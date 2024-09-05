<?php

namespace App\Livewire\Poliklinik;

use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class AntrianPoliklinikRajal extends Component
{
    public $kunjungans = [], $units = [];
    public $tgl_masuk, $kode_unit;
    public $search = '';
    public function pencarian() {}
    public function mount(Request $request)
    {
        $this->tgl_masuk = Carbon::parse($request->tgl_masuk)->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->kode_unit = $request->kode_unit;
        $this->units = Unit::where('KDPOLI', '!=', null)->get();
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        if ($this->tgl_masuk && $this->kode_unit) {
            $this->kunjungans = [];
            $this->kunjungans = Kunjungan::with(['dokter', 'unit', 'penjamin_simrs', 'pasien', 'alasan_masuk', 'antrian', 'status'])->whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->kode_unit)->get();
        }
        return view('livewire.poliklinik.antrian-poliklinik-rajal')->title("Kunjungan Poliklinik");
    }
}
