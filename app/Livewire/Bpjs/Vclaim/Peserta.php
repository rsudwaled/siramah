<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class Peserta extends Component
{
    public $tanggal, $nomorkartu, $nik, $peserta;
    public function cariNIK()
    {
        $this->validate([
            'nik' => 'required',
            'tanggal' => 'required',
        ]);
        $request = new Request([
            'nik' => $this->nik,
            'tanggal' => $this->tanggal,
        ]);
        $api = new VclaimController();
        $res  = $api->peserta_nik($request);
        if ($res->metadata->code == 200) {
            $this->peserta = $res->response->peserta;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function cariNomorKartu()
    {
        $this->validate([
            'nomorkartu' => 'required',
            'tanggal' => 'required',
        ]);
        $request = new Request([
            'nomorkartu' => $this->nomorkartu,
            'tanggal' => $this->tanggal,
        ]);
        $api = new VclaimController();
        $res  = $api->peserta_nomorkartu($request);
        if ($res->metadata->code == 200) {
            $this->peserta = $res->response->peserta;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.peserta')->title('Peserta BPJS');
    }
}
