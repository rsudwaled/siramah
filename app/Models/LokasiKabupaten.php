<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKabupaten extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mt_lokasi_regencies';
    protected $primaryKey = 'id';

    public function provinsi()
    {
        return $this->hasOne(LokasiProvinsi::class,'id','province_id');
    }
}
