<?php

namespace App\Livewire\Pendaftaran;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Livewire\Component;

class PendaftaranRajalProses extends Component
{
    public $kodebooking, $lantai, $loket;
    public $antrian;
    public function mount(Request $request)
    {
        $this->kodebooking = $request->kodebooking;
        $this->lantai = $request->lantai;
        $this->loket = $request->loket;
        $this->antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
    }
    public function render()
    {
        return view('livewire.pendaftaran.pendaftaran-rajal-proses')
            ->title('Pendaftaran Rawat Jalan');
    }
}
