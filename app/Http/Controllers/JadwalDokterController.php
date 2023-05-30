<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\JadwalLibur;
use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        $polikliniks = Poliklinik::with(['jadwals'])->get();
        $dokters = Dokter::where('status', 1)->get();
        $jadwal_antrian = JadwalDokter::get();
        $request['tanggal'] = $request->tanggal ? $request->tanggal : now()->format('Y-m-d');
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $controller = new AntrianController();
            $response = $controller->ref_jadwal_dokter($request);
            if ($response->status() == 200) {
                $jadwals = $response->getData()->response;
                Alert::success($response->statusText(), 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
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
    public function show($id)
    {
        $jadwal = JadwalDokter::find($id);
        return response()->json($jadwal);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kodesubspesialis' => 'required',
            'kodedokter' => 'required',
            'hari' => 'required',
            'jadwal' => 'required',
            'kapasitaspasien' => 'required',
        ]);
        if ($request->libur == "true") {
            $libur = 1;
        } else {
            $libur = 0;
        }
        if (empty($request->namasubspesialis)) {
            $poli = Poliklinik::firstWhere('kodesubspesialis', $request->kodesubspesialis);
            $request['kodepoli'] = $poli->kodepoli;
            $request['namapoli'] = $poli->namapoli;
            $request['namasubspesialis'] = $poli->namasubspesialis;
        }
        if (empty($request->namadokter)) {
            $dokter = Dokter::firstWhere('kodedokter', $request->kodedokter);
            $request['namadokter'] = $dokter->namadokter;
        }
        $hari = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];

        JadwalDokter::updateOrCreate([
            'kodesubspesialis' => $request->kodesubspesialis,
            'kodedokter' => $request->kodedokter,
            'hari' => $request->hari,
        ], [
            'kodepoli' => $request->kodepoli,
            'namapoli' => $request->namapoli,
            'namasubspesialis' => $request->namasubspesialis,
            'namadokter' => $request->namadokter,
            'namahari' => $hari[$request->hari],
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $libur,
            // 'user_by' => Auth::user()->name,
        ]);
        Alert::success('Ok', 'Jadwal Dokter Diperbaharui');
        return redirect()->back();
    }
    public function update($id, Request $request)
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
        $jadwal = JadwalDokter::find($id);
        $dokter = Dokter::firstWhere('kodedokter', $request->kodedokter);
        $poli = Poliklinik::firstWhere('kodesubspesialis', $request->kodesubspesialis);
        $hari = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
        $jadwal->update([
            'kodesubspesialis' =>  $poli->kodesubspesialis,
            'namasubspesialis' =>  $poli->namasubspesialis,
            'kodepoli' =>  $poli->kodepoli,
            'namapoli' =>  $poli->namapoli,
            'kodedokter' =>  $dokter->kodedokter,
            'namadokter' =>  $dokter->namadokter,
            'hari' =>  $request->hari,
            'namahari' =>  $hari[$request->hari],
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $libur,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Diupdate');
        return redirect()->back();
    }
    public function destroy($id, Request $request)
    {
        $jadwal = JadwalDokter::find($id);
        $jadwal->delete();
        Alert::success('Success', 'Jadwal Telah Dihapus');
        return back();
    }
    public function jadwalDokterAntrianBpjs(Request $request)
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
    public function jadwalDokterPoliklinik(Request $request)
    {
        $jadwaldokter = null;
        $jadwallibur = null;
        if (isset($request->kodepoli)) {
            $jadwaldokter = JadwalDokter::where('kodesubspesialis', $request->kodepoli)->get();
            $jadwallibur = JadwalLibur::with(['unit', 'unit.antrians'])
                ->latest()
                ->paginate();
        }
        $dokters = Dokter::get();
        $unit = Unit::where('KDPOLI', "!=", null)
            ->where('KDPOLI', "!=", "")
            ->get();
        return view('simrs.poliklinik.poliklinik_jadwaldokter', compact([
            'request',
            'unit',
            'dokters',
            'jadwallibur',
            'jadwaldokter',
        ]));
    }
    public function jadwal_dokter_bpjs(Request $request)
    {
        dd('jadwal_dokter_bpjs');
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
    public function jadwaldokter_add(Request $request)
    {
        dd('jadwaldokter_add');
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

    public function jadwaldokterPoli(Request $request)
    {
        $jadwals = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('hari', $request->hari)
            ->where('libur', 0)
            ->get();
        return response()->json($jadwals);
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
