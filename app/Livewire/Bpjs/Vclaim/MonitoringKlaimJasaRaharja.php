<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class MonitoringKlaimJasaRaharja extends Component
{
    public $tanggalmulai, $tanggalakhir, $jenispelayanan;
    public $kunjungans = [];

    public function cari()
    {
        $this->validate([
            'tanggalmulai' => 'required',
            'tanggalakhir' => 'required',
            'jenispelayanan' => 'required',
        ]);
        $request = new Request([
            'jenisPelayanan' => $this->jenispelayanan,
            'tanggalMulai' => $this->tanggalmulai,
            'tanggalAkhir' => $this->tanggalakhir,
        ]);
        $api = new VclaimController($request);
        $res  = $api->monitoring_klaim_jasaraharja($request);
        if ($res->metadata->code == 200) {
            $this->kunjungans = $res->response->sep;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.monitoring-klaim-jasa-raharja')->title(
            'Monitroing Klaim Jasa Raharja'
        );
    }
}
