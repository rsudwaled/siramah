<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeBarang extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_tipe_barang';
    protected $guarded = ["kode_tipe"];
    protected $primaryKey = 'kode_tipe';
    public $incrementing = false;
    public $timestamps = false;
}
