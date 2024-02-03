<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paramedis extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_paramedis';
    protected $primaryKey = 'kode_paramedis';
    public $incrementing = false;
    public $timestamps = false;
    // const CREATED_AT = 'input_date';
    protected $guarded = ['id'];

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'kodedokter', 'kode_dokter_jkn');
    }
}
