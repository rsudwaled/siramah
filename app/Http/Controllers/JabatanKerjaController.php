<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanKerja;
use App\Models\BidangPegawai;
use App\Imports\BidangPegawaiImport;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanKerjaController extends Controller
{
    public function dataBidang(Request $request)
    {
        $data = (new BidangPegawaiImport)->toArray($request->file('file'));
        $inserted = 0;
        $jml_data =0;
        foreach ($data[0] as $row) {
            $inserted ++;
            $jml_data ++;
            BidangPegawai::create([
                'id'                => $row['id'],
                'nama_bidang'       => $row['nama_bidang'],
            ]);
        }
        Alert::success('Berhasil', 'Data Berhasil diimport sebanyak '. $jml_data);
        return back();
    }

    public function dataJabatan()
    {
        $data = JabatanKerja::all();
        $bidang = BidangPegawai::all();
        return view('simrs.kepeg.jabatan.datajabatan', compact('data','bidang'));
    }

    public function addJabatan(Request $request)
    {
        JabatanKerja::create([
            'nama_jabatan' => $request->nama_jabatan
        ]);
        Alert::success('Berhasil', 'jabatan baru berhasil ditambahkan');
        return back();
    }
}
