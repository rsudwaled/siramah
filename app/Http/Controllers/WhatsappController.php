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
            'username' => 'rsudwaled',
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
            'username' => 'rsudwaled',
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function send_notif(Request $request)
    {
        $url = env('WHATASAPP_URL') . "notif";
        $response = Http::post($url, [
            'message' => $request->notif,
            'username' => 'rsudwaled',
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
            'username' => 'rsudwaled',
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
            'username' => 'rsudwaled',
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
            'username' => 'rsudwaled',
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
            'username' => 'rsudwaled',
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function webhook(Request $request)
    {
        $pesan = strtoupper($request->message);
        switch ($pesan) {
            case 'NOTIF':
                $request['notif'] = "Test Send Notif";
                return $this->send_notif($request);
                break;
            case 'MESSAGE':
                $request['message'] = "Test Send Message";
                return $this->send_message($request);
                break;
            case 'BUTTON':
                $request['contenttext'] = "contenttext";
                $request['footertext'] = 'footertext';
                $request['buttontext'] = 'buttontext1,buttontext2,buttontext3';
                return $this->send_button($request);
                break;
            case 'LIST':
                $request['contenttext'] = "contenttext";
                $request['titletext'] = "titletext";
                $request['buttontext'] = 'buttontext';
                $request['rowtitle'] = 'rowtitle1,rowtitle2,rowtitle3';
                $request['rowdescription'] = 'rowdescription1,rowdescription2,rowdescription3';
                return $this->send_list($request);
                break;
            default:
                if (substr($pesan, 13) ==  '#BPJS') {
                    $request['nomorKartu'] = explode('#', $pesan)[0];
                    $request['tanggal'] = now()->format('Y-m-d');
                    $vclaim = new VclaimController();
                    $response = $vclaim->peserta_nomorkartu($request);
                    if ($response->status() == 200) {
                        $peserta = $response->getData()->response->peserta;
                        $request['contenttext'] = "Nomor kartu berhasil ditemukan dengan data sebagai berikut : \n*Nama* : " . $peserta->nama . "\n*NIK* : " . $peserta->nik . "\n*No Kartu* : " . $peserta->noKartu . "\n*No RM* : " . $peserta->mr->noMR . "\n\n*Status* : " . $peserta->statusPeserta->keterangan . "\n*FKTP* : " . $peserta->provUmum->nmProvider . "\n*Jenis Peserta* : " . $peserta->jenisPeserta->keterangan . "\n*Hak Kelas* : " . $peserta->hakKelas->keterangan . "\n\nSilahkan pilih jenis kunjungan dibawah ini.";
                        $request['titletext'] = "3. Pilih Jenis Kunjungan";
                        $request['buttontext'] = 'PILIH JENIS KUNJUNGAN';
                        $request['rowtitle'] = "RUJUKAN FKTP,SURAT KONTROL,RUJUKAN ANTAR RS";
                        $request['rowdescription'] = "@FKTP#" . $request->nomorKartu . ",@KONTROL#" . $request->nomorKartu . ",@ANTARRS#" . $request->nomorKartu;
                        return $this->send_list($request);
                    } else {
                        $request['message'] = "*2. Ketik Format Pasien BPJS*\nMohon maaf " . $response->getData()->metadata->message;
                        return $this->send_message($request);
                    }
                } else if (str_contains($pesan, "@BATALANTRI#")) {
                    $request['kodebooking'] = explode("#", explode('@', $pesan)[1])[1];
                    $request['keterangan'] = "Dibatalkan melalui whatsapp";
                    $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
                    $api = new AntrianController();
                    $response = $api->batal_antrian($request);
                    if ($response->status() == 200) {
                        $request['message'] = "*Keterangan Batal Antrian*\nAntrian dengan kodebooking " . $request->kodebooking . " telah dibatalkan. Terima kasih.";
                        return $this->send_message($request);
                    } else {
                        $request['message'] = "*Keterangan Batal Antrian*\nMohon maaf " . $response->getData()->metadata->message;
                        return $this->send_message($request);
                    }
                }
                // INFO JADWAL POLI
                else if (str_contains($pesan, 'JADWAL_POLIKLINIK_')) {
                    $poli = explode('_', $pesan)[2];
                    $rowjadwaldokter = null;
                    $jadwaldokters = JadwalDokterAntrian::where('namasubspesialis', $poli)->orderBy('hari')->get();
                    foreach ($jadwaldokters as  $value) {
                        $rowjadwaldokter = $rowjadwaldokter . $this->hari[$value->hari] . '  : ' . $value->namadokter . ' ' . $value->jadwal . "\n";
                    }
                    $request['contenttext'] = "Jadwal dokter poliklinik " . $poli . " sebagai berikut : \n\n" . $rowjadwaldokter;
                    $request['titletext'] = "3. Pilih Jadwal Dokter " . $poli;
                    $request['buttontext'] = 'INFO JADWAL POLIKLINIK';
                    return $this->send_button($request);
                }
                // default
                else {
                    // $request['fileurl'] = asset('rsudwaled/daftar.jpg');
                    // $request['caption'] = "Web SIRAMAH-RS Waled";
                    // $this->send_image($request);
                    $request['message'] = "Layanan pendaftaran rawat jalan RSUD Waled dapat melalui dua aplikasi beriku \n\n1. Web SIRAMAH-RS Waled : https://siramah.rsudwaled.id\n\n2. Aplikasi JKN : https://play.google.com/store/apps/details?id=app.bpjs.mobile";
                    return $this->send_message($request);
                    break;
                }
        }
    }
}
