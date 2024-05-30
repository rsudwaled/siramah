<?php

namespace App\Http\Controllers\IGD\Antrian;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AntrianPasienIGD;
use App\Models\PenjaminSimrs;
use App\Models\AlasanMasuk;
use App\Models\Penjamin;
use App\Models\Paramedis;
use App\Models\Pasien;

class AntrianController extends Controller
{
    public function listAntrian()
    {
        $antrian = AntrianPasienIGD::with('isTriase')
            ->whereBetween('tgl', ['2023-12-01', now()])
            // ->whereDate('tgl', now())
            ->where('status', 1)
            ->where('kode_kunjungan', null)
            ->orderBy('tgl', 'desc')
            ->get();
        // dd($antrian);
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
        
        $jp = $jp;
        $query          = Pasien::query();
        if ($request->rm && !empty($request->rm)) {
            $query->where('no_rm','LIKE', '%' . $request->rm. '%');
        }
        if ($request->nama && !empty($request->nama)) {
            $query->where('nama_px', 'LIKE', '%' . $request->nama . '%')->limit(100);
        }
        if ($request->nomorkartu && !empty($request->nomorkartu)) {
            $query->where('no_Bpjs','LIKE', '%' . $request->nomorkartu. '%');
        }
        if($request->nik && !empty($request->nik))
        {
            $query->where('nik_bpjs','LIKE', '%' .  $request->nik. '%');
        }
        if(!empty($request->nama) || !empty($request->nik) || !empty($request->nomorkartu) || !empty($request->rm))
        {
            $pasien         = $query->get();
        }else{
            $pasien         = null;
        }

        $penjamin    = PenjaminSimrs::orderBy('kode_penjamin', 'asc')->get();
        $penjaminbpjs= Penjamin::orderBy('id', 'asc')->get();
        $paramedis   = Paramedis::where('act', 1)->get();
        $alasanmasuk = AlasanMasuk::orderBy('id', 'asc')->get();
        
        return view('simrs.igd.daftar.cari_pasien', compact('alasanmasuk','paramedis','penjamin','penjaminbpjs','antrian','request','pasien','no','jp'));
    }
}
