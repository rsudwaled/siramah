<?php

namespace App\Livewire\Rekammedis;

use App\Http\Controllers\VclaimController;
use App\Models\BudgetControl;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Livewire\Component;

class CasemixManager extends Component
{
    public $diagnosa = [], $diagnosas = [], $icd = [], $icd9s = [];
    public $kunjungan, $icd1, $icd2 = [], $icd9 = [];
    public function simpan()
    {
        // dd($this->icd1, $this->icd2);
        $budget = BudgetControl::updateOrCreate(
            [
                'rm_counter' => $this->kunjungan->no_rm . '|' . $this->kunjungan->counter,
            ],
            [
                'tarif_inacbg' =>  '0',
                'no_rm' =>  $this->kunjungan->no_rm,
                'counter' => $this->kunjungan->counter,
                'diagnosa_kode' =>  $this->icd1, #kode
                'diagnosa_utama' => $this->icd1,
                'diagnosa' =>  $this->icd1,
                'prosedur' => $this->icd1, #kode | deskripsi
                'kode_cbg' =>  $this->icd1,
                'kelas' => $this->kunjungan->kelas,
                'tgl_grouper' => now(),
                'tgl_edit' => now(),
                'deskripsi' =>  $this->icd1,
                "pic" => 1,
            ]
        );
    }
    public function final()
    {
        $budget = BudgetControl::where('rm_counter', $this->kunjungan->no_rm . '|' . $this->kunjungan->counter)->first();
        $budget->update([
            'user' => auth()->user()->name,
            'final' => 1,
        ]);
    }
    public function belumFinal()
    {
        $budget = BudgetControl::where('rm_counter', $this->kunjungan->no_rm . '|' . $this->kunjungan->counter)->first();
        $budget->update([
            'user' => auth()->user()->name,
            'final' => 0,
        ]);
    }

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
        $this->kunjungan = $kunjungan;
    }
    public function render()
    {
        return view('livewire.rekammedis.casemix-manager');
    }
}
