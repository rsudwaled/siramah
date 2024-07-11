<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use Livewire\Component;

class RekamMedisRajalDetail extends Component
{
    public $kode, $kunjungan;
    protected $queryString = ['kode'];
    public function mount()
    {
        $this->kunjungan = Kunjungan::with(['unit', 'dokter', 'pasien', 'penjamin_simrs'])
            ->where('kode_kunjungan', $this->kode)
            ->first();
    }
    public function render()
    {
        return view('livewire.rekammedis.rekam-medis-rajal-detail')
            ->title('Rekam Medis Rawat Jalan');
    }
}
