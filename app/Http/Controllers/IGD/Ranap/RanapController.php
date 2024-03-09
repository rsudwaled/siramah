<?php

namespace App\Http\Controllers\IGD\Ranap;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;
use App\Models\PasienBayiIGD;
use App\Models\AlasanMasuk;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Unit;
use App\Models\Spri;
use App\Models\Icd10;
use App\Models\Ruangan;
use App\Models\TarifLayananDetail;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\HistoriesIGDBPJS;
use App\Models\RujukanIntern;
use Carbon\Carbon;
use DB;
use Auth;

class RanapController extends APIController
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

    public function listPasienRanap(Request $request)
    {
        $query = DB::connection('mysql2')->table('ts_kunjungan')
                    ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
                    ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
                    ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
                    ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
                    ->join('di_pasien_diagnosa_frunit', 'ts_kunjungan.kode_kunjungan', '=', 'di_pasien_diagnosa_frunit.kode_kunjungan')
                    ->select(
                        'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                        'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep',
                        'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx',
                        'mt_unit.nama_unit as nama_unit',
                        'mt_status_kunjungan.status_kunjungan as status',
                        'ts_jp_igd.is_bpjs as status_pasien_daftar',
                        'di_pasien_diagnosa_frunit.is_ranap as status_ranap',
                    )
                    ->where('ts_kunjungan.is_ranap_daftar', 0)
                    ->where('di_pasien_diagnosa_frunit.is_ranap', 1)
                    ->orderBy('tgl_kunjungan', 'desc');
        if($request->tanggal && !empty($request->tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_masuk', $request->tanggal); 
        }

        if($request->unit && !empty($request->unit))
        {
            $query->whereIn('ts_kunjungan.kode_unit', [$request->unit]); 
        }

        if(empty($request->tanggal) && empty($request->unit)){
            $query->whereDate('ts_kunjungan.tgl_masuk', now());
        }
        $assesmentRanap = $query->get();
        $unit           = Unit::whereIn('kode_unit', ['1002','1023'])->get();
        return view('simrs.igd.ranap.assesment_ranap', compact('request','assesmentRanap','unit'));
    }

    public function dataPasienRanap(Request $request)
    {
        $query = Kunjungan::with('bpjsCheckHistories','pasien','unit')->whereIn('is_ranap_daftar',['1','2','3']);
        if($request->tanggal && !empty($request->tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_masuk', $request->tanggal); 
        }

        if(empty($request->tanggal) && empty($request->unit)){
            $query->whereDate('ts_kunjungan.tgl_masuk', now());
        }
        $kunjungan = $query->get();
        return view('simrs.igd.ranap.data_pasien_ranap', compact('request','kunjungan'));
    }

    public function detailPasienRanap($kunjungan)
    {
        $kunjungan = Kunjungan::with('pasien','alasanEdit')->where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.ranap.detail_kunjungan', compact('kunjungan'));
    }
    public function ranapUmum(Request $request, $rm, $kunjungan)
    {
        $cekKunjungan   = Kunjungan::where('ref_kunjungan', $kunjungan)->first();
        if(!empty($cekKunjungan))
        {
            Alert::error('PASIEN SUDAH DIDAFTARKAN RANAP!!', 'kamar : '. $cekKunjungan->kamar.' bed : '.$cekKunjungan->no_bed);
            return back();
        }

        $kode           = $kunjungan;
        $pasien         = Pasien::where('no_rm', $rm)->first();
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kunjungan)->get();
        $paramedis      = Paramedis::where('spesialis', 'UMUM')->where('act', 1)->get();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $alasanmasuk    = AlasanMasuk::get();
        $penjamin       = PenjaminSimrs::get();
        $rujukan        = RujukanIntern::firstWhere('kode_kunjungan', $kode);
        // dd($rujukan);
        return view('simrs.igd.ranap.form_ranap', compact('pasien', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis','kode','rujukan'));
    }
    
    public function pasienRanapStore(Request $request)
    {
        if(empty($request->idRuangan))
        {
            Alert::error('RUANGAN BELUM DIPILIH!!', 'silahkan pilih ruangan terlebih dahulu!');
            return back();
        }
        if(empty($request->diagAwal))
        {
            Alert::error('DIAGNOSA BELUM DIPILIH!!', 'silahkan pilih diagnosa terlebih dahulu!');
            return back();
        }
        $request->validate(
            [
                'tanggal_daftar'    => 'required|date',
                'kodeKunjungan'     => 'required',
                'noMR'              => 'required',
                'penjamin_id'       => 'required',
                'alasan_masuk_id'   => 'required',
                'noTelp'            => 'required',
                'kode_paramedis'    => 'required',
            ],
            [
                'tanggal_daftar'    => 'Tanggal daftar wajib dipilih !',
                'kodeKunjungan'     => 'Kode kunjungan tidak ada !',
                'noMR'              => 'Kode Rekam Medis Tidak Ada !',
                'penjamin_id'       => 'Anda belum memilih penjamin !',
                'alasan_masuk_id'   => 'Alasan masuk wajib diisi !',
                'noTelp'            => 'No Telepon wajib diisi !',
                'kode_paramedis'    => 'Dokter DPJP wajib dipilih',
            ],
        );
        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }

        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);

        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->ref_kunjungan     = $request->kodeKunjungan;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->kode_paramedis;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->diagx             = $request->diagAwal??NULL;
        if(!is_null($request->pasienNitip)){
            $createKunjungan->is_ranap_daftar   = 3;
        }else{
            $createKunjungan->is_ranap_daftar   = 1;
        }
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 0;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs;

        if ($createKunjungan->save()) {
            
            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran    = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
                    $createAdm->id_layanan_detail       = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header     = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail       = $kodeTarifDetail;
                    $createAdm->total_tarif             = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan          = 1;
                    $createAdm->total_layanan           = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->status_layanan_detail   = 'OPN';
                    $createAdm->tgl_layanan_detail      = now();
                    $createAdm->tgl_layanan_detail_2    = now();
                    $createAdm->row_id_header           = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi     = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin    = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan!');
        return redirect()->route('pasien.ranap');
    }


    public function daftarRanapBPJS(Request $request, $nomorkartu, $kode)
    {
        $cekKunjungan   = Kunjungan::where('ref_kunjungan', $kode)->first();
        if(!empty($cekKunjungan))
        {
            Alert::error('PASIEN SUDAH DIDAFTARKAN RANAP!!', 'kamar : '. $cekKunjungan->kamar.' bed : '.$cekKunjungan->no_bed);
            return back();
        }

        $tanggal        = now()->format('Y-m-d');
        $url            = env('VCLAIM_URL') . "Peserta/nokartu/" . trim($nomorkartu) . "/tglSEP/" . $tanggal;
        $signature      = $this->signature();
        $response       = Http::withHeaders($signature)->get($url);
        $resdescrtipt   = $this->response_decrypt($response, $signature);
       
        if($resdescrtipt->metadata->code != 200)
        {
            Alert::error('INFORMASI BPJS!!', 'bermasalah pada : '.$resdescrtipt->metadata->message.' '.($resdescrtipt->metadata->code));
            return back();
        }
        $kodeKelas      = $resdescrtipt->response->peserta->hakKelas->kode;
        $kelas          = $resdescrtipt->response->peserta->hakKelas->keterangan;

        $pasien         = Pasien::where('no_Bpjs', 'LIKE', '%' .$nomorkartu. '%')->first();
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kode)->first();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $poli           = Unit::whereNotNull('KDPOLI')->get();
        $alasanmasuk    = AlasanMasuk::get();
        $icd            = Icd10::limit(15)->get();
        $penjamin       = PenjaminSimrs::get();
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $spri           = Spri::where('noKartu', $nomorkartu)->where('tglRencanaKontrol', now()->format('Y-m-d'))->first();
        $historyBpjs    = HistoriesIGDBPJS::firstWhere('kode_kunjungan', $kode);
        $kodeKunjungan  = $kode;
        $rujukan        = RujukanIntern::firstWhere('kode_kunjungan', $kode);
        return view('simrs.igd.ranap.form_ranap_bpjs', compact('pasien', 'icd', 'poli',  'kodeKelas', 'kelas', 'spri', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis','request','kodeKunjungan','historyBpjs','rujukan'));
    }

    public function daftarRanapBPJSStore(Request $request)
    {
        if(empty($request->idRuangan))
        {
            Alert::error('RUANGAN BELUM DIPILIH!!', 'silahkan pilih ruangan terlebih dahulu!');
            return back();
        }
        if(empty($request->diagAwal))
        {
            Alert::error('DIAGNOSA BELUM DIPILIH!!', 'silahkan pilih diagnosa terlebih dahulu!');
            return back();
        }
       
        $request->validate(
            [
                'noMR'              => 'required',
                'idRuangan'         => 'required',
                'tanggal_daftar'    => 'required|date',
                'noTelp'            => 'required',
                'alasan_masuk_id'   => 'required',
                'kode_paramedis'    => 'required',
                'penjamin_id'       => 'required',
                'lakaLantas'        => 'required',
            ],
            [
                'tanggal_daftar'    => 'Tanggal daftar wajib dipilih !',
                'kodeKunjungan'     => 'Kode kunjungan tidak ada !',
                'noMR'              => 'Kode Rekam Medis Tidak Ada !',
                'penjamin_id'       => 'Anda belum memilih penjamin !',
                'alasan_masuk_id'   => 'Alasan masuk wajib diisi !',
                'noTelp'            => 'No Telepon wajib diisi !',
                'kode_paramedis'    => 'Dokter DPJP wajib dipilih',
                'lakaLantas'        => 'Status kecelakaan wajib dipilih',
            ],
        );

        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }
        // $pasien     = Pasien::firstWhere('no_rm', $request->noMR);
        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);
        $dokter     = Paramedis::firstWhere('kode_dokter_jkn', $request->kode_paramedis);
   
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->ref_kunjungan     = $request->kodeKunjungan;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $dokter->kode_paramedis;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->diagx             = $request->diagAwal??NULL;
        $createKunjungan->crad              = $request->crad??0;
        if(!is_null($request->pasienNitip)){
            $createKunjungan->is_ranap_daftar   = 2;
        }else{
            $createKunjungan->is_ranap_daftar   = 1;
        }
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 1;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs;

        if ($createKunjungan->save()) {

            $histories = new HistoriesIGDBPJS();
            $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
            $histories->noMR            = $createKunjungan->no_rm;
            $histories->noKartu         = trim($request->noKartuBPJS);
            $histories->ppkPelayanan    = '1018R001';
            $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
            $histories->user            = Auth::user()->name;
            $histories->noTelp          = $request->noTelp;
            $histories->tglSep          = now();
            $histories->jnsPelayanan    = '1';
            $histories->klsRawatHak     = $request->kodeKelas;
            if(!is_null($request->crad))
            {
                // Aturan naik kelas BPJS. hak_kelas diambil dari form view kelas ruangan
                // 1. VVIP, 
                // 2. VIP, 
                // 3. Kelas 1, 
                // 4. Kelas 2, 
                // 5. Kelas 3, 
                // 6. ICCU, 
                // 7. ICU, 
                // 8. Diatas Kelas 1
                $naikKelasByBPJS = null;
                if($request->hak_kelas==1){$naikKelasByBPJS=3;}
                if($request->hak_kelas==2){$naikKelasByBPJS=4;}
                if($request->hak_kelas==3){$naikKelasByBPJS=5;}
                if($request->hak_kelas==4){$naikKelasByBPJS=2;}
                if($request->hak_kelas==5){$naikKelasByBPJS=1;}

                $histories->klsRawatNaik    = $naikKelasByBPJS??null;
                $histories->pembiayaan      = $request->pembiayaan??null;
                $histories->penanggungJawab = $request->penanggungJawab??null;
            }
            $histories->asalRujukan     = '2';
            $histories->tglRujukan      = now();
            $histories->noRujukan       = null;
            $histories->ppkRujukan      = null;
            $histories->diagAwal        = $request->diagAwal;
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

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran    = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
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
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi     = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin    = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }

        $kunjungan      = Kunjungan::where('kode_kunjungan', $createKunjungan->kode_kunjungan)->first();
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' Selanjutnya Silahkan Buat SPRI dan SEP Rawat Inap!');
        return redirect()->route('create-sepigd.ranap-bpjs',['kunjungan'=> $kunjungan->kode_kunjungan]);
    }

    public function getRiwayatRanap(Request $request)
    {
        $riwayat = Kunjungan::where('kode_kunjungan', $request->kode)->first();
       
        $now = Carbon::now();
        $createdAt = Carbon::parse($riwayat->tgl_keluar);
        $diffInHours = $now->diffInHours($createdAt);
        if ($diffInHours >= 24) {
            // Data sudah 24 jam
            $cekdiffInHours = 1;
        } else {
            // Data belum 24 jam
            $cekdiffInHours = 0;
        }

        if(!empty($riwayat->kode_penjamin))
        {
            $penjamin_bpjs = Penjamin::firstWhere('kode_penjamin_simrs',$riwayat->kode_penjamin);
            if(!empty($penjamin_bpjs))
            {
                $route = route("riwayat-ranap.daftarkan-pasien",[$cekdiffInHours, $riwayat->no_rm, $riwayat->kode_kunjungan]);;
            }
            $penjamin_umum = PenjaminSimrs::firstWhere('kode_penjamin',$riwayat->kode_penjamin);
            if(!empty($penjamin_umum))
            {
                $route = route("form-umum.pasien-ranap",[$riwayat->no_rm, $riwayat->kode_kunjungan]);
                // $route = route("pasien.ranap");
            }
        }
        $url = $route;
        return response()->json(['url'=>$url]);
    }
    public function formRanap1X24Jam(Request $request, $diffInHours, $rm, $kode)
    {
        $pasien         = Pasien::where('no_rm', $rm)->first();
        $tanggal        = now()->format('Y-m-d');
        $kodeKelas      = null;
        $kelas          = null;

        if(!empty($pasien->no_Bpjs))
        {
            $url            = env('VCLAIM_URL') . "Peserta/nokartu/" . trim($pasien->no_Bpjs) . "/tglSEP/" . $tanggal;
            $signature      = $this->signature();
            $response       = Http::withHeaders($signature)->get($url);
            $resdescrtipt   = $this->response_decrypt($response, $signature);

            if($resdescrtipt->metadata->code != 200)
            {
                Alert::error('INFORMASI BPJS!!', 'bermasalah pada : '.$resdescrtipt->metadata->message.' '.($resdescrtipt->metadata->code));
                return back();
            }
            $kodeKelas      = $resdescrtipt->response->peserta->hakKelas->kode;
            $kelas          = $resdescrtipt->response->peserta->hakKelas->keterangan;
        }
        
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kode)->first();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $alasanmasuk    = AlasanMasuk::get();
        $icd            = Icd10::limit(15)->get();
        $penjamin       = Penjamin::get();
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $kodeKunjungan  = $kode;
        $rujukan        = RujukanIntern::firstWhere('kode_kunjungan', $kode);
        return view('simrs.igd.ranap.form_ranap_bpjs_1x24jam', compact('pasien','diffInHours', 'icd',   'kodeKelas', 'kelas',  'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis','request','kodeKunjungan','rujukan'));
    }

    public function createRanap1X24Jam(Request $request)
    {

        if(empty($request->idRuangan))
        {
            Alert::error('RUANGAN BELUM DIPILIH!!', 'silahkan pilih ruangan terlebih dahulu!');
            return back();
        }
        if(empty($request->diagAwal))
        {
            Alert::error('DIAGNOSA BELUM DIPILIH!!', 'silahkan pilih diagnosa terlebih dahulu!');
            return back();
        }
       
        $request->validate(
            [
                'noMR'              => 'required',
                'idRuangan'         => 'required',
                'tanggal_daftar'    => 'required|date',
                'noTelp'            => 'required',
                'alasan_masuk_id'   => 'required',
                'kode_paramedis'    => 'required',
                'penjamin_id'       => 'required',
                'lakaLantas'        => 'required',
            ],
            [
                'tanggal_daftar'    => 'Tanggal daftar wajib dipilih !',
                'kodeKunjungan'     => 'Kode kunjungan tidak ada !',
                'noMR'              => 'Kode Rekam Medis Tidak Ada !',
                'penjamin_id'       => 'Anda belum memilih penjamin !',
                'alasan_masuk_id'   => 'Alasan masuk wajib diisi !',
                'noTelp'            => 'No Telepon wajib diisi !',
                'kode_paramedis'    => 'Dokter DPJP wajib dipilih',
                'lakaLantas'        => 'Status kecelakaan wajib dipilih',
            ],
        );

        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            if($request->diffInHours == 0)
            {
                $c = $counter->counter;
            }else{
                $c = $counter->counter + 1;
            }
        }
        // $pasien     = Pasien::firstWhere('no_rm', $request->noMR);
        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);
        $dokter     = Paramedis::firstWhere('kode_dokter_jkn', $request->kode_paramedis);
   
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->ref_kunjungan     = $request->kodeKunjungan;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $dokter->kode_paramedis;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->diagx             = $request->diagAwal??NULL;
        $createKunjungan->crad              = $request->crad??0;
        if(!is_null($request->pasienNitip && $request->pasienNitip ==1)){
            $createKunjungan->is_ranap_daftar   = 2;
        }else{
            $createKunjungan->is_ranap_daftar   = 1;
        }
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 1;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs;

        if ($createKunjungan->save()) {

            $histories = new HistoriesIGDBPJS();
            $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
            $histories->noMR            = $createKunjungan->no_rm;
            $histories->noKartu         = trim($request->noKartuBPJS);
            $histories->ppkPelayanan    = '1018R001';
            $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
            $histories->user            = Auth::user()->name;
            $histories->noTelp          = $request->noTelp;
            $histories->tglSep          = now();
            $histories->jnsPelayanan    = '1';
            $histories->klsRawatHak     = $request->kodeKelas;
            if(!is_null($request->crad))
            {
                // Aturan naik kelas BPJS. hak_kelas diambil dari form view kelas ruangan
                // 1. VVIP, 
                // 2. VIP, 
                // 3. Kelas 1, 
                // 4. Kelas 2, 
                // 5. Kelas 3, 
                // 6. ICCU, 
                // 7. ICU, 
                // 8. Diatas Kelas 1
                $naikKelasByBPJS = null;
                if($request->hak_kelas==1){$naikKelasByBPJS=3;}
                if($request->hak_kelas==2){$naikKelasByBPJS=4;}
                if($request->hak_kelas==3){$naikKelasByBPJS=5;}
                if($request->hak_kelas==4){$naikKelasByBPJS=2;}
                if($request->hak_kelas==5){$naikKelasByBPJS=1;}

                $histories->klsRawatNaik    = $naikKelasByBPJS??null;
                $histories->pembiayaan      = $request->pembiayaan??null;
                $histories->penanggungJawab = $request->penanggungJawab??null;
            }
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

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran    = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
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
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi     = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin    = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }

        $kunjungan      = Kunjungan::where('kode_kunjungan', $createKunjungan->kode_kunjungan)->first();
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' Selanjutnya Silahkan Buat SPRI dan SEP Rawat Inap!');
        return redirect()->route('create-sepigd.ranap-bpjs',['kunjungan'=> $kunjungan->kode_kunjungan]);
    }

    public function ranapCreateSEPRanap(Request $request, $kunjungan)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.ranap.selesaikan_ranap', compact('kunjungan', 'request'));
    }

    //BRIDGING KE BPJS 
    public function createSPRI(Request $request)
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
    public function getSPRI(Request $request)
    {
        $spri = Spri::firstWhere('noSPRI', $request->noSuratKontrol);
        return response()->json([
            'spri' => $spri,
        ]);
    }
    public function updateSPRI(Request $request)
    {
        $vclaim = new VclaimController();
        $res    = $vclaim->spri_update($request);
        if ($res->metadata->code == 200) {
            $updateSPRI                     = Spri::firstWhere('noSPRI', $request->noSPRI);
            $updateSPRI->tglRencanaKontrol  = $request->tglRencanaKontrol;
            $updateSPRI->kodeDokter         = $request->kodeDokter;
            $updateSPRI->poliKontrol        = $request->poliKontrol;
            $updateSPRI->user               = $request->user;
            $updateSPRI->update();
        }
        return response()->json([
            'res' => $res,
        ]);
    }

    public function cekProsesDaftarSPRI(Request $request)
    {
        $cekSPRI = Spri::where('noKartu', $request->noKartu)
            ->where('tglRencanaKontrol', now()->format('Y-m-d'))
            ->first();
            
        return response()->json([
            'cekSPRI' => $cekSPRI,
        ]);
    }


    public function bridgingSEPIGD(Request $request)
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
                    'noKartu'   => trim($histories->noKartu),
                    'tglSep'    => $histories->tglSep,
                    'ppkPelayanan'  => '1018R001',
                    'jnsPelayanan'  => $histories->jnsPelayanan,
                    'klsRawat'      => [
                        'klsRawatHak'       => $histories->klsRawatHak,
                        'klsRawatNaik'      => $histories->klsRawatNaik??'',
                        'pembiayaan'        => $histories->pembiayaan??'',
                        'penanggungJawab'   => $histories->penanggungJawab??'',
                    ],
                    'noMR'      => $histories->noMR,
                    'rujukan'   => [
                        'asalRujukan'   => $histories->asalRujukan == null?'':$histories->asalRujukan,
                        'tglRujukan'    => $histories->tglRujukan,
                        'noRujukan'     => $spri->noSPRI??'',
                        'ppkRujukan'    => '1018R001',
                    ],
                    'catatan'   => '',
                    'diagAwal'  => $kunjungan->diagx==null? $histories->diagAwal:$kunjungan->diagx,
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
                        'lakaLantas'    => $histories->lakaLantas == null? 0 : $histories->lakaLantas,
                        'noLP'          => $histories->noLP == null ? '' : $histories->noLP,
                        'penjamin'      => [
                            'tglKejadian'   => $histories->lakaLantas == null ? '' : $histories->tglKejadian,
                            'keterangan'    => $histories->keterangan == null ? '' : $histories->keterangan,
                            'suplesi'       => [
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
            $histories->diagAwal        = $kunjungan->diagx;
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

    public function deleteSEP(Request $request)
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

    // pasien ranap bayi
    public function ranapBPJSBayi(Request $request)
    {
        $pasien                 = PasienBayiIGD::firstWhere('rm_bayi', $request->rmby);
        $vlcaim                 = new VclaimController();
        $request['nomorkartu']  = $request->nomorkartu;
        $request['tanggal']     = now()->format('Y-m-d');
        $res                    = $vlcaim->peserta_nomorkartu($request);
        
        $kodeKelas      = $res->response->peserta->hakKelas->kode;
        $kelas          = $res->response->peserta->hakKelas->keterangan;
        $alasanmasuk    = AlasanMasuk::whereNotIn('id', [2,7, 3,13,9])->get();
        $icd            = Icd10::limit(15)->get();
        return view('simrs.igd.ranapbayi.bayi_bpjs', compact('kodeKelas','kelas','pasien','alasanmasuk','icd'));
    }
    
    public function getBedByRuangan(Request $request)
    {
        $bed = Ruangan::where('kode_unit', $request->unit)
            ->where('id_kelas', $request->kelas)
            ->where('status', 1)
            ->where('status_incharge', 0)
            ->get();
        return response()->json([
            'bed' => $bed,
        ]);
    }

    public function formRanapBayi($rm)
    {
        $cekKunjungan = Kunjungan::where('no_rm', $rm)->whereDate('tgl_masuk', now())->get();
        if($cekKunjungan->count() > 0)
        {
            Alert::info('Pasien Sudah Daftar!!', 'pasien dg RM: ' . $rm . ' sudah terdaftar dikunjungan hari!');
            return redirect()->route('pasien-bayi.cari');
        }
        $pasien         = Pasien::firstWhere('no_rm', $rm);
        $unit           = Unit::whereIn('kode_unit', [2004, 2013])->get();
        $penjamin       = PenjaminSimrs::get();
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $alasanmasuk    = AlasanMasuk::whereIn('id', [1,4,5,7,12,15,13])->get();
        return view('simrs.igd.ranapbayi.bayi_umum', compact('pasien', 'unit','penjamin','paramedis','alasanmasuk'));
    }


    public function ranapBayiStore(Request $request)
    {
        $cekKunjungan = Kunjungan::where('no_rm', $request->noMR)->whereDate('tgl_masuk', now())->get();
        if($cekKunjungan->count() > 0)
        {
            Alert::success('Pasien Sudah Daftar!!', 'pasien dg RM: ' . $request->noMR . ' sudah terdaftar dikunjungan!');
            return redirect()->route('pasien-bayi.cari');
        }

        $request->validate(
            [
                'tanggal_daftar'    => 'required|date',
                'noMR'              => 'required',
                'penjamin_id'       => 'required',
                'idRuangan'         => 'required',
                'alasan_masuk_id'   => 'required',
                'dpjp'              => 'required',
                'isBpjs'            => 'required',
            ],
            [
                'idRuangan'         => 'Anda harus memilih ruangan terlebih dahulu!',
                'tanggal'           => 'Tanggal pendaftaran wajib dipilih !',
                'alasan_masuk_id'   => 'Alasan daftar wajib dipilih !',
                'isBpjs'            => 'Anda harus memilih pasien didaftarkan sebagai pasien bpjs/umum !',
                'dpjp'              => 'Anda harus memilih dokter dpjp !',
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
       
        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);

        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->dpjp;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         =  $ruangan->id_kelas;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->id_ruangan        = $request->idRuangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs;
        $createKunjungan->jp_daftar         = $request->input('bpjsProses') == null ? $request->isBpjs : 2;

        if ($createKunjungan->save()) {
            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc    = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
                    $createAdm->id_layanan_detail       = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header     = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail       = $unit->kode_tarif_karcis;
                    $createAdm->total_tarif             = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan          = 1;
                    $createAdm->total_layanan           = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->status_layanan_detail   = 'OPN';
                    $createAdm->tgl_layanan_detail      = now();
                    $createAdm->tgl_layanan_detail_2    = now();
                    $createAdm->row_id_header           = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi     = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin    = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->is_ranap_daftar   = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->form_send_by      = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan!');
        return redirect()->route('pasien.ranap');
    }

    public function getDokterByPoli(Request $request)
    {
        $unit = Unit::where('KDPOLI', $request->kodePoli)->first();
        $dokter = Paramedis::where('unit', $unit->kode_unit)->get();
        $data = array();
        foreach ($dokter as $item) {
            $data[] = array(
                "id" => $item->kode_dokter_jkn,
                "text" => $item->nama_paramedis . " (" . $item->kode_dokter_jkn . ")"
            );
        }
        return response()->json($data);
    }
}
