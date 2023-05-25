<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paramedis extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_paramedis';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'kodedokter', 'kode_dokter_jkn');
    }

}
