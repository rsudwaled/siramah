<?php

namespace App\Http\Controllers\IGD\DiagnosaSynch;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Kunjungan;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Icd10;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\DiagnosaFrunit;
use App\Models\HistoriesIGDBPJS;
use Auth;
use DB;


class DiagnosaSynchController extends APIController
{
    public function vDiagnosaAssesment(Request $request)
    {
        
        $query2 = DiagnosaFrunit::with(['pasien','jpDaftar'])->where('status_bridging', 0)
                  ->where('isSynch', 0)->orderBy('input_date','desc');
                
        if($request->tanggal && !empty($request->tanggal))
        {
            $dataYesterday = Carbon::createFromFormat('Y-m-d',  $request->tanggal);
            $yesterday = $dataYesterday->subDays(2)->format('Y-m-d');

            $query2->whereDate('input_date','>=', $yesterday); 
            $query2->whereDate('input_date','<=', $request->tanggal); 
        }else{
            $dataYesterday = now();
            $yesterday = $dataYesterday->subDays(1)->format('Y-m-d');

            $query2->whereDate('input_date','>=', $yesterday); 
            $query2->whereDate('input_date','<=', now()); 
        }
        if($request->unit && !empty($request->unit))
        {
            $query2->whereIn('kode_unit', [$request->unit]); 
        }

        $pasien_fr = $query2->get();
        $unit = Unit::whereIn('kode_unit',['1002','1023','1010','2004','2013'])->get();
        $requestUnit = Unit::firstWhere('kode_unit', $request->unit);
        return view('simrs.igd.diagnosa_synch.index', compact('request','pasien_fr','unit','requestUnit'));
    }

    // API FUNCTION
   public function signature()
   {
       $cons_id = env('ANTRIAN_CONS_ID');
       $secretKey = env('ANTRIAN_SECRET_KEY');
       $userkey = env('ANTRIAN_USER_KEY');
       date_default_timezone_set('UTC');
       $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
       $signature = hash_hmac('sha256', $cons_id . '&' . $tStamp, $secretKey, true);
       $encodedSignature = base64_encode($signature);
       $data['user_key'] = $userkey;
       $data['x-cons-id'] = $cons_id;
       $data['x-timestamp'] = $tStamp;
       $data['x-signature'] = $encodedSignature;
       $data['decrypt_key'] = $cons_id . $secretKey . $tStamp;
       return $data;
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

    public function synchDiagnosaAndBridging(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(request()->all(), [
            'noMR' => 'required',
            'diagAwal' => 'required',
            'kunjungan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=>$validator,'code'=>400]);
        }
    
        $histories  = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
        $kunjungan  = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        if($kunjungan->jpDaftar->is_bpjs ==0)
        {
            return response()->json(['data'=>$kunjungan,'code'=>401, 'message'=>'MOHON MAAF BUKAN PASIEN BPJS!!. silahkan pilih tombol only update untuk pasien umum']);
        }
        $icd        = Icd10::firstWhere('diag', $request->diagAwal);
        $isSynch    = DiagnosaFrunit::firstWhere('kode_kunjungan', $request->kunjungan);
        if($kunjungan->jpDaftar->is_bpjs ==1)
        {
            $url = env('VCLAIM_URL') . 'SEP/2.0/insert';
            $signature = $this->signature();
            $signature['Content-Type'] = 'application/x-www-form-urlencoded';
            $data = [
                'request' => [
                    't_sep' => [
                        'noKartu' => $histories->noKartu,
                        'tglSep' => $histories->tglSep,
                        'ppkPelayanan' => '1018R001',
                        'jnsPelayanan' => $histories->jnsPelayanan,
                        'klsRawat' => [
                            'klsRawatHak' => $histories->klsRawatHak,
                            'klsRawatNaik' => '',
                            'pembiayaan' => '',
                            'penanggungJawab' => '',
                        ],
                        'noMR' => $histories->noMR,
                        'rujukan' => [
                            'asalRujukan' => $histories->asalRujukan == null?'':$histories->asalRujukan,
                            'tglRujukan' => $histories->tglRujukan,
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
                        'jaminan' => [
                            'lakaLantas' => $histories->lakaLantas == null? 0 : $histories->lakaLantas,
                            'noLP' => $histories->noLP == null ? '' : $histories->noLP,
                            'penjamin' => [
                                'tglKejadian' => $histories->lakaLantas == null ? 0 : $histories->tglKejadian,
                                'keterangan' => $histories->keterangan == null ? '' : $histories->keterangan,
                                'suplesi' => [
                                    'suplesi' => '0',
                                    'noSepSuplesi' => '',
                                    'lokasiLaka' => [
                                        'kdPropinsi' => $histories->kdPropinsi == null ? '' : $histories->kdPropinsi,
                                        'kdKabupaten' => $histories->kdKabupaten == null ? '' : $histories->kdKabupaten,
                                        'kdKecamatan' => $histories->kdKecamatan == null ? '' : $histories->kdKecamatan,
                                    ],
                                ],
                            ],
                        ],
                        'tujuanKunj' => '0',
                        'flagProcedure' => '',
                        'kdPenunjang' => '',
                        'assesmentPel' => '',
                        'skdp' => [
                            'noSurat' => '',
                            'kodeDPJP' => '',
                        ],
                        'dpjpLayan' => $histories->dpjpLayan,
                        'noTelp' => $histories->noTelp,
                        'user' => 'test',
                    ],
                ],
            ];
            $response = Http::withHeaders($signature)->post($url, $data);
            $callback = json_decode($response->body());

            if ($callback->metaData->code == 200) {
              $resdescrtipt = $this->response_decrypt($response, $signature);
              $sep = $resdescrtipt->response->sep->noSep;
              $histories->diagAwal= $request->diagAwal;
              $histories->status_daftar = 1;
              $histories->is_bridging = 1;
              $histories->respon_nosep = $sep;
              $histories->save();
              
              $kunjungan->diagx   = $request->diagAwal;
              $kunjungan->no_sep = $sep;
              $kunjungan->save();

              $isSynch->status_bridging = 1;
              $isSynch->isSynch = 1;
              $isSynch->save();
              return response()->json(['data'=>$callback]);
            }
            else{
                return response()->json(['data'=>$callback]);
            }
        }else{
            return response()->json(['data'=>$callback]);
        }
        
    }

    public function synchDiagnosa(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'noMR' => 'required',
            'diagAwal' => 'required',
            'kunjungan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data'=>$validator,'code'=>400, 'message'=>'Data yang dikirim tidak lengkap!']);
        }

        $kunjungan  = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        if(empty($kunjungan))
        {
            return response()->json(['data'=>$kunjungan,'code'=>401,'message'=>'Kunjungan Tidak Ada!']);
        }
        $icd        = Icd10::firstWhere('diag', $request->diagAwal);
        $kunjungan->diagx   = $request->diagAwal.' - '.$icd->nama ;
        $kunjungan->save();

        $isSynch    = DiagnosaFrunit::firstWhere('kode_kunjungan', $request->kunjungan);
        if(empty($kunjungan))
        {
            return response()->json(['data'=>$kunjungan,'code'=>402,'message'=>'Kunjungan Belum di Assesment Dokter!']);
        }
        $isSynch->isSynch = 1;
        $isSynch->save();

        return response()->json(['data'=>$kunjungan,'code'=>200,'message'=>'Diagnosa Kunjungan : '.$kunjungan->kode_kunjungan.' berhasil diupdate']);
    }
}
