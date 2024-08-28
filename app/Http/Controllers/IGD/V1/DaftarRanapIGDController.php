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
                ->where('status_kunjungan', 1)->get();
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

    public function store(Request $request)
    {
        if(empty($request->rm))
        {
            return back()->withErrors([
                'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
                            ($request->rm === null ? 'Pasien Belum Dipilih, ' : '')
            ]);
        }
        $cekKunjungan   = Kunjungan::where('no_rm',$request->rm)->whereNotNull('id_ruangan')->where('status_kunjungan', 1)->first();
        if(!empty($cekKunjungan))
        {
            return back()->withErrors([
                'alert' => 'PASIEN SUDAH DIDAFTARKAN RANAP!!', 'KAMAR : '. $cekKunjungan->kamar.' BED : '.$cekKunjungan->no_bed
            ]);

        }
        $query_counter  = Kunjungan::where('kode_kunjungan', $request->kode)->where('status_kunjungan', 1)->first();
        $ruangan        = Ruangan::firstWhere('id_ruangan', $request->id_ruangan);
        $unit           = Unit::firstWhere('kode_unit', $request->unitTerpilih);
        // $dokter         = Paramedis::firstWhere('kode_paramedis', $request->dokter_id);
        $pasien         = Pasien::where('no_rm', $request->rm)->first();
        // dd($request->all(), $unit);
        if ($query_counter === null || $ruangan===null || $pasien===null) {
            return back()->withErrors([
                'alert' => 'Data yang di input tidak lengkap, silakan periksa kembali! pada bagian : ' .
                            ($pasien === null ? 'Pasien Belum Dipilih, ' : '') .
                            ($ruangan === null ? 'Ruangan Belum Dipilih, ' : '')
                            // ($dokter === null ? ' Dokter Belum Dipilih, ' : '')
            ]);
        }
        $createKunjungan                    = new Kunjungan();
        $createKunjungan->counter           = $query_counter->counter;
        $createKunjungan->ref_kunjungan     = $request->kode;
        $createKunjungan->no_rm             = $request->rm;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = 0;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $ruangan->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->kode_penjamin     = $request->penjamin_id;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->diagx             = $request->diagAwal??NULL;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs??2;
        $createKunjungan->is_ranap_daftar   = 1;
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = ($request->is_proses == 1)? 2 : ($request->penjamin_id == 'P01' ? 0 : 1);
        $createKunjungan->no_sep            = $request->inject_sep??Null;
        $createKunjungan->no_spri           = $request->inject_spri??Null;
        $createKunjungan->save();
        // if($createKunjungan->save())
        // {
        //     $ruangan->status_incharge = 1;
        //     $ruangan->save();

        //     if($createKunjungan->kode_penjamin != 'P01' || $createKunjungan->jp_daftar != 2)
        //     {
        //         $api = new VclaimController();
        //         $request = new Request([
        //             "nik"        => $pasien->nik_bpjs,
        //             "tanggal"    => now()->format('Y-m-d'),
        //         ]);
        //         $data    = $api->peserta_nik($request);

        //         $histories = new HistoriesIGDBPJS();
        //         $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
        //         $histories->noMR            = $pasien->no_rm;
        //         $histories->noKartu         = trim($pasien->no_Bpjs)??Null;
        //         $histories->ppkPelayanan    = '1018R001';
        //         $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
        //         $histories->user            = Auth::user()->name;
        //         $histories->noTelp          = $pasien->no_hp??$pasien->no_tlp;
        //         $histories->tglSep          = now();
        //         $histories->jnsPelayanan    = '1';
        //         $histories->klsRawatHak     = $data->response->peserta->hakKelas->kode ?? null;
        //         $histories->asalRujukan     = '2';
        //         $histories->tglRujukan      = now();
        //         $histories->noRujukan       = null;
        //         $histories->ppkRujukan      = null;
        //         $histories->diagAwal        = $request->diagAwal??NULL;
        //         $histories->lakaLantas      = Null;
        //         $histories->noLP            = Null;
        //         $histories->tglKejadian     = Null;
        //         $histories->keterangan      = Null;
        //         $histories->kdPropinsi      = Null;
        //         $histories->kdKabupaten     = Null;
        //         $histories->kdKecamatan     = Null;
        //         $histories->response        = Null;
        //         $histories->is_bridging     = 0;
        //         $histories->status_daftar   = 0;
        //         $histories->unit            = $unit->kode_unit;
        //         $histories->save();
        //     }
        // }
        return redirect()->route('pasien.ranap')->with('success', 'Pasien dengan data! Nama: '.$pasien->nama_px.' | RM : '.$pasien->no_rm.' BERHASIL DISIMPAN KE PASIEN RAWAT INAP!!');
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
