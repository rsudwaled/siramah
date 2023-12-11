<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class WhatsappController extends Controller
{
    public $hari = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
    public function test(Request $request)
    {
        $request['message']  = "DAFTAR KONTROL_1018R0011222K001074#504#2022-12-06";
        $request['number'] = '6289529909036@c.us';
        $sk = $this->callback($request);
    }
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
        $pesan = strtoupper($request->message);
        switch ($pesan) {
            default:
                // $request['fileurl'] = asset('rsudwaled/daftar.jpg');
                // $request['caption'] = "Web SIRAMAH-RS Waled";
                // $this->send_image($request);
                $request['message'] = "Layanan pendaftaran rawat jalan RSUD Waled dapat melalui dua aplikasi beriku \n\n1. Web SIRAMAH-RS Waled : https://siramah.rsudwaled.id\n\n2. Aplikasi JKN : https://play.google.com/store/apps/details?id=app.bpjs.mobile";
                // return $this->send_message($request);
                // $this->send_message($request);
                // $sholawat = "اَللّٰهُمَّ صَلِّ عَلٰى سَيِّدِنَا مُحَمَّدٍ، طِبِّ الْقُلُوْبِ وَدَوَائِهَا، وَعَافِيَةِ الْاَبْدَانِ وَشِفَائِهَا، وَنُوْرِ الْاَبْصَارِ وَضِيَائِهَا، وَعَلٰى اٰلِهِ وَصَحْبِهِ وَسَلِّمْ";
                // $request['message'] = $sholawat;
                // $request['number'] = '6289529909036@c.us';
                return $this->send_message($request);
                break;
        }
    }
}
