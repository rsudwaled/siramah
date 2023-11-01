<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends APIController
{
    public function index(Request $request)
    {
        $pasiens = Pasien::with(['kecamatans'])->latest()
            ->where('no_rm', 'LIKE', "%{$request->search}%")
            ->orWhere('nama_px', 'LIKE', "%{$request->search}%")
            ->orWhere('no_Bpjs', 'LIKE', "%{$request->search}%")
            ->orWhere('nik_bpjs', 'LIKE', "%{$request->search}%")
            ->simplePaginate(20);

        $total_pasien = Pasien::count();
        // $pasien_jkn = Pasien::where('no_Bpjs', '!=', '')->count();
        // $pasien_nik = Pasien::where('nik_bpjs', '!=', '')->count();
        // $pasien_laki = Pasien::where('jenis_kelamin', 'L')->count();
        // $pasien_perempuan = Pasien::where('jenis_kelamin', 'P')->count();
        return view('simrs.pasien_index', compact([
            'pasiens',
            'request',
            'total_pasien',
            // 'pasien_jkn',
            // 'pasien_nik',
            // 'pasien_laki',
            // 'pasien_perempuan',
        ]));
    }
    public function edit($no_rm)
    {
        $pasien = Pasien::firstWhere('no_rm', $no_rm);
        return view('simrs.pasien_edit', compact('pasien'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik,' . $request->user_id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_rm' => 'required',
            'no_rm' => 'required',
        ]);
        $request['username'] = $request->nik;
        $request['tanggal_lahir'] = date('Y-m-d', strtotime($request->tanggal_lahir));
        // $user = User::updateOrCreate(['id' => $request->user_id], $request->except(['_token', 'role']));
        // $user->assignRole('Pasien');
        $pasien = Pasien::updateOrCreate(['no_rm' => $request->no_rm], [
            'nik_bpjs' => $request->nik,
            'nama_px' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tanggal_lahir,
        ]);
        Alert::success('Success', 'Data Pasien Telah Disimpan');
        return redirect()->route('simrs.pasien.index');
    }
    public function update($id, Request $request)
    {
        $request['user'] = Auth::user()->id;
        $pasien = Pasien::find($id);
        $pasien->update([
            'nik_bpjs' => $request->nik,
            'no_Bpjs' => $request->nokartu,
            'nama_px' => $request->nama,
        ]);
        Alert::success('Success', 'Data Pasien Diperbaharui.');
        return redirect()->back();
    }
    public function show($no_rm)
    {
        $pasien = Pasien::where('no_rm', 'LIKE', '%' . $no_rm . '%')->first();
        return response()->json($pasien);
    }
    public function cari_pasien(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "search" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $pasien = Pasien::where('no_rm', $request->search)
            ->orWhere('nik_bpjs', $request->search)
            ->orWhere('no_Bpjs', $request->search)
            ->orWhere('nama_px', $request->search)
            ->first();

        if ($pasien) {
            return $this->sendResponse($pasien, 200);
        } else {
            return $this->sendError('Pasien tidak ditemukan', 404);
        }
    }
    public function cekPasien(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nik" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $pasien = Pasien::firstWhere('nik_bpjs', $request->nik);
        if ($pasien) {
            return $this->sendResponse($pasien, 200);
        } else {
            return $this->sendError('Pasien tidak ditemukan', 404);
        }
    }
    public function destroy($no_rm)
    {
        $pasien = Pasien::firstWhere('no_rm', $no_rm);
        $pasien->delete();
        Alert::success('Success', 'Data Pasien Telah Dihapus');
        return redirect()->route('simrs.pasien.index');
    }
    // public function pasien_daerah(Request $request)
    // {
    //     $pasiens_kecamatan = Pasien::select('kode_kecamatan', DB::raw('count(*) as total'))
    //         ->where('kode_kecamatan', '!=', null)
    //         ->where('kode_kecamatan', '!=', 0)
    //         ->groupBy('kode_kecamatan')
    //         ->orderBy('total', 'desc')
    //         ->limit(20)
    //         ->get();
    //     $pasiens_kabupaten = Pasien::select('kode_kabupaten', DB::raw('count(*) as total'))
    //         ->where('kode_kabupaten', '!=', null)
    //         ->where('kode_kabupaten', '!=', 0)
    //         ->groupBy('kode_kabupaten')
    //         ->orderBy('total', 'desc')
    //         ->limit(20)
    //         ->get();
    //     $pasiens_pendidikan = Pasien::select('pendidikan', DB::raw('count(*) as total'))
    //         ->where('pendidikan', '!=', null)
    //         ->where('pendidikan', '!=', 0)
    //         ->groupBy('pendidikan')
    //         ->orderBy('total', 'desc')
    //         ->get();
    //     $pendidikan = Pendidikan::get();
    //     $pasiens_pekerjaan = Pasien::select('pekerjaan', DB::raw('count(*) as total'))
    //         ->where('pekerjaan', '!=', null)
    //         ->where('pekerjaan', '!=', 0)
    //         ->groupBy('pekerjaan')
    //         ->orderBy('total', 'desc')
    //         ->get();
    //     $pekerjaan = Pekerjaan::get();
    //     $pasiens_agama = Pasien::select('agama', DB::raw('count(*) as total'))
    //         ->where('agama', '!=', null)
    //         ->where('agama', '!=', 0)
    //         ->groupBy('agama')
    //         ->orderBy('total', 'desc')
    //         ->get();
    //     $agama = Agama::get();
    //     // dd($pasiens_pekerjaan);
    //     // dd($pasiens_pendidikan->where('pendidikan', 15)->first()->total);
    //     // dd($pasiens_pendidikan);
    //     $pasiens_laki = Pasien::where('jenis_kelamin', 'L')->count();
    //     $pasiens_perempuan = Pasien::where('jenis_kelamin', 'P')->count();
    //     return view('simrs.pasien_daerah', compact([
    //         'pasiens_kecamatan',
    //         'pasiens_kabupaten',
    //         'pasiens_laki',
    //         'pasiens_perempuan',
    //         'pendidikan',
    //         'pasiens_pendidikan',
    //         'pasiens_pekerjaan',
    //         'pekerjaan',
    //         'pasiens_agama',
    //         'agama',
    //     ]));
    // }
    public function fingerprintPeserta(Request $request)
    {
        $peserta = null;
        if ($request->nomorkartu) {
            $request['jenisIdentitas'] = 'noka';
            $request['noIdentitas'] = $request->nomorkartu;
            $api = new AntrianController();
            $response =  $api->ref_pasien_fingerprint($request);
            if ($response->metadata->code == 200) {
                $peserta = $response->response;
                if ($peserta->daftarfp == 0) {
                    Alert::error('Maaf', 'Pasien Belum memeliki Fingerprint BPJS');
                } else {
                    Alert::success('Success', 'Pasien Belum memeliki Fingerprint BPJS');
                }
            } else {
                Alert::error('Maaf', $response->metadata->message);
            }
        }
        return view('bpjs.antrian.fingerprint_peserta', compact([
            'request',
            'peserta'
        ]));
    }
}
