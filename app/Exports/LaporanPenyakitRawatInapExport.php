<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class LaporanPenyakitRawatInapExport implements FromView
{
    public function view():View
    {
        $from = request()->input('dari') ;
        $to = request()->input('sampai') ;
        $diag = request()->input('diagnosa');
        $lpri = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_INAP`('$from','$to','$diag')");
        return view('export.laporan.rawat_inap', compact('lpri'));
    }
}
