<?php

namespace App\Http\Controllers\IGD\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function getDataAll(Request $request)
    {
        $query = DB::connection('mysql2')->table('ts_kunjungan')
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
            ->where('ts_jp_igd.is_bpjs', 1)
            ->where('mt_status_kunjungan.status_kunjungan','!=', 8)
            ->orderBy('kunjungan', 'desc');
        $pasienranap = DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
            ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
            ->join('di_pasien_diagnosa_frunit', 'ts_kunjungan.kode_kunjungan', '=', 'di_pasien_diagnosa_frunit.kode_kunjungan')
            ->select(
                'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep',
                'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
                'ts_jp_igd.is_bpjs as status_pasien_daftar',
                'di_pasien_diagnosa_frunit.is_ranap as status_ranap',
            )
            ->where('ts_kunjungan.is_ranap_daftar', 0)
            ->where('di_pasien_diagnosa_frunit.is_ranap', 1)
            ->orderBy('tgl_kunjungan', 'desc')->get();
        $kunjungan = $query->get();
        $ugdkbd = $query->where('ts_kunjungan.kode_unit', 1023)->count();
        $ugd = $query->where('ts_kunjungan.kode_unit', 1002)->count();
        return view('simrs.igd.dashboard_igd', compact('kunjungan','ugd','ugdkbd','pasienranap'));
    }
}
