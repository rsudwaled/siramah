<?php

namespace App\Http\Controllers\IGD\Kunjungan;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;
use App\Models\Paramedis;
use App\Models\AlasanMasuk;
use App\Models\StatusKunjungan;
use App\Models\MtAlasanEdit;
use App\Models\HistoriesIGDBPJS;
use App\Models\Pasien;
use App\Models\Icd10;
use Carbon\Carbon;
use DB;

use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class KunjunganController extends Controller
{
    public function RiwayatKunjunganPasien(Request $request)
    {
        $all_kunj = Kunjungan::with(['unit','pasien','status','layanan'])
                    ->where('no_rm', $request->rm)->limit(8)
                    ->orderBy('tgl_masuk','desc')->get();
        return response()->json(['semua_kunjungan'=>$all_kunj]);
    }

    public function daftarKunjungan(Request $request)
    {
        $showData           = $request->view;
        $showDataSepCount   = null;
        
        $start_date         = Carbon::parse(now())->startOfDay();
        $end_date           = Carbon::parse(now())->endOfDay();

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
                'ts_kunjungan.tgl_masuk as tgl_kunjungan',
                'ts_kunjungan.kode_unit as unit',
                'ts_kunjungan.diagx as diagx',
                'ts_kunjungan.lakalantas as lakaLantas',
                'ts_kunjungan.jp_daftar as jp_daftar',
                'ts_kunjungan.id_ruangan as id_ruangan',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
                'mt_status_kunjungan.ID as id_status',
            )
            ->orderBy('ts_kunjungan.tgl_masuk', 'desc');
            // Apply date filters based on showData and request parameters
            if ($request->has('tanggal') && !empty($request->tanggal)) {
                $tanggal = $request->tanggal;
                if ($showData === 'kunjungan_sep_berhasil') {
                    $query->whereDate('ts_kunjungan.tgl_masuk', $tanggal)->whereNotNull('ts_kunjungan.no_sep');
                } elseif ($showData === 'kunjungan_ranap') {
                    // $query->whereBetween('ts_kunjungan.tgl_masuk', [$start_date, $end_date])->whereNotNull('ts_kunjungan.id_ruangan');
                    $query->whereDate('tgl_masuk', $tanggal);
                } else {
                    $query->whereDate('ts_kunjungan.tgl_masuk', $tanggal)->whereNull('ts_kunjungan.no_sep');
                }
            } else {
                // Default filtering if no specific date is provided
                if ($showData === 'kunjungan_sep_berhasil') {
                    $query->whereDate('ts_kunjungan.tgl_masuk', now())->whereNotNull('ts_kunjungan.no_sep');
                } elseif ($showData === 'kunjungan_ranap') {
                    // $query->whereBetween('ts_kunjungan.tgl_masuk', [$start_date, $end_date])->whereNotNull('ts_kunjungan.id_ruangan');
                    $query->whereDate('tgl_masuk', now());
                } else {
                    $query->whereDate('ts_kunjungan.tgl_masuk', now())->whereNull('ts_kunjungan.no_sep');
                }
            }
        
        if($showData ==='kunjungan_ranap')
        {
            $kunjungan          = $query->whereIn('nama_unit',['UGD','UGD KEBIDANAN'])->get();
        }else{
            $kunjungan          = $query->whereIn('nama_unit',['UGD','UGD KEBIDANAN'])->get();
        }
        
        $showDataSepCount   = $query->whereDate('tgl_masuk', now())->whereNotNull('ts_kunjungan.no_sep')->whereIn('nama_unit',['UGD','UGD KEBIDANAN'])->count();
        $unit       = Unit::where('kelas_unit', 1)->get();
        $paramedis  = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        return view('simrs.igd.kunjungan.kunjungan_now', compact('showDataSepCount','kunjungan','request','unit','paramedis'));
    }

    public function detailKunjungan($jpdaftar, $kunjungan)
    {
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $histories      = HistoriesIGDBPJS::where('kode_kunjungan', $kunjungan)->first();
        if($jpdaftar==1)
        {
              // daftar bukan bpjs
              $kunjungan = \DB::connection('mysql2')->table('ts_kunjungan')
              ->where('ts_kunjungan.kode_kunjungan', $kunjungan)
              ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
              ->join('mt_histories_igd_bpjs','ts_kunjungan.kode_kunjungan','=', 'mt_histories_igd_bpjs.kode_kunjungan' )
              ->join('mt_alasan_masuk','ts_kunjungan.id_alasan_masuk','=', 'mt_alasan_masuk.id' )
              ->join('mt_penjamin_bpjs','ts_kunjungan.kode_penjamin','=', 'mt_penjamin_bpjs.kode_penjamin_simrs' )
              ->select(
                  'mt_pasien.nama_px as nama',
                  'mt_pasien.tgl_lahir as tgl_lahir',
                  'mt_pasien.no_rm as no_rm',
                  'mt_pasien.no_Bpjs as bpjs',
                  'mt_pasien.nik_bpjs as nik',
                  'mt_alasan_masuk.alasan_masuk as alasan_masuk',
                  'mt_penjamin_bpjs.kode_penjamin_simrs as kode_penjamin',
                  'mt_penjamin_bpjs.nama_penjamin_bpjs as nama_penjamin',
                  'ts_kunjungan.kode_kunjungan as kode_kunjungan',
                  'ts_kunjungan.counter as counter',
                  'ts_kunjungan.no_bed as no_bed',
                  'ts_kunjungan.kamar as kamar',
                  'ts_kunjungan.kelas as kelas',
                  'ts_kunjungan.diagx as diagnosa',
                  'ts_kunjungan.no_sep as no_sep',
                  'ts_kunjungan.jp_daftar as jp_daftar',
                  'ts_kunjungan.no_spri as no_spri',
                  'ts_kunjungan.is_bpjs_proses as is_bpjs_proses',
                  'ts_kunjungan.is_ranap_daftar  as is_ranap_daftar',
                  'ts_kunjungan.perujuk as perujuk',
                  'ts_kunjungan.tgl_masuk as tgl_masuk'
                  )
                  ->first();
        }

        if($jpdaftar==0)
        {
            // daftar bukan bpjs
            $kunjungan = \DB::connection('mysql2')->table('ts_kunjungan')
            ->where('ts_kunjungan.kode_kunjungan', $kunjungan)
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            // ->join('mt_histories_igd_bpjs','ts_kunjungan.kode_kunjungan','=', 'mt_histories_igd_bpjs.kode_kunjungan' )
            ->join('mt_alasan_masuk','ts_kunjungan.id_alasan_masuk','=', 'mt_alasan_masuk.id' )
            ->join('mt_penjamin','ts_kunjungan.kode_penjamin','=', 'mt_penjamin.kode_penjamin' )
            ->select(
                'mt_pasien.nama_px as nama',
                'mt_pasien.tgl_lahir as tgl_lahir',
                'mt_pasien.no_rm as no_rm',
                'mt_pasien.no_Bpjs as bpjs',
                'mt_pasien.nik_bpjs as nik',
                'mt_alasan_masuk.alasan_masuk as alasan_masuk',
                'mt_penjamin.kode_penjamin as kode_penjamin',
                'mt_penjamin.nama_penjamin as nama_penjamin',
                'ts_kunjungan.kode_kunjungan as kode_kunjungan',
                'ts_kunjungan.counter as counter',
                'ts_kunjungan.no_bed as no_bed',
                'ts_kunjungan.kamar as kamar',
                'ts_kunjungan.kelas as kelas',
                'ts_kunjungan.diagx as diagnosa',
                'ts_kunjungan.no_sep as no_sep',
                'ts_kunjungan.jp_daftar as jp_daftar',
                'ts_kunjungan.no_spri as no_spri',
                'ts_kunjungan.is_bpjs_proses as is_bpjs_proses',
                'ts_kunjungan.is_ranap_daftar  as is_ranap_daftar',
                'ts_kunjungan.perujuk as perujuk',
                'ts_kunjungan.tgl_masuk as tgl_masuk'
            )
            ->first();
        }

        return view('simrs.igd.kunjungan.detail_kunjungan', compact('kunjungan','paramedis','histories'));
    }
    public function editKunjungan($kunjungan)
    {
        $kunjungan      = Kunjungan::with('pasien')->where('kode_kunjungan', $kunjungan)->first();
        $penjamin       = PenjaminSimrs::get();
        $penjaminbpjs   = Penjamin::get();
        $alasanmasuk    = AlasanMasuk::get();
        $alasanedit     = MtAlasanEdit::get();
        $statusKunjungan= StatusKunjungan::get();
        return view('simrs.igd.kunjungan.edit_kunjungan', compact('kunjungan','alasanedit','penjamin','alasanmasuk','penjaminbpjs','statusKunjungan'));
    }

    public function updateKunjungan(Request $request, $kunjungan)
    {
        // dd($request->all());

        if($request->isBpjs == 0)
        {
            $penjamin   = $request->penjamin_id_umum;
        }

        if($request->isBpjs == 1)
        {
            $penjamin   = $request->penjamin_id_bpjs;
        }

        if($request->isBpjs == 2)
        {
            $penjamin   = $request->penjamin_id_umum==null? $request->penjamin_id_bpjs:$request->penjamin_id_umum;
        }

        $kunjungan                      = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        $kunjungan->perujuk             = $request->nama_perujuk;
        $kunjungan->kode_penjamin       = $penjamin;
        $kunjungan->id_alasan_masuk     = $request->alasan_masuk_id;
        $kunjungan->id_alasan_edit      = $request->alasan_edit;
        $kunjungan->status_kunjungan    = $request->status_kunjungan;

        if($request->alasan_edit == 3)
        {
            $kunjungan->jp_daftar= 1;
        }

        if($request->alasan_edit == 4)
        {
            $kunjungan->jp_daftar= 0;
        }
        $kunjungan->save();
        return redirect()->route('daftar.kunjungan');
    }

    public function getKunjunganByUser(Request $request)
    {
        $kunjungan = Kunjungan::whereIn('pic2', [Auth::user()->id, 294, 318,329,330,331,332])->get();
        $currentDate = Carbon::now()->toDateString();
        $pasiens = Pasien::where('no_rm', '>=', '01000001')
                //   ->whereDate('tgl_entry', '<=', $currentDate)
                ->paginate(100);
        // dd($pasiens);
        return view('simrs.igd.kunjungan.list_pasien_byuser', compact('kunjungan','pasiens'));
    }

    public function sycnDesktopToWebApps(Request $request)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $request->nokunjungan)->first();
        $penjamin       = PenjaminSimrs::whereIn('kode_penjamin', ['P07', 'P08', 'P09','P10','P11','P13','P14'])->where('kode_penjamin', $kunjungan->kode_penjamin)->first();

        if(empty($penjamin))
        {
            $kunjungan->jp_daftar        =0;
            $kunjungan->form_send_by     =0;
            if($kunjungan->id_ruangan==null)
            {
                $kunjungan->is_ranap_daftar  =0;
            }
            $kunjungan->save();
            $message = 'Jenis Pasien Daftar adalah Umum';
        }
        if(!empty($penjamin))
        {
            HistoriesIGDBPJS::create([
                'kode_kunjungan' => $kunjungan->kode_kunjungan,
                'noAntrian'      =>null,
                'noMR'           => $kunjungan->no_rm,
                'noKartu'        => $kunjungan->pasien->no_Bpjs?? null,
                'tglSep'         => $kunjungan->tgl_masuk,
                'ppkPelayanan'   => '1018R001',
                'jnsPelayanan'   => 2,
                'klsRawatHak'    => null,
                'klsRawatNaik'   => null,
                'pembiayaan'     => null,
                'penanggungJawab'=> null,
                'asalRujukan'    => 2,
                'tglRujukan'     => $kunjungan->tgl_masuk,
                'noRujukan'      => null,
                'ppkRujukan'     => null,
                'diagAwal'       => $kunjungan->diagx,
                'lakaLantas'     => null,
                'noLP'           => null,
                'tglKejadian'    => null,
                'keterangan'     => null,
                'kdPropinsi'     => null,
                'kdKabupaten'    => null,
                'kdKecamatan'    => null,
                'dpjpLayan'      => null,
                'noTelp'         => $kunjungan->pasien->no_tlp==null?$kunjungan->pasien->no_hp:$kunjungan->pasien->no_tlp,
                'user'           => Auth::user()->username,
                'response'       => null,
                'is_bridging'    => 0,
            ]);

            $kunjungan->jp_daftar        =1;
            $kunjungan->form_send_by     =0;
            if($kunjungan->id_ruangan==null)
            {
                $kunjungan->is_ranap_daftar  =0;
            }
            $kunjungan->save();
            $message = 'Jenis Pasien Daftar adalah BPJS';
        }
        return response()->json([
            'data'=>$kunjungan,
            'message'=>$message,
            'code'=>200]);
    }

    public function insertSepKunjungan(Request $request)
    {
        $diagnosa_ts                = Icd10::where('diag', $request->diagnosa_sepinsert)->first();
        $sep_insert                 = Kunjungan::where('kode_kunjungan', $request->kode_insert_sep)->first();
        $sep_insert->no_sep         = $request->insert_no_sep;
        $sep_insert->id_alasan_edit = 9;
        $sep_insert->diagx          = $diagnosa_ts->diag.' | '.$diagnosa_ts->nama;
        $sep_insert->save();
        return back();
    }

    public function cetakLabel(Request $request)
    {
        $pasien = Pasien::where('no_rm', $request->label_no_rm)->first();
        if(is_null($pasien))
        {
            Alert::warning('PERHATIAN!!', 'NO RM tidak terdaftar di data pasien. silahkan cek kembali!');
            return back();
        }
        $qrcode = base64_encode(QrCode::format('svg')->size(35)->errorCorrection('H')->generate('string'));
        $pdf = PDF::loadView('simrs.igd.cetakan_igd.label', ['pasien' => $pasien,'qrcode'=>$qrcode]);
        return $pdf->stream('label-pasien.pdf');
    }

    public function cetakSEPPrint($sep)
    {
        $api = new VclaimController();
        $request = new Request([
            'noSep' => $sep,
        ]);
        $res    = $api->sep_nomor($request);
        $histories  = HistoriesIGDBPJS::where('respon_nosep', $sep)->first();
        $pdf = PDF::loadView('simrs.igd.cetakan_igd.sep_igd', ['data'=>$res->response,'history'=>$histories]);
        return $pdf->stream('cetak-sep-pasien.pdf');
    }
    
    public function tutupKunjungan(Request $request)
    {
        $updateStatus = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $updateStatus->status_kunjungan =3;
        $updateStatus->id_alasan_edit   =7;
        $updateStatus->pic2             =Auth::user()->id_simrs??2;
        $updateStatus->updated_at       =now();
        $updateStatus->save();
        return response()->json(['status'=>$updateStatus]);

    }
    public function bukaKunjungan(Request $request)
    {
        $updateStatus = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $updateStatus->status_kunjungan =1;
        $updateStatus->id_alasan_edit   =8;
        $updateStatus->pic2             =Auth::user()->id_simrs??2;
        $updateStatus->save();
        return response()->json(['status'=>$updateStatus]);

    }

    public function getKunjunganEp(Request $request)
    {
        $query          = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $kunjunganSama  = Kunjungan::where('counter', $query->counter)->where('no_rm', $query->no_rm)->get();
        $penjamin       = PenjaminSimrs::orderBy('kode_penjamin','asc')->get();
        return view('simrs.igd.kunjungan.edit_penjamin', compact('query','kunjunganSama','penjamin'));
    }
}
