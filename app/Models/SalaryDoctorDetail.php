<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDoctorDetail extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'salary_doctor_detail';
    protected $fillable = [
        'id_layanan_detail',
        'id_salary_doctor',
        'pelayan',
        'rm',
        'nama_pasien',
        'kode_unit',
        'unit',
        'kelompok',
        'tanggal',
        'nama_tarif',
        'jumlah_visit',
        'salary_pervisit',
        'cara_bayar',
        'nama_penjamin',
    ];
}
