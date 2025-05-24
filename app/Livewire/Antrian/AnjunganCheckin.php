<?php

namespace App\Livewire\Antrian;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Penjamin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AnjunganCheckin extends Component
{
    public $kodebooking;
    public $antrian;


    public function checkinCetakSEP(Request $request)
    {
        $api = new AntrianController();
        $request['kodebooking'] = $this->kodebooking;
        $request['waktu'] = Carbon::parse(DB::connection('mysql2')->select('select sysdate() as time')[0]->time);
        $res = $api->checkin_antrian($request);
        if ($res->metadata->code == 200) {
            dd($res);
        } else {
            return flash("Mohon maaf, " . $res->metadata->message, 'danger');
        }
    }
    public function mount(Request $request)
    {
        if (!empty($request->kodebooking)) {
            $this->kodebooking = $request->kodebooking;
            $this->antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
            if (!$this->antrian) {
                return flash("Mohon maaf, kodebooking antrian tidak ditemukan", 'danger');
            }
        }
    }
    public function render()
    {
        return view('livewire.antrian.anjungan-checkin')
            ->layout('components.layouts.blank_adminlte');
    }
}
