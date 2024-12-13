<?php

namespace App\Http\Controllers\ERMRANAP\Dokter;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\AsesmenRanap;
use App\Models\AsesmenHeader;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AssesmenMedisController extends Controller
{
    public function storeAssesmen(Request $request)
    {
        $pic_dokter     = Auth::user()->id;
        $user_dokter    = Auth::user()->name;
        $kunjungan      = Kunjungan::with(['pasien', 'unit'])->where('kode_kunjungan', $request->kode_kunjungan)->first();
        $header         = AsesmenHeader::where('kode', $request->kode)->first();
        
        $asesmenMedis = [
            'rm_counter'                => $kunjungan->no_rm . '|' . $kunjungan->counter,
            'kode_kunjungan'            => $kunjungan->kode_kunjungan,
            'counter'                   => $kunjungan->counter,
            'no_rm'                     => $kunjungan->no_rm,
            'nama'                      => $kunjungan->pasien->nama_px,
            'tgl_tiba_diruangan'        => $request->tgl_tiba_diruangan,
            'waktu_tiba_diruangan'      => $request->waktu_tiba_diruangan,
            'tgl_pengkajian'            => $request->tgl_pengkajian,
            'waktu_pengkajian'          => $request->waktu_pengkajian,
            'kode_unit'                 => $kunjungan->kode_unit,
            'nama_unit'                 => $kunjungan->unit->nama_unit,
            'sumber_data'               => $request->sumber_data,
            'nama_keluarga'             => $request->nama_keluarga ?? null,
            'hubungan_keluarga'         => $request->hubungan_keluarga ?? null,
            'keluhan_utama'             => $request->keluhan_utama ?? null,
            'riwayat_penyakit_utama'    => $request->riwayat_penyakit_utama ?? null,
            'riwayat_penyakit_dahulu'   => $request->riwayat_penyakit_dahulu ?? null,
            'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga ?? null,
            'keadaan_umum'              => $request->keadaan_umum ?? null,
            'kesadaran'                 => $request->kesadaran ?? null,
            'diastole'                  => $request->diastole ?? null,
            'sistole'                   => $request->sistole ?? null,
            'pernapasan'                => $request->pernapasan ?? null,
            'suhu'                      => $request->suhu ?? null,
            'pemeriksaan_fisik'         => $request->pemeriksaan_fisik ?? null,
            'pemeriksaan_penunjang'     => $request->pemeriksaan_penunjang ?? null,
            'diagnosa_kerja'            => $request->diagnosa_kerja ?? null,
            'diagnosa_banding'          => $request->diagnosa_banding ?? null,
            'rencana_penunjang'         => $request->rencana_penunjang ?? null,
            'rencana_tindakan'          => $request->rencana_tindakan ?? null,
            'rencana_lama_ranap'        => $request->rencana_lama_ranap ?? null,
            'rencana_tgl_pulang'        => $request->rencana_tgl_pulang ?? null,
            'alasan_lama_ranap'         => $request->alasan_lama_ranap ?? null,
            'status_lanjutan_perawatan' => $request->memerlukan_perawatan_lanjutan ?? 0,
            'lanjutan_perawatan'        => $request->lanjutan_perawatan ?? null,
            'pic_dokter'                => $pic_dokter,
            'user_dokter'               => $user_dokter,
            'tgl_asesmen_awal'          => now(),
        ];
        $header     = [
            'kode'                  => $kunjungan->kode_kunjungan,
            'rm'                    => $kunjungan->no_rm, 
            'rm_counter'            => $kunjungan->no_rm.'|'.$kunjungan->counter, 
            'nama_pasien'           => $kunjungan->pasien->nama_px,
            'unit'                  => $kunjungan->unit->kode_unit,
            'nama_unit'             => $kunjungan->unit->nama_unit,
            'tgl_asesmen_medis'     => Null,
            'waktu_asesmen_medis'   => Null,
            'tgl_pengkajian_medis'  => Null,
            'waktu_pengkajian_medis'=> Null,
            'keluhan_utama'         => Null,
            'penyakit_utama'        => Null,
            'sumber_data_medis'     => $request->sumber_data,
            'nama_keluarga'         => $request->nama_keluarga,
            'hubungan_keluarga'     => $request->hubungan_keluarga,
            'tgl_asesmen_perawat'   => $request->tgl_tiba_diruangan,
            'waktu_asesmen_perawat' => $request->waktu_tiba_diruangan,
            'tgl_pengkajian_perawat'=> $request->tgl_pengkajian,
            'waktu_pengkajian_perawat'  => $request->waktu_pengkajian,
            'keluhan_utama_perawat'     => $request->riwayat_kesehatan_keluahan_utama,
            'riwayat_penyakit_sekarang' => $request->riwayat_kesehatan_riwayat_penyakit_sekarang,
            'tekanan_darah'         => $request->tekanan_darah,
            'respirasi'             => $request->respirasi,
            'nadi'                  => $request->denyut_nadi,
            'suhu'                  => $request->suhu,
            'status_asesmen'        => 0,
        ];

        AsesmenHeader::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $header // Data yang ingin diupdate atau dibuat
        );
        AsesmenRanap::updateOrCreate(
            ['kode_kunjungan' => $kunjungan->kode_kunjungan],
            $asesmenMedis
        );

        Alert::success('Success', 'Asesmen Awal Rawat Inap Disimpan');
        return redirect()->back();
    }
    
    public function printAsesmenRanapAwal(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $pdf = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_asesmen_ranap', compact('kunjungan', 'pasien'));
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_asesmen_ranap');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pdf_asesmen_ranap_awal.pdf');
    }
}
