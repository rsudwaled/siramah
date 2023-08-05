<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;

class CPPTController extends Controller
{
    public function getCPPT()
    {
        return view('simrs.rekammedis.cppt.cppt_view');
    }

    public function getCPPTPrint()
    {
        $from = '2023-06-01';
        $to = '2023-06-30';
        $rm ='23980204';
        $counter ='1.0';
        $data = \DB::connection('mysql2')->select("CALL SP_ASSESMEN_DOKTER_MEDIS_RAWAT_JALAN('$rm','$counter')");
        header("Content-type: image/gif");
        $datagbr = $data[0]->gambar_1;

        $pdf = PDF::loadview('simrs.rekammedis.cppt.cppt_print',['data'=>$data[0],'gambar'=>$datagbr]);
    	// return $pdf->download('cppt-print-pdf');
        return $pdf->stream('cppt-view.pdf');
    }
}
