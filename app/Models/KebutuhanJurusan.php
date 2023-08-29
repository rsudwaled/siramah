<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanJurusan extends Model
{
    use HasFactory;
    protected $connection = 'mysql7';
    protected $table = 'mt_jurusan_kebutuhan';
    protected $guarded = ["id"];
}
