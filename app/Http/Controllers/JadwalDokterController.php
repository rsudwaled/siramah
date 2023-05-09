<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
    public function jadwalDokterBpjs(Request $request)
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
        } else {
            $dokters = null;
        }
        // get poli
        $response = $controller->ref_poli();
        if ($response->status() == 200) {
            $polikliniks = $response->getData()->response;
        } else {
            $polikliniks = null;
        }
        // get jadwal
        $jadwals = null;
        if (isset($request->kodePoli)) {
            $response = $controller->ref_jadwal_dokter($request);
            if ($response->status() == 200) {
                $jadwals = $response->getData()->response;
                Alert::success($response->statusText(), 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->getData()->metadata->message . ' ' . $response->status());
            }
        }
        return view('bpjs.antrian.jadwal_dokter', compact([
            'request',
            'dokters',
            'polikliniks',
            'jadwals',
        ]));
    }
}
