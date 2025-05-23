<?php

namespace App\Livewire\Farmasi;

use App\Models\TipeBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LaporanPengadaanFarmasi extends Component
{
    public $tanggalAwal, $tanggalAkhir,  $tipe;
    public $tipeBarang;
    public $obats = [];
    public function cari()
    {
        $this->validate([
            'tanggalAwal' => 'required',
            'tanggalAkhir' => 'required',
        ]);
        // $response = collect(DB::connection('mysql2')->select("CALL SP_DASAR_PENGADAAN_FARMASI('" . $this->tanggalAwal . "','" . $this->tanggalAkhir . "','','')"));
        // $this->obats = $response;
        $this->dispatch('refreshLaporanPengadaanFarmasi');
    }
    public function render()
    {
        if ($this->tanggalAkhir && $this->tanggalAwal) {
            $response = collect(DB::connection('mysql2')->select("CALL SP_DASAR_PENGADAAN_FARMASI('" . $this->tanggalAwal . "','" . $this->tanggalAkhir . "','','" . $this->tipe . "')"));
            $this->obats = $response;
        }
        return view('livewire.farmasi.laporan-pengadaan-farmasi');
    }
    public function mount()
    {
        $this->tipeBarang = TipeBarang::all();
    }
}
