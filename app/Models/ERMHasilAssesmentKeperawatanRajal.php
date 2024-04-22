<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ERMHasilAssesmentKeperawatanRajal extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'erm_hasil_assesmen_keperawatan_rajal';
    protected $guarded = ['id'];
}
