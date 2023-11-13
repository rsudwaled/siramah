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
            $request['tgl_awal'] = Carbon::parse(explode('-', $request->tanggal)[0])->startOfDay();
            $request['tgl_akhir'] = Carbon::parse(explode('-', $request->tanggal)[1])->endOfDay();
            $status = $request->status;
            if ($request->jenistanggal == 'tgl_keluar') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->whereBetween('tgl_keluar', [$request->tgl_awal, $request->tgl_akhir])
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->whereBetween('tgl_masuk', [$request->tgl_awal, $request->tgl_akhir])
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->where(function ($query) use ($status) {
                        switch ($status) {
                            case '1':
                                $query->where('status_kunjungan', '=', 1);
                                break;
                            case '2':
                                $query->where('status_kunjungan', '!=', 1);
                                break;
                            default:
                                # code...
                                break;
                        }
                    })
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
            'budget',
            'alasan_masuk',
            'unit',
            'dokter',
            'penjamin_simrs',
            'status',
            'surat_kontrol',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $norm = $kunjungan->no_rm;
        $pasien = Cache::remember('pasien' . $kunjungan->no_rm, 30 * 60, function () use ($norm) {
            return Pasien::with([
                'kunjungans',
                'kunjungans.unit', 'kunjungans.assesmen_dokter',
                'kunjungans.layanans', 'kunjungans.layanans.layanan_details',
                'kunjungans.layanans.layanan_details.tarif_detail',
                'kunjungans.layanans.layanan_details.tarif_detail.tarif',
                'kunjungans.layanans.layanan_details.barang',
                'kunjungans.dokter', 'kunjungans.assesmen_perawat'
            ])->firstWhere('no_rm', $norm);
        });
        $biaya_rs = 0;
        foreach ($pasien->kunjungans->where('counter', $kunjungan->counter) as $kjg) {
            $biaya_rs = $biaya_rs + $kjg->layanans->where('status_retur', 'OPN')->sum('total_layanan');
        }
        return view('simrs.ranap.erm_ranap', compact([
            'kunjungan',
            'pasien',
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
