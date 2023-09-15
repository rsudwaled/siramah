<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_hub_keluarga';
    protected $primaryKey = 'kode';
    // public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ["id"];
}
