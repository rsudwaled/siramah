<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResumeTindakanOperasiCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_resume_tindakan_operasi';
    protected $fillable     = [
        'id_resume',
        'kode',
        'rm',
        'kunjungan_counter',
        'kode_tindakan',
        'nama_tindakan',
        'user',
    ];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function ermRanapResume()
    {
        return $this->belongsTo(ErmRanapResume::class, 'id', 'id_resume');
    }
}
