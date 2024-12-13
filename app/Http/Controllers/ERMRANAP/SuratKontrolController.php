<?php

namespace App\Http\Controllers\ERMRANAP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class SuratKontrolController extends Controller
{
    public function create(Request $request)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        return view('simrs.erm-ranap.surat_control.index', compact('kunjungan'));
    }
}
