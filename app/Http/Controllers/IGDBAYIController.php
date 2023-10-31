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
            "no_bpjs_ortu" => 'required',
            "nama_ortu" => 'required',
            "tempat_lahir_ortu" => 'required',
            "alamat_lengkap_ortu" => 'required',
            "no_hp_ortu" => 'required',
            "no_telp_ortu" => 'required',
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
            "bb_bayi" => 'required',
            "alamat_bayi" => 'required',
            
            // "isbpjs" => 'required',
        ]);

        // $last_rm = Pasien::latest('no_rm')->first(); // 23982846
        // $rm_last = substr($last_rm->no_rm, -6); //982846
        // $add_rm_new = $rm_last + 1; //982847
        // $th = substr(Carbon::now()->format('Y'), -2); //23
        // $rm_new = $th . $add_rm_new;

        // $bayi = new PasienBayiIGD();
        // $bayi->nik_ortu = $request->nik_ortu;
        // $bayi->no_bpjs_ortu = $request->no_bpjs_ortu;
        // $bayi->nama_ortu = $request->nama_ortu;
        // $bayi->tempat_lahir_ortu = $request->tempat_lahir_ortu;
        // $bayi->alamat_lengkap_ortu = $request->alamat_lengkap_ortu;
        // $bayi->no_hp_ortu = $request->no_hp_ortu;
        // $bayi->no_telp_ortu = $request->no_telp_ortu;
        // $bayi->tgl_lahir_ortu = $request->tgl_lahir_ortu;
        // $bayi->jk_ortu = $request->jk_ortu;
        // $bayi->provinsi_ortu = $request->provinsi_ortu;
        // $bayi->kab_ortu = $request->kab_ortu;
        // $bayi->kec_ortu = $request->kec_ortu;
        // $bayi->desa_ortu = $request->desa_ortu;
        // $bayi->negara_ortu = $request->negara_ortu;
        
        // $bayi->rm_bayi = $rm_new;
        // $bayi->nama_bayi = $request->nama_bayi;
        // $bayi->jk_bayi = $request->jk_bayi;
        // $bayi->tgl_lahir_bayi = $request->tgl_lahir_bayi;
        // $bayi->alamat_bayi = $request->alamat_bayi;
        // if($bayi->save())
        // {
        //         $pasien = new Pasien();
        //         $pasien->no_rm = $rm_new;
        //         $pasien->nik_bpjs = $request->nik_ortu;
        //         $pasien->no_Bpjs = $request->no_bpjs_ortu;
        //         $pasien->jk = $request->jk_ortu;
        //         if($request->jk_ortu =='L')
        //         {
        //             $pasien->nama_px = 'bayi Sdr. '.$request->nama_ortu;
        //         }else{
        //             $pasien->nama_px = 'bayi Ny. '.$request->nama_ortu;
        //         }
        //         $pasien->tempat_lahir = $request->tempat_lahir_ortu;
        //         $pasien->alamat_lengkap = $request->alamat_lengkap_ortu;
        //         $pasien->no_hp = $request->no_hp_ortu;
        //         $pasien->no_telp = $request->no_telp_ortu;
        //         $pasien->tgl_lahir = $request->tgl_lahir_ortu;
                
        //         $pasien->agama = $request->agama_ortu;
        //         $pasien->pendidikan = $request->pendidikan_ortu;
        //         $pasien->pekerjaan = $request->pekerjaan_ortu;
        //         $pasien->kewarganegaraan = $request->kewarganegaraan_ortu;
        //         $pasien->kode_propinsi = $request->provinsi_ortu;
        //         $pasien->kode_kabupaten = $request->kab_ortu;
        //         $pasien->kode_kecamatan = $request->kec_ortu;
        //         $pasien->kode_desa = $request->desa_ortu;
        //         $pasien->negara = $request->negara_ortu;
        //         $pasien->save();
        // }
        $is_bpjs = $request->isbpjs;
        if($is_bpjs > 0)
        {
            return view('simrs.igd.ranapbayi.bayi_umum');
        }else{
            return view('simrs.igd.ranapbayi.bayi_bpjs');
        }
    }
}
