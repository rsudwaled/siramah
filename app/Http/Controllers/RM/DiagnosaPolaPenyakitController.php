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
        $first      = $request->first;
        $last       = $request->last;
        $range_umur = $request->data_umur;
        $diagnosa   = null;
        // Map range_umur ke stored procedure
        $procedures = [
            'k1'            => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_KR_1_TH',
            'umr1_4'        => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_1_4_TH',
            'umr5_14'       => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_5_14_TH',
            'umr15_44'      => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_15_44_TH',
            'umr45_75lb'    => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_UMUR_45_75_TH',
            'all'           => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_INAP_SEMUA_UMUR'
        ];

        // Cek apakah $first dan $last ada
        if ($first && $last) {
            // Tentukan prosedur yang akan dipanggil berdasarkan $range_umur
            $procedure = $procedures[$range_umur] ?? null;

            // Jika ada prosedur yang sesuai, panggil stored procedure
            if ($procedure) {
                $diagnosa = \DB::connection('mysql8')->select("CALL $procedure ('$first','$last')");
                $diagnosa = collect($diagnosa);
            }
        }

        return view('simrs.diagnosa_pola_penyakit.rawat_inap', compact('range_umur','diagnosa','request','first','last'));
    }
    public function diagnosaPenyakitRawatJalan(Request $request)
    {
        $first      = $request->first;
        $last       = $request->last;
        $range_umur = $request->data_umur;
        $diagnosa   = null;

        // Map range_umur ke stored procedure
        $procedures = [
            'k1' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_KR_1_TH',
            'umr1_4' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_1_4_TH',
            'umr5_14' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_5_14_TH',
            'umr15_44' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_15_44_TH',
            'umr45_75lb' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_UMUR_45_75_TH',
            'all' => 'SP_DIAGNOSA_POLA_PENYAKIT_PENDERITA_RAWAT_JALAN_SEMUA_UMUR'
        ];

        // Cek apakah $first dan $last ada
        if ($first && $last) {
            // Tentukan prosedur yang akan dipanggil berdasarkan $range_umur
            $procedure = $procedures[$range_umur] ?? null;

            // Jika ada prosedur yang sesuai, panggil stored procedure
            if ($procedure) {
                // Bangun query untuk memanggil stored procedure
                $query = "CALL $procedure ('$first','$last')";
                $diagnosa = \DB::connection('mysql8')->select($query);
                $diagnosa = collect($diagnosa);
            }
        }


        return view('simrs.diagnosa_pola_penyakit.rawat_jalan', compact('range_umur','diagnosa','request','first','last'));
    }

    public function exportExcel(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $range_umur = $request->data_umur;
        $umur       = null;
        if($range_umur =='k1')
        {
            $umur = 'Kurang_Dari_1_Tahun';
        }
        elseif($range_umur =='umr1_4')
        {
            $umur = 'umur_1_sampai_4_Tahun';
        }
        elseif($range_umur =='umr5_14')
        {
            $umur = 'umur_5_sampai_14_Tahun';
        }
        elseif($range_umur =='umr15_44')
        {
            $umur = 'umur_15_sampai_44_Tahun';
        }
        elseif($range_umur =='umr45_75lb')
        {
            $umur = 'umur_45_sampai_lebih_dari_75_Tahun';
        }
        else
        {
            $umur = 'semua_umur';
        }
        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Ranap'.$request->first.'_s.d_'.$request->last.'_'.$umur.'.xlsx';
        return Excel::download(new DiagnosaPenyakitExport($request), $namaFile);
    }
    public function exportExcelRajal(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $range_umur = $request->data_umur;
        $umur       = null;
        if($range_umur =='k1')
        {
            $umur = 'Kurang_Dari_1_Tahun';
        }
        elseif($range_umur =='umr1_4')
        {
            $umur = 'umur_1_sampai_4_Tahun';
        }
        elseif($range_umur =='umr5_14')
        {
            $umur = 'umur_5_sampai_14_Tahun';
        }
        elseif($range_umur =='umr15_44')
        {
            $umur = 'umur_15_sampai_44_Tahun';
        }
        elseif($range_umur =='umr45_75lb')
        {
            $umur = 'umur_45_sampai_lebih_dari_75_Tahun';
        }
        else
        {
            $umur = 'semua_umur';
        }
        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Rajal'.$request->first.'_s.d_'.$request->last.'_'.$umur.'.xlsx';
        return Excel::download(new DiagnosaPenyakitRajalExport($request), $namaFile);
    }
}
