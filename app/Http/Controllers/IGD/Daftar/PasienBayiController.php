<?php

namespace App\Http\Controllers\IGD\Daftar;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\PasienBayiIGD;
use App\Models\KeluargaPasien;
use App\Models\Unit;
use App\Models\PenjaminSimrs;
use App\Models\Paramedis;
use App\Models\AlasanMasuk;
use App\Models\Provinsi;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use Carbon\Carbon;
use Auth;

class PasienBayiController extends Controller
{

    public function listKunjunganUGK(Request $request)
    {
        $start         = Carbon::parse($request->start)->format('Y-m-d');
        $finish        = Carbon::parse($request->finish)->format('Y-m-d');
        $bayi          = PasienBayiIGD::get();
        $query         = Kunjungan::whereIn('kode_unit',['1012','1023','1032'])
                        ->whereNull('tgl_keluar');

        if(!empty($request->start) && !empty($request->finish))
        {
            $query->whereDate('tgl_masuk', '>=', $request->start );
            $query->whereDate('tgl_masuk', '<=', $request->finish );
        }else{
            $now = Carbon::now();
            $weekStartDate  = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate    = $now->endOfWeek()->format('Y-m-d');

            $query->whereDate('tgl_masuk', '>=', $weekStartDate );
            $query->whereDate('tgl_masuk', '<=',  $weekEndDate );
        }

        $kunjungan_igd = $query->get();
        return view('simrs.igd.daftar.pasien_bayi.bayi_kunjungan_ugk', compact('kunjungan_igd','bayi','request','start','finish'));
    }

