<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KebutuhanJurusan;
use App\Imports\KebutuhanJurusanImport;
use RealRashid\SweetAlert\Facades\Alert;

class KebutuhanJurusanController extends Controller
{
    public function kebutuhanJurusan()
    {
        $data = KebutuhanJurusan::all();
        $sum = collect($data);
        // dd($data);
        return view('simrs.kepeg.kebutuhanjurusan.v_kebutuhan_jurusan', compact('data','sum'));
    }

    public function importJurusan(Request $request)
    {
        $data = (new KebutuhanJurusanImport)->toArray($request->file('file'));
        $inserted = 0;
        $jml_data =0;
        foreach ($data[0] as $row) {
            $inserted ++;
            $jml_data ++;
            KebutuhanJurusan::create([
                'id'                => $row['id'],
                'nama_jurusan'      => strtolower($row['nama_jurusan']),
            ]);
        }
        Alert::success('Berhasil', 'Data Berhasil diimport sebanyak '. $jml_data);
        return back();
    }
}
