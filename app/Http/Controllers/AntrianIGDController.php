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
use App\Models\AlasanMasuk;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\TriaseIGD;
use App\Models\Icd10;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DB;

class AntrianIGDController extends APIController
{
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

    public function getKabPasien(Request $request)
    {
        $kabupatenpasien = Kabupaten::where('kode_provinsi', $request->kab_prov_id)->get();
        return response()->json($kabupatenpasien);
    }
    public function getKecPasien(Request $request)
    {
        $kecamatanpasien = Kecamatan::where('kode_kabupaten_kota', $request->kec_kab_id)->get();
        return response()->json($kecamatanpasien);
    }
    public function getDesaPasien(Request $request)
    {
        $desapasien = Desa::where('kode_kecamatan', $request->desa_kec_id)->get();
        return response()->json($desapasien);
    }
    public function getKlgKabPasien(Request $request)
    {
        $kabkeluarga = Kabupaten::where('kode_provinsi', $request->klg_kab_prov_id)->get();
        return response()->json($kabkeluarga);
    }
    public function getKlgKecPasien(Request $request)
    {
        $keckeluarga = Kecamatan::where('kode_kabupaten_kota', $request->klg_kec_kab_id)->get();
        return response()->json($keckeluarga);
    }
    public function getKlgDesaPasien(Request $request)
    {
        $desakeluarga = Desa::where('kode_kecamatan', $request->klg_desa_kec_id)->get();
        return response()->json($desakeluarga);
    }

