<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_icd10';
    protected $guarded = ['diag'];
}
