<?php

namespace App\Livewire\Antrian;

use App\Http\Controllers\PendaftaranController;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Livewire\Component;

class AnjunganMandiriPendaftaran extends Component
{
    public $jadwals = [], $jadwaldokters;
    public $jenispasien, $namasubspesialis;
    protected $queryString = ['jenispasien'];
    public function pilihPoli($key)
    {
        $this->namasubspesialis = $key;
        $this->jadwaldokters = JadwalDokter::where('hari', now()->dayOfWeek)->where('namasubspesialis', $key)->get();
    }
    public function pilihDokter($id, Request $request)
    {
        $jadwal = JadwalDokter::find($id);
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $jadwal->kodesubspesialis;
        $request['kodedokter'] = $jadwal->kodedokter;
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = $this->jenispasien;
        $request['method'] = 'Offline';
        // ambil antrian offline
        $api = new PendaftaranController();
        $res = $api->ambil_antrian_offline($request);
        if ($res->metadata->code == 200) {
            $url = route('anjungan.cetak.karcis.umum') . "?kodebooking=" . $res->response->kodebooking;
            return redirect()->to($url);
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        if (count($this->jadwals) == 0) {
            $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->get();
        }
        return view('livewire.antrian.anjungan-mandiri-pendaftaran')
            ->layout('components.layouts.blank_adminlte');
    }
}
