<?php

namespace App\Http\Controllers\IGD\Ranap;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\PasienBayiIGD;
use App\Models\AlasanMasuk;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Unit;
use App\Models\Spri;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\TarifLayanan;
use App\Models\TarifLayananDetail;
use App\Models\Layanan;
use App\Models\LayananDetail;
use DB;
use Auth;

class RanapController extends APIController
{

    public function listPasienRanap(Request $request)
    {
        $assesmentRanap = DB::connection('mysql2')->table('ts_kunjungan')
                    ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
                    ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
                    ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
                    ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
                    ->join('di_pasien_diagnosa_frunit', 'ts_kunjungan.kode_kunjungan', '=', 'di_pasien_diagnosa_frunit.kode_kunjungan')
                    ->select(
                        'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                        'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep',
                        'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx',
                        'mt_unit.nama_unit as nama_unit',
                        'mt_status_kunjungan.status_kunjungan as status',
                        'ts_jp_igd.is_bpjs as status_pasien_daftar',
                        'di_pasien_diagnosa_frunit.is_ranap as status_ranap',
                    )
                    ->where('ts_kunjungan.is_daftar_ranap', 0)
                    ->where('di_pasien_diagnosa_frunit.is_ranap', 1)
                    ->orderBy('tgl_kunjungan', 'desc')->get();
        // dd($assesmentRanap);
        $paramedis = Paramedis::whereNotNull('kode_dokter_jkn')
            ->get();
        return view('simrs.igd.ranap.assesment_ranap', compact('request','assesmentRanap','paramedis'));
    }

