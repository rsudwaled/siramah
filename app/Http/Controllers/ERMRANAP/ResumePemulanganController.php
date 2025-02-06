<?php

namespace App\Http\Controllers\ERMRANAP;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\ErmRanapPengajuanPembukaanFormResume;
use App\Models\ErmRanapResumeDiagSekunder;
use App\Models\ErmRanapResumeObatPulang;
use App\Models\ErmRanapResume;
use App\Models\Paramedis;
use App\Models\Unit;
use Carbon\Carbon;


class ResumePemulanganController extends Controller
{
    public function pasienRanap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        $request['tanggal'] = $request->tanggal ?? now()->format('Y-m-d');
        if ($request->tanggal) {
            $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->whereRelation('unit', 'kelas_unit', '=', 2)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status', 'erm_ranap', 'penjamin_simrs', 'alasan_masuk', 'dokter'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->kodeunit)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status', 'erm_ranap', 'penjamin_simrs', 'alasan_masuk', 'dokter'])
                    ->get();
            }
        }
        $belum = $kunjungans->where('budget.kode_cbg', null)->count();
        if ($belum) {
            Alert::warning('Peringatan', 'Ada ' . $belum . ' pasien yang belum di groupping. Mohon lakukan pengecekan dan silahkan groupping sebelum 3 hari saat rawat inap');
        }
        return view('simrs.erm-ranap.resume_pemulangan.kunjungan_ranap', compact(
            'request',
            'units',
            'kunjungans',
        ));
    }
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
        if (!empty($pasien->tgl_lahir)) {
            try {
                // Parsing tanggal lahir pasien
                $tanggalLahir = Carbon::parse($pasien->tgl_lahir);

                // Mendapatkan usia pasien dalam hari
                $umur = $tanggalLahir->diffInDays(Carbon::now());

                // Menentukan apakah pasien adalah bayi (umur antara 0 hingga 30 hari)
                $statusBayi = ($umur <= 30) ? 'Bayi' : 'Bukan Bayi';

            } catch (\Exception $e) {
                // Jika terjadi kesalahan parsing tanggal
                $statusBayi = 'Tanggal lahir tidak valid';
            }
        } else {
            $statusBayi = 'Tanggal lahir tidak tersedia';
        }
        $resume         = ErmRanapResume::where('kode_kunjungan', $request->kode)->first();
        if($resume && $resume->status_resume == 1)
        {
            return view('simrs.erm-ranap.resume_pemulangan.resume_cepat_final', compact('resume','kunjungan'));
        }
        // $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','".$kunjungan->kode_unit."')");
        $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "')");
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
        $diagnosaSekunder       = !empty($request->diag_sekunder_dokter) && is_array($request->diag_sekunder_dokter)? implode('|', $request->diag_sekunder_dokter): Null;
        $diagSekunderFinal      = implode('|', array_filter([$diagnosaUpdate, $diagnosaSekunder]));

        $operasiUpdate          = $request->tindakan_operasi_update;
        $tindakanOperasi        = !empty($request->tindakan_operasi_dokter) && is_array($request->tindakan_operasi_dokter)? implode('|', $request->tindakan_operasi_dokter): Null;
        $operasiFinal           = implode('|', array_filter([$operasiUpdate, $tindakanOperasi]));

        $prosedureUpdate        = $request->tindakan_prosedure_update;
        $tindakanProsedure      = !empty($request->tindakan_prosedure_dokter) && is_array($request->tindakan_prosedure_dokter)? implode('|', $request->tindakan_prosedure_dokter): Null;
        $prosedureFinal         = implode('|', array_filter([$prosedureUpdate, $tindakanProsedure]));

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
            'rawat_intensif'            => $request->rawat_intensif,
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
            //diagnosa_dokter
            'diagnosa_utama_dokter'     => $request->diagnosa_utama_dokter,
            // akses casemix
            'diagnosa_utama'            => $request->diagnosa_utama,
            // 'diagnosa_sekunder'         => $diagSekunderFinal,
            'diagnosa_sekunder_dokter'  => $diagSekunderFinal??null,

            'komplikasi'                => $request->komplikasi,
            // 'tindakan_operasi'          => $operasiFinal,
            'tindakan_operasi_dokter'   => $operasiFinal??null,

            'tgl_operasi'               => $request->tgl_operasi,
            'waktu_operasi_mulai'       => $request->waktu_mulai_operasi,
            'waktu_operasi_selesai'     => $request->waktu_selesai_operasi,
            'sebab_kematian'            => $request->sebab_kematian,
            // 'tindakan_prosedure'        => $prosedureFinal,
            'tindakan_prosedure_dokter' => $prosedureFinal??Null,

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
            'ket_intruksi_pulang'       => $request->ket_intruksi_pulang??null,
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
            // 'tgl_pengambilan_shk'       => $request->nama_dpjp,
            'tgl_cetak'                 => $request->tgl_cetak??null,
            'kode_dokter'               => $dokter->kode_paramedis,
            'dpjp'                      => $dokter->nama_paramedis,
            'user'                      => Auth::user()->username ?? 'anonim',
        ];
        $resume = ErmRanapResume::updateOrCreate(
            ['kode_kunjungan' => $request->kode_kunjungan],  // Kondisi pencarian
            $data  // Data yang akan diupdate atau disimpan
        );
        $kunjungan_counter = $resume->kode_kunjungan.'|'.$resume->counter;
        $existingObatPulang = ErmRanapResumeObatPulang::where('id_resume', $resume->id)->get();
        // Buat atau update obat berdasarkan data yang diterima dari form
        if (is_array($request->nama_obat) && count($request->nama_obat) > 0)
        {
            foreach ($request->nama_obat as $key => $namaObat) {
                $jumlah         = $request->jumlah[$key];
                $dosis          = $request->dosis[$key];
                $frekuensi      = $request->frekuensi[$key];
                $caraPemberian  = $request->cara_pemberian[$key];
                // Cari apakah obat sudah ada dalam database
                $existingObat = ErmRanapResumeObatPulang::where('id_resume', $resume->id)
                                                        ->where('nama_obat', $namaObat)
                                                        ->first();
                if ($existingObat) {
                    // Jika obat sudah ada, update jumlahnya
                    $existingObat->jumlah = $jumlah;
                    $existingObat->dosis                = $dosis;
                    $existingObat->frekuensi            = $frekuensi;
                    $existingObat->cara_pemberian       = $caraPemberian;
                    $existingObat->save();
                } else {
                    // Jika obat belum ada, buat data baru
                    $obat = new ErmRanapResumeObatPulang();
                    $obat->nama_obat            = $namaObat;
                    $obat->rm                   = $resume->rm;
                    $obat->kunjungan_counter    = $kunjungan_counter;
                    $obat->id_resume            = $resume->id;
                    $obat->jumlah               = $jumlah;
                    $obat->dosis                = $dosis;
                    $obat->frekuensi            = $frekuensi;
                    $obat->cara_pemberian       = $caraPemberian;
                    $obat->save();
                }
            }
            // Menghapus obat yang ada di database tetapi tidak ada di request
            // Cek nama obat yang ada di request
            $namaObatRequest = $request->nama_obat;

            foreach ($existingObatPulang as $obat) {
                // Jika nama obat tidak ada pada request, hapus obat tersebut
                if (!in_array($obat->nama_obat, $namaObatRequest)) {
                    $obat->delete();
                }
            }
        }

        return back();
    }

    public function printResume(Request $request)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $resume         = ErmRanapResume::where('kode_kunjungan', $request->kode)->first();
        if($resume)
        {
            $obatPulang     = ErmRanapResumeObatPulang::where('id_resume', $resume->id)->get();
        }else{
            $obatPulang = collect();
        }
        $pasien         = $kunjungan->pasien;
        if (!empty($pasien->tgl_lahir)) {
            try {
                // Parsing tanggal lahir pasien
                $tanggalLahir = Carbon::parse($pasien->tgl_lahir);

                // Mendapatkan usia pasien dalam hari
                $umur = $tanggalLahir->diffInDays(Carbon::now());

                // Menentukan apakah pasien adalah bayi (umur antara 0 hingga 30 hari)
                $statusBayi = ($umur <= 30) ? 'Bayi' : 'Bukan Bayi';

            } catch (\Exception $e) {
                // Jika terjadi kesalahan parsing tanggal
                $statusBayi = 'Tanggal lahir tidak valid';
            }
        } else {
            $statusBayi = 'Tanggal lahir tidak tersedia';
        }
        // $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','".$kunjungan->kode_unit."')");
        $riwayatObat    = \DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "')");
        $riwayatObat    = collect($riwayatObat);
        $riwayatObat    = $riwayatObat->groupBy('nama_barang')->map(function($items) {
            return [
                'nama_barang' => $items->first()->nama_barang,
                'aturan_pakai' => $items->first()->aturan_pakai,
                'qty' => $items->sum('qty')  // Jumlahkan qty dari semua obat dengan nama yang sama
            ];
        });
        $unit = $kunjungan->kode_unit;
        if($unit =='2020')
        {
            $pdf    = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_resume_pemulangan_pasien_hcu', compact('kunjungan','resume', 'riwayatObat','umur','obatPulang'));
        }else{
            $pdf    = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_resume_pemulangan_pasien', compact('kunjungan','resume', 'riwayatObat','umur','obatPulang'));
        }
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_resume_pemulangan_pasien');
        $pdf->setPaper('F4', 'portrait');
        return $pdf->stream('pdf_resume_pemulangan.pdf');
    }

    public function sendResume(Request $request)
    {
        $finalResume = ErmRanapResume::where('kode_kunjungan', $request->kode_kunjungan)->first();
        $finalResume->status_resume = 1;
        $finalResume->save();
        return back()->with('success', 'Resume Pemulangan Berhasil dikirim dalam bentuk final!');
    }

    public function postPengajuanPembukaanFormResume(Request $request)
    {
        // dd($request->all());
        ErmRanapPengajuanPembukaanFormResume::create([
            'id_resume'     => $request->id_resume,
            'keterangan'    => $request->keterangan,
            'pemohon'       => Auth::user()->username,
            'status_aproval'=> 0,
        ]);
        return back()->with('success', 'Pengajuan Pembukaan Resume Berhasil dikirim!');
    }

    public function getDokters(Request $request)
    {
        $dokters = Paramedis::where('act', 1)
                    ->get(['kode_paramedis', 'nama_paramedis']);

        return response()->json($dokters);
    }

}
