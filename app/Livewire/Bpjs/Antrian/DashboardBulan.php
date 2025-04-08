<?php

namespace App\Livewire\Bpjs\Antrian;

use App\Http\Controllers\AntrianController;
use Illuminate\Http\Request;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class DashboardBulan extends Component
{
    public $tanggal, $waktu,  $antrians = [];
    public function cari()
    {
        $this->validate([
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        $request = new Request([
            'waktu' => $this->waktu,
            'bulan' => explode('-', $this->tanggal)[1],
            'tahun' => explode('-', $this->tanggal)[0],
        ]);
        $api = new AntrianController();
        $res  = $api->dashboard_bulan($request);
        if ($res->metadata->code == 200) {
            $this->antrians = $res->response->list;
            // dd(collect($this->antrians)->sum('jumlah_antrean'));
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.antrian.dashboard-bulan')->title(
            'Dashboard Antrian Bulan'
        );
    }
}
