<?php

namespace App\Http\Controllers\IGD\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Ruangan;
use App\Models\Unit;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\AlasanMasuk;
use App\Models\PenjaminSimrs;
use App\Models\Penjamin;

class DaftarRanapIGDController extends Controller
{
    public function index(Request $request)
    {
        $rmPasien = $request->input('cari_rm');
        $namaPasien = $request->input('nama');
        $alamatPasien = $request->input('cari_desa');
        if(!empty($namaPasien) || !empty($alamatPasien) || !empty($rmPasien))
        {
            $kunjungans = Kunjungan::with([
                'pasien.lokasiDesa', 
                'pasien.lokasiKecamatan', 
                'pasien.lokasiKabupaten', 
                'pasien.lokasiProvinsi'
                ])->whereHas('pasien', function($query) use ($namaPasien, $rmPasien, $alamatPasien) {
                    $query->where('nama_px', 'like', '%' . $namaPasien . '%');
                    $query->where('no_rm', 'like', '%' . $rmPasien . '%');
                    $query->where('desa', 'like', '%' . $alamatPasien . '%');
                })->where('status_kunjungan', 1)->get();
        }else{
            $kunjungans =[];
        }

        $riwayat        = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk', 'desc')->take(5)->get();
        $alasanmasuk    = AlasanMasuk::orderBy('id', 'asc')->get();
        $paramedis      = Paramedis::where('act', 1)->get();
        $penjamin       = PenjaminSimrs::orderBy('kode_penjamin', 'asc')->get();
        $penjaminbpjs   = Penjamin::orderBy('id', 'asc')->get();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $tanggal        = now()->format('Y-m-d');
        return view('simrs.igd.pendaftaran_ranap.index', compact(  'request','unit', 'penjaminbpjs', 'paramedis', 'alasanmasuk', 'paramedis', 'penjamin', 'riwayat', 'kunjungans'));
    }

    public function store(Request $request)
    {
        $query_counter  = Kunjungan::where('kode_kunjungan', $request->kode)->where('status_kunjungan', 1)->first();
        $ruangan        = Ruangan::firstWhere('id_ruangan', $request->id_ruangan);
        $unit           = Unit::firstWhere('kode_unit', $request->unitTerpilih);
        // dd($request->all(), $unit);
        if($query_counter === null || $unit === null)
        {
            return back();
        }
        $createKunjungan                    = new Kunjungan();
        $createKunjungan->counter           = $query_counter->counter;
        $createKunjungan->ref_kunjungan     = $request->kode;
        $createKunjungan->no_rm             = $request->rm;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->dokter_id;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->kode_penjamin     = $request->penjamin_id_umum;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->diagx             = $request->diagAwal??NULL;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs??2;
        $createKunjungan->is_ranap_daftar   = 1;
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 0;
        if($createKunjungan->save())
        {
            $ruangan->status_incharge = 1;
            $ruangan->save();
        }
        return back();
    }

    public function editRuangan($kunjungan)
    {
        $kunjungan  = Kunjungan::with(['ruanganRawat','pasien'])->where('kode_kunjungan', $kunjungan)->first();
        $ruangan    = Ruangan::where('status_incharge', 0)->get();
        $unit       = Unit::where('kelas_unit', 2)->get();
        return view('simrs.igd.pendaftaran_ranap.edit_ruangan', compact('kunjungan','ruangan','unit'));
    }

    public function updateRuangan(Request $request)
    {
        $kunjungan  = Kunjungan::with(['ruanganRawat','pasien'])->where('kode_kunjungan', $request->kode)->first();
        $unit       = Unit::where('kode_unit', $request->unitTerpilih)->first();
       
        $kunjungan->id_ruangan          = $request->id_ruangan;
        $kunjungan->kamar               = $request->ruangan;
        $kunjungan->no_bed              = $request->bed;
        $kunjungan->kode_unit           = $unit->kode_unit;
        $kunjungan->prefix_kunjungan    = $unit->prefix_unit;
        if($kunjungan->save())
        {
            $ruangan    = Ruangan::where('id_ruangan', $kunjungan->id_ruangan)->first();
            $ruangan->status_incharge = 0;
            $ruangan->save();
            

        }
        return back();
    }
}
