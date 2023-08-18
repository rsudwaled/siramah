<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetControl extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_budget_control';
    protected $primaryKey = 'rm_counter';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [
        'id',
    ];
    // public $timestamps = false;
}
