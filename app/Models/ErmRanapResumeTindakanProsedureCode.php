<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResumeTindakanProsedureCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_resume_tindakan_prosedure';
    protected $fillable     = [
        'id_resume',
        'kode',
        'rm',
        'kunjungan_counter',
        'kode_procedure',
        'nama_procedure',
        'user',
    ];

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function ermRanapResume()
    {
        return $this->belongsTo(ErmRanapResume::class, 'id', 'id_resume');
    }
}
