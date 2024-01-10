<?php

namespace App\Http\Controllers\IGD\Ranap;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\PasienBayiIGD;
use App\Models\AlasanMasuk;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Unit;
use App\Models\Spri;
use App\Models\Icd10;
use App\Models\Ruangan;
use App\Models\TarifLayananDetail;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\HistoriesIGDBPJS;
use DB;
use Auth;

class RanapController extends APIController
{

    public function listPasienRanap(Request $request)
    {
        $query = DB::connection('mysql2')->table('ts_kunjungan')
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
                    ->where('ts_kunjungan.is_ranap_daftar', 0)
                    ->where('di_pasien_diagnosa_frunit.is_ranap', 1)
                    ->orderBy('tgl_kunjungan', 'desc');
        if($request->tanggal && !empty($request->tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_masuk', $request->tanggal); 
        }

        if($request->unit && !empty($request->unit))
        {
            $query->whereIn('ts_kunjungan.kode_unit', [$request->unit]); 
        }

        if(empty($request->tanggal) && empty($request->unit)){
            $query->whereDate('ts_kunjungan.tgl_masuk', now());
        }
        $assesmentRanap = $query->get();
        $unit           = Unit::whereIn('kode_unit', ['1002','1023'])->get();
        return view('simrs.igd.ranap.assesment_ranap', compact('request','assesmentRanap','unit'));
    }

    public function dataPasienRanap(Request $request)
    {
        $kunjungan = Kunjungan::where([
                ['status_kunjungan','!=', 8],
                ['is_ranap_daftar', 1],
            ])
            ->whereDate('tgl_masuk', now())
            ->get();
        $unit = Unit::where('kelas_unit', 1)->get();
        return view('simrs.igd.ranap.data_pasien_ranap', compact('request','kunjungan','unit'));
    }

    public function ranapUmum(Request $request, $rm, $kunjungan)
    {
        $pasien         = Pasien::where('no_rm', $rm)->first();
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        $paramedis      = Paramedis::where('spesialis', 'UMUM')->where('act', 1)->get();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $alasanmasuk    = AlasanMasuk::limit(10)->get();
        $penjamin       = PenjaminSimrs::get();
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
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $request->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->is_ranap_daftar   = 1;
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 0;
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
            $createLH->status_pembayaran    = 'OPN';
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
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->is_ranap_daftar   = 1; //status 1 pasien sudah di daftarkan ranap
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

    // public function ranapBPJS(Request $request)
    // {
    //     if ($request->no_kartu == null) {
    //         Alert::error('Error!!', 'pasien tidak memiliki no bpjs');
    //         return back();
    //     }
    //     $vlcaim                     = new VclaimController();
    //     $request['nomorkartu']      = $request->no_kartu;
    //     $request['tanggal']         = now()->format('Y-m-d');
    //     $res                        = $vlcaim->peserta_nomorkartu($request);
    //     $kodeKelas                  = $res->response->peserta->hakKelas->kode;
    //     $kelas                      = $res->response->peserta->hakKelas->keterangan;
    //     $refKunj                    = $request->kodeKunjungan;

    //     $pasien         = Pasien::where('no_Bpjs', 'LIKE', '%' .$request->no_kartu. '%')->first();
    //     $kunjungan      = Kunjungan::where('kode_kunjungan', $refKunj)->get();
    //     $unit           = Unit::where('kelas_unit', 2)->get();
    //     $poli           = Unit::whereNotNull('KDPOLI')->get();
    //     $alasanmasuk    = AlasanMasuk::limit(10)->get();
    //     $icd            = Icd10::limit(15)->get();
    //     $penjamin       = PenjaminSimrs::get();
    //     $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
    //     $spri           = Spri::where('noKartu', $request->no_kartu)->where('tglRencanaKontrol', now()->format('Y-m-d'))->first();
    //     return view('simrs.igd.ranap.form_ranap_bpjs', compact('pasien', 'icd', 'poli', 'refKunj', 'kodeKelas', 'kelas', 'spri', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis'));
    // }


    public function daftarRanapBPJS(Request $request, $nomorkartu, $kode)
    {
        $vlcaim                 = new VclaimController();
        $request['nomorkartu']  = trim($nomorkartu);
        $request['tanggal']     = now()->format('Y-m-d');
        $res                    = $vlcaim->peserta_nomorkartu($request);
        $kodeKelas              = $res->response->peserta->hakKelas->kode;
        $kelas                  = $res->response->peserta->hakKelas->keterangan;

        $pasien         = Pasien::where('no_Bpjs', 'LIKE', '%' .$nomorkartu. '%')->first();
        $kunjungan      = Kunjungan::where('kode_kunjungan', $kode)->get();
        $unit           = Unit::where('kelas_unit', 2)->get();
        $poli           = Unit::whereNotNull('KDPOLI')->get();
        $alasanmasuk    = AlasanMasuk::limit(10)->get();
        $icd            = Icd10::limit(15)->get();
        $penjamin       = PenjaminSimrs::get();
        $paramedis      = Paramedis::whereNotNull('kode_dokter_jkn')->get();
        $spri           = Spri::where('noKartu', $nomorkartu)->where('tglRencanaKontrol', now()->format('Y-m-d'))->first();

        return view('simrs.igd.ranap.form_ranap_bpjs', compact('pasien', 'icd', 'poli',  'kodeKelas', 'kelas', 'spri', 'kunjungan', 'unit', 'penjamin', 'alasanmasuk', 'paramedis','request'));
    }

    public function daftarRanapBPJSStore(Request $request)
    {
        if(empty($request->idRuangan))
        {
            Alert::error('RUANGAN BELUM DIPILIH!!', 'silahkan pilih ruangan terlebih dahulu!');
            return back();
        }
        if(empty($request->diagAwal))
        {
            Alert::error('DIAGNOSA BELUM DIPILIH!!', 'silahkan pilih diagnosa terlebih dahulu!');
            return back();
        }
       
        $request->validate(
            [
                'noMR'              => 'required',
                'idRuangan'         => 'required',
                'tanggal_daftar'    => 'required|date',
                'noTelp'            => 'required',
                'alasan_masuk_id'   => 'required',
                'kode_paramedis'    => 'required',
                'penjamin_id'       => 'required',
                'lakaLantas'        => 'required',
            ],
            [
                'tanggal_daftar'    => 'Tanggal daftar wajib dipilih !',
                'kodeKunjungan'     => 'Kode kunjungan tidak ada !',
                'noMR'              => 'Kode Rekam Medis Tidak Ada !',
                'penjamin_id'       => 'Anda belum memilih penjamin !',
                'alasan_masuk_id'   => 'Alasan masuk wajib diisi !',
                'noTelp'            => 'No Telepon wajib diisi !',
                'kode_paramedis'    => 'Dokter DPJP wajib dipilih',
                'lakaLantas'        => 'Status kecelakaan wajib dipilih',
            ],

        );

        $counter = Kunjungan::latest('counter')
            ->where('no_rm', $request->noMR)
            ->where('status_kunjungan', 2)
            ->first();
        if ($counter == null) {
            $c = 1;
        } else {
            $c = $counter->counter + 1;
        }
        // $pasien     = Pasien::firstWhere('no_rm', $request->noMR);
        $penjamin   = PenjaminSimrs::firstWhere('kode_penjamin', $request->penjamin_id);
        $ruangan    = Ruangan::firstWhere('id_ruangan', $request->idRuangan);
        $unit       = Unit::firstWhere('kode_unit', $ruangan->kode_unit);
        $dokter     = Paramedis::firstWhere('kode_dokter_jkn', $request->kode_paramedis);
   
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
        $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
        $createKunjungan->kelas             = $ruangan->id_kelas;
        $createKunjungan->hak_kelas         = $ruangan->id_kelas;
        $createKunjungan->id_ruangan        = $request->id_ruangan;
        $createKunjungan->no_bed            = $ruangan->no_bed;
        $createKunjungan->kamar             = $ruangan->nama_kamar;
        $createKunjungan->is_ranap_daftar   = 1;
        $createKunjungan->form_send_by      = 1;
        $createKunjungan->jp_daftar         = 0;
        $createKunjungan->pic               = Auth::user()->id;
        if ($createKunjungan->save()) {

            $histories = new HistoriesIGDBPJS();
            $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
            $histories->noMR            = $createKunjungan->no_rm;
            $histories->noKartu         = trim($request->noKartuBPJS);
            $histories->ppkPelayanan    = '1018R001';
            $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
            $histories->user            = Auth::user()->name;
            $histories->noTelp          = $request->noTelp;
            $histories->tglSep          = now();
            $histories->jnsPelayanan    = '1';
            $histories->klsRawatHak     = $request->hak_kelas??null;
            $histories->asalRujukan     = '2';
            $histories->tglRujukan      = now();
            $histories->noRujukan       = null;
            $histories->ppkRujukan      = null;
            $histories->diagAwal        = null;
            $histories->lakaLantas      = $request->lakaLantas == null ? 0 : $request->lakaLantas;
            $histories->noLP            = $request->lakaLantas > 0 ? $request->noLP:null;
            $histories->tglKejadian     = $request->lakaLantas > 0 ? $request->tglKejadian:null;
            $histories->keterangan      = $request->lakaLantas > 0 ? $request->keterangan:null;
            $histories->kdPropinsi      = $request->lakaLantas > 0 ? $request->provinsi:null;
            $histories->kdKabupaten     = $request->lakaLantas > 0 ? $request->kabupaten:null;
            $histories->kdKecamatan     = $request->lakaLantas > 0 ? $request->kecamatan:null;
            $histories->response        = null;
            $histories->is_bridging     = 0;
            $histories->status_daftar   = 0;
            $histories->unit            = $unit->kode_unit;
            $histories->save();

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
            $createLH->status_pembayaran    = 'OPN';
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
                    $createAdm->id_layanan_detail       = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                    $createAdm->kode_layanan_header     = $createLH->kode_layanan_header;
                    $createAdm->kode_tarif_detail       = $unit->kode_tarif_karcis;
                    $createAdm->total_tarif             = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->jumlah_layanan          = 1;
                    $createAdm->total_layanan           = $tarif_adm->TOTAL_TARIF_CURRENT;
                    $createAdm->grantotal_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
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
                        $createKunjungan->status_kunjungan  = 1; //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->is_ranap_daftar   = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->update();

                        $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                        $createLH->update();
                    }
                }
            }
        }

