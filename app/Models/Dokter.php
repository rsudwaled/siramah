<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function paramedis()
    {
        return $this->hasOne(Paramedis::class, 'kode_dokter_jkn', 'kodedokter');
    }
}
