<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanKerja extends Model
{
    use HasFactory;
    protected $connection = 'mysql7';
    protected $table = 'mt_jabatan';
    protected $guarded = ["id_jabatan"];
}
