<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntrianPasienIGD;
use App\Models\Pasien;
use Carbon\Carbon;
use App\Models\Link;
use App\Models\LinkList;

class AntrianIGDController extends Controller
{
    public function getAntrian()
    {
        $tgl = Carbon::now()->format('Y-m-d');
        $antrian_pasien = AntrianPasienIGD::whereDate('tgl', '<=', $tgl)->where('status', 1)->paginate(24);
        $pasien = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        return view('simrs.igd.pendaftaran.daftarantrian_igd', compact('antrian_pasien','pasien'));
    }

    public function daftarkanPasien(Request $request)
    {
        $antrian =AntrianPasienIGD::find($request->antrian);
        $selct_pasien = Pasien::limit(10)->get();
        $pasien = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        $searc_pl = \DB::connection('mysql2')->select("CALL WSP_PANGGIL_DATAPASIEN('$request->no_rm','$request->nama_pasien','$request->alamat','$request->nik','$request->no_bpjs')");
        // dd($searc_pl);
        return view('simrs.igd.pendaftaran.datapasien', compact('antrian','pasien','request','selct_pasien','searc_pl'));
    }

    public function searchPasien(Request $request)
   {
       $pasien = Pasien::limit(100)->orderBy('tgl_entry', 'desc')->get();

       if($request->nik != ''){
         $pasien = Pasien::where('nik_bpjs','LIKE','%'.$request->nik.'%')->get();
        }
       if($request->nama != ''){
         $pasien = Pasien::where('nama_px','LIKE','%'.$request->nama.'%')->get();
        }
       if($request->norm != ''){
         $pasien = Pasien::where('no_rm',$request->norm)->get();
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
        $pasien = Pasien::with(['desas','kecamatans','kabupatens'])->where('no_rm', $request->rm)->first();
        // $pasien = json_encode($pasien);
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
