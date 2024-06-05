<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class AntrianTanggal extends Component
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
        $res  = $api->dashboard_tanggal($request);
        if ($res->metadata->code == 200) {
            $this->antrians = $res->response->list;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.antrian-tanggal')->title(
            'Dashboard Antrian Tanggal'
        );
    }
}
