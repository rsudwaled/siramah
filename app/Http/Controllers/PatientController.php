<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class PatientController extends APIController
{
    public string $baseurl = "https://api-satusehat.kemkes.go.id/fhir-r4/v1";
    public function index(Request $request)
    {
        if ($request->search) {
            $pasiens = Pasien::with(['kecamatans'])->orderBy('tgl_entry', 'desc')
                ->where('no_rm', 'LIKE', "%{$request->search}%")
                ->orWhere('nama_px', 'LIKE', "%{$request->search}%")
                ->orWhere('no_Bpjs', 'LIKE', "%{$request->search}%")
                ->orWhere('nik_bpjs', 'LIKE', "%{$request->search}%")
                ->simplePaginate(20);
        } else {
            $pasiens = Pasien::with(['kecamatans'])->orderBy('tgl_entry', 'desc')
                ->simplePaginate(20);
        }
        $total_pasien = Pasien::count();
        return view('simrs.patient_index', compact([
            'pasiens',
            'request',
            'total_pasien',
        ]));
    }
    public function patient_by_nik(Request $request)
    {
        $token = Token::latest()->first()->access_token;
        $url = $this->baseurl . "/Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $request->nik;
        $response = Http::withToken($token)->get($url);
        $data = $response->json();
        return $this->sendResponse($data);
    }
    public function patient_sync(Request $request)
    {
        $pasien = Pasien::where('no_rm', $request->norm)->first();
        $request['nik'] = $pasien->nik_bpjs;
        $res = $this->patient_by_nik($request);
        if ($res->response->entry[0]) {
            $ihs = $res->response->entry[0]->resource->id;
            $pasien->update([
                'ihs' => $ihs
            ]);
            Alert::success('Berhasil Sync Patient');
        } else {
            Alert::error('Data Pasien Tidak Ditemukan');
        }
        return redirect()->back();
    }
}
