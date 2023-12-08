<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            User::updateOrCreate(
                [
                    'username' => $row['username'],
                ],
                [
                    'email' => $row['email'],
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                    'google_id' => $row['google_id'],
                    'password' => $row['password'] ?? 0,
                    'avatar' => $row['avatar'],
                    'avatar_original' => $row['avatar_original'],
                    'email_verified_at' => Auth::user()->id,
                    'user_verify' => now(),
                ]
            );
        }
    }
}
