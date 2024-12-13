<?php

namespace App\Http\Controllers\ERMRANAP\Perkembangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerkembanganPasien;
use App\Models\ErmRanapKonsultasiDokter;
use App\Models\Kunjungan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PerkembanganPasienController extends Controller
{
    public function getPerkembangan(Request $request)
    {
        $data = PerkembanganPasien::where('pic', Auth::user()->id)->where('kode_kunjungan', $request->kode)->get(); // Ambil semua data konsultasi (sesuaikan dengan query)
        return response()->json($data);
    }
    public function storePerkembangan(Request $request)
    {
        $pic = Auth::user()->id;
        $user = Auth::user()->name;
        PerkembanganPasien::updateOrCreate(
            [
                'tanggal' => $request->tanggal_cppt,
                'waktu'   => $request->waktu_cppt,
            ],
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'rm'                => $request->no_rm,
                'subjek'            => $request->subjek,
                'objek'             => $request->objek,
                'asesmen'           => $request->assesmen,
                'planning'          => $request->planning,
                'instruksi_medis'   => $request->instruksi_medis,
                'verify'            => 0,
                'user'              => $user,
                'pic'               => $pic,
                'profesi'           => 'dokter',
            ]
        );
       
        Alert::success('Success', 'Rencana Asuhan Berhasil Disimpan');
        return redirect()->back();
    }

    public function updatePerkembangan(Request $request, $id)
    {
        $perkembangan = PerkembanganPasien::find($id);
        if (empty($perkembangan)) {
            return response()->json(['success' => false, 'message' => 'Perkembangan tidak ditemukan.'], 404);
        }
        $perkembangan->subjek            = $request->subjek;
        $perkembangan->objek             = $request->objek;
        $perkembangan->asesmen           = $request->asesmen;
        $perkembangan->planning          = $request->planning;
        $perkembangan->instruksi_medis   = $request->instruksi;
        $perkembangan->save();
        return response()->json(['message' => 'Data updated successfully.'], 200);
    }

    public function deletePerkembangan($id)
    {
        $perkembangan = PerkembanganPasien::find($id);
        if (empty($perkembangan)) {
            return response()->json(['success' => false, 'message' => 'Perkembangan tidak ditemukan.'], 404);
        }
        $perkembangan->delete();
        return response()->json(['success' => true,'message' => 'Data berhasil dihapus.'], 200);
    }

    public function storeKonsultasi(Request $request)
    {
        $pic = Auth::user()->id;
        $user = Auth::user()->name;
        $validator = Validator::make($request->all(), [
            'tanggal_konsultasi'=> 'required|date',
            'waktu_konsultasi'  => 'required|date_format:H:i',
            'nama_dokter_konsul'=> 'required|string',
            'jenis_konsultasi'  => 'required|string',
            'keterangan_konsul' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan atau perbarui data menggunakan updateOrCreate
        try {
            ErmRanapKonsultasiDokter::Create(
                // [
                //     'kode' => $request->kode_kunjungan,
                //     'rm' => $request->no_rm,
                //     'tanggal_konsultasi' => $request->tanggal_konsultasi,
                // ],
                [
                    'kode'              => $request->kode_kunjungan,
                    'rm'                => $request->no_rm,
                    'tanggal_konsultasi'=> $request->tanggal_konsultasi,
                    'waktu_konsultasi'  => $request->waktu_konsultasi,
                    'pengirim_konsul'   => $user,
                    'tujuan_konsul'     => $request->nama_dokter_konsul,
                    'spesialis'         => $request->spesialis??Null,
                    'jenis_konsul'      => $request->jenis_konsultasi,
                    'tim_medis_dokter'  => $request->tim_medis_dokter??Null,
                    'keterangan'        => $request->keterangan_konsul,
                    'status_jawab'      => 0,
                    'pic'               => $pic,
                ]
            );

            // Jika berhasil disimpan
            return response()->json([
                'status' => 'success',
                'message' => 'Data perkembangan pasien berhasil disimpan atau diperbarui',
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data',
            ], 500);
        }
    }
    
    public function getKonsultasiData(Request $request)
    {
        // dd($request->all());
        $kode = $request->kunjungan;
        $konsultasi = ErmRanapKonsultasiDokter::where('pic', Auth::user()->id)->where('kode', $kode)->get(); // Ambil semua data konsultasi (sesuaikan dengan query)
        
        return response()->json($konsultasi); // Kembalikan data dalam bentuk JSON
    }

    public function printKonsultasi(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $konsultasi = ErmRanapKonsultasiDokter::where('pic', Auth::user()->id)->first(); 
        // dd($konsultasi);
        $pdf = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_konsultasi', compact('konsultasi','kunjungan','pasien'));
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_konsultasi');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pdf_konsultasi.pdf');
    }

    // ROLE PERAWAT
    public function storeCPPTPerawat(Request $request)
    {
        $pic = Auth::user()->id;
        $user = Auth::user()->name;
        PerkembanganPasien::updateOrCreate(
            [
                'tanggal' => $request->tanggal_cppt,
                'waktu'   => $request->waktu_cppt,
            ],
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'rm'                => $request->no_rm,
                'subjek'            => $request->subjek,
                'objek'             => $request->objek,
                'asesmen'           => $request->assesmen,
                'planning'          => $request->planning,
                'instruksi_medis'   => $request->instruksi_medis,
                'verify'            => 0,
                'user'              => $user,
                'pic'               => $pic,
                'profesi'           => 'perawat',
            ]
        );
        
        
        Alert::success('Success', 'Rencana Asuhan Berhasil Disimpan');
        return redirect()->back();
    }

    public function updateCPPTPerawat(Request $request, $id)
    {
        $perkembangan = PerkembanganPasien::find($id);
        if (empty($perkembangan)) {
            return response()->json(['success' => false, 'message' => 'Perkembangan tidak ditemukan.'], 404);
        }
        $perkembangan->subjek            = $request->subjek;
        $perkembangan->objek             = $request->objek;
        $perkembangan->asesmen           = $request->asesmen;
        $perkembangan->planning          = $request->planning;
        $perkembangan->instruksi_medis   = $request->instruksi;
        $perkembangan->save();
        return response()->json(['message' => 'Data updated successfully.'], 200);
    }
}
