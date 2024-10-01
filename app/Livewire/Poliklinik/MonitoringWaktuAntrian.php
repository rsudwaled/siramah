<?php

namespace App\Livewire\Poliklinik;

use App\Http\Controllers\AntrianController;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class MonitoringWaktuAntrian extends Component
{
    public $antrians;
    public $sync = 0;
    public $tanggalperiksa, $kodepoli;
    protected $listeners = ['antriansync'];
    public function onsync()
    {
        $this->sync = $this->sync ? 0 : 1;
    }
    public function cari()
    {
        if ($this->tanggalperiksa) {
            $this->antrians = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
                // ->where('kodepoli', $this->kodepoli)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->with(['kunjungan', 'kunjungan.assesmen_perawat'])
                ->join('ts_kunjungan', 'jkn_antrian.kode_kunjungan', '=', 'ts_kunjungan.kode_kunjungan')
                ->orderBy('ts_kunjungan.tgl_masuk', 'desc')
                ->select('jkn_antrian.*') // Agar hanya data antrian yang diambil
                ->get();
        }
    }
    public function resync($kodebooking, Request $request)
    {
        $antrianx = Antrian::firstWhere('kodebooking', $kodebooking);
        $request['kodebooking'] = $kodebooking;
        $api =  new AntrianController();
        $res = $api->taskid_antrean($request);
        if ($res->metadata->code == 200) {
            foreach ($res->response as  $antrian) {
                if ($antrian->taskid == 3) {
                    $waktu = Carbon::parse($antrian->wakturs)->format('Y-m-d H:i:s');
                    $antrianx->update([
                        'taskid3' => $waktu,
                    ]);
                }
                if ($antrian->taskid == 4) {
                    $waktu = Carbon::parse($antrian->wakturs)->format('Y-m-d H:i:s');
                    $antrianx->update([
                        'taskid4' => $waktu,
                    ]);
                }
                if ($antrian->taskid == 5) {
                    $waktu = Carbon::parse($antrian->wakturs)->format('Y-m-d H:i:s');
                    $antrianx->update([
                        'taskid5' => $waktu,
                    ]);
                }
                if ($antrian->taskid == 6) {
                    $waktu = Carbon::parse($antrian->wakturs)->format('Y-m-d H:i:s');
                    $antrianx->update([
                        'taskid6' => $waktu,
                    ]);
                }
                if ($antrian->taskid == 7) {
                    $waktu = Carbon::parse($antrian->wakturs)->format('Y-m-d H:i:s');
                    $antrianx->update([
                        'taskid7' => $waktu,
                    ]);
                }
            }
            flash('Berhasil', 'success');
            $antrianx->update([
                'sync_antrian' => 1,
            ]);
        } else {
            $antrianx->update([
                'sync_antrian' => 99,
            ]);
            flash($res->metadata->message, 'danger');
        }
        if ($this->sync) {
            $this->dispatch('antriansync');
        }
    }
    public function antriansync()
    {
        $request = new Request();
        $antrian = Antrian::whereDate('tanggalperiksa', $this->tanggalperiksa)
            // ->where('kodepoli', $this->kodepoli)
            ->whereNotNull('sync_antrian')
            ->where('method', '!=', 'Offline')
            ->where('taskid', '!=', 99)
            ->first();
        if ($antrian) {
            $this->resync($antrian->kodebooking, $request);
        } else {
            flash('Tidak ada antrian yang perlu disyncronkan', 'success');
        }
    }
    public function mount(Request $request)
    {
        $this->tanggalperiksa = $request->tanggalperiksa ?? now()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.poliklinik.monitoring-waktu-antrian')->title('Monitoring Waktu Antrian');
    }
}
