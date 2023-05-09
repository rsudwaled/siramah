<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function dokterAntrianBpjs()
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
            Alert::success($response->statusText(), 'Dokter Antrian BPJS Total : ' . count($dokters));
        } else {
            $dokters = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }
        $dokter_jkn_simrs = Dokter::get();
        return view('bpjs.antrian.dokter', compact([
            'dokters',
            'dokter_jkn_simrs',
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kodedokter' => 'required',
            'namadokter' => 'required',
        ]);
        Dokter::firstOrCreate([
            'kodedokter' => $request->kodedokter,
            'namadokter' => $request->namadokter,
            'user_by' => Auth::user()->name,
        ]);
        Alert::success('Success', 'Dokter Telah Ditambahkan');
        return redirect()->back();
    }
}
