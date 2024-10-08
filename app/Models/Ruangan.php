<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_ruangan';
    protected $guarded = ['id_ruangan'];
    //baru ditambahkan
    protected $primaryKey = 'id_ruangan';

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit',   'kode_unit');
    }
}
