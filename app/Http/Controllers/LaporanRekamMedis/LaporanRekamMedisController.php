<?php

namespace App\Http\Controllers\LaporanRekamMedis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VclaimController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Ruangan;
use App\Exports\LaporanFKTP;
use App\Models\Unit;
use Carbon\Carbon;

class LaporanRekamMedisController extends Controller
{
    public function laporanRL51(Request $request)
    {
        $startdate  = $request->startdate ?? null;
        $enddate    = $request->enddate ?? null;

        $kunjungans     = [];
        $kunjungans1    = [];
        $kunjungans2    = [];
        $baru           = 0;
        $lama           = 0;
        if ($startdate && $enddate) {


            $kunjungans2 = Kunjungan::whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('status_kunjungan', [2, 3])
                ->whereNotIn('counter', [1])
                ->groupBy('no_rm')
                ->get();

            $kunjungans1= Kunjungan::with(['pasien'])
                ->whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('status_kunjungan', [2,3])
                ->where('counter', 1)
                ->where('counter','<=', 1)
                ->groupBy('no_rm')
                ->get();

            $baru   = $kunjungans1->count();
            $lama   = $kunjungans2->count();
        }
        return view('simrs.rekammedis.laporan-rl.rl_5_1', compact('enddate','startdate','request','kunjungans','kunjungans1','kunjungans2','baru','lama'));
    }
    public function detailLaporanRL51(Request $request)
    {
        $startdate      = $request->startdate ?? null;
        $enddate        = $request->enddate ?? null;
        $detailKunjungan = Kunjungan::with(['pasien','unit'])
            ->whereBetween('tgl_masuk', [$startdate, $enddate])
            ->where('no_rm', $request->no_rm)
            ->select('kode_kunjungan', 'tgl_masuk', 'counter','prefix_kunjungan','no_rm')
            ->orderBy('tgl_masuk')
            ->get();

        // Membuat header tabel
        $html = '<table border="1" class="table table-bordered table-hover table-sm nowrap">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Counter</th>';
        $html .= '<th>No RM</th>';
        $html .= '<th>Kunjungan</th>';
        $html .= '<th>Tanggal Masuk</th>';
        $html .= '<th>Unit</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Menambahkan baris tabel untuk setiap detail kunjungan
        foreach ($detailKunjungan as $detail) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($detail->counter) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->no_rm) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->kode_kunjungan) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->tgl_masuk) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->prefix_kunjungan) . '</td>';
            $html .= '</tr>';
        }

        // Menutup elemen tabel
        $html .= '</tbody>';
        $html .= '</table>';
        return response()->json($html);
    }

    public function LaporanRL52(Request $request)
    {
        $startdate      = $request->startdate ?? null;
        $enddate        = $request->enddate ?? null;
        $kunjungan      = [];
        $pengunjung      = [];
        $jumlahKunjungan     = 0;
        $jumlahPengunjung    = 0;
        $results = [];

        if ($startdate && $enddate)
        {
            $query = Kunjungan::with(['pasien','unit'])
                ->whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('kode_unit',[
                    '1004','1005','1006','1007',
                    '1008','1009','1010','1011',
                    '1012','1013','1014','1015',
                    '1016','1017','1018','1019',
                    '1022','1023','1024','1025',
                    '1026','1027','1028','1029',
                    '1030','1032','1033','1036',
                ])
            ->whereIn('status_kunjungan', [2,3]);
            $kunjungan = $query->get();
            $pengunjung = $query->groupBy('no_rm')->get();
            $jumlahKunjungan = $kunjungan->count();
            $jumlahPengunjung = $pengunjung->count();

            $pengunjung = Kunjungan::with(['pasien','unit'])
                ->whereBetween('tgl_masuk', [$startdate, $enddate])
                ->whereIn('kode_unit',[
                    '1004','1005','1006','1007',
                    '1008','1009','1010','1011',
                    '1012','1013','1014','1015',
                    '1016','1017','1018','1019',
                    '1022','1023','1024','1025',
                    '1026','1027','1028','1029',
                    '1030','1032','1033','1036',
                ])
                ->whereIn('status_kunjungan', [2,3])->get();


            // Kelompokkan data berdasarkan prefix_kunjungan
                foreach ($pengunjung as $people) {
                    $prefix = $people->prefix_kunjungan;

                    // Jika prefix belum ada dalam hasil, inisialisasi
                    if (!isset($results[$prefix])) {
                        $results[$prefix] = [
                            'laki_laki' => 0,
                            'perempuan' => 0,
                            'total' => 0,
                        ];
                    }

                    // Hitung jumlah laki-laki dan perempuan
                    if ($people->pasien->jenis_kelamin == 'L') {
                        $results[$prefix]['laki_laki']++;
                    } elseif ($people->pasien->jenis_kelamin == 'P') {
                        $results[$prefix]['perempuan']++;
                    }
                    // Update total
                    $results[$prefix]['total']++;
            }
        }
        return view('simrs.rekammedis.laporan-rl.rl_5_2', compact('startdate','enddate','request','results','pengunjung','jumlahKunjungan','jumlahPengunjung'));
    }


    public function detailLaporanRL52(Request $request)
    {
        $startdate      = $request->startdate ?? null;
        $enddate        = $request->enddate ?? null;

        $detailKunjungan = Kunjungan::with(['pasien','unit'])
            ->whereBetween('tgl_masuk', [$startdate, $enddate])
            ->where('no_rm', $request->no_rm)
            ->select('kode_kunjungan', 'tgl_masuk', 'counter','prefix_kunjungan','no_rm')
            ->orderBy('tgl_masuk')
            ->get();

        // Membuat header tabel
        $html = '<table border="1" class="table table-bordered table-hover table-sm nowrap">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Counter</th>';
        $html .= '<th>No RM</th>';
        $html .= '<th>Kunjungan</th>';
        $html .= '<th>Tanggal Masuk</th>';
        $html .= '<th>Unit</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Menambahkan baris tabel untuk setiap detail kunjungan
        foreach ($detailKunjungan as $detail) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($detail->counter) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->no_rm) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->kode_kunjungan) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->tgl_masuk) . '</td>';
            $html .= '<td>' . htmlspecialchars($detail->prefix_kunjungan) . '</td>';
            $html .= '</tr>';
        }

        // Menutup elemen tabel
        $html .= '</tbody>';
        $html .= '</table>';
        return response()->json($html);
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

    public function laporanRanapPeruangan(Request $request)
    {
        $startdate = $request->startdate ?? null;
        $enddate = $request->enddate ?? null;

        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');

        $ruangan = Ruangan::select('kode_unit','id_kelas',
            DB::raw('SUM(CASE WHEN status_incharge = 0 THEN 1 ELSE 0 END) as count_status_0'),
            DB::raw('SUM(CASE WHEN status_incharge = 1 THEN 1 ELSE 0 END) as count_status_1'),
            DB::raw('SUM(CASE WHEN status_incharge = 2 THEN 1 ELSE 0 END) as count_status_2')
        )
        ->with('unit') // Memuat relasi unit jika diperlukan
        ->groupBy('kode_unit', 'id_kelas') // Mengelompokkan berdasarkan kode_unit dan unit_id
        ->get();

        $query = Kunjungan::query()
            ->join('mt_ruangan', 'ts_kunjungan.id_ruangan', '=', 'mt_ruangan.id_ruangan')
            ->where('mt_ruangan.status_incharge', 1) // Menambahkan kondisi status_incharge
            ->select('ts_kunjungan.*', 'mt_ruangan.*'); // Pilih kolom yang ingin ditampilkan

        // Tambahkan filter berdasarkan parameter jika ada
        if ($startdate && $enddate && $request->kodeunit) {
            $query->whereBetween('ts_kunjungan.tgl_masuk', [$startdate, $enddate])
                ->whereNotNull('ts_kunjungan.id_ruangan')
                ->where('ts_kunjungan.kode_unit', $request->kodeunit);
        } else {
            // Jika tidak ada filter, ambil data untuk tanggal hari ini
            $query->whereDate('ts_kunjungan.tgl_masuk', now()->format('Y-m-d'))
                ->whereNotNull('ts_kunjungan.id_ruangan');
        }

        $kunjungans = $query->get();
        $jumlah     = $query->count();
        return view('simrs.rekammedis.pasien-ranap-peruangan.pasien_peruangan', compact('ruangan','enddate', 'startdate', 'request', 'kunjungans', 'units','jumlah'));
    }

}
