<?php

namespace App\Http\Controllers\ERMRANAP\Perawat;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BudgetControl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\PerkembanganPasien;
use App\Models\PemeriksaanFisikKeperawatan;
use App\Models\ErmRanapKeperawatan;
use App\Models\AsesmenResikoPd;
use App\Models\AsesmenResikoPG;
use App\Models\SkriningNutrisi;
use App\Models\AsesmenFungsional;
use App\Models\PerencanaanPulang;
use App\Models\RencanaAsuhanKeperawatan;
use App\Models\ErmRanapImplementasiEvaluasi;

class RanapPerawatController extends Controller
{
    private function getKunjunganAndPasien($kode)
    {
        $kunjungan = Kunjungan::with([
            'dokter',
            'asesmen_ranap',
        ])->firstWhere('kode_kunjungan', $kode);
        $pasien = $kunjungan->pasien;
        $perkembangan       = PerkembanganPasien::where('kode_kunjungan', $kode)->get();
        return compact('kunjungan', 'pasien', 'perkembangan');
    }

    public function assesmenAwalKeperawatan(Request $request)
    {
        $data               = $this->getKunjunganAndPasien($request->kode);
        $fisik              = PemeriksaanFisikKeperawatan::where('kode', $request->kode)->first();
        $asesmenkeperawatan = ErmRanapKeperawatan::where('kode', $request->kode)->first();
        $faktorResiko       = AsesmenResikoPd::where('kode', $request->kode)->first();
        $skriningResiko     = AsesmenResikoPG::where('kode', $request->kode)->first();
        $skriningNutrisi    = SkriningNutrisi::where('kode', $request->kode)->first();
        $skriningFungsional = AsesmenFungsional::where('kode', $request->kode)->first();
        $perencanaanPulang  = PerencanaanPulang::where('kode', $request->kode)->first();
        $skriningNyeri      = $asesmenkeperawatan ? json_decode($asesmenkeperawatan->skrining_nyeri, true) : [];
        $NyeriLanjutan      = $asesmenkeperawatan ? json_decode($asesmenkeperawatan->asesmen_nyeri_lanjutan, true) : [];
        $riwayatKesehatan   = $asesmenkeperawatan ? json_decode($asesmenkeperawatan->riwayat_kesehatan, true) : [];
        $diagnostikEdukasi  = $asesmenkeperawatan ? json_decode($asesmenkeperawatan->diagnostik_edukasi, true) : [];
        $rencanaAsuhan      = RencanaAsuhanKeperawatan::where('kode', $request->kode)->get();
        $sistemRespirasiOksigenasi  = $fisik ?json_decode($fisik->sistem_respirasi_oksigenasi, true) : [];
        $sistemKardioVaskuler       = $fisik ?json_decode($fisik->sistem_kardio_vaskuler, true):[];
        $sistemGastroIntestinal     = $fisik ?json_decode($fisik->sistem_gastro_intestinal, true):[];
        $sistemMuskuloSkeletal      = $fisik ?json_decode($fisik->sistem_muskulo_skeletal, true):[];
        $sistemNeurologi            = $fisik ?json_decode($fisik->sistem_neurologi, true):[];
        $sistemUrogenital           = $fisik ?json_decode($fisik->sistem_urogenital, true):[];
        $sistemIntegumen            = $fisik ?json_decode($fisik->sistem_integumen, true):[];
        $sistemHygiene              = $fisik ?json_decode($fisik->hyigiene, true):[];
        $sistemPsikobudaya          = $fisik ?json_decode($fisik->psikososial_budaya, true):[];
        $spiritualKepercayaan       = $fisik ?json_decode($fisik->spiritual_kepercayaan, true):[];
        return view('simrs.erm-ranap.perawat.assesmen_awal_keperawatan', array_merge($data, [
            'asesmenkeperawatan'        => $asesmenkeperawatan,
            'skriningNyeri'             => $skriningNyeri,
            'NyeriLanjutan'             => $NyeriLanjutan,
            'riwayatKesehatan'          => $riwayatKesehatan,
            'diagnostikEdukasi'         => $diagnostikEdukasi,
            'sistemRespirasiOksigenasi' => $sistemRespirasiOksigenasi,
            'sistemKardioVaskuler'      => $sistemKardioVaskuler,
            'sistemGastroIntestinal'    => $sistemGastroIntestinal,
            'sistemMuskuloSkeletal'     => $sistemMuskuloSkeletal,
            'sistemNeurologi'           => $sistemNeurologi,
            'sistemUrogenital'          => $sistemUrogenital,
            'sistemIntegumen'           => $sistemIntegumen,
            'sistemHygiene'             => $sistemHygiene,
            'sistemPsikobudaya'         => $sistemPsikobudaya,
            'spiritualKepercayaan'      => $spiritualKepercayaan,
            'faktorResiko'              => $faktorResiko,
            'skriningResiko'            => $skriningResiko,
            'skriningNutrisi'           => $skriningNutrisi,
            'skriningFungsional'        => $skriningFungsional,
            'perencanaanPulang'         => $perencanaanPulang,
            'rencanaAsuhan'             => $rencanaAsuhan,
        ]));
    }
    
    public function implementasiEvaluasi(Request $request)
    {
        $pic_perawat    = Auth::user()->id;
        $data           = $this->getKunjunganAndPasien($request->kode);
        $implementasi   = ErmRanapImplementasiEvaluasi::where('kode', $request->kode)->get();
        $implementasiPeruser   = ErmRanapImplementasiEvaluasi::where('kode', $request->kode)->whereIn('pic_perawat',[$pic_perawat])->get();
        return view('simrs.erm-ranap.perawat.implementasi_evaluasi', array_merge($data, [
            'implementasi' => $implementasi,
            'implementasiPeruser' => $implementasiPeruser,
        ]));
    }
    
    public function lembarEdukasi(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.perawat.lembar_edukasi', $data);
    }
    
    public function catatanMPPA(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.perawat.catatan_mppa',$data);
    }

    public function catatanMPPB(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.perawat.catatan_mppb',$data);
    }

    public function rencanaPemulanganPasien(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.perawat.rencana_pemulangan_pasien', $data);
    }
    public function cpptPerawat(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.perawat.cppt_perawat', $data);
    }

    
}
