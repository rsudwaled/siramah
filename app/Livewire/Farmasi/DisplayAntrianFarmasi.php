<?php

namespace App\Livewire\Farmasi;

use App\Models\OrderObatHeader;
use Livewire\Component;

class DisplayAntrianFarmasi extends Component
{
    public $unit, $tanggal, $playAudio;
    public $orders = [];
    public function mount($lantai)
    {
        if ($lantai == 2) {
            $this->unit = 4008;
        } else {
            $this->unit = 4002;
        }
    }
    public function updateAntrian()
    {
        $this->tanggal = now()->format('Y-m-d');
        try {
            $this->orders = [];
            if ($this->tanggal && $this->unit) {
                $ordersx = OrderObatHeader::with(['kunjungan', 'pasien', 'unit', 'asal_unit', 'dokter', 'penjamin_simrs', 'kunjungan.antrian'])
                    ->whereDate('tgl_entry', $this->tanggal)
                    ->where('status_order', '!=', 0)
                    ->where('status_order', '!=', 99)
                    ->where('kode_unit', $this->unit)
                    ->where('unit_pengirim', '!=', '1016')
                    ->get();
                $this->orders = $ordersx;
                // dd();
            }
            if ($this->tanggal && $this->unit == 4002) {
                $orders_yasmin = OrderObatHeader::with(['kunjungan', 'pasien', 'unit', 'asal_unit', 'dokter', 'penjamin_simrs', 'kunjungan.antrian'])
                    ->whereDate('tgl_entry',  $this->tanggal)
                    ->where('status_order', '!=', 0)
                    ->where('status_order', '!=', 99)
                    ->where('unit_pengirim', '1016')
                    ->get();
                $ordersx = $ordersx->merge($orders_yasmin);
                $this->orders = $ordersx;
            }
            $antrianpanggil = $this->orders->where('panggil', 1)->first();
            if ($antrianpanggil) {
                $this->playAudio = true;
                $this->dispatch('play-audio');
                $antrianpanggil->update(['panggil' => 2]);
            }
        } catch (\Throwable $th) {
            flash($th->getMessage(), 'danger');
        }
    }
    public function render()
    {
        return view('livewire.farmasi.display-antrian-farmasi')
            ->layout('components.layouts.display_poliklinik')
            ->title('Display Antrian Klinik');
    }
}