    public function searchPasien(Request $request)
    {
        $s_bynik = $request->nik;
        $s_byname = $request->nama;
        $s_byaddress = $request->alamat;
        $s_bydate = $request->tglLahir;
        // $s_bybpjs = $request->nobpjs;
        $s_byrm = $request->norm;
        if($s_bynik && $s_byname && $s_byaddress && $s_bydate && $s_byrm){
            $pasien =\DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RS_23('$s_byrm' ,'$s_byname' ,'$s_byaddress' , '' ,'$s_bynik' ,'$s_bydate')");
        }else{
            $pasien = Pasien::limit(100)
            ->orderBy('tgl_entry', 'desc')
            ->get();
        }
        
        // if($s_bynik || $s_byname || $s_byaddress || $s_bydate || $s_byrm){
        //     $pasien =\DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RS_23('$s_byrm' ,'$s_byname' ,'$s_byaddress' , '' ,'$s_bynik' ,'$s_bydate')");   
        // }
        // else{
        //     $pasien = Pasien::limit(100)
        //         ->orderBy('tgl_entry', 'desc')
        //         ->get();
        // }

        if ($s_bynik) {
            $pasien = Pasien::where('nik_bpjs', $s_bynik)->get();
        }
        if ($s_byrm) {
            $pasien = Pasien::where('no_rm', $s_byrm)->get();
        }
        if ($s_byname) {
            $pasien = Pasien::where('nama_px', $s_byname)->limit(100)->get();
        }
        if ($s_byaddress) {
            $pasien = Pasien::where('alamat', 'LIKE', '%' . $s_byaddress . '%')->limit(100)->get();
        }
        if ($s_bydate) {
            $pasien = Pasien::where('tgl_lahir', $s_bydate)->limit(100)->get();
        }

        if ($s_bynik && $s_byname) {
            $pasien = Pasien::where('nik_bpjs', $s_bynik)
                ->where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->limit(100)->get();
        }
        if ($s_byname && $s_bydate) {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('tgl_lahir', $s_bydate)
                ->limit(100)->get();
        }
        if ($s_byname && $s_byaddress) {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('alamat', 'LIKE', '%' . $s_byaddress . '%')
                ->limit(100)->get();
        }

        if ($s_byname && $s_byaddress && $s_bydate) {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $s_byname . '%')
                ->where('alamat', 'LIKE', '%' . $s_byaddress . '%')
                ->where('tgl_lahir', $s_bydate)
                ->limit(100)->get();
        }
        return response()->json([
            'pasien' => $pasien,
            'success' => true,
        ]);
    }

    public function searchPasienByName(Request $request)
    {
        $pasien = Pasien::limit(100)
            ->orderBy('tgl_entry', 'desc')
            ->get();
        if ($request->search_byname != '') {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $request->search_byname . '%')->get();
        }
        return response()->json([
            'pasien' => $pasien,
            'success' => true,
        ]);
    }

    public function pasienBaruCreate(Request $request)
    {
        
        
        $validated = $request->validate([
            'nik_pasien_baru' =>'required',
            'nama_pasien_baru' =>'required',
            'tempat_lahir' =>'required',
            'jk' =>'required',
            'tgl_lahir' =>'required',
            'agama' =>'required',
            'pekerjaan' =>'required',
            'pendidikan' =>'required',
            'no_telp' =>'required',
            'provinsi_pasien' =>'required',
            'negara' =>'required',
            'kewarganegaraan' =>'required',
            'alamat_lengkap_pasien' =>'required',
            'nama_keluarga' =>'required',
            'kontak' =>'required',
            'hub_keluarga' =>'required',
            'alamat_lengkap_sodara' =>'required',
        ]);

        $tgl_lahir = Carbon::parse($request->tgl_lahir)->format('Y-m-d');
        $last_rm = Pasien::latest('no_rm')->first(); // 23982846
        $rm_last = substr($last_rm->no_rm, -6); //982846
        $add_rm_new = $rm_last + 1; //982847
        $th = substr(Carbon::now()->format('Y'), -2); //23
        $rm_new = $th . $add_rm_new;
        
        $keluarga = KeluargaPasien::create([
            'no_rm' => $rm_new,
            'nama_keluarga' => $request->nama_keluarga,
            'hubungan_keluarga' => $request->hub_keluarga,
            'alamat_keluarga' => $request->alamat_lengkap_sodara,
            'telp_keluarga' => $request->kontak,
            'input_date' => Carbon::now(),
            'Update_date' => Carbon::now(),
        ]);
        $pasien = Pasien::create([
            'no_rm' => $rm_new,
            'no_Bpjs' => $request->no_bpjs,
            'nama_px' => $request->nama_pasien_baru,
            'jenis_kelamin' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'negara' => $request->negara,
            'propinsi' => $request->provinsi_pasien,
            'kabupaten' => $request->kabupaten_pasien,
            'kecamatan' => $request->kecamatan_pasien,
            'desa' => $request->desa_pasien,
            'alamat' => $request->alamat_lengkap_pasien,
            'no_telp' => $request->no_telp,
            'no_hp' => $request->no_hp,
            'tgl_entry' => Carbon::now(),
            'nik_bpjs' => $request->nik_pasien_baru,
            'update_date' => Carbon::now(),
            'update_by' => Carbon::now(),
            'kode_propinsi' => $request->provinsi_pasien,
            'kode_kabupaten' => $request->kabupaten_pasien,
            'kode_kecamatan' => $request->kecamatan_pasien,
            'kode_desa' => $request->desa_pasien,
            'no_ktp' => $request->nik_pasien_baru,
        ]);
        Alert::success('Yeay...!', 'anda berhasil menambahkan pasien baru!');
        return back();
    }

    public function antrianIGD()
    {
        // test
        $antrian = AntrianPasienIGD::with('isTriase')->where('status', 1)->where('kode_kunjungan', null)
            ->paginate(32);
        // dd($antrian);
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
        return view('simrs.igd.antrian.antrian_igd', compact('provinsi_klg', 'provinsi', 'negara', 'agama', 'pekerjaan', 'pendidikan', 'antrian', 'pasien', 'hb_keluarga'));
    }
    public function getNoAntrian(Request $request)
    {
        $antrian = AntrianPasienIGD::find($request->id);
        return response()->json($antrian);
    }
    public function antrianPasienUMUMTerpilih(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'required',
            'no_antri' => 'required',
        ]);

        $pasien = Pasien::where('no_rm', $request->no_rm)->first();
        
        $desa = 'Desa ' . $pasien->desas->nama_desa_kelurahan;
        $kec = 'Kec. ' . $pasien->kecamatans->nama_kecamatan;
        $kab = 'Kab. ' . $pasien->kabupatens->nama_kabupaten_kota;
        $alamat = $pasien->alamat . ' ( ' . $desa . ' - ' . $kec . ' - ' . $kab . ' )';

        $upd_thp1 =  AntrianPasienIGD::findOrFail($request->no_antri);
        $upd_thp1->no_rm = $request->no_rm;
        $upd_thp1->is_px_daftar = $request->pendaftaran_id;
        $upd_thp1->update();

        $jpdaftar = $request->pendaftaran_id;
        return redirect()->route('form-pasien',['no'=>$upd_thp1->no_antri,'rm'=> $pasien->no_rm,'jp'=>$jpdaftar]);
    }

    public function formPasienIGD(Request $request,$no, $rm, $jp)
    {
        
        $antrian = AntrianPasienIGD::firstWhere('no_antri',$no);
        $pasien = Pasien::firstWhere('no_rm', $rm);
        $tanggal =now()->format('Y-m-d');

        // cek status bpjs aktif atau tidak
        $url = env('VCLAIM_URL') . "Peserta/nik/" . $pasien->nik_bpjs . "/tglSEP/" . $tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        $resdescrtipt = $this->response_decrypt($response, $signature);
        $callback = json_decode($response->body());
        
        // dd($res);
        $kelasBPJS = null;
        $ketkelasBPJS = null;
        $jpBpjs = null;
        $ket_jpBpjs = null;
        if ($resdescrtipt->metadata->code == 200) {
            $kelasBPJS = $resdescrtipt->response->peserta->hakKelas->kode;
            $ketkelasBPJS = $resdescrtipt->response->peserta->hakKelas->keterangan;
            //jenis peserta bpjs
            $jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->kode;
            $ket_jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->keterangan;
        }
        // dd($kelasBPJS);
        $keluarga = KeluargaPasien::where('no_rm', $rm)->first();
        $hb_keluarga = HubunganKeluarga::all();
        $kunjungan = Kunjungan::where('no_rm', $rm)->get();
        $knj_aktif = Kunjungan::where('no_rm', $rm)
            ->where('status_kunjungan', 1)
            ->count();

        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::where('act', 1)
            ->get();
        $penjamin = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
        if ($jp == 1) {
            return view('simrs.igd.form_igd.form_igd', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
                'antrian','keluarga', 'hb_keluarga', 'resdescrtipt', 
                'kelasBPJS','ketkelasBPJS','jpBpjs','ket_jpBpjs',
                'knj_aktif',
            ));
        } elseif ($jp == 0) {
            return view('simrs.igd.form_igd.form_igd_kebidanan', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin','alasanmasuk', 
                'antrian', 'resdescrtipt',
                'kelasBPJS','ketkelasBPJS','jpBpjs','ket_jpBpjs',
                'keluarga', 'hb_keluarga','knj_aktif'));
        } else {
            Alert::warning('INFORMASI!', 'anda belum memilih jenis pendaftaran!');
            return back();
        }
    }
    
    public function antrianPasienBPJSTerpilih(Request $request)
    {
        // dd($request->all());
        if ($request->no_rm == null) {
            Alert::warning('INFORMASI!', 'anda belum memilih pasien!');
            return back();
        }
        if ($request->no_antri == null) {
            Alert::warning('INFORMASI!', 'anda belum memilih antrian!');
            return back();
        }
        $pasien = Pasien::where('no_rm', $request->no_rm)->first();
        
        $upd_thp1bpjs =  AntrianPasienIGD::findOrFail($request->no_antri);
        // dd($upd_thp1bpjs->no_antri);
        $upd_thp1bpjs->no_rm = $request->no_rm;
        $upd_thp1bpjs->is_px_daftar = $request->pendaftaran_id;
        $upd_thp1bpjs->update();

        $jpdaftar = $request->pendaftaran_id;
        return redirect()->route('form-pasien-bpjs',['nik'=>$request->nik,'no'=>$upd_thp1bpjs->no_antri,'rm'=> $pasien->no_rm,'jp'=>$jpdaftar]);
    }

    public function formPasienBPJS(Request $request, $nik, $no, $rm, $jp)
    {
        // get provinsi bpjs
        $data = new VclaimController();
        $provinsibpjs = $data->ref_provinsi_api($request);
        $provinsibpjs = $provinsibpjs->original;

        $antrian = AntrianPasienIGD::firstWhere('no_antri',$no);
        $status_pendaftaran = $request->jp;
        $pasien = Pasien::where('no_rm', $rm)->first();
        $icd = Icd10::limit(10)->get();
        // cek status bpjs aktif atau tidak
        $api = new VclaimController();
        $request['nik'] = $request->nik;
        $request['tanggal'] = now()->format('Y-m-d');
        $resdescrtipt = $api->peserta_nik($request);
        // dd($resdescrtipt);
        if ($resdescrtipt->metadata->code != 200) {
            Alert::warning('ERROR!', 'PASIEN BERMASALAH DENGAN :' . $resdescrtipt->metadata->message);
            return back();
        }
        $kelasBPJS = null;
        $ketkelasBPJS = null;
        $jpBpjs = null;
        $ket_jpBpjs = null;
        $statusBPJS = null;
        if ($resdescrtipt->metadata->code == 200) {
            $kelasBPJS = $resdescrtipt->response->peserta->hakKelas->kode;
            $$statusBPJS = $resdescrtipt->response->peserta->statusPeserta->kode;
            $ketkelasBPJS = $resdescrtipt->response->peserta->hakKelas->keterangan;
            //jenis peserta bpjs
            $jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->kode;
            $ket_jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->keterangan;
        }
        // dd($statusBPJS);
        $keluarga = KeluargaPasien::where('no_rm', $rm)->first();
        $hb_keluarga = HubunganKeluarga::all();
        $kunjungan = Kunjungan::where('no_rm', $rm)->get();
        $knj_aktif = Kunjungan::where('no_rm', $rm)
            ->where('status_kunjungan', 1)
            ->count();

        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::whereNotNull('kode_dokter_jkn')
            ->where('act', 1)
            ->get();
        $penjamin = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
        if ($jp == 1) {
            return view('simrs.igd.pasienbpjs.p_bpjs_rajal', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
                'antrian', 'status_pendaftaran', 'keluarga', 'hb_keluarga', 'resdescrtipt', 'kelasBPJS','statusBPJS', 
                'ketkelasBPJS', 'jpBpjs', 'ket_jpBpjs', 'icd', 'provinsibpjs', 'knj_aktif'));
        } elseif ($jp == 0) {
            return view('simrs.igd.pasienbpjs.p_bpjs_rajal_kbd', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
                'antrian', 'status_pendaftaran', 'keluarga', 'hb_keluarga', 'resdescrtipt', 'kelasBPJS','statusBPJS', 
                'ketkelasBPJS', 'jpBpjs', 'ket_jpBpjs', 'icd', 'provinsibpjs', 'knj_aktif'));
        } else {
            Alert::warning('INFORMASI!', 'anda belum memilih jenis pendaftaran!');
            return back();
        }
        
    }
   
    public function pasiendiDaftarkan(Request $request, $nik)
    {
        if ($antrian == null || $norm == null) {
            Alert::warning('INFORMASI!', 'silahkan pilih no antrian dan pasien yang akan di daftarkan!');
            return back();
        }

        $status_pendaftaran = $jp;
        $antrian = AntrianPasienIGD::find($antrian);
        $pasien = Pasien::firstWhere('no_rm', $norm);

        // cek status bpjs aktif atau tidak
        $api = new VclaimController();
        $request['nik'] = $pasien->nik_bpjs;
        $request['tanggal'] = now()->format('Y-m-d');
        $res = $api->peserta_nik($request);
        // dd($res);
        $kelasBPJS = null;
        $ketkelasBPJS = null;
        $jpBpjs = null;
        $ket_jpBpjs = null;
        if ($res->metadata->code == 200) {
            $kelasBPJS = $res->response->peserta->hakKelas->kode;
            $ketkelasBPJS = $res->response->peserta->hakKelas->keterangan;
            //jenis peserta bpjs
            $jpBpjs = $res->response->peserta->jenisPeserta->kode;
            $ket_jpBpjs = $res->response->peserta->jenisPeserta->keterangan;
        }
        // dd($kelasBPJS);
        $keluarga = KeluargaPasien::where('no_rm', $norm)->first();
        $hb_keluarga = HubunganKeluarga::all();
        $kunjungan = Kunjungan::where('no_rm', $norm)->get();
        $knj_aktif = Kunjungan::where('no_rm', $norm)
            ->where('status_kunjungan', 1)
            ->count();

        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::where('spesialis', 'UMUM')
            ->where('act', 1)
            ->get();
        $penjamin = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
       
        
        if ($jp == 0) {
            return view('simrs.igd.form_igd.form_igd', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
                'antrian', 'status_pendaftaran', 'keluarga', 'hb_keluarga', 'res', 
                'kelasBPJS','ketkelasBPJS','jpBpjs','ket_jpBpjs',
                'knj_aktif',
            ));
        } elseif ($jp == 1) {
            return view('simrs.igd.form_igd.form_igd_kebidanan', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin','alasanmasuk', 
                'antrian', 'status_pendaftaran', 
                'kelasBPJS','ketkelasBPJS','jpBpjs','ket_jpBpjs',
                'keluarga', 'hb_keluarga', 'res', 'knj_aktif'));
        } else {
            Alert::warning('INFORMASI!', 'anda belum memilih jenis pendaftaran!');
            return back();
        }
    }

    public function pasienBPJSDiDaftarkan(Request $request)
    {
        if ($request->no_antri == null || $request->pasien_id == null) {
            Alert::warning('INFORMASI!', 'silahkan pilih no antrian dan pasien yang akan di daftarkan!');
            return back();
        }

        $antrian = AntrianPasienIGD::find($request->no_antri);
        $status_pendaftaran = $request->pendaftaran_id;
        $pasien = Pasien::where('no_rm', $request->pasien_id)->first();

        // cek status bpjs aktif atau tidak
        $api = new VclaimController();
        $request['nik'] = $pasien->nik_bpjs;
        $request['tanggal'] = now()->format('Y-m-d');
        $resdescrtipt = $api->peserta_nik($request);
        // dd($resdescrtipt);
        $kelasBPJS = null;
        $ketkelasBPJS = null;
        //jenis peserta bpjs
        $jpBpjs = null;
        $ket_jpBpjs = null;
        if ($resdescrtipt->metadata->code ==200) {
            $kelasBPJS = $resdescrtipt->response->peserta->hakKelas->kode;
            $ketkelasBPJS = $resdescrtipt->response->peserta->hakKelas->keterangan;
            //jenis peserta bpjs
            $jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->kode;
            $ket_jpBpjs = $resdescrtipt->response->peserta->jenisPeserta->keterangan;
        }
        $keluarga = KeluargaPasien::where('no_rm', $rm)->first();
        $hb_keluarga = HubunganKeluarga::all();
        $kunjungan = Kunjungan::where('no_rm', $request->pasien_id)->get();
        $knj_aktif = Kunjungan::where('no_rm', $request->pasien_id)
            ->where('status_kunjungan', 1)
            ->count();

        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::where('spesialis', 'UMUM')
            ->where('act', 1)
            ->get();
        $penjamin = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
       
        
        if ($request->pendaftaran_id == 0) {
            return view('simrs.igd.pasienbpjs.p_bpjs_rajal', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
                'antrian', 'status_pendaftaran', 'keluarga', 'hb_keluarga', 'resdescrtipt',
                'kelasBPJS','ketkelasBPJS','jpBpjs','ket_jpBpjs','knj_aktif',
            ));
        } elseif ($request->pendaftaran_id == 1) {
            return view('simrs.igd.pasienbpjs.p_bpjs_ranap', compact(
                'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin','alasanmasuk', 
                'antrian', 'status_pendaftaran', 
                'keluarga', 'hb_keluarga', 'resdescrtipt', 'knj_aktif'));
        } else {
            Alert::warning('INFORMASI!', 'anda belum memilih jenis pendaftaran!');
            return back();
        }
    }
    // function nanti tidak dipakai

    public function getAntrian()
    {
        $tgl = Carbon::now()->format('Y-m-d');
        $antrian_pasien = AntrianPasienIGD::whereDate('tgl', '<=', $tgl)
            ->where('status', 1)
            ->paginate(32);
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
        return view('simrs.igd.pendaftaran.daftarantrian_igd', compact('provinsi_klg', 'provinsi', 'negara', 'agama', 'pekerjaan', 'pendidikan', 'antrian_pasien', 'pasien', 'hb_keluarga'));
    }

    public function getpasienTerpilih(Request $request)
    {
        $pasien = Pasien::with(['desas', 'kecamatans', 'kabupatens'])
            ->where('no_rm', $request->rm)
            ->first();
        // $pasien  = json_encode($pasien);
        return response()->json([
            'pasien' => $pasien,
        ]);
    }

}
