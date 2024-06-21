<?php

namespace App\Http\Controllers\IGD\Pasien;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CekPasienPulangExport;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Pasien;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\KeluargaPasien;
use App\Models\Unit;
use Carbon\Carbon;
use Auth;
use DB;

class PasienIGDController extends Controller
{
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
    public function index(Request $request)
    {
        $provinsi       = Provinsi::all();
        $kabupaten      = Kabupaten::where('kode_kabupaten_kota','3209')->get();
        $kecamatan      = Kecamatan::where('kode_kabupaten_kota','3209')->get();
        $negara         = Negara::all();
        $hb_keluarga    = HubunganKeluarga::orderBy('kode','asc')->get();
        $agama          = Agama::orderBy('ID','asc')->get();
        $pekerjaan      = Pekerjaan::all();
        $pendidikan     = Pendidikan::all();
        return view('simrs.igd.pasienigd.tambah_pasien',
            compact('provinsi','kabupaten','kecamatan',
                'negara','hb_keluarga','agama','pekerjaan','pendidikan'
            ));
    }

    public function pasienBaruIGD(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'nik_pasien_baru'   =>'required|numeric',
                'nama_pasien_baru'  =>'required',
                'tempat_lahir'      =>'required',
                'jk'                =>'required',
                'tgl_lahir'         =>'required',
                'agama'             =>'required',
                'pekerjaan'         =>'required',
                'pendidikan'        =>'required',
                'no_telp'           =>'required|numeric',
                'provinsi_pasien'   =>'required',
                'kewarganegaraan'   =>'required',
                'alamat_lengkap_pasien' =>'required',
                'nama_keluarga'     =>'required',
                'hub_keluarga'      =>'required',
            ],
            [
                'nik_pasien_baru'       =>'nik pasien wajib diisi',
                'nik_pasien_baru.max'   =>'nik maksimal 16 digit dan bentuknya number',
                'nik_pasien_baru.min'   =>'nik minimal 16 digit dan bentuknya number',
                'nama_pasien_baru'      =>'nama pasien wajib diisi',
                'tempat_lahir'          =>'tempat lahir wajib diisi',
                'jk'                    =>'jenis kelamin wajib dipilih',
                'tgl_lahir'             =>'tanggal lahir wajib diisi',
                'agama'                 =>'agama wajib dipilih',
                'pekerjaan'             =>'pekerjaan wajib dipilih',
                'pendidikan'            =>'pendidikan wajib dipilih',
                'no_telp'               =>'no telpon wajib diisi',
                'no_telp.max'           =>'no telpon maksimal 13 digit',
                'no_telp.min'           =>'no telpon minimal 12 digit',
                'provinsi_pasien'       =>'provinsi pasien wajib dipilih',
                'kewarganegaraan'       =>'kewarganegaraan wajib dipilih',
                'alamat_lengkap_pasien' =>'alamat lengkap pasien wajib diisi',
                'nama_keluarga'         =>'nama keluarga wajib diisi',
                'hub_keluarga'          =>'hubungan keluarga dengan pasien wajib dipilih',
            ]);

        $tgl_lahir  = Carbon::parse($request->tgl_lahir)->format('Y-m-d');
        $same_address = $request->has('default_alamat_checkbox')??Null;
        
        $cek_last_rm = \DB::connection('mysql2')->table('mt_pasien')
                ->selectRaw('MAX(no_rm) + 1 AS rm_baru')
                ->whereRaw("LEFT(no_rm, 2) = '01'")
                ->first();
        $rm_new ='0'.$cek_last_rm->rm_baru;
        $kecamatan      = Kecamatan::where('kode_kecamatan', $request->kecamatan_pasien)->first();
        $desa           = Desa::where('kode_desa_kelurahan', $request->desa_pasien)->first();

        $keluarga = KeluargaPasien::create([
            'no_rm'             => $rm_new,
            'nama_keluarga'     => $request->nama_keluarga,
            'hubungan_keluarga' => $request->hub_keluarga,
            'alamat_keluarga'   => !empty($same_address) ? $desa->nama_desa_kelurahan.' Kecamatan '.$kecamatan->nama_kecamatan.' '.$request->alamat_lengkap_pasien : $request->alamat_lengkap_sodara,
            'tlp_keluarga'      => !empty($same_address) ? $request->no_telp : $request->kontak,
            'input_date'        => Carbon::now(),
            'Update_date'       => Carbon::now(),
        ]);
        if(empty($keluarga))
        {
            Alert::warning('DATA KELUARGA KOSONG!', 'silahkan isi data keluarga pasien!');
            return redirect()->route('pasien-baru.create');
        }

        $pasien = Pasien::create([
            'no_rm'             => $rm_new,
            'no_Bpjs'           => $request->no_bpjs,
            'nama_px'           => strtoupper($request->nama_pasien_baru),
            'jenis_kelamin'     => $request->jk,
            'tempat_lahir'      => strtoupper($request->tempat_lahir),
            'tgl_lahir'         => $tgl_lahir,
            'agama'             => $request->agama,
            'pendidikan'        => $request->pendidikan,
            'pekerjaan'         => $request->pekerjaan,
            'kewarganegaraan'   => $request->kewarganegaraan,
            'negara'            => $request->kewarganegaraan==1?'INDONESIA':strtoupper($request->negara),
            'propinsi'          => $request->provinsi_pasien,
            'kabupaten'         => $request->kabupaten_pasien,
            'kecamatan'         => $request->kecamatan_pasien,
            'desa'              => $request->desa_pasien,
            'alamat'            => strtoupper($desa->nama_desa_kelurahan.' Kecamatan '.$kecamatan->nama_kecamatan.' '.$request->alamat_lengkap_pasien),
            'no_telp'           => $request->no_telp,
            'no_hp'             => $request->no_telp,
            'tgl_entry'         => Carbon::now(),
            'nik_bpjs'          => $request->nik_pasien_baru,
            'update_date'       => Carbon::now(),
            'update_by'         => Carbon::now(),
            'kode_propinsi'     => $request->provinsi_pasien,
            'kode_kabupaten'    => $request->kabupaten_pasien,
            'kode_kecamatan'    => $request->kecamatan_pasien,
            'kode_desa'         => $request->desa_pasien,
            'no_ktp'            => $request->nik_pasien_baru,
            'user_create'       =>  Auth::user()->name,
            'status_px'         =>  1,
            'pic2'              => Auth::user()->id,
            'pic'               => Auth::user()->id_simrs,

        ]);

        Alert::success('Yeay...!', 'anda berhasil menambahkan pasien baru!');
        return redirect()->route('daftar-igd.v1');
    }

    public function editPasien(Request $request, $rm)
    {
        $pasien         = Pasien::firstWhere('no_rm',$rm);
        $klp            = KeluargaPasien::firstWhere('no_rm',$rm);
        $provinsi       = Provinsi::get();
        $kota           = Kabupaten::where('kode_provinsi', $pasien->kode_propinsi)->get();
        $kecamatan      = Kecamatan::where('kode_kabupaten_kota', $pasien->kode_kabupaten)->get();
        $desa           = Desa::where('kode_kecamatan', $pasien->kode_kecamatan)->get();
        $negara         = Negara::get();
        $hb_keluarga    = HubunganKeluarga::orderBy('kode','asc')->get();
        $agama          = Agama::orderBy('ID','asc')->get();
        $pekerjaan      = Pekerjaan::get();
        $pendidikan     = Pendidikan::get();
        return view('simrs.igd.pasienigd.edit_pasien',compact(
            'klp','pasien','provinsi','negara',
            'hb_keluarga','agama','pekerjaan','pendidikan',
            'kota','kecamatan','desa'
        ));
    }

    public function updatePasien(Request $request)
    {
        $pasien         = Pasien::firstWhere('no_rm',$request->rm);
        $kabUpdate      = is_numeric($request->kabupaten_pasien);
        $kecUpdate      = is_numeric($request->kecamatan_pasien);
        $desaUpdate     = is_numeric($request->desa_pasien);
        if ($kabUpdate==false && $kecUpdate==false && $desaUpdate==false) {
            $kab    = Kabupaten::firstWhere('nama_kabupaten_kota', $request->kabupaten_pasien);
            $kec    = Kecamatan::firstWhere('nama_kecamatan', $request->kecamatan_pasien);
            $desa   = Desa::firstWhere('nama_desa_kelurahan', $request->desa_pasien);
        }

        $pasien->no_Bpjs            = $request->no_bpjs;
        $pasien->nama_px            = strtoupper($request->nama_pasien_baru);
        $pasien->jenis_kelamin      = $request->jk;
        $pasien->tempat_lahir       = strtoupper($request->tempat_lahir);
        $pasien->tgl_lahir          = $request->tgl_lahir;
        $pasien->agama              = $request->agama;
        $pasien->pendidikan         = $request->pendidikan;
        $pasien->pekerjaan          = $request->pekerjaan;
        $pasien->kewarganegaraan    = $request->kewarganegaraan;
        // $pasien->negara             = strtoupper($request->negara);
        $pasien->negara             = 'INDONESIA';
        $pasien->propinsi           = $request->provinsi_pasien;
        $pasien->kabupaten          = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
        $pasien->kecamatan          = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
        $pasien->desa               = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
        $pasien->kode_propinsi      = $request->provinsi_pasien;
        $pasien->kode_kabupaten     = $kabUpdate==false? $kab->kode_kabupaten_kota:$request->kabupaten_pasien;
        $pasien->kode_kecamatan     = $kecUpdate==false? $kec->kode_kecamatan:$request->kecamatan_pasien;
        $pasien->kode_desa          = $desaUpdate==false? $desa->kode_desa_kelurahan:$request->desa_pasien;
        $pasien->alamat             = strtoupper($request->alamat_lengkap_pasien);
        $pasien->no_tlp             = $request->no_tlp??$request->no_hp;
        $pasien->no_hp              = $request->no_hp??$request->no_tlp;
        $pasien->nik_bpjs           = $request->nik;
        if($pasien->update())
        {
            $klp = KeluargaPasien::firstWhere('no_rm',$request->rm);
            if(is_null($klp))
            {
                KeluargaPasien::create([
                    'no_rm'             => $request->rm,
                    'nama_keluarga'     => $request->nama_keluarga,
                    'hubungan_keluarga' => $request->hub_keluarga,
                    'alamat_keluarga'   => $request->alamat_lengkap_sodara,
                    'tlp_keluarga'      => $request->tlp_keluarga,
                    'Update_date'       => Carbon::now(),
                ]);

            }else{
                $klp->nama_keluarga     = $request->nama_keluarga;
                $klp->hubungan_keluarga = $request->hub_keluarga;
                $klp->alamat_keluarga   = $request->alamat_lengkap_sodara;
                $klp->tlp_keluarga      = $request->tlp_keluarga;
                $klp->Update_date       = Carbon::now();
                $klp->update();
            }
        }
        return response()->json(['pasien'=>$pasien, 'status'=>200]);
    }

    public function cekPasien(Request $request)
    {
        $query = DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
            ->select(
                'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                'ts_kunjungan.kode_kunjungan as kunjungan',
                'ts_kunjungan.status_kunjungan as stts_kunjungan',
                'ts_kunjungan.no_sep as sep',
                'ts_kunjungan.form_send_by as form_send_by',
                'ts_kunjungan.ref_kunjungan as ref_kunjungan',
                'ts_kunjungan.is_bpjs_proses as is_bpjs_proses',
                'ts_kunjungan.tgl_keluar as tgl_pulang',
                'ts_kunjungan.kode_unit as unit',
                'ts_kunjungan.diagx as diagx',
                'ts_kunjungan.lakalantas as lakaLantas',
                'ts_kunjungan.jp_daftar as jp_daftar',
                'ts_kunjungan.id_ruangan as ruangan',
                'ts_kunjungan.kamar as kamar',
                'ts_kunjungan.no_bed as bed',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
                'mt_status_kunjungan.ID as id_status',
            )
            ->orderBy('ts_kunjungan.tgl_keluar', 'desc');

        if($request->tanggal && !empty($request->tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_keluar', $request->tanggal);
        }

        if($request->unit && !empty($request->unit))
        {
            $query->where('ts_kunjungan.kode_unit', $request->unit);
        }

        if(empty($request->tanggal) && empty($request->tanggal)){
            $query->whereDate('ts_kunjungan.tgl_keluar', now());
        }

        $kunjungan  = $query->get();
        $unit = Unit::where('kelas_unit', 2)->get();
        return view('simrs.igd.pasienigd.cek_pasien_pulang', compact('kunjungan','unit','request'));
    }

    public function cekPasienExport(Request $request)
    {
        $unit = Unit::where('kode_unit', $request->unit)->first();
        $namaFile = 'Data-Pasien-Pulang'.$request->tanggal.'_s.d_'.$unit->nama_unit.'.xlsx';
        return Excel::download(new CekPasienPulangExport($request), $namaFile);
    }

}
