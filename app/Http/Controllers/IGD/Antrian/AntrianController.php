<?php

namespace App\Http\Controllers\IGD\Antrian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\AntrianPasienIGD;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends Controller
{
    public function listAntrian()
    {
        $antrian = AntrianPasienIGD::with('isTriase')
            // ->whereBetween('tgl', ['2023-12-01', now()])
            ->whereDate('tgl', now())
            ->where('status', 1)
            ->where('kode_kunjungan', null)
            ->orderBy('tgl', 'desc')
            ->get();
        return view('simrs.igd.antrian.list_antrian', compact('antrian'));
    }

    public function terpilihAntrian($no, $jp, Request $request)
    {
        $antrian = AntrianPasienIGD::with('isTriase')->firstWhere('no_antri', $no);
        if(($antrian->isTriase==null) && (mb_substr($antrian->no_antri, 0, 1) != "B"))
        {
            Alert::error('Proses Daftar Gagal!!', 'pasien belum di triase oleh dokter!');
            return back();
        }
        if(!empty($antrian->isTriase) && $antrian->isTriase->klasifikasi_pasien == 'PULANG' && (mb_substr($antrian->no_antri, 0, 1) != "B"))
        {
            Alert::error('Proses Daftar Gagal!!', 'pasien di triase pulang!');
            return back();
        }
        $pasien = Pasien::orderBy('no_rm','desc')->paginate(20);
        $jp = $jp;
        if ($request->rm && !empty($request->rm)) {
            $pasien = Pasien::where('no_rm', $request->rm)->get();
        }
        if ($request->nama && !empty($request->nama)) {
            $pasien = Pasien::where('nama_px', 'LIKE', '%' . $request->nama . '%')->limit(50)->get();
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $pasien = Pasien::where('no_Bpjs', $request->nomorkartu)->get();
        }
        if($request->nik && !empty($request->nik))
        {
            $pasien = Pasien::where('nik_bpjs', $request->nik)->get();
        }
        
        return view('simrs.igd.daftar.cari_pasien', compact('antrian','request','pasien','no','jp'));
    }
}
