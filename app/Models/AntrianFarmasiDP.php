<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianFarmasiDP extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_antrian_farmasi';
    protected $fillable = [
        'nomor_antrian',
        'rm',
        'jenis_antrian',
        'kode_unit',
        'unit_pengirim',
        'kode_kunjungan',
        'status_antrian',
        'tgl_antrian',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'rm');
    }
}
