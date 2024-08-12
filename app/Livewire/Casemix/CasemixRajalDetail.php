<?php

namespace App\Livewire\Casemix;

use App\Models\Kunjungan;
use Livewire\Component;

class CasemixRajalDetail extends Component
{
    public $kode, $kunjungan;
    protected $listeners = ['refreshPage' => '$refresh'];
    protected $queryString = ['kode'];
    public function mount()
    {
        $this->kunjungan = Kunjungan::with(['unit', 'dokter', 'pasien', 'penjamin_simrs'])
            ->where('kode_kunjungan', $this->kode)
            ->first();
    }
    public function render()
    {
        return view('livewire.casemix.casemix-rajal-detail')
            ->title('Casemix Rawat Jalan');
    }
}
