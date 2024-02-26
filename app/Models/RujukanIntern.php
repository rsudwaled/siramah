<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RujukanIntern extends Model
{
    use HasFactory;
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'tx_rujukan_intern';
    protected $guarded = ['id'];
}