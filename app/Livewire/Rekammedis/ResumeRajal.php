<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use Livewire\Component;

class ResumeRajal extends Component
{
    public $kunjungan;
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }
    public function render()
    {
        return view('livewire.rekammedis.resume-rajal');
    }
}
