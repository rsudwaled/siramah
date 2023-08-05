<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenyakitRawatJalanByYearsExport;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanPenyakitRawatJalanPenelitianController extends Controller
{
    public function LaporanPenyakitRawatJalan(Request $request)
    {
        $diagnosa = $request->diagnosa == null ? '' : $request->diagnosa;
        $laporanPenyakitRJ = null;
        $from = $request->dari == null ? now()->format('Y-m-d') : $request->dari;
        $to = $request->sampai == null ? now()->format('Y-m-d') : $request->sampai;
        if($diagnosa == null && $request->dari && $request->sampai)
        {
            Alert::warning('PERINGATAN!', 'untuk memunculkan data, dimohon untuk memilih data diagnosa terlebih dahulu.');
        }

        if($diagnosa)
        {
            $laporanPenyakitRJ = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_JALAN_2023`('$from','$to','$diagnosa')");
            $laporanPenyakitRJ = collect($laporanPenyakitRJ);
        }

        return view('simrs.laporanindex.laporanpenyakitrawatjalan.laporan_penyakit_rawat_jalan_by_years', compact('laporanPenyakitRJ','request','from','to','diagnosa'));
    }

    public function exportExcel(Request $request)
    {
        if($request->diagnosa == null && $request->dari && $request->sampai)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data diagnosa terlebih dahulu.');
            return back();
        }

        $nama = 'LaporanPenyakitRawatJalanByYears_periode_'.$request->dari.'_s.d_'.$request->sampai.'.xlsx';
        return Excel::download(new LaporanPenyakitRawatJalanByYearsExport($request), $nama);
    }
}
