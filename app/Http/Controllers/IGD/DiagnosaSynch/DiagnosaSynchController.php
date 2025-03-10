<?php

namespace App\Http\Controllers\IGD\DiagnosaSynch;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Kunjungan;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Icd10;
use Illuminate\Http\Request;
use App\Models\DiagnosaFrunit;
use App\Models\HistoriesIGDBPJS;
use Auth;


class DiagnosaSynchController extends APIController
{
    public function vDiagnosaAssesment(Request $request)
    {
        $query = DiagnosaFrunit::with(['pasien','jpDaftar'])->where('status_bridging', 0)
                  ->where('isSynch', 0)->orderBy('input_date','desc');

        if($request->tanggal && !empty($request->tanggal))
        {
            $dataYesterday  = Carbon::createFromFormat('Y-m-d',  $request->tanggal);
            $yesterday      = $dataYesterday->subDays(2)->format('Y-m-d');

            $query->whereDate('input_date','>=', $yesterday);
            $query->whereDate('input_date','<=', $request->tanggal);
        }
        if($request->unit && !empty($request->unit))
        {
            $query->whereIn('kode_unit', [$request->unit]);
        }
        if(empty($request->tanggal) && empty($request->unit)){
            $query->whereDate('input_date', now());
        }

        $pasien_fr      = $query->get();
        $unit           = Unit::whereIn('kode_unit',['1002','1023','1010','2004','2013'])->get();
        $requestUnit    = Unit::firstWhere('kode_unit', $request->unit);
        return view('simrs.igd.diagnosa_synch.index', compact('request','pasien_fr','unit','requestUnit'));
    }

    // API FUNCTION
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

