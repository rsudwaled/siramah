<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Livewire\Component;

class RefDokter extends Component
{
    public $dokters = [];
    public function mount()
    {
        $api = new AntrianController();
        $res  = $api->ref_dokter();
        if ($res->metadata->code) {
            $this->dokters = $res->response;
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text')->title('Referensi Dokter');
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.ref-dokter')
            ->title('Referensi Dokter');
    }
}
