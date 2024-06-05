<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class Sep extends Component
{
    public $tanggal, $jenispelayanan;
    public $kunjungans = [];
    public $openmodalSEP = false;

    public function modalSEP()
    {
        // $this->reset(['nomorkartu', 'noSEP', 'tglRencanaKontrol', 'poliKontrol', 'kodeDokter', 'noSuratKontrol']);
        $this->openmodalSEP = $this->openmodalSEP ? false : true;
    }
    public function cari()
    {
        $this->validate([
            'tanggal' => 'required',
            'jenispelayanan' => 'required',
        ]);
        $request = new Request([
            'jenispelayanan' => $this->jenispelayanan,
            'tanggal' => $this->tanggal,
        ]);
        $api = new VclaimController();
        $res  = $api->monitoring_data_kunjungan($request);
        if ($res->metadata->code == 200) {
            $this->kunjungans = $res->response->sep;
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.sep')->title(
            'SEP Kunjungan'
        );
    }
}
