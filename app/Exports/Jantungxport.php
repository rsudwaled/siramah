<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class Jantungxport implements FromView
{
    public function view():View
    {
        $startdate = request()->input('startdate') ;
        $enddate   = request()->input('enddate') ;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_JANTUNG_kasus_baru('$startdate','$enddate')");
        return view('export.kasus_baru.kasus_baru_jantung', compact('data'));
    }
}