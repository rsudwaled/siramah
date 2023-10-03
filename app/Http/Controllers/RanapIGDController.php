<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\AntrianPasienIGD;
use App\Models\Pasien;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\HubunganKeluarga;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\KeluargaPasien;
use App\Models\Unit;
use App\Models\Paramedis;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;
use App\Models\AlasanMasuk;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\TriaseIGD;
use App\Models\Icd10;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\TarifLayanan;
use App\Models\TarifLayananDetail;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;

class RanapIGDController extends Controller
{
    public function getKunjunganNow()
    {
        // $kunjungan = Kunjungan::where('tgl_masuk', now())->get();
        $kunjungan = Kunjungan::where('status_kunjungan', 2)->get();
        return view('simrs.igd.ranap.data_kunjungan', compact('kunjungan'));
    }


    public function ranapUmum(Request $request)
    {
        $pasien = Pasien::where('no_rm', 10230617)->first();
        $kunjungan = Kunjungan::where('no_rm', $pasien->no_rm)->get();
        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $penjamin = PenjaminSimrs::get();
        return view('simrs.igd.ranap.form_ranap', compact('pasien','kunjungan','unit','penjamin','alasanmasuk'));
    }

    public function ranapBPJS(Request $request)
    {
        $pasien = Pasien::where('no_rm', 10230617)->first();
        $kunjungan = Kunjungan::where('no_rm', $pasien->no_rm)->get();
        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $penjamin = PenjaminSimrs::get();
        return view('simrs.igd.ranap.form_ranap_bpjs', compact('pasien','kunjungan','unit','penjamin','alasanmasuk'));
    }

    public function getKelasRuangan(Request $request)
    {
        $ruangan = Ruangan::where('id_kelas', $request->kelas_r_id)
            ->where('status_incharge', 1)
            ->get();
        // $ruangan = json_encode($ruangan);
        return response()->json([
            'ruangan' => $ruangan,
        ]);
    }
}
