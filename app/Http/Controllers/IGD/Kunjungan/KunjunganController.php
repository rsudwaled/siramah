<?php

namespace App\Http\Controllers\IGD\Kunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use App\Models\AlasanMasuk;
use DB;

class KunjunganController extends Controller
{
    public function daftarKunjungan(Request $request)
    {

        $query = \DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
            ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
            ->select(
                'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep',
                'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
            )
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
        $kunjungan = $query->get();
        $unit = Unit::where('kelas_unit', 1)->get();
        return view('simrs.igd.kunjungan.kunjungan_now', compact('kunjungan','request','unit'));
    }

    public function detailKunjungan($kunjungan)
    {
        $kunjungan = Kunjungan::with('pasien')->where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.kunjungan.detail_kunjungan', compact('kunjungan'));
    }
    public function editKunjungan($kunjungan)
    {
        $kunjungan  = Kunjungan::with('pasien')->where('kode_kunjungan', $kunjungan)->first();
        $penjamin   = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
        $alasanmasuk    = AlasanMasuk::limit(10)->get();
        return view('simrs.igd.kunjungan.edit_kunjungan', compact('kunjungan','penjamin','alasanmasuk'));
    }

    public function updateKunjungan(Request $request, $kunjungan)
    {
        $kunjungan                      = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        $kunjungan->perujuk             = $request->nama_perujuk;
        $kunjungan->jp_daftar           = $request->isBpjs;
        $kunjungan->kode_penjamin       = $request->penjamin_id;
        $kunjungan->id_alasan_masuk     = $request->alasan_masuk_id;
        $kunjungan->alasan_edit         = $request->alasan_edit;
        $kunjungan->save();
        return redirect()->route('detail.kunjungan', ['kunjungan'=>$kunjungan]);
    }

}
