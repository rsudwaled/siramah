<?php

namespace App\Livewire\Rekammedis;

use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RincianBiaya extends Component
{
    public $kunjungan, $rincians;
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $res = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','','')"));
        $this->rincians = $res;
        // dd($res->groupBy('KELOMPOK_TARIF'));
        // dd(money($res->sum("GRANTOTAL_LAYANAN"), 'IDR'));
    }
    public function render()
    {
        return view('livewire.rekammedis.rincian-biaya');
    }
}
