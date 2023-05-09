<?php

namespace Database\Seeders;

use App\Http\Controllers\AntrianController;
use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $api = new AntrianController();
        $response = $api->ref_dokter();
        if ($response->status() == 200) {
            $dokters = $response->getData()->response;
            foreach ($dokters as $value) {
                Dokter::firstOrCreate([
                    'kodedokter' => $value->kodedokter,
                    'namadokter' => $value->namadokter,
                ]);
            }
        } else {
            return $response->getData()->metadata->message;
        }
    }
}
