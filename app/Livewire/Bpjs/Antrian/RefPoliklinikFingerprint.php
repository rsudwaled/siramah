<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Livewire\Component;

class RefPoliklinikFingerprint extends Component
{
    public $polikliniks = [];
    public function mount()
    {
        $api = new AntrianController();
        $res  = $api->ref_poli_fingerprint();
        if ($res->metadata->code) {
            $this->polikliniks = $res->response;
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text')->title('Referensi Poliklinik');
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.ref-poliklinik-fingerprint');
    }
}
