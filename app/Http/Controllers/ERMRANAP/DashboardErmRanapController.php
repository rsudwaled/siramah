<?php

namespace App\Http\Controllers\ERMRANAP;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\BudgetControl;
use App\Models\AsesmenDokterRajal;
use App\Models\AsesmenRanap;
use App\Models\PerkembanganPasien;
use App\Models\Kunjungan;
use App\Models\AsesmenHeader;
use App\Models\ErmRanapKonsultasiDokter;
use App\Models\ErmRanapMppa;
use App\Models\FileRekamMedis;
use App\Models\FileUpload;

class DashboardErmRanapController extends Controller
{
    private function getKunjunganAndPasien($kode)
    {
        $kunjungan = Kunjungan::with([
            'dokter',
            'asesmen_ranap',
        ])->firstWhere('kode_kunjungan', $kode);
        $pasien = $kunjungan->pasien;
        $perkembangan       = PerkembanganPasien::where('kode_kunjungan', $kode)->get();
        return compact('kunjungan', 'pasien', 'perkembangan');
    }

    public function dashboardERMRanap(Request $request)
    {
        $akses  =   Auth::user()->roles->first()->name;
        $kunjungan = Kunjungan::with([
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'alasan_pulang',
            'surat_kontrol',
            'groupping',
            'erm_ranap',
            'asesmen_ranap',
            'asuhan_terpadu',
            'asesmen_ranap_keperawatan',
            'mppa'
        ])->firstWhere('kode_kunjungan', $request->kode);
        
        $riwayatKunjungan = Kunjungan::with('unit')
            ->where('no_rm', $kunjungan->no_rm)
            ->orderBy('counter', 'desc')
            ->get();
        $pasien     = $kunjungan->pasien;
        $header     = AsesmenHeader::where('kode', $request->kode)->first();
        $response   = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','','')"));
        $grandTotal = $response->sum("GRANTOTAL_LAYANAN");

        if($akses ==='Dokter')
        {
            return view('simrs.erm-ranap.dashboard_erm_ranap', compact('kunjungan','pasien','grandTotal','header','riwayatKunjungan'));
        }else{
            return view('simrs.erm-ranap.dashboard_erm_ranap_perawat', compact('kunjungan','pasien','grandTotal','riwayatKunjungan'));
        }
    }
    public function get_rincian_biaya(Request $request)
    {
        $response = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $request->norm . "','" . $request->counter . "','','')"));
        $budget = BudgetControl::find($request->norm . '|' . $request->counter);
        $data = [
            "groupping" =>  $budget ? 'true' : 'false',
            "budget" => $budget ?? null,
            "rincian" => $response,
            "rangkuman" => [
                "tarif_rs" => round($response->sum("GRANTOTAL_LAYANAN")),
                "prosedur_non_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE NON BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "prosedur_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "tenaga_ahli" => round($response->where('nama_group_vclaim', "TENAGA AHLI")->sum("GRANTOTAL_LAYANAN")),
                "radiologi" => round($response->where('nama_group_vclaim', "RADIOLOGI")->sum("GRANTOTAL_LAYANAN")),
                "laboratorium" => round($response->where('nama_group_vclaim', "LABORATORIUM")->sum("GRANTOTAL_LAYANAN")),
                "rehabilitasi" => round($response->where('nama_group_vclaim', "REHABILITASI MEDIK")->sum("GRANTOTAL_LAYANAN")),
                "sewa_alat" => round($response->where('nama_group_vclaim', "SEWA ALAT")->sum("GRANTOTAL_LAYANAN")),
                "keperawatan" => round($response->where('nama_group_vclaim', "KEPERAWATAN")->sum("GRANTOTAL_LAYANAN")),
                "kamar_akomodasi" => round($response->where('nama_group_vclaim', "KAMAR/AKOMODASI")->sum("GRANTOTAL_LAYANAN")),
                "penunjang" => round($response->where('nama_group_vclaim', "PENUNJANG MEDIS")->sum("GRANTOTAL_LAYANAN")),
                "konsultasi" => round($response->where('nama_group_vclaim', "KONSULTASI")->sum("GRANTOTAL_LAYANAN")),
                "pelayanan_darah" => round($response->where('nama_group_vclaim', "PELAYANAN DARAH")->sum("GRANTOTAL_LAYANAN")),
                "rawat_intensif" => round($response->where('nama_group_vclaim', "RAWAT INTENSIF")->sum("GRANTOTAL_LAYANAN")),
                "obat" => round($response->where('nama_group_vclaim', "OBAT")->sum("GRANTOTAL_LAYANAN")),
                "alkes" => round($response->where('nama_group_vclaim', "ALKES")->sum("GRANTOTAL_LAYANAN")),
                "bmhp" => round($response->where('nama_group_vclaim', "BMHP")->sum("GRANTOTAL_LAYANAN")),
                "obat_kronis" => round($response->where('nama_group_vclaim', "OBAT KRONIS")->sum("GRANTOTAL_LAYANAN")),
                "obat_kemo" => round($response->where('nama_group_vclaim', "OBAT KEMOTERAPI")->sum("GRANTOTAL_LAYANAN")),
            ],
        ];
        $data = json_decode(json_encode($data));
        return view('simrs.erm-ranap.rincian_biaya', compact('data'));
    }
    public function assesmenAwalMedis(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'dokter',
            'asesmen_ranap',
            'unit'
        ])->firstWhere('kode_kunjungan', $request->kode);
        $pasien         = $kunjungan->pasien;
        $assesmen       = AsesmenRanap::where('kode_kunjungan',$request->kode)->first();
        $header         = AsesmenHeader::where('kode', $request->kode)->first();
        return view('simrs.erm-ranap.dokter.assesmen_awal_medis', compact('kunjungan','pasien','assesmen','header'));
    }

    public function assesmenKebutuhanEdukasi()
    {
        return view('simrs.erm-ranap.dokter.kebutuhan_edukasi');
    }

    public function konsultasi(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'dokter',
            'asesmen_ranap',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $perkembangan   = PerkembanganPasien::where('kode_kunjungan',$request->kode)->get();
        $konsultasi     = ErmRanapKonsultasiDokter::where('kode',$request->kode)->get();
        return view('simrs.erm-ranap.dokter.cppt_konsultasi.cppt_konsultasi', compact('kunjungan','perkembangan','konsultasi'));
    }

    public function assesmenPraAnastesi()
    {
        return view('simrs.erm-ranap.dokter.assesmen_pra_anastesi');
    }

    public function informasiTindakan()
    {
        return view('simrs.erm-ranap.dokter.informasi_tindakan');
    }

    public function catatanMPPA(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        $mppa = ErmRanapMppa::where('kode', $request->kode)->first();
        return view('simrs.erm-ranap.dokter.catatan_mppa', [
            'data' => $data,
            'mppa' => $mppa,
        ]);
    }

    public function catatanMPPAStore(Request $request)
    {
        $data = [
            'tgl_evaluasi'                      => $request->tgl_evaluasi,
            'waktu_evaluasi'                    => $request->waktu_evaluasi,
            'kode'                              => $request->kode,
            'rm'                                => $request->rm_pasien,
            'skrining_pasien'                   => $request->skrining_pasien,
            'asesmen_fisik'                 => json_encode([
               'mandiri_penuh'              => $request->has('mandiri_penuh') ? 'on' : 'off',
               'mandiri_sebagian'           => $request->has('mandiri_sebagian') ? 'on' : 'off',
               'total_bantuan_lainnya'      => $request->has('total_bantuan_lainnya') ? 'on' : 'off',
               'keterangan_bantuan_fisik'   => $request->keterangan_bantuan_fisik,
            ]),
            'riwayat_kesehatan'                 => $request->riwayat_kesehatan_mppa,
            'perilaku_psiko_spiritual'          => $request->perilaku_psikososialkultur_mppa,
            'kesehatan_mental'                  => $request->kesehatan_mental_kognitif_mppa,
            'lingkungan_tt'                     => $request->lingkungan_tempat_tinggal_mppa,
            'dukungan_keluarga'                 => $request->has('dukungan_merawat_tidak') ? 'on' : 'off',
            'finansial'                     => json_encode([
                'finansial_baik_mppa'       => $request->has('finansial_baik_mppa') ? 'on' : 'off',
                'finansial_sedang_mppa'     => $request->has('finansial_sedang_mppa') ? 'on' : 'off',
                'finansial_kurang_mppa'     => $request->has('finansial_kurang_mppa') ? 'on' : 'off',
            ]),
            'jaminan'                       => json_encode([
                'jaminan_pribadi_mppa'      => $request->has('jaminan_pribadi_mppa') ? 'on' : 'off',
                'jaminan_asuransi_mppa'     => $request->has('jaminan_asuransi_mppa') ? 'on' : 'off',
                'jaminan_jknbpjs_mppa'      => $request->has('jaminan_jknbpjs_mppa') ? 'on' : 'off',
            ]),
            'riwayat_penggunaan_obat'       => json_encode([
                'obat_alternatif'           => $request->has('obat_alternatif') ? 'on' : 'off',
                'obat_alternatif'           => $request->has('obat_alternatif') ? 'on' : 'off',
                'riwayat_obat_alternatif'   => $request->riwayat_obat_alternatif,
            ]),
            'riwayat_trauma'                =>json_encode([
                'tidak_trauma_kekerasan'    => $request->has('tidak_trauma_kekerasan') ? 'on' : 'off',
                'ada_trauma_kekerasan'      => $request->has('ada_trauma_kekerasan') ? 'on' : 'off',
            ]),
            'pemahaman_kesehatan'               => json_encode([
                'tahu_pemahaman_kesehatan'      => $request->has('tahu_pemahaman_kesehatan') ? 'on' : 'off',
                'tidak_tahu_pemahaman_kesehatan'=> $request->has('tidak_tahu_pemahaman_kesehatan') ? 'on' : 'off',
            ]),
            'harapan_terhadap_hasil'                => json_encode([
                'ada_harapan_terhadap_hasil'        => $request->has('ada_harapan_terhadap_hasil') ? 'on' : 'off',
                'tidak_ada_harapan_terhadap_hasil'  => $request->has('tidak_ada_harapan_terhadap_hasil') ? 'on' : 'off',
            ]),
            'perkiraaan_lama_rawat'             => $request->perkiraan_lama_dirawat_mppa,
            'discharger_plan'                   => json_encode([
                'tidak_discharge_plan'          => $request->has('tidak_discharge_plan') ? 'on' : 'off',
                'ada_discharge_plan'            => $request->has('ada_discharge_plan') ? 'on' : 'off',
                'keterangan_discharge_plan'     => $request->keterangan_discharge_plan,
            ]),
            'perencanaan_lanjutan'              => json_encode([
                'rencana_lanjutan_home_care'    => $request->has('rencana_lanjutan_home_care') ? 'on' : 'off',
                'rencana_lanjutan_pengobatan'   => $request->has('rencana_lanjutan_pengobatan') ? 'on' : 'off',
                'rencana_lanjutan_rujuk'        => $request->has('rencana_lanjutan_rujuk') ? 'on' : 'off',
                'rencana_lanjutan_komunitas'    => $request->has('rencana_lanjutan_komunitas') ? 'on' : 'off',
            ]),
            'aspek_legal'                       => json_encode([
                'aspek_legal_ada'              => $request->has('aspek_legal_ada') ? 'on' : 'off',
                'aspek_legal_tidak_ada'        => $request->has('aspek_legal_tidak_ada') ? 'on' : 'off',
                'keterangan_aspek_legal'       => $request->keterangan_aspek_legal,
            ]),
            'identifikasi_masalah'              => json_encode([
                'tidak_sesuai_dg_cp_ppk'                            => $request->has('tidak_sesuai_dg_cp_ppk') ? 'on' : 'off',
                'adanya_komplikasi'                                 => $request->has('adanya_komplikasi') ? 'on' : 'off',
                'pemahaman_pasien_kurang_untuk_kondisi_terkini'     => $request->has('pemahaman_pasien_kurang_untuk_kondisi_terkini') ? 'on' : 'off',
                'ketidakpatuhan_pasien_pasien_kendala_keuangan'     => $request->has('ketidakpatuhan_pasien_pasien_kendala_keuangan') ? 'on' : 'off',
                'terjadi_konflik'                                   => $request->has('terjadi_konflik') ? 'on' : 'off',
                'pemulangan_belum_memenuhi_kriteria'                => $request->has('pemulangan_belum_memenuhi_kriteria') ? 'on' : 'off',
                'tindakan_pengobatan_tertunda'                      => $request->has('tindakan_pengobatan_tertunda') ? 'on' : 'off',
            ]),
            'kebutuhan_asuhan'                  => $request->has('kebutuhan_asuhan') ? 'on' : 'off',
            'kebutuhan_edukasi'                 => $request->has('kebutuhan_edukasi') ? 'on' : 'off',
            'solusi_konflik'                    => $request->has('solusi_konflik') ? 'on' : 'off',
            'diagnosis'                         => $request->has('diagnosis') ? 'on' : 'off',
            'perencanaan_mpp_jangka_pendek'     => $request->perencanaan_mpp_jangka_pendek,
            'perencanaan_mpp_jangka_panjang'    => $request->perencanaan_mpp_jangka_panjang,
            'perencanaan_mpp_kebutuhan_berjalan'=> $request->perencanaan_mpp_kebutuhan_berjalan,
            'perencanaan_mpp_lainnya'           => $request->perencanaan_mpp_lain_lain,
        ];
        ErmRanapMppa::updateOrCreate(
            ['kode' => $data['kode']], // Kondisi pencarian
            $data // Data yang ingin diupdate atau dibuat
        );
        return back();
    }

    public function catatanMPPB(Request $request)
    {
        $data = $this->getKunjunganAndPasien($request->kode);
        return view('simrs.erm-ranap.dokter.catatan_mppb',$data);
    }

    // versi 1.1
    public function getRiwayatDetails($kode_kunjungan)
    {
        $riwayatKunjungan = Kunjungan::with(['unit'])
        ->where('kode_kunjungan', $kode_kunjungan)
        ->orderBy('counter', 'desc')
        ->get();
        $kunjungan = Kunjungan::where('kode_kunjungan', $kode_kunjungan)->first();
        $asesmenRajal = AsesmenDokterRajal::where('id_kunjungan',$kode_kunjungan)->get();
        // Koleksi untuk menyimpan obat dan tindakan
        // $semuaObat = collect();
        $semuaTindakan = collect();

        // Ambil data asesmen menggunakan DB query
        foreach ($riwayatKunjungan as $riwayat) {
            $asesmen = \DB::connection('mysql2')->select('CALL RINCIAN_BIAYA_FINAL(?, ?, ?, ?)', [
                $riwayat->no_rm,
                $riwayat->counter,
                '',
                '',
            ]);

            // Pisahkan data berdasarkan kelompok tarif
            // $obat = collect($asesmen)->where('KELOMPOK_TARIF', 'Obat & Bhp');
            $tindakan = collect($asesmen)->where('KELOMPOK_TARIF', 'Tindakan Medis');

            // Gabungkan data obat ke dalam koleksi semuaObat
            // if ($obat->isNotEmpty()) {
            //     $semuaObat = $semuaObat->merge($obat->map(function ($item) use ($riwayat) {
            //         return [
            //             'NAMA_TARIF' => $item->NAMA_TARIF,
            //             'kode_kunjungan' => $riwayat->kode_kunjungan, // Tambahkan kode_kunjungan ke setiap obat
            //         ];
            //     }));
            // }

            // Gabungkan data tindakan ke dalam koleksi semuaTindakan
            if ($tindakan->isNotEmpty()) {
                $semuaTindakan = $semuaTindakan->merge($tindakan->map(function ($item) use ($riwayat) {
                    return [
                        'NAMA_TARIF' => $item->NAMA_TARIF,
                        'kode_kunjungan' => $riwayat->kode_kunjungan, // Tambahkan kode_kunjungan ke setiap tindakan
                    ];
                }));
            }
        }
        $riwayatObat = DB::connection('mysql2')->select("CALL SP_HISTORY_RESEP_PASIEN_PERKUNJUNGAN_hadid('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','".$kunjungan->kode_unit."')");
        return response()->json([
            'tindakan' => $semuaTindakan,
            'obat' => $riwayatObat,
            'asesmenRajal'=>$asesmenRajal
        ]);

    }

    public function getBerkasFile(Request $request)
    {
        $files      = FileRekamMedis::where('norm', $request->no_rm)->get();
        $fileUpload = FileUpload::where('no_rm', $request->no_rm)->get();
        return response()->json([
            'files' => $files,
            'fileUpload' => $fileUpload,
        ]);
    }

}
