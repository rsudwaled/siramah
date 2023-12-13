<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\DiagnosaFrunit;
use App\Models\HistoriesIGDBPJS;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;

class KunjunganIGDController extends APIController
{
    public function pilihKunjungan(Request $request)
    {
      $query = Kunjungan::where('status_kunjungan', 1)
              ->whereIn('kode_unit', ['1023','1002'])
              ->orderBy('tgl_masuk','desc');

      $all  = Kunjungan::whereIn('kode_unit', ['1023','1002'])
              ->orderBy('tgl_masuk','desc')->get();

      $query2 = DiagnosaFrunit::whereBetween('input_date', ['2023-11-01', now()])
              ->where('status_bridging', 0)->orderBy('input_date','desc');
              
      if($request->tanggal && !empty($request->tanggal))
      {
        $query->whereDate('tgl_masuk',$request->tanggal); 
        $query2->whereDate('input_date',$request->tanggal);
      }
      if($request->jenis_kunjungan=="umum")
      {
        $query->whereNull('no_sep'); 
        $query2->whereIn('kode_unit', ['1002']); 
      }else{
        $query->whereNotNull('no_sep');
        $query2->whereIn('kode_unit', ['1002']); 
      }
      
      $kunjungans = $query->get();
      $pasienBpjs = $query2->get();
      $kunjunganBridging = $query->get();
      // dd($kunjungans, $pasienBpjs, $kunjunganBridging);
      return view('simrs.igd.kunjungan.filter_kunjungan', compact('kunjungans','kunjunganBridging','all','request','pasienBpjs'));
    }

    public function editKunjungan(Request $request)
    {
      $kunjungan = Kunjungan::where('no_rm', $request->no_rm)->orderBy('tgl_masuk', 'desc')->get();
      $noRM = $request->no_rm;
      $penjamin = PenjaminSimrs::get();
      return view('simrs.igd.kunjungan.list_edit_kunjungan', compact('kunjungan','noRM','penjamin'));
    }

    public function editKunjunganTerpilih(Request $request)
    {
      $data = Kunjungan::with(['penjamin_simrs','pasien','unit'])
        ->where('counter', $request->counter)
        ->where('no_rm', $request->rm)->first();
      $data=collect($data);
      return response()->json($data, 200);
    }

    public function updateKunjunganTerpilih(Request $request)
    {
      $data = Kunjungan::where('counter', $request->counter)->where('no_rm', $request->no_rm)->first();
      if($request->status==0)
      {
        $status = $data->status_kunjungan;
      }else{
        $status = $request->status;
      }
      $data->status_kunjungan = $status;
      $data->kode_penjamin = $request->penjamin;
      $data->update();
      return response()->json(['data'=>$data, 'status'=>200]);
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

  public function updateDiagnosa(Request $request)
  {
    $validator = Validator::make(request()->all(), [
        'noMR' => 'required',
        'diagAwal' => 'required',
        'kunjungan' => 'required',
    ]);
    
    if ($validator->fails()) {
        Alert::error('Error', 'data yang dikirimkan tidak lengkap!');
        return back();
    }

    $histories = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $request->kunjungan);
    $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);

    $vclaim = new VclaimController();
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
                'jaminan' => [
                    'lakaLantas' => $histories->lakaLantas,
                    'noLP' => $histories->noLP == null ? '' : $histories->noLP,
                    'penjamin' => [
                        'tglKejadian' => $histories->lakaLantas == 0 ? '' : $histories->tglKejadian,
                        'keterangan' => $histories->keterangan == null ? '' : $histories->keterangan,
                        'suplesi' => [
                            'suplesi' => '0',
                            'noSepSuplesi' => '',
                            'lokasiLaka' => [
                                'kdPropinsi' => $histories->provinsi == null ? '' : $histories->provinsi,
                                'kdKabupaten' => $histories->kabupaten == null ? '' : $histories->kabupaten,
                                'kdKecamatan' => $histories->kecamatan == null ? '' : $histories->kecamatan,
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
    // RESPONSE JSON ERROR;
    
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
      Alert::success('success', 'Diagnosa pada kunjungan sudah di synchronize' );
      return back();
    }
    else{
      Alert::error('Error', $callback->metaData->message);
      return back();
    }
      
  }
}
