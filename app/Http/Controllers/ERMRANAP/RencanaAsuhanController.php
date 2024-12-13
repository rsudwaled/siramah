<?php

namespace App\Http\Controllers\ERMRANAP;

use App\Http\Controllers\APIController;
use App\Models\AsuhanTerpadu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RencanaAsuhanController extends APIController
{
    
    public function getDataRencana(Request $request)
    {
        $rencanaAsuhan = AsuhanTerpadu::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($rencanaAsuhan);
    }
    public function simpan_rencana_asuhan_terpadu(Request $request)
    {
        AsuhanTerpadu::updateOrCreate(
            [
                'kode_kunjungan'    => $request->kode_kunjungan,
                'no_rm'             => $request->no_rm, 
                'tgl_waktu'         => $request->tgl_waktu, 
            ],
            [
                'kode'                  => $request->kode,
                'tgl_waktu'             => $request->tgl_waktu, 
                'kode_kunjungan'        => $request->kode_kunjungan,
                'counter'               => $request->counter,
                'no_rm'                 => $request->no_rm,
                'rm_counter'            => $request->rm_counter,
                'nama'                  => $request->nama,
                'rencana_asuhan'        => $request->rencana_asuhan,
                'capaian_diharapkan'    => $request->capaian_diharapkan,
                'profesi'               => $request->profesi,
                'pic'                   => $request->pic,
                'kode_unit'             => $request->kode_unit,
                'user'                  => $request->user,
            ]
        );
        Alert::success('Success', 'Rencana Asuhan Terpadu Rawat Inap Disimpan');
        return redirect()->back();
    }
    public function getRencanaAsuhData(Request $request)
    {
        $data = AsuhanTerpadu::findOrFail($request->id);
        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }
        return response()->json($data);
    }
    public function hapusRencanaAsuhan(Request $request)
    {
        $rencanaAsuhan = AsuhanTerpadu::find($request->id);
        if ($rencanaAsuhan->user_id == Auth::user()->id) {
            $rencanaAsuhan->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
}
