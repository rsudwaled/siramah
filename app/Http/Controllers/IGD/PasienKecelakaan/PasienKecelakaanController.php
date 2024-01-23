<?php

namespace App\Http\Controllers\IGD\PasienKecelakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\AlasanMasuk;
use App\Models\Paramedis;
use App\Models\PenjaminSimrs;
use RealRashid\SweetAlert\Facades\Alert;

class PasienKecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $pasien = null;
        if(!empty($request->rm) || !empty($request->nama) ||  !empty($request->nomorkartu) || !empty($request->nik))
        {
            $query = Pasien::query();
            if ($request->rm && !empty($request->rm)) {
                $query->where('no_rm', $request->rm);
            }
            if ($request->nama && !empty($request->nama)) {
                $query->where('nama_px', 'LIKE', '%' . $request->nama . '%');
            }
            if ($request->nomorkartu && !empty($request->nomorkartu)) {
                $query->where('no_Bpjs', $request->nomorkartu);
            }
            if($request->nik && !empty($request->nik))
            {
                $query->where('nik_bpjs', $request->nik);
            }
            $pasien = $query->get();
        }
       
        return view('simrs.igd.pasien_kecelakaan.index', compact('request','pasien'));
    }

    public function create()
    {
        $alasanmasuk    = AlasanMasuk::get();
        $paramedis      = Paramedis::where('act', 1)->get();
        $penjamin       = PenjaminSimrs::get();
        return view('simrs.igd.pasien_kecelakaan.create', compact('alasanmasuk','paramedis','penjamin'));
    }
}
