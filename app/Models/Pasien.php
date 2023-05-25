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
    public $timestamps = false;
    const CREATED_AT = 'tgl_entry';
    // const UPDATED_AT = 'last_update';

    protected $guarded = ["id"];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'no_rm', 'no_rm');
    }
    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'norm', 'no_rm');
    }
    public function kecamatans()
    {
        return $this->hasOne(Kecamatan::class, 'kode_kecamatan', 'kecamatan');
    }
    public function kabupatens()
    {
        return $this->hasOne(Kecamatan::class, 'kode_kecamatan', 'kecamatan');
    }
}
