<?php

namespace App\Livewire\Poliklinik;

use App\Models\Antrian;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Livewire\Component;

class DashboardAntrianRajal extends Component
{
    public $tgl_awal, $tgl_akhir, $kunjungans = [], $antrians = [];
    public function render()
    {
        if ($this->tgl_awal && $this->tgl_akhir) {
            $this->antrians = Antrian::whereBetween('tanggalperiksa', [$this->tgl_awal, $this->tgl_akhir])
                ->where('method', '!=', 'Offline')
                ->orderBy('tanggalperiksa', 'asc')
                ->get();
            $this->kunjungans = Kunjungan::whereBetween('tgl_masuk', [Carbon::parse($this->tgl_awal)->startOfDay(), Carbon::parse($this->tgl_akhir)->endOfDay()])
                ->where('status_kunjungan', "!=", 8)
                ->where('kode_unit', "!=", null)
                ->where('kode_unit', 'LIKE', '10%')
                ->where('kode_unit', "!=", 1002)
                ->where('kode_unit', "!=", 1023)
                ->orderBy('tgl_masuk', 'asc')
                ->with(['dokter', 'unit', 'pasien', 'order_obat_header', 'surat_kontrol', 'antrian'])
                ->get();
        }
        return view('livewire.poliklinik.dashboard-antrian-rajal')->title('Dashboard Antrian Rawat Jalan');
    }
    public function mount()
    {
        $this->tgl_awal = now()->format('Y-m-d');
        $this->tgl_akhir = now()->format('Y-m-d');
    }
}
