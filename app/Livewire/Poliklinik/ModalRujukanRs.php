<?php

namespace App\Livewire\Poliklinik;

use Livewire\Component;

class ModalRujukanRs extends Component
{
    public $kunjungan;
    public function mount($kunjungan) {
        $this->kunjungan = $kunjungan;
    }
    public function render()
    {
        return view('livewire.poliklinik.modal-rujukan-rs');
    }
}
