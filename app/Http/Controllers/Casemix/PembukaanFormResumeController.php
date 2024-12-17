<?php

namespace App\Http\Controllers\Casemix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ErmRanapPengajuanPembukaanFormResume;

class PembukaanFormResumeController extends Controller
{
    public function pengajuan(Request $request)
    {
        $pengajuan = ErmRanapPengajuanPembukaanFormResume::where('status_aproval', 0)->get();
        $countPengajuan = count($pengajuan);
        return view('simrs.casemix.resume_pemulangan.index', compact('pengajuan','countPengajuan'));
    }
}
