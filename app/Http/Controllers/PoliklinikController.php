<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PoliklinikController extends Controller
{
    public function poliklikAntrianBpjs()
    {
        $controller = new AntrianController();
        $poliklinik_save = Poliklinik::get();

        $response = $controller->ref_poli();
        if ($response->status() == 200) {
            $polikliniks = $response->getData()->response;
            Alert::success($response->statusText(), 'Poliklinik Antrian BPJS');
        } else {
            $polikliniks = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }
        $response = $controller->ref_poli_fingerprint();
        if ($response->status() == 200) {
            $fingerprint = $response->getData()->response;
            Alert::success($response->statusText(), 'Poliklinik Antrian BPJS');
        } else {
            $fingerprint = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status(),  'Poliklinik Fingerprint Antrian BPJS');
        }
        return view('bpjs.antrian.poliklinik', compact([
            'polikliniks',
            'fingerprint',
            'poliklinik_save',
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kodepoli' => 'required',
            'namapoli' => 'required',
            'kodesubspesialis' => 'required',
            'namasubspesialis' => 'required',
        ]);
        Poliklinik::firstOrCreate([
            'kodepoli' => $request->kodepoli,
            'kodesubspesialis' => $request->kodesubspesialis,
        ], [
            'namapoli' => $request->namapoli,
            'namasubspesialis' => $request->namasubspesialis,
            'user_by' => Auth::user()->name,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Ditambahkan');
        return redirect()->back();
    }
}
