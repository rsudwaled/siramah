<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kepegawaian;
use App\Models\BidangPegawai;
use App\Models\TingkatPendidikan;
use App\Models\KebutuhanJurusan;

class FormulirRL2Controller extends Controller
{
    public function FormulirRL2(Request $request)
    {
        $tingkat = TingkatPendidikan::get();
        $id = $request->tingkat;
        $idt = null;
        
        $data = Kepegawaian::all();
        $data = $data->groupBy(['id_bidang','jurusan']);
        // $data = $data->groupBy('id_bidang','jurusan');
        // $data = $data->groupBy('id_bidang');
        // dd($data);
        $bidangd = BidangPegawai::all();
        $jurusan = KebutuhanJurusan::all();
        $kb = $jurusan->groupBy('nama_jurusan')->toArray();
        // dd($data, $kb);

        return view('simrs.formulir.f_r_l_2.formulir_rl_2', compact('data','tingkat','idt','bidangd','jurusan','kb'));
    }
}
