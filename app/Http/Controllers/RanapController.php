<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RanapController extends Controller
{
    public function kunjunganranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->tanggal) {
            $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->whereRelation('unit', 'kelas_unit', '=', 2)
                    ->with(['pasien', 'budget', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->kodeunit)
                    ->with(['pasien', 'budget', 'unit', 'status'])
                    ->get();
            }
        }
        return view('simrs.ranap.kunjungan_ranap', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function pasienranapprofile(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'budget',
            'alasan_pulang',
            'surat_kontrol',
            // 'layanans', 'layanans.layanan_details',
            // 'layanans.layanan_details.tarif_detail',
            // 'layanans.layanan_details.tarif_detail.tarif',
            // 'layanans.layanan_details.barang',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $kunjungans = null;
        $kunjungans = Kunjungan::where('no_rm', $kunjungan->no_rm)
            ->with([
                'unit', 'assesmen_dokter',
                'layanans', 'layanans.layanan_details',
                'layanans.layanan_details.tarif_detail',
                'layanans.layanan_details.tarif_detail.tarif',
                'layanans.layanan_details.barang',
                'dokter', 'assesmen_perawat'
            ])
            ->orderBy('tgl_masuk', 'desc')
            ->limit(10)->get();
        $biaya_rs = 0;
        foreach ($pasien->kunjungans->where('counter', $kunjungan->counter) as $kjg) {
            $biaya_rs = $biaya_rs + $kjg->layanans->where('status_retur', 'OPN')->sum('total_layanan');
        }
        return view('simrs.ranap.erm_ranap', compact([
            'kunjungan',
            'pasien',
            'kunjungans',
            'biaya_rs',
        ]));
    }
    public function kunjunganranapaktif(Request $request)
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
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            }
        }
        return view('simrs.ranap.kunjungan_ranap_aktif', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
}
