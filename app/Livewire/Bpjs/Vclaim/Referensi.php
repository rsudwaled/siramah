<?php

namespace App\Livewire\Bpjs\Vclaim;

use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Livewire\Component;

class Referensi extends Component
{
    public $diagnosa, $procedure, $poliklinik, $jenisfaskes, $faskes, $dokter, $tanggal, $jenispelayanan, $provinsi, $kabupaten, $kecamatan;
    public $diagnosas = [], $procedures = [], $polikliniks = [], $faskess = [], $dokters = [], $provinsis = [], $kabupatens = [], $kecamatans = [];
    public function updateKecamatan()
    {
        $this->validate([
            'kabupaten' => 'required',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'kodekabupaten' => $this->kabupaten,
            ]);
            $res = $api->ref_kecamatan($request);
            if ($res->metadata->code == 200) {
                $this->kecamatans = [];
                foreach ($res->response->list as $key => $value) {
                    $this->kecamatans[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updateKabupaten()
    {
        $this->validate([
            'provinsi' => 'required',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'kodeprovinsi' => $this->provinsi,
            ]);
            $res = $api->ref_kabupaten($request);
            if ($res->metadata->code == 200) {
                $this->kabupatens = [];
                foreach ($res->response->list as $key => $value) {
                    $this->kabupatens[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updateProvinsi()
    {
        try {
            $api = new VclaimController();
            $request = new Request([
                'provinsi' => $this->provinsi,
            ]);
            $res = $api->ref_provinsi($request);
            if ($res->metadata->code == 200) {
                $this->provinsis = [];
                foreach ($res->response->list as $key => $value) {
                    $this->provinsis[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updatedDokter()
    {
        $this->validate([
            'dokter' => 'required|min:3',
            'poliklinik' => 'required|min:3',
            'jenispelayanan' => 'required',
            'tanggal' => 'required',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'kodespesialis' => $this->poliklinik,
                'jenispelayanan' => $this->jenispelayanan,
                'tanggal' => $this->tanggal,
            ]);
            $res = $api->ref_dpjp($request);
            if ($res->metadata->code == 200) {
                $this->dokters = [];
                foreach ($res->response->list as $key => $value) {
                    $this->dokters[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updatedFaskes()
    {
        $this->validate([
            'faskes' => 'required|min:3',
            'jenisfaskes' => 'required',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'nama' => $this->faskes,
                'jenisfaskes' => $this->jenisfaskes,
            ]);
            $res = $api->ref_faskes($request);
            if ($res->metadata->code == 200) {
                $this->faskess = [];
                foreach ($res->response->faskes as $key => $value) {
                    $this->faskess[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updatedProcedure()
    {
        $this->validate([
            'procedure' => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'procedure' => $this->procedure,
            ]);
            $res = $api->ref_procedure($request);
            if ($res->metadata->code == 200) {
                $this->procedures = [];
                foreach ($res->response->procedure as $value) {
                    $this->procedures[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updatedDiagnosa()
    {
        $this->validate([
            'diagnosa' => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'diagnosa' => $this->diagnosa,
            ]);
            $res = $api->ref_diagnosa($request);
            if ($res->metadata->code == 200) {
                $this->diagnosas = [];
                foreach ($res->response->diagnosa as $key => $value) {
                    $this->diagnosas[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function updatedPoliklinik()
    {
        $this->validate([
            'poliklinik' => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'poliklinik' => $this->poliklinik,
            ]);
            $res = $api->ref_poliklinik($request);
            if ($res->metadata->code == 200) {
                $this->polikliniks = [];
                foreach ($res->response->poli as $key => $value) {
                    $this->polikliniks[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
                return flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function render()
    {
        return view('livewire.bpjs.vclaim.referensi');
    }
}
