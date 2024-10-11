<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use App\Models\Unit;
use Illuminate\Http\Request;
use Livewire\Component;

class KunjunganOperasi extends Component
{
    public $kunjungans = [];
    public $tgl_masuk, $kode_unit;
    public $jenispelayanan;
    public $units = [];
    public $search;

    public function mount(Request $request)
    {
        $this->tgl_masuk = $this->tgl_masuk ?? $request->tgl_masuk ?? now()->format('Y-m-d');
    }
    public function updatedJenispelayanan()
    {
        switch ($this->jenispelayanan) {
            case 'rajal':
                $this->kode_unit = null;
                $this->units = Unit::where('kelas_unit', 1)
                    ->orderBy('nama_unit', 'asc')
                    ->whereNotIn('kode_unit', ['1002', '1023', '1035'])
                    ->pluck('nama_unit', 'kode_unit');
                break;
            case 'ranap':
                $this->kode_unit = null;
                $this->units = Unit::where('kelas_unit', 2)
                    ->orderBy('nama_unit', 'asc')
                    ->pluck('nama_unit', 'kode_unit');
                break;
            case 'igd':
                $this->kode_unit = null;
                $this->units = Unit::where('kelas_unit', 1)
                    ->orderBy('nama_unit', 'asc')
                    ->whereNotIn('kode_unit', ['1002', '1023', '1035'])
                    ->pluck('nama_unit', 'kode_unit');
                break;

            default:
                # code...
                break;
        }
    }



    public function render()
    {
        if ($this->tgl_masuk && $this->kode_unit) {
            $this->kunjungans = Kunjungan::whereDate('tgl_masuk', $this->tgl_masuk)
                ->where('kode_unit', $this->kode_unit)
                ->with(['pasien', 'status','alasan_masuk','unit','dokter','penjamin_simrs'])
                ->get();
        }
        return view('livewire.operasi.kunjungan-operasi')->title('Kunjungan Operasi');
    }
}
