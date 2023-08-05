<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenyakitRawatInapbyYearExport;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanPenyakitRawatInapPenelitianController extends Controller
{
    public function LaporanPenyakitRawatInap(Request $request)
    {
        $diagnosa = $request->diagnosa == null ? '' : $request->diagnosa;
        $laporanPenyakitRI = null;
        $from = $request->dari == null ? now()->format('Y-m-d') : $request->dari;
        $to = $request->sampai == null ? now()->format('Y-m-d') : $request->sampai;
        if($diagnosa == null && $request->dari && $request->sampai)
        {
            Alert::warning('PERINGATAN!', 'untuk memunculkan data, dimohon untuk memilih data diagnosa terlebih dahulu.');
        }

        if($diagnosa)
        {
            $laporanPenyakitRI = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_INAP_2023`('$from','$to','$diagnosa')");
            $laporanPenyakitRI = collect($laporanPenyakitRI);
        }
        return view('simrs.laporanindex.laporanpenyakitrawatinap.laporan_penyakit_rawat_inap_by_years', compact('laporanPenyakitRI','request','from','to','diagnosa'));
    }

    public function exportExcel(Request $request)
    {
        if($request->diagnosa == null && $request->dari && $request->sampai)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data diagnosa terlebih dahulu.');
            return back();
        }

        $namaByYear = 'LaporanPenyakitRawatInapPenelitian_periode_'.$request->dari.'_s.d_'.$request->sampai.'.xlsx';
        return Excel::download(new LaporanPenyakitRawatInapbyYearExport($request), $namaByYear);
    }
}
