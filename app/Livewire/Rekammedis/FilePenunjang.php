<?php

namespace App\Livewire\Rekammedis;

use App\Models\FileRekamMedis;
use App\Models\FileUpload;
use App\Models\Kunjungan;
use Livewire\Component;

class FilePenunjang extends Component
{
    public $kunjungan, $pasien, $file, $fileagil;
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->pasien = $kunjungan->pasien;
    }
    public function render()
    {
        $this->file = FileRekamMedis::where('norm', $this->pasien->no_rm)
            ->get();
        $this->fileagil = FileUpload::where('no_rm', $this->pasien->no_rm)
            ->get();
        return view('livewire.rekammedis.file-penunjang');
    }
}
