<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $connection = 'mysql5';
    protected $table = 'ts_surat_masuk';
    protected $primaryKey = 'id_surat_masuk';

    protected $guarded = ['id_surat_masuk'];


    public function lampiran()
    {
        return $this->hasOne(SuratLampiran::class, 'surat_id', 'id_surat_masuk');
    }

    // public function setTindakanAttribute($value)
    // {
    //     return $this->attributes['tindakan'] = json_decode($value);
    // }

    public function getTindakanAttribute($value)
    {
        return $this->attributes['tindakan'] = json_decode($value);
    }
}
