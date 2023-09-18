<?php

namespace Database\Seeders;

use App\Models\Poliklinik;
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
        // $user = User::create([
        //     "name" => "Admin Super",
        //     "email" => "brsud.waled@gmail.com",
        //     "username" => "adminrs",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('asdasdqwe'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Admin Super');
        $user = User::create([
            "name" => "Marwan Dhiaur Rahman",
            "email" => "marwandhiaurrahman@gmail.com",
            "username" => "marwan",
            "phone" => "089529909036",
            'password' => bcrypt('asdasdqwe'),
            'user_verify' => 1,
            'email_verified_at' => now()
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
        $user->assignRole('BPJS');
        // $user = User::create([
        //     "name" => "Bagian Umum",
        //     "email" => "bagum@gmail.com",
        //     "username" => "bagianumum",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('bagianumum'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Bagian Umum');
        // $user = User::create([
        //     "name" => "Admin Pendaftaran",
        //     "email" => "adminpendaftaran@gmail.com",
        //     "username" => "adminpendaftaran",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminpendaftaran'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Pendaftaran');
        // $user = User::create([
        //     "name" => "Admin Kasir",
        //     "email" => "adminkasir@gmail.com",
        //     "username" => "adminkasir",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminkasir'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Kasir');
        // $user = User::create([
        //     "name" => "Admin Poliklinik",
        //     "email" => "adminpoli@gmail.com",
        //     "username" => "adminpoli",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminpoli'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Poliklinik');
        // $user = User::create([
        //     "name" => "Admin Farmasi",
        //     "email" => "adminfarmasi@gmail.com",
        //     "username" => "adminfarmasi",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminfarmasi'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Farmasi');
        // $user = User::create([
        //     "name" => "Admin Pelayanan Medis",
        //     "email" => "adminyanmed@gmail.com",
        //     "username" => "adminyanmed",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminyanmed'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Pelayanan Medis');
        // $user = User::create([
        //     "name" => "Admin Rekam Medis",
        //     "email" => "adminrekammedis@gmail.com",
        //     "username" => "adminrekammedis",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('adminrekammedis'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Rekam Medis');
        // $user = User::create([
        //     "name" => "Admin Casemix",
        //     "email" => "casemix@gmail.com",
        //     "username" => "casemix",
        //     "phone" => "089529909036",
        //     'password' => bcrypt('casemix'),
        //     'user_verify' => 1,
        //     'email_verified_at' => now()
        // ]);
        // $user->assignRole('Casemix');
        // $adminpoli = [
        //     'OBG',
        //     // 'HIV',
        //     'KLT',
        //     'PAR',
        //     // 'MCU',
        //     'ORT',
        //     'URO',
        //     'JAN',
        //     'BSY',
        //     'INT',
        //     'THT',
        //     'MAT',
        //     '008',
        //     'ANT',
        //     'BED',
        //     'GIG',
        //     'GND',
        //     'GPR',
        //     'IRM',
        //     'ANA',
        //     'SAR',
        //     'JIW',
        //     '020',

        // ];
        // foreach ($adminpoli as  $value) {
        //     $poli = Poliklinik::where('kodesubspesialis', $value)->first();
        //     $user = User::create([
        //         "name" => "ADMIN " . $poli->namasubspesialis,
        //         "email" => $value . "@gmail.com",
        //         "username" => $value,
        //         "phone" => '089529909036',
        //         'password' => bcrypt('adminpoli'),
        //         'user_verify' => 2,
        //         'email_verified_at' => now()
        //     ]);
        //     $user->assignRole('Poliklinik');
        // }
    }
}
