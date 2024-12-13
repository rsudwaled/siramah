<?php

namespace App\Http\Controllers\ERMRANAP\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\ErmRanapImplementasiEvaluasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ImplementasiEvaluasiController extends Controller
{
    public function storeImplementasiEvaluasi(Request $request)
    {
       
        $tanggal        = $request->input('tanggal_implementasi_evaluasi');
        $waktu          = $request->input('waktu_implementasi_evaluasi');
        $keterangan     = $request->input('keterangan_implementasi');
        
        $kunjungan      = Kunjungan::with(['unit','pasien'])->where('kode_kunjungan', $request->kode)->first();
        $pic_perawat    = Auth::user()->id;
        $user_perawat   = Auth::user()->name;
        for ($i = 0; $i < count($tanggal); $i++) {
            ErmRanapImplementasiEvaluasi::updateOrCreate(
                [
                    'id' => $ids[$i] ?? null // Kondisi pencarian
                ],
                [
                    'kode'                          => $kunjungan->kode_kunjungan,
                    'rm'                            => $kunjungan->no_rm,
                    'tanggal_implementasi_evaluasi' => $tanggal[$i],
                    'waktu_implementasi_evaluasi'   => $waktu[$i],
                    'keterangan_implementasi'       => $keterangan[$i],
                    'pic_perawat'                   => $pic_perawat,
                    'user_perawat'                  => $user_perawat,
                    'input_date'                    => now(),
                ]
            );
        }
        Alert::success('Success', 'Data Implementasi dan Evaluasi berhasil disimpan!');
        return redirect()->back();
    }

    public function updateImplementasiEvaluasi(Request $request, $id)
    {
        $editImplementasi =ErmRanapImplementasiEvaluasi::find($id);
        if(!$editImplementasi)
        {
            return response()->json(['success' => false]);
        }
        $editImplementasi->tanggal_implementasi_evaluasi = $request->tanggal_implementasi_evaluasi;
        $editImplementasi->waktu_implementasi_evaluasi   = $request->waktu_implementasi_evaluasi;
        $editImplementasi->keterangan_implementasi       = $request->keterangan_implementasi;
        $editImplementasi->save();

        return response()->json(['success' => true]);
    }

    public function printImplementasiEvaluasi(Request $request)
    {
        $kunjungan          = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien             = $kunjungan->pasien;
        $implementasi       = ErmRanapImplementasiEvaluasi::where('kode', $request->kode)->get();
        $pdf = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_implementasi_evaluasi_keperawatan', compact(
            'kunjungan', 'pasien','implementasi',
        ));
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_implementasi_evaluasi_keperawatan');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pdf_implemetasi_evaluasi_keperawatan.pdf');
    }

    public function showDataImplementasiEvaluasi(Request $request)
    {
        $verifikasi = ErmRanapImplementasiEvaluasi::where('kode', $request->kode)
        ->whereDate('tanggal_implementasi_evaluasi', $request->tgl_verifikasi)
        ->get();

        if ($verifikasi->isNotEmpty()) {
            return response()->json(['data_found' => true, 'data' => $verifikasi]);
        } else {
            return response()->json(['data_found' => false]);
        }
    }
    public function verifikasiImplementasiEvaluasi(Request $request)
    {
        $verifikasi = ErmRanapImplementasiEvaluasi::find($request->id);
        if ($verifikasi) {
            $verifikasi->verifikasi =1;
            $verifikasi->waktu_verifikasi =now();
            $verifikasi->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
