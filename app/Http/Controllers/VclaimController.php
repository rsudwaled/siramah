<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class VclaimController extends APIController
{

    public function cekRujukanPeserta(Request $request)
    {
        $rujukans = null;
        $base = new BaseController();

        $res =  $this->rujukan_peserta($request);
        if ($res->metadata->code == 200) {
            $rujukanx = $res->response->rujukan;
            foreach ($rujukanx as  $value) {
                if (Carbon::parse($value->tglKunjungan)->diffInDays(now()) < 90) {
                    $rujukans[] = $value;
                }
                if ($rujukans) {
                    // dd($res, $value->tglKunjungan, $rujukans);
                    return $base->sendResponse($rujukans, 200);
                } else {
                    return $base->sendError('Rujukan telah kadaluarsa semua', 404);
                }
            }
        } else {
            return $base->sendError($res->metadata->message, 400);
        }
    }

    public function cekRujukanRSPeserta(Request $request)
    {
        $rujukans = null;
        $base = new BaseController();

        $res =  $this->rujukan_rs_peserta($request);
        if ($res->metadata->code == 200) {
            $rujukanx = $res->response->rujukan;
            foreach ($rujukanx as  $value) {
                if (Carbon::parse($value->tglKunjungan)->diffInDays(now()) < 90) {
                    $rujukans[] = $value;
                }
                if ($rujukans) {
                    // dd($res, $value->tglKunjungan, $rujukans);
                    return $base->sendResponse($rujukans, 200);
                } else {
                    return $base->sendError('Rujukan telah kadaluarsa semua', 404);
                }
            }
        } else {
            return $base->sendError($res->metadata->message, 400);
        }
    }
    public function cekSuratKontrolPeserta(Request $request)
    {
        $rujukans = null;
        $base = new BaseController();

        $request['bulan'] = Carbon::parse($request->tanggal)->month;
        $request['tahun'] = Carbon::parse($request->tanggal)->year;
        $request['formatfilter'] = 2;
        $res =  $this->suratkontrol_peserta($request);
        if ($res->metadata->code == 200) {
            $suratkontrols = $res->response->list;
            return $base->sendResponse($suratkontrols, 200);
        } else {
            return $base->sendError($res->metadata->message, 400);
        }
    }
    public function referensiVclaim(Request $request)
    {
        return view('bpjs.vclaim.referensi_index', compact([
            'request',
        ]));
    }
    public function ref_diagnosa_api(Request $request)
    {
        $data = array();
        $response = $this->ref_diagnosa($request);
        if ($response->metadata->code == 200) {
            $diagnosa = $response->response->diagnosa;
            foreach ($diagnosa as $item) {
                $data[] = array(
                    "id" => $item->kode,
                    "text" => $item->nama
                );
            }
        }
        return response()->json($data);
    }
    public function ref_poliklinik_api(Request $request)
    {
        $data = array();
        $response = $this->ref_poliklinik($request);
        if ($response->metadata->code == 200) {
            $poli = $response->response->poli;
            foreach ($poli as $item) {
                $data[] = array(
                    "id" => $item->kode,
                    "text" => $item->nama . " (" . $item->kode . ")"
                );
            }
        }
        return response()->json($data);
    }
    public function ref_faskes_api(Request $request)
    {
        $data = array();
        $response = $this->ref_faskes($request);
        if ($response->metadata->code == 200) {
            $faskes = $response->response->faskes;
            foreach ($faskes as $item) {
                $data[] = array(
                    "id" => $item->kode,
                    "text" => $item->nama . " (" . $item->kode . ")"
                );
            }
        }
        return response()->json($data);
    }
    public function ref_dpjp_api(Request $request)
    {
        $data = array();
        $response = $this->ref_dpjp($request);
        if ($response->metadata->code == 200) {
            $dokter = $response->response->list;
            foreach ($dokter as $item) {
                if ((strpos(strtoupper($item->nama), strtoupper($request->nama)) !== false)) {
                    $data[] = array(
                        "id" => $item->kode,
                        "text" => $item->nama . " (" . $item->kode . ")"
                    );
                }
            }
        }
        return response()->json($data);
    }
    public function ref_provinsi_api(Request $request)
    {
        $data = array();
        $response = $this->ref_provinsi($request);
        if ($response->metadata->code == 200) {
            $provinsi = $response->response->list;
            foreach ($provinsi as $item) {
                if ((strpos(strtoupper($item->nama), strtoupper($request->nama)) !== false)) {
                    $data[] = array(
                        "id" => $item->kode,
                        "text" => $item->nama . " (" . $item->kode . ")"
                    );
                }
            }
        }
        return response()->json($data);
    }
    public function ref_kabupaten_api(Request $request)
    {
        $data = array();
        $response = $this->ref_kabupaten($request);
        if ($response->metadata->code == 200) {
            $kabupaten = $response->response->list;
            foreach ($kabupaten as $item) {
                if ((strpos(strtoupper($item->nama), strtoupper($request->nama)) !== false)) {
                    $data[] = array(
                        "id" => $item->kode,
                        "text" => $item->nama . " (" . $item->kode . ")"
                    );
                }
            }
        }
        return response()->json($data);
    }
    public function ref_kecamatan_api(Request $request)
    {
        $data = array();
        $response = $this->ref_kecamatan($request);
        if ($response->metadata->code == 200) {
            $kecamatan = $response->response->list;
            foreach ($kecamatan as $item) {
                if ((strpos(strtoupper($item->nama), strtoupper($request->nama)) !== false)) {
                    $data[] = array(
                        "id" => $item->kode,
                        "text" => $item->nama . " (" . $item->kode . ")"
                    );
                }
            }
        }
        return response()->json($data);
    }
    public function monitoringDataKunjungan(Request $request)
    {
        $sep = null;
        $vclaim = new VclaimController();
        if ($request->tanggal && $request->jenisPelayanan) {
            $response =  $vclaim->monitoring_data_kunjungan($request);
            if ($response->metadata->code == 200) {
                $sep = $response->response->sep;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($sep) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.monitoring_data_kunjungan_index', compact([
            'request', 'sep'
        ]));
    }
    public function monitoringDataKlaim(Request $request)
    {
        $klaim = null;
        $vclaim = new VclaimController();
        if ($request->tanggalPulang && $request->jenisPelayanan && $request->statusKlaim) {
            $response =   $vclaim->monitoring_data_klaim($request);
            if ($response->metadata->code == 200) {
                $klaim = $response->response->klaim;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($klaim) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.monitoring_data_klaim_index', compact([
            'request', 'klaim'
        ]));
    }
    public function monitoringPelayananPeserta(Request $request)
    {
        $peserta = null;
        $sep = null;
        $rujukan = null;
        $rujukan_rs = null;
        $surat_kontrol = null;
        $vclaim = new VclaimController();
        // get  peserta
        if ($request->tanggal) {
            if ($request->nik && $request->tanggal) {
                $response =  $vclaim->peserta_nik($request);
                if ($response->metadata->code == 200) {
                    $peserta = $response->response->peserta;
                    $request['nomorkartu'] = $peserta->noKartu;
                    Alert::success('OK', 'Peserta Ditemukan');
                } else {
                }
            } else if ($request->nomorkartu && $request->tanggal) {
                $response =  $vclaim->peserta_nomorkartu($request);
                if ($response->metadata->code == 200) {
                    $peserta = $response->response->peserta;
                    $request['nik'] = $peserta->nik;
                    Alert::success('OK', 'Peserta Ditemukan');
                } else {
                    Alert::error('Error', $response->metadata->message);
                }
            }
        } else {
            $request['tanggal'] = now()->format('Y-m-d');
        }

        // get data
        if (isset($peserta)) {
            $request['tanggalAkhir'] = Carbon::parse($request->tanggal)->format('Y-m-d');
            $request['tanggalMulai'] = Carbon::parse($request->tanggalAkhir)->subDays(90)->format('Y-m-d');
            // history sep

            $response = $vclaim->monitoring_pelayanan_peserta($request);
            if ($response->metadata->code == 200) {
                $sep = $response->response->histori;
            }
            // rujukan fktp

            $response = $vclaim->rujukan_peserta($request);
            if ($response->metadata->code == 200) {
                $rujukan = $response->response->rujukan;
            }

            // rujukan antar rs
            $response = $vclaim->rujukan_rs_peserta($request);
            if ($response->metadata->code == 200) {
                $rujukan_rs = $response->response->rujukan;
            }

            // rujukan antar rs
            $request['tahun'] = Carbon::parse($request->tanggal)->format('Y');
            $request['bulan'] = Carbon::parse($request->tanggal)->format('m');
            $request['formatfilter'] = 2;
            $response = $vclaim->suratkontrol_peserta($request);
            if ($response->metadata->code == 200) {
                $surat_kontrol = $response->response->list;
            }
        }

        return view('bpjs.vclaim.monitoring_pelayanan_peserta_index', compact([
            'request',
            'peserta',
            'sep',
            'rujukan',
            'rujukan_rs',
            'surat_kontrol',
        ]));
    }
    public function monitoringKlaimJasaraharja(Request $request)
    {
        $klaim = null;
        $vclaim = new VclaimController();

        if ($request->tanggal && $request->jenisPelayanan) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalMulai'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalAkhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $response =  $vclaim->monitoring_klaim_jasaraharja($request);
            if ($response->metadata->code == 200) {
                if ($response->response) {
                    $klaim = $response->response->jaminan;
                    Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($klaim) . ' Pasien');
                } else {
                    Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
                }
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.monitoring_klaim_jasaraharja_index', compact([
            'request', 'klaim'
        ]));
    }

    // API VCLAIM
    public static function signature()
    {
        $cons_id =  env('VCLAIM_CONS_ID');
        $secretKey = env('VCLAIM_SECRET_KEY');
        $userkey = env('VCLAIM_USER_KEY');

        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $cons_id . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);

        $response = array(
            'user_key' => $userkey,
            'x-cons-id' => $cons_id,
            'x-timestamp' => $tStamp,
            'x-signature' => $encodedSignature,
            'decrypt_key' => $cons_id . $secretKey . $tStamp,
        );
        return $response;
    }
    public static function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }
    public function response_decrypt($response, $signature)
    {
        $code = json_decode($response->body())->metaData->code;
        $message = json_decode($response->body())->metaData->message;
        if ($code == 200 || $code == 1) {
            $response = json_decode($response->body())->response ?? null;
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response);
            $data = json_decode($decrypt);
            if ($code == 1)
                $code = 200;
            return $this->sendResponse($data, $code);
        } else {
            return $this->sendError($message,$code);
        }
    }
    public function response_no_decrypt($response)
    {
        $code = json_decode($response->body())->metaData->code;
        $message = json_decode($response->body())->metaData->message;
        $response = json_decode($response->body())->metaData->response;
        $response = [
            'response' => $response,
            'metadata' => [
                'message' => $message,
                'code' => $code,
            ],
        ];
        return json_decode(json_encode($response));
    }
    // MONITORING
    public function monitoring_data_kunjungan(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggal" => "required|date",
            "jenisPelayanan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Monitoring/Kunjungan/Tanggal/" . $request->tanggal . "/JnsPelayanan/" . $request->jenisPelayanan;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function monitoring_data_klaim(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggalPulang" => "required|date",
            "jenisPelayanan" => "required",
            "statusKlaim" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Monitoring/Klaim/Tanggal/" . $request->tanggalPulang . "/JnsPelayanan/" . $request->jenisPelayanan . "/Status/" . $request->statusKlaim;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function monitoring_pelayanan_peserta(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required",
            "tanggalMulai" => "required|date",
            "tanggalAkhir" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "monitoring/HistoriPelayanan/NoKartu/" . $request->nomorkartu . "/tglMulai/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function monitoring_klaim_jasaraharja(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisPelayanan" => "required",
            "tanggalMulai" => "required|date",
            "tanggalAkhir" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "monitoring/JasaRaharja/JnsPelayanan/" . $request->jenisPelayanan . "/tglMulai/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // PESERTA
    public function peserta_nomorkartu(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required",
            "tanggal" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "Peserta/nokartu/" . $request->nomorkartu . "/tglSEP/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function peserta_nik(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nik" => "required",
            "tanggal" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Peserta/nik/" . $request->nik . "/tglSEP/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // REFERENSI
    public function ref_diagnosa(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "diagnosa" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/diagnosa/" . $request->diagnosa;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_poliklinik(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "poliklinik" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/poli/" . $request->poliklinik;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_faskes(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nama" => "required",
            "jenisfaskes" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/faskes/" . $request->nama . "/" . $request->jenisfaskes;


        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_dpjp(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenispelayanan" => "required",
            "tanggal" => "required|date",
            "kodespesialis" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/dokter/pelayanan/" . $request->jenispelayanan . "/tglPelayanan/" . $request->tanggal . "/Spesialis/" . $request->kodespesialis;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_provinsi(Request $request)
    {
        $url = env('VCLAIM_URL') . "referensi/propinsi";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_kabupaten(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodeprovinsi" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/kabupaten/propinsi/" . $request->kodeprovinsi;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_kecamatan(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodekabupaten" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "referensi/kecamatan/kabupaten/" . $request->kodekabupaten;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // RENCANA KONTROL
    public function suratkontrol_insert(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
            "tglRencanaKontrol" => "required|date",
            "kodeDokter" => "required",
            "poliKontrol" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/insert";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "noSEP" => $request->noSep,
                "tglRencanaKontrol" => $request->tglRencanaKontrol,
                "poliKontrol" => $request->poliKontrol,
                "kodeDokter" => $request->kodeDokter,
                "user" =>  $request->user,
            ]
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSuratKontrol" => "required",
            "noSep" => "required",
            "kodeDokter" => "required",
            "poliKontrol" => "required",
            "tglRencanaKontrol" => "required|date",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/Update";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "noSuratKontrol" => $request->noSuratKontrol,
                "noSEP" => $request->noSep,
                "kodeDokter" => $request->kodeDokter,
                "poliKontrol" => $request->poliKontrol,
                "tglRencanaKontrol" => $request->tglRencanaKontrol,
                "user" =>  $request->user,
            ]
        ];
        $response = Http::withHeaders($signature)->put($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_delete(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSuratKontrol" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/Delete";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "t_suratkontrol" => [
                    "noSuratKontrol" => $request->noSuratKontrol,
                    "user" =>  $request->user,
                ]
            ]
        ];
        $response = Http::withHeaders($signature)->delete($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_nomor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSuratKontrol" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/noSuratKontrol/" . $request->noSuratKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_peserta(Request $request)
    {
        if ($request->tanggal) {
            $request['bulan'] = Carbon::parse($request->tanggal)->month;
            $request['tahun'] = Carbon::parse($request->tanggal)->year;
            $request['formatfilter'] =2;
        }
        $validator = Validator::make(request()->all(), [
            "bulan" => "required",
            "tahun" => "required",
            "nomorkartu" => "required",
            "formatfilter" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/ListRencanaKontrol/Bulan/" . sprintf("%02d", $request->bulan)  . "/Tahun/" . $request->tahun . "/Nokartu/" . $request->nomorkartu . "/filter/" . $request->formatfilter;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_tanggal(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggalMulai" => "required|date",
            "tanggalAkhir" => "required|date",
            "formatFilter" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/ListRencanaKontrol/tglAwal/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir .  "/filter/" . $request->formatFilter;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_poli(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisKontrol" => "required",
            "nomor" => "required",
            "tanggalKontrol" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/ListSpesialistik/JnsKontrol/" . $request->jenisKontrol  . "/nomor/" . $request->nomor . "/TglRencanaKontrol/" . $request->tanggalKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_dokter(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisKontrol" => "required",
            "kodePoli" => "required",
            "tanggalKontrol" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/JadwalPraktekDokter/JnsKontrol/" . $request->jenisKontrol . "/KdPoli/" . $request->kodePoli . "/TglRencanaKontrol/" . $request->tanggalKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // RUJUKAN
    public function rujukan_nomor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorrujukan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Rujukan/" . $request->nomorrujukan;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function rujukan_peserta(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "Rujukan/List/Peserta/" . $request->nomorkartu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function rujukan_rs_nomor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorrujukan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Rujukan/RS/" . $request->nomorrujukan;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function rujukan_rs_peserta(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "Rujukan/RS/List/Peserta/" . $request->nomorkartu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function rujukan_jumlah_sep(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "jenisRujukan" => "required",
            "nomorrujukan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "Rujukan/JumlahSEP/" . $request->jenisRujukan . "/" . $request->nomorrujukan;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // SEP
    public function sep_insert(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noKartu" => "required",
            "tglSep" => "required",
            "ppkPelayanan" => "required",
            "jnsPelayanan" => "required",
            "klsRawatHak" => "required",
            "asalRujukan" => "required",
            "tglRujukan" => "required",
            "noRujukan" => "required",
            "ppkRujukan" => "required",
            "catatan" => "required",
            "diagAwal" => "required",
            "tujuan" => "required",
            "eksekutif" => "required",
            "tujuanKunj" => "required",
            // "flagProcedure" => "required",
            // "kdPenunjang" => "required",
            // "assesmentPel" => "required",
            // "noSurat" => "required",
            // "kodeDPJP" => "required",
            "dpjpLayan" => "required",
            "noTelp" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "SEP/2.0/insert";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "t_sep" => [
                    "noKartu" => $request->noKartu,
                    "tglSep" => $request->tglSep,
                    "ppkPelayanan" => $request->ppkPelayanan,
                    "jnsPelayanan" => $request->jnsPelayanan,
                    "klsRawat" => [
                        "klsRawatHak" => $request->klsRawatHak,
                        "klsRawatNaik" => "",
                        "pembiayaan" => "",
                        "penanggungJawab" => "",
                    ],
                    "noMR" => $request->noMR,
                    "rujukan" => [
                        "asalRujukan" =>  $request->asalRujukan,
                        "tglRujukan" =>  $request->tglRujukan,
                        "noRujukan" =>  $request->noRujukan,
                        "ppkRujukan" =>  $request->ppkRujukan,
                    ],
                    "catatan" => $request->catatan,
                    "diagAwal" => $request->diagAwal,
                    "poli" => [
                        "tujuan" => $request->tujuan,
                        "eksekutif" => $request->eksekutif,
                    ],
                    "cob" => [
                        "cob" => "0"
                    ],
                    "katarak" => [
                        "katarak" => "0"
                    ],
                    "jaminan" => [
                        "lakaLantas" => "0",
                        "noLP" => "",
                        "penjamin" => [
                            "tglKejadian" => "",
                            "keterangan" => "",
                            "suplesi" => [
                                "suplesi" => "0",
                                "noSepSuplesi" => "",
                                "lokasiLaka" => [
                                    "kdPropinsi" => "",
                                    "kdKabupaten" => "",
                                    "kdKecamatan" => "",
                                ]
                            ]
                        ]
                    ],
                    "tujuanKunj" => $request->tujuanKunj,
                    "flagProcedure" => $request->flagProcedure,
                    "kdPenunjang" => $request->kdPenunjang,
                    "assesmentPel" => $request->assesmentPel,
                    "skdp" => [
                        "noSurat" => $request->noSurat,
                        "kodeDPJP" => $request->kodeDPJP,
                    ],
                    "dpjpLayan" => $request->dpjpLayan,
                    "noTelp" => $request->noTelp,
                    "user" =>  $request->user,
                ]
            ]
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function sep_delete(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        $url = env('VCLAIM_URL') . "SEP/2.0/delete";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "t_sep" => [
                    "noSep" => $request->noSep,
                    "user" => 'RSUD Waled',
                ]
            ]
        ];
        $response = Http::withHeaders($signature)->delete($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function sep_nomor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }

        $url = env('VCLAIM_URL') . "SEP/" . $request->noSep;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
}
