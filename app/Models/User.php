<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, MustVerifyEmail, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function verificator()
    {
        return $this->hasOne(User::class, 'id', 'user_verify');
    }
    public function adminlte_image()
    {
        if ($this->avatar) {
            return $this->avatar;
        } else {
            return asset('rsudwaled_icon_qrcode.png');
        }
    }
    public function userSimrs()
    {
        return $this->hasOne(UserSimrs::class, 'id', 'id_simrs');
    }
}
