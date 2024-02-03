<?php

namespace App\Http\Controllers\IGD\Daftar;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\AlasanMasuk;
use App\Models\Paramedis;
use App\Models\Penjamin;
use App\Models\PenjaminSimrs;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\TarifLayananDetail;
use App\Models\JPasienIGD;
use App\Models\HistoriesIGDBPJS;

class DaftarTanpaNomorController extends Controller
{
// API FUNCTION

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
        $code       = $code ?? 404;
        $response   = [
            'metadata' => [
                'message' => $error,
                'code' => $code,
            ],
        ];
        return json_decode(json_encode($response));
    }
    public function signature()
   {
       $cons_id             = env('ANTRIAN_CONS_ID');
       $secretKey           = env('ANTRIAN_SECRET_KEY');
       $userkey             = env('ANTRIAN_USER_KEY');
       date_default_timezone_set('UTC');
       $tStamp              = strval(time() - strtotime('1970-01-01 00:00:00'));
       $signature           = hash_hmac('sha256', $cons_id . '&' . $tStamp, $secretKey, true);
       $encodedSignature    = base64_encode($signature);
       $data['user_key']    = $userkey;
       $data['x-cons-id']   = $cons_id;
       $data['x-timestamp'] = $tStamp;
       $data['x-signature'] = $encodedSignature;
       $data['decrypt_key'] = $cons_id . $secretKey . $tStamp;
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
               'message' => $message,
               'code' => $code,
           ],
       ];
       return json_decode(json_encode($response));
   }
   public function updateNOBPJS(Request $request)
   {
       $data            = Pasien::where('nik_bpjs', $request->nik_pas)->first();
       $data->no_Bpjs   = $request->no_bpjs;
       $data->update();
       return response()->json($data, 200);
   }
    public function vTanpaNomor(Request $request)
    {
        $pasien = Pasien::latest()->limit(50)->get();
        if ($request->rm && !empty($request->rm)) {
            $pasien = Pasien::where('no_rm', $request->rm)->get();
        }
        if ($request->nama && !empty($request->nama)) {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $request->nama . '%')->limit(50)->get();
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $pasien = Pasien::where('no_Bpjs', $request->nomorkartu)->get();
        }
        if($request->nik && !empty($request->nik))
        {
            $pasien = Pasien::where('nik_bpjs', $request->nik)->get();
        }
        return view('simrs.igd.daftar.v_tanpanomor', compact('request','pasien'));
    }

    public function penjaminUmum(Request $request)
    {
        $penjamin = PenjaminSimrs::get();
        return response()->json($penjamin);
    }
    public function penjaminBPJS(Request $request)
    {
        $penjamin = Penjamin::get();
        return response()->json($penjamin);
    }

    public function formDaftarTanpaNomor(Request $request, $rm)
    {
        $pasien     = Pasien::firstWhere('no_rm', $rm);
        if(empty($pasien->nik_bpjs))
        {
            Alert::info('Informasi!!', 'pasien tidak memiliki NIK. silahkan daftarkan sebagai pasien bayi atau perbaharui nik pasien dengan benar!');
            return back();
        }
        $kunjungan  = Kunjungan::where('no_rm', $rm)->orderBy('tgl_masuk','desc')->take(2)->get();
        $knj_aktif  = Kunjungan::where('no_rm', $rm)
            ->where('status_kunjungan', 1)
            ->count();
        $alasanmasuk    = AlasanMasuk::get();
        $paramedis      = Paramedis::where('act', 1)->get();
        $penjamin       = PenjaminSimrs::get();
        $penjaminbpjs   = Penjamin::get();
        $tanggal        = now()->format('Y-m-d');
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
        
        return view('simrs.igd.daftar.form_daftar_tanpanomor', compact('pasien','penjaminbpjs','paramedis','alasanmasuk','paramedis','penjamin','kunjungan','knj_aktif','resdescrtipt'));
    }

    public function daftarTanpaNomorStore(Request $request)
    {

        if (empty($request->penjamin_id_umum) || empty($request->penjamin_id_umum)) {
            Alert::error('Penjamin Belum dipilih!!', 'silahkan pilih penjamin terlebih dahulu!');
            return back();
        }
        if($request->isBpjs == null)
        {
            Alert::error('Status Pasien Belum dipilih!!', 'silahkan pilih status pasien bpjs atau bukan!');
            return back();
        }
        $bpjsProses = $request->bpjsProses;
        $penjamin   = $request->isBpjs == 1 ? $request->penjamin_id_bpjs : $request->penjamin_id_umum;
        $request->validate(
            [
                'rm'                => 'required',
                'dokter_id'         => 'required',
                'tanggal'           => 'required',
                // 'penjamin_id_umum'  => 'required',
                'alasan_masuk_id'   => 'required',
                'isBpjs'            => 'required',
                'jp'                => 'required',
                'noTelp'            => 'required|numeric|min:10|max_digits:15',
            ],
            [
                'dokter_id'         => 'Dokter DPJP wajib dipilih !',
                'tanggal'           => 'Tanggal pendaftaran wajib dipilih !',
                // 'penjamin_id_umum'  => 'Penjamin wajib dipilih !',
                'alasan_masuk_id'   => 'Alasan daftar wajib dipilih !',
                'isBpjs'            => 'Anda harus memilih pasien didaftarkan sebagai pasien bpj/umum !',
                'jp'                => 'Anda harus memilih pasien didaftarkan kedalam unit mana !',
                'noTelp'            => 'No telepon wajib diisi !',
                'noTelp.max'        => 'No telepon maksimal 13 digit',
            ]);

            $data = Kunjungan::where('no_rm', $request->rm)
            ->where('status_kunjungan', 1)
            ->get();
        if ($data->count() > 0) {
            Alert::error('Proses Daftar Gagal!!', 'pasien masih memiliki status kunjungan belum ditutup!');
            return back();
        }
        
        // counter increment
        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->rm)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }
        
        $unit       = Unit::firstWhere('kode_unit', $request->jp == 1? '1002':'1023');
        $pasien     = Pasien::where('no_rm', $request->rm)->first();
        $dokter     = Paramedis::firstWhere('kode_paramedis', $request->dokter_id);
        
        
        $createKunjungan                    = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->no_rm             = $request->rm;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->dokter_id;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin;
        $createKunjungan->kelas             = 3;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->perujuk           = $request->nama_perujuk??null;
        $createKunjungan->is_ranap_daftar   = 0;
        $createKunjungan->form_send_by      = 0;
        $createKunjungan->jp_daftar         = $bpjsProses == null ? $request->isBpjs : 2;
        $createKunjungan->pic2              = Auth::user()->id;
        
        if ($createKunjungan->save()) {
            $jpPasien               = new JPasienIGD();
            $jpPasien->kunjungan    = $createKunjungan->kode_kunjungan;
            $jpPasien->rm           = $request->rm;
            $jpPasien->nomorkartu   = $pasien->no_Bpjs;
            $jpPasien->is_bpjs      = $bpjsProses == null ? $request->isBpjs : 2;
            $jpPasien->save();

            if($request->isBpjs == 1)
            {
                $histories = new HistoriesIGDBPJS();
                $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
                $histories->noMR            = $createKunjungan->no_rm;
                $histories->noKartu         = trim($pasien->no_Bpjs);
                $histories->ppkPelayanan    = '1018R001';
                $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
                $histories->user            = Auth::user()->name;
                $histories->noTelp          = $request->noTelp;
                $histories->tglSep          = now();
                $histories->jnsPelayanan    = '2';
                $histories->klsRawatHak     = $request->kelasRawatHak??null;
                $histories->asalRujukan     = '2';
                $histories->tglRujukan      = now();
                $histories->noRujukan       = null;
                $histories->ppkRujukan      = null;
                $histories->diagAwal        = null;
                $histories->lakaLantas      = $request->lakaLantas == null ? 0 : $request->lakaLantas;
                $histories->noLP            = $request->lakaLantas > 0 ? $request->noLP:null;
                $histories->tglKejadian     = $request->lakaLantas > 0 ? $request->tglKejadian:null;
                $histories->keterangan      = $request->lakaLantas > 0 ? $request->keterangan:null;
                $histories->kdPropinsi      = $request->lakaLantas > 0 ? $request->provinsi:null;
                $histories->kdKabupaten     = $request->lakaLantas > 0 ? $request->kabupaten:null;
                $histories->kdKecamatan     = $request->lakaLantas > 0 ? $request->kecamatan:null;
                $histories->response        = null;
                $histories->is_bridging     = 0;
                $histories->status_daftar   = 0;
                $histories->unit            = $unit->kode_unit;
                $histories->save();
            }

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            $tarif_karcis           = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
            $tarif_adm              = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
            $total_bayar_k_a        = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;

            $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
            $nomorlayanandetkarc    = substr($layanandet->id_layanan_detail, 9) + 1;
            $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;
            // create layanan header
            $createLH                       = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran    = 'OPN';
            if ($unit->kelas_unit == 1) {
                $createLH->kode_tipe_transaksi  = 1;
                $createLH->status_layanan       = 3; // status 3 nanti di update jadi 1
                $createLH->total_layanan        = $total_bayar_k_a;

                if ($penjamin == 'P01') {
                    $createLH->tagihan_pribadi  = $total_bayar_k_a;
                } else {
                    $createLH->tagihan_penjamin = $total_bayar_k_a;
                }

                if ($createLH->save()) {

                    // create detail karcis
                    $createKarcis                           = new LayananDetail();
                    $createKarcis->id_layanan_detail        = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                    $createKarcis->kode_layanan_header      = $createLH->kode_layanan_header;
                    $createKarcis->kode_tarif_detail        = $unit->kode_tarif_karcis;
                    $createKarcis->total_tarif              = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->jumlah_layanan           = 1;
                    $createKarcis->total_layanan            = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->grantotal_layanan        = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->status_layanan_detail    = 'OPN';
                    $createKarcis->tgl_layanan_detail       = now();
                    $createKarcis->tgl_layanan_detail_2     = now();
                    $createKarcis->row_id_header            = $createLH->id;
                    if ($penjamin == 'P01') {
                        $createKarcis->tagihan_pribadi      = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    } else {
                        $createKarcis->tagihan_penjamin     = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    }
                    if ($createKarcis->save()) {
                        // create detail admin
                        $createAdm                          = new LayananDetail();
                        $createAdm->id_layanan_detail       = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                        $createAdm->kode_layanan_header     = $createLH->kode_layanan_header;
                        $createAdm->kode_tarif_detail       = $unit->kode_tarif_adm;
                        $createAdm->total_tarif             = $tarif_adm->TOTAL_TARIF_CURRENT;
                        $createAdm->jumlah_layanan          = 1;
                        $createAdm->total_layanan           = $tarif_adm->TOTAL_TARIF_CURRENT;
                        $createAdm->grantotal_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                        $createAdm->status_layanan_detail   = 'OPN';
                        $createAdm->tgl_layanan_detail      = now();
                        $createAdm->tgl_layanan_detail_2    = now();
                        $createAdm->row_id_header           = $createLH->id;
                        if ($penjamin == 'P01') {
                            $createAdm->tagihan_pribadi     = $tarif_adm->TOTAL_TARIF_CURRENT;
                        } else {
                            $createAdm->tagihan_penjamin    = $tarif_adm->TOTAL_TARIF_CURRENT;
                        }
                        
                        if($createAdm->save())
                        {
                            $createKunjungan->status_kunjungan = 1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                            $createKunjungan->update();

                            $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                            $createLH->update();
                        }
                    }
                }
            } 
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->rm . ' berhasil didaftarkan!');
        return redirect()->route('list.antrian');
    }
}
