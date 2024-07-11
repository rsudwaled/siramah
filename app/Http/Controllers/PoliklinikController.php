<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\PenjaminSimrs;
use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PoliklinikController extends BaseController
{
    public function index()
    {
        $polis = Poliklinik::with(['unit'])->get();
        return view('simrs.poli_index', [
            'polis' => $polis
        ]);
    }
    public function poliklikAntrianBpjs()
    {
        $controller = new AntrianController();
        $poliklinik_save = Poliklinik::get();

        $response = $controller->ref_poli();
        if ($response->metadata->code == 200) {
            $polikliniks = $response->response;
            Alert::success($response->metadata->message, 'Poliklinik Antrian BPJS');
        } else {
            $polikliniks = null;
            Alert::error($response->metadata->message . ' ' . $response->metadata->code);
        }
        $response = $controller->ref_poli_fingerprint();
        if ($response->metadata->code == 200) {
            $fingerprint = $response->response;
            Alert::success($response->metadata->message, 'Poliklinik Antrian BPJS');
        } else {
            $fingerprint = null;
            Alert::error($response->metadata->message . ' ' . $response->metadata->code,  'Poliklinik Fingerprint Antrian BPJS');
        }
        return view('bpjs.antrian.poliklinik', compact([
            'polikliniks',
            'fingerprint',
            'poliklinik_save',
        ]));
    }
    public function displayAntrianPoliklinik(Request $request)
    {
        $antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->where('lokasi', 2)->get();
        $polis = Poliklinik::where('lokasi', 2)->get();
        return view('simrs.display_antrian_poliklinik', compact('antrians', 'polis'));
    }
    public function displayantrian2(Request $request)
    {
        $antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->where('lokasi', 2)->get();
        $polis = Poliklinik::where('lokasi', 2)->get();
        return view('simrs.display_antrian_poliklinik', compact('antrians', 'polis'));
    }
    public function displayantrian3(Request $request)
    {
        $antrians = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))
            ->where('lokasi', 3)->get();
        $polis = Poliklinik::where('lokasi', 3)->get();
        return view('simrs.display_antrian_lt3', compact('antrians', 'polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodepoli' => 'required',
            'namapoli' => 'required',
            'kodesubspesialis' => 'required',
            'namasubspesialis' => 'required',
        ]);
        Poliklinik::firstOrCreate([
            'kodepoli' => $request->kodepoli,
            'kodesubspesialis' => $request->kodesubspesialis,
        ], [
            'namapoli' => $request->namapoli,
            'namasubspesialis' => $request->namasubspesialis,
            'user_by' => Auth::user()->name,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Ditambahkan');
        return redirect()->back();
    }
    public function poliklik_antrian_refresh()
    {
        $controller = new AntrianController();
        $response = $controller->ref_poli();
        if ($response->metadata->code == 200) {
            $polikliniks = $response->response;
            foreach ($polikliniks as $value) {
                PoliklinikAntrian::firstOrCreate([
                    'kodePoli' => $value->kdpoli,
                    'namaPoli' => $value->nmpoli,
                    'kodeSubspesialis' => $value->kdsubspesialis,
                    'namaSubspesialis' => $value->nmsubspesialis,
                ]);
            }
            Alert::success($response->metadata->message, 'Refresh Poliklinik Antrian BPJS Total : ' . count($polikliniks));
        } else {
            Alert::error($response->metadata->message . ' ' . $response->metadata->code);
        }
        return redirect()->route('pelayanan-medis.poliklinik_antrian');
    }
    public function poliklik_antrian_yanmed()
    {
        $polikliniks = PoliklinikAntrian::get();
        return view('simrs.pelyananmedis.poliklinik_antrian_bpjs', compact([
            'polikliniks'
        ]));
    }
    public function create()
    {
        $api = new AntrianBPJSController();
        $poli = $api->ref_poli()->response;
        $poliDB = UnitDB::where('KDPOLI', '!=', null)->get(['kode_unit', 'nama_unit', 'KDPOLI',]);
        foreach ($poli as $value) {
            if ($value->kdpoli == $value->kdsubspesialis) {
                $subpesialis = 0;
            } else {
                $subpesialis = 1;
            }
            Poliklinik::updateOrCreate(
                [
                    'kodepoli' => $value->kdpoli,
                    'kodesubspesialis' => $value->kdsubspesialis,
                ],
                [
                    'namapoli' => $value->nmpoli,
                    'namasubspesialis' => $value->nmsubspesialis,
                    'subspesialis' => $subpesialis,
                    'lokasi' => 1,
                    'loket' => 1,
                    'status' => 0,
                ]
            );
        }
        // update aktif
        $poli_jkn = Poliklinik::get();
        foreach ($poli_jkn as $poli) {
            foreach ($poliDB as $unit) {
                if ($poli->kodesubspesialis ==  $unit->KDPOLI) {
                    if (isset($unit->lokasi)) {
                        $lokasi = $unit->lokasi->lokasi;
                        $loket = $unit->lokasi->loket;
                    } else {
                        $lokasi = 0;
                        $loket = 0;
                    }
                    $poli->update([
                        'status' => 1,
                        'lokasi' => $lokasi,
                        'loket' => $loket,
                    ]);
                    $user = User::updateOrCreate([
                        'email' => $poli->kodesubspesialis . '@gmail.com',
                        'username' => $poli->kodesubspesialis,
                    ], [
                        'name' => 'ADMIN POLI ' . $poli->namasubspesialis,
                        'phone' => '089529909036',
                        'password' => bcrypt('adminpoli'),
                    ]);
                    $user->assignRole('Poliklinik');
                }
            }
        }
        Alert::success('Success', 'Refresh Poliklinik Berhasil');
        return redirect()->route('poli.index');
    }
    public function edit($id)
    {
        $poli = Poliklinik::find($id);
        if ($poli->status == '0') {
            $status = 1;
            $keterangan = 'Aktifkan';
        } else {
            $status = 0;
            $keterangan = 'Non-Aktifkan';
        }
        $poli->update([
            'status' => $status,
        ]);
        Alert::success('Success', 'Poliklinik ' . $poli->namasubspesialis . ' Telah Di ' . $keterangan);
        return redirect()->route('poliklinik.index');
    }
    public function show($id)
    {
        $poli = Poliklinik::find($id);
        return response()->json($poli);
    }
    public function poliklinik_aktif()
    {
        $poli = Poliklinik::where('status', 1)->get();
        return $this->sendResponse($poli, 200);
    }
    public function diagnosaRawatJalan(Request $request)
    {
        // $response = null;
        $kunjungans = null;
        if (isset($request->tanggal) && isset($request->kodepoli)) {
            $poli = Unit::firstWhere('KDPOLI', $request->kodepoli);
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)
                ->where('kode_unit', $poli->kode_unit)
                ->with(['unit', 'pasien', 'assesmen_dokter'])
                ->get();
                // coding urutkan berdasarkan nama
            // $response = DB::connection('mysql2')->select("CALL SP_PANGGIL_PASIEN_RAWAT_JALAN_KUNJUNGAN('" . $poli->kode_unit . "','" . $request->tanggal . "')");
        }
        $unit = Unit::where('KDPOLI', "!=", null)->where('KDPOLI', "!=", "")->get();
        // $penjaminrs = PenjaminSimrs::get();
        // $response = collect($response);
        return view('simrs.rekammedis.diagnosa_rawat_jalan', [
            'kunjungans' => $kunjungans,
            'request' => $request,
            // 'response' => $response,
            // 'penjaminrs' => $penjaminrs,
            'unit' => $unit,
        ]);
    }
}
