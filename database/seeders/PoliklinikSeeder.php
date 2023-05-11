<?php

namespace Database\Seeders;

use App\Http\Controllers\AntrianController;
use App\Models\Poliklinik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliklinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $api = new AntrianController();
        $response = $api->ref_poli();
        if ($response->status() == 200) {
            $polikliniks = $response->getData()->response;
            foreach ($polikliniks as $value) {
                Poliklinik::firstOrCreate([
                    'kodepoli' => $value->kdpoli,
                    'namapoli' => $value->nmpoli,
                    'kodesubspesialis' => $value->kdsubspesialis,
                    'namasubspesialis' => $value->nmsubspesialis,
                    'user_by' => 'Migration',
                ]);
            }
        } else {
            return $response->getData()->metadata->message;
        }

        $polikliniks = Poliklinik::all();
        foreach ($polikliniks as  $value) {
            if ($value->unit) {
                $value->update([
                    'status' => 1
                ]);
            }
        }
    }
}
