<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Token;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class EncounterController extends SatuSehatController
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
        $request['patient_id'] = $pasien->ihs;
        if ($pasien->ihs == null) {
            $request['norm'] = $pasien->no_rm;
            $api = new PatientController();
            $res = $api->patient_get_id($request);
            if ($res->metadata->code == 200) {
                $ihs = $res->response->entry[0]->resource->id;
                $request['patient_id'] = $ihs;
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
                return redirect()->back();
            }
        }
        $request['patient_name'] = $pasien->nama_px;
        $request['practitioner_id'] = $dokter->id_satusehat;
        $request['practitioner_name'] = $dokter->nama_paramedis;
        $request['location_id'] = $unit->id_location;
        $request['location_name'] = 'Lokasi poliklinik ' . $unit->nama_unit;
        $request['organization_id'] =  $unit->id_satusehat;
        $request['encounter_id'] = $kunjungan->kode_kunjungan;
        $request['start'] = Carbon::parse($kunjungan->tgl_masuk);
        if (!$kunjungan->id_satusehat) {
            $res = $this->encounter_create($request);
            if ($res->metadata->code == 200) {
                $ihs = $res->response->id;
                $kunjungan->update([
                    'id_satusehat' => $ihs,
                ]);
                Alert::success('Success', 'Kunjungan telah syncron dengan satusehat id ' . $kunjungan->id_satusehat);
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        } else {
            Alert::error('Mohon Maaf', 'Kunjungan telah syncron dengan satusehat id ' . $kunjungan->id_satusehat);
        }
        $urlback = route('encounter') . '?kodeunit=' . $unit->kode_unit . '&tanggal=' . Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d');
        return redirect()->to($urlback);
    }
    public function encounter_create(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "patient_id" => "required",
            "patient_name" => "required",
            "practitioner_id" => "required",
            "practitioner_name" => "required",
            "location_id" => "required",
            "location_name" => "required",
            "encounter_id" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Data Belum Lengkap', $validator->errors()->first(), 400);
        }
        $token = Token::latest()->first()->access_token;
        $url =  env('SATUSEHAT_BASE_URL') . "/Encounter";
        $data = [
            "resourceType" => "Encounter",
            "status" => "arrived",
            "class" => [
                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code" => "AMB",
                "display" => "ambulatory"
            ],
            "subject" => [
                "reference" => "Patient/" . $request->patient_id,
                "display" => $request->patient_name,
            ],
            "participant" => [
                [
                    "type" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code" => "ATND",
                                    "display" => "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual" => [
                        "reference" => "Practitioner/" . $request->practitioner_id,
                        "display" => $request->practitioner_name,
                    ]
                ]
            ],
            "period" => [
                "start" => $request->start
            ],
            "location" => [
                [
                    "location" => [
                        "reference" => "Location/" . $request->location_id,
                        "display" => $request->location_name,
                    ]
                ]
            ],
            "statusHistory" => [
                [
                    "status" => "arrived",
                    "period" => [
                        "start" => $request->start
                    ]
                ]
            ],
            "serviceProvider" => [
                "reference" => "Organization/100025921"
            ],
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/encounter/100025921",
                    "value" => $request->encounter_id
                ]
            ]
        ];
        $response = Http::withToken($token)->post($url, $data);
        $res = $response->json();
        return $this->responseSatuSehat($res);
    }
}
