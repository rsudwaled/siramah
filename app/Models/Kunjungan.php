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
    public $incrementing = false;
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
    ];
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
    public function dokter()
    {
        return $this->belongsTo(Paramedis::class, 'kode_paramedis', 'kode_paramedis');
    }
    public function layanan()
    {
        return $this->hasOne(Layanan::class, 'kode_kunjungan', 'kode_kunjungan');
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

    protected $appends = ['nama_pasien'];
    public function getNamaPasienAttribute()
    {
        $pasien = Pasien::firstWhere('no_rm', $this->no_rm);
        if (isset($pasien)) {
            $pasien = $pasien->nama_px;
        } else {
            $pasien = '';
        }
        return $pasien;
    }
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
