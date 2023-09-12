<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluargaPasien extends Model
{
    use HasFactory;
    protected $connection = 'mysql9';
    protected $table = 'mt_pasien_keluarga';
    // protected $primaryKey = 'no_rm';
    protected $fillable = ['no_rm','nama_keluarga','hubungan_keluarga','alamat_keluarga','tlp_keluarga','input_date','Update_date'];
    public $timestamps = false;
    const CREATED_AT = 'input_date';
}
