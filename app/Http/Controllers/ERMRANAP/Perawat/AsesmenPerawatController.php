<?php

namespace App\Http\Controllers\ERMRANAP\Perawat;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\PemeriksaanFisikKeperawatan;
use App\Models\AsesmenHeader;
use App\Models\ErmRanapKeperawatan;
use App\Models\AsesmenResikoPd;
use App\Models\AsesmenResikoPG;
use App\Models\SkriningNutrisi;
use App\Models\AsesmenFungsional;
use App\Models\PerencanaanPulang;
use App\Models\RencanaAsuhanKeperawatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AsesmenPerawatController extends Controller
{
    public function storeAsesmenPerawat(Request $request)
    {
        $pic_perawat    = Auth::user()->id;
        $user_perawat   = Auth::user()->name;

        $kunjungan  = Kunjungan::with(['unit','pasien'])->where('kode_kunjungan', $request->kode)->first();
        $header     = [
            'kode'                  => $kunjungan->kode_kunjungan,
            // 'rm'                    => $kunjungan->no_rm, 
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
        $asesmen    = [
            'kode'              => $kunjungan->kode_kunjungan,
            'counter'           => $kunjungan->counter,
            'no_rm'             => $kunjungan->no_rm,
            'rm_counter'        => $kunjungan->no_rm.'|'.$kunjungan->counter,
            'nama'              => $kunjungan->pasien->nama_px,
            'kode_unit'         => $kunjungan->kode_unit,
            'nama_unit'         => $kunjungan->unit->nama_unit,
            'tgl_tiba_ruangan'  => $request->tgl_tiba_diruangan,
            'waktu_tiba'        => $request->waktu_tiba_diruangan,
            'tgl_pengkajian'    => $request->tgl_pengkajian,
            'waktu_pengkajian'  => $request->waktu_pengkajian,
            'cara_masuk'        => $request->cara_masuk,
            'asal_masuk'        => $request->asal_masuk,
            'sumber_data'       => $request->sumber_data,
            'nama_keluarga'     => $request->nama_keluarga,
            'hubungan_keluarga' => $request->hubungan_keluarga,
            'keadaan_umum'      => $request->keadaan_umum,
            'kesadaran'         => $request->kesadaran,
            'tekanan_darah'     => $request->tekanan_darah,
            'respirasi'         => $request->respirasi,
            'denyut_nadi'       => $request->denyut_nadi,
            'suhu'              => $request->suhu,
            'diagnosa_keperawatan'=> $request->diagnosa_keperawatan,
            'skrining_nyeri'   => json_encode([ // Mengubah array menjadi JSON string
                'keluhan_nyeri'             => $request->keluhan_nyeri ?? [],
                'skala_nyeri'               => $request->skala_nyeri ?? 0,
                'provocation'               => $request->provocation ?? [],
                'quality'                   => $request->quality ?? [],
                'region'                    => $request->region ?? [],
                'severity'                  => $request->severity ?? [],
                'time'                      => $request->time ?? [],
            ]),
            'asesmen_nyeri_lanjutan'   => json_encode([ // Mengubah array menjadi JSON string
                'provocation'               => $request->provocation ?? [],
                'quality'                   => $request->quality ?? 0,
                'region'                    => $request->region ?? [],
                'severity'                  => $request->severity ?? [],
                'time'                      => $request->time ?? [],
            ]),
            'keluhan_utama'             => $request->riwayat_kesehatan_keluahan_utama,
            'penyakit_sekarang'         => $request->riwayat_kesehatan_riwayat_penyakit_sekarang,
            'riwayat_kesehatan'         => json_encode([ // Mengubah array menjadi JSON string
                'riwayat_kesehatan_pernah_dirawat'  => $request->riwayat_kesehatan_pernah_dirawat ?? [],
                'riwayat_kesehatan_nama_penyakit'   => $request->riwayat_kesehatan_nama_penyakit ?? [],
                'riwayat_kesehatan_pemakaian_obat'  => $request->riwayat_kesehatan_pemakaian_obat ?? [],
                'riwayat_kesehatan_nama_obat'       => $request->riwayat_kesehatan_nama_obat ?? [],
                'riwayat_penyerta'                  => $request->riwayat_penyerta ?? [],
                'riwayat_penyerta_keterangan_lainya'=> $request->riwayat_penyerta_keterangan_lainya ?? [],
                'riwayat_alergi'                    => $request->riwayat_alergi ?? [],
                'riwayat_alergi_keterangan'         => $request->riwayat_alergi_keterangan ?? [],
            ]),
            'diagnostik_edukasi'         => json_encode([ // Mengubah array menjadi JSON string
                'diagnostik_laboratorium'       => $request->diagnostik_laboratorium ?? [],
                'diagnostik_radiologi'          => $request->diagnostik_radiologi ?? [],
                'diagnostik_lainya'             => $request->diagnostik_lainya ?? [],
                'tentang_penyakit'              => $request->tentang_penyakit ?? [],
                'informasi_yg_ingin_diketahui'  => $request->informasi_yg_ingin_diketahui ?? [],
                'keluarga_terlibat_perawatan'   => $request->keluarga_terlibat_perawatan ?? [],
            ]),
        ];
        $pemeriksaanFisik   = [
            'kode' => $kunjungan->kode_kunjungan,
            'rm' => $kunjungan->no_rm,
            'sistem_respirasi_oksigenasi'=> json_encode([ // Mengubah array menjadi JSON string
                'obstruksi'                 => $request->obstruksi ?? [],
                'alat_bantu_napas'          => $request->alat_bantu_napas ?? [],
                'dyspnea'                   => $request->dyspnea ?? [],
                'batuk'                     => $request->batuk ?? [],
                'sputum'                    => $request->sputum ?? [],
                'warna_sputum'              => $request->warna_sputum ?? [],
                'bunyi_napas'               => $request->bunyi_napas ?? [],
                'thorax'                    => $request->thorax ?? [],
                'krepitasi'                 => $request->krepitasi ?? [],
                'ctt'                       => $request->ctt ?? [],
            ]),
            'sistem_kardio_vaskuler'     => json_encode([ // Mengubah array menjadi JSON string
                'nadi'                  => $request->nadi ?? [],
                'konjungtiva'           => $request->konjungtiva ?? [],
                'pasang_alat'           => $request->pasang_alat ?? [],
                'temperatur'            => $request->temperatur ?? [],
                'kulit'                 => $request->kulit ?? [],
                'bunyi_jantung'         => $request->bunyi_jantung ?? [],
                'ekstremis'             => $request->ekstremis ?? [],
                'nichiban'              => $request->nichiban ?? [],
                'edema'                 => $request->edema ?? [],
            ]),
            'sistem_gastro_intestinal'   => json_encode([ // Mengubah array menjadi JSON string
                'makan_frekuensi'       => $request->makan_frekuensi ?? [],
                'makan_jumlah'          => $request->makan_jumlah ?? [],
                'mual'                  => $request->mual ?? [],
                'muntah'                => $request->muntah ?? [],
                'warna_muntah'          => $request->warna_muntah ?? [],
                'bab'                   => $request->bab ?? [],
                'warna_bab'             => $request->warna_bab ?? [],
                'konsistensi_bab'       => $request->konsistensi_bab ?? [],
                'sklera'                => $request->sklera ?? [],
                'mukosa'                => $request->mukosa ?? [],
                'warna_lidah'           => $request->warna_lidah ?? [],
                'lidah_warna'           => $request->lidah_warna ?? [],
                'reflek_menelan'        => $request->reflek_menelan ?? [],
                'reflek_mengunyah'      => $request->reflek_mengunyah ?? [],
                'alat_bantu'            => $request->alat_bantu ?? [],
                'bising_usu'            => $request->bising_usu ?? [],
                'bentuk_abdomen'        => $request->bentuk_abdomen ?? [],
                'stomata'               => $request->stomata ?? [],
                'drain'                 => $request->drain ?? [],
            ]),
            'sistem_muskulo_skeletal'    => json_encode([ // Mengubah array menjadi JSON string
                'fraktur'               => $request->fraktur ?? [],
                'mobilitas'             => $request->mobilitas ?? [],
                'mobilitas_alat_bantu'  => $request->mobilitas_alat_bantu ?? [],
            ]),
            'sistem_neurologi'           => json_encode([ // Mengubah array menjadi JSON string
                'kesulitan_bicara'      => $request->kesulitan_bicara ?? [],
                'kelemahan_alat_gerak'  => $request->kelemahan_alat_gerak ?? [],
                'evd'                   => $request->evd ?? [],
            ]),
            'sistem_urogenital'          => json_encode([ // Mengubah array menjadi JSON string
                'pola_bak'              => $request->pola_bak ?? [],
                'frekuensi_bak'         => $request->frekuensi_bak ?? [],
                'warna_urina'           => $request->warna_urina ?? [],
                'uro_alat_bantu'        => $request->uro_alat_bantu ?? [],
                'uro_stomata'           => $request->uro_stomata ?? [],
            ]),
            'sistem_integumen'           => json_encode([ // Mengubah array menjadi JSON string
                'integumen_luka'        => $request->integumen_luka ?? [],
                'integumen_benjolan'    => $request->integumen_benjolan ?? [],
                'integumen_suhu'        => $request->integumen_suhu ?? [],
            ]),
            'hyigiene'                   => json_encode([ // Mengubah array menjadi JSON string
                'aktivitas_hygiene'     => $request->aktivitas_hygiene ?? [],
                'penampilan_hygiene'    => $request->penampilan_hygiene ?? [],
            ]),
            'psikososial_budaya'         => json_encode([ // Mengubah array menjadi JSON string
                'ekspresi_wajah'                => $request->ekspresi_wajah ?? [],
                'kemampuan_bicara_psiko_sosbud' => $request->kemampuan_bicara_psiko_sosbud ?? [],
                'koping_mekanisme'              => $request->koping_mekanisme ?? [],
                'pekerjaan'                     => $request->pekerjaan ?? [],
                'tinggal_bersama'               => $request->tinggal_bersama ?? [],
                'suku'                          => $request->suku ?? [],
            ]),
            'spiritual_kepercayaan' => json_encode([
                'agama'             => $request->input('spiritual_agama', []), // Menggunakan input 'spiritual_agama'
                'keprihatinan'      => [
                    'jawaban'       => $request->input('keprihatinan_jawaban', 'Tidak'), // Menyimpan Ya/Tidak
                    'detail'        => $request->input('keprihatinan_ya_detail', []) // Pertanyaan tambahan jika Ya
                ],
                'nilai_kepercayaan' => $request->input('nilai_kepercayaan', ''), // Menangani input teks
            ]),
        ];
        $asesmenResikoPD    = [
            'kode'  => $kunjungan->kode_kunjungan,
            'rm'    => $kunjungan->no_rm,
            'unit'  => $kunjungan->kode_unit,
            'skor_riwayat_jatuh_tidak'      => $request->skor_riwayat_jatuh_tidak,
            'skor_riwayat_jatuh_ya'         => $request->skor_riwayat_jatuh_ya,
            'skor_diagnosa_sekunder_tidak'  => $request->skor_diagnosa_sekunder_tidak,
            'skor_diagnosa_sekunder_ya'     => $request->skor_diagnosa_sekunder_ya,
            'skor_alat_bantu_tidak'         => $request->skor_alat_bantu_tidak,
            'skor_alat_bantu_kruk'          => $request->skor_alat_bantu_kruk,
            'skor_alat_bantu_kursi'         => $request->skor_alat_bantu_kursi,
            'skor_infus_tidak'              => $request->skor_infus_tidak,
            'skor_infus_ya'                 => $request->skor_infus_ya,
            'skor_gaya_berjalan_normal'     => $request->skor_gaya_berjalan_normal,
            'skor_gaya_berjalan_lemah'      => $request->skor_gaya_berjalan_lemah,
            'skor_gaya_berjalan_terganggu'  => $request->skor_gaya_berjalan_terganggu,
            'skor_status_mental_menyadari'  => $request->skor_status_mental_menyadari,
            'skor_status_mental_lupa'       => $request->skor_status_mental_lupa,
            'total_skor'                    => $request->total_skor_pasien,
        ];
        $asesmenResikoPG    = [
            'kode'  => $kunjungan->kode_kunjungan,
            'rm'    => $kunjungan->no_rm,
            'unit'  => $kunjungan->kode_unit,
            'jatuh_rumah_sakit'         =>isset($request->skor_skrining_riwayat_jatuh[0]) ? $request->skor_skrining_riwayat_jatuh[0] : 0,
            'jatuh_2_bulan_terakhir'    =>isset($request->skor_skrining_riwayat_jatuh[1]) ? $request->skor_skrining_riwayat_jatuh[1] : 0,
            'skor_riwayat_jatuh'        =>array_sum($request->skor_skrining_riwayat_jatuh),
            'delirium'                  =>isset($request->skor_skrining_status_mental[0]) ? $request->skor_skrining_status_mental[0] : 0,
            'disorientasi'              =>isset($request->skor_skrining_status_mental[1]) ? $request->skor_skrining_status_mental[1] : 0,
            'agitasi'                   =>isset($request->skor_skrining_status_mental[2]) ? $request->skor_skrining_status_mental[2] : 0,
            'skor_status_mental'        =>array_sum($request->skor_skrining_status_mental),
            'pakai_kacamata'            =>isset($request->skor_skrining_penglihatan[0]) ? $request->skor_skrining_penglihatan[0] : 0,
            'penglihatan_buram'         =>isset($request->skor_skrining_penglihatan[1]) ? $request->skor_skrining_penglihatan[1] : 0,
            'keluhan_mata'              =>isset($request->skor_skrining_penglihatan[2]) ? $request->skor_skrining_penglihatan[2] : 0,
            'skor_penglihatan'          =>array_sum($request->skor_skrining_penglihatan),
            'perubahan_berkemih'        =>isset($request->skrining_kebiasaan_berkemih[0]) ? $request->skrining_kebiasaan_berkemih[0] : 0,
            'skor_kebiasaan_berkemih'   =>array_sum($request->skor_skrining_kebiasaan_berkemih),
            'transfer_mobilitas'        =>$request->transfer_mobilitas??0,
            'risiko_jatuh_rendah'       =>$request->risiko_jatuh_rendah=='on'?1:0,
            'risiko_jatuh_sedang'       =>$request->risiko_jatuh_sedang=='on'?1:0,
            'risiko_jatuh_tinggi'       =>$request->risiko_jatuh_tinggi=='on'?1:0,
            'total_skor'                =>$request->total_skor_skrining,
        ];
        $skriningNutrisi    = [
            'kode'                      => $kunjungan->kode_kunjungan,
            'rm'                        => $kunjungan->no_rm,
            'tidak_terjadi_penurunan'   => $request->tidak_terjadi_penurunan== 'on'?0:NULL,
            'tidak_yakin_turun'         => $request->tidak_yakin_penurunan == 'on'?2:NULL,
            'penurunan_bb'              => isset($request->skor_penurunan_bb_tidak_yakin) ? 2 : ($request->penurunan_bb ?? 0),
            'pernurunan_1_5'            => $request->skor_penurunan_bb_1_5??0,
            'pernurunan_6_10'           => $request->skor_penurunan_bb_6_10??0,
            'pernurunan_11_15'          => $request->skor_penurunan_bb_11_15??0,
            'pernurunan_lbh_15'         => $request->skor_penurunan_bb_lbh_15??0,
            'pernurunan_tidak_yakin'    => $request->skor_penurunan_bb_tidak_yakin??0,
            'nafsu_makan_buruk'         => $request->asupan_makan_buruk,
            'sakit_berat'               => $request->sakit_berat,
            'total_skor_skrining_nutrisi'=> $request->total_skor_skrining_nutrisi,
        ];
        $asesmenFungsional  = [
            'kode'                      => $kunjungan->kode_kunjungan,
            'counter'                   => $kunjungan->counter,
            'rm'                        => $kunjungan->no_rm,
            'skor_af_rangsang_defeksi'  => $request->skor_af_rangsang_defeksi??0,
            'skor_af_rangsang_berkemih' => $request->skor_af_rangsang_berkemih??0,
            'skor_af_membersihkan_diri' => $request->skor_af_membersihkan_diri??0,
            'skor_af_penggunaan_jamban' => $request->skor_af_penggunaan_jamban??0,
            'skor_af_makan'             => $request->skor_af_makan??0,
            'skor_af_berubah_sikap'     => $request->skor_af_berubah_sikap??0,
            'skor_af_berpindah_berjalan'=> $request->skor_af_berpindah_berjalan??0,
            'skor_af_memakai_baju'      => $request->skor_af_memakai_baju??0,
            'skor_af_naik_tangga'       => $request->skor_af_naik_tangga??0,
            'skor_af_mandi'             => $request->skor_af_mandi??0,
            'total_skor_af'             => $request->total_skor_af??0,
        ];
        $perencanaanPulang  = [
            'kode'                                  => $kunjungan->kode_kunjungan,
            'counter'                               => $kunjungan->counter,
            'rm'                                    => $kunjungan->no_rm,
            'jenis_tt'                              => $request->jenis_tt,
            'jenis_tt_lainya'                       => $request->jenis_tt_lainya,
            'usia_lbh_7'                            => $request->usia_lbh_7,
            'ket_usia_lbh_70'                       => $request->ket_usia_lbh_70,            
            'pasien_tinggal_sendiri'                => $request->pasien_tinggal_sendiri,
            'ket_pasien_tinggal_sendiri'           => $request->ket_pasien_tinggal_sendiri,            
            'memiliki_tetangga'                     => $request->memiliki_tetangga,
            'ket_memiliki_tetangga'                 => $request->ket_memiliki_tetangga,            
            'perawatan_lanjutan_dirumah'            => $request->perawatan_lanjutan_dirumah,
            'ket_perawatan_lanjutan_dirumah'        => $request->ket_perawatan_lanjutan_dirumah,            
            'keterbatasan_merawat_diri'             => $request->keterbatasan_merawat_diri,
            'ket_keterbatasan_merawat_diri'         => $request->ket_keterbatasan_merawat_diri,            
            'lebih_6_jenis_obat'                    => $request->lebih_6_jenis_obat,
            'ket_lebih_6_jenis_obat'                => $request->ket_lebih_6_jenis_obat,            
            'kesulitan_mobilitas'                   => $request->kesulitan_mobilitas,
            'ket_kesulitan_mobilitas'               => $request->ket_kesulitan_mobilitas,            
            'memerlukan_alat_bantu'                 => $request->memerlukan_alat_bantu,
            'ket_memerlukan_alat_bantu'             => $request->ket_memerlukan_alat_bantu,            
            'memerlukan_pelayanan_medis'            => $request->memerlukan_pelayanan_medis,
            'ket_memerlukan_pelayanan_medis'        => $request->ket_memerlukan_pelayanan_medis,            
            'memerlukan_pelayanan_keperawatan'      => $request->memerlukan_pelayanan_keperawatan,
            'ket_memerlukan_pelayanan_keperawatan'  => $request->ket_memerlukan_pelayanan_keperawatan,            
            'memerlukan_bantuan_sehari_hari'        => $request->jememerlukan_bantuan_sehari_harinis_tt,
            'ket_memerlukan_bantuan_sehari_hari'    => $request->ket_memerlukan_bantuan_sehari_hari,            
            'sering_menggunakan_fasilitas_igd'      => $request->sering_menggunakan_fasilitas_igd,
            'ket_sering_menggunakan_fasilitas_igd'  => $request->ket_sering_menggunakan_fasilitas_igd,        
        ];

        AsesmenHeader::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $header // Data yang ingin diupdate atau dibuat
        );
        PemeriksaanFisikKeperawatan::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $pemeriksaanFisik // Data yang ingin diupdate atau dibuat
        );
        ErmRanapKeperawatan::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $asesmen // Data yang ingin diupdate atau dibuat
        );
        AsesmenResikoPd::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $asesmenResikoPD // Data yang ingin diupdate atau dibuat
        );
        AsesmenResikoPG::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $asesmenResikoPG // Data yang ingin diupdate atau dibuat
        );
        SkriningNutrisi::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $skriningNutrisi // Data yang ingin diupdate atau dibuat
        );
        AsesmenFungsional::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $asesmenFungsional // Data yang ingin diupdate atau dibuat
        );
        PerencanaanPulang::updateOrCreate(
            ['kode' => $kunjungan->kode_kunjungan], // Kondisi pencarian
            $perencanaanPulang // Data yang ingin diupdate atau dibuat
        );
        $ids        = $request->input('id_asuhan_keperawatan');
        $tanggal    = $request->input('tanggal_asuhan_keperawatan');
        $waktu      = $request->input('waktu_asuhan_keperawatan');
        $rencana    = $request->input('rencana_asuhan_keperawatan');
       
        for ($i = 0; $i < count($tanggal); $i++) {
            // Jika ada id yang valid, update, jika tidak, buat baru
            RencanaAsuhanKeperawatan::updateOrCreate(
                [
                    'id' => $ids[$i] ?? null // Kondisi pencarian
                ],
                [
                    'kode'              => $kunjungan->kode_kunjungan,
                    'rm'                => $kunjungan->no_rm,
                    'tanggal_rencana'   => $tanggal[$i],
                    'waktu_rencana'     => $waktu[$i],
                    'keterangan'        => $rencana[$i],
                    'pic_perawat'       => $pic_perawat,
                    'user_perawat'      => $user_perawat,
                ]
            );
        }

        Alert::success('Success', 'Asesmen Awal Keperawatan Disimpan');
        return redirect()->back();
    }

    public function printAsesmenAwalKeperawatan(Request $request)
    {
        $kunjungan          = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien             = $kunjungan->pasien;
        $skriningNyeri      = $kunjungan && $kunjungan->asesmen_ranap_keperawatan ? json_decode($kunjungan->asesmen_ranap_keperawatan->skrining_nyeri, true) : [];
        $diagnostikEdukasi  = $kunjungan && $kunjungan->asesmen_ranap_keperawatan ? json_decode($kunjungan->asesmen_ranap_keperawatan->diagnostik_edukasi, true) : [];
        
        $fisik              = PemeriksaanFisikKeperawatan::where('kode', $request->kode)->first();
        $sistemRespirasiOksigenasi  = $fisik ?json_decode($fisik->sistem_respirasi_oksigenasi, true) : [];
        $sistemKardioVaskuler       = $fisik ?json_decode($fisik->sistem_kardio_vaskuler, true):[];
        $sistemGastroIntestinal     = $fisik ?json_decode($fisik->sistem_gastro_intestinal, true):[];
        $sistemMuskuloSkeletal      = $fisik ?json_decode($fisik->sistem_muskulo_skeletal, true):[];
        $sistemNeurologi            = $fisik ?json_decode($fisik->sistem_neurologi, true):[];
        $sistemUrogenital           = $fisik ?json_decode($fisik->sistem_urogenital, true):[];
        $sistemIntegumen            = $fisik ?json_decode($fisik->sistem_integumen, true):[];
        $sistemHygiene              = $fisik ?json_decode($fisik->hyigiene, true):[];
        $sistemPsikobudaya          = $fisik ?json_decode($fisik->psikososial_budaya, true):[];
        $spiritualKepercayaan       = $fisik ?json_decode($fisik->spiritual_kepercayaan, true):[];

        $faktorResiko       = AsesmenResikoPd::where('kode', $request->kode)->first();
        $skriningResiko     = AsesmenResikoPG::where('kode', $request->kode)->first();
        $skriningNutrisi    = SkriningNutrisi::where('kode', $request->kode)->first();
        $skriningFungsional = AsesmenFungsional::where('kode', $request->kode)->first();
        $perencanaanPulang  = PerencanaanPulang::where('kode', $request->kode)->first();
        $rencanaAsuhan      = RencanaAsuhanKeperawatan::where('kode', $request->kode)->get();
        // dd($perencanaanPulang);
        $pdf = Pdf::loadView('simrs.erm-ranap.cetak_pdf.cetakan_asesmen_ranap_keperawatan', compact(
            'kunjungan', 'pasien','skriningNyeri','diagnostikEdukasi',
            'sistemRespirasiOksigenasi','sistemKardioVaskuler',
            'sistemGastroIntestinal',
            'sistemMuskuloSkeletal',
            'sistemNeurologi',
            'sistemUrogenital',
            'sistemIntegumen',
            'sistemHygiene',
            'sistemPsikobudaya',
            'spiritualKepercayaan',
            'faktorResiko',
            'skriningResiko',
            'skriningNutrisi',
            'skriningFungsional',
            'perencanaanPulang',
            'rencanaAsuhan'
        ));
        // return view('simrs.erm-ranap.cetak_pdf.cetakan_asesmen_ranap_keperawatan');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pdf_asesmen_ranap_awal.pdf');
    }
}
