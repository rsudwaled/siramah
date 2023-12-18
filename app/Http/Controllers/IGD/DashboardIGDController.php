<?php

namespace  App\Http\Controllers\IGD;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use Carbon\Carbon;
use DB;

class DashboardIGDController extends Controller
{
    public function getDataAll(Request $request)
    {
        // $kunNow = Kunjungan::whereDate('tgl_masuk', Carbon::today())->where('status_kunjungan', 1)->orderBy('tgl_masuk','desc')->paginate(32);
        $threeday_ago = Carbon::now()->addDays(-3)->format('Y-m-d');
        // dd($threeday_ago);

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
        ->orderBy('tgl_kunjungan', 'desc');
        $kunjungan = $query->get();
        return view('simrs.igd.dashboard_igd', compact('kunjungan'));
    }
}
