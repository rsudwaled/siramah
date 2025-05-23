<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResumeDiagSekunder extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection   = 'mysql2';
    protected $table        = 'erm_ranap_resume_diag_sekunder';
    protected $fillable     = [
        'kode',
        'kode_diagnosa',
        'diagnosa',
        'rm',
        'kunjungan_counter',
        'id_resume',
        'user',
    ];

    protected $dates = ['deleted_at'];
    public function ermRanapResume()
    {
        return $this->belongsTo(ErmRanapResume::class, 'id_resume', 'id');
    }
}
