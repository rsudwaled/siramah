<?php

namespace App\Livewire\Poliklinik;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalSep extends Component
{
    public $kunjungan, $seps, $message;
    public function mount($kunjungan)
    {
        $this->kunjungan = $kunjungan;

        $api = new VclaimController();
        $request = new Request([
            "nomorkartu" => $kunjungan->pasien->no_Bpjs,
            "tanggalMulai" => now()->subDay(90)->format('Y-m-d'),
            "tanggalAkhir"  =>  now()->format('Y-m-d'),
        ]);
        $res = $api->monitoring_pelayanan_peserta($request);
        if ($res->metadata->code != 200) {
            return flash($res->metadata->message, 'danger');
        }
        $this->seps = $res->response->histori;
    }
    public function render()
    {
        return view('livewire.poliklinik.modal-sep');
    }
}
