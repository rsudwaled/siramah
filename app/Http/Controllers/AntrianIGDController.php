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
use Carbon\Carbon;

class AntrianIGDController extends Controller
{

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

    public function getKabPasien(Request $request)
    {
        $kabupaten = Kabupaten::where('kode_provinsi', $request->kab_prov_id)->get();
        return response()->json($kabupaten);
    }
    public function getKecPasien(Request $request)
    {
        $kecamatan = Kecamatan::where('kode_kabupaten_kota', $request->kec_kab_id)->get();
        return response()->json($kecamatan);
    }
    public function getDesaPasien(Request $request)
    {
        $desa = Desa::where('kode_kecamatan', $request->desa_kec_id)->get();
        return response()->json($desa);
    }
    public function getKlgKabPasien(Request $request)
    {
        $kabupaten = Kabupaten::where('kode_provinsi', $request->kab_prov_id)->get();
        return response()->json($kabupaten);
    }
    public function getKlgKecPasien(Request $request)
    {
        $kecamatan = Kecamatan::where('kode_kabupaten_kota', $request->kec_kab_id)->get();
        return response()->json($kecamatan);
    }
    public function getKlgDesaPasien(Request $request)
    {
        $desa = Desa::where('kode_kecamatan', $request->desa_kec_id)->get();
        return response()->json($desa);
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

    public function getpasienTerpilih(Request $request)
    {
        $pasien     = Pasien::with(['desas','kecamatans','kabupatens'])->where('no_rm', $request->rm)->first();
        // $pasien  = json_encode($pasien);
        return response()->json([
            'pasien' => $pasien
         ]);
    }

    public function pasiendiDaftarkan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'antrian_id' => 'required',
            'pasien_id' => 'required',
        ]);
    }
}
