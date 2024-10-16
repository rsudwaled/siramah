<?php

namespace App\Http\Controllers\LaporanRekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KasusMenularDMExport;
use App\Exports\Hypertensixport;
use App\Exports\PPOKxport;
use App\Exports\Jantungxport;
use App\Exports\Strokexport;

class PenyakitKasusBaruController extends Controller
{
    public function menularDM(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_DIABETES_MELITUS_kasus_baru('$startdate','$enddate')");
        return view('simrs.rekammedis.kasus_baru.menular_dm', compact('request','enddate','startdate','data'));
    }

    public function hypertensi(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_HYPERTENSI_kasus_baru('$startdate','$enddate')");
        return view('simrs.rekammedis.kasus_baru.hypertensi', compact('request','enddate','startdate','data'));
    }
    public function ppok(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_PPOK_kasus_baru('$startdate','$enddate')");
        return view('simrs.rekammedis.kasus_baru.ppok', compact('request','enddate','startdate','data'));
    }
    public function jantung(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_JANTUNG_kasus_baru('$startdate','$enddate')");
        return view('simrs.rekammedis.kasus_baru.jantung', compact('request','enddate','startdate','data'));
    }
    public function stroke(Request $request)
    {
        $startdate  = $request->startdate;
        $enddate    = $request->enddate;
        $data       = \DB::connection('mysql2')->select("CALL RM_LAPORAN_PENYAKIT_TIDAK_MENULAR_STROKE_Kasus_baru('$startdate','$enddate')");
        return view('simrs.rekammedis.kasus_baru.stroke', compact('request','enddate','startdate','data'));
    }

    public function downloadMenularDM(Request $request){
        $namaFile = 'Laporan_Kasus_Menular_DM_'.$request->startdate.'_s.d_'.$request->enddate.'.xlsx';
        return Excel::download(new KasusMenularDMExport($request), $namaFile);
    }
    public function downloadHypertensi(Request $request){
        $namaFile = 'Laporan_Kasus_Hypertensi_'.$request->startdate.'_s.d_'.$request->enddate.'.xlsx';
        return Excel::download(new Hypertensixport($request), $namaFile);
    }
    public function downloadPpok(Request $request){
        $namaFile = 'Laporan_Kasus_PPOK_'.$request->startdate.'_s.d_'.$request->enddate.'.xlsx';
        return Excel::download(new PPOKxport($request), $namaFile);
    }
    public function downloadJantung(Request $request){
        $namaFile = 'Laporan_Kasus_Jantung_'.$request->startdate.'_s.d_'.$request->enddate.'.xlsx';
        return Excel::download(new Jantungxport($request), $namaFile);
    }
    public function downloadStroke(Request $request){
        $namaFile = 'Laporan_Kasus_Stroke_'.$request->startdate.'_s.d_'.$request->enddate.'.xlsx';
        return Excel::download(new Strokexport($request), $namaFile);
    }
}
