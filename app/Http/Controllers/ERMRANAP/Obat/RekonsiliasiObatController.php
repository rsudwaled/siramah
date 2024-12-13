<?php

namespace App\Http\Controllers\ERMRANAP\Obat;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekonsiliasiObat;
use App\Models\DetailRekonsiliasiObat;

class RekonsiliasiObatController extends Controller
{
    public function storeObat(Request $request)
    {
        $pic_dokter     = Auth::user()->id;
        $user_dokter    = Auth::user()->name;
        $kunjungan      = Kunjungan::with(['pasien'])->where('kode_kunjungan', $request->kode)->first();

        if (!$kunjungan) {
            Alert::danger('danger', 'Rekonsiliasi Obat GAGAL Disimpan');
            return redirect()->back();
        }
        
        // Cek apakah rekonsiliasi sudah ada dengan kode_kunjungan yang sama
        $rekonsiliasi = RekonsiliasiObat::where('kode_kunjungan', $kunjungan->kode_kunjungan)->first();

        if (!$rekonsiliasi) {
            // Jika tidak ada, buat rekonsiliasi baru
            $rekonsiliasi = new RekonsiliasiObat();
        } 

        $rekonsiliasi->kode_kunjungan   = $kunjungan->kode_kunjungan;
        $rekonsiliasi->no_rm            = $kunjungan->no_rm;
        $rekonsiliasi->nama             = $kunjungan->pasien->nama_px;
        $rekonsiliasi->pic_dokter       = $pic_dokter??'1';
        $rekonsiliasi->user_dokter      = $user_dokter;
        
        if ($rekonsiliasi->save()) {
            $id = $rekonsiliasi->id;
            foreach ($request->nama_obat as $key => $nama_obat) {
                // Validate to ensure related data is present before creating detail records
                DetailRekonsiliasiObat::create([
                    'rekonsiliasi_id'   => $id,
                    'nama_obat'         => $nama_obat,
                    'dosis'             => $request->dosis[$key] ?? null,
                    'aturan_pakai'      => $request->aturan_pakai[$key] ?? null,
                    'terapi_lanjutan'   => $request->terapi_lanjutan[$key] ?? null,
                    'jumlah'            => $request->jumlah[$key] ?? null,
                ]);
            }
        
            Alert::success('Success', 'Rekonsiliasi Obat Berhasil Disimpan');
            return redirect()->back();
        } else {
            Alert::danger('danger', 'Rekonsiliasi Obat GAGAL Disimpan');
            return redirect()->back();
        }
        
        
    }
    public function updateObat(Request $request, $id)
    {
        $update = DetailRekonsiliasiObat::find($id);
        
        $update->nama_obat      = $request->nama_obat;
        $update->dosis          = $request->dosis;
        $update->aturan_pakai   = $request->aturan_pakai;
        $update->jumlah         = $request->jumlah;
        $update->terapi_lanjutan= $request->lanjutan;
        $update->save();
        return response()->json(['message' => 'Data updated successfully.'], 200);
    }

    public function deleteObat($id)
    {
        $obat = DetailRekonsiliasiObat::find($id);
        if ($obat) {
            $obat->delete();
            return response()->json(['success' => true, 'message' => 'Obat berhasil dihapus!']);
        }
        return response()->json(['success' => false, 'message' => 'Obat tidak ditemukan.'], 404);
    }
    
}
