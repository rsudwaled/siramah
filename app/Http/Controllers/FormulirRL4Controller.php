<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FormulirRL4Controller extends Controller
{
    public function FormulirRL4A(Request $request)
    {

        $from = $request->dari;
        $to = $request->sampai;
        $laporanFM = null;

        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RANAP`('$from','$to')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_4.formulir_rl_4A',compact('laporanFM','from','to','request','pasienlm'));
    }

    public function FormulirRL4AK(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $laporanFM = null;

        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RANAP_KECELAKAAN`('$from','$to')");
            $laporanFM = collect($laporanFM);

        }
        return view('simrs.formulir.f_r_l_4.formulir_rl_4AK',compact('laporanFM','from','to','request'));
    }

    public function FormulirRL4B(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $laporanFM = null;
        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RAJAL`('$from','$to')");
            $laporanFM = collect($laporanFM);
        }

        return view('simrs.formulir.f_r_l_4.formulir_rl_4B',compact('laporanFM','from','to','request'));
    }
    public function FormulirRL4BK(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $laporanFM = null;
        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RAJAL_KECELAKAAN`('$from','$to')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_4.formulir_rl_4BK',compact('laporanFM','from','to','request'));
    }

}
