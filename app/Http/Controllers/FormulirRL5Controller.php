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
        $dataperunit = $request->dataperunit;
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
        if ($dataperunit == null) {
            $request['unit'] = "";
            $kode_unit = null;
        }
        if ($dataperunit == 'on' && $kode_unit == null || $dataperunit == 'off' && $kode_unit != null) {
            Alert::warning('PERINGATAN!', 'pastikan anda sudah mencentang laporan unit dan pilih kode unit apabila ingin menampilkan data perunit.');
        }
        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `sp_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }

        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3', compact('laporanFM', 'from', 'to', 'request', 'jml', 'dataperunit', 'kode_unit', 'unit', 'th'));
    }

    public function FormulirRL5_3Perunit(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $sel = $request->unit;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;
        $laporanFM = null;

        if ($from && $to && $jml && $kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3unit', compact('laporanFM', 'from', 'to', 'request', 'jml', 'unit', 'sel'));
    }

    public function FormulirRL5_4(Request $request)
    {
        // dd($request->all());
        $from = $request->dari;
        $dataperunit = $request->dataperunit;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = null;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th1 = $p1->year;
        $th2 = $p2->year;
        if ($th1 == $th2) {
            $th = $th2;
        } else {
            $th = $th1 . '-' . $th2;
        }
        if ($dataperunit == 'on') {
            $kode_unit = $request->unit;
        }

        if ($dataperunit == 'on' && $kode_unit == null) {
            Alert::warning('PERINGATAN!', 'pastikan anda sudah mencentang laporan unit dan pilih kode unit apabila ingin menampilkan data perunit.');
        }

        $laporanFM = null;
        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4', compact('laporanFM', 'from', 'to', 'request', 'jml', 'unit', 'kode_unit', 'dataperunit', 'th'));
    }

    public function FormulirRL5_4Perunit(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;
        $laporanFM = null;
        $laporanFMU = null;

        if ($from && $to && $jml && $kode_unit) {
            $laporanFMU = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFMU = collect($laporanFMU);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4unit', compact('laporanFM', 'from', 'to', 'request', 'jml', 'unit', 'kode_unit', 'laporanFMU'));
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
