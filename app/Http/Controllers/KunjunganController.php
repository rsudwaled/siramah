<?php

namespace App\Http\Controllers;

use App\Models\AlasanMasuk;
use App\Models\AlasanPulang;
use App\Models\Kunjungan;
use App\Models\StatusKunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->search)) {
            $kunjungans = Kunjungan::with(['pasien', 'unit', 'penjamin'])
                ->orderByDesc('tgl_masuk')
                ->paginate();
        } else {
            $kunjungans = Kunjungan::with(['pasien', 'unit', 'penjamin'])
                ->where('no_rm',  $request->search)
                ->orderByDesc('tgl_masuk')
                ->paginate();
        }
        $status_kunjungan = StatusKunjungan::pluck('status_kunjungan', 'id');
        $alasan_masuk = AlasanMasuk::pluck('alasan_masuk', 'id');
        $alasan_pulang = AlasanPulang::pluck('alasan_pulang', 'kode');
        return view('simrs.kunjungan_index', [
            'request' => $request,
            'kunjungans' => $kunjungans,
            'status_kunjungan' => $status_kunjungan,
            'alasan_masuk' => $alasan_masuk,
            'alasan_pulang' => $alasan_pulang,
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
}
