<?php

namespace App\Http\Controllers\IGD\SEP;

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\HistoriesIGDBPJS;

class SEPController extends APIController
{
    public function signature()
    {
        $cons_id             = env('ANTRIAN_CONS_ID');
       $secretKey           = env('ANTRIAN_SECRET_KEY');
       $userkey             = env('ANTRIAN_USER_KEY');
        date_default_timezone_set('UTC');
        $tStamp                  = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature               = hash_hmac('sha256', $cons_id . '&' . $tStamp, $secretKey, true);
        $encodedSignature        = base64_encode($signature);
        $data['user_key']        = $userkey;
        $data['x-cons-id']       = $cons_id;
        $data['x-timestamp']     = $tStamp;
        $data['x-signature']     = $encodedSignature;
        $data['decrypt_key']     = $cons_id . $secretKey . $tStamp;
        return $data;
    }
 
    public static function stringDecrypt($key, $string)
    {
        $encrypt_method  = 'AES-256-CBC';
        $key_hash        = hex2bin(hash('sha256', $key));
        $iv              = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output          = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output          = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }
 
    public function response_decrypt($response, $signature)
    {
        $code    = json_decode($response->body())->metaData->code;
        $message = json_decode($response->body())->metaData->message;
        if ($code == 200 || $code == 1) {
            $response    = json_decode($response->body())->response ?? null;
            $decrypt     = $this->stringDecrypt($signature['decrypt_key'], $response);
            $data        = json_decode($decrypt);
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
        $code        = json_decode($response->body())->metaData->code;
        $message     = json_decode($response->body())->metaData->message;
        $response    = json_decode($response->body())->metaData->response;
        $response = [
            'response' => $response,
            'metadata' => [
                'message'    => $message,
                'code'       => $code,
            ],
        ];
        return json_decode(json_encode($response));
    }

    public function bridgingSEP(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'noMR'      => 'required',
            'kunjungan' => 'required',
            'diagAwal'  => 'required',
            'dpjp'      => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=>$validator,'code'=>400]);
        }
    
        $histories  = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
        $kunjungan  = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        if($kunjungan->jp_daftar == 0)
        {
            return response()->json([
                'data'=>$kunjungan,
                'code'=>401, 
                'message'=>'MOHON MAAF BUKAN PASIEN BPJS!!. silahkan pilih tombol only update untuk pasien umum'
            ]);
        }
               
        if($kunjungan->jp_daftar ==1)
        {
            $url        = env('VCLAIM_URL') . 'SEP/2.0/insert';
            $signature  = $this->signature();
            $signature['Content-Type'] = 'application/x-www-form-urlencoded';
            $data = [
                'request' => [
                    't_sep' => [
                        'noKartu'       => trim($histories->noKartu),
                        'tglSep'        => $histories->tglSep,
                        'ppkPelayanan'  => '1018R001',
                        'jnsPelayanan'  => '2',
                        'klsRawat'      => [
                            'klsRawatHak'       => '',
                            'klsRawatNaik'      => '',
                            'pembiayaan'        => '',
                            'penanggungJawab'   => '',
                        ],
                        'noMR'      => $histories->noMR,
                        'rujukan'   => [
                            'asalRujukan'   => $histories->asalRujukan == null?'':$histories->asalRujukan,
                            'tglRujukan'    => $histories->tglRujukan,
                            'noRujukan'     => '',
                            'ppkRujukan'    => '',
                        ],
                        'catatan'   => 'test insert',
                        'diagAwal'  => $request->diagAwal,
                        'poli' => [
                            'tujuan'    => 'IGD',
                            'eksekutif' => '0',
                        ],
                        'cob' => [
                            'cob' => '0',
                        ],
                        'katarak' => [
                            'katarak' => '0',
                        ],
                        'jaminan' => [
                            'lakaLantas'            => $histories->lakaLantas == null? 0 : $histories->lakaLantas,
                            'noLP'                  => $histories->noLP == null ? '' : $histories->noLP,
                            'penjamin' => [
                                'tglKejadian'       => $histories->lakaLantas == null ? 0 : $histories->tglKejadian,
                                'keterangan'        => $histories->keterangan == null ? '' : $histories->keterangan,
                                'suplesi' => [
                                    'suplesi'       => '0',
                                    'noSepSuplesi'  => '',
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
                            'noSurat'   => '',
                            'kodeDPJP'  => '',
                        ],
                        'dpjpLayan'     => $request->dpjp, 
                        'noTelp'        => $histories->noTelp,
                        'user'          => $histories->user,
                    ],
                ],
            ];
            $response = Http::withHeaders($signature)->post($url, $data);
            $callback = json_decode($response->body());
            if ($callback->metaData->code == 200) {
              $resdescrtipt = $this->response_decrypt($response, $signature);
              $sep          = $resdescrtipt->response->sep->noSep;
              $histories->diagAwal      = $request->diagAwal;
              $histories->status_daftar = 1;
              $histories->is_bridging   = 1;
              $histories->respon_nosep  = $sep;
              $histories->dpjpLayanan   = $request->dpjp;
              $histories->save();
              
              $kunjungan->diagx     = $request->diagAwal;
              $kunjungan->no_sep    = $sep;
              $kunjungan->save();

            //   $isSynch->status_bridging = 1;
            //   $isSynch->isSynch         = 1;
            //   $isSynch->save();
              return response()->json(['data'=>$callback]);
            }
            else{
                return response()->json(['data'=>$callback]);
            }
        }else{
            return response()->json(['data'=>null]);
        }
    }

    public function updateSep(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(request()->all(), [
            'noMR'      => 'required',
            'kunjungan' => 'required',
            'diagAwal'  => 'required',
            'dpjp'      => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=>$validator,'code'=>400]);
        }

        $histories  = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
        $kunjungan  = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $diagnosa_update = $histories->diagAwal;
        $dpjp_update     = $histories->dpjpLayanan;

        $url        = env('VCLAIM_URL') . 'SEP/2.0/update';
        $signature  = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = 
        [
            'request' => [
                't_sep' => [
                    'noSep'         => trim($histories->respon_nosep),
                    'klsRawat'      => [
                        'klsRawatHak'       => '3',
                        'klsRawatNaik'      => '',
                        'pembiayaan'        => '',
                        'penanggungJawab'   => '',
                    ],
                    'noMR'      => $request->noMR,
                    'catatan'   => 'test insert',
                    'diagAwal'  => $request->diagAwal,
                    'poli' => [
                        'tujuan'    => 'IGD',
                        'eksekutif' => '0',
                    ],
                    'cob' => [
                        'cob' => '0',
                    ],
                    'katarak' => [
                        'katarak' => '0',
                    ],
                    'jaminan' => [
                        'lakaLantas'            => '0',
                        'penjamin' => [
                            'tglKejadian'       => '',
                            'keterangan'        => '',
                            'suplesi' => [
                                'suplesi'       => '0',
                                'noSepSuplesi'  => '',
                                'lokasiLaka'    => [
                                    'kdPropinsi'    => '',
                                    'kdKabupaten'   => '',
                                    'kdKecamatan'   => '',
                                ],
                            ],
                        ],
                    ],
                    'dpjpLayan'     => $request->dpjp,
                    'noTelp'        => $histories->noTelp,
                    'user'          => $histories->user,
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->put($url, $data);
        $callback = json_decode($response->body());
        // dd($data, $callback, $response);
        if ($callback->metaData->code == 200) {
            $resdescrtipt               = $this->response_decrypt($response, $signature);
            $sep                        = $resdescrtipt->response->sep->noSep;
            
            $histories->diagnosa_update = $diagnosa_update;
            $histories->dpjp_update     = $dpjp_update;

            $histories->diagAwal        = $request->diagAwal;
            $histories->respon_nosep    = $sep;
            $histories->save();
            
            $kunjungan->diagx           = $request->diagAwal;
            $kunjungan->save();
            return response()->json(['data'=>$callback]);
        }
        else{
            return response()->json(['data'=>$callback]);
        }
    }

    public function sepBackdate(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(request()->all(), [
            'noKartu'   => 'required',
            'kunjungan' => 'required',
            'keterangan'=> 'required',
            'tglSep'    => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=>$validator,'code'=>400,'message'=>'Data input belum lengkap!']);
        }
        
        $histories  = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
        
        $url        = env('VCLAIM_URL') . 'Sep/pengajuanSEP';
        $signature  = $this->signature();
        $signature['Content-Type'] = 'application/x-www-form-urlencoded';
        $data = [
            'request' => [
                't_sep' => [
                    'noKartu'       => trim($request->noKartu),
                    'tglSep'        => $request->tglSep,
                    'jnsPelayanan'  => "2",
                    'jnsPengajuan'  => "1",
                    'keterangan'    => $request->keterangan,
                    'user'          => 'coba',
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $histories->is_backdate     = 1;
            $histories->save();
            return response()->json(['data'=>$callback]);
        }
        else{
            return response()->json(['data'=>$callback]);
        }
    }
}
