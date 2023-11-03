<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeluargaPasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Pasien;
use App\Models\PasienBayiIGD;
use Carbon\Carbon;


class IGDBAYIController extends Controller
{
    public function pendaftaranPasienBayi()
    {
        $negara = Negara::get();
        $hb_keluarga = HubunganKeluarga::get();
        $agama = Agama::get();
        $pekerjaan = Pekerjaan::get();
        $pendidikan = Pendidikan::get();
        $provinsi = Provinsi::get();
        $kab = Kabupaten::get();
        $kec = Kecamatan::get();
        $desa = Desa::get();
        return view('simrs.igd.pendaftaran.pasien_bayi', compact('provinsi','kab','kec','desa','negara','hb_keluarga','agama','pekerjaan','pendidikan'));
    }

    public function cariOrangtua(Request $request)
    {
        $data = Pasien::where('nik_bpjs', $request->nik_ortu)->first();
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function pasienBayiCreate(Request $request)
    {
        
        $validated = $request->validate([
            "nik_ortu" => 'required',
            "nama_ortu" => 'required',
            "tempat_lahir_ortu" => 'required',
            "alamat_lengkap_ortu" => 'required',
            "no_hp_ortu" => 'required',
            "tgl_lahir_ortu" => 'required',
            "jk_ortu" =>'required',
            "agama_ortu" => 'required',
            "pendidikan_ortu" => 'required',
            "pekerjaan_ortu" => 'required',
            "kewarganegaraan_ortu" => 'required',
            "provinsi_ortu" => 'required',
            "kab_ortu" => 'required',
            "kec_ortu" => 'required',
            "desa_ortu" => 'required',
            "negara_ortu" => 'required',
            "nama_bayi" => 'required',
            "jk_bayi" => 'required',
            "tgl_lahir_bayi" => 'required',
            
        ]);

        $last_rm = Pasien::latest('no_rm')->first(); // 23982846
        $rm_last = substr($last_rm->no_rm, -6); //982846
        $add_rm_new = $rm_last + 1; //982847
        $add_rmbayi_new = $rm_last + 2; //982847
        $th = substr(Carbon::now()->format('Y'), -2); //23
        $rm_new = $th . $add_rm_new;
        $rmbayi_new = $th . $add_rmbayi_new;

        $kontak = $request->no_hp_ortu==null? $request->no_telp_ortu:$request->no_hp_ortu; 
        $rm_ibu = $request->rm_ibu == null ? $add_rm_new : $request->rm_ibu;
        $rm_bayi = $request->rm_ibu == null ? $rmbayi_new: $rm_new;

        $bayi = new PasienBayiIGD();
        $bayi->nik_ortu = $request->nik_ortu;
        $bayi->no_bpjs_ortu = $request->no_bpjs_ortu;
        $bayi->nama_ortu = $request->nama_ortu;
        $bayi->tempat_lahir_ortu = $request->tempat_lahir_ortu;
        $bayi->alamat_lengkap_ortu = $request->alamat_lengkap_ortu;
        $bayi->no_hp_ortu = $kontak;
        
        $bayi->rm_bayi  = $rm_bayi;
        $bayi->rm_ibu   = $rm_ibu;
        $bayi->nama_bayi = $request->nama_bayi;
        $bayi->jk_bayi = $request->jk_bayi;
        $bayi->tgl_lahir_bayi = $request->tgl_lahir_bayi;
        $bayi->is_bpjs = (int) $request->isbpjs;
        $bayi->isbpjs_keterangan = $request->isbpjs_keterangan;
        if($bayi->save())
        {
            if($request->rm_ibu == null)
            {
                // pasien orangtua baru create
                $ortuNew = new Pasien();
                $ortuNew->no_rm = $rm_ibu;
                $ortuNew->nik_bpjs = $request->nik_ortu;
                $ortuNew->no_Bpjs = $request->no_bpjs_ortu;
                $ortuNew->jenis_kelamin = $request->jk_ortu;
                $ortuNew->nama_px = $request->nama_ortu;
                $ortuNew->tempat_lahir = $request->tempat_lahir_ortu;
                $ortuNew->alamat = $request->alamat_lengkap_ortu;
                $ortuNew->no_hp = $kontak;
                $ortuNew->no_tlp = $kontak;
                $ortuNew->tgl_lahir = $request->tgl_lahir_ortu;
                
                $ortuNew->agama = $request->agama_ortu;
                $ortuNew->pendidikan = $request->pendidikan_ortu;
                $ortuNew->pekerjaan = $request->pekerjaan_ortu;
                $ortuNew->kewarganegaraan = $request->kewarganegaraan_ortu;
                $ortuNew->kode_propinsi = $request->provinsi_ortu;
                $ortuNew->kode_kabupaten = $request->kab_ortu;
                $ortuNew->kode_kecamatan = $request->kec_ortu;
                $ortuNew->kode_desa = $request->desa_ortu;
                $ortuNew->negara = $request->negara_ortu;
                if($ortuNew->save()){
                    // pasien bayi create
                    $pasienBayi = new Pasien();
                    $pasienBayi->no_rm = $rm_bayi;
                    $pasienBayi->jenis_kelamin = $request->jk_bayi;
                    $pasienBayi->nama_px = $request->nama_bayi;
                    $pasienBayi->tempat_lahir = $request->tempat_lahir_bayi;
                    $pasienBayi->alamat = $request->alamat_lengkap_ortu;
                    
                    $pasienBayi->agama = $request->agama_ortu;
                    $pasienBayi->kewarganegaraan = $request->kewarganegaraan_ortu;
                    $pasienBayi->kode_propinsi = $request->provinsi_ortu;
                    $pasienBayi->kode_kabupaten = $request->kab_ortu;
                    $pasienBayi->kode_kecamatan = $request->kec_ortu;
                    $pasienBayi->kode_desa = $request->desa_ortu;
                    $pasienBayi->negara = $request->negara_ortu;
                    if($pasienBayi->save()){
                        $hub =  $ortuNew->jenis_kelamin=='L'? 1 : 2 ;
                        $keluarga = KeluargaPasien::create([
                            'no_rm' => $rm_bayi,
                            'nama_keluarga' => $request->nama_ortu,
                            'hubungan_keluarga' => $hub,
                            'alamat_keluarga' => $request->alamat_lengkap_ortu,
                            'telp_keluarga' => $kontak,
                            'input_date' => Carbon::now(),
                            'Update_date' => Carbon::now(),
                        ]);
                    }
                }
            }else{
                $pasienBayi = new Pasien();
                $pasienBayi->no_rm = $rm_bayi;
                $pasienBayi->jenis_kelamin = $request->jk_bayi;
                $pasienBayi->nama_px = $request->nama_bayi;
                $pasienBayi->tempat_lahir = $request->tempat_lahir_bayi;
                $pasienBayi->alamat = $request->alamat_lengkap_ortu;
                
                $pasienBayi->agama = $request->agama_ortu;
                $pasienBayi->kewarganegaraan = $request->kewarganegaraan_ortu;
                $pasienBayi->kode_propinsi = $request->provinsi_ortu;
                $pasienBayi->kode_kabupaten = $request->kab_ortu;
                $pasienBayi->kode_kecamatan = $request->kec_ortu;
                $pasienBayi->kode_desa = $request->desa_ortu;
                $pasienBayi->negara = $request->negara_ortu;
                if($pasienBayi->save()){
                    $hub =  $ortuNew->jenis_kelamin=='L'? 1 : 2 ;
                    $keluarga = KeluargaPasien::create([
                        'no_rm' => $rm_bayi,
                        'nama_keluarga' => $request->nama_ortu,
                        'hubungan_keluarga' => $hub,
                        'alamat_keluarga' => $request->alamat_lengkap_ortu,
                        'telp_keluarga' => $kontak,
                        'input_date' => Carbon::now(),
                        'Update_date' => Carbon::now(),
                    ]);
                }
            }
        }
        return response()->json($bayi, 200);
    }
}
