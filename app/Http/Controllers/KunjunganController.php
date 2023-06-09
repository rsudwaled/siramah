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
use Illuminate\Support\Facades\DB;

class KunjunganController extends Controller
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
        return $this->sendResponse('OK', $data, 200);
    }
    public function edit($kodekunjungan)
    {
        $kunjungan = Kunjungan::with(['pasien'])->firstWhere('kode_kunjungan', $kodekunjungan);
        $kunjungan['namaPasien'] = $kunjungan->pasien->nama_px;
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
                ->where('status_kunjungan',  "<=", 2)
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
}
