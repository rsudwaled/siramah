<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class FormulirRL5Controller extends Controller
{
    public function FormulirRL5_1(Request $request)
    {
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_1');
    }
    public function FormulirRL5_2(Request $request)
    {
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_2');
    }

    public function FormulirRL5_3(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3', compact('from', 'to', 'request','unit'));
    }

    public function FormulirRL5_3P(Request $request)
    {
        // dd($request->all());
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th1 = $p1->year;
        $th2 = $p2->year;
        if ($th1 == $th2) {
            $th = $th2;
        } else {
            $th = $th1 . '-' . $th2;
        }
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;
        
        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
            return view('simrs.formulir.f_r_l_5.formulir_rl_5_3unit', compact('laporanFM', 'from', 'to', 'request', 'jml', 'kode_unit', 'unit', 'th'));
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `sp_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3data', compact('laporanFM', 'from', 'to', 'request', 'jml','th'));
    }

    public function FormulirRL5_4(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4',compact('from','to','request','unit'));
    }

    public function FormulirRL5_4P(Request $request)
    {
        // dd($request->all());
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th1 = $p1->year;
        $th2 = $p2->year;
        if ($th1 == $th2) {
            $th = $th2;
        } else {
            $th = $th1 . '-' . $th2;
        }

        $laporanFM = null;
        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
            return view('simrs.formulir.f_r_l_5.formulir_rl_5_4_data', compact('laporanFM', 'from', 'to', 'request', 'jml', 'unit', 'kode_unit',  'th'));
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4unit_old', compact('laporanFM', 'from', 'to', 'request', 'jml','th'));
    }

    public function FormulirRL5_5(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;

        $ksm = \DB::connection('mysql2')->select("CALL `sp_MASTER_KELOMPOK_STAF_MEDIS`('')");
        $dataKsm = $request->ksm;
        $laporanFM = null;

        if ($from && $to && $dataKsm) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `sp_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_smf`('$from','$to','$dataKsm')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_5', compact('laporanFM', 'from', 'to', 'request', 'ksm', 'dataKsm'));
    }
}
