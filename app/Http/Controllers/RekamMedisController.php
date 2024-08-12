<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RekamMedisController extends Controller
{
    //
    public function resumerajalprint(Request $request)
    {
        $kunjungan = Kunjungan::with(['unit', 'dokter', 'pasien', 'penjamin_simrs'])
            ->where('kode_kunjungan', $request->kode)
            ->first();
        $asesmendokter = $kunjungan->assesmen_dokter;
        $grouping = $kunjungan->budget;

        if ($asesmendokter->tgl_entry) {
            $qrttddokter = QrCode::format('png')->size(150)->generate('E-Sign ' . $asesmendokter->nama_dokter . ' waktu ' . $asesmendokter->tgl_entry);
        } else {
            $qrttddokter = QrCode::format('png')->size(150)->generate($asesmendokter->nama_dokter . ' belum melakukan E-Sign pada resume rawat jalan ini');
        }
        $ttddokter = "data:image/png;base64," . base64_encode($qrttddokter);

        // return view('livewire.print.pdf_resume_rajal', compact('kunjungan','asesmendokter','grouping','ttddokter'));
        $pdf = Pdf::loadView('livewire.print.pdf_resume_rajal', compact('kunjungan', 'asesmendokter', 'grouping', 'ttddokter'));
        return $pdf->stream('resumerajal.pdf');
    }
    public function seprajalprint(Request $request)
    {
        $api = new VclaimController();
        $request['noSep'] = $request->kode;
        $res  = $api->sep_nomor($request);
        if ($res->metadata->code == 200) {
            $sep = $res->response;
            $qr = QrCode::format('png')->size(150)->generate($sep->peserta->noKartu);
            $qrpasien = "data:image/png;base64," . base64_encode($qr);
            // return view('livewire.print.pdf_sep', compact('sep'));
            $pdf = Pdf::loadView('livewire.print.pdf_sep', compact('sep', 'qrpasien'));
            return $pdf->stream('sep.pdf');
        } else {
        }
    }
}
