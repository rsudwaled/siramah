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
    public $nama, $nohp, $nomorkartu;
    public $kunjungan;
    public $formHp = false;

    public function simpanNohp()
    {
        $this->validate([
            'nohp' => 'required|numeric|digits_between:8,15',
        ]);
        $this->antrian->nohp = $this->nohp;
        $this->antrian->save();
        $this->formHp = false;
        return flash("Data berhasil diperbaharui", 'success');
    }
    public function openFormHp()
    {
        $this->formHp = $this->formHp ? false : true;
    }
    public function checkinCetakSEP(Request $request)
    {
        $api = new AntrianController();
        $request['kodebooking'] = $this->kodebooking;
        $request['waktu'] = Carbon::parse(DB::connection('mysql2')->select('select sysdate() as time')[0]->time);
        $this->antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
        $this->getdata();
        $res = $api->checkin_antrian($request);
        if ($res->metadata->code == 200) {
            return flash("Berhasil cetak SEP dan Karcis Antrian", 'success');
        } else {
            if ($res->metadata->message == "Gagal Buat SEP : No.Telepon Diisi Dengan Benar (min 8 digit).") {
                $this->getdata();
                $this->formHp = true;
            }
            return flash("Mohon maaf, " . $res->metadata->message, 'danger');
        }
    }
    public function mount(Request $request)
    {
        if (!empty($request->kodebooking)) {
            $this->kodebooking = $request->kodebooking;
            $this->antrian = Antrian::where('kodebooking', $this->kodebooking)
                ->orWhere('nomorkartu', $this->kodebooking)
                ->where('tanggalperiksa',  Carbon::now()->format('Y-m-d'))
                ->orderBy('tanggalperiksa', 'desc')->first();
            if ($this->antrian) {
                $this->getdata();
            } else {
                return flash("Mohon maaf, kodebooking antrian tidak ditemukan", 'danger');
            }
        }
    }
    public function getdata()
    {
        $this->kodebooking = $this->antrian->kodebooking;
        $this->kunjungan = $this->antrian->kunjungan;
        $this->nama = $this->antrian->nama;
        $this->nohp = $this->antrian->nohp;
        $this->nomorkartu = $this->antrian->nomorkartu;
    }
    public function render()
    {
        return view('livewire.antrian.anjungan-checkin')
            ->layout('components.layouts.blank_adminlte');
    }
}
