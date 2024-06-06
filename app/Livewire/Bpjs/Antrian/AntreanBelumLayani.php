<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class AntreanBelumLayani extends Component
{
    public $antrians = [];
    public function mount()
    {
        $api = new AntrianController();
        $request = new Request();
        $res  = $api->antrian_belum_dilayani($request);
        if ($res->metadata->code == 200) {
            $this->antrians = $res->response;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text')->title('Antrean Belum Layani');
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.antrean-belum-layani')->title('Antrean Belum Layani');
    }
}
