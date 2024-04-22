<?php

namespace App\Http\Controllers\LaporanIndex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TarifLayanan;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class IndexKematianController extends Controller
{
    public function index(Request $request)
    {
        $years      = $request->tahun == null ? now()->format('Y') : $request->tahun;
        $tarif      = TarifLayanan::get();
        $tarifFind  = TarifLayanan::where('KODE_TARIF_HEADER', $request->kode_tarif)->first();
        if(empty($tarifFind))
        {
            Alert::warning('INFORMASI!', 'kode tarif header tidak terdaftar');
        }
        $findReport = null;
        if (!empty($years) && !empty($tarifFind)) {
            $findReport = $tarifFind == null ? '' : \DB::connection('mysql2')->select("CALL `SP_LAPORAN_INDEX_OPERASI`('$years','$tarifFind->KODE_TARIF_HEADER')");
        }

        return view('simrs.laporanindex.index_operasi.index', compact('years','tarif','findReport'));
    }
}
