<?php

namespace App\Http\Controllers;

use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\SuratKontrol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKontrolController extends Controller
{
    public function suratKontrolBpjs(Request $request)
    {
        $suratkontrol = null;
        if ($request->tanggal && $request->formatFilter) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalMulai'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalAkhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $vclaim = new VclaimController();
            $response =  $vclaim->suratkontrol_tanggal($request);
            if ($response->metadata->code == 200) {
                $suratkontrol = $response->response->list;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        if ($request->nomorKartu) {
            $bulan = explode('-', $request->bulan);
            $request['tahun'] = $bulan[0];
            $request['bulan'] = $bulan[1];
            $response =  $this->suratkontrol_peserta($request);
            if ($response->metadata->code == 200) {
                $suratkontrol = $response->response->list;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.surat_kontrol_index', compact([
            'request', 'suratkontrol'
        ]));
    }
    public function edit($id)
    {
        $suratkontrol = SuratKontrol::find($id);
        return response()->json($suratkontrol);
    }
    public function store(Request $request)
    {
        $request['noSep'] = $request->nomorsep_suratkontrol;
        $request['tglRencanaKontrol'] = $request->tanggal_suratkontrol;
        $request['kodeDokter'] = $request->kodedokter_suratkontrol;
        $request['poliKontrol'] = $request->kodepoli_suratkontrol;
        $poli = Poliklinik::where('kodesubspesialis', $request->poliKontrol)->first();
        $request['user'] = Auth::user()->name;
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_insert($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            SuratKontrol::create([
                "tglTerbitKontrol" => now()->format('Y-m-d'),
                "tglRencanaKontrol" => $suratkontrol->tglRencanaKontrol,
                "poliTujuan" => $request->poliKontrol,
                "namaPoliTujuan" => $poli->namasubspesialis,
                "kodeDokter" => $request->kodeDokter,
                "namaDokter" => $suratkontrol->namaDokter,
                "noSuratKontrol" => $suratkontrol->noSuratKontrol,
                "namaJnsKontrol" => "Surat Kontrol",
                "noSepAsalKontrol" => $request->noSep,
                "noKartu" => $suratkontrol->noKartu,
                "nama" => $suratkontrol->nama,
                "kelamin" => $suratkontrol->kelamin,
                "tglLahir" => $suratkontrol->tglLahir,
                "user" => Auth::user()->name,
            ]);
            $vclaim = new VclaimController();
            $request['nomorkartu'] = $suratkontrol->noKartu;
            $request['tanggal'] = now()->format('Y-m-d');
            $response_peserta = $vclaim->peserta_nomorkartu($request);
            if ($response_peserta->metadata->code == 200) {
                $peserta = $response_peserta->response->peserta;
                $wa = new WhatsappController();
                $request['message'] = "*Surat Kontrol Rawat Jalan*\nTelah berhasil pembuatan surat kontrol atas pasien sebagai berikut.\n\nNama : " . $suratkontrol->nama . "\nNo Surat Kontrol : " . $suratkontrol->noSuratKontrol . "\nTanggal Kontrol : " . $suratkontrol->tglRencanaKontrol . "\nPoliklinik : " . $poli->namasubspesialis . "\n\nUntuk surat kontrol online dapat diakses melalui link berikut.\nsim.rsudwaled.id/siramah/suratkontrol_print?nomorsuratkontrol=" . $suratkontrol->noSuratKontrol;
                $request['number'] = $peserta->mr->noTelepon;
                $wa->send_message($request);
            }
        }
        return $response;
    }
    public function update(Request $request)
    {
        $request['noSuratKontrol'] = $request->nomor_suratkontrol;
        $request['noSep'] = $request->nomorsep_suratkontrol;
        $request['kodeDokter'] = $request->kodedokter_suratkontrol;
        $request['poliKontrol'] = $request->kodepoli_suratkontrol;
        $request['tglRencanaKontrol'] = $request->tanggal_suratkontrol;
        $poli = Poliklinik::where('kodesubspesialis', $request->poliKontrol)->first();
        $request['user'] = 'Siramah';
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_update($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $sk = SuratKontrol::firstWhere('noSuratKontrol', $request->nomor_suratkontrol);
            $sk->update([
                "tglTerbitKontrol" => now()->format('Y-m-d'),
                "tglRencanaKontrol" => $suratkontrol->tglRencanaKontrol,
                "poliTujuan" => $request->poliKontrol,
                "namaPoliTujuan" => $poli->namasubspesialis,
                "kodeDokter" => $request->kodeDokter,
                "namaDokter" => $suratkontrol->namaDokter,
                "noSuratKontrol" => $suratkontrol->noSuratKontrol,
                "namaJnsKontrol" => "Surat Kontrol",
                "noSepAsalKontrol" => $request->noSep,
                "noKartu" => $suratkontrol->noKartu,
                "nama" => $suratkontrol->nama,
                "kelamin" => $suratkontrol->kelamin,
                "tglLahir" => $suratkontrol->tglLahir,
                "user" => 'Siramah',
            ]);
        }
        return $response;
    }
    public function destroy(Request $request)
    {
        $request['noSuratKontrol'] = $request->nomor_suratkontrol;
        $request['user'] = 'Sistem SIRAMAH';
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_delete($request);
        if ($response->metadata->code == 200) {
            $sk = SuratKontrol::firstWhere('noSuratKontrol', $request->nomor_suratkontrol);
            $sk->delete();
        }
        return $response;
    }
    public function suratKontrolPrint($nomorsuratkontrol, Request $request)
    {
        $request['noSuratKontrol'] = $nomorsuratkontrol;
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_nomor($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $sep = $response->response->sep;
            $peserta = $response->response->sep->peserta;
            $pasien = Pasien::firstWhere('no_Bpjs', $peserta->noKartu);
            $dokter = Paramedis::firstWhere('kode_dokter_jkn', $suratkontrol->kodeDokter);
            return view('simrs.suratkontrol.suratkontrol_print', compact([
                'suratkontrol',
                'sep',
                'peserta',
                'pasien',
                'dokter',
            ]));
        } else {
            return $response->metadata->message;
        }
    }
    public function print(Request $request)
    {
        // dd($request->all());
        $request['noSuratKontrol'] = $request->nomorsuratkontrol;
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_nomor($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $sep = $response->response->sep;
            $peserta = $response->response->sep->peserta;
            $pasien = Pasien::firstWhere('no_Bpjs', $peserta->noKartu);
            $dokter = Paramedis::firstWhere('kode_dokter_jkn', $suratkontrol->kodeDokter);
            return view('simrs.suratkontrol.suratkontrol_print', compact([
                'suratkontrol',
                'sep',
                'peserta',
                'pasien',
                'dokter',
            ]));
        } else {
            return $response->metadata->message;
        }
    }
}
