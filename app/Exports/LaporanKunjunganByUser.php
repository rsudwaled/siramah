<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\User;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;

class LaporanKunjunganByUser implements FromView
{
    public function view():View
    {
        $user_pendaftaran = request()->input('user_pendaftaran') ;
        $from   = request()->input('start') ;
        $to     = request()->input('end') ;
        // Pastikan $from dan $to dalam format datetime yang benar menggunakan Carbon
        $from   = Carbon::parse($from)->startOfDay();  // Awal hari
        $to     = Carbon::parse($to)->endOfDay();
        $admin  = User::where('id', $user_pendaftaran)->first();
        $laporan= Kunjungan::with(['status','pasien'])
                    ->where('pic', $admin->id_simrs)
                    ->whereBetween('tgl_masuk', [$from, $to])
                    ->get();
        return view('export.laporan.kunjungan_byuser', compact('laporan','admin'));
    }
}
