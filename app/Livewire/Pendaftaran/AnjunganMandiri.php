<?php

namespace App\Livewire\Pendaftaran;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Livewire\Component;

class AnjunganMandiri extends Component
{
    public function testCetakKarcis()
    {
        return view('livewire.pendaftaran.test-cetak-karcis');
    }
    public function cetakKarcisUmum(Request $request){
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        return view('livewire.pendaftaran.antrian-cetak-karcis-umum', compact('antrian'));
    }
    public function cetakKarcisBpjs(Request $request){
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        return view('livewire.pendaftaran.antrian-cetak-karcis-bpjs', compact('antrian'));
    }
    public function render()
    {
        return view('livewire.pendaftaran.anjungan-mandiri')
            ->layout('components.layouts.blank_adminlte');
    }
}
