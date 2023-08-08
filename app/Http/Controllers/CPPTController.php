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

    public function getCPPTPrint()
    {
        // $rm ='23980204';
        // $counter ='1.0';
        $rm ='23979877';
        $counter ='2';
        $data = \DB::connection('mysql2')->select("CALL SP_ASSESMEN_DOKTER_MEDIS_RAWAT_JALAN('$rm','$counter')");
        header("Content-type: image/gif");
        $datagbr = $data[0]->gambar_1;

        $rincianbiaya = \DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('$rm','$counter','','')");

        $pdf = PDF::loadview('simrs.rekammedis.cppt.cppt_print',['data'=>$data[0],'gambar'=>$datagbr,'rincianbiaya'=>$rincianbiaya]);
        return $pdf->stream('cppt-view.pdf');
    }

    public function getCPPTPrintAnestesi()
    {
        $idKunjungan    ='22231013';
        $ass = AssesmenDokter::where('id_kunjungan', $idKunjungan)->firstOrFail();
        $lemon = explode('|', $ass->LEMON);
        // dd($ass);
        $pdf = PDF::loadview('simrs.rekammedis.cppt.cppt_anestesi_print',compact('ass','lemon'));
        return $pdf->stream('cppt-view.pdf');
    }
}
