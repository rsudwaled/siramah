<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class VclaimController extends APIController
{

    public $baseurl = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";
    public $consid =  "3431";
    public $secrekey = "7fI37884D3";
    public $userkey = "8c4bf16aee4629511617bd55de88b4fe";

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
    public function ref_diagnosa_api2(Request $request)
    {
        $data = array();
        $response = $this->ref_diagnosa($request);
        if ($response->metadata->code == 200) {
            $diagnosa = $response->response->diagnosa;
            foreach ($diagnosa as $item) {
                $data[] = array(
                    "id" => $item->nama,
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
        $kunjungans = null;
        $vclaim = new VclaimController();
        if ($request->tanggal && $request->jenispelayanan) {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)->get(['kode_kunjungan', 'no_sep']);
            $response =  $vclaim->monitoring_data_kunjungan($request);
            if ($response->metadata->code == 200) {
                $sep = $response->response->sep;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($sep) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.monitoring_data_kunjungan_index', compact([
            'request',
            'sep',
            'kunjungans',
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
    public function signature()
    {
        $cons_id =  $this->consid;
        $secretKey = $this->secrekey;
        $userkey = $this->userkey;

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
    public function stringDecrypt($key, $string)
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
            return $this->sendError($message, $code);
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
            "jenispelayanan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Monitoring/Kunjungan/Tanggal/" . $request->tanggal . "/JnsPelayanan/" . $request->jenispelayanan;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Monitoring/Klaim/Tanggal/" . $request->tanggalPulang . "/JnsPelayanan/" . $request->jenisPelayanan . "/Status/" . $request->statusKlaim;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "monitoring/HistoriPelayanan/NoKartu/" . $request->nomorkartu . "/tglMulai/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "monitoring/JasaRaharja/JnsPelayanan/" . $request->jenisPelayanan . "/tglMulai/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir;
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
        $url = $this->baseurl . "Peserta/nokartu/" . $request->nomorkartu . "/tglSEP/" . $request->tanggal;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Peserta/nik/" . $request->nik . "/tglSEP/" . $request->tanggal;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/diagnosa/" . $request->diagnosa;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/poli/" . $request->poliklinik;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/faskes/" . $request->nama . "/" . $request->jenisfaskes;


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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/dokter/pelayanan/" . $request->jenispelayanan . "/tglPelayanan/" . $request->tanggal . "/Spesialis/" . $request->kodespesialis;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_provinsi(Request $request)
    {
        $url = $this->baseurl . "referensi/propinsi";
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/kabupaten/propinsi/" . $request->kodeprovinsi;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/kecamatan/kabupaten/" . $request->kodekabupaten;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_diagnosa_prb(Request $request)
    {
        $url = $this->baseurl . "referensi/diagnosaprb" . $request->kodekabupaten;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_obat_prb(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "obat" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/obatprb/" . $request->obat;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_tindakan(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tindakan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/procedure/" . $request->tindakan;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_kelas_rawat(Request $request)
    {
        $url = $this->baseurl . "referensi/kelasrawat";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_dokter(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "dokter" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "referensi/dokter/" . $request->dokter;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_spesialistik(Request $request)
    {
        $url = $this->baseurl . "referensi/spesialistik";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_ruang_rawat(Request $request)
    {
        $url = $this->baseurl . "referensi/ruangrawat";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_cara_keluar(Request $request)
    {
        $url = $this->baseurl . "referensi/carakeluar";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_pasca_pulang(Request $request)
    {
        $url = $this->baseurl . "referensi/pascapulang";
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
        $url = $this->baseurl . "RencanaKontrol/insert";
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
            "noSEP" => "required",
            "kodeDokter" => "required",
            "poliKontrol" => "required",
            "tglRencanaKontrol" => "required|date",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/Update";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "noSuratKontrol" => $request->noSuratKontrol,
                "noSEP" => $request->noSEP,
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/Delete";
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/noSuratKontrol/" . $request->noSuratKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_peserta(Request $request)
    {
        if ($request->tanggal) {
            $request['bulan'] = Carbon::parse($request->tanggal)->month;
            $request['tahun'] = Carbon::parse($request->tanggal)->year;
            $request['formatfilter'] = 2;
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
        $url = $this->baseurl . "RencanaKontrol/ListRencanaKontrol/Bulan/" . sprintf("%02d", $request->bulan)  . "/Tahun/" . $request->tahun . "/Nokartu/" . $request->nomorkartu . "/filter/" . $request->formatfilter;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/ListRencanaKontrol/tglAwal/" . $request->tanggalMulai . "/tglAkhir/" . $request->tanggalAkhir .  "/filter/" . $request->formatFilter;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_poli(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisKontrol" => "required",
            "nomor" => "required",
            "tglRencanaKontrol" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/ListSpesialistik/JnsKontrol/" . $request->jenisKontrol  . "/nomor/" . $request->nomor . "/TglRencanaKontrol/" . $request->tglRencanaKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function suratkontrol_dokter(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisKontrol" => "required",
            "kodePoli" => "required",
            "tglRencanaKontrol" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "RencanaKontrol/JadwalPraktekDokter/JnsKontrol/" . $request->jenisKontrol . "/KdPoli/" . $request->kodePoli . "/TglRencanaKontrol/" . $request->tglRencanaKontrol;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }

    // SPRI
    public function spri_insert(Request $request)
    {
        $vclaim = new VclaimController();
        $url = env('VCLAIM_URL') . 'RencanaKontrol/InsertSPRI';
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            'request' => [
                "noKartu"       => $request->noKartu,
                "kodeDokter"    => $request->kodeDokter,
                "poliKontrol"   => $request->poliKontrol,
                "tglRencanaKontrol" => $request->tglRencanaKontrol,
                "user"          => $request->user,
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        return $this->response_decrypt($response, $signature);
    }

    public function spri_update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSPRI" => "required",
            "kodeDokter" => "required",
            "poliKontrol" => "required",
            "tglRencanaKontrol" => "required|date",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/UpdateSPRI";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "noSPRI" => $request->noSPRI,
                "kodeDokter" => $request->kodeDokter,
                "poliKontrol" => $request->poliKontrol,
                "tglRencanaKontrol" => $request->tglRencanaKontrol,
                "user" =>  $request->user,
            ]
        ];
        $response = Http::withHeaders($signature)->put($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function spri_delete(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSuratKontrol" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL') . "RencanaKontrol/Delete";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "t_suratkontrol" => [
                    "noSuratKontrol" => $request->noSuratKontrol,
                    "user" => 'RSUD Waled',
                ]
            ]
        ];
        $response = Http::withHeaders($signature)->delete($url, $data);
        return $this->response_decrypt($response, $signature);
    }

    // SEP RANAP
    public function sep_ranap_insert(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            // "asalRujukan" => "required",
            // "tglRujukan" => "required",
            // "noRujukan" => "required",
            // "ppkRujukan" => "required",
            "noKartu" => "required",
            "tglSep" => "required",
            "klsRawatHak" => "required",
            "catatan" => "required",
            "diagAwal" => "required",
            "tujuan" => "required",
            "eksekutif" => "required",
            "tujuanKunj" => "required",
            "dpjpLayan" => "required",
            "noTelp" => "required",
            "user" => "required",

            'tanggal_daftar' => 'required',
            'noSurat' => 'required',
            'kodeDPJP' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $vclaim = new VclaimController();
        $url = env('VCLAIM_URL') . 'SEP/2.0/insert';
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            'request' => [
                't_sep' => [
                    'noKartu' => $request->noKartu,
                    'tglSep' => $request->tanggal_daftar,
                    'ppkPelayanan' => '1018R001',
                    'jnsPelayanan' => '1',
                    'klsRawat' => [
                        'klsRawatHak' => $request->klsRawatHak,
                        'klsRawatNaik' => '',
                        'pembiayaan' => '',
                        'penanggungJawab' => '',
                    ],
                    'noMR' => $request->noMR,
                    'rujukan' => [
                        'asalRujukan' => "",
                        'tglRujukan' => '',
                        'noRujukan' => '',
                        'ppkRujukan' => '',
                    ],
                    'catatan' => '',
                    'diagAwal' => $request->diagAwal,
                    'poli' => [
                        'tujuan' => 'IGD',
                        'eksekutif' => '0',
                    ],
                    'cob' => [
                        'cob' => '0',
                    ],
                    'katarak' => [
                        'katarak' => '0',
                    ],
                    // "lakaLantas":" 0 : Bukan Kecelakaan lalu lintas [BKLL], 1 : KLL dan bukan kecelakaan Kerja [BKK], 2 : KLL dan KK, 3 : KK",
                    'jaminan' => [
                        'lakaLantas' => $request->lakaLantas,
                        'noLP' => $request->noLP == null ? '' : $request->noLP,
                        'penjamin' => [
                            'tglKejadian' => $request->lakaLantas == 0 ? '' : $request->tglKejadian,
                            'keterangan' => $request->keterangan == null ? '' : $request->keterangan,
                            'suplesi' => [
                                'suplesi' => '0',
                                'noSepSuplesi' => '',
                                'lokasiLaka' => [
                                    'kdPropinsi' => $request->provinsi == null ? '' : $request->provinsi,
                                    'kdKabupaten' => $request->kabupaten == null ? '' : $request->kabupaten,
                                    'kdKecamatan' => $request->kecamatan == null ? '' : $request->kecamatan,
                                ],
                            ],
                        ],
                    ],
                    'tujuanKunj' => '0',
                    'flagProcedure' => '',
                    'kdPenunjang' => '',
                    'assesmentPel' => '',
                    'skdp' => [
                        'noSurat' => $request->noSurat,
                        'kodeDPJP' => $request->kodeDPJP,
                    ],
                    'dpjpLayan' => '',
                    'noTelp' => $request->noTelp,
                    'user' => $user,
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    // RUJUKAN
    public function rujukan_nomor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorrujukan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Rujukan/" . $request->nomorrujukan;
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
        $url = $this->baseurl . "Rujukan/List/Peserta/" . $request->nomorkartu;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Rujukan/RS/" . $request->nomorrujukan;
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Rujukan/RS/List/Peserta/" . $request->nomorkartu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function rujukan_jumlah_sep(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "jenisRujukan" => "required",
            "nomorRujukan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "Rujukan/JumlahSEP/" . $request->jenisRujukan . "/" . $request->nomorRujukan;
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
            "tujuan" => "required", #0
            "eksekutif" => "required", #0
            "tujuanKunj" => "required", #0
            // "flagProcedure" => "required", #0
            // "kdPenunjang" => "required", #0
            // "assesmentPel" => "required", #0
            // "noSurat" => "required",
            // "kodeDPJP" => "required",
            "dpjpLayan" => "required",
            "noTelp" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "SEP/2.0/insert";
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
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "SEP/2.0/delete";
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
            return $this->sendError($validator->errors()->first(), 400);
        }

        $url = $this->baseurl . "SEP/" . $request->noSep;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function sep_update_pulang(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
            "statusPulang" => "required",
            "tglPulang" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "SEP/2.0/updtglplg";
        $signature = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            "request" => [
                "t_sep" => [
                    "noSep" => $request->noSep,
                    "statusPulang" => $request->statusPulang,
                    "tglPulang" => $request->tglPulang,
                    "user" => $request->user,
                    "noSuratMeninggal" => $request->noSuratMeninggal,
                    "tglMeninggal" => $request->tglMeninggal,
                    "noLPManual" => $request->noLPManual,
                ]
            ]
        ];
        $response = Http::withHeaders($signature)->put($url, $data);
        return $this->response_decrypt($response, $signature);
    }
    public function sep_internal(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
        ]);
        if ($validator->fails()) {
            $response = [
                'metaData' => [
                    'code' => 400,
                    'message' => $validator->errors()->first(),
                ],
            ];
            return json_decode(json_encode($response));
        }
        $url = $this->baseurl . "SEP/Internal/" . $request->noSep;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)
            ->get($url);
        $response = json_decode($response);
        if ($response->metaData->code == 200) {
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response->response);
            $response->response = json_decode($decrypt);
        }
        return $response;
    }
    public function sep_internal_delete(Request $request)
    {
        // checking request
        $validator = Validator::make(request()->all(), [
            "noSep" => "required",
            "noSurat" => "required",
            "tglRujukanInternal" => "required",
            "kdPoliTuj" => "required",
        ]);
        if ($validator->fails()) {
            return json_decode(json_encode(['metadata' => ['code' => 201, 'message' => $validator->errors()->first(),],]));
        }
        // delete sep
        $url = $this->baseurl . "SEP/Internal/delete";
        $signature = $this->signature();
        $client = new Client();
        $response = $client->request('DELETE', $url, [
            'headers' => $signature,
            'body' => json_encode([
                "request" => [
                    "t_sep" => [
                        "noSep" => $request->noSep,
                        "noSurat" => $request->noSurat,
                        "tglRujukanInternal" => $request->tglRujukanInternal,
                        "kdPoliTuj" => $request->kdPoliTuj,
                        "user" => "RSUD Waled",
                    ]
                ]
            ]),
        ]);
        $response = json_decode($response->getBody());
        if ($response->metaData->code == 200) {
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response->response);
            $response->response = json_decode($decrypt);
        }
        return $response;
    }
    public function sepInternal(Request $request)
    {
        $sepinternals = null;
        if ($request->nomorsep) {
            $request['noSep'] = $request->nomorsep;
            $sepinternals = $this->sep_internal($request);
            // dd($request->all(), $sepinternals);
        }
        return view('bpjs.vclaim.sep_internal', [
            'request' => $request,
            'sepinternals' => $sepinternals,
        ]);
    }
    public function sepInternalDelete(Request $request)
    {
        $response = $this->sep_internal_delete($request);
        if ($response->metaData->code == 200) {
            Alert::success('Success', 'Data berhasil dihapus. ' . $response->metaData->message);
        } else {
            Alert::error('Error', 'Data gagal dihapus. ' .  $response->metaData->message);
        }
        return redirect()->back();
    }
}
