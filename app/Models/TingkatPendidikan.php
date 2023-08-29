<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatPendidikan extends Model
{
    use HasFactory;
    protected $connection = 'mysql7';
    protected $table = 'mt_tingkat_pendidikan';
    protected $guarded = ["id_tingkat"];
}
