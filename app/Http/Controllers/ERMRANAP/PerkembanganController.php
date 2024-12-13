<?php

namespace App\Http\Controllers\ERMRANAP;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\ErmRanapPerkembangan;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkembanganController extends Controller
{
    // soap
    public function simpan_perkembangan_ranap(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tanggal_input'     => 'required|date',
            'perkembangan'      => 'required',
            'instruksi_medis'   => 'required',
        ], [
            'tanggal_input.required'     => 'Kolom inputan tanggal wajib diisi.',
            'tanggal_input.date'         => 'Kolom inputan tanggal harus berupa tanggal yang valid.',
            'perkembangan.required'      => 'Kolom inputan SOAP hasil pemeriksaan wajib diisi.',
            'instruksi_medis.required'   => 'Kolom inputan instruksi medis wajib diisi.',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'metadata' => [
                    'code' => 422,
                    'message' => 'Upps... ada inputan yang belum diisi!',
                ],
                'errors' => $validator->errors(), // Kirimkan detail kesalahan
            ], 422);
        }
    
        try {
            $data = ErmRanapPerkembangan::updateOrCreate(
                [
                    'tanggal_input'     => $request->tanggal_input,
                    'kode_kunjungan'    => $request->kode_kunjungan,
                    'counter'           => $request->counter,
                    'norm'              => $request->norm,
                ],
                [
                    'norm'              => $request->norm,
                    'perkembangan'      => $request->perkembangan,
                    'instruksi_medis'   => $request->instruksi_medis,
                    'instruksi_medis'   => $request->instruksi_medis,
                    'user_id'           => Auth::user()->id,
                    'pic'               => Auth::user()->name,
                ],
                $request->all()
            );
            return response()->json([
                'metadata' => [
                    'code' => 200,
                    'message' => 'Data berhasil disimpan',
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in simpan_perkembangan_ranap: ' . $e->getMessage());
            return response()->json([
                'metadata' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                ],
            ], 500);
        }
    }
    public function get_perkembangan_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function hapus_perkembangan_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi->user_id == Auth::user()->id) {
            $observasi->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
    public function verifikasi_soap_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi) {
            # code...
            $observasi->update([
                'verifikasi_at' => now(),
                'verifikasi_by' => Auth::user()->name,
            ]);
            return $this->sendResponse('Berhasil diverifikasi');
        } else {
            return $this->sendError('Catatan tidak ditemukan');
        }
    }
    public function cancle_verifikasi_soap_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi) {
            # code...
            $observasi->update([
                'verifikasi_at' => Null,
                'verifikasi_by' => Null,
            ]);
            return $this->sendResponse('Verifikasi berhasil dibatalkan');
        } else {
            return $this->sendError('Catatan tidak ditemukan');
        }
    }
    public function print_perkembangan_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_perkembangan;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_perkembangan', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
}
