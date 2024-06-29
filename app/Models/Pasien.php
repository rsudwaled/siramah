<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_pasien';
    protected $primaryKey = 'no_rm';
    // protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    const CREATED_AT = 'tgl_entry';
    const UPDATED_AT = 'update_date';
    protected $guarded = ["id"];
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'no_rm', 'no_rm');
    }
    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'norm', 'no_rm');
    }
    public function desas()
    {
        return $this->hasOne(Desa::class,'kode_desa_kelurahan','kode_desa');
    }
    public function kecamatans()
    {
        return $this->hasOne(Kecamatan::class, 'kode_kecamatan', 'kecamatan');
    }
    public function kabupatens()
    {
        return $this->hasOne(Kabupaten::class, 'kode_kabupaten_kota', 'kabupaten');
    }
    public function hubunganKeluarga()
    {
        return $this->belongsTo(KeluargaPasien::class,'no_rm','no_rm');
    }

    public function lokasiDesa()
    {
        return $this->hasOne(LokasiDesa::class,'id','kode_desa');
    }
    public function lokasiKecamatan()
    {
        return $this->hasOne(LokasiKecamatan::class,  'id','kecamatan');
    }
    public function lokasiKabupaten()
    {
        return $this->hasOne(LokasiKabupaten::class,  'id','kabupaten');
    }
    public function lokasiProvinsi()
    {
        return $this->hasOne(LokasiProvinsi::class,  'id','propinsi');
    }
}
