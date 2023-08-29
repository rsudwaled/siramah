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
    public function kebutuhanJurusanAdd(Request $request)
    {
        $data = KebutuhanJurusan::findOrFail($request->id_jurusan);
        $data->kebutuhan_lk = $request->kebutuhan_lk;
        $data->kebutuhan_pr = $request->kebutuhan_pr;
        $data->kekurangan_lk = $request->kebutuhan_lk-$data->keadaan_lk;
        $data->kekurangan_pr = $request->kebutuhan_pr-$data->keadaan_pr;
        $data->update();

        Alert::success('Berhasil', 'kebutuhan laki-laki : '.$data->kebutuhan_lk.' dan kebutuhan perempuan : '.$data->kebutuhan_pr);
        return back();
    }

    public function editKebutuhan(Request $request, $id)
    {
        $data = KebutuhanJurusan::findOrFail($request->id);
        return view('simrs.kepeg.kebutuhanjurusan.v_kebutuhan_jurusan_edit', compact('data'));
    }
    public function updateKebutuhan(Request $request, $id)
    {
        $data = KebutuhanJurusan::find($id);
        $data->keadaan_lk = $request->keadaan_lk;
        $data->keadaan_pr = $request->keadaan_pr;
        $data->kebutuhan_lk = $request->kebutuhan_lk;
        $data->kebutuhan_pr = $request->kebutuhan_pr;
        $data->kekurangan_lk = $request->kebutuhan_lk-$data->keadaan_lk;
        $data->kekurangan_pr = $request->kebutuhan_pr-$data->keadaan_pr;
        $data->save();

        Alert::success('Berhasil Diupdate', 'laki-laki : '.$data->kebutuhan_lk.' dan perempuan : '.$data->kebutuhan_pr);
        return redirect()->route('data-jurusan.get');
    }
}
