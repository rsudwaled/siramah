<?php

namespace App\Http\Controllers\IGD\BPJSPROSES;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class BpjsProsesController extends Controller
{
    public function listPasienBpjsProses(Request $request)
    {
        $date       = $request->date;
        $query      = Kunjungan::where('jp_daftar', 2);

        if($request->date != null)
        {
            $query->whereDate('tgl_masuk', $request->date);
        }

        $kunjungan  = $query->get();
        return view('simrs.igd.bpjs_proses.list_pasien_bpjsproses', compact('request','kunjungan'));
    }

    public function detailPasienBPJSPROSES($kunjungan)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.bpjs_proses.detail_pasien_bpjsproses', compact('kunjungan'));
    }
}
