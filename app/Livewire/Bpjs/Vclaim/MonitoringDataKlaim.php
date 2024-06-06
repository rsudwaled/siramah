<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class MonitoringDataKlaim extends Component
{
    public $tanggal, $jenispelayanan, $statusklaim;
    public $kunjungans = [];
    public function cari()
    {
        $this->validate([
            'tanggal' => 'required',
            'jenispelayanan' => 'required',
            'statusklaim' => 'required',

        ]);
        $request = new Request([
            'jenisPelayanan' => $this->jenispelayanan,
            'tanggalPulang' => $this->tanggal,
            'statusKlaim' => $this->statusklaim,
        ]);
        $api = new VclaimController();
        $res  = $api->monitoring_data_klaim($request);
        if ($res->metadata->code == 200) {
            $this->kunjungans = $res->response->klaim;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.monitoring-data-klaim')->title(
            'Monitroing Data Klaim'
        );
    }
}
