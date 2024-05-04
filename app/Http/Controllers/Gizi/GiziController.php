<?php

namespace App\Http\Controllers\Gizi;

use App\Models\Unit;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\ErmRanapGiziMonev;
use App\Http\Controllers\Controller;
use App\Models\ErmRanapGiziAssesment;
use App\Models\ErmRanapGiziDiagnosis;
use App\Models\ErmRanapGiziIntervensi;
use App\Http\Controllers\APIController;
use RealRashid\SweetAlert\Facades\Alert;

class GiziController extends APIController
{
    public function index(Request $request)
    {
        $unit = Unit::all();
        $pasien = null;
        if (!empty($request->unit)) {
            $pasien = \DB::connection('mysql2')->select("CALL `SP_PANGGIL_PASIEN_RANAP_CURRENT`('$request->unit','','')");
        }
        return view('simrs.gizi.index', compact('request','unit','pasien'));
    }

    public function addAssesment(Request $request)
    {
        $Kunjungan = Kunjungan::with('pasien')->where('kode_kunjungan', $request->kunjungan)->where('counter', $request->counter)->first();
        return response()->json(route('simrs.gizi.create.assesment', ['kunjungan' => $Kunjungan->kode_kunjungan,'counter'=>$Kunjungan->counter]));
    }

    public function createAssesment($kunjungan, $counter)
    {
        $kunjungan = Kunjungan::with(['pasien','erm_ranap_gizi'])->where('kode_kunjungan', $kunjungan)->where('counter', $counter)->first();
        return view('simrs.gizi.assesment', compact('kunjungan'));
    }
    public function storeAssesment(Request $request)
    {
        dd($request->all());
        $assesment = ErmRanapGiziAssesment::updateOrCreate([
            "kode_kunjungan"                    => $request->kode_kunjungan,
            "counter"                           => $request->kode_kunjungan,
            "no_rm"                             => $request->kode_kunjungan,
            "nama"                              => $request->kode_kunjungan,
            "diagnosis_medis"                   => $request->kode_kunjungan,
            "assesment_bb"                      => $request->kode_kunjungan,
            "assesment_tb"                      => $request->kode_kunjungan,
            "assesment_lk_anak"                 => $request->kode_kunjungan,
            "assesment_lila"                    => $request->kode_kunjungan,
            "assesment_tinggi_lutut"            => $request->kode_kunjungan,
            "assesment_bb_ideal"                => $request->kode_kunjungan,
            "assesment_imt"                     => $request->kode_kunjungan,
            "assesment_bb_u"                    => $request->kode_kunjungan,
            "assesment_tb_u"                    => $request->kode_kunjungan,
            "assesment_bb_tb"                   => $request->kode_kunjungan,
            "assesment_lila_u"                  => $request->kode_kunjungan,
            "kebiasaan_selingan_cemilan"        => $request->kode_kunjungan,
            "alergi_malanan_&_pantangan_makanan"=> $request->kode_kunjungan,
            "gangguan_gastrointestinal"         => $request->kode_kunjungan,
            "bentuk_makanan_sebelum_masuk_rs_a" => $request->kode_kunjungan,
            "fisik_klinis"                      => $request->kode_kunjungan,
        ]);
        Alert::success('Success', 'Asesmen Gizi Disimpan');
        return $this->sendResponse($assesment);
    }   

    public function storeDiagnosis(Request $request)
    {
        $diagnosis = ErmRanapGiziDiagnosis::updateOrCreate(
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'counter'           => $request->counter,
                'no_rm'             => $request->no_rm,
            ],
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'counter'           => $request->counter,
                'no_rm'             => $request->no_rm,
                'nama'              => $request->nama_pasien_diagnosis_gizi,
                'diagnosis_gizi'    => $request->diagnosis_gizi,
                'tanggal_input_diagnosis_gizi'=> $request->tanggal_input,
            ]
        );
        return $this->sendResponse($diagnosis);
    }

    public function getDiagnosis(Request $request)
    {
        $diagnosis = ErmRanapGiziDiagnosis::where('no_rm', $request->norm)->get();
        return $this->sendResponse($diagnosis);
    }

    public function storeIntervensi(Request $request)
    {
        $intervensi = ErmRanapGiziIntervensi::updateOrCreate(
                [
                    'kode_kunjungan'    => $request->kode_kunjungan,
                    'counter'           => $request->counter,
                    'no_rm'             => $request->no_rm,
                ],
                [
                    'kode_kunjungan'    => $request->kode_kunjungan,
                    'counter'           => $request->counter,
                    'no_rm'             => $request->no_rm,
                    'nama'              => $request->nama_pasien_intervensi_gizi,
                    'intervensi'        => $request->intervensi,
                    'tanggal_input_intervensi'=> $request->tanggal_input,
                ]
        );
        return $this->sendResponse($intervensi);
    }

    public function storeMonev(Request $request)
    {
        $monev = ErmRanapGiziMonev::updateOrCreate(
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'counter'           => $request->counter,
                'no_rm'             => $request->no_rm,
            ],
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'counter'           => $request->counter,
                'no_rm'             => $request->no_rm,
                'nama'              => $request->nama_pasien_monev_gizi,
                'monitoring'        => $request->monev,
                'tanggal_input_monev'=> $request->tanggal_input,
            ]
        );
        return $this->sendResponse($monev);
    }
}
