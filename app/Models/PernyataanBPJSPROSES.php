<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PernyataanBPJSPROSES extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'sp_bpjs_proses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_rm',
        'nama_keluarga',
        'alamat_keluarga',
        'kontak',
        'tgl_batas_waktu',
        'status_proses',
    ];
    
}
