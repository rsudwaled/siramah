<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_unit';
    protected $primaryKey = 'kode_unit';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [
        'id',
    ];
    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class, 'kode_unit', 'kode_unit');
    }
    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'kodepoli', 'KDPOLI');
    }
    public function lokasi()
    {
        return $this->hasOne(LokasiUnit::class, 'kode_unit', 'kode_unit');
    }
    public function poliklinik()
    {
        return $this->hasOne(Poliklinik::class, 'kodesubspesialis', 'KDPOLI');
    }
}
