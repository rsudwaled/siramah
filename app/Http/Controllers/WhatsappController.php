<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class WhatsappController extends Controller
{
    public $baseurl = "192.168.2.30:3000/";
    public $username = "rswld1";
    public $hari = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
    public function whatsapp(Request $request)
    {
        $request['number'] = "089529909036";
        if ($request->message) {
            $res = $this->send_message($request);
            if ($res->status == "true") {
                Alert::success('Success', 'Pesan testing terkirim');
            } else {
                Alert::error('Error', 'Pesan testing gagal terkirim');
            }
        }
        return view('admin.whatsapp', compact(['request']));
    }
    public function send_message(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'number' => 'required',
        ]);
        $url = $this->baseurl . "send-message";
        $response = Http::post($url, [
            'number' => $request->number,
            'message' => $request->message,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_message_group(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $url = $this->baseurl . "send-message-group";
        $response = Http::post($url, [
            'group' => $request->number,
            'message' => $request->message,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_notif(Request $request)
    {
        $url = $this->baseurl . "notif";
        $response = Http::post($url, [
            'message' => $request->notif,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_button(Request $request)
    {
        $url = $this->baseurl . "send-button";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, // 'UMUM,BPJS'
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_list(Request $request)
    {
        $url = $this->baseurl . "send-list";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, #wajib
            'titlesection' => $request->titlesection,
            'rowtitle' => $request->rowtitle, #wajib
            'rowdescription' => $request->rowdescription,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_image(Request $request)
    {
        $url = $this->baseurl . "send-media";
        $response = Http::post($url, [
            'number' => $request->number,
            'fileurl' => $request->fileurl,
            'caption' => $request->caption,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_filepath(Request $request)
    {
        $url = $this->baseurl . "send-filepath";
        $response = Http::post($url, [
            'number' => $request->number,
            'filepath' => $request->filepath,
            'caption' => $request->caption,
            'username' => $this->username,
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function webhook(Request $request)
    {
        if ($request->username == "rswld1") {
            $pesan = strtoupper($request->message);
            switch ($pesan) {
                default:
                    $request['message'] = "Mohon maaf untuk saat ini layanan pendaftaran antrian pasien BPJS hanya bisa melalui Aplikasi Mobile JKN : https://play.google.com/store/apps/details?id=app.bpjs.mobile";
                    // $request['message'] = "test wa api";
                    return $this->send_message($request);
                    break;
            }
        } else {
            $request['number'] = "089529909036";
            $this->send_message($request);
            return response()->json('hello siapa anda  ?', 404);
        }
    }
}
