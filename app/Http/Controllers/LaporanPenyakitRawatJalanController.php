<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenyakitRawatJalanExport;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanPenyakitRawatJalanController extends Controller
{
    public function LaporanPenyakitRawatJalan(Request $request)
    {
        // dd($request->all());
        if($request->all() == null){
            Alert::warning('PERINGATAN!', 'untuk memunculkan data, dimohon untuk memilih data periode tanggal dan diagnosa terlebih dahulu.');
        }
        if($request->diagnosa == null)
        {
            Alert::warning('PERINGATAN!', 'untuk memunculkan data, dimohon untuk memilih data periode tanggal dan diagnosa terlebih dahulu.');
        }

        $diagnosa = $request->diagnosa == null ? '' : $request->diagnosa;
        $selDiag = $diagnosa == null ? '' : \DB::connection('mysql2')->select("CALL `sp_mt_icd10`('$diagnosa')");

        $laporanPenyakitRJ = null;
        $from = $request->dari == null ? now()->format('Y-m-d') : $request->dari;
        $to = $request->sampai == null ? now()->format('Y-m-d') : $request->sampai;

        if($diagnosa)
        {
            $laporanPenyakitRJ = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_JALAN`('$from','$to','$diagnosa')");
            $laporanPenyakitRJ = collect($laporanPenyakitRJ);
        }

        return view('simrs.laporanindex.laporanpenyakitrawatjalan.laporan_penyakit_rawat_jalan', compact('selDiag','laporanPenyakitRJ','request','from','to','diagnosa'));
    }

    public function dataAjax(Request $request)
    {

        $data = [];
        if($request->has('q')){
            $cari = $request->q;
            $data = \DB::connection('mysql2')->select("CALL `sp_mt_icd10`('$cari')");
        }
        return response()->json($data);
    }

    public function exportExcel(Request $request)
    {
        if($request->diagnosa == null && $request->dari && $request->sampai)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data diagnosa terlebih dahulu.');
            return back();
        }

        $nama = 'LaporanPenyakitRawatJalan_periode_'.$request->dari.'_s.d_'.$request->sampai.'.xlsx';
        return Excel::download(new LaporanPenyakitRawatJalanExport($request), $nama);
    }
}
