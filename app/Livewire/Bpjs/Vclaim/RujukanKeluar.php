<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class RujukanKeluar extends Component
{
    public $rujukans;
    public $tglMulai, $tglAkhir;
    public function render(Request $request)
    {
        $api = new VclaimController();
        $this->tglMulai = '2024-11-01';
        $this->tglAkhir = '2024-11-15';
        $request['tglMulai'] = '2024-11-01';
        $request['tglAkhir'] = '2024-11-11';
        $res =  $api->rujukan_keluar($request);
        if ($res->metadata->code == 200) {
            $this->rujukans = $res->response->list;
        }
        return view('livewire.bpjs.vclaim.rujukan-keluar')->title('Rujukan Keluar');
    }
}