    public function index(Request $request)
    {
        $start         = Carbon::parse($request->start)->format('Y-m-d');
        $finish        = Carbon::parse($request->finish)->format('Y-m-d');
        $bayi          = PasienBayiIGD::get();
        $query         = Kunjungan::where('prefix_kunjungan','UGK')
                        ->whereNull('tgl_keluar');

        if(!empty($request->start) && !empty($request->finish))
        {
            $query->whereDate('tgl_masuk', '>=', $request->start );
            $query->whereDate('tgl_masuk', '<=', $request->finish );
        }else{
            $now = Carbon::now();
            $weekStartDate  = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate    = $now->endOfWeek()->format('Y-m-d H:i');

            $query->whereDate('tgl_masuk', '>=', $weekStartDate );
            $query->whereDate('tgl_masuk', '<=',  $weekEndDate );
        }

        $kunjungan_igd = $query->get();
        return view('simrs.igd.daftar.pasien_bayi.pasien_bayi', compact('kunjungan_igd','bayi','request','start','finish'));
    }
    public function bayiPerorangtua(Request $request)
    {
        $data = PasienBayiIGD::where('rm_ibu', $request->detail)->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function cariBayi(Request $request)
    {
        $query = PasienBayiIGD::query();
        if($request->tanggal && !empty($request->tanggal))
        {
            $dataYesterday  = Carbon::createFromFormat('Y-m-d',  $request->tanggal);
            $yesterday      = $dataYesterday->subDays(2)->format('Y-m-d');

            $query->whereDate('tgl_lahir','>=', $yesterday);
            $query->whereDate('tgl_lahir','<=', $request->tanggal);
        }
        if ($request->rm && !empty($request->rm)) {
            $query->where('rm_ibu', $request->rm);
        }
        if ($request->nama && !empty($request->nama)) {
            $query->where('nama_ortu', 'LIKE', '%' . $request->nama . '%')->limit(50);
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $query->where('no_bpjs_ortu', 'LIKE', '%' . $request->nomorkartu.'%');
        }
        if($request->nik && !empty($request->nik))
        {
            $query->where('nik_ortu', 'LIKE', '%' .$request->nik.'%');
        }
        $bayi = $query->get();
        return view('simrs.igd.daftar.pasien_bayi.bayi_luar', compact('request','bayi'));
    }

    public function bayiStore(Request $request)
    {
        $request->validate(
            [
                'tempat_lahir_bayi' => 'required',
                'jam_lahir_bayi'    => 'required',
            ],
            [
                'tempat_lahir_bayi' => 'Tempat lahir bayi wajib diisi !',
                'jam_lahir_bayi'    => 'Jam lahir bayi belum dipilih !',
            ]);
        $ortubayi   = Pasien::firstWhere('no_rm', $request->rm_ibu_bayi);
        $cekOrtu    = KeluargaPasien::firstWhere('no_rm', $ortubayi->no_rm);

        $cek_last_rm = \DB::connection('mysql2')->table('mt_pasien')
                ->selectRaw('MAX(no_rm) + 1 AS rm_baru')
                ->whereRaw("LEFT(no_rm, 2) = '01'")
                ->first();
        $rm_bayi ='0'.$cek_last_rm->rm_baru;

        $kontak     = $ortubayi->no_hp==null? $request->no_tlp:$ortubayi->no_hp;
        $tgl_lahir_bayi = Carbon::parse($request->tgl_lahir_bayi)->format('Y-m-d');

        $bayi = new PasienBayiIGD();
        $bayi->nik_ortu             = $ortubayi->nik_bpjs;
        $bayi->no_bpjs_ortu         = $ortubayi->no_Bpjs;
        $bayi->nama_ortu            = $ortubayi->nama_px;
        $bayi->tempat_lahir_ortu    = $ortubayi->tempat_lahir;
        $bayi->alamat_lengkap_ortu  = $ortubayi->alamat;
        $bayi->no_hp_ortu           = $kontak;
        $bayi->kunjungan_ortu       = $request->kunjungan_ortu;

        $bayi->rm_bayi              = $rm_bayi;
        $bayi->rm_ibu               = $ortubayi->no_rm;
        $bayi->nama_bayi            = strtoupper( $ortubayi->nama_px.', BY NY ');
        $bayi->jk_bayi              = $request->jk_bayi;
        $bayi->tempat_lahir         = $request->tempat_lahir_bayi;
        $bayi->tgl_lahir_bayi       = $tgl_lahir_bayi;
        $bayi->is_bpjs              = (int) $request->isbpjs;
        $bayi->isbpjs_keterangan    = $request->isbpjs_keterangan;
        $bayi->jam_lahir_bayi       = $request->jam_lahir_bayi;
        if($bayi->save())
        {
            $hub =  $ortubayi->jenis_kelamin=='L'? 1 : 2 ;
            if($cekOrtu){
                $keluarga = KeluargaPasien::create([
                    'no_rm'             => $rm_bayi,
                    'nama_keluarga'     => $ortubayi->nama_px,
                    'hubungan_keluarga' => $hub,
                    'alamat_keluarga'   => $ortubayi->alamat,
                    'telp_keluarga'     => $kontak,
                    'input_date'        => Carbon::now(),
                    'Update_date'       => Carbon::now(),
                ]);
            }
            $pasien = Pasien::create([
                'no_rm'             => $rm_bayi,
                'no_Bpjs'           => '',
                'nama_px'           => strtoupper( $ortubayi->nama_px.', BY NY '),
                'jenis_kelamin'     => $request->jk_bayi,
                'tempat_lahir'      => $request->tempat_lahir_bayi,
                'tgl_lahir'         => $tgl_lahir_bayi,
                'agama'             => $ortubayi->agama,
                'pendidikan'        => '',
                'pekerjaan'         => '',
                'kewarganegaraan'   => $ortubayi->kewarganegaraan,
                'negara'            => $ortubayi->negara,
                'propinsi'          => $ortubayi->propinsi==null?$ortubayi->kode_propinsi:$ortubayi->propinsi,
                'kabupaten'         => $ortubayi->kabupaten==null? $ortubayi->kode_kabupaten:$ortubayi->kabupaten,
                'kecamatan'         => $ortubayi->kecamatan==null?$ortubayi->kode_kecamatan:$ortubayi->kecamatan,
                'desa'              => $ortubayi->desa==null?$ortubayi->kode_desa:$ortubayi->desa,
                'alamat'            => $ortubayi->alamat,
                'no_telp'           => '',
                'no_hp'             => '',
                'tgl_entry'         => Carbon::now(),
                'nik_bpjs'          => '',
                'update_date'       => Carbon::now(),
                'update_by'         => Carbon::now(),
                'kode_propinsi'     => $ortubayi->kode_propinsi,
                'kode_kabupaten'    => $ortubayi->kode_kabupaten,
                'kode_kecamatan'    => $ortubayi->kode_kecamatan,
                'kode_desa'         => $ortubayi->kode_desa,
                'no_ktp'            => '',
                'pic'               => Auth::user()->id_simrs,
                'user_create'       => Auth::user()->username,
            ]);
        }
        return redirect()->route('form-umum.ranap-bayi', ['rm'=> $rm_bayi, 'kunjungan'=>$bayi->kunjungan_ortu]);
    }

    public function ranapUMUMBayi(Request $request)
    {
        $pasien         = Pasien::firstWhere('no_rm', $request->rm);
        $unit           = Unit::whereIn('kode_unit', [2004, 2013])->get();
        $penjamin       = PenjaminSimrs::get();
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $alasanmasuk    = AlasanMasuk::whereIn('id', [1,4,5,7,12,15,13])->get();
        return view('simrs.igd.ranapbayi.bayi_umum', compact('pasien', 'unit','penjamin','paramedis','alasanmasuk'));
    }

    public function formAddBayi(Request $request)
    {
        $provinsi       = Provinsi::all();
        $provinsi_klg   = Provinsi::all();
        $negara         = Negara::all();
        $hb_keluarga    = HubunganKeluarga::whereIn('kode', ['1','2'])->get();
        $agama          = Agama::all();
        $pekerjaan      = Pekerjaan::all();
        $pendidikan     = Pendidikan::all();


        $query          = Pasien::query();
        if ($request->rm && !empty($request->rm)) {
            $query->where('no_rm', $request->rm);
        }
        if ($request->nama && !empty($request->nama)) {
            $query->where('nama_px', 'LIKE', '%' . $request->nama . '%')->limit(50);
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $query->where('no_Bpjs', $request->nomorkartu);
        }
        if($request->nik && !empty($request->nik))
        {
            $query->where('nik_bpjs', $request->nik);
        }
        if(!empty($request->nama) || !empty($request->nik) || !empty($request->nomorkartu) || !empty($request->rm))
        {
            $pasien         = $query->get();
        }else{
            $pasien         = null;
        }
        return view('simrs.igd.daftar.pasien_bayi.tambah_bayi', compact('pasien','provinsi','provinsi_klg','negara','hb_keluarga','agama','pekerjaan','pendidikan','request'));
    }

    public function formBayiStore(Request $request)
    {
        $request->validate(
            [
                'rm_ibu'            => 'required',
                'nama_bayi'         => 'required',
                'tempat_lahir_bayi' => 'required',
                'jam_lahir_bayi'    => 'required',
            ],
            [
                'rm_ibu'            => 'Orangtua Bayi wajib dipilih !',
                'nama_bayi'         => 'Nama bayi wajib diisi !',
                'tempat_lahir_bayi' => 'Tempat lahir bayi wajib diisi !',
                'jam_lahir_bayi'    => 'Jam lahir bayi belum dipilih !',
            ]);
        $ortubayi   = Pasien::firstWhere('no_rm', $request->rm_ibu);
        $cekOrtu    = KeluargaPasien::firstWhere('no_rm', $ortubayi->no_rm);

        $cek_last_rm = \DB::connection('mysql2')->table('mt_pasien')
        ->selectRaw('MAX(no_rm) + 1 AS rm_baru')
        ->whereRaw("LEFT(no_rm, 2) = '01'")
        ->first();
        $rm_bayi ='0'.$cek_last_rm->rm_baru;

        $kontak     = $ortubayi->no_hp==null? $request->no_tlp:$ortubayi->no_hp;
        $tgl_lahir_bayi = Carbon::parse($request->tgl_lahir_bayi)->format('Y-m-d');

        $bayi = new PasienBayiIGD();
        $bayi->nik_ortu             = $ortubayi->nik_bpjs;
        $bayi->no_bpjs_ortu         = $ortubayi->no_Bpjs;
        $bayi->nama_ortu            = $ortubayi->nama_px;
        $bayi->tempat_lahir_ortu    = $ortubayi->tempat_lahir;
        $bayi->alamat_lengkap_ortu  = $ortubayi->alamat;
        $bayi->no_hp_ortu           = $kontak;
        $bayi->kunjungan_ortu       = null;

        $bayi->rm_bayi              = $rm_bayi;
        $bayi->rm_ibu               = $ortubayi->no_rm;
        $bayi->nama_bayi            = strtoupper( $ortubayi->nama_px.', BY NY ');
        $bayi->jk_bayi              = $request->jk_bayi;
        $bayi->tempat_lahir         = $request->tempat_lahir_bayi;
        $bayi->tgl_lahir_bayi       = $tgl_lahir_bayi;
        $bayi->jam_lahir_bayi       = $request->jam_lahir_bayi;
        if($bayi->save())
        {
            $hub =  $ortubayi->jenis_kelamin=='L'? 1 : 2 ;
            if($cekOrtu){
                KeluargaPasien::create([
                    'no_rm'             => $rm_bayi,
                    'nama_keluarga'     => $ortubayi->nama_px,
                    'hubungan_keluarga' => $hub,
                    'alamat_keluarga'   => $ortubayi->alamat,
                    'telp_keluarga'     => $kontak,
                    'input_date'        => Carbon::now(),
                    'Update_date'       => Carbon::now(),
                ]);
            }
            Pasien::create([
                'no_rm'             => $rm_bayi,
                'no_Bpjs'           => '',
                'nama_px'           => strtoupper( $ortubayi->nama_px.', BY NY '),
                'jenis_kelamin'     => $request->jk_bayi,
                'tempat_lahir'      => $request->tempat_lahir_bayi,
                'tgl_lahir'         => $tgl_lahir_bayi,
                'agama'             => $ortubayi->agama,
                'pendidikan'        => '',
                'pekerjaan'         => '',
                'kewarganegaraan'   => $ortubayi->kewarganegaraan,
                'negara'            => $ortubayi->negara,
                'propinsi'          => $ortubayi->propinsi==null?$ortubayi->kode_propinsi:$ortubayi->propinsi,
                'kabupaten'         => $ortubayi->kabupaten==null? $ortubayi->kode_kabupaten:$ortubayi->kabupaten,
                'kecamatan'         => $ortubayi->kecamatan==null?$ortubayi->kode_kecamatan:$ortubayi->kecamatan,
                'desa'              => $ortubayi->desa==null?$ortubayi->kode_desa:$ortubayi->desa,
                'alamat'            => $ortubayi->alamat,
                'no_telp'           => '',
                'no_hp'             => '',
                'tgl_entry'         => Carbon::now(),
                'nik_bpjs'          => '',
                'update_date'       => Carbon::now(),
                'update_by'         => Carbon::now(),
                'kode_propinsi'     => $ortubayi->kode_propinsi,
                'kode_kabupaten'    => $ortubayi->kode_kabupaten,
                'kode_kecamatan'    => $ortubayi->kode_kecamatan,
                'kode_desa'         => $ortubayi->kode_desa,
                'no_ktp'            => '',
                'pic'               => Auth::user()->id_simrs,
                'user_create'       => Auth::user()->username,
            ]);
        }
        Alert::success('Tambah Bayi Berhasil!!', 'pasien bayi dengan  RM: ' . $bayi->rm_bayi . ' berhasil di tambahkan!');
        return redirect()->route('form-umum.ranap-bayi', ['rm' => $bayi->rm_bayi]);
    }
}
