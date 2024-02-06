<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_kunjungan';
    protected $primaryKey = 'kode_kunjungan';
    // public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'counter',
        'no_rm',
        'kode_unit',
        'tgl_masuk',
        'kode_paramedis',
        'status_kunjungan',
        'prefix_kunjungan',
        'kode_penjamin',
        'pic',
        'id_alasan_masuk',
        'pic2',
        'kelas',
        'hak_kelas',
        'no_sep',
        'no_rujukan',
        'diagx',
        'created_at',
        'keterangan2',
        'lakalantas',
        'is_ranap_daftar',
        'form_send_by',
        'jp_daftar',
        'perujuk',
        'no_spri',
        'id_alasan_edit',
    ];
    protected $appends = ['rm_counter'];
    public function getRmCounterAttribute()
    {
        return $this->no_rm . '|' . $this->counter;
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rm', 'no_rm');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }
    public function status()
    {
        return $this->belongsTo(StatusKunjungan::class,   'status_kunjungan', 'ID',);
    }
    public function penjamin()
    {
        return $this->hasOne(Penjamin::class, 'kode_penjamin_simrs', 'kode_penjamin');
    }
    public function penjamin_simrs()
    {
        return $this->hasOne(PenjaminSimrs::class, 'kode_penjamin', 'kode_penjamin');
    }
    public function diagnosapoli()
    {
        return $this->hasOne(DiagnosaPoli::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function diagnosaicd()
    {
        return $this->hasOne(DiagnosaICD::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function dokter()
    {
        return $this->belongsTo(Paramedis::class, 'kode_paramedis', 'kode_paramedis');
    }
    public function assesmen_dokter()
    {
        return $this->hasOne(AssesmenDokter::class, 'id_kunjungan', 'kode_kunjungan');
    }
    public function assesmen_perawat()
    {
        return $this->hasOne(AsesmenPerawat::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function layanan()
    {
        return $this->hasOne(Layanan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function layanans()
    {
        return $this->hasMany(Layanan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap()
    {
        return $this->hasOne(ErmRanap::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function groupping()
    {
        return $this->hasOne(ErmGroupping::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap_mppa()
    {
        return $this->hasOne(ErmRanapMppa::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap_mppb()
    {
        return $this->hasOne(ErmRanapMppb::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap_keperawatan()
    {
        return $this->hasMany(ErmRanapKeperawatan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap_observasi()
    {
        return $this->hasMany(ErmRanapObservasi::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function erm_ranap_perkembangan()
    {
        return $this->hasMany(ErmRanapPerkembangan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function antrian()
    {
        return $this->belongsTo(Antrian::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function surat_kontrol()
    {
        return $this->hasOne(SuratKontrol::class, 'noSepAsalKontrol', 'no_sep');
    }
    public function alasan_masuk()
    {
        return $this->hasOne(AlasanMasuk::class, 'id', 'id_alasan_masuk');
    }
    public function alasan_pulang()
    {
        return $this->hasOne(AlasanPulang::class, 'kode', 'id_alasan_pulang');
    }
    public function tracer()
    {
        return $this->hasOne(Tracer::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function budget()
    {
        return $this->belongsTo(BudgetControl::class, 'rm_counter',   'rm_counter');
    }
    public function tagihan()
    {
        return $this->belongsTo(TagihanPasien::class, 'rm_counter',   'rm_counter');
    }
    public function ruanganRawat()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan',   'id_ruangan');
    }
    public function ermCpptDokter()
    {
        return $this->belongsTo(ErmCpptDokter::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function jpDaftar()
    {
        return $this->belongsTo(JPasienIGD::class, 'kode_kunjungan', 'kunjungan');
    }
    public function diagnosaIGD()
    {
        return $this->belongsTo(Icd10::class, 'diagx', 'diag');
    }
    public function alasanEdit()
    {
        return $this->belongsTo(MtAlasanEdit::class, 'id_alasan_edit', 'id');
    }
    public function pasienKecelakaan()
    {
        return $this->belongsTo(PasienKecelakaan::class, 'kode_kunjungan', 'kode_kunjungan');
    }

    // protected $appends = ['nama_pasien'];
    // public function getNamaPasienAttribute()
    // {
    //     $pasien = Pasien::firstWhere('no_rm', $this->no_rm);
    //     if (isset($pasien)) {
    //         $pasien = $pasien->nama_px;
    //     } else {
    //         $pasien = '';
    //     }
    //     return $pasien;
    // }
    // public function getNamaPenjaminAttribute()
    // {
    //     if (isset($this->kode_penjamin)) {
    //         $penjamin = PenjaminSimrs::firstWhere('kode_penjamin', $this->kode_penjamin)->nama_penjamin;
    //     } else {
    //         $penjamin = '';
    //     }
    //     return $penjamin;
    // }
}
