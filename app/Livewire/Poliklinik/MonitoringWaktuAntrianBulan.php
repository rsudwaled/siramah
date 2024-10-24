<?php

namespace App\Livewire\Poliklinik;

use App\Exports\MonitoringWaktuAntrianExport;
use App\Http\Controllers\AntrianController;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringWaktuAntrianBulan extends Component
{
    public $antrians;
    public $sync = false;
    public $tanggalperiksa, $kodepoli;
    protected $listeners = ['antriansync'];

    public function render()
    {
        if ($this->tanggalperiksa) {
            $this->antrians = Antrian::where('tanggalperiksa', 'LIKE', "%" . $this->tanggalperiksa . "%")
                // ->where('kodepoli', $this->kodepoli)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->where('taskid',  7)
                ->orderBy('tanggalperiksa', 'asc')
                ->with(['kunjungan', 'kunjungan.assesmen_perawat', 'kunjungan.order_obat_header'])
                // ->join('ts_kunjungan', 'jkn_antrian.kode_kunjungan', '=', 'ts_kunjungan.kode_kunjungan')
                // ->orderBy('ts_kunjungan.tgl_masuk', 'desc')
                // ->select('jkn_antrian.*') // Agar hanya data antrian yang diambil
                ->get();
        }
        if ($this->sync) {
            $antrian = $this->antrians
                ->where('sync_antrian', 0)
                ->first();
            if ($antrian) {
                $this->resync($antrian->kodebooking);
            } else {
                $this->tanggalperiksa = Carbon::parse($this->tanggalperiksa)->addDays(1)->format('Y-m-d');
            }
        }
        return view('livewire.poliklinik.monitoring-waktu-antrian-bulan');
    }
    public function mount(Request $request)
    {
        $this->tanggalperiksa = $request->tanggalperiksa ?? now()->format('Y-m');
    }
    public function onsync()
    {
        $this->sync = $this->sync ? false : true;
    }
    public function resync($kodebooking)
    {
        try {
            $request = new Request();
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
                $this->dispatch('bell-play');
            } else {
                $antrianx->update([
                    'sync_antrian' => 99,
                ]);
                flash($res->metadata->message, 'danger');
                $this->dispatch('error-sound');
            }
        } catch (\Throwable $th) {
            flash($th->getMessage(), 'danger');
            $this->dispatch('error-sound');
        }
    }
    // public function antriansync()
    // {
    //     try {
    //         $antrian = Antrian::whereDate('tanggalperiksa', $this->tanggalperiksa)
    //             // ->where('kodepoli', $this->kodepoli)
    //             ->whereNotNull('sync_antrian')
    //             ->where('method', '!=', 'Offline')
    //             ->where('taskid', '!=', 99)
    //             ->first();
    //         if ($antrian) {
    //             $this->resync($antrian->kodebooking);
    //             flash('Oke', 'success');
    //         } else {
    //             flash('Tidak ada antrian yang perlu disyncronkan', 'success');
    //         }
    //     } catch (\Throwable $th) {
    //         flash($th->getMessage(), 'success');
    //     }
    // }
    public function export()
    {
        try {
            return Excel::download(new MonitoringWaktuAntrianExport($this->tanggalperiksa), 'waktuantrian-' . $this->tanggalperiksa . '.xlsx');
            flash('Export Obat successfully', 'success');
        } catch (\Throwable $th) {
            flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }

    public function bell()
    {
        $this->dispatch('bell-play');
    }
}
