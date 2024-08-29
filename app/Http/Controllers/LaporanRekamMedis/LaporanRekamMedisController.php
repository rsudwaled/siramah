<?php

namespace App\Http\Controllers\LaporanRekamMedis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VclaimController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Exports\LaporanFKTP;
use App\Models\Unit;
use Carbon\Carbon;

class LaporanRekamMedisController extends Controller
{
    public function laporanRL51(Request $request)
    {
        $startdate = $request->startdate ?? null;
        $enddate = $request->enddate ?? null;

        $kunjunganPerBulan = null;
        $jumlahPasienBaru = 0;
        $jumlahPasienLama = 0;
        $kunjunganPerBulan = [];
        if ($startdate && $enddate) {
            // Mengonversi startdate menjadi objek Carbon
            $startDateObject = Carbon::parse($startdate);

            $currentMonth = $startDateObject->format('m');
            $currentYear = $startDateObject->format('Y');

            // Menggunakan Carbon untuk mendapatkan bulan dan tahun sebelumnya
            $previousMonthObject = $startDateObject->copy()->subMonth();
            $previousMonth = $previousMonthObject->format('m');
            $previousYear = $previousMonthObject->format('Y');

            // Subquery untuk kunjungan bulan ini
            $currentMonthQuery = DB::connection('mysql2')->table('ts_kunjungan')
                ->select('no_rm', DB::raw('COUNT(*) as jumlah_kunjungan'))
                ->whereYear('tgl_masuk', $currentYear)
                ->whereMonth('tgl_masuk', $currentMonth)
                ->groupBy('no_rm');

            // Subquery untuk kunjungan bulan sebelumnya
            $previousMonthQuery = DB::connection('mysql2')->table('ts_kunjungan')
                ->select('no_rm', DB::raw('COUNT(*) as jumlah_kunjungan'))
                ->whereYear('tgl_masuk', $previousYear)
                ->whereMonth('tgl_masuk', $previousMonth)
                ->groupBy('no_rm');

            // Main query untuk mendapatkan data pasien dan status
            $kunjunganPerBulan = DB::connection('mysql2')->table('mt_pasien')
                ->leftJoinSub($currentMonthQuery, 'current_month_kunjungan', function ($join) {
                    $join->on('mt_pasien.no_rm', '=', 'current_month_kunjungan.no_rm');
                })
                ->leftJoinSub($previousMonthQuery, 'previous_month_kunjungan', function ($join) {
                    $join->on('mt_pasien.no_rm', '=', 'previous_month_kunjungan.no_rm');
                })
                ->select(
                    'mt_pasien.nama_px',
                    'mt_pasien.no_rm',
                    DB::raw('COALESCE(current_month_kunjungan.jumlah_kunjungan, 0) as jumlah_kunjungan'),
                    DB::raw('CASE
                        WHEN COALESCE(previous_month_kunjungan.jumlah_kunjungan, 0) > 0 THEN "Lama"
                        WHEN MONTH(mt_pasien.tgl_entry) = MONTH(CURDATE()) AND YEAR(mt_pasien.tgl_entry) = YEAR(CURDATE()) AND COALESCE(current_month_kunjungan.jumlah_kunjungan, 0) = 1 THEN "Baru"
                        ELSE "Lama"
                    END as status_pasien')
                )
                ->groupBy('mt_pasien.no_rm', 'mt_pasien.nama_px', 'current_month_kunjungan.jumlah_kunjungan', 'previous_month_kunjungan.jumlah_kunjungan', 'mt_pasien.tgl_entry')
                ->get();

            // Hitung jumlah pasien baru dan lama
            $jumlahPasienBaru = $kunjunganPerBulan->where('status_pasien', 'Baru')->count();
            $jumlahPasienLama = $kunjunganPerBulan->where('status_pasien', 'Lama')->count();

            // Menghitung total kunjungan dari hasil query
            $totalKunjungan = $kunjunganPerBulan->sum('jumlah_kunjungan');
        }
        dd($kunjunganPerBulan, $jumlahPasienBaru, $jumlahPasienLama, $totalKunjungan);

        return view('simrs.rekammedis.laporan-rl.rl_5_1', compact('enddate', 'startdate', 'request', 'kunjunganPerBulan'));
    }
    public function detailLaporanRL51(Request $request)
    {
        $detailKunjungan = DB::table('ts_kunjungan')
            ->where('no_rm', $request->no_rm)
            ->select('kode_kunjungan', 'tgl_masuk', 'counter')
            ->orderBy('tgl_masuk')
            ->get();

        $html = '<ul>';
        foreach ($detailKunjungan as $detail) {
            $html .= '<li>Kode Kunjungan: ' . $detail->kode_kunjungan . ' - Tanggal Masuk: ' . $detail->tgl_masuk . ' - Counter: ' . $detail->counter . '</li>';
        }
        $html .= '</ul>';

        return response()->json($html);
    }

    public function LaporanRL52(Request $request)
    {
        $startdate = $request->startdate ?? null;
        $enddate = $request->enddate ?? null;
        $kunjunganPerBulan = null;
        $totalKunjungan = 0;
        if ($startdate && $enddate) {

            $query = DB::table('ts_kunjungan')
                ->join('pasien', 'ts_kunjungan.no_rm', '=', 'pasien.no_rm')
                ->select(
                    'pasien.nama',
                    'ts_kunjungan.no_rm',
                    DB::raw('COUNT(DISTINCT DATE_FORMAT(ts_kunjungan.tgl_masuk, "%Y-%m")) as jumlah_kunjungan')
                )
                ->groupBy('ts_kunjungan.no_rm', 'pasien.nama');

            // Tambahkan filter tanggal jika ada
            if ($startdate && $enddate) {
                $query->whereBetween('ts_kunjungan.tgl_masuk', [$startdate, $enddate]);
            }

            $kunjunganPerBulan = $query->get();

            // Query untuk menghitung jumlah pasien yang berkunjung
            $jumlahPasienQuery = DB::table('ts_kunjungan')
                ->join('pasien', 'ts_kunjungan.no_rm', '=', 'pasien.no_rm')
                ->select(DB::raw('COUNT(DISTINCT ts_kunjungan.no_rm) as jumlah_pasien'));
            if ($startdate && $enddate) {
                $jumlahPasienQuery->whereBetween('ts_kunjungan.tgl_masuk', [$startdate, $enddate]);
            }

            $jumlahPasien = $jumlahPasienQuery->value('jumlah_pasien');
            // Hitung total kunjungan
            $totalKunjungan = $kunjunganPerBulan->sum('jumlah_kunjungan');
        }

        return view('simrs.rekammedis.laporan-rl.rl_5_2', compact('startdate', 'enddate', 'kunjunganPerBulan', 'totalKunjungan', 'jumlahPasien'));
    }

    public function pasienRujukanFktp(Request $request)
    {
        $startdate = $request->startdate ?? null;
        $enddate = $request->enddate ?? null;

        $units = Unit::whereIn('kelas_unit', ['1'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');

        if ($request->kodeunit == "-") {
            // Mendapatkan kunjungan dengan relasi pasien, memilih satu kunjungan per nomor rujukan
            $kunjungans = Kunjungan::with('pasien')
                ->select('no_rujukan', 'no_rm', 'no_sep', DB::raw('MAX(tgl_masuk) as tgl_masuk'))
                ->whereBetween('tgl_masuk', [$startdate, $enddate])
                ->groupBy('no_rujukan')
                ->get();
            // Untuk mendapatkan data lengkap dari kunjungan berdasarkan nomor rujukan dan tanggal masuk yang maksimal
            $kunjunganIds = Kunjungan::whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('no_rujukan', $kunjungans->pluck('no_rujukan'))
                ->whereIn('no_sep', $kunjungans->pluck('no_sep'))
                ->whereIn('tgl_masuk', $kunjungans->pluck('tgl_masuk'))
                ->whereNotIn('status_kunjungan', ['1', '8'])
                // ->where('kode_unit', $request->kodeunit)
                ->where(function ($query) {
                    $query->where('no_rujukan', 'NOT LIKE', '1018%');
                })
                // ->whereNull('perujuk')
                ->with(['pasien', 'unit'])
                ->get();

            // foreach ($kunjunganIds as $kunjungan) {
            //     $vclaim = new VclaimController();
            //     $request = new Request([
            //        "nomorkartu" => trim($kunjungan->pasien->no_Bpjs ?? ''),
            //         "tanggal"   => now()->format('Y-m-d'),
            //     ]);

            //     $response = $vclaim->peserta_nomorkartu($request);
            //     $code = $response->metadata->code;
            //     $updateKunjungan = Kunjungan::where('no_rujukan', $kunjungan->no_rujukan)->get();

            //     foreach ($updateKunjungan as $perujuk) {
            //         $perujuk->perujuk = $response->response->peserta->provUmum->kdProvider . ' | ' . $response->response->peserta->provUmum->nmProvider;
            //         $perujuk->save();
            //     }
            // }

        } else {
            // Mendapatkan kunjungan dengan relasi pasien, memilih satu kunjungan per nomor rujukan
            $kunjungans = Kunjungan::with('pasien')
                ->select('no_rujukan', 'no_rm', 'no_sep', DB::raw('MAX(tgl_masuk) as tgl_masuk'))
                ->whereBetween('tgl_masuk', [$startdate, $enddate])
                ->where('kode_unit', $request->kodeunit)
                ->groupBy('no_rujukan')
                ->get();
            // Untuk mendapatkan data lengkap dari kunjungan berdasarkan nomor rujukan dan tanggal masuk yang maksimal
            $kunjunganIds = Kunjungan::whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('no_rujukan', $kunjungans->pluck('no_rujukan'))
                ->whereIn('no_sep', $kunjungans->pluck('no_sep'))
                ->whereIn('tgl_masuk', $kunjungans->pluck('tgl_masuk'))
                ->whereNotIn('status_kunjungan', ['1', '8'])
                ->where('kode_unit', $request->kodeunit)
                ->where(function ($query) {
                    $query->where('no_rujukan', 'NOT LIKE', '1018%');
                })
                ->with(['pasien', 'unit'])
                ->get();

            // foreach ($kunjunganIds as $kunjungan) {
            //     $vclaim = new VclaimController();
            //     $request = new Request([
            //         "nomorrujukan" => $kunjungan->no_rujukan,
            //     ]);

            //     $response = $vclaim->rujukan_nomor($request);
            //     $code = $response->metadata->code;

            //     if ($code == '200') {
            //         $this->updatePerujuk($kunjungan->no_rujukan, $response);
            //     } else {
            //         $response = $vclaim->rujukan_rs_nomor($request);
            //         $code = $response->metadata->code;

            //         if ($code == '200') {
            //             $this->updatePerujuk($kunjungan->no_rujukan, $response);
            //         }
            //     }
            // }
        }
        return view('simrs.rekammedis.laporan-rujukan.laporan_rujukan_fktp', compact('enddate', 'startdate', 'request', 'kunjungans', 'units', 'kunjunganIds'));
    }
    private function updatePerujuk($no_rujukan, $response)
    {
        $updateKunjungan = Kunjungan::where('no_rujukan', $no_rujukan)->get();

        foreach ($updateKunjungan as $perujuk) {
            $perujuk->perujuk = $response->response->rujukan->provPerujuk->kode . ' | ' . $response->response->rujukan->provPerujuk->nama;
            $perujuk->save();
        }
    }

    public function getFktp(Request $request)
    {
        $vclaim = new VclaimController();
        $request = new Request([
            "nomorrujukan"  => $request->norujukan,
        ]);
        $response    = $vclaim->rujukan_nomor($request);
        $error = $response->metadata->message;
        $code = $response->metadata->code;
        if ($code == '200') {
            $updateKunjungan = Kunjungan::where('no_rujukan', $request['nomorrujukan'])->get();
            foreach ($updateKunjungan as $perujuk) {
                $perujuk->perujuk = $response->response->rujukan->provPerujuk->kode . ' | ' . $response->response->rujukan->provPerujuk->nama;
                $perujuk->save();
            }
        } else {
            $response    = $vclaim->rujukan_rs_nomor($request);
            $error = $response->metadata->message;
            $code = $response->metadata->code;
            if ($code == '200') {
                $updateKunjungan = Kunjungan::where('no_rujukan', $request['nomorrujukan'])->get();
                foreach ($updateKunjungan as $perujuk) {
                    $perujuk->perujuk = $response->response->rujukan->provPerujuk->kode . ' | ' . $response->response->rujukan->provPerujuk->nama;
                    $perujuk->save();
                }
            }
        }
        return response()->json([
            'request' => $request->all(),
            'response' => $response,
            'error' => $error,
            'code' => $code,
        ]);
    }

    public function download(Request $request)
    {
        $startdate = $request->startdate ?? null;
        $enddate = $request->enddate ?? null;
        $namaFile = 'Data-fktp-'.$startdate.'_'.$enddate.'.xlsx';
        return Excel::download(new LaporanFKTP, $namaFile);
    }
}
