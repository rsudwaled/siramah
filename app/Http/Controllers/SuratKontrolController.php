<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratKontrolController extends Controller
{
    public function surat_kontrol_index(Request $request)
    {
        $suratkontrol = null;
        if ($request->tanggal && $request->formatFilter) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalMulai'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalAkhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $response =  $this->suratkontrol_tanggal($request);
            if ($response->status() == 200) {
                $suratkontrol = $response->getData()->response->list;
                Alert::success($response->getData()->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
            }
        }
        if ($request->nomorKartu) {
            $bulan = explode('-', $request->bulan);
            $request['tahun'] = $bulan[0];
            $request['bulan'] = $bulan[1];
            $response =  $this->suratkontrol_peserta($request);
            if ($response->status() == 200) {
                $suratkontrol = $response->getData()->response->list;
                Alert::success($response->getData()->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->status(), $response->getData()->metadata->message);
            }
        }
        return view('bpjs.vclaim.surat_kontrol_index', compact([
            'request', 'suratkontrol'
        ]));
    }
}