        $kunjungan      = Kunjungan::where('kode_kunjungan', $createKunjungan->kode_kunjungan)->first();
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->noMR . ' Selanjutnya Silahkan Buat SPRI dan SEP Rawat Inap!');
        return redirect()->route('create-sepigd.ranap-bpjs',['kunjungan'=> $kunjungan->kode_kunjungan]);
    }

    public function ranapCreateSEPRanap(Request $request)
    {
        // $kunjungan      = Kunjungan::where('kode_kunjungan', $kode)->first();
        $kunjungan      = Kunjungan::where('kode_kunjungan', '22237494')->first();
        return view('simrs.igd.ranap.selesaikan_ranap', compact('kunjungan', 'request'));
    }

    public function createSPRI(Request $request)
    {
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

            $kunjungan = Kunjungan::where('kode_kunjungan', $request->kodeKunjungan)->first();
            $kunjungan->no_spri = $spri->noSPRI;
            $kunjungan->save();
        } else {
            Alert::error('Error', 'Error ' . $response->metadata->code . ' ' . $response->metadata->message);
        }
        return $response;
    }
    public function getSPRI(Request $request)
    {
        $spri = Spri::firstWhere('noSPRI', $request->noSuratKontrol);
        return response()->json([
            'spri' => $spri,
        ]);
    }
    public function updateSPRI(Request $request)
    {
        $vclaim = new VclaimController();
        $res = $vclaim->spri_update($request);
        if ($res->metadata->code == 200) {
            $updateSPRI = Spri::firstWhere('noSPRI', $request->noSPRI);
            $updateSPRI->tglRencanaKontrol = $request->tglRencanaKontrol;
            $updateSPRI->kodeDokter = $request->kodeDokter;
            $updateSPRI->poliKontrol = $request->poliKontrol;
            $updateSPRI->user = $request->user;
            $updateSPRI->update();
        }
        return response()->json([
            'res' => $res,
        ]);
    }

    public function cekProsesDaftarSPRI(Request $request)
    {
        $cekSPRI = Spri::where('noKartu', $request->noKartu)
            ->where('tglRencanaKontrol', now()->format('Y-m-d'))
            ->first();
        // dd($cekSPRI);
        return response()->json([
            'cekSPRI' => $cekSPRI,
        ]);
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
                        $createKunjungan->is_ranap_daftar = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->form_send_by = 1; //status 1 pasien sudah di daftarkan ranap
                        $createKunjungan->jp_daftar = 0; //status 1 pasien sudah di daftarkan ranap
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
