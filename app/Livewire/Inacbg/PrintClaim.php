<?php

namespace App\Livewire\Inacbg;

use App\Http\Controllers\InacbgController;
use App\Models\Bkip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PrintClaim extends Component
{
    public $tanggalawal, $tanggalakhir;
    public $kunjungans = [];
    public function cari()
    {
        $bkip = Bkip::where('tgl_masuk', $this->tanggalawal)->get();
        $this->kunjungans = $bkip;
    }
    public function print()
    {
       dd($this->kunjungans);
    }
    public function render()
    {
        // $api = new InacbgController();
        // $request = [
        //     "metadata" => [
        //         "method" => "claim_print",
        //     ],
        //     "data" => [
        //         "nomor_sep" =>  '1018R0010225V005407',
        //     ]
        // ];
        // $json_request = json_encode($request);
        // $res = $api->send_request($json_request);
        // $base64String = $res->data;
        // $pdfData = base64_decode($base64String);
        // $fileName = 'bkip-1018R0010225V005407.pdf';
        // $file = Storage::put("public/temp/$fileName", $pdfData);
        // $filePath = Storage::url("public/temp/$fileName");
        return view('livewire.inacbg.print-claim')->title('Print Klaim');
    }
}
