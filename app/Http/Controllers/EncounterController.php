<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function encounter(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['1'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        return view('simrs.encounter_index', compact('units', 'request'));
    }
    public function table_kunjungan_encounter(Request $request)
    {
        if ($request->kodeunit == '-') {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggalperiksa)
                ->where('status_kunjungan', "!=", 8)
                ->whereRelation('unit', 'kelas_unit', '=', 1)
                ->where('kode_unit', "!=", 1002)
                ->where('kode_unit', "!=", 1023)
                ->with(['diagnosapoli', 'diagnosaicd', 'unit', 'dokter', 'pasien'])
                ->get();
        } else {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggalperiksa)
                ->where('kode_unit', $request->kodeunit)
                ->where('status_kunjungan', "!=", 8)
                ->with(['diagnosapoli', 'diagnosaicd', 'unit', 'dokter', 'pasien'])
                ->get();
        }
        return view('simrs.table_kunjungan_encounter', compact('kunjungans', 'request'));
    }
    public function encounter_sync(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $unit = $kunjungan->unit;
        $dokter = $kunjungan->dokter;
        if ($pasien->ihs == null) {
            $request['norm'] = $pasien->no_rm;
            $api = new PatientController();
            $res = $api->patient_get_id($request);
        }
        $request['patient_id'] = $pasien->ihs;
        $request['patient_name'] = $pasien->nama_px;
        $request['practitioner_id'] = $dokter->id_satusehat;
        $request['practitioner_name'] = $dokter->nama_paramedis;
        $request['location_id'] = $unit->id_location;
        $request['location_name'] = 'Lokasi poliklinik ' . $unit->nama_unit;
        $request['start'] = Carbon::parse($kunjungan->tgl_masuk);
        dd($kunjungan, $request->all());
        // $pasien = Pasien::where('no_rm', $request->norm)->first();
        // $request['nik'] = $pasien->nik_bpjs;
        // $res = $this->patient_by_nik($request);
        // if ($res->metadata->code == 200) {
        //     $ihs = $res->response->entry[0]->resource->id;
        //     $pasien->update([
        //         'ihs' => $ihs
        //     ]);
        //     Alert::success('Sukses', 'Berhasil Sync Patient Satu Sehat');
        // } else {
        //     Alert::error('Mohon Maaf', $res->metadata->message);
        // }
        // return redirect()->back();
    }
}
