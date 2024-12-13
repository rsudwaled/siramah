<?php

namespace App\Http\Controllers\ERMRANAP\RencanaAsuhan;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\ErmRanapRencanaAsuhan;

class RencanaAsuhanController extends Controller
{
    public function storeRencanaAsuhan(Request $request)
    {
        $pic_dokter = Auth::user()->id;
        $user_dokter = Auth::user()->name;
        $kunjungan = Kunjungan::with(['pasien'])->where('kode_kunjungan', $request->kode)->first();
        foreach ($request->tanggal as $key => $rencana) {
            ErmRanapRencanaAsuhan::create([
                'rm_counter'        =>$kunjungan->no_rm.'|'.$kunjungan->counter,
                'kode_kunjungan'    =>$kunjungan->kode_kunjungan,
                'tanggal'           =>$request->tanggal[$key],
                'waktu_asuhan'      =>$request->waktu_asuhan[$key],
                'profesi'           =>'dokter',
                'rencana_asuhan'    =>$request->rencana_asuhan[$key],
                'capaian_diharapkan'=>$request->capaian_yang_diharapkan[$key],
                'pic_dokter'        =>$pic_dokter,
                'user_dokter'       =>$user_dokter,
            ]);
        }
        Alert::success('Success', 'Rencana Asuhan Berhasil Disimpan');
        return redirect()->back();
    }
    public function updateRencana(Request $request, $id)
    {
        $pic_dokter     = Auth::user()->id;
        $user_dokter    = Auth::user()->name;
        $rencana        = ErmRanapRencanaAsuhan::find($id);
        if (empty($rencana)) {
            return response()->json(['success' => false, 'message' => 'Rencana tidak ditemukan.'], 404);
        }
        $rencana->tanggal           = $request->tanggal;
        $rencana->waktu_asuhan      = $request->waktu;
        $rencana->profesi           = $request->profesi;
        $rencana->rencana_asuhan    = $request->rencana;
        $rencana->capaian_diharapkan= $request->capaian;
        $rencana->pic_dokter        = $pic_dokter;
        $rencana->user_dokter       = $user_dokter;
        $rencana->save();
        return response()->json(['message' => 'Data updated successfully.'], 200);
    }
    public function deleteRencana($id)
    {
        $rencana = ErmRanapRencanaAsuhan::find($id);
        if ($rencana) {
            $rencana->delete();
            return response()->json(['success' => true, 'message' => 'Rencana berhasil dihapus!']);
        }
        return response()->json(['success' => false, 'message' => 'Rencana tidak ditemukan.'], 404);
    }
}
