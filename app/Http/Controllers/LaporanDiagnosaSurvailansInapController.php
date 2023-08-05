<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanSurvailansExport;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanDiagnosaSurvailansInapController extends Controller
{
    public function LaporanSurvailans(Request $request)
    {
        $laporanDS = null;
        $from = $request->dari == null ? '' : $request->dari;
        $to = $request->sampai == null ? '' : $request->sampai;
        if($from == null && $to == null)
        {
            Alert::warning('INFORMASI!', 'untuk memunculkan data, dimohon untuk memilih periode tanggal terlebih dahulu.');
        }

        if($from && $to)
        {
            $laporanDS = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_SURVAILANS_TERPADU_RAWAT_INAP`('$from','$to')");
            $laporanDS = collect($laporanDS);
            // dd($laporanDS);
        }

        return view('simrs.laporanindex.laporansurvailans.laporansurvailansInap', compact('from','to','laporanDS','request'));
    }

    public function exportExcel(Request $request)
    {
        if($request->dari == null && $request->sampai == null)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data diagnosa terlebih dahulu.');
            return back();
        }

        $namaFile = 'LaporanDiagnosaSurvailansRanap_Periode_'.$request->dari.'_s.d_'.$request->sampai.'.xlsx';
        return Excel::download(new LaporanSurvailansExport($request), $namaFile);
    }

}
