<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Kunjungan;
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
use App\Models\TarifLayanan;
use App\Models\TarifLayananDetail;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;

class IGDBPJSController extends APIController
{
    public function getDataAntrianPasienBPJS(Request $request)
    {
        //TES
        $antrian = AntrianPasienIGD::with('isTriase')->where('status', 1)->paginate(32);
        // $antrian = AntrianPasienIGD::whereDate('tgl', now())
        //     ->where('status', 1)
        //     ->paginate(32);
        $pasien = Pasien::limit(200)
            ->orderBy('tgl_entry', 'desc')
            ->get();
        $provinsi = Provinsi::all();
        $provinsi_klg = Provinsi::all();
        $negara = Negara::all();
        $hb_keluarga = HubunganKeluarga::all();
        $agama = Agama::all();
        $pekerjaan = Pekerjaan::all();
        $pendidikan = Pendidikan::all();
        return view('simrs.igd.pasienbpjs.antrian_igd_bpjs', compact('provinsi_klg', 'provinsi', 'negara', 'agama', 'pekerjaan', 'pendidikan','antrian', 'pasien', 'hb_keluarga'));
    }
    public function searchPasienIGDBPJS(Request $request)
    {
        $s_bynik = $request->nik;
        $s_byname = $request->nama;
        $s_byaddress = $request->alamat;
        $s_bydate = $request->tglLahir;
        $s_bybpjs = $request->nobpjs;
        if ($s_bynik && $s_byname && $s_byaddress && $s_bydate && $s_bybpjs) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nik_bpjs', $s_bynik)
                ->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('no_Bpjs', 'LIKE', '%' . $s_bybpjs . '%')
                ->where('alamat', 'LIKE', '%' . $s_byaddress . '%')
                ->where('tgl_lahir', $s_bydate)
                ->limit(100)->get();
        }else{
            $pasien = Pasien::whereNotNull('no_Bpjs')->limit(100)
                ->orderBy('tgl_entry', 'desc')
                ->get();
        }
        if ($s_bynik) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nik_bpjs', $s_bynik)->limit(100)->get();
        }
        if ($s_bybpjs) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('no_Bpjs', $s_bybpjs)->limit(100)->get();
        }
        if ($s_byname) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nama_px', $s_byname)->limit(100)->get();
        }
        if ($s_byaddress) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('alamat', 'LIKE', '%' . $s_byaddress . '%')->limit(100)->get();
        }
        if ($s_bydate) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('tgl_lahir', $s_bydate)->limit(100)->get();
        }

        if ($s_bynik && $s_byname) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nik_bpjs', $s_bynik)
                ->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->limit(100)->get();
        }
        if ($s_byname && $s_bydate) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('tgl_lahir', $s_bydate)
                ->limit(100)->get();
        }
        if ($s_byname && $s_byaddress) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('alamat', 'LIKE', '%' . $s_byaddress . '%')
                ->limit(100)->get();
        }

        if ($s_byname && $s_byaddress && $s_bydate) {
            $pasien = Pasien::whereNotNull('no_Bpjs')->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('alamat', 'LIKE', '%' . $s_byaddress . '%')
                ->where('tgl_lahir', $s_bydate)
                ->limit(100)->get();
        }
        

        return response()->json([
            'pasien' => $pasien,
            'success' => true,
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

    public function pasienBPJSSTORE(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'noMR' => 'required',
            'dpjpLayan' => 'required',
            'alasan_masuk_id' => 'required',
            'lakaLantas' => 'required',
            'asalRujukan' => 'required',
            'noTelp' => 'required',
            'isBridging' => 'required',
        ],[
            'dpjpLayan' => 'Dokter DPJP Wajib dipilih, Tidak Boleh Kosong',
            'alasan_masuk_id' => 'Alasan Pasien Daftar Wajib dipilih dan tidak boleh kosong',
            'lakaLantas' => 'Status Kecelakaan Wajib dipilih, dan lengkapi data selanjutnya yang diperlukan',
            'asalRujukan' => 'Asal Rujukan Wajib dipilih, Faskes 2 (RS) - Faskes 1 (puskes)',
            'noTelp' => 'No Telepon Wajib Diisi dengan baik dan benar',
        ]);
        if ($request->isBridging == 1) {
            if($request->diagAwal==null){
                Alert::error('Error', 'bridging bpjs gagal, diagnosa wajib diisi!');
                return back();
            }
        }
        $pasien = Pasien::firstwhere('no_rm', $request->noMR);
        $user = Auth::user()->name;
        if($request->isBridging == 1)
        {
            $validator = Validator::make(request()->all(), [
                'noKartu' => 'required',
                'tglSep' => 'required',
                'asalRujukan' => 'required',
                'jnsPelayanan' => 'required',
                'diagAwal' => 'required',
                'dpjpLayan' => 'required',
                'noTelp' => 'required',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', 'data yang dikirimkan tidak lengkap!');
                return back();
            }
            $vclaim = new VclaimController();
            $url = env('VCLAIM_URL') . 'SEP/2.0/insert';
            $signature = $this->signature();
            $signature['Content-Type'] = 'application/x-www-form-urlencoded';
            $data = [
                'request' => [
                    't_sep' => [
                        'noKartu' => $request->noKartu,
                        'tglSep' => $request->tglSep,
                        'ppkPelayanan' => '1018R001',
                        'jnsPelayanan' => $request->jnsPelayanan,
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
                            'noSurat' => '',
                            'kodeDPJP' => '',
                        ],
                        'dpjpLayan' => $request->dpjpLayan,
                        'noTelp' => $request->noTelp,
                        'user' => $user,
                    ],
                ],
            ];
            $response = Http::withHeaders($signature)->post($url, $data);
            $callback = json_decode($response->body());
            $resdescrtipt = $this->response_decrypt($response, $signature);
            // dd($request->all(), $callback, $resdescrtipt);
            $sep = $resdescrtipt->response->sep->noSep;
            if ($callback->metaData->code == 200) {
                // jika sep sudah dicreate maka create kunjungan dibawah ini
                $counter = Kunjungan::latest('counter')
                    ->where('no_rm', $request->noMR)
                    ->where('status_kunjungan', 2)
                    ->first();
                if ($counter == null) {
                    $c = 1;
                } else {
                    $c = $counter->counter + 1;
                }
                $dokter = Paramedis::firstWhere('kode_dokter_jkn', $request->dpjpLayan);
                $penjamin = Penjamin::firstWhere('nama_penjamin_bpjs', $request->penjamin);
                $unit = Unit::findOrFail($request->unit);
                $desa = 'Desa ' . $pasien->desas->nama_desa_kelurahan;
                $kec = 'Kec. ' . $pasien->kecamatans->nama_kecamatan;
                $kab = 'Kab. ' . $pasien->kabupatens->nama_kabupaten_kota;
                $alamat = $pasien->alamat . ' ( ' . $desa . ' - ' . $kec . ' - ' . $kab . ' )';

                $createKunjungan = new Kunjungan();
                $createKunjungan->counter = $c;
                $createKunjungan->no_rm = $request->noMR;
                $createKunjungan->kode_unit = $unit->kode_unit;
                $createKunjungan->tgl_masuk = now();
                $createKunjungan->kode_paramedis = $dokter->kode_paramedis;
                $createKunjungan->status_kunjungan = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
                $createKunjungan->prefix_kunjungan = $unit->prefix_unit;
                $createKunjungan->kode_penjamin = $penjamin->kode_penjamin_simrs;
                $createKunjungan->kelas = 3;
                $createKunjungan->no_sep = $sep;
                $createKunjungan->diagx = $request->diagAwal;
                $createKunjungan->id_alasan_masuk = $request->alasan_masuk_id;
                $createKunjungan->pic = Auth::user()->id;
                if ($createKunjungan->save()) {
                    $ant_upd = AntrianPasienIGD::find($request->id_antrian);
                    $ant_upd->no_rm = $request->noMR;
                    $ant_upd->nama_px = $pasien->nama_px;
                    $ant_upd->kode_kunjungan = $createKunjungan->kode_kunjungan;
                    $ant_upd->unit = $unit->kode_unit;
                    $ant_upd->alamat = $alamat;
                    $ant_upd->status = 2;
                    $ant_upd->update();

                    $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
                    if ($kodelayanan == null) {
                        $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
                    }

                    $tarif_karcis = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
                    $tarif_adm = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
                    $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;
                    // create layanan header
                    $createLH = new Layanan();
                    $createLH->kode_layanan_header = $kodelayanan;
                    $createLH->tgl_entry = now();
                    $createLH->kode_kunjungan = $createKunjungan->kode_kunjungan;
                    $createLH->kode_unit = $unit->kode_unit;
                    $createLH->pic = Auth::user()->id;
                    $createLH->status_pembayaran = 'OPN';
                    if ($unit->kelas_unit == 1) {
                        $createLH->kode_tipe_transaksi = 2;
                        $createLH->status_layanan = 3; // status 3 nanti di update jadi 1
                        $createLH->total_layanan = $total_bayar_k_a;
                        $createLH->tagihan_penjamin = $total_bayar_k_a;
                        // header create
                        if ($createLH->save()) {
                            // create layanan detail
                            $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                            $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                            $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                            // create detail karcis
                            $createKarcis = new LayananDetail();
                            $createKarcis->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                            $createKarcis->kode_layanan_header = $createLH->kode_layanan_header;
                            $createKarcis->kode_tarif_detail = $unit->kode_tarif_karcis;
                            $createKarcis->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->jumlah_layanan = 1;
                            $createKarcis->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->status_layanan_detail = 'OPN';
                            $createKarcis->tgl_layanan_detail = now();
                            $createKarcis->tgl_layanan_detail_2 = now();
                            $createKarcis->row_id_header = $createLH->id;
                            $createKarcis->tagihan_penjamin = $total_bayar_k_a;
                            if ($createKarcis->save()) {
                                // create detail karcis
                                $createAdm = new LayananDetail();
                                $createAdm->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                                $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                                $createAdm->kode_tarif_detail = $unit->kode_tarif_karcis;
                                $createAdm->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->jumlah_layanan = 1;
                                $createAdm->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->status_layanan_detail = 'OPN';
                                $createAdm->tgl_layanan_detail = now();
                                $createAdm->tgl_layanan_detail_2 = now();
                                $createAdm->row_id_header = $createLH->id;
                                $createAdm->tagihan_penjamin = $total_bayar_k_a;

                                if ($createAdm->save()) {
                                    $createKunjungan->status_kunjungan = 1; //status 8 update setelah header dan detail selesai jadi 1
                                    $createKunjungan->update();

                                    $createLH->status_layanan = 2; // status 3 di update jadi 1
                                    $createLH->update();
                                }
                            }
                        }
                    }
                }
                Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan sebagai pasien bpjs!');
                return redirect()->route('pendaftaran-pasien-igdbpjs');
            } else {
                // jika response code tidak 200 maka pendaftaran digagalkan/ pasien di daftarkan dengan status pasien umum
                Alert::error('WARNING ERROR!!', 'PERINGATAN ERROR: ' . $callback->metaData->code . $callback->metaData->message);
                return back();
            }
        }else{
            $counter = Kunjungan::latest('counter')
                    ->where('no_rm', $request->noMR)
                    ->where('status_kunjungan', 2)
                    ->first();
                if ($counter == null) {
                    $c = 1;
                } else {
                    $c = $counter->counter + 1;
                }
                $dokter = Paramedis::firstWhere('kode_dokter_jkn', $request->dpjpLayan);
                $penjamin = Penjamin::firstWhere('nama_penjamin_bpjs', $request->penjamin);
                $unit = Unit::findOrFail($request->unit);
                $desa = 'Desa ' . $pasien->desas->nama_desa_kelurahan;
                $kec = 'Kec. ' . $pasien->kecamatans->nama_kecamatan;
                $kab = 'Kab. ' . $pasien->kabupatens->nama_kabupaten_kota;
                $alamat = $pasien->alamat . ' ( ' . $desa . ' - ' . $kec . ' - ' . $kab . ' )';

                $createKunjungan = new Kunjungan();
                $createKunjungan->counter = $c;
                $createKunjungan->no_rm = $request->noMR;
                $createKunjungan->kode_unit = $unit->kode_unit;
                $createKunjungan->tgl_masuk = now();
                $createKunjungan->kode_paramedis = $dokter->kode_paramedis;
                $createKunjungan->status_kunjungan = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
                $createKunjungan->prefix_kunjungan = $unit->prefix_unit;
                $createKunjungan->kode_penjamin = $penjamin->kode_penjamin_simrs;
                $createKunjungan->kelas = 3;
                $createKunjungan->no_sep = '';
                $createKunjungan->diagx = '';
                $createKunjungan->id_alasan_masuk = $request->alasan_masuk_id;
                $createKunjungan->pic = Auth::user()->id;
                if ($createKunjungan->save()) {
                    $ant_upd = AntrianPasienIGD::find($request->id_antrian);
                    $ant_upd->no_rm = $request->noMR;
                    $ant_upd->nama_px = $pasien->nama_px;
                    $ant_upd->kode_kunjungan = $createKunjungan->kode_kunjungan;
                    $ant_upd->unit = $unit->kode_unit;
                    $ant_upd->alamat = $alamat;
                    $ant_upd->status = 2;
                    $ant_upd->update();

                    $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
                    if ($kodelayanan == null) {
                        $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
                    }

                    $tarif_karcis = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
                    $tarif_adm = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
                    $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;
                    // create layanan header
                    $createLH = new Layanan();
                    $createLH->kode_layanan_header = $kodelayanan;
                    $createLH->tgl_entry = now();
                    $createLH->kode_kunjungan = $createKunjungan->kode_kunjungan;
                    $createLH->kode_unit = $unit->kode_unit;
                    $createLH->pic = Auth::user()->id;
                    $createLH->status_pembayaran = 'OPN';
                    if ($unit->kelas_unit == 1) {
                        $createLH->kode_tipe_transaksi = 2;
                        $createLH->status_layanan = 3; // status 3 nanti di update jadi 1
                        $createLH->total_layanan = $total_bayar_k_a;
                        $createLH->tagihan_penjamin = $total_bayar_k_a;
                        // header create
                        if ($createLH->save()) {
                            // create layanan detail
                            $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                            $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                            $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                            // create detail karcis
                            $createKarcis = new LayananDetail();
                            $createKarcis->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                            $createKarcis->kode_layanan_header = $createLH->kode_layanan_header;
                            $createKarcis->kode_tarif_detail = $unit->kode_tarif_karcis;
                            $createKarcis->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->jumlah_layanan = 1;
                            $createKarcis->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                            $createKarcis->status_layanan_detail = 'OPN';
                            $createKarcis->tgl_layanan_detail = now();
                            $createKarcis->tgl_layanan_detail_2 = now();
                            $createKarcis->row_id_header = $createLH->id;
                            $createKarcis->tagihan_penjamin = $total_bayar_k_a;
                            if ($createKarcis->save()) {
                                // create detail karcis
                                $createAdm = new LayananDetail();
                                $createAdm->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                                $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                                $createAdm->kode_tarif_detail = $unit->kode_tarif_karcis;
                                $createAdm->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->jumlah_layanan = 1;
                                $createAdm->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                                $createAdm->status_layanan_detail = 'OPN';
                                $createAdm->tgl_layanan_detail = now();
                                $createAdm->tgl_layanan_detail_2 = now();
                                $createAdm->row_id_header = $createLH->id;
                                $createAdm->tagihan_penjamin = $total_bayar_k_a;

                                if ($createAdm->save()) {
                                    $createKunjungan->status_kunjungan = 1; //status 8 update setelah header dan detail selesai jadi 1
                                    $createKunjungan->update();

                                    $createLH->status_layanan = 2; // status 3 di update jadi 1
                                    $createLH->update();
                                }
                            }
                        }
                    }
                }
                Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan sebagai pasien bpjs!');
                return redirect()->route('pendaftaran-pasien-igdbpjs');
        }
        
    }

    public function batalDaftar(Request $request)
    {
        // dd($request->all());
        $data =  AntrianPasienIGD::findOrFail($request->id);
        $data->no_rm = (Null);
        $data->is_px_daftar = (Null);
        $data->update();
        return response()->json($data, 200, $headers);
    }
    public function getProvinsiBPJS(Request $request)
    {
        $provinsi = new VclaimController();
        $provinsibpjs = $provinsi->ref_provinsi_api();
        return response()->json($provinsibpjs, 200, $headers);
    }
    public function getKabBPJS(Request $request)
    {
        $kab = new VclaimController();
        $kabbpjs = $kab->ref_kabupaten_api();
        return response()->json($kabbpjs, 200, $headers);
    }
    public function getKecBPJS(Request $request)
    {
        $kec = new VclaimController();
        $kecbpjs = $kec->ref_kecamatan_api();
        return response()->json($kecbpjs, 200, $headers);
    }

    // public function editPasienBPJS(Request $request)
    // {
    //     $pasien = Pasien::firstWhere('no_rm',$request->rm);
    //     $klp = KeluargaPasien::firstWhere('no_rm',$request->rm);
    //     $provinsi = Provinsi::get();
    //     $negara = Negara::get();
    //     $hb_keluarga = HubunganKeluarga::get();
    //     $agama = Agama::get();
    //     $pekerjaan = Pekerjaan::get();
    //     $pendidikan = Pendidikan::get();
    //     return view('simrs.igd.pasienbpjs.edit_pasienbpjs',compact(
    //         'klp','pasien','provinsi','negara',
    //         'hb_keluarga','agama','pekerjaan','pendidikan',
    //     ));
    // }

    // public function updatePasien(Request $request)
    // {
    //     // dd($request->all());
    //     $pasien = Pasien::firstWhere('no_rm',$request->rm);
    //     $kabUpdate = is_numeric($request->kabupaten_pasien);
    //     $kecUpdate = is_numeric($request->kecamatan_pasien);
    //     $desaUpdate = is_numeric($request->desa_pasien);
    //     if ($kabUpdate==false && $kecUpdate==false && $desaUpdate==false) {
    //         $kab = Kabupaten::firstWhere('nama_kabupaten_kota', $request->kabupaten_pasien);
    //         $kec = Kecamatan::firstWhere('nama_kecamatan', $request->kecamatan_pasien);
    //         $desa = Desa::firstWhere('nama_desa_kelurahan', $request->desa_pasien);
    //     }
    //     // dd($request->all(),$kabUpdate, $kecUpdate,$desaUpdate, $kab, $kec, $desa);
    //     $pasien->no_Bpjs            = $request->no_bpjs;
    //     $pasien->nama_px            = $request->nama_pasien_baru;
    //     $pasien->jenis_kelamin      = $request->jk;
    //     $pasien->tempat_lahir       = $request->tempat_lahir;
    //     $pasien->tgl_lahir          = $request->tgl_lahir;
    //     $pasien->agama              = $request->agama;
    //     $pasien->pendidikan         = $request->pendidikan;
    //     $pasien->pekerjaan          = $request->pekerjaan;
    //     $pasien->kewarganegaraan    = $request->kewarganegaraan;
    //     $pasien->negara             = $request->negara;
    //     $pasien->propinsi           = $request->provinsi_pasien;
    //     $pasien->kabupaten          = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
    //     $pasien->kecamatan          = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
    //     $pasien->desa               = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
    //     $pasien->kode_propinsi      = $request->provinsi_pasien;
    //     $pasien->kode_kabupaten     = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
    //     $pasien->kode_kecamatan     = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
    //     $pasien->kode_desa          = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
    //     $pasien->alamat             = $request->alamat_lengkap_pasien;
    //     $pasien->no_tlp             = $request->no_tlp;
    //     $pasien->no_hp              = $request->no_hp;
    //     $pasien->nik_bpjs           = $request->nik;
    //     if($pasien->update())
    //     {
    //         // if(is_null($request->nama_keluarga) || is_null($request->hub_keluarga) || is_null($request->alamat_lengkap_sodara)||is_null($request->kontak))
    //         // {
    //         //     return response()->json(['pasien'=>$pasien, 'status'=>201]);
    //         // }
    //         $klp = KeluargaPasien::firstWhere('no_rm',$request->rm);
    //         if(is_null($klp))
    //         {
    //             KeluargaPasien::create([
    //                 'no_rm'=>$request->rm,
    //                 'nama_keluarga' => $request->nama_keluarga,
    //                 'hubungan_keluarga' => $request->hub_keluarga,
    //                 'alamat_keluarga' => $request->alamat_lengkap_sodara,
    //                 'tlp_keluarga' => $request->tlp_keluarga,
    //                 'Update_date' => Carbon::now(),
    //             ]);

    //         }else{
    //             $klp->nama_keluarga = $request->nama_keluarga;
    //             $klp->hubungan_keluarga = $request->hub_keluarga;
    //             $klp->alamat_keluarga = $request->alamat_lengkap_sodara;
    //             $klp->tlp_keluarga = $request->tlp_keluarga;
    //             $klp->Update_date = Carbon::now();
    //             $klp->update();
    //         }
    //     }
    //     return response()->json(['pasien'=>$pasien, 'status'=>200]);
    // }
}
