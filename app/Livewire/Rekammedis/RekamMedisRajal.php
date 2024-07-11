<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use App\Models\Unit;
use Livewire\Component;

class RekamMedisRajal extends Component
{
    public  $kunjungans = [], $units = [], $dokters = [];
    public $tgl_masuk, $unit, $dokter;
    protected $queryString = ['tgl_masuk', 'unit'];
    public function mount()
    {
    //    dd($this->unit );
    }
    public function render()
    {
        $this->units = Unit::where('kelas_unit', 1)->where('KDPOLI', '!=', null)->pluck('nama_unit', 'kode_unit');
        if ($this->tgl_masuk) {
            $this->kunjungans = Kunjungan::with(['unit', 'dokter', 'pasien'])
                ->whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->unit)
                ->get();
        }
        return view('livewire.rekammedis.rekam-medis-rajal')->title('Rekam Medis Rajal');
    }
}
