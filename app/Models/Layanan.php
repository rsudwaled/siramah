<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_layanan_header';
    protected $guarded = ['id'];
}
