<?php

namespace App\Http\Controllers\Gizi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\ERMHasilAssesmentKeperawatanRajal;

class GiziController extends Controller
{
    public function index(Request $request)
    {
        $unit = Unit::all();
        $pasien = null;
        if (!empty($request->unit)) {
            $pasien = \DB::connection('mysql2')->select("CALL `SP_PANGGIL_PASIEN_RANAP_CURRENT`('$request->unit','','')");
        }
        return view('simrs.gizi.index', compact('request','unit','pasien'));
    }

    public function addAssesment(Request $request)
    {
        $Kunjungan = Kunjungan::with('pasien')->where('kode_kunjungan', $request->kunjungan)->where('counter', $request->counter)->first();
        return response()->json(route('simrs.gizi.create.assesment', ['kunjungan' => $Kunjungan->kode_kunjungan,'counter'=>$Kunjungan->counter]));
    }

    public function createAssesment($kunjungan, $counter)
    {
        $kunjungan = Kunjungan::with('pasien')->where('kode_kunjungan', $kunjungan)->where('counter', $counter)->first();
        $erm = ERMHasilAssesmentKeperawatanRajal::where('kode_kunjungan', $kunjungan)->where('kode_unit',3013)->first();
        return view('simrs.gizi.assesment', compact('kunjungan','erm'));
    }
    public function storeAssesment(Request $request)
    {
        dd($request->all());
        $cek_erm = ERMHasilAssesmentKeperawatanRajal::where('kode_kunjungan', $request->kunjungan)->where('kode_unit',3013)->first();
        if (empty($cek_erm)) {
            ERMHasilAssesmentKeperawatanRajal::create([

            ]);
        } else {
            # code...
        }
        

    }
}
