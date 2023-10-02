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

class PendaftaranPasienIGDBPJSController extends APIController
{
    public function getDataAntrianPasienBPJS(Request $request)
    {
        $antrian_triase = TriaseIGD::whereDate('tgl_masuk_triase', now())
            ->where('klasifikasi_pasien', 'IGD')
            ->paginate(32);
        //TES
        $antrian = AntrianPasienIGD::where('status', 1)->paginate(32);
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
        return view('simrs.igd.pasienbpjs.antrian_igd_bpjs', compact('provinsi_klg', 'provinsi', 'negara', 'agama', 'pekerjaan', 'pendidikan', 'antrian_triase', 'antrian', 'pasien', 'hb_keluarga'));
    }

    // public function pasienBPJSCREATE(Request $request)
    // {
    //     if ($request->no_antri == null || $request->pasien_id == null) {
    //         Alert::warning('INFORMASI!', 'silahkan pilih no antrian dan pasien yang akan di daftarkan!');
    //         return back();
    //     }
    //     // get provinsi bpjs
    //     $data = new VclaimController();
    //     $provinsibpjs = $data->ref_provinsi_api($request);
    //     $provinsibpjs = $provinsibpjs->original;

    //     $antrian = AntrianPasienIGD::find($request->no_antri);
    //     $status_pendaftaran = $request->pendaftaran_id;
    //     $pasien = Pasien::where('no_rm', $request->pasien_id)->first();
    //     $icd = Icd10::limit(10)->get();
    //     // cek status bpjs aktif atau tidak
    //     $api = new VclaimController();
    //     $request['nik'] = $pasien->nik_bpjs;
    //     $request['tanggal'] = now()->format('Y-m-d');
    //     $resdescrtipt = $api->peserta_nik($request);
    //     // dd($resdescrtipt);
    //     if ($resdescrtipt->metadata->code != 200) {
    //         Alert::warning('ERROR!', 'PASIEN BERMASALAH DENGAN :' . $resdescrtipt->metadata->message);
    //         return back();
    //     }
    //     $kelasBPJS = null;
    //     $ketkelasBPJS = null;
    //     $jpBpjs = null;
    //     $ket_jpBpjs = null;
    //     $statusBPJS = null;
    //     if ($resdescrtipt->metadata->code == 200) {
    //         $kelasBPJS = $resdescrtipt->response->peserta->hakKelas->kode;
    //         $$statusBPJS = $resdescrtipt->response->peserta->statusPeserta->kode;
    //         $ketkelasBPJS = $resdescrtipt->response->peserta->hakKelas->keterangan;
    //         //jenis peserta bpjs
    //         $jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->kode;
    //         $ket_jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->keterangan;
    //     }
    //     // dd($statusBPJS);
    //     $keluarga = KeluargaPasien::where('no_rm', $pasien->no_rm)->first();
    //     $hb_keluarga = HubunganKeluarga::all();
    //     $kunjungan = Kunjungan::where('no_rm', $request->pasien_id)->get();
    //     $knj_aktif = Kunjungan::where('no_rm', $request->pasien_id)
    //         ->where('status_kunjungan', 1)
    //         ->count();

    //     $unit = Unit::limit(10)->get();
    //     $alasanmasuk = AlasanMasuk::limit(10)->get();
    //     $paramedis = Paramedis::where('spesialis', 'UMUM')
    //         ->where('act', 1)
    //         ->get();
        // $penjamin = PenjaminSimrs::limit(10)
        //     ->where('act', 1)
        //     ->get();
    //     return view('simrs.igd.pasienbpjs.p_bpjs_rajal', compact(
    //         'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
    //         'antrian', 'status_pendaftaran', 'keluarga', 'hb_keluarga', 'resdescrtipt', 'kelasBPJS','statusBPJS', 
    //         'ketkelasBPJS', 'jpBpjs', 'ket_jpBpjs', 'icd', 'provinsibpjs', 'knj_aktif'));
    // }
   
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
    // API FUNCTION END
    public function pasienBPJSSTORE(Request $request)
    {
        dd($request->all());
        if ($request->diagAwal ==null) {
            Alert::error('Error', 'Diagnosa tidak boleh kosong!');
            return back();
        }
        if ($request->dpjpLayan ==null) {
            Alert::error('Error', 'DPJP tidak boleh kosong!');
            return back();
        }
        if ($request->alasan_masuk_id ==null) {
            Alert::error('Error', 'Alasan tidak boleh kosong!');
            return back();
        }
        if ($request->lakaLantas ==null) {
            Alert::error('Error', 'Status Kecelakaan tidak boleh kosong!');
            return back();
        }
        if ($request->asalRujukan ==null) {
            Alert::error('Error', 'Alasan Rujukan tidak boleh kosong!');
            return back();
        }
        if ($request->noTelp ==null) {
            Alert::error('Error', 'No Telepon tidak boleh kosong!');
            return back();
        }
        $pasien = Pasien::firstwhere('no_rm', $request->noMR);
        $user = Auth::user()->name;

        $validator = Validator::make(request()->all(), [
            'noKartu' => 'required',
            'tglSep' => 'required',
            // "ppkPelayanan" => "required",
            'asalRujukan' => 'required',
            'jnsPelayanan' => 'required',
            'diagAwal' => 'required',
            'dpjpLayan' => 'required',
            'noTelp' => 'required',
            // "user" => "required",
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
        $resdescrtipt = $this->response_decrypt($response, $signature);
        $callback = json_decode($response->body());
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
            $penjamin = Penjamin::where('nama_penjamin_bpjs', $request->penjamin)->first();
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
            $createKunjungan->kode_paramedis = $request->dpjpLayan;
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
}
