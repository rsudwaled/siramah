<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPasien extends Model
{
    use HasFactory;

    protected $connection = 'mysql6';
    protected $table = 'ts_tagihan_pasien';
    protected $primaryKey = 'rm_counter';
    public $incrementing = false;
    protected $keyType = 'string';

}
