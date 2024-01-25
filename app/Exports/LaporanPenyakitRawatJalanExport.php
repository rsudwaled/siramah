<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\LaporanPenyakitRawatJalan;
use Illuminate\Http\Request;

class LaporanPenyakitRawatJalanExport implements FromView
{
    public function view():View
    {
        $from   = request()->input('dari') ;
        $to     = request()->input('sampai') ;
        $diag   = request()->input('diagnosa');
        $lprj   = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_JALAN`('$from','$to','$diag')");
        return view('export.laporan.rawat_jalan', compact('lprj'));
    }
}
