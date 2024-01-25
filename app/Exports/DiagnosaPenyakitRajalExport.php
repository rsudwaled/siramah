<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class DiagnosaPenyakitRajalExport implements FromView
{
    public function view():View
    {
        $first = request()->input('first') ;
        $last = request()->input('last') ;
        $diag_umr = request()->input('data_umur');
        if ($first && $last) {
            if($diag_umr =='k1') {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_KR_1_TH ('$first','$last')");
            }
            elseif($diag_umr =='umr1_4')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_1_4_TH ('$first','$last')");
            }
            elseif($diag_umr =='umr5_14')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_5_14_TH ('$first','$last')");
            }
            elseif($diag_umr =='umr15_44')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_15_44_TH ('$first','$last')");
            }
            elseif($diag_umr =='umr45_75lb')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_45_75_TH ('$first','$last')");
            }
           
            else{
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_SEMUA_UMUR ('$first','$last')");
            }
            $diagnosa = collect($diagnosa);
            
        }
        
        return view('export.laporan.diagnosa_pola_penyakit', compact('diagnosa'));
    }
}
