<?php

namespace App\Livewire\Operasi;

use App\Models\JadwalOperasi;
use App\Models\Paramedis;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ModalJadwalOperasi extends Component
{
    public $no_book, $kode_kunjungan, $nama_pasien, $nomor_rm, $nomor_bpjs;
    public $nama_dokter, $nama_poli_bpjs, $kd_poli_bpjs;
    public $tanggal, $ruangan, $diagnosa, $jenis, $terlaksana = 0, $end, $keterangan;
    public function render()
    {
        return view('livewire.operasi.modal-jadwal-operasi');
    }
    public function mount($kunjungan)
    {
        $pasien = $kunjungan->pasien;
        $this->kode_kunjungan = $kunjungan->kode_kunjungan;
        $this->nama_pasien = $pasien->nama_px;
        $this->nomor_rm = $pasien->no_rm;
        $this->nomor_bpjs = $pasien->no_Bpjs;
        $this->nama_dokter = $kunjungan->dokter?->nama_paramedis;
        $this->nama_poli_bpjs = $kunjungan->unit?->nama_unit;
        $this->kd_poli_bpjs = $kunjungan->unit?->kode_unit;

        $jadwal = $kunjungan->jadwal_operasi;
        if ($jadwal) {
            $this->no_book = $jadwal->no_book;
            $this->tanggal = $jadwal->tanggal;
            $this->ruangan = $jadwal->ruangan;
            $this->diagnosa = $jadwal->diagnosa;
            $this->jenis = $jadwal->jenis;
            $this->terlaksana = $jadwal->status;
            $this->end = $jadwal->end;
            $this->keterangan = $jadwal->keterangan;
        }
    }
    public function simpan()
    {
        $this->validate([
            'tanggal' => 'required',
            'kode_kunjungan' => 'required',
            'nama_pasien' => 'required',
            'nomor_rm' => 'required',
            'nama_dokter' => 'required',
            'nama_poli_bpjs' => 'required',
            'kd_poli_bpjs' => 'required',
            'tanggal' => 'required',
            'ruangan' => 'required',
            'jenis' => 'required',
            'terlaksana' => 'required',
        ]);
        $unit = Unit::firstWhere('kode_unit', $this->kd_poli_bpjs);
        if (!$this->no_book) {
            $this->no_book = strtoupper(uniqid());
        }
        $jadwal =  JadwalOperasi::updateOrCreate([
            'no_book' => $this->no_book
        ], [
            'nomor_rm' => $this->nomor_rm,
            'nama_pasien' => $this->nama_pasien,
            'nama_dokter' => $this->nama_dokter,
            'ruangan' => $this->ruangan,
            'tanggal' => $this->tanggal ? Carbon::parse($this->tanggal) : null,
            'end' => $this->end ?  Carbon::parse($this->end) : null,
            'jenis' => $this->jenis,
            'ruangan_asal' => $unit->nama_unit,
            'diagnosa' => $this->diagnosa,
            'status' => $this->terlaksana,
            'keterangan' => $this->keterangan,
            'kd_poli_bpjs' => $unit->KDPOLI ?? "BED",
            'nama_poli_bpjs' => $unit->nama_unit,
            'nomor_bpjs' => $this->nomor_bpjs,
            'kode_kunjungan' => $this->kode_kunjungan,
        ]);
        Alert::success('Success', 'Berhasil simpan jadwal operasi');
        $url = route('erm.oprasi') . "?kode_kunjungan=" . $this->kode_kunjungan;
        return redirect()->to($url);
    }
}
