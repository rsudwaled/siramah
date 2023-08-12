<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;
use App\Models\AssesmenDokter;

class CPPTController extends Controller
{
    public function getCPPT()
    {
        return view('simrs.rekammedis.cppt.cppt_view');
    }

    public function getK(Request $request){
        $kode_unit = AssesmenDokter::where("id_pasien",$request->rm)->get();
        return response()->json($kode_unit);
    }
    public function getC(Request $request){
        $counter = AssesmenDokter::where('kode_unit', $request->id_kunjungan)
                    ->where('id_pasien', $request->rm)->get();
        return response()->json($counter);
    }

    public function getCPPTPrint(Request $request)
    {
        // $rm ='23980204';
        // $counter ='1.0';
        // $rm ='23979877';
        // $counter ='2';
        $rm = $request->rm;
        $counter = $request->counter;
        $kode_kunjungan = $request->kode_kunjungan;
        $data = \DB::connection('mysql2')->select("CALL SP_ASSESMEN_DOKTER_MEDIS_RAWAT_JALAN('$rm','$counter')");
        header("Content-type: image/gif");
        $datagbr = $data[0]->gambar_1;

        $rincianbiaya = \DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('$rm','$counter','','')");
        // dd($data);

        $pdf = PDF::loadview('simrs.rekammedis.cppt.cppt_print',['data'=>$data[0],'gambar'=>$datagbr,'rincianbiaya'=>$rincianbiaya]);
        return $pdf->stream('cppt-view.pdf');
    }

    public function getCPPTPrintAnestesi(Request $request)
    {
        // $idKunjungan    ='22231013';
        $idKunjungan = $request->kode_kunjungan;
        $ass = AssesmenDokter::where('id_kunjungan', $idKunjungan)->get();
        $lemon = null;
        if ($ass[0]->LEMON != Null) {
            $lemon = explode('|', $ass[0]->LEMON);
        }

        $pdf = PDF::loadview('simrs.rekammedis.cppt.cppt_anestesi_print',compact('ass','lemon'));
        return $pdf->stream('cppt-view.pdf');
    }


}
