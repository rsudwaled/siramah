<?php

namespace App\Livewire\Poliklinik;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Livewire\Component;

class AntrianPoliklinikProses extends Component
{
    public $kode_kunjungan;
    public $kunjungan, $antrian;
    public $tgl_masuk, $kode_unit;
    public function mount(Request $request)
    {
        $this->kode_kunjungan = $request->kode_kunjungan;
        $this->kunjungan = Kunjungan::with(['dokter', 'unit', 'penjamin_simrs', 'pasien', 'alasan_masuk', 'antrian', 'status'])
            ->firstWhere('kode_kunjungan', $this->kode_kunjungan);
        $this->antrian = $this->kunjungan->antrian;
        $this->tgl_masuk = $this->kunjungan->tgl_masuk;
        $this->kode_unit = $this->kunjungan->unit->kode_unit;
    }
    public function render()
    {
        return view('livewire.poliklinik.antrian-poliklinik-proses')->title('Kunjungan Poliklinik');
    }
}
