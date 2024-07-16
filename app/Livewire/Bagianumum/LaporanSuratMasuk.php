<?php

namespace App\Livewire\Bagianumum;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanSuratMasuk extends Component
{
    use WithPagination;
    public $tanggal, $suratmasuks = [];
    public function cari()
    {
        $awalbulan = Carbon::parse($this->tanggal)->startOfMonth();
        $akhirbulan = Carbon::parse($this->tanggal)->endOfMonth();
        $this->suratmasuks = SuratMasuk::with(['lampiran'])
            ->whereBetween('created_at', [$awalbulan, $akhirbulan])
            ->get();
    }
    public function render()
    {
        return view('livewire.bagianumum.laporan-surat-masuk')->title('Laporan Surat Masuk');
    }
}
