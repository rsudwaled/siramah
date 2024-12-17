<?php

namespace App\Http\Controllers\LaporanRekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ErmRanapPengajuanPembukaanFormResume;

class PembukaanFormResumeController extends Controller
{
    public function pengajuan(Request $request)
    {
        $pengajuan = ErmRanapPengajuanPembukaanFormResume::where('status_aproval', 0)->get();
        $countPengajuan = count($pengajuan);
        return view('simrs.rekammedis.pengajuan_pembukaan_resume.index', compact('pengajuan','countPengajuan'));
    }
}
