<?php

namespace App\Http\Controllers;

use App\Models\AlasanMasuk;
use App\Models\AlasanPulang;
use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use App\Models\StatusKunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KunjunganController extends APIController
{
    public function index(Request $request)
    {
        if (empty($request->search)) {
            $kunjungans = Kunjungan::with(['pasien', 'unit', 'penjamin_simrs', 'alasan_masuk', 'dokter', 'status'])
                ->orderByDesc('tgl_masuk')
                ->paginate();
        } else {
            $kunjungans = Kunjungan::with(['pasien', 'unit', 'penjamin_simrs', 'alasan_masuk', 'dokter', 'status'])
                ->where('no_rm', 'LIKE', '%' . $request->search . '%')
                ->orderByDesc('tgl_masuk')
                ->paginate();
        }
        return view('simrs.kunjungan_index', [
            'request' => $request,
            'kunjungans' => $kunjungans,
        ]);
    }
    public function show($kodekunjungan)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $kodekunjungan);
        $data['noSEP'] = $kunjungan->no_sep;
        $data['namaPasien'] = $kunjungan->pasien->nama_px;
        $data['kodePoli'] = $kunjungan->unit->KDPOLI;
        $data['kodeDokter'] = $kunjungan->dokter ? (string) $kunjungan->dokter->kode_dokter_jkn : null;
        return $this->sendResponse($data, 200);
    }
    public function edit($kodekunjungan)
    {
        $kunjungan = Kunjungan::with(['pasien'])->firstWhere('kode_kunjungan', $kodekunjungan);
        $kunjungan['namaPasien'] = $kunjungan->pasien->nama_px;
        $kunjungan['tglLahir'] = Carbon::parse($kunjungan->pasien->tgl_lahir)->format('Y-m-d');
        $kunjungan['sex'] = $kunjungan->pasien->jenis_kelamin;
        $kunjungan['nomorkartu'] = $kunjungan->pasien->no_Bpjs;
        $kunjungan['kodePoli'] = $kunjungan->unit->KDPOLI;
        $kunjungan['kodeDokter'] = $kunjungan->dokter ? (string) $kunjungan->dokter->kode_dokter_jkn : null;
        $kunjungan['noSEP'] = $kunjungan->no_sep;
        return response()->json($kunjungan);
    }
    public function kunjungan_tanggal($tanggal)
    {
        $kunjungans = Kunjungan::whereDate('tgl_masuk', $tanggal)->get(['no_rm', 'kode_unit', 'kode_paramedis', 'tgl_masuk']);
        return response()->json($kunjungans);
    }
    public function kunjungan_poliklinik(Request $request)
    {
        // $kunjungans = Kunjungan::whereDate('tgl_masuk', $tanggal)->get(['no_rm', 'kode_unit', 'kode_paramedis', 'tgl_masuk']);
        // return response()->json($kunjungans);
        $units = Unit::where('kelas_unit', 1)->get();
        $kunjungans = null;
        if (isset($request->kodepoli)) {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)->where('kode_unit', $request->kodepoli)->get();
        }
        return view('simrs.rekammedis.kunjungan_poliklinik', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function laporanKunjunganPoliklinik(Request $request)
    {
        $response = null;
        $kunjungans = null;
        if (isset($request->tanggal) && isset($request->kodepoli)) {
            $poli = Unit::where('KDPOLI', $request->kodepoli)->first();
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)
                ->where('kode_unit', $poli->kode_unit)
                ->where('status_kunjungan',  "!=", 8)
                ->with(['dokter', 'unit', 'pasien', 'diagnosapoli', 'pasien.kecamatans', 'penjamin', 'surat_kontrol'])
                ->get();
            $response = DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RAWAT_JALAN_KUNJUNGAN('" . $poli->kode_unit . "','" . $request->tanggal . "')");
        }
        $unit = Unit::where('KDPOLI', "!=", null)->where('KDPOLI', "!=", "")->get();
        $penjaminrs = PenjaminSimrs::get();
        $response = collect($response);
        return view('simrs.poliklinik.poliklinik_laporan_kunjungan', [
            'kunjungans' => $kunjungans,
            'request' => $request,
            'response' => $response,
            'penjaminrs' => $penjaminrs,
            'unit' => $unit,
        ]);
    }
    public function kunjunganRanap(Request $request)
    {
        $kunjungans = Kunjungan::where('kode_unit', $request->unit)
            ->where('status_kunjungan', 1)
            ->with(['pasien', 'unit', 'dokter', 'penjamin_simrs'])
            ->whereHas('pasien')
            ->get(['kode_kunjungan', 'tgl_masuk', 'no_rm', 'kode_unit', 'kode_penjamin', 'kode_paramedis', 'no_sep']);
        return $this->sendResponse($kunjungans, 200);
    }
    public function pasienRanapAktif(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->kodeunit) {
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'budget', 'tagihan', 'surat_kontrol'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'budget', 'tagihan', 'surat_kontrol'])
                    ->get();
            }
        }
        return view('simrs.ranap.ranap_aktif', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function pasienRanap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->tanggal) {
            $tanggalawal = Carbon::parse(explode('-', $request->tanggal)[0]);
            $tanggalakhir = Carbon::parse(explode('-', $request->tanggal)[1])->endOfDay();
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->whereBetween('tgl_masuk', [$tanggalawal, $tanggalakhir])
                    // ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'budget', 'status',  'tagihan', 'surat_kontrol'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->whereBetween('tgl_masuk', [$tanggalawal, $tanggalakhir])
                    // ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'budget', 'status',  'tagihan', 'surat_kontrol'])
                    ->get();
            }
        }
        return view('simrs.ranap.ranap_pasien', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function pasienRanapPasien(Request $request)
    {

        $kunjungan = Kunjungan::with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'budget', 'status',  'tagihan', 'surat_kontrol'])
            ->find($request->kode);

        $inacbg = new InacbgController();
        $request['norm'] = $kunjungan->no_rm;
        $request['counter'] = $kunjungan->counter;
        $budget = $inacbg->rincian_biaya_pasien($request)->response;
        // dd($budget);
        // rincian_biaya_pasien

        $vclaim = new VclaimController();
        $res = $vclaim->sep_insert($request);
        if ($res->metadata->code == 200) {
            # code...
        } else {
            # code...
        }
        return view('simrs.ranap.ranap_detail_pasien', compact([
            'request',
            'kunjungan',
            'budget',
        ]));
    }
    public function pasienRanapPulang(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->tanggal) {
            $tanggalawal = Carbon::parse(explode('-', $request->tanggal)[0]);
            $tanggalakhir = Carbon::parse(explode('-', $request->tanggal)[1])->endOfDay();
            $kunjungans = collect(DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_PULANG('','" . $tanggalawal . "','" . $tanggalakhir . "','" . $request->kodeunit . "')"));
        }
        return view('simrs.ranap.ranap_pasien_pulang', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function kunjunganpasienranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        $kunjungan_aktif = null;
        if ($request->tanggal) {
            $tanggalawal = Carbon::parse(explode('-', $request->tanggal)[0]);
            $tanggalakhir = Carbon::parse(explode('-', $request->tanggal)[1])->endOfDay();
            $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                ->whereBetween('tgl_keluar', [$tanggalawal, $tanggalakhir])
                ->has('pasien')
                ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status', 'alasan_pulang'])
                ->get();
            $kunjungan_aktif = Kunjungan::where('kode_unit', $request->kodeunit)
                ->where('status_kunjungan', 1)
                ->has('pasien')
                ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status', 'alasan_pulang'])
                ->get();
        }
        return view('simrs.ranap.kunjungan_pasien_ranap', compact([
            'request',
            'units',
            'kunjungans',
            'kunjungan_aktif',
        ]));
    }
    public function bukakunjungan(Request $request)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $kunjungan->update([
            'tgl_keluar' => null,
            'catatan' => $kunjungan->tgl_keluar,
            'status_kunjungan' => 1,
            'cfar' => 1,
            'cetak_label' => 1,
        ]);
        Alert::success('Succes', 'Kunjungan berhasil dibuka kembali. Lihat di pasien aktif');
        return redirect()->back();
    }
    public function tutupkunjungan(Request $request)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $kunjungan->update([
            'tgl_keluar' => $kunjungan->catatan,
            'status_kunjungan' => 2,
            'cfar' => 1,
            'cetak_label' => 1,
        ]);
        Alert::success('Succes', 'Kunjungan berhasil ditutup kembali. Lihat di pasien pulang.');
        return redirect()->back();
    }
    public function pemulangan_sep_pasien(Request $request)
    {
        dd($request->all());
        $api = new VclaimController();
        $request['user'] = Auth::user()->name;
        $response = $api->sep_update_pulang($request);
        if ($response->metadata->code == 200) {
            Alert::success('Success', 'Update SEP Tanggal Pulang Berhasil.');
        } else {
            Alert::error('Gagal', $response->metadata->message);
        }
        return redirect()->back();
    }
    public function data_kunjungan_rajal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "tanggal" => "required",
            "unit" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $data = Kunjungan::whereDate('tgl_masuk', $request->tanggal)
            ->where('kode_unit', $request->unit)
            ->with('pasien','unit','dokter')
            ->get()
            ->map(function ($kunjungan) {
                return [
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'counter' => $kunjungan->counter,
                    'tgl_masuk' => $kunjungan->tgl_masuk,
                    'tgl_keluar' => $kunjungan->tgl_keluar,

                    'no_rm' => $kunjungan->no_rm,
                    'nama_px' => $kunjungan->pasien->nama_px,

                    'kode_unit' => $kunjungan->kode_unit,
                    'nama_unit' => $kunjungan->unit->nama_unit,

                    'kode_paramedis' => $kunjungan->kode_paramedis,
                    'nama_paramedis' => $kunjungan->dokter->nama_paramedis,
                ];
            });

        return $this->sendResponse($data, 200);
    }
}
