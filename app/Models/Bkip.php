<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bkip extends Model
{
    use HasFactory;
    protected $connection = 'mysql9';
    protected $table = 'tb_fpk_vs_kunjungan';
    // protected $primaryKey = 'rm_counter';
    // public $incrementing = false;
    // protected $keyType = 'string';
    protected $guarded = [
        'id',
    ];
}
