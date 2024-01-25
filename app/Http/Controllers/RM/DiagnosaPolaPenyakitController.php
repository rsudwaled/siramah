<?php

namespace App\Http\Controllers\RM;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DiagnosaPenyakitExport;
use App\Exports\DiagnosaPenyakitRajalExport;

class DiagnosaPolaPenyakitController extends Controller
{
    public function diagnosaPenyakitRawatInap(Request $request)
    {
        $first = $request->first;
        $last = $request->last;
        $diagnosa = null;
        if ($first && $last) {
            if($request->data_umur =='k1') {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_KR_1_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr1_4')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_1_4_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr5_14')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_5_14_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr15_44')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_15_44_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr45_75lb')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_45_75_TH ('$first','$last')");
            }
            else{
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_SEMUA_UMUR ('$first','$last')");
            }
            
            $diagnosa = collect($diagnosa);
        }
        
        return view('simrs.diagnosa_pola_penyakit.rawat_inap', compact('diagnosa','request','first','last'));
    }
    public function diagnosaPenyakitRawatJalan(Request $request)
    {
        $first = $request->first;
        $last = $request->last;
        $diagnosa = null;
        if ($first && $last) {
            if($request->data_umur =='k1') {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_KR_1_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr1_4')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_1_4_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr5_14')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_5_14_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr15_44')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_15_44_TH ('$first','$last')");
            }
            elseif($request->data_umur =='umr45_75lb')
            {
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_45_75_TH ('$first','$last')");
            }
           
            else{
                $diagnosa = \DB::connection('mysql8')->select("CALL SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_SEMUA_UMUR ('$first','$last')");
            }
            
            $diagnosa = collect($diagnosa);
        }
        
        return view('simrs.diagnosa_pola_penyakit.rawat_jalan', compact('diagnosa','request','first','last'));
    }

    public function exportExcel(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }

        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Ranap'.$request->first.'_s.d_'.$request->last.'.xlsx';
        return Excel::download(new DiagnosaPenyakitExport($request), $namaFile);
    }
    public function exportExcelRajal(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }

        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Rajal'.$request->first.'_s.d_'.$request->last.'.xlsx';
        return Excel::download(new DiagnosaPenyakitRajalExport($request), $namaFile);
    }
}
