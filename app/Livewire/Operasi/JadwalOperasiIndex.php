<?php

namespace App\Livewire\Operasi;

use App\Models\JadwalOperasi;
use Livewire\Component;

class JadwalOperasiIndex extends Component
{
    public $jadwals;
    public $bulan;
    public function render()
    {
        if ($this->bulan) {
            $this->jadwals = JadwalOperasi::where('tanggal', 'like', $this->bulan . '%')->get();
        }
        return view('livewire.operasi.jadwal-operasi-index')->title('Jadwal Operasi Pasien');
    }
}
