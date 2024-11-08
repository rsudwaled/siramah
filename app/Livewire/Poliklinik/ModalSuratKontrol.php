<?php

namespace App\Livewire\Poliklinik;

use App\Http\Controllers\VclaimController;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\Unit;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalSuratKontrol extends Component
{
    public $daftarantrian = true;
    public $antrian, $kunjungan, $tanggal, $formatfilter;
    public $nomorkartu, $noSEP, $tglRencanaKontrol, $poliKontrol, $kodeDokter, $noSuratKontrol, $jampraktek, $nohp;
    public $noSPRI;
    public $seps = [], $polis = [], $dokters = [], $dokterss, $units, $suratkontrols = [];
    public $formSuratKontrol = false, $formSpri = false;
    public function render()
    {
        return view('livewire.pendaftaran.modal-suratkontrol');
    }
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->nomorkartu = $kunjungan->pasien?->no_Bpjs;
        $this->nohp = $kunjungan->pasien?->no_hp;
        // $this->units = Unit::where('KDPOLI', '!=', null)->pluck('nama_unit', 'KDPOLI');
        // $this->dokters = Paramedis::where('kode_dokter_jkn', '!=', null)->pluck('nama_paramedis', 'kode_dokter_jkn');
    }
    public function buatSuratKontrol()
    {
        $this->reset(['noSEP', 'seps', 'tglRencanaKontrol', 'poliKontrol', 'kodeDokter', 'noSuratKontrol']);
        $this->formSuratKontrol = $this->formSuratKontrol ?  false : true;
        $this->formSpri = false;
    }
    public function buatSPRI()
    {
        $this->reset(['noSPRI',  'tglRencanaKontrol', 'poliKontrol', 'kodeDokter']);
        $this->formSpri = $this->formSpri ? false : true;
        $this->formSuratKontrol = false;
    }
    // public function insertSuratKontrol()
    // {
    //     $this->validate([
    //         'nomorkartu' => 'required',
    //         'noSEP' => 'required',
    //         'tglRencanaKontrol' => 'required',
    //         'poliKontrol' => 'required',
    //         'kodeDokter' => 'required',
    //     ]);
    //     $this->jampraktek = str_replace(' ', '', explode('|', $this->kodeDokter)[1]);
    //     $this->kodeDokter = explode('|', $this->kodeDokter)[0];
    //     $pasien = Pasien::firstWhere('nomorkartu', $this->nomorkartu);
    //     $jadwal = JadwalDokter::where("hari",  Carbon::parse($this->tglRencanaKontrol)->dayOfWeek)
    //         ->where("kodepoli", $this->poliKontrol)
    //         ->where('kodedokter', $this->kodeDokter)
    //         ->where("jampraktek", $this->jampraktek)
    //         ->first();
    //     if (!$jadwal || !$pasien) {
    //         return flash('Jadwal dokter / pasien tidak ditemukan', 'danger');
    //     }
    //     $api = new VclaimController();
    //     if ($this->noSuratKontrol) {
    //         $request = new Request([
    //             'noSuratKontrol' => $this->noSuratKontrol,
    //             'noSEP' => $this->noSEP,
    //             'kodeDokter' => $this->kodeDokter,
    //             'poliKontrol' => $this->poliKontrol,
    //             'tglRencanaKontrol' => $this->tglRencanaKontrol,
    //             'user' => auth()->user()->name,
    //         ]);
    //         $res = $api->suratkontrol_update($request);
    //     } else {
    //         $request = new Request([
    //             'user' => auth()->user()->name,
    //             'noSEP' => $this->noSEP,
    //             'poliKontrol' => $this->poliKontrol,
    //             'tglRencanaKontrol' => $this->tglRencanaKontrol,
    //             'kodeDokter' => $this->kodeDokter,
    //         ]);
    //         $res = $api->suratkontrol_insert($request);
    //     }
    //     if ($res->metadata->code == 200) {
    //         if ($this->daftarantrian) {
    //             $antrian = new AntrianController();
    //             $request = new Request([
    //                 // data pasien
    //                 'nomorkartu' => $pasien->nomorkartu,
    //                 'nik' => $pasien->nik,
    //                 'nohp' => $this->nohp ?? $pasien->nohp,
    //                 'norm' => $pasien->norm,
    //                 // data jadwal
    //                 'tanggalperiksa' => $this->tglRencanaKontrol,
    //                 'kodepoli' => $jadwal->kodesubspesialis,
    //                 'kodedokter' => $jadwal->kodedokter,
    //                 'jampraktek' => $jadwal->jampraktek,
    //                 // data surat kontrol
    //                 'jeniskunjungan' => 3,
    //                 'nomorreferensi' => $res->response->noSuratKontrol,
    //             ]);
    //             $antrian->ambil_antrian($request);
    //         }
    //         $this->formSuratKontrol = false;
    //         $this->formatfilter = 2;
    //         $this->tanggal = now()->format('Y-m');
    //         $this->cariDataSuratKontrol();
    //         return flash($res->metadata->message, 'success');
    //     } else {
    //         return flash($res->metadata->message, 'danger');
    //     }
    // }
    public function insertSPRI()
    {
        $this->validate([
            'nomorkartu' => 'required',
            'kodeDokter' => 'required',
            'poliKontrol' => 'required',
            'tglRencanaKontrol' => 'required',
        ]);
        $api = new VclaimController();
        if ($this->noSPRI) {
            $request = new Request([
                'noSPRI' => $this->noSPRI,
                'noKartu' => $this->nomorkartu,
                'kodeDokter' => $this->kodeDokter,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'user' => auth()->user()->name,
            ]);
            $res = $api->spri_update($request);
        } else {
            $request = new Request([
                'noKartu' => $this->nomorkartu,
                'kodeDokter' => $this->kodeDokter,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'user' => auth()->user()->name,
            ]);
            $res = $api->spri_insert($request);
        }
        if ($res->metadata->code == 200) {
            $this->formSuratKontrol = false;
            $this->formSpri = false;
            $this->formatfilter = 2;
            $this->tanggal = now()->format('Y-m');
            $this->cariDataSuratKontrol();
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function editSurat($noSuratKontrol, $noSepAsalKontrol)
    {
        $this->noSuratKontrol = $noSuratKontrol;
        $this->noSEP = $noSepAsalKontrol;
        $this->formSuratKontrol = true;
    }
    public function editSPRI($noSPRI)
    {
        $this->noSPRI = $noSPRI;
        $this->formSpri = true;
    }
    public function hapusSurat($noSuratKontrol)
    {
        $this->noSuratKontrol = $noSuratKontrol;
        $api = new VclaimController();
        $request = new Request([
            'noSuratKontrol' => $this->noSuratKontrol,
            'user' => auth()->user()->name,
        ]);
        $res = $api->suratkontrol_delete($request);
        if ($res->metadata->code == 200) {
            $this->cariDataSuratKontrol();
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariDokter()
    {
        $this->validate([
            'poliKontrol' => 'required',
            'tglRencanaKontrol' => 'required',
        ]);
        $api = new VclaimController();
        $request = new Request([
            'kodePoli' => $this->poliKontrol,
            'tglRencanaKontrol' => $this->tglRencanaKontrol
        ]);
        $res = $api->suratkontrol_dokter($request);
        if ($res->metadata->code == 200) {
            $this->dokters = [];
            foreach ($res->response->list as $key => $value) {
                $this->dokters[] = [
                    'no' => $key + 1,
                    'kodeDokter' => $value->kodeDokter,
                    'namaDokter' => $value->namaDokter,
                    'jadwalPraktek' => $value->jadwalPraktek,
                ];
            }
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariPoli()
    {
        $this->validate([
            'noSEP' => 'required',
            'tglRencanaKontrol' => 'required',
        ]);
        $api = new VclaimController();
        $request = new Request([
            'nomor' => $this->noSEP,
            'jenisKontrol' => 2,
            'tglRencanaKontrol' => $this->tglRencanaKontrol
        ]);
        $res = $api->suratkontrol_poli($request);
        if ($res->metadata->code == 200) {
            $this->polis = [];
            foreach ($res->response->list as $key => $value) {
                $this->polis[] = [
                    'no' => $key + 1,
                    'kodePoli' => $value->kodePoli,
                    'namaPoli' => $value->namaPoli,
                    'persentase' => $value->persentase,
                ];
            }
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariSEP()
    {
        $this->validate([
            'nomorkartu' => 'required',
        ]);
        $api = new VclaimController();
        $request = new Request([
            'nomorkartu' => $this->nomorkartu,
            'tanggalMulai' => now()->subDays(90)->format('Y-m-d'),
            'tanggalAkhir' => now()->format('Y-m-d'),
        ]);
        $res = $api->monitoring_pelayanan_peserta($request);
        if ($res->metadata->code == 200) {
            $this->seps = [];
            foreach ($res->response->histori as $key => $value) {
                $this->seps[] = [
                    'no' => $key + 1,
                    'noSep' => $value->noSep,
                    'tglSep' => $value->tglSep,
                    'poli' => $value->poli,
                    'ppkPelayanan' => $value->ppkPelayanan,
                ];
            }
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariDataSuratKontrol()
    {
        $this->validate([
            'nomorkartu' => 'required',
            "tanggal" => "required",
            "formatfilter" => "required",
        ]);
        $api = new VclaimController();
        $request = new Request([
            'nomorkartu' => $this->nomorkartu,
            'tanggal' => $this->tanggal,
            'formatfilter' => $this->formatfilter,
        ]);
        $res = $api->suratkontrol_peserta($request);
        $this->suratkontrols = [];
        if ($res->metadata->code == 200) {
            $this->suratkontrols = $res->response->list;
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
}
