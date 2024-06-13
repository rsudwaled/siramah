<?php

namespace App\Livewire\Antrian;

use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\Poliklinik;
use App\Models\Unit;
use Livewire\Component;

class DisplayAntrianKlinik extends Component
{
    public $antrians, $lantai, $polikliniks, $unit, $antrianpanggil;


    public function updateAntrian()
    {
        $this->polikliniks = Poliklinik::where('lokasi',  $this->lantai)->get();
        $poli = $this->polikliniks->pluck('kodepoli');
        $this->antrianpanggil =  $this->antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->whereIn('kodepoli', $poli)
            ->where('taskid', 4)
            ->where('sync_panggil', 0)
            ->first();
        if ($this->antrianpanggil) {
            $this->dispatch('panggil-antrian');
            $this->antrianpanggil->update(['sync_panggil' => 1]);
        }
        $this->antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->whereIn('kodepoli', $poli)
            ->get();
    }
    public function mount($lantai)
    {
        $this->lantai = $lantai;
        $this->polikliniks = Poliklinik::where('lokasi',  $this->lantai)->get();
        $poli = $this->polikliniks->pluck('kodepoli');
        $this->antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->whereIn('kodepoli', $poli)
            ->get();
    }
    public function render()
    {
        return view('livewire.antrian.display-antrian-klinik')
            ->layout('components.layouts.display_poliklinik')
            ->title('Display Antrian Klinik');
    }
}
