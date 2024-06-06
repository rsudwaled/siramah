<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class ListTaskid extends Component
{
    public $kodebooking, $taskid = [];
    public function cari()
    {
        $this->validate([
            'kodebooking' => 'required',
        ]);
        $request = new Request([
            'kodebooking' => $this->kodebooking,
        ]);
        $api = new AntrianController();
        $res  = $api->taskid_antrean($request);
        if ($res->metadata->code == 200) {
            $this->taskid = $res->response;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.list-taskid')->title('List Taskid');
    }
}
