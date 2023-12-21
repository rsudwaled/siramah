<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmGroupping extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_groupping';
    protected $guarded = ['id'];


}
