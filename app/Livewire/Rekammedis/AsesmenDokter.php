<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use Livewire\Component;

class AsesmenDokter extends Component
{
    public $kunjungan, $asesmendokter;
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->asesmendokter = $kunjungan->assesmen_dokter;
    }
    public function render()
    {
        return view('livewire.rekammedis.asesmen-dokter');
    }
}
