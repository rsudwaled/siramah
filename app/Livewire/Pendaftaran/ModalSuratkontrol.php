<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalSuratkontrol extends Component
{
    public $antrian, $tanggal, $formatfilter;
    public $nomorkartu, $noSEP, $tglRencanaKontrol, $poliKontrol, $kodeDokter, $noSuratKontrol;
    public $seps = [], $polis = [], $dokters = [], $suratkontrols = [], $form = false;

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
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function editSurat($noSuratKontrol, $noSepAsalKontrol)
    {
        $this->noSuratKontrol = $noSuratKontrol;
        $this->noSEP = $noSepAsalKontrol;
        $this->form = true;
    }
    public function buatSuratKontrol()
    {
        $this->validate([
            'nomorkartu' => 'required',
            'noSEP' => 'required',
            'tglRencanaKontrol' => 'required',
            'poliKontrol' => 'required',
            'kodeDokter' => 'required',
        ]);
        $api = new VclaimController();
        if ($this->noSuratKontrol) {
            $request = new Request([
                'noSuratKontrol' => $this->noSuratKontrol,
                'noSEP' => $this->noSEP,
                'kodeDokter' => $this->kodeDokter,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'user' => auth()->user()->name,
            ]);
            $res = $api->suratkontrol_update($request);
        } else {
            $request = new Request([
                'user' => auth()->user()->name,
                'noSep' => $this->noSEP,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'kodeDokter' => $this->kodeDokter,
            ]);
            $res = $api->suratkontrol_insert($request);
        }
        if ($res->metadata->code == 200) {
            $this->form = false;
            $this->formatfilter = 2;
            $this->tanggal = now()->format('Y-m');
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
            'jenisKontrol' => 2,
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
        if ($res->metadata->code == 200) {
            $this->suratkontrols = [];
            $this->suratkontrols = $res->response->list;
            return flash($res->metadata->message, 'success');
        } else {
            $this->suratkontrols = [];
            return flash($res->metadata->message, 'danger');
        }
    }
    public function mount(Antrian $antrian)
    {
        $this->antrian = $antrian;
        $this->nomorkartu = $antrian->nomorkartu;
    }
    public function render()
    {
        return view('livewire.pendaftaran.modal-suratkontrol');
    }
}
