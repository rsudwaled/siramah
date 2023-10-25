<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeluargaPasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Pasien;


class IGDBAYIController extends Controller
{
    public function pendaftaranPasienBayi()
    {
        $klp = KeluargaPasien::firstWhere('no_rm',10004866);
        $provinsi = Provinsi::get();
        $negara = Negara::get();
        $hb_keluarga = HubunganKeluarga::get();
        $agama = Agama::get();
        $pekerjaan = Pekerjaan::get();
        $pendidikan = Pendidikan::get();
        return view('simrs.igd.pendaftaran.pasien_bayi', compact('klp','provinsi','negara','hb_keluarga','agama','pekerjaan','pendidikan'));
    }

    public function cariOrangtua(Request $request)
    {
        $data = Pasien::with(['kecamatans','kabupatens','desas'])->where('nik_bpjs', $request->nik_ortu)->get();
        return response()->json([
            'data' => $data,
            'success' => true,
        ]);
    }
}
