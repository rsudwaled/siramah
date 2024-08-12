<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use Livewire\Component;
use Livewire\WithPagination;

class HistoriKunjungan extends Component
{
    use WithPagination;
    // public $kunjungans = [];
    public $kunjungan, $pasien;
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->pasien = $kunjungan->pasien;
    }
    public function render()
    {
        $kunjungans = Kunjungan::where('no_rm', $this->pasien->no_rm)
            ->orderBy('tgl_masuk', 'desc')
            ->with(['unit'])
            ->paginate(5);
        return view('livewire.rekammedis.histori-kunjungan', compact('kunjungans'));
    }
}
