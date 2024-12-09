<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SepVerifDownloader extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_sep_verif';
    protected $primaryKey = 'idx';
}
