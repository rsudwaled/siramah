<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Livewire\Component;
use Illuminate\Http\Request;

class AntreanTanggal extends Component
{
    public $tanggal,  $antrians = [];
    public function cari()
    {
        $this->validate([
            'tanggal' => 'required',
        ]);
        $request = new Request([
            'tanggal' => $this->tanggal,
        ]);
        $api = new AntrianController();
        $res  = $api->antrian_tanggal($request);
        if ($res->metadata->code == 200) {
            $this->antrians = $res->response;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.antrean-tanggal')->title(
            'Antrian Tanggal'
        );
    }
}
