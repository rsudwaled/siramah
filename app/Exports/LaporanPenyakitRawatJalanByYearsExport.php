<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\LaporanPenyakitRawatJalan;
use Illuminate\Http\Request;

class LaporanPenyakitRawatJalanByYearsExport implements FromView
{
    public function view():View
    {
        $from   = request()->input('dari') ;
        $to     = request()->input('sampai') ;
        $diag   = request()->input('diagnosa');
        $lprjByYears = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_JALAN_2023`('$from','$to','$diag')");
        return view('export.laporan.rawat_jalan_by_years', compact('lprjByYears'));
    }
}