    public function ranapUmum(Request $request, $rm, $kunjungan)
    {
        $pasien = Pasien::where('no_rm', $rm)->first();
        $kunjungan = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        $paramedis = Paramedis::where('spesialis', 'UMUM')
            ->where('act', 1)
            ->get();
        $unit = Unit::where('kelas_unit', 2)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $penjamin = PenjaminSimrs::get();
        return view('simrs.igd.ranap.form_ranap', compact('pasien', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis'));
    }

    public function pasienRanapStore(Request $request)
    {
        
        $validator = $request->validate([
            'tanggal_daftar' => 'required|date',
            'kodeKunjungan' => 'required',
            'noMR' => 'required',
            'penjamin_id' => 'required',
            'idRuangan' => 'required',
            'alasan_masuk_id' => 'required',
            'noTelp' => 'required',
            'dpjp' => 'required',
        ]);
        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }
        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->ref_kunjungan     = $request->kodeKunjungan;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->dpjp;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin_simrs;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->id_ruangan        = $request->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->pic               = Auth::user()->id;
        if ($createKunjungan->save()) {
            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
                    $createAdm->id_layanan_detail   = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail   = $unit->kode_tarif_karcis;
                    $createAdm->total_tarif         = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan      = 1;
                    $createAdm->total_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan   = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->status_layanan_detail   = 'OPN';
                    $createAdm->tgl_layanan_detail      = now();
                    $createAdm->tgl_layanan_detail_2    = now();
                    $createAdm->row_id_header           = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi     = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin    = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->is_daftar_ranap = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan!');
        return redirect()->route('list-assesment.ranap');
    }

    public function createSPRI(Request $request)
    {
        dd($request->all());
        $vclaim = new VclaimController();
        $response = $vclaim->spri_insert($request);
        if ($response->metadata->code == 200) {
            $spri = $response->response;
            Spri::create([
                'noSPRI' => $spri->noSPRI,
                'tglRencanaKontrol' => $spri->tglRencanaKontrol,
                'namaDokter' => $spri->namaDokter,
                'noKartu' => $spri->noKartu,
                'nama' => $spri->nama,
                'kelamin' => $spri->kelamin,
                'tglLahir' => $spri->tglLahir,
                'namaDiagnosa' => $spri->namaDiagnosa,

                'kodeDokter' => $request->kodeDokter,
                'poliKontrol' => $request->poliKontrol,
                'user' => $request->user,
            ]);
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return $response;
    }


    // pasien ranap bayi
    public function ranapBPJSBayi(Request $request)
    {
        $pasien = PasienBayiIGD::firstWhere('rm_bayi', $request->rmby);
        $vlcaim = new VclaimController();
        $request['nomorkartu'] = $request->nomorkartu;
        $request['tanggal'] = now()->format('Y-m-d');
        $res = $vlcaim->peserta_nomorkartu($request);
        // dd($request->all(), $pasienBayi, $res);
        $kodeKelas = $res->response->peserta->hakKelas->kode;
        $kelas = $res->response->peserta->hakKelas->keterangan;
        $alasanmasuk = AlasanMasuk::whereNotIn('id', [2,7, 3,13,9])->get();
        $icd = Icd10::limit(15)->get();
        return view('simrs.igd.ranapbayi.bayi_bpjs', compact('kodeKelas','kelas','pasien','alasanmasuk','icd'));
    }
    
    public function getBedByRuangan(Request $request)
    {
        $bed = Ruangan::where('kode_unit', $request->unit)
            ->where('id_kelas', $request->kelas)
            ->where('status', 1)
            ->where('status_incharge', 0)
            ->get();
        return response()->json([
            'bed' => $bed,
        ]);
    }

    public function formRanapBayi($rm)
    {
        $cekKunjungan = Kunjungan::where('no_rm', $rm)->whereDate('tgl_masuk', now())->get();
        if($cekKunjungan->count() > 0)
        {
            Alert::info('Pasien Sudah Daftar!!', 'pasien dg RM: ' . $rm . ' sudah terdaftar dikunjungan hari!');
            return redirect()->route('pasien-bayi.cari');
        }
        $pasien = Pasien::firstWhere('no_rm', $rm);
        $unit = Unit::whereIn('kode_unit', [2004, 2013])->get();
        $penjamin = PenjaminSimrs::get();
        $paramedis = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $alasanmasuk = AlasanMasuk::whereIn('id', [1,4,5,7,12,15,13])->get();
        return view('simrs.igd.ranapbayi.bayi_umum', compact('pasien', 'unit','penjamin','paramedis','alasanmasuk'));
    }


    public function ranapBayiStore(Request $request)
    {
        $cekKunjungan = Kunjungan::where('no_rm', $request->noMR)->whereDate('tgl_masuk', now())->get();
        if($cekKunjungan->count() > 0)
        {
            Alert::success('Pasien Sudah Daftar!!', 'pasien dg RM: ' . $request->noMR . ' sudah terdaftar dikunjungan!');
            return redirect()->route('pasien-bayi.cari');
        }
        $validator = $request->validate([
            'tanggal_daftar' => 'required|date',
            'noMR' => 'required',
            'penjamin_id' => 'required',
            'idRuangan' => 'required',
            'alasan_masuk_id' => 'required',
            'dpjp' => 'required',
        ]);

        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }

        $penjamin = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit = Unit::firstWhere('kode_unit', $ruangan->kode_unit);

        $createKunjungan = new Kunjungan();
        $createKunjungan->counter           = $c;
        $createKunjungan->no_rm             = $request->noMR;
        $createKunjungan->kode_unit         = $unit->kode_unit;
        $createKunjungan->tgl_masuk         = now();
        $createKunjungan->kode_paramedis    = $request->dpjp;
        $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
        $createKunjungan->kode_penjamin     = $penjamin->kode_penjamin_simrs;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         =  $ruangan->id_kelas;
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->id_ruangan        = $request->idRuangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->pic2               = Auth::user()->id;
        if ($createKunjungan->save()) {
            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }
            $kodeTarifDetail = $unit->kode_tarif_adm . $ruangan->id_kelas; //kode tarif detail
            $tarif_adm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $kodeTarifDetail);
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 2) {
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 1;
                    $createLH->tagihan_pribadi      = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 2;
                    $createLH->tagihan_penjamin     = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc    = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail admn
                    $createAdm = new LayananDetail();
                    $createAdm->id_layanan_detail   = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail   = $unit->kode_tarif_karcis;
                    $createAdm->total_tarif         = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan      = 1;
                    $createAdm->total_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan   = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->status_layanan_detail   = 'OPN';
                    $createAdm->tgl_layanan_detail      = now();
                    $createAdm->tgl_layanan_detail_2    = now();
                    $createAdm->row_id_header           = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createAdm->tagihan_pribadi = $total_bayar_k_a;
                    } else {
                        $createAdm->tagihan_penjamin = $total_bayar_k_a;
                    }

                    if ($createAdm->save()) {
                        $createKunjungan->status_kunjungan = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->is_daftar_ranap = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' berhasil didaftarkan!');
        return redirect()->route('kunjungan.ranap');
    }
}
