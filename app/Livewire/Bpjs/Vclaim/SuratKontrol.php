<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class SuratKontrol extends Component
{
    public $formatfilter, $tanggalAwal, $tanggalAkhir;
    public $nomorkartu, $noSEP, $tglRencanaKontrol, $poliKontrol, $kodeDokter, $noSuratKontrol;
    public $suratkontrols = [];
    public $seps = [], $polis = [], $dokters = [];
    public $openmodalSK = false;
    public $openmodalSPRI = false;

    public function modalSPRI()
    {
        $this->openmodalSPRI = $this->openmodalSPRI ? false : true;
    }
    public function modalSK()
    {
        $this->reset(['nomorkartu', 'noSEP', 'tglRencanaKontrol', 'poliKontrol', 'kodeDokter', 'noSuratKontrol']);
        $this->openmodalSK = $this->openmodalSK ? false : true;
    }
    public function editSurat($noSurat)
    {
        $api = new VclaimController();
        $request = new Request([
            'noSuratKontrol' => $noSurat
        ]);
        $res = $api->suratkontrol_nomor($request);
        if ($res->metadata->code == 200) {
            $this->noSuratKontrol = $res->response->noSuratKontrol;
            $this->nomorkartu = $res->response->sep->peserta->noKartu;
            $this->nomorkartu = $res->response->sep->peserta->noKartu;
            $this->noSEP = $res->response->sep->noSep;
            $this->tglRencanaKontrol = $res->response->tglRencanaKontrol;
            $this->poliKontrol = $res->response->poliTujuan;
            $this->kodeDokter = $res->response->kodeDokter;
            $this->openmodalSK = true;
            flash($res->metadata->message . ' Surat telah dihapus', 'success');
            return redirect(route('vclaim.suratkontrol_print') . "?noSuratKontrol=" .  $this->noSuratKontrol)->with('new_tab', true);
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function hapusSurat($noSurat)
    {
        $api = new VclaimController();
        $request = new Request([
            'user' => auth()->user()->name,
            'noSuratKontrol' => $noSurat
        ]);
        $res = $api->suratkontrol_delete($request);
        if ($res->metadata->code == 200) {
            $this->dispatch('refreshSuratKontrol');
            return flash($res->metadata->message . ' Surat telah dihapus', 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
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
                'user' => auth()->user()->name,
                'noSEP' => $this->noSEP,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'kodeDokter' => $this->kodeDokter,
            ]);
            $res = $api->suratkontrol_update($request);
            if ($res->metadata->code == 200) {
                $this->modalSK();
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } else {
            $request = new Request([
                'user' => auth()->user()->name,
                'noSEP' => $this->noSEP,
                'poliKontrol' => $this->poliKontrol,
                'tglRencanaKontrol' => $this->tglRencanaKontrol,
                'kodeDokter' => $this->kodeDokter,
            ]);
            $res = $api->suratkontrol_insert($request);
            if ($res->metadata->code == 200) {
                $this->modalSK();
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
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
            'formatfilter' => 'required',
            'tanggalAwal' => 'required',
            'tanggalAkhir' => 'required',
        ]);
        $request = new Request([
            'formatfilter' => $this->formatfilter,
            'tglawal' => $this->tanggalAwal,
            'tglakhir' => $this->tanggalAkhir,
        ]);
        $api = new VclaimController();
        $res  = $api->suratkontrol_tanggal($request);
        if ($res->metadata->code == 200) {
            $this->suratkontrols = $res->response->list;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.surat-kontrol')->title('Surat Kontrol');
    }
}
