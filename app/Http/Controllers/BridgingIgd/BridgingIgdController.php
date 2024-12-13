<?php

namespace App\Http\Controllers\BridgingIgd;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Spri;
use App\Models\Icd10;
use App\Models\HistoriesIGDBPJS;
use Carbon\Carbon;
use PDF;

class BridgingIgdController extends APIController
{
     // API FUNCTION
     public function signature()
     {
         $cons_id        = env('ANTRIAN_CONS_ID');
         $secretKey      = env('ANTRIAN_SECRET_KEY');
         $userkey        = env('ANTRIAN_USER_KEY');
         date_default_timezone_set('UTC');
         $tStamp                 = strval(time() - strtotime('1970-01-01 00:00:00'));
         $signature              = hash_hmac('sha256', $cons_id . '&' . $tStamp, $secretKey, true);
         $encodedSignature       = base64_encode($signature);
         $data['user_key']       = $userkey;
         $data['x-cons-id']      = $cons_id;
         $data['x-timestamp']    = $tStamp;
         $data['x-signature']    = $encodedSignature;
         $data['decrypt_key']    = $cons_id . $secretKey . $tStamp;
         return $data;
     }

     public static function stringDecrypt($key, $string)
     {
         $encrypt_method = 'AES-256-CBC';
         $key_hash       = hex2bin(hash('sha256', $key));
         $iv             = substr(hex2bin(hash('sha256', $key)), 0, 16);
         $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
         $output         = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
         return $output;
     }

     public function response_decrypt($response, $signature)
     {
         $code       = json_decode($response->body())->metaData->code;
         $message    = json_decode($response->body())->metaData->message;
         if ($code == 200 || $code == 1) {
             $response   = json_decode($response->body())->response ?? null;
             $decrypt    = $this->stringDecrypt($signature['decrypt_key'], $response);
             $data = json_decode($decrypt);
             if ($code == 1) {
                 $code = 200;
             }
             return $this->sendResponse($data, $code);
         } else {
             return $this->sendError($message, $code);
         }
     }

     public function response_no_decrypt($response)
     {
         $code       = json_decode($response->body())->metaData->code;
         $message    = json_decode($response->body())->metaData->message;
         $response   = json_decode($response->body())->metaData->response;
         $response = [
             'response' => $response,
             'metadata' => [
                 'message' => $message,
                 'code' => $code,
             ],
         ];
         return json_decode(json_encode($response));
     }

    public function listRawatInap(Request $request)
    {
        $start  = $request->start;
        $finish = $request->finish;
        // Buat query dasar dengan relasi yang dibutuhkan
        $query = Kunjungan::with(['bpjsCheckHistories', 'pasien', 'unit'])
        ->whereIn('is_ranap_daftar', ['1', '2', '3']);
        if (
            !empty($request->nik) || !empty($request->nomorkartu) || !empty($request->rm) || !empty($request->nama) ||
            !empty($request->cari_desa) || !empty($request->cari_kecamatan)
        ){
            $search = Pasien::query()
                ->when($request->nik, function ($query, $nik) {
                    $query->where('nik_bpjs', 'LIKE', '%' . $nik . '%');
                })
                ->when($request->nomorkartu, function ($query, $bpjsNumber) {
                    $query->where('no_Bpjs', 'LIKE', '%' . $bpjsNumber . '%');
                })
                ->when($request->nama, function ($query, $name) {
                    $query->where('nama_px', 'LIKE', '%' . $name . '%');
                })
                ->when($request->rm, function ($query, $mrn) {
                    $query->where('no_rm', 'LIKE', '%' . $mrn . '%');
                })
                ->when($request->cari_desa, function ($query, $villageName) {
                    $query->whereHas('lokasiDesa', function ($query) use ($villageName) {
                        $query->where('name', 'LIKE', '%' . $villageName . '%');
                    });
                })
                ->when($request->cari_kecamatan, function ($query, $districtName) {
                    $query->whereHas('lokasiKecamatan', function ($query) use ($districtName) {
                        $query->where('name', 'LIKE', '%' . $districtName . '%');
                    });
                });

            if ($search->exists()) {
                $pasien = $search->get()->pluck('no_rm')->toArray();

            if (!empty($pasien)) {
                    $kunjungan = $query->where('status_kunjungan', 1)
                        ->whereIn('no_rm', $pasien)
                        ->get();
                } else {
                    $kunjungan = collect(); // Return empty collection if no matching pasien found
                }
            } else {
                if ($start && $finish) {
                    $startDate = Carbon::parse($start)->startOfDay();
                    $endDate = Carbon::parse($finish)->endOfDay();
                    $query->whereBetween('tgl_masuk', [$startDate, $endDate]);
                } elseif (empty($start) && empty($finish)) {
                    $query->whereDate('tgl_masuk', now());
                }

                $kunjungan = $query->where('status_kunjungan', 1)->get();
            }
        }else{
            if ($start && $finish) {
                $startDate = Carbon::parse($start)->startOfDay();
                $endDate = Carbon::parse($finish)->endOfDay();
                $query->whereBetween('tgl_masuk', [$startDate, $endDate]);
            } elseif (empty($start) && empty($finish)) {
                $query->whereDate('tgl_masuk', now());
            }

            $kunjungan = $query->where('status_kunjungan', 1)->get();
        }
        return view('simrs.igd.bridging_bpjs.list_pasien_rawat_inap', compact('request','kunjungan'));
    }

