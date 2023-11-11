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
use App\Models\Kunjungan;
use App\Models\PasienBayiIGD;
use Carbon\Carbon;
use Validator;


class IGDBAYIController extends Controller
{
    public function pendaftaranPasienBayi()
    {
        $kunjungan_igd = Kunjungan::where('prefix_kunjungan','UGK')->get();
        $bayi          = PasienBayiIGD::get();
        return view('simrs.igd.pendaftaran.pasien_bayi', compact('kunjungan_igd','bayi'));
    }

    public function cariOrangtua(Request $request)
    {
        $data = Pasien::where('nik_bpjs', $request->nik_ortu)->first();
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }

    public function bayiPerorangtua(Request $request)
    {
        $bayi = PasienBayiIGD::where('rm_ibu', $request->detail)->get();
        return response()->json([
            'data' => $bayi,
        ]);
    }

    public function pasienBayiCreate(Request $request)
    {
        $ortubayi = Pasien::firstWhere('no_rm', $request->rm);
        $cekOrtu = KeluargaPasien::firstWhere('no_rm', $ortubayi->no_rm);
        $last_rm = Pasien::latest('no_rm')->first(); // 23982846
        $rm_last = substr($last_rm->no_rm, -6); //982846
        $add_rm_new = $rm_last + 1; //982847
        $th = substr(Carbon::now()->format('Y'), -2); //23
        $rm_bayi = $th . $add_rm_new;
        $kontak = $ortubayi->no_hp==null? $request->no_tlp:$ortubayi->no_hp; 
        $tgl_lahir_bayi = Carbon::parse($request->tgl_lahir_bayi)->format('Y-m-d');

        $bayi = new PasienBayiIGD();
        $bayi->nik_ortu = $ortubayi->nik_bpjs;
        $bayi->no_bpjs_ortu = $ortubayi->no_Bpjs;
        $bayi->nama_ortu = $ortubayi->nama_px;
        $bayi->tempat_lahir_ortu = $ortubayi->tempat_lahir;
        $bayi->alamat_lengkap_ortu = $ortubayi->alamat;
        $bayi->no_hp_ortu = $kontak;
        $bayi->kunjungan_ortu = $request->kunjungan;
        
        $bayi->rm_bayi  = $rm_bayi;
        $bayi->rm_ibu   = $ortubayi->no_rm;
        $bayi->nama_bayi = $request->nama_bayi;
        $bayi->jk_bayi = $request->jk_bayi;
        $bayi->tempat_lahir = $request->tempat_lahir_bayi;
        $bayi->tgl_lahir_bayi = $tgl_lahir_bayi;
        $bayi->is_bpjs = (int) $request->isbpjs;
        $bayi->isbpjs_keterangan = $request->isbpjs_keterangan;
        if($bayi->save())
        {
            $hub =  $ortubayi->jenis_kelamin=='L'? 1 : 2 ;
            if($cekOrtu){
                $keluarga = KeluargaPasien::create([
                    'no_rm' => $rm_bayi,
                    'nama_keluarga' =>$ortubayi->nama_px,
                    'hubungan_keluarga' => $hub,
                    'alamat_keluarga' => $ortubayi->alamat,
                    'telp_keluarga' => $kontak,
                    'input_date' => Carbon::now(),
                    'Update_date' => Carbon::now(),
                ]);
            }
            $pasien = Pasien::create([
                'no_rm' => $rm_bayi,
                'no_Bpjs' => '',
                'nama_px' => $request->nama_bayi,
                'jenis_kelamin' => $request->jk_bayi,
                'tempat_lahir' => $request->tempat_lahir_bayi,
                'tgl_lahir' => $tgl_lahir_bayi,
                'agama' => $ortubayi->agama,
                'pendidikan' => '',
                'pekerjaan' => '',
                'kewarganegaraan' => $ortubayi->kewarganegaraan,
                'negara' => $ortubayi->negara,
                'propinsi' => $ortubayi->provinsi_pasien,
                'kabupaten' => $ortubayi->kabupaten_pasien,
                'kecamatan' => $ortubayi->kecamatan_pasien,
                'desa' => $ortubayi->desa_pasien,
                'alamat' => $ortubayi->alamat_lengkap_pasien,
                'no_telp' => '',
                'no_hp' => '',
                'tgl_entry' => Carbon::now(),
                'nik_bpjs' => '',
                'update_date' => Carbon::now(),
                'update_by' => Carbon::now(),
                'kode_propinsi' => $ortubayi->provinsi_pasien,
                'kode_kabupaten' => $ortubayi->kabupaten_pasien,
                'kode_kecamatan' => $ortubayi->kecamatan_pasien,
                'kode_desa' => $ortubayi->desa_pasien,
                'no_ktp' => '',
            ]);
        }
        return response()->json(['bayi'=>$bayi, 'status'=>200]);
    }
}
