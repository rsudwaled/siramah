<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKunjungan extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'mt_status_kunjungan';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [];

    public function kunjungans()
    {
        return $this->hasMany(KunjunganDB::class, 'status_kunjungan', 'ID');
    }
}
