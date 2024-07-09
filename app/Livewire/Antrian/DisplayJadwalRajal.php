<?php

namespace App\Livewire\Antrian;

use App\Models\Antrian;
use App\Models\JadwalDokter;
use Livewire\Component;

class DisplayJadwalRajal extends Component
{
    public $antrians;
    public function render()
    {
        $jadwals = JadwalDokter::where('hari', now()->dayOfWeek)
            ->orderBy('namasubspesialis', 'asc')
            ->get();
        $this->antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))->get();
        return view('livewire.antrian.display-jadwal-rajal', compact('jadwals'))
            ->layout('components.layouts.blank_adminlte');
    }
}
