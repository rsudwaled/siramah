<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class MonitoringPelayananPeserta extends Component
{
    public $nomorkartu;
    public $kunjungans = [];
    public function cari()
    {
        $this->validate([
            'nomorkartu' => 'required',
        ]);

        $request = new Request([
            'nomorkartu' => $this->nomorkartu,
            'tanggalMulai' => now()->subDays(90)->format('Y-m-d'),
            'tanggalAkhir' => now()->format('Y-m-d'),
        ]);
        $api = new VclaimController();
        $res  = $api->monitoring_pelayanan_peserta($request);
        if ($res->metadata->code == 200) {
            $this->kunjungans = $res->response->histori;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.monitoring-pelayanan-peserta')->title(
            'Monitroing Pelayanan Peserta'
        );
    }
}
