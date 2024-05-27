<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDoctor extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'salary_doctor';
    protected $fillable = [
        'tanggal_start',
        'tanggal_finish',
        'totalVisit',
        'totalSalary',
        'status_salary',
        'code_paramedis',
        'doctor',
    ];
}
