<?php

namespace App\Http\Controllers\IGD\Kunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;
use App\Models\AlasanMasuk;
use App\Models\StatusKunjungan;
use App\Models\MtAlasanEdit;
use DB;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    public function RiwayatKunjunganPasien(Request $request)
    {
        $riwayat        = Kunjungan::with(['unit','pasien','status'])->where('no_rm', $request->rm)->limit(5)->get();
        $ranap          = Kunjungan::with(['unit','pasien','status'])->whereNotNull('id_ruangan')->where('no_rm', $request->rm)->limit(5)->get();
        $kebidanan      = Kunjungan::with(['unit','pasien','status'])->whereIn('kode_unit', ['1023'])->where('no_rm', $request->rm)->limit(5)->get();
        
        return response()->json(['riwayat'=>$riwayat,'ranap'=>$ranap, 'kebidanan'=>$kebidanan]);
    }

    public function daftarKunjungan(Request $request)
    {

        $query = DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            // ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
            ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
            ->select(
                'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep', 'ts_kunjungan.form_send_by as form_send_by', 'ts_kunjungan.ref_kunjungan as ref_kunjungan',
                'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx','ts_kunjungan.lakalantas as lakaLantas','ts_kunjungan.jp_daftar as jp_daftar',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
                'mt_status_kunjungan.ID as id_status',
            )
            ->where('ts_kunjungan.ref_kunjungan','=',0)
            ->orderBy('ts_kunjungan.tgl_masuk', 'desc');

       
        if($request->tanggal && !empty($request->tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_masuk', $request->tanggal); 
        }

        if($request->unit && !empty($request->unit))
        {
            $query->whereIn('ts_kunjungan.kode_unit', [$request->unit]); 
        }

        if(empty($request->tanggal) && empty($request->unit)){
            $query->whereDate('ts_kunjungan.tgl_masuk', now());
        }
        // $kunjungan = $query->get();
        $kunjungan = $query->whereIn('nama_unit',['UGD','UGK'])->get();
        $unit = Unit::where('kelas_unit', 1)->get();
        return view('simrs.igd.kunjungan.kunjungan_now', compact('kunjungan','request','unit'));
    }

    public function detailKunjungan($kunjungan)
    {
        $kunjungan = Kunjungan::with('pasien','alasanEdit')->where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.kunjungan.detail_kunjungan', compact('kunjungan'));
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
        return redirect()->route('detail.kunjungan', ['kunjungan'=>$kunjungan]);
    }

    public function getKunjunganByUser(Request $request)
    {
        $kunjungan = Kunjungan::where('pic2', Auth::user()->id)->get();
        return view('simrs.igd.kunjungan.list_pasien_byuser', compact('kunjungan'));
    }

}
