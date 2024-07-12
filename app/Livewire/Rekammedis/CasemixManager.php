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
        $budget = BudgetControl::updateOrCreate(
            [
                'rm_counter' => $this->kunjungan->no_rm . '|' . $this->kunjungan->counter,
            ],
            [
                'tarif_inacbg' =>  '0',
                'no_rm' =>  $this->kunjungan->no_rm,
                'counter' => $this->kunjungan->counter,
                'diagnosa_utama' => $this->icd1,
                'diagnosa_kode' =>  $this->icd1,
                'diagnosa' =>  implode(';', $this->icd2),
                'prosedur' => $this->icd1, #kode | deskripsi
                'kode_cbg' =>  $this->icd1,
                'kelas' => $this->kunjungan->kelas,
                'tgl_grouper' => now(),
                'tgl_edit' => now(),
                'deskripsi' =>  $this->icd1,
                "pic" => auth()->user()->id,
                "user" => auth()->user()->name,
            ]
        );
        flash('Data berhasil disimpan oleh ' . auth()->user()->name, 'success');
        $this->dispatch('refreshPage');
    }
    public function final()
    {
        $budget = BudgetControl::where('rm_counter', $this->kunjungan->no_rm . '|' . $this->kunjungan->counter)->first();
        $budget->update([
            'user' => auth()->user()->name,
            'final' => 1,
        ]);
        flash('Data sudah final disimpan oleh ' . auth()->user()->name, 'success');
        $this->dispatch('refreshPage');
    }
    public function belumFinal()
    {
        $budget = BudgetControl::where('rm_counter', $this->kunjungan->no_rm . '|' . $this->kunjungan->counter)->first();
        $budget->update([
            'user' => auth()->user()->name,
            'final' => 0,
        ]);
        flash('Data belum final disimpan oleh ' . auth()->user()->name, 'success');
        $this->dispatch('refreshPage');
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
        $this->icd1 = $kunjungan->budget?->diagnosa_utama;
        $this->icd2 = explode(';',  $kunjungan->budget?->diagnosa);
    }
    public function render()
    {
        return view('livewire.rekammedis.casemix-manager');
    }
}
