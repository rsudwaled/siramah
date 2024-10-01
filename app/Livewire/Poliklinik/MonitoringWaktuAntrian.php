<?php

namespace App\Livewire\Poliklinik;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Livewire\Component;

class MonitoringWaktuAntrian extends Component
{
    public $antrians;
    public $tanggalperiksa, $kodepoli;
    public function mount(Request $request)
    {
        $this->tanggalperiksa = $request->tanggalperiksa;
    }
    public function render()
    {
        if ($this->tanggalperiksa) {
            $this->antrians = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
                // ->where('kodepoli', $this->kodepoli)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->with(['kunjungan','kunjungan.assesmen_perawat'])
                ->orderBy('taskid', 'desc')
                ->get();


        }
        return view('livewire.poliklinik.monitoring-waktu-antrian')->title('Monitoring Waktu Antrian');
    }
}
