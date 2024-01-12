<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JPasienIGD extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_jp_igd';
    protected $guarded = ['id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'rm', 'no_rm');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan', 'kode_kunjungan');
    }
}
