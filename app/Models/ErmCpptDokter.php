<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmCpptDokter extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_cppt_dokter';
    protected $guarded = ['id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rm', 'no_rm');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }
    public function paramedis()
    {
        return $this->hasOne(Paramedis::class, 'kode_dokter_jkn', 'kodedokter');
    }

}
