<?php

namespace App\Http\Controllers;

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

        $kunNow = \DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_penjamin', 'mt_penjamin.kode_penjamin', '=', 'ts_kunjungan.kode_penjamin')
            ->whereIn('mt_penjamin.kode_kelompok', [1,2])
            ->whereNull('ts_kunjungan.no_sep')
            ->whereNull('ts_kunjungan.diagx')
            ->whereIn('ts_kunjungan.prefix_kunjungan',['UGD','UGK','PRN','NCU'])
            ->whereBetween(\DB::raw('DATE(ts_kunjungan.tgl_masuk)'), [$threeday_ago, Carbon::today()->format('Y-m-d')])
            ->get();
        // dd($kunNow);
        $igdbpjs_count = \DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_penjamin', 'mt_penjamin.kode_penjamin', '=', 'ts_kunjungan.kode_penjamin')
            ->whereIn('mt_penjamin.kode_kelompok', [1,2])
            ->whereNull('ts_kunjungan.no_sep')
            ->whereNull('ts_kunjungan.diagx')
            ->whereIn('ts_kunjungan.prefix_kunjungan',['UGD'])->count();
        $igkbpjs_count = \DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_penjamin', 'mt_penjamin.kode_penjamin', '=', 'ts_kunjungan.kode_penjamin')
            ->whereIn('mt_penjamin.kode_kelompok', [1,2])
            ->whereNull('ts_kunjungan.no_sep')
            ->whereNull('ts_kunjungan.diagx')
            ->whereIn('ts_kunjungan.prefix_kunjungan',['UGK','PRN','NCU'])->count();
        $pasienRanap = Kunjungan::whereNotNull('id_ruangan')->orderBy('tgl_masuk','desc')->get();
        // dd($pasienRanap);
        return view('simrs.igd.dashboard_igd', compact('kunNow', 'igdbpjs_count','igkbpjs_count','pasienRanap'));
    }
}
