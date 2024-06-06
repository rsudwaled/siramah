<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class AntreanDokter extends Component
{
    public $antrians = [];
    public $kodepoli, $kodedokter, $hari, $jampraktek;

    public function render()
    {
        $api = new AntrianController();
        $request = new Request([
            'kodepoli' => request('kodepoli'),
            'kodedokter' => request('kodedokter'),
            'hari' => request('hari'),
            'jampraktek' => request('jampraktek'),
        ]);
        $res  = $api->antrian_poliklinik($request);
        if ($res->metadata->code == 200) {
            $this->antrians = $res->response;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
        return view('livewire.bpjs.antrian.antrean-dokter')->title('Antrean Dokter Poliklinik');
    }
}
