<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanKerja;
use App\Models\BidangPegawai;
use App\Imports\BidangPegawaiImport;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanKerjaController extends Controller
{
    // Jabatan Function
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

    public function editJabatan($id_jabatan)
    {
        $data = JabatanKerja::findOrFail($id_jabatan);
        return view('simrs.kepeg.jabatan.editjabatan', compact('data'));
    }
    public function updateJabatan(Request $request, $id_jabatan)
    {
        $data = JabatanKerja::findOrFail($id_jabatan);;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->update();

        Alert::success('Berhasil', 'jabatan baru berhasil diupdate');
        return redirect()->route('jabatan-kepeg.get');
    }
    
    

    // Bidang Function
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

    public function addBidang(Request $request)
    {
        BidangPegawai::create([
            'nama_bidang' => $request->nama_bidang
        ]);
        Alert::success('Berhasil', 'Bidang baru berhasil ditambahkan');
        return back();
    }


    public function editBidang($id_bidang)
    {
        $data = BidangPegawai::findOrFail($id_bidang);
        return view('simrs.kepeg.jabatan.editbidang', compact('data'));
    }

    public function updateBidang(Request $request, $id_bidang)
    {
        $data = BidangPegawai::findOrFail($id_bidang);;
        $data->nama_bidang = $request->nama_bidang;
        $data->update();

        Alert::success('Berhasil', 'Bidang baru berhasil diupdate');
        return redirect()->route('jabatan-kepeg.get');
    }
}
