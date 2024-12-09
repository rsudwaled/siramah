<?php

namespace App\Http\Controllers\IGD\V1;

use App\Http\Controllers\VclaimController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HistoriesIGDBPJS;
use Illuminate\Http\Request;
use App\Models\Icd10;
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
        if($rmPasien)
        {
            $kunjungans = Kunjungan::with([
                'pasien.lokasiDesa',
                'pasien.lokasiKecamatan',
                'pasien.lokasiKabupaten',
                'pasien.lokasiProvinsi'])
                ->where('no_rm', $rmPasien)
                ->whereIn('status_kunjungan', [1,14])->get();
        }else{
            $kunjungans =[];
        }
        // dd($kunjungans, $rmPasien);
        $riwayat        = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk', 'desc')->take(5)->get();
        $alasanmasuk    = AlasanMasuk::orderBy('id', 'asc')->get();
        $paramedis      = Paramedis::where('act', 1)->get();
        $penjamin       = PenjaminSimrs::orderBy('kode_penjamin', 'asc')->get();
        $penjaminbpjs   = Penjamin::orderBy('id', 'asc')->get();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $tanggal        = now()->format('Y-m-d');
        return view('simrs.igd.pendaftaran_ranap.index', compact(  'request','unit', 'penjaminbpjs', 'paramedis', 'alasanmasuk', 'paramedis', 'penjamin', 'riwayat', 'kunjungans'));
    }

    // public function store(Request $request)
    // {
    //     if(empty($request->rm))
    //     {
    //         return back()->withErrors([
    //             'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
    //                         ($request->rm === null ? 'Pasien Belum Dipilih, ' : '')
    //         ]);
    //     }
    //     $cekKunjungan   = Kunjungan::where('no_rm',$request->rm)->whereNotNull('id_ruangan')->where('status_kunjungan', 1)->first();
    //     if(!empty($cekKunjungan))
    //     {
    //         return back()->withErrors([
    //             'alert' => 'PASIEN SUDAH DIDAFTARKAN RANAP!!', 'KAMAR : '. $cekKunjungan->kamar.' BED : '.$cekKunjungan->no_bed
    //         ]);

    //     }
    //     $query_counter  = Kunjungan::where('kode_kunjungan', $request->kode)->where('status_kunjungan', 1)->first();
    //     $ruangan        = Ruangan::firstWhere('id_ruangan', $request->id_ruangan);
    //     $unit           = Unit::firstWhere('kode_unit', $request->unitTerpilih);
    //     // $dokter         = Paramedis::firstWhere('kode_paramedis', $request->dokter_id);
    //     $pasien         = Pasien::where('no_rm', $request->rm)->first();
    //     // dd($request->all(), $unit);
    //     if ($query_counter === null || $ruangan===null || $pasien===null) {
    //         return back()->withErrors([
    //             'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
    //                         ($pasien === null ? 'Pasien Belum Dipilih, ' : '') .
    //                         ($ruangan === null ? 'Ruangan Belum Dipilih, ' : '')
    //                         // ($dokter === null ? ' Dokter Belum Dipilih, ' : '')
    //         ]);
    //     }
    //     $createKunjungan                    = new Kunjungan();
    //     $createKunjungan->counter           = $query_counter->counter;
    //     $createKunjungan->ref_kunjungan     = $request->kode;
    //     $createKunjungan->no_rm             = $request->rm;
    //     $createKunjungan->tgl_masuk         = now();
    //     $createKunjungan->kode_paramedis    = 0;
    //     $createKunjungan->kode_unit         = $unit->kode_unit;
    //     $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
    //     $createKunjungan->kelas             = $ruangan->id_kelas;
    //     $createKunjungan->hak_kelas         = $ruangan->id_kelas;
    //     $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
    //     $createKunjungan->no_bed            = $ruangan->no_bed;
    //     $createKunjungan->kamar             = $ruangan->nama_kamar;
    //     $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
    //     $createKunjungan->kode_penjamin     = $request->penjamin_id;
    //     $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
    //     $createKunjungan->diagx             = $request->diagAwal??NULL;
    //     $createKunjungan->pic2              = Auth::user()->id;
    //     $createKunjungan->pic               = Auth::user()->id_simrs??2;
    //     $createKunjungan->is_ranap_daftar   = 1;
    //     $createKunjungan->form_send_by      = 1;
    //     $createKunjungan->jp_daftar         = ($request->is_proses == 1)? 2 : ($request->penjamin_id == 'P01' ? 0 : 1);
    //     $createKunjungan->no_sep            = $request->inject_sep??Null;
    //     $createKunjungan->no_spri           = $request->inject_spri??Null;
    //     $createKunjungan->save();

    //     $ruangan->status_incharge = 1;
    //     $ruangan->save();
    //     return redirect()->route('pasien.ranap')->with('success', 'Pasien dengan data! Nama: '.$pasien->nama_px.' | RM : '.$pasien->no_rm.' BERHASIL DISIMPAN KE PASIEN RAWAT INAP!!');
    // }
    public function store(Request $request)
    {
        $statusRuangan  = $request->status_persiapan;
        $query_counter  = Kunjungan::where('kode_kunjungan', $request->kode)->where('status_kunjungan', 1)->first();
        $pasien         = Pasien::where('no_rm', $request->rm)->first();

        $createKunjungan                    = new Kunjungan();
        $createKunjungan->counter           = $query_counter->counter;
        $createKunjungan->ref_kunjungan     = $request->kode;
        $createKunjungan->no_rm             = $request->rm;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->jp_daftar         = ($request->is_proses == 1)? 2 : ($request->penjamin_id == 'P01' ? 0 : 1);
        $createKunjungan->no_sep            = $request->inject_sep??Null;
        $createKunjungan->no_spri           = $request->inject_spri??Null;
        $createKunjungan->kode_penjamin     = $request->penjamin_id;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs??2;
        $createKunjungan->is_ranap_daftar   = 1;
        $createKunjungan->form_send_by      = 1;

        if($statusRuangan ==1)
        {
            $ruangan        = Ruangan::firstWhere('id_ruangan', '991');
            $unit           = Unit::firstWhere('kode_unit', '0000');

            $createKunjungan->status_kunjungan  = 14;
            $createKunjungan->kode_unit         = $unit->kode_unit;
            $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
            $createKunjungan->kelas             = $ruangan->id_kelas;
            $createKunjungan->hak_kelas         = $ruangan->id_kelas;
            $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
            $createKunjungan->no_bed            = $ruangan->no_bed;
            $createKunjungan->kamar             = $ruangan->nama_kamar;
            $createKunjungan->save();

        }else{
            $ruangan        = Ruangan::firstWhere('id_ruangan', $request->id_ruangan);
            $unit           = Unit::firstWhere('kode_unit', $request->unitTerpilih);
            $pasien         = Pasien::where('no_rm', $request->rm)->first();
            if ($query_counter === null || $unit === null  || $ruangan===null) {
                return back()->withErrors([
                    'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
                                ($ruangan === null ? 'Ruangan Belum Dipilih' : '')
                ]);
            }
            $createKunjungan->kode_unit         = $unit->kode_unit;
            $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
            $createKunjungan->kelas             = $ruangan->id_kelas;
            $createKunjungan->hak_kelas         = $ruangan->id_kelas;
            $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
            $createKunjungan->no_bed            = $ruangan->no_bed;
            $createKunjungan->kamar             = $ruangan->nama_kamar;
            $createKunjungan->status_kunjungan  = 1;
            if($createKunjungan->save())
            {
                $ruangan->status_incharge = 1;
                $ruangan->save();
            }
        }
        return redirect()->route('pasien.ranap')->with('success', 'Pasien dengan data! Nama: '.$pasien->nama_px.' | RM : '.$pasien->no_rm);
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
        $updateRuangan    = Ruangan::where('id_ruangan',$request->id_ruangan)->first();

        $kunjungan->id_ruangan          = $updateRuangan->id_ruangan;
        $kunjungan->kamar               = $updateRuangan->nama_kamar;
        $kunjungan->kelas               = $updateRuangan->id_kelas;
        $kunjungan->hak_kelas           = $updateRuangan->id_kelas;
        $kunjungan->no_bed              = $updateRuangan->no_bed;
        $kunjungan->kode_unit           = $unit->kode_unit;
        $kunjungan->prefix_kunjungan    = $unit->prefix_unit;
        $kunjungan->status_kunjungan    = 1;
        if($kunjungan->save())
        {
            $ruangan    = Ruangan::where('id_ruangan', $kunjungan->id_ruangan)->first();
            $ruangan->status_incharge = 0;
            $ruangan->save();
        }
        return back();
    }

    public function updateDiagnosaKunjungan(Request $request)
    {

        // Ambil data kunjungan dengan relasi yang diperlukan
        $kunjungan = Kunjungan::with(['bpjsCheckHistories', 'pasien'])
        ->where('kode_kunjungan', $request->kode_update)
        ->first();

        // Cek jika kunjungan ada
        if ($kunjungan) {
            // Ambil diagnosa berdasarkan kode diagnosa awal
            $diagnosa_ts = Icd10::where('diag', $request->diagAwal)->first();

            // Cek jika diagnosa ditemukan
            if ($diagnosa_ts) {
                $kunjungan->diagx = $diagnosa_ts->diag . ' | ' . $diagnosa_ts->nama;
            }

            // Cek jika bpjsCheckHistories dan pasien ada
            if ($kunjungan->bpjsCheckHistories && $kunjungan->pasien) {
                $kunjungan->bpjsCheckHistories->noKartu     = $kunjungan->pasien->no_Bpjs;
                $kunjungan->bpjsCheckHistories->diagAwal    = $diagnosa_ts->diag;
                $kunjungan->bpjsCheckHistories->save();
            }
            $kunjungan->save();
            return back();
        }
    }
}
