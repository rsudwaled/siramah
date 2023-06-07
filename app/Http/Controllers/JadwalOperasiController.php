<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalOperasi;
use App\Models\Paramedis;
use App\Models\Poliklinik;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalOperasiController extends APIController
{
    public function jadwalOperasi()
    {
        $dokters = Dokter::get();
        $poli = Poliklinik::get();
        $jadwals = JadwalOperasi::whereYear('tanggal', '=', 2023)
            ->get();
        return view('simrs.jadwaloperasi_index', [
            'dokters' => $dokters,
            'poli' => $poli,
            'jadwals' => $jadwals
        ]);
    }

    public function jadwaloperasi_info()
    {
        $tanggalawal = Carbon::now()->format('Y-m-d');
        $tanggalakhir = Carbon::now()->addDays(1)->format('Y-m-d');
        $jadwals = JadwalOperasi::whereBetween('tanggal', [$tanggalawal, $tanggalakhir])->get();
        return view('simrs.jadwaloperasi_info', compact([
            'jadwals'
        ]));
    }

    public function jadwaloperasi_display()
    {
        $tanggalawal = Carbon::now()->format('Y-m-d');
        $tanggalakhir = Carbon::now()->addDays(1)->format('Y-m-d');
        $jadwals = JadwalOperasi::whereBetween('tanggal', [$tanggalawal, $tanggalakhir])->get();
        return view('simrs.jadwaloperasi_display', compact([
            'jadwals'
        ]));
    }

    public function jadwal_operasi_rs(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "tanggalawal" => "required|date",
            "tanggalakhir" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 201);
        }
        $request['tanggalawal'] = Carbon::parse($request->tanggalawal)->startOfDay();
        $request['tanggalakhir'] = Carbon::parse($request->tanggalakhir)->endOfDay();
        // end auth token
        $jadwalops = JadwalOperasi::whereBetween('tanggal', [$request->tanggalawal, $request->tanggalakhir])->get();
        $jadwals = [];
        foreach ($jadwalops as  $jadwalop) {
            $dokter = Paramedis::where('nama_paramedis', $jadwalop->nama_dokter)->first();
            if (isset($dokter)) {
                $unit = Unit::where('kode_unit', $dokter->unit)->first();
            } else {
                $unit['KDPOLI'] = 'UGD';
            }
            $jadwals[] = [
                "kodebooking" => $jadwalop->no_book,
                "tanggaloperasi" => Carbon::parse($jadwalop->tanggal)->format('Y-m-d'),
                "jenistindakan" => $jadwalop->jenis,
                "kodepoli" =>  $unit->KDPOLI ?? 'BED',
                // "namapoli" => $jadwalop->ruangan_asal,
                "namapoli" => 'BEDAH',
                "terlaksana" => 0,
                "nopeserta" => $jadwalop->nomor_bpjs,
                "lastupdate" => now()->timestamp * 1000,
            ];
        }
        $response = [
            "list" => $jadwals
        ];
        return $this->sendResponse($response, 200);
    }
    public function jadwal_operasi_pasien(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "nopeserta" => "required|digits:13",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 201);
        }
        $jadwalops = JadwalOperasi::where('nomor_bpjs', $request->nopeserta)->get();
        $jadwals = [];
        foreach ($jadwalops as  $jadwalop) {
            $dokter = Paramedis::where('nama_paramedis', $jadwalop->nama_dokter)->first();
            if (isset($dokter)) {
                $unit = Unit::where('kode_unit', $dokter->unit)->first();
            } else {
                $unit['KDPOLI'] = 'UGD';
            }
            $jadwals[] = [
                "kodebooking" => $jadwalop->no_book,
                "tanggaloperasi" => Carbon::parse($jadwalop->tanggal)->format('Y-m-d'),
                "jenistindakan" => $jadwalop->jenis,
                "kodepoli" =>  $unit->KDPOLI ?? 'BED',
                "namapoli" => "Penyakit Dalam",
                "terlaksana" => 0,
            ];
        }
        $response = [
            "list" => $jadwals
        ];
        return $this->sendResponse($response, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->method == 'STORE') {
            $request['kodebooking'] = strtoupper(uniqid());
            $request['kodetindakan'] = $request->jenistindakan;
            $poli = Poliklinik::where('kodesubspesialis',  $request->kodepoli)->first();
            $request['namapoli'] = $poli->namasubspesialis;
            $dokter = Dokter::where('kodedokter', $request->kodedokter)->first();
            $request['namadokter'] = $dokter->namadokter;
            $request->validate([
                'kodebooking' => 'required',
                'tanggaloperasi' => 'required',
                'kodetindakan' => 'required',
                'jenistindakan' => 'required',
                'kodepoli' => 'required',
                'namapoli' => 'required',
                'kodedokter' => 'required',
                'namadokter' => 'required',
                'nopeserta' => 'required',
                'nik' => 'required',
                'norm' => 'required',
                'namapeserta' => 'required',
            ]);
            JadwalOperasi::create([
                'kodebooking' => $request->kodebooking,
                'tanggaloperasi' => $request->tanggaloperasi,
                'kodetindakan' => $request->kodetindakan,
                'jenistindakan' => $request->jenistindakan,
                'kodepoli' => $request->kodepoli,
                'namapoli' => $request->namapoli,
                'kodedokter' => $request->kodedokter,
                'namadokter' => $request->namadokter,
                'terlaksana' => 0,
                'nopeserta' => $request->nopeserta,
                'nik' => $request->nik,
                'norm' => $request->norm,
                'namapeserta' => $request->namapeserta,
            ]);
            Alert::success('Success', 'Jadwal Telah Ditambahkan');
            return redirect()->route('jadwaloperasi.index');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
