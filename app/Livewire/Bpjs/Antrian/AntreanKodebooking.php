<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Livewire\Component;
use Illuminate\Http\Request;

class AntreanKodebooking extends Component
{
    public $antrian;
    public function mount($kodebooking)
    {
        $request = new Request([
            'kodebooking' => $kodebooking,
        ]);
        $api = new AntrianController();
        $res  = $api->antrian_kodebooking($request);
        if ($res->metadata->code == 200) {
            $this->antrian = $res->response[0];
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text')->title('Antrean Kodebooking');
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.antrean-kodebooking')->title('Antrean Kodebooking');
    }
}
