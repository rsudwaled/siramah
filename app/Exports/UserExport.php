<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'google_id',
            'username',
            'password',
            'avatar',
            'avatar_original',
            'email_verified_at',
            'user_verify',
            'pic',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}
