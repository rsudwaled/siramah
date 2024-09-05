<?php

namespace App\Livewire\Poliklinik;

use App\Http\Controllers\IcareController;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalIcare extends Component
{
    public $kunjungan, $message, $url, $icare = false;
    public function mount($kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $api = new IcareController();
        $request = new Request([
            'nomorkartu' => $kunjungan->pasien->no_Bpjs,
            'kodedokter' => $kunjungan->dokter->kode_dokter_jkn,
        ]);
        $res = $api->icare($request);
        if ($res->metadata->code == 200) {
            $this->icare = true;
            $this->url = $res->response->url;
        } else {
            $this->message = $res->metadata->message;
        }
    }
    public function render()
    {
        return view('livewire.poliklinik.modal-icare');
    }
}
