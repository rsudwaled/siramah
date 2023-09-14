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
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianIGDController extends Controller
{

    public function antrianIGD()
    {
        $tgl            = Carbon::now()->format('Y-m-d');
        $antrian_pasien = AntrianPasienIGD::whereDate('tgl', '<=', $tgl)->where('status', 1)->paginate(32);
        $pasien         = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        $provinsi       = Provinsi::all();
        $provinsi_klg       = Provinsi::all();
        $negara         = Negara::all();
        $hb_keluarga    = HubunganKeluarga::all();
        $agama          = Agama::all();
        $pekerjaan      = Pekerjaan::all();
        $pendidikan      = Pendidikan::all();
        return view('simrs.igd.antrian.antrian_igd', compact('provinsi_klg','provinsi','negara','agama','pekerjaan','pendidikan','antrian_pasien','pasien','hb_keluarga'));
    }
    public function getNoAntrian(Request $request)
    {
        $antrian = AntrianPasienIGD::find($request->no);
        return response()->json($antrian);
    }
   
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
        $pasien      = Pasien::limit(100)->orderBy('tgl_entry', 'desc')->get();
 
        if($request->nik != ''){
          $pasien    = Pasien::where('nik_bpjs',$request->nik)->get();
         }
        if($request->nama != ''){
          $pasien    = Pasien::where('nama_px','LIKE','%'.$request->nama.'%')->get();
         }
        
         if($request->nik && $request->nama)
         {
             $pasien = Pasien::where('nik_bpjs',$request->nik)->get();
         }
         // if data nik dan nama ada tapi tidak singkron datanya maka munculkan alert
       return response()->json([
          'pasien' => $pasien
       ]);
     }
    
    public function pasienBaruCreate(Request $request)
    {
        
        // dd($request->all());
        $tgl_lahir = Carbon::parse($request->tgl_lahir)->format('Y-m-d');
        $last_rm = Pasien::latest('no_rm')->first();// 23982846
        $rm_last = substr($last_rm->no_rm, -6);//982846
        $add_rm_new = $rm_last +1; //982847 
        $th = substr(Carbon::now()->format('Y'), -2);//23
        $rm_new =$th.$add_rm_new;
        // dd($rm_new);
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
     public function pasiendiDaftarkan(Request $request)
     {
        //  dd($request->all());
         if($request->antrian_id== null || $request->pasien_id== null)
         {
             Alert::warning('INFORMASI!', 'silahkan pilih no antrian dan pasien yang akan di daftarkan!');
             return back();
         }
         $status_pendaftaran = $request->pendaftaran_id;
         $antrian = AntrianPasienIGD::find($request->antrian_id);
         $pasien = Pasien::where('no_rm',$request->pasien_id)->first();
         $kunjungan = \DB::connection('mysql2')->select("CALL SP_RIWAYAT_KUNJUNGAN_PX('$request->pasien_id')");
         $lay_head1 = \DB::connection('mysql2')->select("CALL `GET_NOMOR_LAYANAN_HEADER`('1002')");
         $lay_head2 = \DB::connection('mysql2')->select("CALL `GET_NOMOR_LAYANAN_HEADER`('1023')");
         $unit = Unit::limit(10)->get();
         $ruangan_ranap = Unit::where('kelas_unit', '=', "2")->where('ACT', 1)->orderBy('id','desc')->get(); //ini aslinya unit
         $ruangan = Ruangan::where('status_incharge',1)->get();
         $alasanmasuk = AlasanMasuk::limit(10)->get();
         $paramedis = Paramedis::where('spesialis', 'UMUM')->where('act', 1)->get();
         $penjamin = PenjaminSimrs::limit(10)->where('act', 1)->get();

        if($request->pendaftaran_id==0){
            return view('simrs.igd.form_igd.form_igd', compact(
                'pasien','kunjungan','unit','paramedis','penjamin',
                'lay_head1','lay_head2','alasanmasuk','ruangan_ranap',
                'ruangan','antrian','status_pendaftaran'
            ));
        }else if($request->pendaftaran_id==1){
            return view('simrs.igd.form_igd.form_igd_kebidanan', compact(
                'pasien','kunjungan','unit','paramedis','penjamin',
                'lay_head1','lay_head2','alasanmasuk','ruangan_ranap',
                'ruangan','antrian','status_pendaftaran'
            ));
        }else if($request->pendaftaran_id==2){
            return view('simrs.igd.form_igd.form_ranap', compact(
                'pasien','kunjungan','unit','paramedis','penjamin',
                'lay_head1','lay_head2','alasanmasuk','ruangan_ranap',
                'ruangan','antrian','status_pendaftaran'
            ));
        }else if($request->pendaftaran_id==3){
            return view('simrs.igd.form_igd.form_penunjang', compact(
                'pasien','kunjungan','unit','paramedis','penjamin',
                'lay_head1','lay_head2','alasanmasuk','ruangan_ranap',
                'ruangan','antrian','status_pendaftaran'
            ));    
        }else{
            Alert::warning('INFORMASI!', 'anda belum memilih jenis pendaftaran!');
            return back();
        }
     }

    // function nanti tidak dipakai

    public function getAntrian()
    {
        $tgl            = Carbon::now()->format('Y-m-d');
        $antrian_pasien = AntrianPasienIGD::whereDate('tgl', '<=', $tgl)->where('status', 1)->paginate(32);
        $pasien         = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        $provinsi       = Provinsi::all();
        $provinsi_klg       = Provinsi::all();
        $negara         = Negara::all();
        $hb_keluarga    = HubunganKeluarga::all();
        $agama          = Agama::all();
        $pekerjaan      = Pekerjaan::all();
        $pendidikan      = Pendidikan::all();
        return view('simrs.igd.pendaftaran.daftarantrian_igd', compact('provinsi_klg','provinsi','negara','agama','pekerjaan','pendidikan','antrian_pasien','pasien','hb_keluarga'));
    }


    public function daftarkanPasien(Request $request)
    {
        $antrian        = AntrianPasienIGD::find($request->antrian);
        $selct_pasien   = Pasien::limit(10)->get();
        $pasien         = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        $searc_pl       = \DB::connection('mysql2')->select("CALL WSP_PANGGIL_DATAPASIEN('$request->no_rm','$request->nama_pasien','$request->alamat','$request->nik','$request->no_bpjs')");
        // dd($searc_pl);
        return view('simrs.igd.pendaftaran.datapasien', compact('antrian','pasien','request','selct_pasien','searc_pl'));
    }

   
    public function getpasienTerpilih(Request $request)
    {
        $pasien     = Pasien::with(['desas','kecamatans','kabupatens'])->where('no_rm', $request->rm)->first();
        // $pasien  = json_encode($pasien);
        return response()->json([
            'pasien' => $pasien
         ]);
    }

    public function getKelasRuangan(Request $request)
    {
        $ruangan = Ruangan::where('id_kelas', $request->kelas_r_id)->where('status_incharge',1)->get();
        // $ruangan = json_encode($ruangan);
        return response()->json([
            'ruangan' => $ruangan
         ]);
    }
   
}
