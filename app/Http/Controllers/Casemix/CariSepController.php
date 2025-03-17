<?php

namespace App\Http\Controllers\Casemix;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;
use PDF;

class CariSepController extends APIController
{
    public $baseurl = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";
    public $consid =  "3431";
    public $secrekey = "7fI37884D3";
    public $userkey = "8c4bf16aee4629511617bd55de88b4fe";

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

    public function viewCariSep(Request $request)
    {
        return view('simrs.casemix.cari_sep.view_cari_sep');
    }

    public function getSep(Request $request)
    {
        if ($request->noSep) {
            $url            = $this->baseurl . "SEP/" . $request->noSep;
            $signature      = $this->signature();
            $response       = Http::withHeaders($signature)->get($url);
            $resdescrtipt   = $this->response_decrypt($response, $signature);

            $data           = $resdescrtipt->response;
            $noKartu        = $data->peserta->noKartu;
            // dd($data);
            if ($data) {
                $qrCode = QrCode::size(40)->generate($noKartu);
                return response()->json([
                    'html' => view('simrs.igd.cetakan_igd.sep_downloader_casemix', compact('data', 'qrCode'))->render()
                ]);
            } else {
                return response()->json([
                    'message' => 'Data SEP tidak ditemukan.'
                ]);
            }
        }

        return response()->json([
            'message' => 'No SEP HARUS DIISI !!.'
        ]);
    }

    public function getSepDownload(Request $request)
    {
        if ($request->noSep) {
            $url            = $this->baseurl . "SEP/" . $request->noSep;
            $signature      = $this->signature();
            $response       = Http::withHeaders($signature)->get($url);
            $resdescrtipt   = $this->response_decrypt($response, $signature);
            if($resdescrtipt->response)
            {
                $data           = $resdescrtipt->response;
                $noKartu        = $data->peserta->noKartu;

                $qrCode = QrCode::size(40)->generate($noKartu);
                $pdf    = PDF::loadView('simrs.igd.cetakan_igd.sep_downloader_casemix_pdf', ['data'=>$data,'qrCode'=>$qrCode]);
                return $pdf->stream($data->peserta->noMr.'-'.$data->noSep.'.pdf');

            }else{
                return redirect()->route('casemix-cari-sep.index');
            }
        }
    }
}
