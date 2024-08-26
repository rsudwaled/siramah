<?php

namespace App\Http\Controllers\IGD\Penunjang;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\AlasanMasuk;
use App\Models\Paramedis;
use App\Models\Penjamin;
use App\Models\PenjaminSimrs;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\TarifLayananDetail;
use App\Models\AntrianPasienIGD;
use App\Models\JPasienIGD;
use App\Models\HistoriesIGDBPJS;

class DaftarPenunjangController extends Controller
{
    // API FUNCTION BPJS
    public function sendResponse($data, int $code = 200)
     {
         $response = [
             'response' => $data,
             'metadata' => [
                 'message' => 'Ok',
                 'code' =>  $code,
             ],
         ];
         return json_decode(json_encode($response));
     }
     public function sendError($error,  $code = 404)
     {
         $code = $code ?? 404;
         $response = [
             'metadata' => [
                 'message'  => $error,
                 'code'     => $code,
             ],
         ];
         return json_decode(json_encode($response));
     }

    public function signature()
    {
        $cons_id    = env('ANTRIAN_CONS_ID');
        $secretKey  = env('ANTRIAN_SECRET_KEY');
        $userkey    = env('ANTRIAN_USER_KEY');
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
                'message'   => $message,
                'code'      => $code,
            ],
        ];
        return json_decode(json_encode($response));
    }
    public function index(Request $request)
    {
        $query          = Pasien::query();
        if ($request->rm && !empty($request->rm)) {
            $query->where('no_rm','LIKE', '%' . $request->rm. '%');
        }
        if ($request->nama && !empty($request->nama)) {
            $query->where('nama_px', 'LIKE', '%' . $request->nama . '%')->limit(100);
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $query->where('no_Bpjs','LIKE', '%' . $request->nomorkartu. '%');
        }
        if($request->nik && !empty($request->nik))
        {
            $query->where('nik_bpjs','LIKE', '%' .  $request->nik. '%');
        }
        if(!empty($request->nama) || !empty($request->nik) || !empty($request->nomorkartu) || !empty($request->rm))
        {
            $pasien         = $query->get();
        }else{
            $pasien         = null;
        }

        $kunjungan   = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk','desc')->take(2)->get();
        $knj_aktif   = Kunjungan::where('no_rm', $request->rm)
                        ->where('status_kunjungan', 1)
                        ->count();
        $alasanmasuk = AlasanMasuk::orderBy('id', 'asc')->get();
        $paramedis   = Paramedis::where('act', 1)->get();
        $penjamin    = PenjaminSimrs::orderBy('kode_penjamin', 'asc')->get();
        $unit        = Unit::whereIn('kode_unit', ['4002','4008','4010','4011','3014','3002','3003','3007','3020'])->orderBy('id', 'asc')->get();
        $tanggal     = now()->format('Y-m-d');
        // cek status bpjs aktif atau tidak

        $url            = null;
        $signature      = null;
        $response       = null;
        $resdescrtipt   = null;
        if(!empty($pasien->nik_bpjs))
        {
            $url            = env('VCLAIM_URL') . "Peserta/nik/" . $pasien->nik_bpjs . "/tglSEP/" . $tanggal;
            $signature      = $this->signature();
            $response       = Http::withHeaders($signature)->get($url);
            $resdescrtipt   = $this->response_decrypt($response, $signature);
        }

        $antrian_triase = AntrianPasienIGD::with('isTriase')
            ->whereDate('tgl', now())
            ->where('status', 1)
            ->where('kode_kunjungan', null)
            ->orderBy('tgl', 'desc')
            ->get();
        return view('simrs.igd.daftar_penunjang.index', compact('unit','antrian_triase','pasien','request','paramedis','alasanmasuk','paramedis','penjamin','kunjungan','knj_aktif','resdescrtipt'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if(empty($request->rm))
        {
            return back()->withErrors([
                'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
                            ($request->rm === null ? 'Pasien Belum Dipilih, ' : '')
            ]);
        }

        $unit           = Unit::firstWhere('kode_unit', $request->unit_penunjang);
        $query          = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk','desc');
        $latestCounter  = $query->where('status_kunjungan','=', 2)->first();
         // counter increment
        if ($latestCounter === null) {
            $c = 1;
        } else {
            $c = $latestCounter->counter + 1;
        }
        $createKunjungan                    = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->no_rm             = $request->rm;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->status_kunjungan  = 1;
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $request->penjamin_id;
        $createKunjungan->kelas             = 3;
        $createKunjungan->hak_kelas         = 3;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->perujuk           = $request->nama_perujuk??null;
        $createKunjungan->is_ranap_daftar   = 0;
        $createKunjungan->form_send_by      = 0;
        $createKunjungan->jp_daftar         = 0;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs??2;
        $createKunjungan->save();
        return redirect()->route('kunjungan-penunjang.list');
    }

    public function kunjunganPenunjang(Request $request)
    {
        $query = Kunjungan::whereIn('kode_unit', ['4002','4008','4010','4011','3014','3002','3003','3007','3020']);
        if(!empty($request->tanggal))
        {
            $query->whereDate('tgl_masuk', $request->tanggal);
        }else{
            $query->whereDate('tgl_masuk', now());
        }
        $penunjang = $query->get();
        return view('simrs.igd.daftar_penunjang.list_daftar', compact('request','penunjang'));
    }
}
