<?php

namespace App\Http\Controllers;

use App\Models\PengaturanWhatsapp;
use App\Models\WhatsappLog;
use App\Models\WhatsappQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    public $hari = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
    public function send_message(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'number' => 'required',
        ]);
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "send-message";
        $response = Http::post($url, [
            'number' => $request->number,
            'message' => $request->message,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_message_group(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'number' => 'required',
        ]);
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl .  "send-message-group";
        $response = Http::post($url, [
            'group' => $request->number,
            'message' => $request->message,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_notif(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "notif";
        $response = Http::post($url, [
            'message' => $request->notif,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_button(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "send-button";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, // 'UMUM,BPJS'
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_list(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "send-list";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, #wajib
            'titlesection' => $request->titlesection,
            'rowtitle' => $request->rowtitle, #wajib
            'rowdescription' => $request->rowdescription,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_image(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "send-media";
        $response = Http::post($url, [
            'number' => $request->number,
            'fileurl' => $request->fileurl,
            'caption' => $request->caption,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_filepath(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        $url = $pengaturan->baseUrl . "send-filepath";
        $response = Http::post($url, [
            'number' => $request->number,
            'filepath' => $request->filepath,
            'caption' => $request->caption,
            'username' => $pengaturan->kode,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function webhook(Request $request)
    {
        $pengaturan = PengaturanWhatsapp::first();
        if ($request->username == $pengaturan->kode) {
            if ($request->type == "qr") {
                WhatsappQr::create([
                    'qr' => $request->qr,
                    'username' => $request->username,
                ]);
                Log::info('QR Whatsapp : ' . $request->qr);
            }
            if ($request->type == "message") {
                Log::info('Whatsapp Message: ' . $request->message);
            }
            WhatsappLog::create([
                'status' => $request->status . ' : ' . $request->message,
                'type' => $request->type,
                'username' => $request->username,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'success ' . $request->status,
            ]);
        } else {
            WhatsappLog::create([
                'status' => 'Username Gagal ' . $request->username,
                'type' => 'message',
                'username' => $request->username,
            ]);
            Log::warning('Error Username Whatsapp : ' . $request->username);
            return response()->json([
                'status' => false,
                'message' => 'Username Gagal ' . $request->username,
            ]);
        }
    }
}
