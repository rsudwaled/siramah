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
        $negara = Negara::get();
        $hb_keluarga = HubunganKeluarga::get();
        $agama = Agama::get();
        $pekerjaan = Pekerjaan::get();
        $pendidikan = Pendidikan::get();
        $provinsi = Provinsi::get();
        $kab = Kabupaten::get();
        $kec = Kecamatan::get();
        $desa = Desa::get();
        $kunjungan_igd = Kunjungan::where('prefix_kunjungan','UGK')->get();
        return view('simrs.igd.pendaftaran.pasien_bayi', compact('provinsi','kab','kec','desa','negara','hb_keluarga','agama','pekerjaan','pendidikan','kunjungan_igd'));
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
        
        $last_rm = Pasien::latest('no_rm')->first(); // 23982846
        $rm_last = substr($last_rm->no_rm, -6); //982846
        $add_rm_new = $rm_last + 1; //982847
        $add_rmbayi_new = $rm_last + 2; //982847
        $th = substr(Carbon::now()->format('Y'), -2); //23
        $rm_new = $th . $add_rm_new;
        $rmbayi_new = $th . $add_rmbayi_new;

        $kontak = $request->no_hp_ortu==null? $request->no_telp_ortu:$request->no_hp_ortu; 
        $rm_ibu = $request->rm_ibu == null ? $rm_new : $request->rm_ibu;
        $rm_bayi = $request->rm_ibu == null ? $rmbayi_new: $rm_new;
        $tgl_lahir_bayi = Carbon::parse($request->tgl_lahir_bayi)->format('Y-m-d');

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
        $bayi->tgl_lahir_bayi = $tgl_lahir_bayi;
        $bayi->is_bpjs = (int) $request->isbpjs;
        $bayi->isbpjs_keterangan = $request->isbpjs_keterangan;
        if($bayi->save())
        {
            $hub =  $request->jk_ortu=='L'? 1 : 2 ;
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
        return redirect()->route('ranapumum.bayi',['rm'=>$bayi->rm_bayi]);
    }
}
