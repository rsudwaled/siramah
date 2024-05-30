<?php

namespace App\Http\Controllers\LaporanIndex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TarifLayanan;
use App\Models\Paramedis;
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

    public function indexKematian(Request $request)
    {
        $start      = $request->start == null ? now()->format('Y-m-d') : $request->start;
        $finish      = $request->finish == null ? now()->format('Y-m-d') : $request->finish;
        $tarif      = TarifLayanan::get();
        $paramedis  = Paramedis::get();

        $diagnosa = DB::connection('mysql2')
        ->table('di_pasien_diagnosa')
        ->join('ts_kunjungan', 'di_pasien_diagnosa.kode_kunjungan', '=', 'ts_kunjungan.kode_kunjungan')
        ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
        ->select(
            'ts_kunjungan.kode_paramedis',
            DB::raw('CASE 
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), STR_TO_DATE(mt_pasien.tgl_lahir, "%Y-%m-%d")) / 365.25) <= 10 THEN "10"
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), STR_TO_DATE(mt_pasien.tgl_lahir, "%Y-%m-%d")) / 365.25) <= 15 THEN "15"
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), STR_TO_DATE(mt_pasien.tgl_lahir, "%Y-%m-%d")) / 365.25) <= 20 THEN "20"
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE(), STR_TO_DATE(mt_pasien.tgl_lahir, "%Y-%m-%d")) / 365.25) <= 35 THEN "35"
                        ELSE "35+"
                    END as usia_group'),
            DB::raw('COUNT(*) as total_pasien'),
            'mt_pasien.nama_px as pasien',
            'mt_pasien.no_rm as rm',
        )
        // ->where('ts_kunjungan.kode_paramedis', 'DOK607')
        ->groupBy('usia_group')
        ->get();

        // dd($diagnosa);     
        return view('simrs.laporanindex.index_kematian.index',compact('start','finish','tarif','paramedis'));
    }
}
