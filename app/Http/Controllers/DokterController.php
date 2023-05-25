<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Paramedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $paramedis = Paramedis::get();
        $dokter = Dokter::get();
        return view('simrs.dokter_index', compact([
            'request',
            'dokter',
            'paramedis',
        ]));
    }
    public function show($id)
    {
        $dokter = Dokter::with(['paramedis'])->where('kodedokter', $id)->first();
        return response()->json($dokter);
    }
    public function create()
    {
        $api = new AntrianController();
        $dokters = $api->ref_dokter()->getData()->response;
        foreach ($dokters as $value) {
            Dokter::updateOrCreate(
                [
                    'kodedokter' => $value->kodedokter,
                ],
                [
                    'namadokter' => $value->namadokter,
                    'status' => 1,
                ]
            );
            $user = User::updateOrCreate([
                'email' => $value->kodedokter . '@gmail.com',
                'username' => $value->kodedokter,
            ], [
                'name' => $value->namadokter,
                'phone' => $value->kodedokter,
                'password' => bcrypt($value->kodedokter),
            ]);
            $user->assignRole('Dokter');
        }
        Alert::success('Success', 'Refresh User Data Dokter Berhasil');
        return redirect()->back();
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
    public function update($id, Request $request)
    {
        $request->validate([
            'namadokter' => 'required',
        ]);
        $dokter = Dokter::firstWhere('kodedokter', $id);
        $dokter->update([
            'namadokter' => $request->namadokter
        ]);
        $paramedis = Paramedis::firstWhere('kode_paramedis', $request->kode_paramedis);
        $paramedis->update([
            'sip_dr' => $request->sip_dr
        ]);
        Alert::success('Success', 'Data Dokter telah diperbarui');
        return redirect()->back();
    }
    public function dokter_antrian_bpjs()
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
    public function dokter_antrian_refresh(Request $request)
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
            foreach ($dokters as $value) {
                DokterAntrian::firstOrCreate([
                    'kodeDokter' => $value->kodedokter,
                    'namaDokter' => $value->namadokter,
                ]);
            }
            Alert::success($response->statusText(), 'Refresh Dokter Antrian BPJS Total : ' . count($dokters));
        } else {
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }
        return redirect()->route('pelayanan-medis.dokter_antrian');
    }
    public function dokter_antrian_yanmed(Request $request)
    {
        $dokters =  DokterAntrian::get();
        return view('simrs.pelyananmedis.dokter_antrian', compact([
            'dokters'
        ]));
    }
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
}
