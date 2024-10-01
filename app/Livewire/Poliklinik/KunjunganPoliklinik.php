<?php

namespace App\Livewire\Poliklinik;

use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class KunjunganPoliklinik extends Component
{
    public $kunjungans, $units;
    public $tgl_masuk, $kode_unit;
    public $search = '';
    public function pencarian() {}
    public function mount(Request $request)
    {
        $this->tgl_masuk = $request->tgl_masuk ?? now()->format('Y-m-d');
        $this->kode_unit = $request->kode_unit;
        $this->units = Unit::where('KDPOLI', '!=', null)->get();
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        if ($this->tgl_masuk && $this->kode_unit) {
            $this->kunjungans = [];
            $this->kunjungans = Kunjungan::whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->kode_unit)
                ->with(['dokter', 'unit', 'penjamin_simrs', 'pasien', 'alasan_masuk', 'antrian', 'status'])
                ->orderBy('tgl_masuk','asc')
                ->get();
        }
        return view('livewire.poliklinik.kunjungan-poliklinik')->title("Kunjungan Poliklinik");
    }
}
