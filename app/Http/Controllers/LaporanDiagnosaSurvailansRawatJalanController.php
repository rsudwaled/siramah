<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanSurvailansRajalExport;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanDiagnosaSurvailansRawatJalanController extends Controller
{
    public function LaporanSurvailans(Request $request)
    {
        $from = $request->dari == null ? '' : $request->dari;
        $to = $request->sampai == null ? '' : $request->sampai;
        $laporanDSRAJAL = null;
        if($from == null && $to == null)
        {
            Alert::warning('INFORMASI!', 'untuk memunculkan data, dimohon untuk memilih periode tanggal terlebih dahulu.');
        }

        if($from && $to)
        {
            $laporanDSRAJAL = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_SURVAILANS_TERPADU_RAWAT_JALAN`('$from','$to')");
            $laporanDSRAJAL = collect($laporanDSRAJAL);
        }

        return view('simrs.laporanindex.laporansurvailans.laporansurvailansRajal', compact('from','to','laporanDSRAJAL','request'));
    }

    public function exportExcel(Request $request)
    {
        if($request->dari == null && $request->sampai == null)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data diagnosa terlebih dahulu.');
            return back();
        }

        $namaFile = 'LaporanDiagnosaSurvailansRajal_Periode_'.$request->dari.'_s.d_'.$request->sampai.'.xlsx';
        return Excel::download(new LaporanSurvailansRajalExport($request), $namaFile);
    }
}
