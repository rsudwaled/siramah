<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class RefPesertaFingerprint extends Component
{
    public $identitas, $noidentitas;
    public $nik, $nomorkartu, $tgllahir, $daftarfp;
    public function cari()
    {
        $api = new AntrianController();
        $request = new Request([
            'identitas' => $this->identitas,
            'noidentitas' => $this->noidentitas,
        ]);
        $res = $api->ref_pasien_fingerprint($request);
        if ($res->metadata->code == 200) {
            $this->nik = $res->response->nik;
            $this->nomorkartu = $res->response->nomorkartu;
            $this->tgllahir = $res->response->tgllahir;
            $this->daftarfp = $res->response->daftarfp;
            flash($res->metadata->message,  'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.ref-peserta-fingerprint')->title('Peserta Fingerprint');
    }
}
