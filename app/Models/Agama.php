<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_agama';
    protected $guarded = ["id"];
}
