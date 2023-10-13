<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spri extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_spri_igd';
    protected $fillable = [
        "noSPRI",
        "tglRencanaKontrol",
        "namaDokter",
        "noKartu",
        "nama",
        "kelamin",
        "tglLahir",
        "namaDiagnosa",

        "kodeDokter",
        "poliKontrol",
        "user",
    ];
}
