<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResume extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_resume_pemulangan_pasien';
    protected $fillable = [
        'kode_kunjungan',
        'counter',
        'rm',
        'tgl_evaluasi',
        'waktu_evaluasi',
        'tgl_masuk',
        'jam_masuk',
        'ruang_rawat_masuk',
        'tgl_keluar',
        'jam_keluar',
        'ruang_rawat_keluar',
        'lama_rawat',
        'bb_bayi_lahir',
        'ringkasan_perawatan',
        'riwayat_penyakit',
        'indikasi_ranap',
        'pemeriksaan_fisik',
        'penunjang_lab',
        'penunjang_radiologi',
        'penunjang_lainnya',
        'hasil_konsultasi',
        'diagnosa_masuk',
        'diagnosa_utama',
        'diagnosa_utama_icd10',
        'diagnosa_utama_icd10_desc',
        'diagnosa_sekunder',
        'komplikasi',
        'tindakan_operasi',
        'tgl_operasi',
        'waktu_operasi_mulai',
        'waktu_operasi_selesai',
        'sebab_kematian',
        'tindakan_prosedure',
        'id_pengobatan_selama_rawat',
        'id_obat_untuk_pulang',
        'cara_keluar',
        'kondisi_pulang',
        'keadaan_umum',
        'kesadaran',
        'tekanan_darah',
        'nadi',
        'pengobatan_dilanjutkan',
        'tgl_kontrol',
        'lokasi_kontrol',
        'diet',
        'latihan',
        'keterangan_kembali',
        'a_1menit',
        'ap_1menit',
        'apg_1menit',
        'apga_1menit',
        'apgar_1menit',
        'total_apgar_1menit',
        'a_5menit',
        'ap_5menit',
        'apg_5menit',
        'apga_5menit',
        'apgar_5menit',
        'total_apgar_5menit',
        'grafida',
        'pemeriksaan_shk_ya',
        'pemeriksaan_shk_tidak',
        'diambil_dari_tumit',
        'diambil_dari_vena',
        'tgl_pengambilan_shk',
        'tgl_cetak',                 
        'dpjp',
        'kode_dokter',
        'status_resume',
        'revisi_resume',
        'user'
    ];

    public function kunjungan()
    {
        return $this->hasOne(Kunjungan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'no_rm', 'rm');
    }
    public function ttddokter()
    {
        return $this->hasOne(TtdDokter::class,  'id', 'ttd_dokter');
    }
    public function ttdkeluarga()
    {
        return $this->hasOne(TtdDokter::class,  'id', 'ttd_keluarga');
    }
}
