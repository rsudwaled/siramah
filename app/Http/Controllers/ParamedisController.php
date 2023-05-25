<?php

namespace App\Http\Controllers;

use App\Models\Paramedis;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ParamedisController extends Controller
{
    public function index(Request $request)
    {
        $paramedis = Paramedis::get(['kode_paramedis', 'kode_dokter_jkn', 'nama_paramedis', 'sip_dr']);
        $paramedis_total = Paramedis::count();
        $total_paramedis = Paramedis::count();

        // get dokter vclaim bpjs
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->status() == 200) {
            $dokter_bpjs = collect($response->getData()->response);
        } else {
            $dokter_bpjs = null;
            Alert::error($response->getData()->metadata->message . ' ' . $response->status());
        }

        // $paramedis->where('kode_dokter_jkn', )
        return view('simrs.paramedis_index', compact([
            'request',
            'dokter_bpjs',
            'paramedis',
            'paramedis_total',
            'total_paramedis',
        ]));
    }
    public function show($id)
    {
        $paramedis = Paramedis::with(['dokter'])->where('kode_paramedis', $id)->first();
        return response()->json($paramedis);
    }
    public function update($id, Request $request)
    {
        $paramedis = Paramedis::firstWhere('kode_paramedis', $id);
        $paramedis->update([
            'nama_paramedis' => $request->nama_paramedis,
            'sip_dr' => $request->sip_dr,
            'kode_dokter_jkn' => $request->kodedokter,
        ]);
        Alert::success('Success', 'Data Dokter telah diperbarui');
        return redirect()->back();
    }
}
