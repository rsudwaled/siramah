<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class WhatsappController extends Controller
{
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
        // return $response;
    }
    public function send_message(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'number' => 'required',
        ]);
        $url = env('WHATASAPP_URL') . "send-message";
        $response = Http::post($url, [
            'number' => $request->number,
            'message' => $request->message,
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_message_group(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $url = env('WHATASAPP_URL') . "send-message-group";
        $response = Http::post($url, [
            'group' => $request->number,
            'message' => $request->message,
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_notif(Request $request)
    {
        $url = env('WHATASAPP_URL') . "notif";
        $response = Http::post($url, [
            'message' => $request->notif,
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_button(Request $request)
    {
        $url = env('WHATASAPP_URL') . "send-button";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, // 'UMUM,BPJS'
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_list(Request $request)
    {
        $url = env('WHATASAPP_URL') . "send-list";
        $response = Http::post($url, [
            'number' => $request->number,
            'contenttext' => $request->contenttext,
            'footertext' => $request->footertext,
            'titletext' => $request->titletext,
            'buttontext' => $request->buttontext, #wajib
            'titlesection' => $request->titlesection,
            'rowtitle' => $request->rowtitle, #wajib
            'rowdescription' => $request->rowdescription,
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_image(Request $request)
    {
        $url = env('WHATASAPP_URL') . "send-media";
        $response = Http::post($url, [
            'number' => $request->number,
            'fileurl' => $request->fileurl,
            'caption' => $request->caption,
            'username' => env('WHATASAPP_USERNAME'),
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_filepath(Request $request)
    {
        $url = env('WHATASAPP_URL') . "send-filepath";
        $response = Http::post($url, [
            'number' => $request->number,
            'filepath' => $request->filepath,
            'caption' => $request->caption,
            'username' => env('WHATASAPP_USERNAME'),
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
                    $request['message'] = "Layanan pendaftaran rawat jalan RSUD Waled dapat melalui dua aplikasi beriku \n\n1. Web SIRAMAH-RS Waled : https://siramah.rsudwaled.id\n\n2. Aplikasi JKN : https://play.google.com/store/apps/details?id=app.bpjs.mobile";
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
