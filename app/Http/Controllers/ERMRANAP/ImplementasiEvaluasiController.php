<?php

namespace App\Http\Controllers\ERMRANAP;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\ErmRanapKeperawatan;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImplementasiEvaluasiController extends Controller
{
    // implementasi
    public function get_keperawatan_ranap(Request $request)
    {
        $observasi = ErmRanapKeperawatan::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function simpan_keperawatan_ranap(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $keperawatan = ErmRanapKeperawatan::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        return $this->sendResponse($keperawatan);
    }
    public function hapus_keperawatan_ranap(Request $request)
    {
        $keperawatan = ErmRanapKeperawatan::find($request->id);
        if ($keperawatan->user_id == Auth::user()->id) {
            $keperawatan->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
    public function print_implementasi_evaluasi_keperawatan(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_keperawatan;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_keperawatan', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
}
