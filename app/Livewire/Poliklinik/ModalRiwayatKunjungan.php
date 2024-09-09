<?php

namespace App\Livewire\Poliklinik;

use App\Models\Kunjungan;
use Livewire\Component;

class ModalRiwayatKunjungan extends Component
{
    public $kunjungan, $pasien, $kunjungans;
    public function mount($kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->kunjungans = Kunjungan::where('no_rm', $kunjungan->no_rm)
            ->get();
    }

    public function render()
    {
        return view('livewire.poliklinik.modal-riwayat-kunjungan');
    }
}
