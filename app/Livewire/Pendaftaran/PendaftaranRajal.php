<?php

namespace App\Livewire\Pendaftaran;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Livewire\Component;

class PendaftaranRajal extends Component
{
    public $antrians = [];
    public $tanggalperiksa, $lantai, $loket, $jenispasien;
    public $search = '';

    public function mount(Request $request)
    {

        $this->tanggalperiksa = $request->tanggalperiksa;
        $this->lantai = $request->lantai;
        $this->loket = $request->loket;
        $this->search = $request->search;
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        if ($this->tanggalperiksa) {
            $this->antrians = Antrian::whereDate('tanggalperiksa', $this->tanggalperiksa)
                ->where('method', 'Offline')
                ->where('jenispasien', 'LIKE', '%' . $this->jenispasien . '%')
                ->where('lantaipendaftaran',  'LIKE', '%' . $this->lantai . '%')
                ->get();
        }
        return view('livewire.pendaftaran.pendaftaran-rajal')
            ->title('Pendaftaran Rawat Jalan');
    }
}
