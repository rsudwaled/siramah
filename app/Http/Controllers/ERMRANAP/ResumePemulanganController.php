<?php

namespace App\Http\Controllers\ERMRANAP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Icd10;
use App\Models\Kunjungan;
use App\Models\ErmRanapResume;
use App\Models\Paramedis;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ResumePemulanganController extends Controller
{
    public function viewResume(Request $request)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $pasien = $kunjungan->pasien;
        
        return view('simrs.erm-ranap.resume_pemulangan.resume', compact('kunjungan','pasien'));
    }

    public function viewResumeCepat(Request $request)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $pasien         = $kunjungan->pasien;
        $tanggalLahir   = Carbon::parse($pasien->tgl_lahir);
        $umur           = $tanggalLahir->age;
        $resume         = ErmRanapResume::where('kode_kunjungan', $request->kode)->first();
        $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','".$kunjungan->kode_unit."')");
        $riwayatObat    = collect($riwayatObat);
        $riwayatObat    = $riwayatObat->groupBy('nama_barang')->map(function($items) {
            return [
                'nama_barang' => $items->first()->nama_barang,  // Ambil nama obat dari salah satu item
                'qty' => $items->sum('qty')  // Jumlahkan qty dari semua obat dengan nama yang sama
            ];
        });
        return view('simrs.erm-ranap.resume_pemulangan.resume_cepat', compact('kunjungan','pasien','riwayatObat','resume','umur'));
    }
    
    public function storeResume(Request $request)
    {
        if (empty($request->nama_dpjp)) {
            return back()->with('error', 'Nama DPJP harus diisi!');
        }
        $dokter = Paramedis::where('kode_paramedis', $request->nama_dpjp)->first();
        $diagnosaUpdate         = $request->diagnosa_sekunder_update;
        $diagnosaSekunder       = !empty($request->diagnosa_sekunder) && is_array($request->diagnosa_sekunder)? implode('|', $request->diagnosa_sekunder): Null; 
        $diagnosaSekunderFinal  = implode('|', array_filter([$diagnosaUpdate, $diagnosaSekunder]));
        $operasiUpdate          = $request->tindakan_operasi_update;
        $tindakanOperasi        = !empty($request->tindakan_operasi) && is_array($request->tindakan_operasi)? implode('|', $request->tindakan_operasi): Null; 
        $operasiFinal           = implode('|', array_filter([$operasiUpdate, $tindakanOperasi]));
        $prosedureUpdate        = $request->tindakan_prosedure_update;
        $tindakanProsedure      = !empty($request->tindakan_prosedure) && is_array($request->tindakan_prosedure)? implode('|', $request->tindakan_prosedure): Null; 
        $prosedureFinal         = implode('|', array_filter([$prosedureUpdate, $tindakanProsedure]));
        
        $diagnosaUtamaRequest   = explode(' - ', $request->diagnosa_utama);
        $diagnosaUtamaCode      = $diagnosaUtamaRequest[0];
        $diagnosaUtama          = $diagnosaUtamaRequest[1];

        $data = [
            'kode_kunjungan'            => $request->kode_kunjungan,
            'counter'                   => $request->counter,
            'rm'                        => $request->rm_pasien,
            'tgl_evaluasi'              => $request->tgl_evaluasi,
            'waktu_evaluasi'            => $request->waktu_evaluasi,
            'tgl_masuk'                 => $request->tgl_masuk,
            'jam_masuk'                 => $request->waktu_masuk,
            'ruang_rawat_masuk'         => $request->ruang_rawat_masuk,
            'tgl_keluar'                => $request->tgl_keluar,
            'jam_keluar'                => $request->waktu_keluar,
            'ruang_rawat_keluar'        => $request->ruang_rawat_keluar,
            'lama_rawat'                => $request->lama_rawat,
            'bb_bayi_lahir'             => $request->bb_bayi_lahir,
            'ringkasan_perawatan'       => $request->ringkasan_perawatan,
            'riwayat_penyakit'          => $request->riwayat_penyakit,
            'indikasi_ranap'            => $request->indikasi_rawat_inap,
            'pemeriksaan_fisik'         => $request->pemeriksaan_fisik,
            'penunjang_lab'             => $request->penunjang_laboratorium,
            'penunjang_radiologi'       => $request->penunjang_radiologi,
            'penunjang_lainnya'         => $request->penunjang_lainya,
            'hasil_konsultasi'          => $request->hasil_konsultasi,
            'diagnosa_masuk'            => $request->diagnosa_masuk,
            'diagnosa_utama'            => $diagnosaUtama,
            'diagnosa_utama_icd10'      => $diagnosaUtamaCode,
            'diagnosa_sekunder'         => $diagnosaSekunderFinal,
            // 'icd9'                      => 'xxx',
            'komplikasi'                => $request->komplikasi,
            'tindakan_operasi'          => $operasiFinal,
            'tgl_operasi'               => $request->tgl_operasi,
            'waktu_operasi_mulai'       => $request->waktu_mulai_operasi,
            'waktu_operasi_selesai'     => $request->waktu_selesai_operasi,
            'sebab_kematian'            => $request->sebab_kematian,
            'tindakan_prosedure'        => $prosedureFinal,
            'id_pengobatan_selama_rawat'=> 1,
            'id_obat_untuk_pulang'      => 1,
            'cara_keluar'               => json_encode([ 
                'sembuh_perbaikan'  => $request->sembuh_perbaikan??0,
                'pindah_rs'         => $request->pindah_rs??0,
                'pulang_paksa'      => $request->pulang_paksa??0,
                'meninggal'         => $request->meninggal??0,
                'cara_lainya'       => $request->cara_keluar_lainnya??null,
            ]),
            'kondisi_pulang'            => $request->kondisi_pulang,
            'keadaan_umum'              => $request->keadaan_umum,
            'kesadaran'                 => $request->kesadaran,
            'tekanan_darah'             => $request->tekanan_darah,
            'nadi'                      => $request->nadi,
            'pengobatan_dilanjutkan'    => json_encode([ 
                'poliklinik_rswaled' => $request->poliklinik_rswaled,
                'rs_lain'            => $request->rs_lain,
                'dokter_praktek'     => $request->dokter_praktek,
                'lainnya'            => $request->pengobatan_lanjutan_lainnya,
            ]),
            'tgl_kontrol'               => $request->tgl_kontrol,
            'lokasi_kontrol'            => $request->lokasi_kontrol,
            'diet'                      => $request->diet,
            'latihan'                   => $request->latihan,
            'keterangan_kembali'        => $request->keterangan_kembali,
            'a_1menit'                  => $request->a_1menit??null,
            'ap_1menit'                 => $request->ap_1menit??null,
            'apg_1menit'                => $request->apg_1menit??null,
            'apga_1menit'               => $request->apga_1menit??null,
            'apgar_1menit'              => $request->apgar_1menit??null,
            'total_apgar_1menit'        => $request->total_apgar_1menit??null,
            'a_5menit'                  => $request->a_5menit??null,
            'ap_5menit'                 => $request->ap_5menit??null,
            'apg_5menit'                => $request->apg_5menit??null,
            'apga_5menit'               => $request->apga_5menit??null,
            'apgar_5menit'              => $request->apgar_5menit??null,
            'total_apgar_5menit'        => $request->total_apgar_5menit??null,
            'grafida'                   => $request->grafida??null,
            'pemeriksaan_shk_ya'        => $request->pemeriksaan_shk_ya??null,
            'pemeriksaan_shk_tidak'     => $request->pemeriksaan_shk_tidak??null,
            'diambil_dari_tumit'        => $request->diambil_dari_tumit??null,
            'diambil_dari_vena'         => $request->diambil_dari_vena??null,
            'tgl_pengambilan_shk'       => $request->tgl_pengambilan_shk??null,
            'tgl_pengambilan_shk'       => $request->nama_dpjp,
            'tgl_cetak'                 => $request->tgl_cetak??null,
            'kode_dokter'               => $dokter->kode_paramedis,
            'dpjp'                      => $dokter->nama_paramedis,
        ];
        ErmRanapResume::updateOrCreate(
            ['kode_kunjungan' => $request->kode_kunjungan],  // Kondisi pencarian
            $data  // Data yang akan diupdate atau disimpan
        );
        return back();
    }
    
    public function printResume(Request $request)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $resume         = ErmRanapResume::where('kode_kunjungan', $request->kode)->first();
        $pasien         = $kunjungan->pasien;
        $tanggalLahir   = Carbon::parse($pasien->tgl_lahir);
        $umur           = $tanggalLahir->age;
        $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','".$kunjungan->kode_unit."')");
        $riwayatObat    = collect($riwayatObat);
        $riwayatObat    = $riwayatObat->groupBy('nama_barang')->map(function($items) {
            return [
                'nama_barang' => $items->first()->nama_barang,  // Ambil nama obat dari salah satu item
                'qty' => $items->sum('qty')  // Jumlahkan qty dari semua obat dengan nama yang sama
            ];
        });
        $pdf    = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_resume_pemulangan_pasien', compact('kunjungan','resume', 'riwayatObat','umur'));
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_resume_pemulangan_pasien');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pdf_resume_pemulangan.pdf');
    }

    public function getDokters(Request $request)
    {
        $dokters = Paramedis::where('act', 1)
                    ->get(['kode_paramedis', 'nama_paramedis']);
 
        return response()->json($dokters);
    }

}
