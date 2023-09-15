<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuanganTerpilihIGD extends Model
{
    use HasFactory;
    protected $connection = 'mysql8';
    protected $table = 'ruangan_terpilih_igd';
    protected $fillable = [
        'ruangan_id',
        'pasien_id',
        'tgl_masuk',
    ];
    
}
