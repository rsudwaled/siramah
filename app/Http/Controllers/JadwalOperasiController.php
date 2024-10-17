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
use RealRashid\SweetAlert\Facades\Alert;

class JadwalOperasiController extends APIController
{
    public function index()
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

        $wa = new WhatsappController();
        $request['number'] = "089529909036";
        $request['message'] = "get jadwal operasi " . now();
        $res = $wa->send_message($request);
        $jadwalops = JadwalOperasi::whereBetween('tanggal', [$request->tanggalawal, $request->tanggalakhir])->get();
        $jadwals = [];
        foreach ($jadwalops as  $jadwalop) {
            $jadwals[] = [
                "kodebooking" => $jadwalop->no_book,
                "tanggaloperasi" => Carbon::parse($jadwalop->tanggal)->format('Y-m-d'),
                // "jenistindakan" => '-',
                // "kodepoli" => "ANA",
                // "namapoli" => "BEDAH",
                "jenistindakan" => $jadwalop->jenis,
                "kodepoli" => $jadwalop->kd_poli_bpjs == "" ? 'ANA' : $jadwalop->kd_poli_bpjs,
                "namapoli" => $jadwalop->ruangan_asal ?? "ANAK",
                "terlaksana" => 0,
                "nopeserta" => $jadwalop->nomor_bpjs == '' ?  "" : $jadwalop->nomor_bpjs,
                "lastupdate" => Carbon::parse("2024-10-17 07:00:00")->timestamp * 1000,
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
}
