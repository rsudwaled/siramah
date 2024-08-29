<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Kunjungan;

class LaporanFKTP implements FromView
{
    public function view():View
    {
        $startdate   = request()->input('startdate') ;
        $enddate     = request()->input('enddate') ;
        $kunjungans = Kunjungan::with('pasien')
            ->select('no_rujukan', 'no_rm', 'no_sep', DB::raw('MAX(tgl_masuk) as tgl_masuk'))
            ->whereBetween('tgl_masuk', [$startdate, $enddate])
            ->groupBy('no_rujukan')
            ->get();
        // Untuk mendapatkan data lengkap dari kunjungan berdasarkan nomor rujukan dan tanggal masuk yang maksimal
        $data = Kunjungan::whereBetween('tgl_masuk', [$startdate, $enddate])
            ->whereIn('no_rujukan', $kunjungans->pluck('no_rujukan'))
            ->whereIn('no_sep', $kunjungans->pluck('no_sep'))
            ->whereIn('tgl_masuk', $kunjungans->pluck('tgl_masuk'))
            ->whereNotIn('status_kunjungan', ['1', '8'])
            ->where(function ($query) {
                $query->where('no_rujukan', 'NOT LIKE', '1018%');
            })
            ->with(['pasien', 'unit'])
            ->get();

        return view('export.laporan.fktp_pasien', compact('data'));
    }
}
