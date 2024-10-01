<?php

namespace App\Livewire\Operasi;

use Livewire\Component;

class KunjunganOperasi extends Component
{
    public $kunjungans;
    public $tgl_masuk;
    public $search;

    public function render()
    {

        return view('livewire.operasi.kunjungan-operasi')->title('Kunjungan Operasi');
    }
}
