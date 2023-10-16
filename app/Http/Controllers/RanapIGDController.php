<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\AntrianPasienIGD;
use App\Models\Pasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\KeluargaPasien;
use App\Models\Unit;
use App\Models\Paramedis;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;
use App\Models\AlasanMasuk;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\TriaseIGD;
use App\Models\Icd10;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\Spri;
use App\Models\Poliklinik;
use App\Models\TarifLayanan;
use App\Models\TarifLayananDetail;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DB;

class RanapIGDController extends APIController
{
    public function getKunjunganNow()
    {
        $kunjungan = Kunjungan::with('pasien')->where('status_kunjungan', 2)->get();
        $paramedis = Paramedis::whereNotNull('kode_dokter_jkn')
            ->get();
        return view('simrs.igd.ranap.data_kunjungan', compact('kunjungan','paramedis'));
    }

    public function ranapUmum(Request $request)
    {
        $refKunj = $request->kun;
        $pasien = Pasien::where('no_rm', 10230617)->first();
        $kunjungan = Kunjungan::where('kode_kunjungan', $refKunj)->first();
        $paramedis = Paramedis::where('spesialis', 'UMUM')
            ->where('act', 1)
            ->get();
        $unit = Unit::where('kelas_unit', 2)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $penjamin = PenjaminSimrs::get();
        return view('simrs.igd.ranap.form_ranap', compact('pasien', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'refKunj','paramedis'));
    }

