<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Unit;
use App\Models\Paramedis;
use App\Models\PenjaminSimrs;
use App\Models\AlasanMasuk;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\AntrianPasienIGD;
use App\Models\PernyataanBPJSPROSES;
use App\Models\KeluargaPasien;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use Carbon\Carbon;

class PendaftaranPasienIGDController extends Controller
{
    public function getPasien(Request $request)
    {
        $selct_pasien = Pasien::limit(10)->get();
        $pasien = Pasien::limit(200)->orderBy('tgl_entry', 'desc')->get();
        $searc_pl = \DB::connection('mysql2')->select("CALL WSP_PANGGIL_DATAPASIEN('$request->no_rm','$request->nama_pasien','$request->alamat','$request->nik','$request->no_bpjs')");
        // dd($searc_pl);
        return view('simrs.igd.pendaftaran.datapasien', compact('pasien','request','selct_pasien','searc_pl'));
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
       if($request->nobpjs != ''){
         $pasien = Pasien::where('no_Bpjs',$request->nobpjs)->get();
        }
       if($request->alamat != ''){
         $pasien = Pasien::where('alamat','LIKE','%'.$request->alamat.'%')->get();
        }
        if($request->nik && $request->nama && $request->norm && $request->nobpjs && $request->alamat)
        {
            $pasien = Pasien::where('no_rm',$request->norm)->get();
        }
        // if data nik dan nama ada tapi tidak singkron datanya maka munculkan alert
      return response()->json([
         'pasien' => $pasien
      ]);
    }
    public function daftarPasien(Request $request)
    {
        $antrian = AntrianPasienIGD::find($request->antrian);
        $pasien = Pasien::where('no_rm',$request->rm)->first();
        $kunjungan = \DB::connection('mysql2')->select("CALL SP_RIWAYAT_KUNJUNGAN_PX('$request->rm')");
        $lay_head1 = \DB::connection('mysql2')->select("CALL `GET_NOMOR_LAYANAN_HEADER`('1002')");
        $lay_head2 = \DB::connection('mysql2')->select("CALL `GET_NOMOR_LAYANAN_HEADER`('1023')");
        $unit = Unit::limit(10)->get();
        $ruangan_ranap = Unit::where('kelas_unit', '=', "2")->where('ACT', 1)->orderBy('id','desc')->get(); //ini aslinya unit
        $ruangan = Ruangan::where('status_incharge',1)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::where('spesialis', 'UMUM')->where('act', 1)->get();
        $penjamin = PenjaminSimrs::limit(10)->where('act', 1)->get();
        return view('simrs.igd.pendaftaran.kunjungan_pasien', compact(
            'pasien','kunjungan','unit','paramedis','penjamin',
            'lay_head1','lay_head2','alasanmasuk','ruangan_ranap',
            'ruangan','antrian'
        ));
    }
    public function getRuangan(Request $request)
    {
        $ruangan = \DB::connection('mysql2')->select("CALL `SP_BED_MONITORING_RUANGAN`('$request->ruangan')");
        $ruangan = json_encode($ruangan);
        // $api = new VclaimController();
        // $res = $api->sep_insert($request);
        // dd($res);
        return response()->json([
            'ruangan' => $ruangan
         ]);
    }

    public function pilihRuangan(Request $request)
    {
      // dd($request->all());
      $cekpasien =RuanganTerpilihIGD::where('pasien_id', $request->pasien_id)->first();
      $masuk = Carbon::parse($cekpasien->tgl_masuk)->format('Y-m-d');
      $tgl = Carbon::now()->format('Y-m-d');
      
      if($masuk == $tgl)
      {
       Alert::error('Error', 'pasien sudah memiliki ruangan!');
        return back();
      }
      RuanganTerpilihIGD::create([
        'ruangan_id' => $request->ruangan_id,
        'pasien_id' => $request->pasien_id,
        'tgl_masuk' => now(),
      ]);
      // Alert::success('Success', 'anda sudah memilih ruangan pasien!');
      return back();
    }

    // coba view baru nih
    public function pilihPendaftaranPasien(Request $request)
    {
      $pasien = Pasien::where('no_rm',$request->rm)->first();
      $kunjungan = \DB::connection('mysql2')->select("CALL SP_RIWAYAT_KUNJUNGAN_PX('$request->rm')");
      return view('simrs.igd.pendaftaran.pilihpendaftaranpasien', compact('pasien','kunjungan'));
    }


    // caba route baru fix view
    public function suratPernyataanPasien(Request $request)
    {
      // dd($request->all());
      // $keluarga = KeluargaPasien::where('no_rm', $request->no_rm_by_pasien)->first();
      // // dd($keluarga);
      // if($keluarga->tlp_keluarga === null || $keluarga->alamat_keluarga === null)
      // {
      //   $keluarga->update([
      //     'tlp_keluarga' => $request->tlp_keluarga_sp,
      //     'alamat_keluarga' => $request->alamat_keluarga_sp,
      //   ]);
      // }
      $pernyataan = PernyataanBPJSPROSES::create([
        'no_rm' => $request->rm_sp,
        'nama_keluarga' => $request->nama_keluarga_sp,
        'alamat_keluarga' => $request->alamat_keluarga_sp,
        'kontak' => $request->tlp_keluarga_sp,
        'tgl_batas_waktu' => $request->tgl_surat_pernyataan_sp,
        'status_proses' => 0,
      ]);
      return response()->json($pernyataan);
    }

    public function kunjunganPasienHariIni(Request $request)
    {
      $tgl       = Carbon::now()->format('Y-m-d');
      $kunjungan = Kunjungan::whereDate('tgl_masuk', '<=', $tgl)->where('status_kunjungan', 1)->paginate(32);
      return view('simrs.igd.kunjungan.kunjungan_igd', compact('kunjungan'));
    }

    public function listPasienDaftar(Request $request)
    {
      // $kunjungan = Kunjungan::where('id_user_igd', Auth::user()->id)->whereDate('tgl_masuk', '<=', $tgl)->get();
      $kunjungan = Kunjungan::where('id_user_igd', Auth::user()->id)->get();
      return view('simrs.igd.kunjungan.list_pasien_byuser', compact('kunjungan'));
    }
}
