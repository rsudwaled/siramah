<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use Livewire\Component;

class LaporanPasienOperasi extends Component
{
    public $kunjungans;
    public function render()
    {
        $this->kunjungans = Kunjungan::whereHas('laporan_operasi')->get();
        return view('livewire.operasi.laporan-pasien-operasi')
            ->title('Laporan Pasien Operasi');
    }
}
