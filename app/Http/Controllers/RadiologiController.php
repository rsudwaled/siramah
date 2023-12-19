<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RadiologiController extends Controller
{
    public function hasilradiologi(Request $request)
    {
        $kodeunit = '3003';
        $kunjungans = null;
        if ($request->tanggal) {
            $request['tgl'] = Carbon::parse($request->tanggal)->startOfDay();
            $kunjungans = Kunjungan::orderBy('tgl_masuk', 'desc')
                ->whereDate('tgl_masuk', $request->tanggal)
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans', 'layanans.layanan_details',
                    'layanans.layanan_details.tarif_detail',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
        }
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        return view('simrs.radiologi.kunjungan_rad', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
}
