<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanap extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_resume';
    protected $guarded = ['id'];

    public function kunjungan()
    {
        return $this->hasOne(Kunjungan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'no_rm', 'norm');
    }
}
