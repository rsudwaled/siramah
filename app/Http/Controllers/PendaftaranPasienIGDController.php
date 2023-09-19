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
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

class PendaftaranPasienIGDController extends Controller
{
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
      $kunjungan = Kunjungan::whereDate('tgl_masuk', '<=', $tgl)->where('status_kunjungan', 1)->orderBy('tgl_masuk','desc')->paginate(32);
      return view('simrs.igd.kunjungan.kunjungan_igd', compact('kunjungan'));
    }

    public function listPasienDaftar(Request $request)
    {
      $kunjungan = Kunjungan::where('pic2', Auth::user()->id)->get();
      return view('simrs.igd.kunjungan.list_pasien_byuser', compact('kunjungan'));
    }

    public function updateNOBPJS(Request $request)
    {
      // dd($request->all());
      $data = Pasien::where('nik_bpjs', $request->nik_pas)->first();
      $data->no_Bpjs = $request->no_bpjs;
      $data->update();
      return response()->json($data, 200);
    }

    public function tutupKunjunganPasien(Request $request)
    {
      if ($request->rm_tk == null && $request->counter_tk) {
        Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
        return back();
      }
      $ttp_k = Kunjungan::where('no_rm',$request->rm_tk)->where('counter', $request->counter_tk)->first();
      if($ttp_k == null)
      {
        Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
        return back();
      }
      $ttp_k->status_kunjungan = 2;
      $ttp_k->update();
      Alert::success('success', 'Kunjungan pasien ke'.$request->counter_tk.' berhasil ditutup' );
      return back();
    }
    public function bukaKunjunganPasien(Request $request)
    {
      $buka_k = Kunjungan::where('no_rm',$request->rm_tk)->where('counter', $request->counter_tk)->first();
      if($buka_k == null)
      {
        Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
        return back();
      }
      $buka_k->status_kunjungan = 1;
      $buka_k->update();
      Alert::success('success', 'Kunjungan pasien ke'.$request->counter_tk.' berhasil dibuka' );
      return back();
    }

    public function pendaftaranIGDStore(Request $request)
    {
      $data = Kunjungan::where('no_rm',$request->rm)->where('status_kunjungan', 1)->get();
      if($data->count() > 0)
      {
        Alert::error('Proses Daftar Gagal!!', 'pasien masih memiliki status kunjungan belum ditutup!');
        return back();
      }
      $request->validate([
          "nik" => "required",
          "rm" => "required",
          "unit" => "required",
          "dokter_id" => "required",
          "tanggal" => "required",
          "penjamin_id" => "required",
          "alasan_masuk_id" => "required",
      ]);
      // counter increment
      $counter  = Kunjungan::latest('counter')->where('no_rm',$request->rm)->where('status_kunjungan', 2)->first();
      if($counter == null){$c=1;}else{$c= $counter->counter+1;}
      $unit     = Unit::findOrFail($request->unit);
      $pasien   = Pasien::where('no_rm', $request->rm)->first();
      $desa     = 'Desa '.$pasien->desas->nama_desa_kelurahan; 
      $kec      = 'Kec. '.$pasien->kecamatans->nama_kecamatan; 
      $kab      = 'Kab. '.$pasien->kabupatens->nama_kabupaten_kota; 
      $alamat   = $pasien->alamat.' ( '.$desa.' - '.$kec.' - '.$kab.' )';
      // dd($desa, $kec, $kab, $alamat);
      $save = Kunjungan::create([
        'counter'=>$c,
        "no_rm" => $request->rm,
        "kode_unit" => $unit->kode_unit,
        "tgl_masuk" => now(),
        "kode_paramedis" => $request->dokter_id,
        "status_kunjungan" => 1,
        "prefix_kunjungan" => $unit->prefix_unit,
        "kode_penjamin" => $request->penjamin_id,
        "kelas" => 3,
        "id_alasan_masuk" => $request->alasan_masuk_id,
        "pic" => 'adm-web',
      ]);
      $ant_upd  = AntrianPasienIGD::find($request->antrian);
      $ant_upd->no_rm     =$request->rm;
      $ant_upd->nama_px   =$pasien->nama_px;
      $ant_upd->kode_kunjungan =$save->kode_kunjungan;
      $ant_upd->unit      =$unit->kode_unit;
      $ant_upd->alamat    =$alamat;
      $ant_upd->status    =2;
      $ant_upd->update();
      // dd($request->all(),$save,  $c, $ant_upd);
      Alert::success('Daftar Sukses!!', 'pasien dg RM: '.$request->rm.' berhasil didaftarkan!');
      return redirect()->route('d-antrian-igd');
    }
}
