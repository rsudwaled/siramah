<?php

namespace App\Livewire\Wa;

use App\Http\Controllers\WhatsappController;
use App\Models\PengaturanWhatsapp;
use App\Models\WhatsappLog;
use App\Models\WhatsappQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WhatsappIndex extends Component
{
    public $number, $message, $qr, $logs;
    public $pengaturan, $nama, $kode, $baseUrl;
    public $activeTab = 'tabs-kirim'; // Default tab
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function kirim(Request $request)
    {
        $api = new WhatsappController();
        $request['number'] = $this->number;
        $request['message'] = $this->message;
        $res = $api->send_message($request);
        if ($res->status) {
            return flash('Berhasil mengirim pesan', 'success');
        } else {
            dd($res);
            return flash('Gagal mengirim pesan', 'danger');
        }
    }
    public function mount()
    {
        $this->number = "089529909036";
        $this->message = "test";
        $this->pengaturan = PengaturanWhatsapp::first();
        if ($this->pengaturan) {
            $this->nama = $this->pengaturan->nama;
            $this->kode = $this->pengaturan->kode;
            $this->baseUrl = $this->pengaturan->baseUrl;
        }
    }
    public function save()
    {
        $user = Auth::user();
        $pengaturan = PengaturanWhatsapp::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanWhatsapp();
        }
        $pengaturan->nama = $this->nama;
        $pengaturan->kode = $this->kode;
        $pengaturan->baseUrl = $this->baseUrl;
        $pengaturan->save();
        Log::notice('User ' . $user->name . ' telah memperbaharui pengaturan whatsapp');
        flash('Pengaturan Vclaim updated successfully!', 'success');
    }
    public function render()
    {
        $this->qr = WhatsappQr::orderBy('created_at', 'desc')->limit(2)->get();
        $this->logs = WhatsappLog::orderBy('created_at', 'desc')->limit(10)->get();
        return view('livewire.wa.whatsapp-index')->title('Whatsapp');
    }
}
