<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KunjunganIGDController extends Controller
{
    public function kunjunganPasienHariIni(Request $request)
    {
      $tgl       = Carbon::now()->format('Y-m-d');
      $kunjungan = Kunjungan::whereDate('tgl_masuk', Carbon::today())->where('status_kunjungan', 1)->orderBy('tgl_masuk','desc')->paginate(32);
      $ugd       = $kunjungan->where('kode_unit', 1002)->count();
      $ugdkbd    = $kunjungan->where('kode_unit', 1020)->count();
      return view('simrs.igd.kunjungan.kunjungan_igd', compact('kunjungan','ugd','ugdkbd'));
    }
}
