<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanapPengajuanPembukaanFormResume extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_pengajuan_pembukaan_form_resume';
    protected $guarded = ['id'];
    protected $fillable     = [
        'id_resume',
        'keterangan',
        'pemohon',
        'status_aproval',
    ];
}
