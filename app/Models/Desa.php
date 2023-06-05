<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_desa_kelurahan';
    protected $primaryKey = 'kode_desa_kelurahan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ["id"];
}
