<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\DiagnosaFrunit;
use RealRashid\SweetAlert\Facades\Alert;

class KunjunganIGDController extends Controller
{
    public function kunjunganPasienHariIni(Request $request)
    {
      $tgl       = Carbon::now()->format('Y-m-d');
      $kunjungan = Kunjungan::whereBetween('tgl_masuk', ['2023-11-01', now()])->where('status_kunjungan', 1)->orderBy('tgl_masuk','desc')->paginate(32);
      $frunit = DiagnosaFrunit::whereBetween('input_date', ['2023-11-01', now()])->where('status_bridging', 0)->orderBy('input_date','desc')->paginate(32);
      $ugd       = $kunjungan->where('kode_unit', 1002)->count();
      $ugdkbd    = $kunjungan->where('kode_unit', 1023)->count();
      return view('simrs.igd.kunjungan.kunjungan_igd', compact('kunjungan','frunit','ugd','ugdkbd'));
    }
    public function tutupKunjunganByKode(Request $request)
    {
      if ($request->rm_tk == null && $request->kunjungan_tk) {
        Alert::error('Error!!', 'data yang dimasukan tidak boleh kosong!');
        return back();
      }
      $ttp_k = Kunjungan::where('no_rm',$request->rm_tk)->where('kode_kunjungan', $request->kunjungan_tk)->first();
      if($ttp_k == null)
      {
        Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
        return back();
      }
      $ttp_k->status_kunjungan = 2;
      $ttp_k->update();
      Alert::success('success', 'Kunjungan pasien dengan kode : '.$ttp_k->kode_kunjungan.' berhasil ditutup' );
      return back();
    }
    public function bukaKunjunganByKode(Request $request)
    {
      if ($request->rm_tk == null && $request->kunjungan_tk) {
        Alert::error('Error!!', 'data yang dimasukan tidak boleh kosong!');
        return back();
      }
      $ttp_k = Kunjungan::where('no_rm',$request->rm_tk)->where('kode_kunjungan', $request->kunjungan_tk)->first();
      if($ttp_k == null)
      {
        Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
        return back();
      }
      $ttp_k->status_kunjungan = 1;
      $ttp_k->cfar = 1;
      $ttp_k->update();
      Alert::success('success', 'Kunjungan pasien dengan kode : '.$ttp_k->kode_kunjungan.' berhasil dibuka' );
      return back();
    }

    public function editKunjungan(Request $request)
    {
      $kunjungan = Kunjungan::where('no_rm', $request->no_rm)->orderBy('tgl_masuk', 'desc')->get();
      $noRM = $request->no_rm;
      $penjamin = PenjaminSimrs::get();
      return view('simrs.igd.kunjungan.list_edit_kunjungan', compact('kunjungan','noRM','penjamin'));
    }

    public function editKunjunganTerpilih(Request $request)
    {
      $data = Kunjungan::with(['penjamin_simrs','pasien','unit'])
        ->where('counter', $request->counter)
        ->where('no_rm', $request->rm)->first();
      $data=collect($data);
      return response()->json($data, 200);
    }

    public function updateKunjunganTerpilih(Request $request)
    {
      $data = Kunjungan::where('counter', $request->counter)->where('no_rm', $request->no_rm)->first();
      if($request->status==0)
      {
        $status = $data->status_kunjungan;
      }else{
        $status = $request->status;
      }
      $data->status_kunjungan = $status;
      $data->kode_penjamin = $request->penjamin;
      $data->update();
      return response()->json(['data'=>$data, 'status'=>200]);
    }

    public function diagnosaPasien(Request $request)
    {
      $kunjungan = Kunjungan::where('kode_kunjungan', $request->kunjungan)
      ->where('no_rm', $request->rm)->first();
      $kunjungan->diagx = $request->syncDiagnosa;
      if($kunjungan->update())
      {
        $diagFr = DiagnosaFrunit::where('no_rm', $request->rm)->where('kode_kunjungan', $request->kunjungan)->first();
        $diagFr->status_bridging =
        $diagFr->save();
      }
      Alert::success('success', 'Diagnosa pada kunjungan sudah di synchronize' );
      return back();
    }
}