    public function ranapBPJS(Request $request)
    {
        if($request->no_kartu==null)
        {
            Alert::error('Error!!', 'pasien tidak memiliki no bpjs');
            return back();
        }
        $vlcaim = new VclaimController();
        $request['nomorkartu'] = $request->no_kartu;
        $request['tanggal'] = now()->format('Y-m-d');
        $res = $vlcaim->peserta_nomorkartu($request);
        $kodeKelas = $res->response->peserta->hakKelas->kode;
        $kelas = $res->response->peserta->hakKelas->keterangan;
        $refKunj = $request->kodeKunjungan;
        $pasien = Pasien::firstWhere('no_Bpjs', $request->no_kartu);
        $kunjungan = Kunjungan::where('kode_kunjungan', $refKunj)->get();
        $unit = Unit::where('kelas_unit', 2)->get();
        $poli = Unit::whereNotNull('KDPOLI')->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $icd = Icd10::limit(15)->get();
        $penjamin = PenjaminSimrs::get();
        $paramedis = Paramedis::whereNotNull('kode_dokter_jkn')
            ->get();
        $spri = Spri::where('noKartu', $request->no_kartu)->where('tglRencanaKontrol', now()->format('Y-m-d'))->first();
        // dd($spri);
        return view('simrs.igd.ranap.form_ranap_bpjs', compact('pasien','icd','poli','refKunj','kodeKelas','kelas','spri', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk','paramedis'));
    }
    public function getUnit(Request $request)
    {
        // $unit 
        $unit = Unit::where('kelas_id', 2)
            ->get();
        return response()->json([
            'unit' => $unit,
        ]);
    }
    public function getBedByRuangan(Request $request)
    {
        $bed = Ruangan::where('kode_unit', $request->unit)
            ->where('id_kelas', $request->kelas)
            ->where('status', 1)
            ->where('status_incharge', 0)
            ->get();
        // dd($bed);
        return response()->json([
            'bed' => $bed,
        ]);
    }

    public function pasienRanapStore(Request $request)
    {
        // dd($request->all());
        $validator = $request->validate([
            "tanggal_daftar" => "required|date",
            "kodeKunjungan" => "required",
            "noMR" => "required",
            "penjamin_id" => "required",
            "idRuangan" => "required",
            "alasan_masuk_id" => "required",
            "noTelp" => "required",
            "dpjp" => "required",
        ]);
        $counter = Kunjungan::latest('counter')
        ->where('no_rm', $request->noMR)
        ->where('status_kunjungan', 2)
        ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }
        $penjamin = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit = Unit::firstWhere('kode_unit', $ruangan->kode_unit);
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter       = $c;
        $createKunjungan->ref_kunjungan = $request->kodeKunjungan;
        $createKunjungan->no_rm         = $request->noMR;
        $createKunjungan->kode_unit     = $unit->kode_unit;
        $createKunjungan->tgl_masuk     = now();
        $createKunjungan->kode_paramedis    = $request->dpjp;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin_simrs;
        $createKunjungan->kelas             = $request->kelas_rawat;
        $createKunjungan->hak_kelas         = $request->hak_kelas;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->id_ruangan        = $request->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->pic               = Auth::user()->id;
        if ($createKunjungan->save()) {

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm.$ruangan->id_kelas;//kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header = $kodelayanan;
            $createLH->tgl_entry = now();
            $createLH->kode_kunjungan = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit = $unit->kode_unit;
            $createLH->pic = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi = 2;
                    $createLH->status_layanan = 1; 
                    $createLH->tagihan_pribadi = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi = 2;
                    $createLH->status_layanan = 2; 
                    $createLH->tagihan_penjamin = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
                    $createAdm->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail = $unit->kode_tarif_karcis;
                    $createAdm->total_tarif = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan = 1;
                    $createAdm->total_layanan = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->status_layanan_detail = 'OPN';
                    $createAdm->tgl_layanan_detail = now();
                    $createAdm->tgl_layanan_detail_2 = now();
                    $createAdm->row_id_header = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin = $total_bayar_k_a;
                    }
                    
                    if($createAdm->save())
                    {
                        $createKunjungan->status_kunjungan =1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->update();

                        $createLH->status_layanan =1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            } 
            // dd($createKunjungan,  $ant_upd, $createLH, $createKarcis, $createAdm);
            // else if($unit->kelas_unit == 2) {
            //     // jika kelas unit 2
            // }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan!');
        return redirect()->route('kunjungan.ranap');
    }


    // pasien ranap bpjs

    public function getSPRI(Request $request)
    {
        $spri = Spri::firstWhere('noSPRI', $request->noSuratKontrol);
        return response()->json([
            'spri' => $spri,
        ]);
    }
    public function createSPRI(Request $request)
    {
        $vclaim = new VclaimController();
        $response = $vclaim->spri_insert($request);
        if ($response->metadata->code == 200) {
            $spri = $response->response;
            Spri::create([
                "noSPRI"=>$spri->noSPRI,
                "tglRencanaKontrol"=>$spri->tglRencanaKontrol,
                "namaDokter"=>$spri->namaDokter,
                "noKartu"=>$spri->noKartu,
                "nama"=>$spri->nama,
                "kelamin"=>$spri->kelamin,
                "tglLahir"=>$spri->tglLahir,
                "namaDiagnosa"=>$spri->namaDiagnosa,
        
                "kodeDokter"=>$request->kodeDokter,
                "poliKontrol"=>$request->poliKontrol,
                "user" => $request->user,
            ]);
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return  $response;
    }
    public function updateSPRI(Request $request)
    {
        
        $vclaim = new VclaimController();
        $res = $vclaim->spri_update($request);
        if($res->metadata->code == 200)
        {
            $updateSPRI =  Spri::firstWhere('noSPRI', $request->noSPRI);
            $updateSPRI->tglRencanaKontrol = $request->tglRencanaKontrol;
            $updateSPRI->kodeDokter = $request->kodeDokter;
            $updateSPRI->poliKontrol = $request->poliKontrol;
            $updateSPRI->user = $request->user;
            $updateSPRI->update();
        }
        return response()->json([
            'res' => $res,
        ]);
    }

    public function cekProsesDaftarSPRI(Request $request)
    {
        $cekSPRI = Spri::where('noKartu', $request->noKartu)->where('tglRencanaKontrol', now()->format('Y-m-d'))->first();
        // dd($cekSPRI);
        return response()->json([
            'cekSPRI' => $cekSPRI,
        ]);
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

    public function pasienRanapBPJSStore(Request $request)
    {
        dd($request->all());
        $validator = $request->validate([
            "tanggal_daftar" => "required|date",
            "kodeKunjungan" => "required",
            "noMR" => "required",
            "penjamin_id" => "required",
            "idRuangan" => "required",
            "alasan_masuk_id" => "required",
            "noTelp" => "required",
            "dpjp" => "required",
            "diagnosa" => "required",
        ]);
        $counter = Kunjungan::latest('counter')
        ->where('no_rm', $request->noMR)
        ->where('status_kunjungan', 2)
        ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
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
                        'asalRujukan' => "$request->asalRujukan",
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
                    'dpjpLayan' =>'',
                    'noTelp' => $request->noTelp,
                    'user' => $user,
                ],
            ],
        ];
        $response = Http::withHeaders($signature)->post($url, $data);
        $resdescrtipt = $this->response_decrypt($response, $signature);
        $callback = json_decode($response->body());
        $sep = $resdescrtipt->response->sep->noSep;
    }
}
