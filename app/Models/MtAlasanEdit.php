<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtAlasanEdit extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'mt_alasan_edit';
    protected $guarded = ['id'];


}
