<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPasienKecelakaan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'temp_pasien_kecelakaan';
    protected $fillable = [
        'rm',
        'nama',
        'jk',
    ];
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'rm');
    }
}
