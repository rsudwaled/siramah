<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriesIGDBPJS extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mt_histories_igd_bpjs';
}
