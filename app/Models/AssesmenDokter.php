<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmenDokter extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'assesmen_dokters';
    protected $guarded = ["id"];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'no_rm');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'id_kunjungan', 'id_kunjungan');
    }

}
