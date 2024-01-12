<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PasienIGDController extends Controller
{
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
            'tlp_keluarga' => $request->kontak,
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
    public function editPasien(Request $request)
    {
        $pasien = Pasien::firstWhere('no_rm',$request->rm);
        $klp = KeluargaPasien::firstWhere('no_rm',$request->rm);
        $provinsi = Provinsi::get();
        $kota = Kabupaten::where('kode_provinsi', $pasien->kode_propinsi)->get();
        $kecamatan = Kecamatan::where('kode_kabupaten_kota', $pasien->kode_kabupaten)->get();
        $desa = Desa::where('kode_kecamatan', $pasien->kode_kecamatan)->get();
        $negara = Negara::get();
        $hb_keluarga = HubunganKeluarga::get();
        $agama = Agama::get();
        $pekerjaan = Pekerjaan::get();
        $pendidikan = Pendidikan::get();
        return view('simrs.igd.pasienigd.edit_pasien',compact(
            'klp','pasien','provinsi','negara',
            'hb_keluarga','agama','pekerjaan','pendidikan',
            'kota','kecamatan','desa'
        ));
    }

    public function updatePasien(Request $request)
    {
        // dd($request->all());
        $pasien = Pasien::firstWhere('no_rm',$request->rm);
        $kabUpdate = is_numeric($request->kabupaten_pasien);
        $kecUpdate = is_numeric($request->kecamatan_pasien);
        $desaUpdate = is_numeric($request->desa_pasien);
        if ($kabUpdate==false && $kecUpdate==false && $desaUpdate==false) {
            $kab = Kabupaten::firstWhere('nama_kabupaten_kota', $request->kabupaten_pasien);
            $kec = Kecamatan::firstWhere('nama_kecamatan', $request->kecamatan_pasien);
            $desa = Desa::firstWhere('nama_desa_kelurahan', $request->desa_pasien);
        }
        // dd($request->all(),$kabUpdate, $kecUpdate,$desaUpdate, $kab, $kec, $desa);
        $pasien->no_Bpjs            = $request->no_bpjs;
        $pasien->nama_px            = $request->nama_pasien_baru;
        $pasien->jenis_kelamin      = $request->jk;
        $pasien->tempat_lahir       = $request->tempat_lahir;
        $pasien->tgl_lahir          = $request->tgl_lahir;
        $pasien->agama              = $request->agama;
        $pasien->pendidikan         = $request->pendidikan;
        $pasien->pekerjaan          = $request->pekerjaan;
        $pasien->kewarganegaraan    = $request->kewarganegaraan;
        $pasien->negara             = $request->negara;
        $pasien->propinsi           = $request->provinsi_pasien;
        $pasien->kabupaten          = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
        $pasien->kecamatan          = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
        $pasien->desa               = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
        $pasien->kode_propinsi      = $request->provinsi_pasien;
        $pasien->kode_kabupaten     = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
        $pasien->kode_kecamatan     = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
        $pasien->kode_desa          = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
        $pasien->alamat             = $request->alamat_lengkap_pasien;
        $pasien->no_tlp             = $request->no_tlp;
        $pasien->no_hp              = $request->no_hp;
        $pasien->nik_bpjs           = $request->nik;
        if($pasien->update())
        {
            $klp = KeluargaPasien::firstWhere('no_rm',$request->rm);
            if(is_null($klp))
            {
                KeluargaPasien::create([
                    'no_rm'=>$request->rm,
                    'nama_keluarga' => $request->nama_keluarga,
                    'hubungan_keluarga' => $request->hub_keluarga,
                    'alamat_keluarga' => $request->alamat_lengkap_sodara,
                    'tlp_keluarga' => $request->tlp_keluarga,
                    'Update_date' => Carbon::now(),
                ]);

            }else{
                $klp->nama_keluarga = $request->nama_keluarga;
                $klp->hubungan_keluarga = $request->hub_keluarga;
                $klp->alamat_keluarga = $request->alamat_lengkap_sodara;
                $klp->tlp_keluarga = $request->tlp_keluarga;
                $klp->Update_date = Carbon::now();
                $klp->update();
            }
        }
        return response()->json(['pasien'=>$pasien, 'status'=>200]);
    }

}
