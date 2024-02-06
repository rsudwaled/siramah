<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Paramedis;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class PractitionerController extends SatuSehatController
{
    public function index(Request $request)
    {
        $paramedis = Paramedis::get();
        $dokter = Dokter::get();
        return view('simrs.practitioner_index', compact([
            'request',
            'dokter',
            'paramedis',
        ]));
    }
    public function practitioner_by_nik(Request $request)
    {
        $token = Token::latest()->first()->access_token;
        $url = env('SATUSEHAT_BASE_URL') . "/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|" . $request->nik;
        $response = Http::withToken($token)->get($url);
        $data = $response->json();
        return $this->responseSatuSehat($data);
    }
    public function practitioner_sync(Request $request)
    {
        $paramedis = Paramedis::where('kode_paramedis', $request->kode_paramedis)->first();
        $request['nik'] = $paramedis->nik;
        $res = $this->practitioner_by_nik($request);
        if ($res->response->entry[0]) {
            $ihs = $res->response->entry[0]->resource->id;
            $paramedis->update([
                'id_satusehat' => $ihs
            ]);
            Alert::success('Success', 'Berhasil Sync Practitioner Satu Sehat');
        } else {
            Alert::error('Mohon Maaf', $res->metadata->message);
        }
        return redirect()->back();
    }
}
