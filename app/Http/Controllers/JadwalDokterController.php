<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
    public function jadwalDokterBpjs(Request $request)
    {
        $polikliniks = Poliklinik::all();
        $jadwal_save = JadwalDokter::all();
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $api = new AntrianController();
            $response = $api->ref_jadwal_dokter($request);
            if ($response->status() == 200) {
                $jadwals = $response->getData()->response;
                Alert::success($response->statusText(), 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->getData()->metadata->message . ' ' . $response->status());
            }
        }
        return view('bpjs.antrian.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'jadwals',
            'jadwal_save',
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kodepoli' => 'required',
            'namapoli' => 'required',
            'kodesubspesialis' => 'required',
            'namasubspesialis' => 'required',
            'kodedokter' => 'required',
            'namadokter' => 'required',
            'hari' => 'required',
            'namahari' => 'required',
            'jadwal' => 'required',
            'kapasitaspasien' => 'required',
            'libur' => 'required',
        ]);
        JadwalDokter::firstOrCreate([
            'kodepoli' => $request->kodepoli,
            'kodesubspesialis' => $request->kodesubspesialis,
            'kodedokter' => $request->kodedokter,
            'hari' => $request->hari,
        ], [
            'namapoli' => $request->namapoli,
            'namasubspesialis' => $request->namasubspesialis,
            'namadokter' => $request->namadokter,
            'namahari' => $request->namahari,
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $request->libur,
            'user_by' => Auth::user()->name,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Ditambahkan');
        return redirect()->back();
    }
}
