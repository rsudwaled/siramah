<?php

namespace App\Http\Controllers\BridgingIgd;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Spri;
use App\Models\Icd10;
use App\Models\HistoriesIGDBPJS;
use Carbon\Carbon;

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
        $histories  = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
        $kunjungan  = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $spri       = Spri::firstWhere('kunjungan', $request->kunjungan);
        $url        = env('VCLAIM_URL') . 'SEP/2.0/insert';
        $signature  = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            'request' => [
                't_sep' => [
                    'noKartu'               => trim($histories->noKartu??$kunjungan->pasien->no_Bpjs),
                    'tglSep'                => $histories->tglSep,
                    'ppkPelayanan'          => '1018R001',
                    'jnsPelayanan'          => $histories->jnsPelayanan,
                    'klsRawat'      => [
                        'klsRawatHak'       => $histories->klsRawatHak,
                        'klsRawatNaik'      => $histories->klsRawatNaik??'',
                        'pembiayaan'        => $histories->pembiayaan??'',
                        'penanggungJawab'   => $histories->penanggungJawab??'',
                    ],
                    'noMR'                  => $histories->noMR,
                    'rujukan'   => [
                        'asalRujukan'       => $histories->asalRujukan == null?'':$histories->asalRujukan,
                        'tglRujukan'        => $histories->tglRujukan,
                        'noRujukan'         => $spri->noSPRI??'',
                        'ppkRujukan'        => '1018R001',
                    ],
                    'catatan'               => '',
                    'diagAwal'              => $histories->diagAwal??Null,
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
                        'lakaLantas'        => $histories->lakaLantas == null? 0 : $histories->lakaLantas,
                        'noLP'              => $histories->noLP == null ? '' : $histories->noLP,
                        'penjamin'          => [
                            'tglKejadian'   => $histories->lakaLantas == null ? '' : $histories->tglKejadian,
                            'keterangan'    => $histories->keterangan == null ? '' : $histories->keterangan,
                            'suplesi'       => [
                                'suplesi'           => '0',
                                'noSepSuplesi'      => '',
                                'lokasiLaka'    => [
                                    'kdPropinsi'    => $histories->kdPropinsi == null ? '' : $histories->kdPropinsi,
                                    'kdKabupaten'   => $histories->kdKabupaten == null ? '' : $histories->kdKabupaten,
                                    'kdKecamatan'   => $histories->kdKecamatan == null ? '' : $histories->kdKecamatan,
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
                    'noTelp'    => $histories->noTelp,
                    'user'      => 'RSUD WALED',
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $resdescrtipt   = $this->response_decrypt($response, $signature);
            $sep            = $resdescrtipt->response->sep->noSep;

            $histories->ppkRujukan       = '1018R001';
            $histories->noRujukan       = $spri->noSPRI;
            // $histories->diagAwal        = $kunjungan->diagx;
            $histories->status_daftar   = 1;
            $histories->is_bridging     = 1;
            $histories->respon_nosep    = $sep;
            $histories->save();

            $kunjungan->no_sep = $sep;
            $kunjungan->save();

            return response()->json(['data'=>$callback]);
        }
        else{
            return response()->json(['data'=>$callback]);
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
}
