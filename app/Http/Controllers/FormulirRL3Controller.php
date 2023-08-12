<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormulirRL3Controller extends Controller
{
    public function FormulirRL3_1()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_1');
    }
    public function FormulirRL3_2(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $kunjunganRD = null;
        if ($from && $to) {
            // CALL LAPORAN_SENSUS_KUNJUNGAN_BULANAN_IGD_REKAP('2023-06-01','2023-06-30','1002')
            $kunjunganRD = \DB::connection('mysql2')->select("CALL LAPORAN_SENSUS_KUNJUNGAN_BULANAN_IGD_REKAP('$from','$to','1002')");
            $kunjunganRD = collect($kunjunganRD);
        }
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_2', compact('kunjunganRD'));
    }
    public function FormulirRL3_3()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_3');
    }
    public function FormulirRL3_6()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_6');
    }
    public function FormulirRL3_7()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_7');
    }
    public function FormulirRL3_8()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_8');
    }
    public function FormulirRL3_10(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $F310 = null;
        if ($from && $to) {
            $F310 = \DB::connection('mysql2')->select("CALL RL_3_10('$from','$to')");
            $F310 = collect($F310);
        }
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_10',compact('F310'));
    }
    public function FormulirRL3_11()
    {
        // call RL_3_10(tgl_awal,tgl_akhir)
        // call RL_3_15(tgl_awal,tgl_akhir)
        // call RL_3_3(tgl_awal,tgl_akhir)
        // call RL_3_6(tgl_awal,tgl_akhir)
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_11');
    }
}