    public function updateDiagKunjungan(Request $request)
    {

        $kunjungan = Kunjungan::with(['bpjsCheckHistories', 'pasien'])
        ->where('kode_kunjungan', $request->kode_update)
        ->first();

        if ($kunjungan) {
            $diagnosa_ts = Icd10::where('diag', $request->diagAwal)->first();
            if ($diagnosa_ts) {
                $kunjungan->diagx = $diagnosa_ts->diag . ' | ' . $diagnosa_ts->nama;
            }

            if ($kunjungan->bpjsCheckHistories && $kunjungan->pasien) {
                $kunjungan->bpjsCheckHistories->noKartu     = $kunjungan->pasien->no_Bpjs;
                $kunjungan->bpjsCheckHistories->diagAwal    = $diagnosa_ts->diag;
                $kunjungan->bpjsCheckHistories->save();
            }
            $kunjungan->save();
            return back();
        }
    }

    public function createSpri(Request $request)
    {
        $vclaim     = new VclaimController();
        $response   = $vclaim->spri_insert($request);
        if ($response->metadata->code == 200) {
            $spri = $response->response;
            $cekSPRI = Spri::where('kunjungan', $request->kodeKunjungan)->first();
            if(!empty($cekSPRI))
            {
                $cekSPRI->noSPRI            = $spri->noSPRI;
                $cekSPRI->tglRencanaKontrol = $spri->tglRencanaKontrol;
                $cekSPRI->save();
            }else{
                Spri::create([
                    'kunjungan'         => $request->kodeKunjungan,
                    'noSPRI'            => $spri->noSPRI,
                    'tglRencanaKontrol' => $spri->tglRencanaKontrol,
                    'namaDokter'        => $spri->namaDokter,
                    'noKartu'           => $spri->noKartu,
                    'nama'              => $spri->nama,
                    'kelamin'           => $spri->kelamin,
                    'tglLahir'          => $spri->tglLahir,
                    'namaDiagnosa'      => $spri->namaDiagnosa,

                    'kodeDokter'        => $request->kodeDokter,
                    'poliKontrol'       => $request->poliKontrol,
                    'user'              => $request->user,
                ]);
            }
            $kunjungan          = Kunjungan::where('kode_kunjungan', $request->kodeKunjungan)->first();
            $kunjungan->no_spri = $spri->noSPRI;
            $kunjungan->save();
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return $response;
    }

    public function deleteSPRI(Request $request)
    {

        $vclaim     = new VclaimController();
        $response   = $vclaim->spri_delete($request);
        if ($response->metadata->code == 200) {
            $cekSPRI    = Spri::firstWhere('noSPRI', $request->noSuratKontrol);
            if($cekSPRI)
            {
                $cekSPRI->noSPRI = Null;
                $cekSPRI->save();
            }

            $kunjungan          = Kunjungan::where('no_spri', $request->noSuratKontrol)->first();
            $kunjungan->no_spri = NULL;
            $kunjungan->save();
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return $response;
    }
    public function createSEPRanap(Request $request)
    {
        $url = env('VCLAIM_URL') . "Peserta/nokartu/" . $request->noKartu . "/tglSEP/" . $request->tglSep;
        $signatureCekStatus         = $this->signature();
        $responseCekStatus          = Http::withHeaders($signatureCekStatus)->get($url);
        $resdescrtiptCekStatus      = $this->response_decrypt($responseCekStatus, $signatureCekStatus);

        $kunjungan      = Kunjungan::firstWhere('kode_kunjungan', $request->kode_kunjungan);
        $spri           = Spri::firstWhere('kunjungan', $request->kode_kunjungan);
        $diagnosa_ts    = Icd10::where('diag', $request->diagAwal)->first();

        $url        = env('VCLAIM_URL') . 'SEP/2.0/insert';
        $signature  = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            'request' => [
                't_sep' => [
                    'noKartu'               => trim($request->noKartu??$kunjungan->pasien->no_Bpjs),
                    'tglSep'                => $request->tglSep,
                    'ppkPelayanan'          => '1018R001',
                    'jnsPelayanan'          => 1,
                    'klsRawat'      => [
                        'klsRawatHak'       => $resdescrtiptCekStatus->response->peserta->hakKelas->kode ?? null,
                        'klsRawatNaik'      => '',
                        'pembiayaan'        => '',
                        'penanggungJawab'   => '',
                    ],
                    'noMR'                  => $request->noMR,
                    'rujukan'   => [
                        'asalRujukan'       => 2,
                        'tglRujukan'        => $request->tglSep,
                        'noRujukan'         => $spri->noSPRI??'',
                        'ppkRujukan'        => '1018R001',
                    ],
                    'catatan'               => '',
                    'diagAwal'              => $request->diagAwal??Null,
                    'poli'      => [
                        'tujuan'    => '',
                        'eksekutif' => '0',
                    ],
                    'cob' => [
                        'cob' => '0',
                    ],
                    'katarak' => [
                        'katarak' => '0',
                    ],
                    'jaminan' => [
                        'lakaLantas'        => 0,
                        'noLP'              => '',
                        'penjamin'          => [
                            'tglKejadian'   => '',
                            'keterangan'    => '',
                            'suplesi'       => [
                                'suplesi'           => '0',
                                'noSepSuplesi'      => '',
                                'lokasiLaka'    => [
                                    'kdPropinsi'    => '',
                                    'kdKabupaten'   => '',
                                    'kdKecamatan'   => '',
                                ],
                            ],
                        ],
                    ],
                    'tujuanKunj'    => '0',
                    'flagProcedure' => '',
                    'kdPenunjang'   => '',
                    'assesmentPel'  => '',
                    'skdp' => [
                        'noSurat'   => $spri->noSPRI??'',
                        'kodeDPJP'  => $spri->kodeDokter??'',
                    ],
                    'dpjpLayan' => '',
                    'noTelp'    => !empty($kunjungan->pasien->no_hp) ? $kunjungan->pasien->no_hp : (!empty($kunjungan->pasien->no_tlp) ? $kunjungan->pasien->no_tlp : '000000000000'),
                    'user'      => 'RSUD WALED',
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $resdescrtipt   = $this->response_decrypt($response, $signature);
            $sep            = $resdescrtipt->response->sep->noSep;

            if ($diagnosa_ts) {
                $kunjungan->diagx = $diagnosa_ts->diag . ' | ' . $diagnosa_ts->nama;
            }
            $kunjungan->no_sep = $sep;
            if($kunjungan->save())
            {
                HistoriesIGDBPJS::updateOrCreate(
                    [
                        'kode_kunjungan'  => $kunjungan->kode_kunjungan,
                        'noMR'            => $kunjungan->pasien->no_rm,
                        'jnsPelayanan'    => 1,
                        'tglSep'          => now()->toDateString(),
                    ],
                    [
                        'noKartu'         => trim($kunjungan->pasien->no_Bpjs) ?? null,
                        'ppkPelayanan'    => '1018R001',
                        'dpjpLayan'       => $spri->kodeDokter ?? null,
                        'user'            => Auth::user()->name,
                        'noTelp'          => !empty($kunjungan->pasien->no_hp) ? $kunjungan->pasien->no_hp : (!empty($kunjungan->pasien->no_tlp) ? $kunjungan->pasien->no_tlp : '000000000000'),
                        'tglSep'          => now(),
                        'jnsPelayanan'    => '1',
                        'klsRawatHak'     => $resdescrtiptCekStatus->response->peserta->hakKelas->kode ?? null,
                        'asalRujukan'     => '2',
                        'tglRujukan'      => now(),
                        'noRujukan'       => $spri->noSPRI??'',
                        'ppkRujukan'      => '1018R001',
                        'diagAwal'        => $request->diagAwal ?? null,
                        'respon_nosep'  => $sep,
                        'is_bridging'     => 1,
                        'status_daftar'   => 1,
                    ]
                );
            }

            return response()->json([
                'metaData' => $callback->metaData
            ]);
        }
        else{
            return response()->json([
                'metaData' => $callback->metaData
            ]);
        }

    }

    public function deleteSEPRanap(Request $request)
    {
        $vclaim     = new VclaimController();
        $response   = $vclaim->sep_delete($request);
        if ($response->metadata->code == 200) {
            $cekSEP    = HistoriesIGDBPJS::firstWhere('respon_nosep', $request->noSep);
            if($cekSEP)
            {
                $cekSEP->respon_nosep   = Null;
                $cekSEP->noRujukan      = Null;
                $cekSEP->ppkRujukan     = Null;
                $cekSEP->save();
            }

            $kunjungan          = Kunjungan::where('no_sep', $request->noSep)->first();
            $kunjungan->no_sep  = NULL;
            $kunjungan->save();
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return $response;
    }

    public function sepPrint(Request $request)
    {
        $vclaim     = new VclaimController();
        $response   = $vclaim->sep_nomor($request);
        $data = $response->response ?? null;
        $user = Auth::user()->name;
        $pasien = Pasien::where('no_rm', $data->peserta->noMr)->first();
        $noHp = $pasien->no_hp??null;
        $noTelp = $pasien->no_tlp??null;
        // dd($request->all(), $response, $data, $noTelp, $noHp);
        $pdf = PDF::loadView('simrs.igd.cetakan_igd.sep_ranap', ['data'=>$data,'user'=>$user,'noHp'=>$noHp,'noTelp'=>$noTelp]);
        return $pdf->stream('cetak-sep-ranap.pdf');
        // return view('simrs.igd.cetakan_igd.sep_ranap', compact('data'));
    }

    public function getIcd10(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "keyword" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL')  . "referensi/diagnosa/" . $request->keyword;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $resdescrtipt   = $this->response_decrypt($response, $signature);
            $dataDiagnosa = $resdescrtipt->response->diagnosa; 
        }
        return response()->json([
            'metadata' => $callback->metaData,
            'diagnosa' => $dataDiagnosa
        ]);
    }

    public function getIcd9(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "procedure" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = env('VCLAIM_URL')  . "referensi/procedure/"  . $request->procedure;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $resdescrtipt   = $this->response_decrypt($response, $signature);
            $icd9 = $resdescrtipt->response->procedure; 
        }
        // dd($response, $callback, $resdescrtipt, $icd9);
        return response()->json([
            'metadata' => $callback->metaData,
            'icd9' => $icd9
        ]);
    }
}
