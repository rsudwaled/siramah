<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_provinsi';
    protected $primaryKey = 'kode_provinsi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ["id"];
}
