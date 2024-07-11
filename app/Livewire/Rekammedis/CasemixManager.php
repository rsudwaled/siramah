<?php

namespace App\Livewire\Rekammedis;

use App\Http\Controllers\VclaimController;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Livewire\Component;

class CasemixManager extends Component
{
    public $diagnosa = [], $diagnosas = [], $icd = [], $icd9s = [];
    public $sumber_data, $keluhan_utama, $riwayat_pengobatan, $riwayat_penyakit, $riwayat_alergi, $pernah_berobat, $denyut_jantung, $pernapasan, $sistole, $distole, $suhu, $berat_badan, $tinggi_badan, $bsa, $pemeriksaan_fisik_perawat, $pemeriksaan_fisik_dokter, $pemeriksaan_lab, $pemeriksaan_rad, $pemeriksaan_penunjang, $icd1, $icd2 = [], $icd9 = [], $diagnosa_dokter, $diagnosa_keperawatan, $rencana_medis, $rencana_keperawatan, $tindakan_medis, $instruksi_medis;

    public function updatedIcd2($inputicd2, $index)
    {
        $this->validate([
            "icd2.{$index}" => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'diagnosa' => $inputicd2,
            ]);
            $res = $api->ref_diagnosa($request);
            if ($res->metadata->code == 200) {
                $this->icd = [];
                foreach ($res->response->diagnosa as $key => $value) {
                    $this->icd[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function addIcd2()
    {
        $this->icd2[] = '';
    }
    public function removeIcd2($index)
    {
        unset($this->icd2[$index]);
        $this->icd2 = array_values($this->icd2);
    }
    public function updatedIcd1()
    {
        $this->validate([
            'icd1' => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'diagnosa' => $this->icd1,
            ]);
            $res = $api->ref_diagnosa($request);
            if ($res->metadata->code == 200) {
                $this->icd = [];
                foreach ($res->response->diagnosa as $key => $value) {
                    $this->icd[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function mount(Kunjungan $kunjungan)
    {
        // dd($kunjungan);
    }
    public function render()
    {
        return view('livewire.rekammedis.casemix-manager');
    }
}
