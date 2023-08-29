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
    public function FormulirRL3_3(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $dataGM = null;
        if ($from && $to) {
            // KEGIATAN KESEHATAN GIGI DAN MULUT
            $dataGM = \DB::connection('mysql2')->select("call RL_3_3('$from','$to')");
            $dataGM = collect($dataGM);
        }
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_3', compact('dataGM'));
    }
    public function FormulirRL3_4()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_4');
    }
    public function FormulirRL3_5()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_5');
    }
    public function FormulirRL3_6(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $dataBDH = null;
        if ($from && $to) {
            // KEGIATAN PEMBEDAHAN
            $dataBDH = \DB::connection('mysql2')->select("call RL_3_6('$from','$to','')");
            $dataBDH = collect($dataBDH);
        }
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_6',compact('dataBDH'));
    }
    public function FormulirRL3_7()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_7');
    }
    public function FormulirRL3_8()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_8');
    }
    public function FormulirRL3_9()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_9');
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
        // dd($F310);
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_10',compact('F310'));
    }
    public function FormulirRL3_11(Request $request)
    {
        // call RL_3_10(tgl_awal,tgl_akhir)
        // call RL_3_15(tgl_awal,tgl_akhir)
        // call RL_3_3(tgl_awal,tgl_akhir)
        // call RL_3_6(tgl_awal,tgl_akhir)
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_11');
    }
    public function FormulirRL3_12()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_12');
    }
    public function FormulirRL3_13()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_13');
    }
    public function FormulirRL3_14()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_14');
    }
    public function FormulirRL3_15()
    {
        return view('simrs.formulir.f_r_l_3.formulir_rl_3_15');
    }
}
