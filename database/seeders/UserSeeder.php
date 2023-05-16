<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "Admin Super",
            "email" => "brsud.waled@gmail.com",
            "username" => "adminrs",
            "phone" => "089529909036",
            'password' => bcrypt('qweqwe123'),
            'user_verify' => 1,
            'email_verified_at' => now()
        ]);
        $user->assignRole('Admin Super');
        $user = User::create([
            "name" => "Marwan Dhiaur Rahman",
            "email" => "marwandhiaurrahman@gmail.com",
            "username" => "marwan",
            "phone" => "089529909036",
            'password' => bcrypt('qweqwe123'),
            // 'user_verify' => 1,
            // 'email_verified_at' => now()
        ]);
        $user->assignRole('Admin Super');
        $user = User::create([
            "name" => "Admin Antrian BPJS",
            "email" => "antrianbpjs@gmail.com",
            "username" => "antrianbpjs",
            "phone" => "089529909036",
            'password' => bcrypt('antrianbpjs'),
            'user_verify' => 1,
            'email_verified_at' => now()
        ]);
        $user->assignRole('Admin Super');
    }
}
