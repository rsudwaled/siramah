<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;

class RefJadwalDokter extends Component
{
    public $kodepoli, $tanggal;
    public $polikliniks = [];
    public $jadwals = [];
    public function cari()
    {
        $this->validate([
            'tanggal' => 'required',
            'kodepoli' => 'required',
        ]);
        $request = new Request([
            'kodepoli' => $this->kodepoli,
            'tanggal' => $this->tanggal,
        ]);
        $api = new AntrianController();
        $res  = $api->ref_jadwal_dokter($request);
        if ($res->metadata->code == 200) {
            $this->jadwals = $res->response;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function mount()
    {
        $api = new AntrianController();
        $res  = $api->ref_poli();
        if ($res->metadata->code) {
            $this->polikliniks = $res->response;
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text')->title('Referensi Jadwal Dokter');
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.ref-jadwal-dokter')->title('Referensi Jadwal Dokter');
    }
}
