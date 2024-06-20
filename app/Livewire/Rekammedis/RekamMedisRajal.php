<?php

namespace App\Livewire\Rekammedis;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\WhatsappController;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class RekamMedisRajal extends Component
{
    use WithPagination;
    public $tanggalperiksa;
    public $syncall = false;
    protected $listeners = ['antriansync',];
    public function syncantrian($kodebooking)
    {
        try {
            $antrian = Antrian::where('kodebooking', $kodebooking)->first();
            $api = new AntrianController();
            $request3 = new Request([
                "kodebooking" => $antrian->kodebooking,
                "taskid" =>  3,
                "waktu" => Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid4, 'Asia/Jakarta')->subSeconds(rand(3600, 7200)),
            ]);
            $res = $api->update_antrean($request3);
            $request4 = new Request([
                "kodebooking" => $antrian->kodebooking,
                "taskid" =>  4,
                "waktu" => Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid4, 'Asia/Jakarta'),
            ]);
            $res = $api->update_antrean($request4);
            $request = new Request([
                "kodebooking" => $antrian->kodebooking,
                "taskid" =>  5,
                "waktu" => Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid4, 'Asia/Jakarta')->addSeconds(rand(600, 900)),
            ]);
            $res = $api->update_antrean($request);
            $request = new Request([
                "kodebooking" => $antrian->kodebooking,
                "taskid" =>  6,
                "waktu" => Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid4, 'Asia/Jakarta')->addSeconds(rand(1200, 1800)),
            ]);
            $res = $api->update_antrean($request);
            $request = new Request([
                "kodebooking" => $antrian->kodebooking,
                "taskid" =>  7,
                "waktu" => Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid4, 'Asia/Jakarta')->addSeconds(rand(1400, 2600)),
            ]);
            $res = $api->update_antrean($request);
            if ($res->metadata->code == 200 || $res->metadata->code == 208) {
                $antrian->sync_antrian = 1;
                $antrian->user5 = auth()->user()->id;
                $antrian->save();
                flash($antrian->kodebooking . " " . $res->metadata->message, 'success');
                if ($this->syncall) {
                    $this->dispatch('antriansync');
                }
            } else {
                // $wa = new WhatsappController();
                // $request = new Request([
                //     "number" => '089529909036',
                //     "message" =>  $res->metadata->message,
                // ]);
                // $wa->send_message($request);
                $antrian->update([
                    "sync_antrian" => 2,
                ]);
                if ($this->syncall) {
                    $this->dispatch('antriansync');
                }
                flash($antrian->kodebooking . " " . $res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            flash($antrian->kodebooking . " " . $th->getMessage(), 'danger');
            if ($this->syncall) {
                $this->dispatch('antriansync');
            }
        }
    }
    public function onsyncall()
    {
        $this->syncall = $this->syncall ? false : true;
    }
    public function antriansync()
    {
        $antrian = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
            ->whereIn('taskid', [7, 5])
            ->where('sync_antrian',  null)
            ->where('method', '!=', 'Offline')
            ->where('taskid', '!=', 99)
            ->orderBy('taskid', 'desc')
            ->orWhere('sync_antrian', '<',  1)
            ->where('tanggalperiksa', $this->tanggalperiksa)
            ->whereIn('taskid', [7, 5])
            ->where('method', '!=', 'Offline')
            ->where('taskid', '!=', 99)
            ->orderBy('taskid', 'desc')
            ->first();
        if ($antrian) {
            $this->syncantrian($antrian->kodebooking);
        } else {
            $wa = new WhatsappController();
            $request = new Request([
                "number" => '089529909036',
                "message" =>  'Semua antrian sudah disyncronkan',
            ]);
            $wa->send_message($request);
            flash('Tidak ada antrian yang perlu disyncronkan', 'success');
        }
    }
    public function caritanggal()
    {
        $this->validate([
            'tanggalperiksa' => 'required|date',
        ]);
        $this->tanggalperiksa = $this->tanggalperiksa;
    }
    public function mount(Request $request)
    {
        $this->tanggalperiksa = $request->tanggalperiksa;
    }
    public function render()
    {
        $antrians = null;
        $antrians_total = null;
        $antrians_sync = null;
        if ($this->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->orderBy('taskid', 'desc')
                ->paginate();
            $antrians_total = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)->count();
            $antrians_sync = Antrian::where('tanggalperiksa', $this->tanggalperiksa)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->where('sync_antrian', 1)->count();
        }
        return view('livewire.rekammedis.rekam-medis-rajal', compact('antrians', 'antrians_total', 'antrians_sync'))->title('Rekam Medis Rajal');
    }
}
