<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use App\Models\Unit;
use Livewire\Component;

class RekamMedisRajal extends Component
{
    public  $kunjungans = [], $units = [], $dokters = [];
    public $tgl_masuk, $unit, $search;
    protected $queryString = ['tgl_masuk', 'unit'];
    public function cariTanggal()
    {
        //    dd($this->unit );
    }
    public function mount()
    {
        //    dd($this->unit );
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        $this->units = Unit::where('kelas_unit', 1)->where('KDPOLI', '!=', null)->orderBy('nama_unit', 'asc')->pluck('nama_unit', 'kode_unit');
        if ($this->tgl_masuk && $this->unit == 0 && !$this->search) {
            $this->kunjungans = Kunjungan::with(['unit', 'dokter', 'pasien'])
                ->whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('unit.kelas_unit', $this->unit)
                ->get();
        }
        if ($this->tgl_masuk && $this->unit && !$this->search) {
            $this->kunjungans = Kunjungan::with(['unit', 'dokter', 'pasien'])
                ->whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->unit)
                ->get();
        }
        if ($this->tgl_masuk && $this->unit && $this->search) {
            $this->kunjungans = Kunjungan::with(['unit', 'dokter', 'pasien'])
                ->whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->unit)
                ->whereHas('pasien', function ($query) use ($search) {
                    $query->where('nama_px', 'like', "%{$search}%")
                        ->orWhere('no_rm', 'like', "%{$search}%");
                })
                ->get();
        }
        return view('livewire.rekammedis.rekam-medis-rajal')->title('Rekam Medis Rawat Jalan');
    }
}
