<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Livewire\Component;

class ErmOperasi extends Component
{
    public $kunjungan;
    public function mount(Request $request)
    {
        $this->kunjungan = Kunjungan::with(['pasien', 'unit', 'dokter'])
            ->where('kode_kunjungan', $request->kode_kunjungan)
            ->first();
    }
    public function render()
    {
        return view('livewire.operasi.erm-operasi')->title('ERM Operasi');
    }
}
