<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BudgetControl;
use App\Models\ErmGroupping;
use App\Models\Icd10;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InacbgController extends APIController
{
    public $key_eclaim = "888464e40d0eb122e2221dcf18d2d8005cefb986b9093128db9c2ec1985176ad";

    public function search_diagnosis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_diagnosis",
            ],
            "data" => [
                "keyword" => $request->keyword,
            ]
        ];
        $json_request = json_encode($request_data);
        $response =  $this->send_request($json_request);
        $datarray = array();
        if ($response->metadata->code == 200) {
            $data = $response->response->data;
            $count = $response->response->count;
            if ($count == 0) {
            } else {
                foreach ($data as  $item) {
                    $datarray[] = array(
                        "id" => $item[1],
                        "text" => $item[1] . ' ' . $item[0]
                    );
                }
            }
            return response()->json($datarray);
        } else {
            return $response;
        }
    }
    public function get_diagnosis_eclaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_diagnosis",
            ],
            "data" => [
                "keyword" => $request->keyword,
            ]
        ];
        $json_request = json_encode($request_data);
        $response =  $this->send_request($json_request);
        $datarray = array();
        if ($response->metadata->code == 200) {
            $data = $response->response->data;
            $count = $response->response->count;
            if ($count == 0) {
            } else {
                foreach ($data as  $item) {
                    $datarray[] = array(
                        "id" => $item[1] . '|' . $item[0],
                        "text" => $item[1] . ' ' . $item[0],
                    );
                }
            }
            return response()->json($datarray);
        } else {
            return $response;
        }
    }
    public function search_procedures(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_procedures",
            ],
            "data" => [
                "keyword" => $request->keyword,
            ]
        ];
        $json_request = json_encode($request_data);
        $response =  $this->send_request($json_request);
        $datarray = array();
        if ($response->metadata->code == 200) {
            $data = $response->response->data;
            $count = $response->response->count;
            if ($count == 0) {
            } else {
                foreach ($data as  $item) {
                    $datarray[] = array(
                        "id" => $item[1],
                        "text" => $item[1] . ' ' . $item[0]
                    );
                }
            }
            return response()->json($datarray);
        } else {
            return $response;
        }
    }
    public function get_procedure_eclaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_procedures",
            ],
            "data" => [
                "keyword" => $request->keyword,
            ]
        ];
        $json_request = json_encode($request_data);
        $response =  $this->send_request($json_request);
        $datarray = array();
        if ($response->metadata->code == 200) {
            $data = $response->response->data;
            $count = $response->response->count;
            if ($count == 0) {
            } else {
                foreach ($data as  $item) {
                    $datarray[] = array(
                        "id" => $item[1] . '|' . $item[0],
                        "text" => $item[1] . ' ' . $item[0]
                    );
                }
            }
            return response()->json($datarray);
        } else {
            return $response;
        }
    }
    public function search_diagnosis_inagrouper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_diagnosis_inagrouper",
            ],
            "data" => [
                "keyword" => $request->keyword
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function search_procedures_inagrouper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "search_procedures_inagrouper",
            ],
            "data" => [
                "keyword" => $request->keyword
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function new_claim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nomorkartu" =>  "required",
            "noSEP" =>  "required",
            "norm" =>  "required",
            "nama" =>  "required",
            "tgllahir" =>  "required",
            "gender" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "new_claim",
            ],
            "data" => [
                "nomor_kartu" => $request->nomorkartu,
                "nomor_sep" => $request->noSEP,
                "nomor_rm" => $request->norm,
                "nama_pasien" => $request->nama,
                "tgl_lahir" => $request->tgllahir,
                "gender" => $request->gender,
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function claim_ranap(Request $request)
    {
        $request->validate([
            "kodekunjungan" =>  "required",
            "counter" =>  "required",
            "norm" =>  "required",
            "noSEP" =>  "required",
        ]);
        $diag = null;
        $diag_utama = null;
        foreach ($request->diagnosa as $key => $value) {
            $diagnosa = Icd10::where('diag', $value)->first();
            if ($key == 0) {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag_utama =  $value . " | " . $a;
            } else if ($key == 1) {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag =  $value . " | " . $a;
            } else {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag = $diag . ";" .  $value . " | " . $a;
            }
        }
        $request['tgl_pulang'] = now()->format('Y-m-d H:m:s');
        $res = $this->new_claim($request);
        $res = $this->set_claim_ranap($request);
        $res = $this->grouper($request);
        if ($res->metadata->code == 200) {
            $rmcounter = $request->norm . '|' . $request->counter;
            $budget = BudgetControl::updateOrCreate(
                [
                    'rm_counter' => $rmcounter
                ],
                [
                    'tarif_inacbg' => $res->response->cbg->tariff ?? '0',
                    'no_rm' => $request->norm,
                    'counter' => $request->counter,

                    'diagnosa_kode' => $request->diagnosa, #kode
                    'diagnosa_utama' => $diag_utama,
                    'diagnosa' => $diag,
                    'prosedur' => $request->procedure, #kode | deskripsi
                    'kode_cbg' => $res->response->cbg->code . " | " . $res->response->cbg->description,
                    'kelas' => $res->response->kelas,
                    'tgl_grouper' => now(),
                    'tgl_edit' => now(),
                    'deskripsi' => $res->response->cbg->description,
                    "pic" => 1,
                ]
            );
            $kunjungan = Kunjungan::find($request->kodekunjungan);
            $kunjungan->update([
                'no_sep' => $request->noSEP,
            ]);
            Alert::success('Success', 'Groupping berhasil');
        } else {
            Alert::error('Gagal', 'Groupping gagal');
        }
        return redirect()->back();
    }
    public function claim_ranap_v2(Request $request)
    {
        $request->validate([
            "kodekunjungan" =>  "required",
            "counter" =>  "required",
            "norm" =>  "required",
            "noSEP" =>  "required",
        ]);
        $diag = null;
        $diag_utama = null;
        foreach ($request->diagnosa as $key => $value) {
            $diagnosa = Icd10::where('diag', $value)->first();
            if ($key == 0) {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag_utama =  $value . " | " . $a;
            } else if ($key == 1) {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag =  $value . " | " . $a;
            } else {
                $a = $diagnosa != null ? $diagnosa->nama : '-';
                $diag = $diag . ";" .  $value . " | " . $a;
            }
        }
        $request['tgl_pulang'] = now()->format('Y-m-d H:m:s');
        $res = $this->new_claim($request);
        $res = $this->set_claim_ranap($request);
        $res = $this->grouper($request);
        if ($res->metadata->code == 200) {
            $rmcounter = $request->norm . '|' . $request->counter;
            $budget = BudgetControl::updateOrCreate(
                [
                    'rm_counter' => $rmcounter
                ],
                [
                    'tarif_inacbg' => $res->response->cbg->tariff ?? '0',
                    'no_rm' => $request->norm,
                    'counter' => $request->counter,

                    'diagnosa_kode' => $request->diagnosa, #kode
                    'diagnosa_utama' => $diag_utama,
                    'diagnosa' => $diag,
                    'prosedur' => $request->procedure, #kode | deskripsi
                    'kode_cbg' => $res->response->cbg->code . " | " . $res->response->cbg->description,
                    'kelas' => $res->response->kelas,
                    'tgl_grouper' => now(),
                    'tgl_edit' => now(),
                    'deskripsi' => $res->response->cbg->description,
                    "pic" => 1,
                ]
            );
            $kunjungan = Kunjungan::find($request->kodekunjungan);
            $kunjungan->update([
                'no_sep' => $request->noSEP,
            ]);
            Alert::success('Success', 'Groupping berhasil');
        } else {
            Alert::error('Gagal', 'Groupping gagal');
        }
        return redirect()->back();
    }
    public function set_claim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nomor_sep" =>  "required",
            "nomor_kartu" =>  "required",
            "tgl_masuk" =>  "required|date",
            "cara_masuk" =>  "required",
            "jenis_rawat" =>  "required",
            "kelas_rawat" =>  "required",
            "diagnosa" =>  "required",
            // "procedure" =>  "required",
        ]);
        return $this->sendResponse('ok', $request->diagnosa);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "set_claim_data",
                "nomor_sep" => $request->nomor_sep,

            ],
            "data" => [
                "nomor_sep" =>  $request->nomor_sep,
                "nomor_kartu" => $request->nomor_kartu,
                "tgl_masuk" => $request->tgl_masuk,
                "tgl_pulang" => $request->tgl_pulang,
                "cara_masuk" => $request->cara_masuk, #isi
                "jenis_rawat" => $request->jenis_rawat, #inap, jalan, igd
                "kelas_rawat" => $request->kelas_rawat, #kelas rawat
                "adl_sub_acute" => "0",
                "adl_chronic" => "0",
                "icu_indikator" => "0",
                "icu_los" => "0",
                "ventilator_hour" => "0",
                // "ventilator" => [
                //     "use_ind" => "1",
                //     "start_dttm" => "2023-01-26 12:55:00",
                //     "stop_dttm" => "2023-01-26 17:50:00"
                // ],
                // "upgrade_class_ind" => "0",
                // "upgrade_class_class" => "0",
                // "upgrade_cla ss_los" => "0",
                // "upgrade_class_payor" => "0",
                // "add_payment_pct" => "0",
                "birth_weight" => "0", #berat bayi
                "sistole" => 120, #detak tensi
                "diastole" => 70, #yg dbawah
                "discharge_status" => "1", #kluar
                "diagnosa" => $request->diagnosa,
                "procedure" => "85.51",
                "diagnosa_inagrouper" => $request->diagnosa_inagrouper,
                "procedure_inagrouper" => $request->procedure_inagrouper,
                "tarif_rs" => [
                    "prosedur_non_bedah" => "0",
                    "prosedur_bedah" => "0",
                    "konsultasi" => "30000",
                    "tenaga_ahli" => "0",
                    "keperawatan" => "0",
                    "penunjang" => "0",
                    "radiologi" => "0",
                    "laboratorium" => "0",
                    "pelayanan_darah" => "0",
                    "rehabilitasi" => "0",
                    "kamar" => "0",
                    "rawat_intensif" => "0",
                    "obat" => "0",
                    "obat_kronis" => "0",
                    "obat_kemoterapi" => "0",
                    "alkes" => "0",
                    "bmhp" => "0",
                    "sewa_alat" => "0"
                ],
                "pemulasaraan_jenazah" => "0",
                "kantong_jenazah" => "0",
                "peti_jenazah" => "0",
                "plastik_erat" => "0",
                "desinfektan_jenazah" => "0",
                "mobil_jenazah" => "0",
                "desinfektan_mobil_jenazah" => "0",
                "covid19_status_cd" => "0",
                "nomor_kartu_t" => "nik",
                "episodes" => "",
                "covid19_cc_ind" => "0",
                "covid19_rs_darurat_ind" => "0",
                "covid19_co_insidense_ind" => "0",
                // "covid19_penunjang_pengurang" => [
                //     "lab_asam_laktat" => "1",
                //     "lab_procalcitonin" => "1",
                //     "lab_crp" => "1",
                //     "lab_kultur" => "1",
                //     "lab_d_dimer" => "1",
                //     "lab_pt" => "1",
                //     "lab_aptt" => "1",
                //     "lab_waktu_pendarahan" => "1",
                //     "lab_anti_hiv" => "1",
                //     "lab_analisa_gas" => "1",
                //     "lab_albumin" => "1",
                //     "rad_thorax_ap_pa" => "0"
                // ],
                "terapi_konvalesen" => "0",
                "akses_naat" => "C",
                // "isoman_ind" => "0",
                "bayi_lahir_status_cd" => 0,
                "dializer_single_use" => "0", #hd setting multiple
                "kantong_darah" => 0,
                // "apgar" => [
                //     "menit_1" =>
                //     [
                //         "appearance" => 1,
                //         "pulse" => 2,
                //         "grimace" => 1,
                //         "activity" => 1,
                //         "respiration" => 1
                //     ],
                //     "menit_5" => [
                //         "appearance" => 2,
                //         "pulse" => 2,
                //         "grimace" => 2,
                //         "activity" => 2,
                //         "respiration" => 2
                //     ],
                // ],
                // "persalinan" => [
                //     "usia_kehamilan" => "22",
                //     "gravida" => "2",
                //     "partus" => "4",
                //     "abortus" => "2",
                //     "onset_kontraksi" => "induksi",
                //     "delivery" => [
                //         [
                //             "delivery_sequence" => "1",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:01:33",
                //             "letak_janin" => "kepala",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "1"
                //         ],
                //         [
                //             "delivery_sequence" => "2",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:03:49",
                //             "letak_janin" => "lintang",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "0"
                //         ]
                //     ]
                // ],
                "tarif_poli_eks" => "#",
                "nama_dokter" => "RUDY, DR",
                "kode_tarif" => "BP",
                "payor_id" => "3",
                "payor_cd" => "JKN",
                // "cob_cd" => "0001",
                "coder_nik" => "123123123123",

            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function claim_ranap_v3(Request $request)
    {
        $request->validate([
            "kodekunjungan" =>  "required",
            "counter" =>  "required",
            "norm" =>  "required",
            "noSEP" =>  "required",
            "diagnosa" =>  "required",
        ]);
        $request['diagnosa'] = $request->diagnosa ? json_encode($request->diagnosa) : null;
        $request['procedure'] = $request->procedure ? json_encode($request->procedure) : null;
        $groupping = ErmGroupping::updateOrCreate(
            [
                'nosep' => $request->noSEP,
                'kode_kunjungan' => $request->kodekunjungan,
                'counter' => $request->counter,
                'nomorkartu' => $request->nomorkartu,
                'norm' => $request->norm,
                'nomorkartu' => $request->nomorkartu,
            ],
            $request->all()
        );
        $diag = null;
        $diag_utama = null;
        $request['diagnosa_utama'] = json_decode($request->diagnosa)[0];
        $request['diagnosa_sekunder'] = array_slice(json_decode($request->diagnosa), 1);
        $request['tgl_pulang'] = now()->format('Y-m-d H:m:s');
        $res = $this->new_claim($request);
        $res = $this->set_claim_ranap_v2($request);
        $res = $this->grouper($request);
        if ($res->metadata->code == 200) {
            $rmcounter = $request->norm . '|' . $request->counter;
            $budget = BudgetControl::updateOrCreate(
                [
                    'rm_counter' => $rmcounter
                ],
                [
                    'tarif_inacbg' => $res->response->cbg->tariff ?? '0',
                    'no_rm' => $request->norm,
                    'counter' => $request->counter,

                    'diagnosa_kode' => $request->diagnosa, #kode
                    'diagnosa_utama' => $diag_utama,
                    'diagnosa' => $diag,
                    'prosedur' => $request->procedure, #kode | deskripsi
                    'kode_cbg' => $res->response->cbg->code . " | " . $res->response->cbg->description,
                    'kelas' => $res->response->kelas,
                    'tgl_grouper' => now(),
                    'tgl_edit' => now(),
                    'deskripsi' => $res->response->cbg->description,
                    "pic" => 1,
                ]
            );
            $groupping->update([
                'code_inacbg' => $res->response->cbg->code,
                'description_inacbg' => $res->response->cbg->description,
                'tarif_inacbg' => $res->response->cbg->tariff ?? '0',
            ]);
            $kunjungan = Kunjungan::find($request->kodekunjungan);
            $kunjungan->update([
                'no_sep' => $request->noSEP,
            ]);
            Alert::success('Success', 'Groupping berhasil (' . $res->response->cbg->description . ')');
        } else {
            Alert::error('Gagal', 'Groupping gagal');
        }
        return redirect()->back();
    }
    public function set_claim_rajal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nomor_sep" =>  "required",
            "nomor_kartu" =>  "required",
            "tgl_masuk" =>  "required|date",
            "cara_masuk" =>  "required",
            "jenis_rawat" =>  "required",
            "kelas_rawat" =>  "required",
            "discharge_status" =>  "required",
            "diagnosa" =>  "required",
            // "procedure" =>  "required",
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }

        $icd10 = $request->diagnosa[0];
        $jumlah_diag = count($request->diagnosa) - 1;
        for ($i = 1; $i  <= $jumlah_diag; $i++) {
            $icd10 = $icd10 . '#' . $request->diagnosa[$i];
        }

        $icd9 = $request->procedure[0];
        $jumlah_diag = count($request->procedure) - 1;
        for ($i = 1; $i  <= $jumlah_diag; $i++) {
            $icd9 = $icd9 . '#' . $request->procedure[$i];
        }

        $request_data = [
            "metadata" => [
                "method" => "set_claim_data",
                "nomor_sep" => $request->nomor_sep,

            ],
            "data" => [
                "nomor_sep" =>  $request->nomor_sep,
                "nomor_kartu" => $request->nomor_kartu,
                "tgl_masuk" => $request->tgl_masuk,
                "tgl_pulang" => $request->tgl_pulang,
                "cara_masuk" => $request->cara_masuk, #isi
                "jenis_rawat" => $request->jenis_rawat, #inap, jalan, igd
                "kelas_rawat" => $request->kelas_rawat, #kelas rawat
                "sistole" =>  $request->sistole, #detak tensi
                "diastole" => $request->diastole, #yg dbawah
                "discharge_status" => $request->discharge_status, #kluar
                "diagnosa" => $icd10,
                "procedure" => $icd9,
                "tarif_rs" => [
                    "prosedur_non_bedah" => "0",
                    "prosedur_bedah" => "0",
                    "konsultasi" => "30000",
                    "tenaga_ahli" => "0",
                    "keperawatan" => "0",
                    "penunjang" => "0",
                    "radiologi" => "0",
                    "laboratorium" => "0",
                    "pelayanan_darah" => "0",
                    "rehabilitasi" => "0",
                    "kamar" => "0",
                    "rawat_intensif" => "0",
                    "obat" => "0",
                    "obat_kronis" => "0",
                    "obat_kemoterapi" => "0",
                    "alkes" => "0",
                    "bmhp" => "0",
                    "sewa_alat" => "0"
                ],
                "nama_dokter" => "RUDY, DR",
                "kode_tarif" => "BP",
                "payor_id" => "3",
                "payor_cd" => "JKN",
                // "cob_cd" => "0001",
                "coder_nik" => "123123123123",
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function set_claim_ranap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "noSEP" =>  "required",
            "nomorkartu" =>  "required",
            "tglmasuk" =>  "required",
            "cara_masuk" =>  "required",
            "kelas_rawat" =>  "required",
            "diagnosa" =>  "required",
            "discharge_status" =>  "required",
            "dokter_dpjp" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $icd10 = $request->diagnosa[0];
        $jumlah_diag = count($request->diagnosa) - 1;
        for ($i = 1; $i  <= $jumlah_diag; $i++) {
            $icd10 = $icd10 . '#' . $request->diagnosa[$i];
        }
        $request['diagnosa'] = $icd10;
        $icd9 = "#";
        if ($request->procedure) {
            $icd9 = $request->procedure[0];
            $jumlah_diag = count($request->procedure) - 1;
            for ($i = 1; $i  <= $jumlah_diag; $i++) {
                $icd9 = $icd9 . '#' . $request->procedure[$i];
            }
        }
        $request['procedure'] = $icd9;
        $request_data = [
            "metadata" => [
                "method" => "set_claim_data",
                "nomor_sep" => $request->noSEP,

            ],
            "data" => [
                "nomor_sep" =>  $request->noSEP,
                "nomor_kartu" => $request->nomorkartu,
                "tgl_masuk" => $request->tglmasuk,
                "tgl_pulang" => $request->tgl_pulang,
                "cara_masuk" => $request->cara_masuk, #isi
                "jenis_rawat" => 1, #inap, jalan, igd
                "kelas_rawat" => $request->kelas_rawat, #kelas rawat
                "adl_sub_acute" => "0",
                "adl_chronic" => "0",
                "icu_indikator" => "0",
                "icu_los" => "0",
                "ventilator_hour" => "0",
                // "ventilator" => [
                //     "use_ind" => "1",
                //     "start_dttm" => "2023-01-26 12:55:00",
                //     "stop_dttm" => "2023-01-26 17:50:00"
                // ],
                // "upgrade_class_ind" => "0",
                // "upgrade_class_class" => "0",
                // "upgrade_cla ss_los" => "0",
                // "upgrade_class_payor" => "0",
                // "add_payment_pct" => "0",
                "birth_weight" => $request->berat_badan, #berat bayi
                "sistole" => $request->sistole, #detak tensi
                "diastole" => $request->diastole, #yg dbawah
                "discharge_status" => $request->discharge_status, #kluar
                "diagnosa" => $icd10,
                "procedure" => $icd9,
                "diagnosa_inagrouper" => $request->diagnosa_inagrouper,
                "procedure_inagrouper" => $request->procedure_inagrouper,
                "tarif_rs" => [
                    "prosedur_non_bedah" => $request->prosedur_non_bedah,
                    "prosedur_bedah" => $request->prosedur_bedah,
                    "konsultasi" => $request->konsultasi,
                    "tenaga_ahli" => $request->tenaga_ahli,
                    "keperawatan" => $request->keperawatan,
                    "penunjang" => $request->penunjang,
                    "radiologi" => $request->radiologi,
                    "laboratorium" => $request->laboratorium,
                    "pelayanan_darah" => $request->pelayanan_darah,
                    "rehabilitasi" => $request->rehabilitasi,
                    "kamar" => $request->kamar_akomodasi,
                    "rawat_intensif" => $request->rawat_intensif,
                    "obat" => $request->obat,
                    "obat_kronis" => $request->obat_kronis,
                    "obat_kemoterapi" => $request->obat_kemoterapi,
                    "alkes" => $request->alkes,
                    "bmhp" => $request->bmhp,
                    "sewa_alat" => $request->sewa_alat,
                ],
                "pemulasaraan_jenazah" => "0",
                "kantong_jenazah" => "0",
                "peti_jenazah" => "0",
                "plastik_erat" => "0",
                "desinfektan_jenazah" => "0",
                "mobil_jenazah" => "0",
                "desinfektan_mobil_jenazah" => "0",
                "covid19_status_cd" => "0",
                "nomor_kartu_t" => "nik",
                "episodes" => "",
                "covid19_cc_ind" => "0",
                "covid19_rs_darurat_ind" => "0",
                "covid19_co_insidense_ind" => "0",
                // "covid19_penunjang_pengurang" => [
                //     "lab_asam_laktat" => "1",
                //     "lab_procalcitonin" => "1",
                //     "lab_crp" => "1",
                //     "lab_kultur" => "1",
                //     "lab_d_dimer" => "1",
                //     "lab_pt" => "1",
                //     "lab_aptt" => "1",
                //     "lab_waktu_pendarahan" => "1",
                //     "lab_anti_hiv" => "1",
                //     "lab_analisa_gas" => "1",
                //     "lab_albumin" => "1",
                //     "rad_thorax_ap_pa" => "0"
                // ],
                "terapi_konvalesen" => "0",
                "akses_naat" => "C",
                // "isoman_ind" => "0",
                "bayi_lahir_status_cd" => 0,
                "dializer_single_use" => "0", #hd setting multiple
                "kantong_darah" => 0,
                // "apgar" => [
                //     "menit_1" =>
                //     [
                //         "appearance" => 1,
                //         "pulse" => 2,
                //         "grimace" => 1,
                //         "activity" => 1,
                //         "respiration" => 1
                //     ],
                //     "menit_5" => [
                //         "appearance" => 2,
                //         "pulse" => 2,
                //         "grimace" => 2,
                //         "activity" => 2,
                //         "respiration" => 2
                //     ],
                // ],
                // "persalinan" => [
                //     "usia_kehamilan" => "22",
                //     "gravida" => "2",
                //     "partus" => "4",
                //     "abortus" => "2",
                //     "onset_kontraksi" => "induksi",
                //     "delivery" => [
                //         [
                //             "delivery_sequence" => "1",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:01:33",
                //             "letak_janin" => "kepala",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "1"
                //         ],
                //         [
                //             "delivery_sequence" => "2",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:03:49",
                //             "letak_janin" => "lintang",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "0"
                //         ]
                //     ]
                // ],
                "tarif_poli_eks" => "#",
                "nama_dokter" => $request->dokter_dpjp,
                "kode_tarif" => "BP",
                "payor_id" => "3",
                "payor_cd" => "JKN",
                // "cob_cd" => "0001",
                "coder_nik" => "123123123123",

            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function set_claim_ranap_v2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "noSEP" =>  "required",
            "nomorkartu" =>  "required",
            "tglmasuk" =>  "required",
            "cara_masuk" =>  "required",
            "kelas_rawat" =>  "required",
            "diagnosa" =>  "required",
            "discharge_status" =>  "required",
            "dokter_dpjp" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $icd10 = explode('|', json_decode($request->diagnosa)[0])[0];
        $jumlah_diag = count(json_decode($request->diagnosa)) - 1;
        for ($i = 1; $i  <= $jumlah_diag; $i++) {
            $icd10 = $icd10 . '#' . explode('|', json_decode($request->diagnosa)[$i])[0];
        }
        $icd9 = "#";
        if ($request->procedure) {
            $icd9 = explode('|', json_decode($request->procedure)[0])[0];
            $jumlah_diag = count(json_decode($request->procedure)) - 1;
            for ($i = 1; $i  <= $jumlah_diag; $i++) {
                $icd9 = $icd9 . '#' . explode('|', json_decode($request->procedure)[$i])[0];
            }
        }
        $request_data = [
            "metadata" => [
                "method" => "set_claim_data",
                "nomor_sep" => $request->noSEP,

            ],
            "data" => [
                "nomor_sep" =>  $request->noSEP,
                "nomor_kartu" => $request->nomorkartu,
                "tgl_masuk" => $request->tglmasuk,
                "tgl_pulang" => $request->tgl_pulang,
                "cara_masuk" => $request->cara_masuk, #isi
                "jenis_rawat" => 1, #inap, jalan, igd
                "kelas_rawat" => $request->kelas_rawat, #kelas rawat
                "adl_sub_acute" => "0",
                "adl_chronic" => "0",
                "icu_indikator" => "0",
                "icu_los" => "0",
                "ventilator_hour" => "0",
                // "ventilator" => [
                //     "use_ind" => "1",
                //     "start_dttm" => "2023-01-26 12:55:00",
                //     "stop_dttm" => "2023-01-26 17:50:00"
                // ],
                // "upgrade_class_ind" => "0",
                // "upgrade_class_class" => "0",
                // "upgrade_cla ss_los" => "0",
                // "upgrade_class_payor" => "0",
                // "add_payment_pct" => "0",
                "birth_weight" => $request->berat_badan, #berat bayi
                "sistole" => $request->sistole ?? 120, #detak tensi
                "diastole" => $request->diastole ?? 80, #yg dbawah
                "discharge_status" => $request->discharge_status, #kluar
                "diagnosa" => $icd10,
                "procedure" => $icd9,
                "diagnosa_inagrouper" => $request->diagnosa_inagrouper,
                "procedure_inagrouper" => $request->procedure_inagrouper,
                "tarif_rs" => [
                    "prosedur_non_bedah" => $request->prosedur_non_bedah,
                    "prosedur_bedah" => $request->prosedur_bedah,
                    "konsultasi" => $request->konsultasi,
                    "tenaga_ahli" => $request->tenaga_ahli,
                    "keperawatan" => $request->keperawatan,
                    "penunjang" => $request->penunjang,
                    "radiologi" => $request->radiologi,
                    "laboratorium" => $request->laboratorium,
                    "pelayanan_darah" => $request->pelayanan_darah,
                    "rehabilitasi" => $request->rehabilitasi,
                    "kamar" => $request->kamar_akomodasi,
                    "rawat_intensif" => $request->rawat_intensif,
                    "obat" => $request->obat,
                    "obat_kronis" => $request->obat_kronis,
                    "obat_kemoterapi" => $request->obat_kemoterapi,
                    "alkes" => $request->alkes,
                    "bmhp" => $request->bmhp,
                    "sewa_alat" => $request->sewa_alat,
                ],
                "pemulasaraan_jenazah" => "0",
                "kantong_jenazah" => "0",
                "peti_jenazah" => "0",
                "plastik_erat" => "0",
                "desinfektan_jenazah" => "0",
                "mobil_jenazah" => "0",
                "desinfektan_mobil_jenazah" => "0",
                "covid19_status_cd" => "0",
                "nomor_kartu_t" => "nik",
                "episodes" => "",
                "covid19_cc_ind" => "0",
                "covid19_rs_darurat_ind" => "0",
                "covid19_co_insidense_ind" => "0",
                // "covid19_penunjang_pengurang" => [
                //     "lab_asam_laktat" => "1",
                //     "lab_procalcitonin" => "1",
                //     "lab_crp" => "1",
                //     "lab_kultur" => "1",
                //     "lab_d_dimer" => "1",
                //     "lab_pt" => "1",
                //     "lab_aptt" => "1",
                //     "lab_waktu_pendarahan" => "1",
                //     "lab_anti_hiv" => "1",
                //     "lab_analisa_gas" => "1",
                //     "lab_albumin" => "1",
                //     "rad_thorax_ap_pa" => "0"
                // ],
                "terapi_konvalesen" => "0",
                "akses_naat" => "C",
                // "isoman_ind" => "0",
                "bayi_lahir_status_cd" => 0,
                "dializer_single_use" => "0", #hd setting multiple
                "kantong_darah" => 0,
                // "apgar" => [
                //     "menit_1" =>
                //     [
                //         "appearance" => 1,
                //         "pulse" => 2,
                //         "grimace" => 1,
                //         "activity" => 1,
                //         "respiration" => 1
                //     ],
                //     "menit_5" => [
                //         "appearance" => 2,
                //         "pulse" => 2,
                //         "grimace" => 2,
                //         "activity" => 2,
                //         "respiration" => 2
                //     ],
                // ],
                // "persalinan" => [
                //     "usia_kehamilan" => "22",
                //     "gravida" => "2",
                //     "partus" => "4",
                //     "abortus" => "2",
                //     "onset_kontraksi" => "induksi",
                //     "delivery" => [
                //         [
                //             "delivery_sequence" => "1",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:01:33",
                //             "letak_janin" => "kepala",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "1"
                //         ],
                //         [
                //             "delivery_sequence" => "2",
                //             "delivery_method" => "vaginal",
                //             "delivery_dttm" => "2023-01-21 17:03:49",
                //             "letak_janin" => "lintang",
                //             "kondisi" => "livebirth",
                //             "use_manual" => "1",
                //             "use_forcep" => "0",
                //             "use_vacuum" => "0"
                //         ]
                //     ]
                // ],
                "tarif_poli_eks" => "#",
                "nama_dokter" => $request->dokter_dpjp,
                "kode_tarif" => "BP",
                "payor_id" => "3",
                "payor_cd" => "JKN",
                // "cob_cd" => "0001",
                "coder_nik" => "123123123123",

            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function grouper(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "noSEP" =>  "required",
            "nomorkartu" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "grouper",
                "stage" => "1",
            ],
            "data" => [
                "nomor_sep" => $request->noSEP,
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function get_claim_data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nomor_sep" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "get_claim_data",
            ],
            "data" => [
                "nomor_sep" => $request->nomor_sep,
            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function get_claim_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nomor_sep" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 400);
        }
        $request_data = [
            "metadata" => [
                "method" => "get_claim_status",
            ],
            "data" => [
                "nomor_sep" => $request->nomor_sep,

            ]
        ];
        $json_request = json_encode($request_data);
        return $this->send_request($json_request);
    }
    public function send_request($json_request)
    {
        // data yang akan dikirimkan dengan method POST adalah encrypted:
        $key = $this->key_eclaim;
        $payload = $this->inacbg_encrypt($json_request, $key);
        // tentukan Content-Type pada http header
        $header = array("Content-Type: application/x-www-form-urlencoded");
        // url server aplikasi E-Klaim,
        // silakan disesuaikan instalasi masing-masing
        $url = "http://192.168.2.210/E-Klaim/ws.php";
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        // request dengan curl
        $response = curl_exec($ch);
        // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
        // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
        $first = strpos($response, "\n") + 1;
        $last = strrpos($response, "\n") - 1;
        $response = substr(
            $response,
            $first,
            strlen($response) - $first - $last
        );
        // decrypt dengan fungsi inacbg_decrypt
        $response = $this->inacbg_decrypt($response, $key);
        // hasil decrypt adalah format json, ditranslate kedalam array
        $msg = json_decode($response);
        return $msg;
    }
    // Encryption Function
    function inacbg_encrypt($data, $key)
    {

        /// make binary representasion of $key
        $key = hex2bin($key);
        /// check key length, must be 256 bit or 32 bytes
        if (mb_strlen($key, "8bit") !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        /// create initialization vector
        $iv_size = openssl_cipher_iv_length("aes-256-cbc");
        $iv = openssl_random_pseudo_bytes($iv_size); // dengan catatan dibawah
        /// encrypt
        $encrypted = openssl_encrypt(
            $data,
            "aes-256-cbc",
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        /// create signature, against padding oracle attacks
        $signature = mb_substr(hash_hmac(
            "sha256",
            $encrypted,
            $key,
            true
        ), 0, 10, "8bit");
        /// combine all, encode, and format
        $encoded = chunk_split(base64_encode($signature . $iv . $encrypted));
        return $encoded;
    }
    // Decryption Function
    function inacbg_decrypt($str, $strkey)
    {
        /// make binary representation of $key
        $key = hex2bin($strkey);
        /// check key length, must be 256 bit or 32 bytes
        if (mb_strlen($key, "8bit") !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        /// calculate iv size
        $iv_size = openssl_cipher_iv_length("aes-256-cbc");
        /// breakdown parts
        $decoded = base64_decode($str);
        $signature = mb_substr($decoded, 0, 10, "8bit");
        $iv = mb_substr($decoded, 10, $iv_size, "8bit");
        $encrypted = mb_substr($decoded, $iv_size + 10, NULL, "8bit");
        /// check signature, against padding oracle attack
        $calc_signature = mb_substr(hash_hmac(
            "sha256",
            $encrypted,
            $key,
            true
        ), 0, 10, "8bit");
        if (!$this->inacbg_compare($signature, $calc_signature)) {
            return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
        }
        $decrypted = openssl_decrypt(
            $encrypted,
            "aes-256-cbc",
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return $decrypted;
    }
    // Compare Function
    function inacbg_compare($a, $b)
    {
        /// compare individually to prevent timing attacks
        /// compare length
        if (strlen($a) !== strlen($b)) return false;

        /// compare individual
        $result = 0;
        for ($i = 0; $i < strlen($a); $i++) {
            $result |= ord($a[$i]) ^ ord($b[$i]);
        }

        return $result == 0;
    }
    public function rincian_biaya_pasien(Request $request)
    {
        $response = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $request->norm . "','" . $request->counter . "','','')"));
        $budget = BudgetControl::find($request->norm . '|' . $request->counter);
        $data = [
            "rincian" => $response,
            "budget" => $budget,
            "pasien" => $budget->pasien ?? null,
            "rangkuman" => [
                "tarif_rs" => round($response->sum("GRANTOTAL_LAYANAN")),
                "prosedur_non_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE NON BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "prosedur_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "tenaga_ahli" => round($response->where('nama_group_vclaim', "TENAGA AHLI")->sum("GRANTOTAL_LAYANAN")),
                "radiologi" => round($response->where('nama_group_vclaim', "RADIOLOGI")->sum("GRANTOTAL_LAYANAN")),
                "laboratorium" => round($response->where('nama_group_vclaim', "LABORATORIUM")->sum("GRANTOTAL_LAYANAN")),
                "rehabilitasi" => round($response->where('nama_group_vclaim', "REHABILITASI MEDIK")->sum("GRANTOTAL_LAYANAN")),
                "sewa_alat" => round($response->where('nama_group_vclaim', "SEWA ALAT")->sum("GRANTOTAL_LAYANAN")),
                "keperawatan" => round($response->where('nama_group_vclaim', "KEPERAWATAN")->sum("GRANTOTAL_LAYANAN")),
                "kamar_akomodasi" => round($response->where('nama_group_vclaim', "KAMAR/AKOMODASI")->sum("GRANTOTAL_LAYANAN")),
                "penunjang" => round($response->where('nama_group_vclaim', "PENUNJANG MEDIS")->sum("GRANTOTAL_LAYANAN")),
                "konsultasi" => round($response->where('nama_group_vclaim', "KONSULTASI")->sum("GRANTOTAL_LAYANAN")),
                "pelayanan_darah" => round($response->where('nama_group_vclaim', "PELAYANAN DARAH")->sum("GRANTOTAL_LAYANAN")),
                "rawat_intensif" => round($response->where('nama_group_vclaim', "RAWAT INTENSIF")->sum("GRANTOTAL_LAYANAN")),
                "obat" => round($response->where('nama_group_vclaim', "OBAT")->sum("GRANTOTAL_LAYANAN")),
                "alkes" => round($response->where('nama_group_vclaim', "ALKES")->sum("GRANTOTAL_LAYANAN")),
                "bmhp" => round($response->where('nama_group_vclaim', "BMHP")->sum("GRANTOTAL_LAYANAN")),
                "obat_kronis" => round($response->where('nama_group_vclaim', "OBAT KRONIS")->sum("GRANTOTAL_LAYANAN")),
                "obat_kemo" => round($response->where('nama_group_vclaim', "OBAT KEMOTERAPI")->sum("GRANTOTAL_LAYANAN")),
            ],
        ];
        return $this->sendResponse($data, 200);
    }
    public function update_claim(Request $request)
    {
        $budget = BudgetControl::find($request->rm_counter);
        $budget->update([
            "status" => $request->status,
            "saran" => $request->saran,
            "pic2" => Auth::user()->id,
        ]);
        return redirect()->back();
    }
}
