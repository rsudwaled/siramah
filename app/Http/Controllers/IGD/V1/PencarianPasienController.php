<?php

namespace App\Http\Controllers\IGD\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;

class PencarianPasienController extends Controller
{
    public function cariPasienTerdaftar(Request $request)
    {
        $search = Pasien::query()
        ->when($request->nik, function ($query, $nik) {
            $query->where('nik_bpjs', 'LIKE', '%' . $nik . '%');
        })
        ->when($request->nomorkartu, function ($query, $bpjsNumber) {
            $query->where('no_Bpjs', 'LIKE', '%' . $bpjsNumber . '%');
        })
        ->when($request->nama, function ($query, $name) {
            $query->where('nama_px', 'LIKE', '%' . $name . '%');
        })
        ->when($request->rm, function ($query, $mrn) {
            $query->where('no_rm', 'LIKE', '%' . $mrn . '%');
        })
        ->when($request->cari_desa, function ($query) use ($request) {
            $villageName = $request->cari_desa;
            $query->whereHas('lokasiDesa', function ($query) use ($villageName) {
                $query->where('name', 'LIKE', '%' . $villageName . '%');
            });
        })
        ->when($request->cari_kecamatan, function ($query) use ($request) {
            $villageName = $request->cari_kecamatan;
            $query->whereHas('lokasiKecamatan', function ($query) use ($villageName) {
                $query->where('name', 'LIKE', '%' . $villageName . '%');
            });
        });
    if (
        !empty($request->rm) || !empty($request->nama) ||
        !empty($request->cari_desa) || !empty($request->cari_kecamatan)
    ) {
        $pasiens = $search->get();
    } else {
        $pasiens = $search->orderBy('tgl_entry', 'desc')->take(4)->get();
    }
        return view('simrs.igd.pencarian_pasien.cari_pasien_terdaftar', compact('request', 'pasiens'));
    }
}
