<?php

namespace App\Http\Controllers\Casemix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SepVerifDownloader;
use PDF;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SepDownloaderController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->input('tahun');
        $bulan  = $request->input('bulan');
        $sep    = SepVerifDownloader::whereYear('tgl_keluar', $tahun)
                ->whereMonth('tgl_keluar', $bulan)
                ->get();
        return view('simrs.sep_downloader.index', compact('request','sep'));
    }

    public function downloadAll(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        // Ambil data berdasarkan tahun dan bulan
        $sepVerify = SepVerifDownloader::whereYear('tgl_keluar', $tahun)
            ->whereMonth('tgl_keluar', $bulan)
            ->take(10)
            ->get();

        // Loop untuk setiap SEP dan siapkan file PDF untuk diunduh
        foreach ($sepVerify as $sep) {
            $sep = SepVerifDownloader::where('idx', $sep->idx)->first();
            if (!$sep) {
                return response()->json(['message' => 'Data not found.'], 404);
            }
            $qrCode = QrCode::size(300)->generate($sep->sepnoKartu);
            $pdf = PDF::loadView('simrs.igd.cetakan_igd.sep_downloader', compact('sep', 'qrCode'));
            $sep->is_download = 1;
            $sep->save();

            return $pdf->download($sep->no_sep.'-'. $sep->idx . '.pdf');
        }
        return back();
    }

    public function downloadSingle(Request $request)
    {
        $sep = SepVerifDownloader::where('idx', '436348')->first(); // RJ
        if (!$sep) {
            return response()->json(['message' => 'Data not found.'], 404);
        }
        $qrCode = QrCode::size(300)->generate($sep->sepnoKartu);
        $pdf = PDF::loadView('simrs.igd.cetakan_igd.sep_downloader', compact('sep', 'qrCode'));
        $sep->is_download = 1;
        $sep->save();

        return $pdf->download($sep->no_sep.'-'. $sep->idx . '.pdf');
    }

    public function download(Request $request, $id)
    {
        $sep = SepVerifDownloader::where('idx', $id)->first(); // RJ
        if (!$sep) {
            return response()->json(['message' => 'Data not found.'], 404);
        }
        $qrCode = QrCode::size(300)->generate($sep->sepnoKartu);
        $pdf = PDF::loadView('simrs.igd.cetakan_igd.sep_downloader', compact('sep', 'qrCode'));
        $sep->is_download = 1;
        $sep->save();

        return $pdf->download($sep->no_sep.'-'. $sep->idx . '.pdf');
    }
}
