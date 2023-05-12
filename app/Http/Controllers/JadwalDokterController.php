<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
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
    public function jadwal_dokter_bpjs(Request $request)
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
    public function index(Request $request)
    {
        $polikliniks = Poliklinik::get();
        $dokters = Dokter::get();
        $jadwal_antrian = JadwalDokter::get();
        $request['tanggal'] = $request->tanggal ? $request->tanggal : now()->format('Y-m-d');

        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $controller = new AntrianController();
            $response = $controller->ref_jadwal_dokter($request);
            if ($response->status() == 200) {
                $jadwals = $response->getData()->response;
                // Alert::success($response->statusText(), 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->getData()->metadata->message . ' ' . $response->status());
            }
        }

        return view('simrs.pelyananmedis.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'jadwals',
            'dokters',
            'jadwal_antrian',
        ]));
    }
    public function jadwaldokter_add(Request $request)
    {
        $request->validate([
            'kodePoli' => 'required',
            'namaPoli' => 'required',
            'kodeSubspesialis' => 'required',
            'namaSubspesialis' => 'required',
            'kodeDokter' => 'required',
            'namaDokter' => 'required',
            'hari' => 'required',
            'namaHari' => 'required',
            'jadwal' => 'required',
            'kapasitasPasien' => 'required',
            'libur' => 'required',
        ]);
        JadwalDokterAntrian::firstOrCreate([
            'kodepoli' => $request->kodePoli,
            'namapoli' => $request->namaPoli,
            'kodesubspesialis' => $request->kodeSubspesialis,
            'namasubspesialis' => $request->namaSubspesialis,
            'kodedokter' => $request->kodeDokter,
            'namadokter' => $request->namaDokter,
            'hari' => $request->hari,
            'namahari' => $request->namaHari,
        ], [
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitasPasien,
            'libur' => $request->libur,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Ditambahkan');
        return redirect()->back();
    }
    public function show($id)
    {
        $jadwal = JadwalDokter::find($id);
        return response()->json($jadwal);
    }
    public function jadwaldokterPoli(Request $request)
    {
        $jadwals = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('hari', $request->hari)
            ->where('libur', 0)
            ->get();
        return response()->json($jadwals);
    }
    public function update(Request $request)
    {
        $request->validate([
            'jadwal' => 'required',
            'kapasitaspasien' => 'required',
        ]);
        if ($request->libur == "true") {
            $libur = 1;
        } else {
            $libur = 0;
        }
        $jadwal = JadwalDokterAntrian::find($request->idjadwal);
        $jadwal->update([
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $libur,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Diupdate');
        return redirect()->back();
    }
    public function jadwaldokter_delete(Request $request)
    {
        $request->validate([
            'idjadwal' => 'required',
        ]);
        $jadwal = JadwalDokterAntrian::find($request->idjadwal);
        $jadwal->delete();
        Alert::success('Success', 'Jadwal Dokter Telah Dihapus');
        return redirect()->back();
    }
}
