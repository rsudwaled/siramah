<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErmRanapPerkembangan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_ranap_perkembangan';
    protected $guarded = ['id'];
}
