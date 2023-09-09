<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluargaPasien extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_pasien_keluarga';
    protected $primaryKey = 'no_rm';
    public $timestamps = false;
    const CREATED_AT = 'input_date';
}
