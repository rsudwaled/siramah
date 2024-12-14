<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanapResumeDiagSekunder extends Model
{
    use HasFactory;
    
    protected $connection   = 'mysql2';
    protected $table        = 'erm_ranap_resume_diag_sekunder';
    protected $fillable     = [
        'kode',
        'diagnosa',
        'rm',
        'kunjungan_counter',
        'id_resume',
    ];

}
