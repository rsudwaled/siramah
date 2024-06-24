<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiProvinsi extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mt_lokasi_provinces';
    protected $primaryKey = 'id';
}
