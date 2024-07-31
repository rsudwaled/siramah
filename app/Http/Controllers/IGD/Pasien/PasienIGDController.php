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
use App\Models\Desa;

use App\Models\LokasiProvinsi;
use App\Models\LokasiKabupaten;
use App\Models\LokasiKecamatan;
use App\Models\LokasiDesa;

use App\Models\Pasien;
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
    // alamat pasien
    public function getKabPasien(Request $request)
    {
        // $kabupatenpasien = Kabupaten::where('kode_provinsi', $request->kab_prov_id)->get();
        $kabupatenpasien = LokasiKabupaten::where('province_id', $request->kab_prov_id)->get();
        return response()->json($kabupatenpasien);
    }
    public function getKecPasien(Request $request)
    {
        // $kecamatanpasien = Kecamatan::where('kode_kabupaten_kota', $request->kec_kab_id)->get();
        $kecamatanpasien = LokasiKecamatan::where('regency_id', $request->kec_kab_id)->get();
        return response()->json($kecamatanpasien);
    }
    public function getDesaPasien(Request $request)
    {
        $search = $request->get('q');

        $desa = LokasiDesa::where('name', 'LIKE', "%$search%")
                    ->limit(100)
                    ->with('kecamatan.kabupatenKota') // Memuat relasi kecamatan dan kabupaten/kota
                    ->get(['id', 'name', 'district_id']);

        return response()->json($desa->map(function($item) {
            $kecamatanName = $item->kecamatan ? $item->kecamatan->name : null;
            $kabupatenName = $item->kecamatan && $item->kecamatan->kabupatenKota ? $item->kecamatan->kabupatenKota->name : null;

            return [
                'id' => $item->id,
                'name' => $item->name . ($kecamatanName ? ' - ' . $kecamatanName.' - '.$kabupatenName : ''),
            ];
        }));
    }


    // alamat keluarga pasien
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
        $negara         = Negara::all();
        $hb_keluarga    = HubunganKeluarga::orderBy('kode','asc')->get();
        $agama          = Agama::orderBy('ID','asc')->get();
        $pekerjaan      = Pekerjaan::all();
        $pendidikan     = Pendidikan::all();
        return view('simrs.igd.pasienigd.tambah_pasien',
            compact('negara','hb_keluarga','agama','pekerjaan','pendidikan'
            ));
    }

    public function createPasienBaruFromBpjsCek(Request $request)
    {
        dd($request->all());
        return view('simrs.igd.pasienigd.tambah_pasien');
    }

    public function pasienBaruIGD(Request $request)
    {
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
                'desa_pasien'       =>'required',
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
                'desa_pasien'           =>'desa pasien wajib dipilih',
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
        $desa           = LokasiDesa::with('kecamatan')->where('id', $request->desa_pasien)->first();

        $keluarga = KeluargaPasien::create([
            'no_rm'             => $rm_new,
            'nama_keluarga'     => strtoupper($request->nama_keluarga),
            'hubungan_keluarga' => $request->hub_keluarga,
            'alamat_keluarga'   => !empty($same_address) ? $desa->name.' Kecamatan '.$desa->kecamatan->name.' - '. $desa->kecamatan->kabupatenKota->name.' - '. $desa->kecamatan->kabupatenKota->provinsi->name.' '.$request->alamat_lengkap_pasien : $request->alamat_lengkap_sodara,
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
            'alamat'            => strtoupper($request->alamat_lengkap_pasien),
            'no_telp'           => $request->no_telp,
            'no_hp'             => $request->no_telp,
            'tgl_entry'         => Carbon::now(),
            'nik_bpjs'          => $request->nik_pasien_baru,
            'update_date'       => Carbon::now(),
            'update_by'         => Carbon::now(),
            'propinsi'          => $desa->kecamatan->kabupatenKota->provinsi->id??Null,
            'kabupaten'         => $desa->kecamatan->kabupatenKota->id??Null,
            'kecamatan'         => $desa->kecamatan->id??Null,
            'desa'              => $desa->id??Null,
            'kode_propinsi'     => $desa->kecamatan->kabupatenKota->provinsi->id??Null,
            'kode_kabupaten'    => $desa->kecamatan->kabupatenKota->id??Null,
            'kode_kecamatan'    => $desa->kecamatan->id??Null,
            'kode_desa'         => $desa->id??Null,
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

        $desa           = LokasiDesa::with('kecamatan')->where('id', $pasien->desa??$pasien->kode_desa)->first();

        $negara         = Negara::get();
        $hb_keluarga    = HubunganKeluarga::orderBy('kode','asc')->get();
        $agama          = Agama::orderBy('ID','asc')->get();
        $pekerjaan      = Pekerjaan::get();
        $pendidikan     = Pendidikan::get();
        return view('simrs.igd.pasienigd.edit_pasien',compact(
            'klp','pasien','negara',
            'hb_keluarga','agama','pekerjaan','pendidikan',
            'desa'
        ));
    }

    public function updatePasien(Request $request)
    {
        $pasien         = Pasien::firstWhere('no_rm',$request->rm);
        $desa           = LokasiDesa::with('kecamatan')->where('id', $request->desa_pasien)->first();

        $pasien->no_Bpjs            = $request->no_bpjs;
        $pasien->nama_px            = strtoupper($request->nama_pasien_baru);
        $pasien->jenis_kelamin      = $request->jk;
        $pasien->tempat_lahir       = strtoupper($request->tempat_lahir);
        $pasien->tgl_lahir          = $request->tgl_lahir;
        $pasien->agama              = $request->agama;
        $pasien->pendidikan         = $request->pendidikan;
        $pasien->pekerjaan          = $request->pekerjaan;
        $pasien->kewarganegaraan    = $request->kewarganegaraan;
        $pasien->negara             = 'INDONESIA';

        $pasien->propinsi          = $desa ? $desa->kecamatan->kabupatenKota->provinsi->id : $pasien->provinsi;
        $pasien->kabupaten         = $desa ? $desa->kecamatan->kabupatenKota->id : $pasien->kabupaten;
        $pasien->kecamatan         = $desa ? $desa->kecamatan->id : $pasien->kecamatan;
        $pasien->desa              = $desa ? $desa->id : $pasien->desa;
        $pasien->kode_propinsi     = $desa ? $desa->kecamatan->kabupatenKota->provinsi->id : $pasien->kode_propinsi;
        $pasien->kode_kabupaten    = $desa ? $desa->kecamatan->kabupatenKota->id : $pasien->kode_kabupaten;
        $pasien->kode_kecamatan    = $desa ? $desa->kecamatan->id : $pasien->kode_kecamatan;
        $pasien->kode_desa         = $desa ? $desa->id : $pasien->kode_desa;


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
                    'nama_keluarga'     => strtoupper($request->nama_keluarga),
                    'hubungan_keluarga' => $request->hub_keluarga,
                    'alamat_keluarga'   => strtoupper($request->alamat_lengkap_pasien),
                    'tlp_keluarga'      => $request->tlp_keluarga,
                    'Update_date'       => Carbon::now(),
                ]);

            }else{
                $klp->nama_keluarga     = strtoupper($request->nama_keluarga);
                $klp->hubungan_keluarga = $request->hub_keluarga;
                $klp->alamat_keluarga   = strtoupper($request->alamat_lengkap_sodara);
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
