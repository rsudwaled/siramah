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
        $kunNow = \DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_penjamin', 'mt_penjamin.kode_penjamin', '=', 'ts_kunjungan.kode_penjamin')
            ->whereIn('mt_penjamin.kode_kelompok', [1,2])
            ->whereNotNull('ts_kunjungan.no_sep')
            ->whereNotNull('ts_kunjungan.diagx')
            // ->whereIn('ts_kunjungan.prefix_kunjungan',['UGD','UGK'])
            ->get();
     
        return view('simrs.igd.dashboard_igd', compact('kunNow'));
    }
}
