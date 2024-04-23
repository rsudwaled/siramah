<?php

namespace App\Http\Controllers\LaporanIndex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paramedis;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class IndexDokterController extends Controller
{
    public function index(Request $request)
    {
        $from       = $request->dari == null ? now()->format('Y-m-d') : $request->dari;
        $to         = $request->selesai == null ? now()->format('Y-m-d') : $request->selesai;

        $paramedis  = Paramedis::get();
        $dokterFind = Paramedis::where('kode_paramedis', $request->kode_paramedis)->first();
        if(empty($dokterFind))
        {
            Alert::warning('INFORMASI!', 'kode paramedis tidak terdaftar');
        }
        $findReport = null;
        if (!empty($from) && !empty($to) && !empty($dokterFind)) {
            $findReport = $dokterFind == null ? '' : \DB::connection('mysql2')->select("CALL `sp_laporan_kartu_indeks_dokter`('$request->kode_paramedis','$from','$to')");
        }
        return view('simrs.laporanindex.index_dokter.index', compact('paramedis','findReport','from','to'));
    }
}
