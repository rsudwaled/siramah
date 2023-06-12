<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'jkn_jadwal_dokter';
    protected $guarded = ['id'];

    public function antrians()
    {
        return $this->hasMany(Antrian::class,  'kodepoli', 'kodesubspesialis');
    }

}
