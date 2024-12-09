<?php

namespace App\Livewire\Poliklinik;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Livewire\Component;

class KunjunganPoliklinikPasien extends Component
{
    public $kunjungan;
    public function render()
    {
        return view('livewire.poliklinik.kunjungan-poliklinik-pasien')->title('Kunjungan Poliklinik');
    }
    public function mount(Request $request)
    {
        $this->kunjungan = Kunjungan::where('kode_kunjungan', $request->kode_kunjungan)
            ->with(['pasien','status','unit','dokter','antrian'])
            ->first();
    }
}
