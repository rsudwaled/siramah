<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class KunjunganPasienOperasi extends Component
{
    public $kunjungans = [];
    public $tgl_masuk, $kode_unit;
    public $jenispelayanan;
    public $units = [];
    public $search;
    public function render()
    {
        $query = Kunjungan::with(['pasien', 'status', 'alasan_masuk', 'unit', 'dokter', 'penjamin_simrs']);
        if ($this->tgl_masuk && $this->kode_unit) {
            $unit = Unit::firstWhere('kode_unit', $this->kode_unit);
            if ($unit->kelas_unit == 2) {
                $tgl_awal = Carbon::parse($this->tgl_masuk)->endOfDay();
                $tgl_akhir = Carbon::parse($this->tgl_masuk)->startOfDay();
                $query->where('tgl_masuk', '<=', $tgl_awal)
                    ->where('tgl_keluar', '>=', $tgl_akhir)
                    ->where('kode_unit', $this->kode_unit)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $this->kode_unit);
            } else {
                $query->whereDate('tgl_masuk', $this->tgl_masuk)
                    ->where('kode_unit', $this->kode_unit);
            }
            if ($this->search) {
                $query->whereHas('pasien', function ($q) {
                    $q->where('nama_px', 'like', '%' . $this->search . '%');
                });
            }
            $this->kunjungans = $query->get();
        }
        return view('livewire.operasi.kunjungan-pasien-operasi')
            ->title('Kunjungan Pasien');
    }
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
                    ->whereIn('kode_unit', ['1002'])
                    ->pluck('nama_unit', 'kode_unit');
                break;

            default:
                break;
        }
    }
}
