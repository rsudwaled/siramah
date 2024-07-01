<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\VclaimController;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Livewire\Component;

class AnjunganMandiriDaftar extends Component
{
    public $pasienbaru = 1;
    public $jenispasien, $nik, $nomorkartu, $nomorreferensi, $poliklinik, $kodepoli, $jadwaldokter, $jeniskunjungan;
    public $polikliniks = [], $jadwals = [];
    public $rujukans = [], $suratkontrols = [], $rujukanrs = [];
    protected $queryString = ['pasienbaru', 'jenispasien'];

    public function daftar()
    {
        $this->validate([
            'nik' => 'required',
            'nomorreferensi' => 'required',
            'kodepoli' => 'required',
            'jadwaldokter' => 'required',
            'jeniskunjungan' => 'required',
        ]);
        $pasien = Pasien::firstWhere('nik_bpjs', $this->nik);
        $jadwal = JadwalDokter::find($this->jadwaldokter);
        $request = new Request([
            'nomorkartu' => $pasien->no_Bpjs,
            'nik' => $pasien->nik_bpjs,
            'nohp' => $pasien->nohp ?? '000000000000',
            'norm' => $pasien->no_rm,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'kodedokter' => $jadwal->kodedokter,
            'kodepoli' => $jadwal->kodepoli,
            'jampraktek' => $jadwal->jadwal,
            'jenispasien' => 'JKN',
            'jeniskunjungan' => $this->jeniskunjungan,
            'nomorreferensi' => $this->nomorreferensi,
        ]);
        $api = new AntrianController();
        $res = $api->ambil_antrian($request);
        if ($res->metadata->code == 200) {
            dd($res);
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function updatedJadwaldokter()
    {
    }
    public function updatedKodepoli()
    {
        $this->jadwaldokter = null;
        $this->jadwals = [];
        $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->where('kodesubspesialis', $this->kodepoli)->get();
    }
    public function pilihSurat($nomorreferensi, $jeniskunjungan)
    {
        $this->jadwals = [];
        $this->nomorreferensi = $nomorreferensi;
        $this->jeniskunjungan = $jeniskunjungan;
    }
    public function cariPasien()
    {
        $this->nomorreferensi = null;
        $this->kodepoli = null;
        $this->jadwals = [];
        $pasien = Pasien::firstWhere('nik_bpjs', $this->nik);
        if ($pasien) {
            $nomorkartu = $pasien->nomorkartu;
            $api = new VclaimController();
            $request = new Request([
                'nik' => $this->nik,
                'tanggal' => now()->format('Y-m-d'),
            ]);
            $res = $api->peserta_nik($request);
            if ($res->metadata->code == 200) {
                $peserta = $res->response->peserta;
                $status = $peserta->statusPeserta->kode;
                if ($status == 0) {
                    $request = new Request([
                        'nomorkartu' =>  $peserta->noKartu,
                        'tanggal' => now()->format('Y-m-d'),
                    ]);
                    $res = $api->suratkontrol_peserta($request);
                    if ($res->metadata->code == 200) {
                        $this->suratkontrols = $res->response->list;
                    }
                    $res = $api->rujukan_peserta($request);
                    if ($res->metadata->code == 200) {
                        $this->rujukans = $res->response->rujukan;
                    }
                    // $res = $api->rujukan_rs_peserta($request);
                    // if ($res->metadata->code == 200) {
                    //     $rujukanrs = $res->response->rujukan;
                    // }
                    // dd($request->all(), $rujukanrs);
                    flash("Pasien Ditemukan", 'success');
                } else {
                    return flash("Mohon maaf, Status Peserta BPJS " . $peserta->statusPeserta->keterangan, 'danger');
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } else {
            return   flash("Mohon maaf, NIK Pasien Tidak Ditemukan", 'danger');
        }
    }
    public function render()
    {
        $this->polikliniks = JadwalDokter::where('hari', now()->dayOfWeek)->select('kodesubspesialis', 'namasubspesialis')->groupBy('kodesubspesialis', 'namasubspesialis')->get();
        return view('livewire.pendaftaran.anjungan-mandiri-daftar')
            ->layout('components.layouts.blank_adminlte');
    }
}
