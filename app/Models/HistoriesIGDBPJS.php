<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriesIGDBPJS extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mt_histories_igd_bpjs';
    protected $primaryKey = 'kode_kunjungan';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_kunjungan',
        'noAntrian',
        'noMR',
        'noKartu',
        'tglSep',
        'ppkPelayanan',
        'jnsPelayanan',
        'klsRawatHak', 
        'klsRawatNaik', 
        'pembiayaan', 
        'penanggungJawab',
        'asalRujukan',
        'tglRujukan',
        'noRujukan',
        'ppkRujukan',
        'diagAwal',
        'lakaLantas',
        'noLP',
        'tglKejadian',
        'keterangan',
        'kdPropinsi',
        'kdKabupaten',
        'kdKecamatan',
        'dpjpLayan',
        'noTelp',
        'user',
        'response',
        'is_bridging',
        'is_ranap_umum',
        'status_daftar',
        
    ];

    protected $casts = [
        'response' => 'string',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'noMR', 'no_rm');
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
    public function dokter()
    {
        return $this->belongsTo(Paramedis::class, 'kode_paramedis', 'kode_paramedis');
    }
    public function layanan()
    {
        return $this->hasOne(Layanan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function assesmen_dokter()
    {
        return $this->hasOne(AssesmenDokter::class, 'id_kunjungan', 'kode_kunjungan');
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
}
