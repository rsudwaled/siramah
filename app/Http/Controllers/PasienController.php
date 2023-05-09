<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends Controller
{
    //
    public function fingerprintPeserta(Request $request)
    {
        $peserta = null;
        if ($request->nomorkartu) {
            $request['jenisIdentitas'] = 'noka';
            $request['noIdentitas'] = $request->nomorkartu;
            $api = new AntrianController();
            $response =  $api->ref_pasien_fingerprint($request);
            if ($response->getData()->metadata->code == 200) {
                $peserta = $response->getData()->response;
                if ($peserta->daftarfp == 0) {
                    Alert::error('Maaf', 'Pasien Belum memeliki Fingerprint BPJS');
                } else {
                    Alert::success('Success', 'Pasien Belum memeliki Fingerprint BPJS');
                }
            } else {
                Alert::error('Maaf', $response->getData()->metadata->message);
            }
        }
        return view('bpjs.antrian.fingerprint_peserta', compact([
            'request',
            'peserta'
        ]));
    }
}
