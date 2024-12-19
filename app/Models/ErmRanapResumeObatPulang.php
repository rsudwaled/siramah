<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResumeObatPulang extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_resume_pemulangan_obat_pulang';
    protected $guarded = ['id'];
    protected $fillable = [
        'kunjungan_counter',
        'rm',
        'nama_obat',
        'jumlah',
        'dosis',
        'frekuensi',
        'cara_pemberian',
        'id_resume',
    ];

}
