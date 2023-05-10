<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiUnit extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_lokasi_unit';
    public $timestamps = false;

    protected $fillable = [
        'kode_unit',
        'lokasi',
        'loket',
    ];
}
