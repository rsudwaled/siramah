<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmenDokter extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'assesmen_dokters';
    protected $guarded = ["id"];
}