   public function synchDiagnosaAndBridging(Request $request)
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
                       'noKartu'       => trim($histories->noKartu ?? ($kunjungan->pasien->no_Bpjs ?? '')),
                       'tglSep'        => $histories->tglSep ?? \Carbon\Carbon::now()->format('Y-m-d'),
                       'ppkPelayanan'  => '1018R001',
                       'jnsPelayanan'  => '2',
                       'klsRawat'      => [
                           'klsRawatHak'       => '',
                           'klsRawatNaik'      => '',
                           'pembiayaan'        => '',
                           'penanggungJawab'   => '',
                       ],
                       'noMR'      => $histories->noMR??$kunjungan->pasien->no_rm,
                       'rujukan'   => [
                           'asalRujukan'   => 2,
                           'tglRujukan'    => \Carbon\Carbon::now()->format('Y-m-d'),
                           'noRujukan'     => '',
                           'ppkRujukan'    => '',
                       ],
                       'catatan'   => '',
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
                           'lakaLantas'            => $histories?->lakaLantas == null? 0 : $histories?->lakaLantas,
                           'noLP'                  => $histories?->noLP == null ? '' : $histories?->noLP,
                           'penjamin' => [
                               'tglKejadian'       => $histories?->lakaLantas == null ? 0 : $histories?->tglKejadian,
                               'keterangan'        => $histories?->keterangan == null ? '' : $histories?->keterangan,
                               'suplesi' => [
                                   'suplesi'       => '0',
                                   'noSepSuplesi'  => '',
                                   'lokasiLaka'    => [
                                       'kdPropinsi'    => $histories?->kdPropinsi == null ? '' : $histories?->kdPropinsi,
                                       'kdKabupaten'   => $histories?->kdKabupaten == null ? '' : $histories?->kdKabupaten,
                                       'kdKecamatan'   => $histories?->kdKecamatan == null ? '' : $histories?->kdKecamatan,
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
                       'dpjpLayan'     => $request->dpjp, // ini request dari view modal
                       // 'dpjpLayan'     => $histories->dpjpLayanan,
                       'noTelp'        => $histories?->noTelp ?? ($kunjungan->pasien->no_tlp ? $kunjungan->pasien->no_hp : '000000000000'),
                       'user'          => $histories?->user??'admin rswaled',
                   ],
               ],
           ];
           $response = Http::withHeaders($signature)->post($url, $data);
           $callback = json_decode($response->body());
           if ($callback->metaData->code == 200) {
             $resdescrtipt = $this->response_decrypt($response, $signature);
             $sep          = $resdescrtipt->response->sep->noSep;

             $histories = new HistoriesIGDBPJS();
             $histories->kode_kunjungan  = $kunjungan->kode_kunjungan;
             $histories->noMR            = $kunjungan->no_rm;
             $histories->noKartu         = trim($kunjungan->pasien->no_Bpjs);
             $histories->ppkPelayanan    = '1018R001';
             $histories->dpjpLayan       = $request->dpjp;
             $histories->user            = Auth::user()->name;
             $histories->noTelp          = $kunjungan->pasien->no_tlp ? $kunjungan->pasien->no_hp : '000000000000';
             $histories->tglSep          = now();
             $histories->jnsPelayanan    = '2';
             $histories->klsRawatHak     = null;
             $histories->asalRujukan     = '2';
             $histories->tglRujukan      = now();
             $histories->noRujukan       = null;
             $histories->ppkRujukan      = null;
             $histories->diagAwal        = $request->diagAwal;
             $histories->lakaLantas      = null;
             $histories->noLP            = null;
             $histories->tglKejadian     = null;
             $histories->keterangan      = null;
             $histories->kdPropinsi      = null;
             $histories->kdKabupaten     = null;
             $histories->kdKecamatan     = null;
             $histories->response        = null;
             $histories->is_bridging     = 1;
             $histories->status_daftar   = 1;
             $histories->unit            = $kunjungan->kode_unit;
             $histories->respon_nosep    = $sep;
             $histories->save();

             $kunjungan->no_sep    = $sep;
             $diagnosa_ts          = Icd10::where('diag', $request->diagAwal)->first();
             $kunjungan->diagx     = $diagnosa_ts ? $diagnosa_ts->diag . ' | ' . $diagnosa_ts->nama : '';
             $kunjungan->save();
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
        $data = [
            'request' => [
                't_sep' => [
                    'noSep'       => trim($histories->respon_nosep),
                    'klsRawat'      => [
                        'klsRawatHak'       => '',
                        'klsRawatNaik'      => '',
                        'pembiayaan'        => '',
                        'penanggungJawab'   => '',
                    ],
                    'noMR'      => $histories->noMR,
                    'catatan'   => 'test insert',
                    'diagAwal'  => $histories->diagAwal,
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
                    'dpjpLayan'     => $request->dpjp,
                    'noTelp'        => $histories->noTelp,
                    'user'          => $histories->user,
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        $callback = json_decode($response->body());
        if ($callback->metaData->code == 200) {
            $resdescrtipt               = $this->response_decrypt($response, $signature);
            $sep                        = $resdescrtipt->response->sep->noSep;

            $histories->diagnosa_update = $diagnosa_update;
            $histories->dpjp_update     = $dpjp_update;

            $histories->diagAwal        = $request->diagAwal;
            $histories->respon_nosep    = $sep;
            $histories->save();

            $kunjungan->diagx           = $request->diagAwal;
            $kunjungan->no_sep          = $sep;
            $kunjungan->save();
            return response()->json(['data'=>$callback]);
        }
        else{
            return response()->json(['data'=>$callback]);
        }
    }

    public function sepBackdate(Request $request)
    {

    }

    public function synchDiagnosa(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'noMR'      => 'required',
            'diagAwal'  => 'required',
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
        $diagnosa_ts          = Icd10::where('diag', $request->diagAwal)->first();
        $kunjungan->diagx     = $diagnosa_ts->diag.' | '.$diagnosa_ts->nama;
        $kunjungan->save();

        // $isSynch    = DiagnosaFrunit::firstWhere('kode_kunjungan', $request->kunjungan);
        if(empty($kunjungan))
        {
            return response()->json(['data'=>$kunjungan,'code'=>402,'message'=>'Kunjungan Belum di Assesment Dokter!']);
        }
        // $isSynch->isSynch = 1;
        // $isSynch->save();

        return response()->json(['data'=>$kunjungan,'code'=>200,'message'=>'Diagnosa Kunjungan : '.$kunjungan->kode_kunjungan.' berhasil diupdate']);
    }
}
