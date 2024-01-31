<?php

namespace App\Http\Controllers\IGD\PasienKecelakaan;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjaminSimrs;
use App\Models\AlasanMasuk;
use App\Models\Paramedis;
use App\Models\Unit;
use App\Models\Pasien;
use App\Models\Layanan;
use App\Models\Kunjungan;
use App\Models\JPasienIGD;
use App\Models\LayananDetail;
use App\Models\HistoriesIGDBPJS;
use App\Models\PasienKecelakaan;
use App\Models\TarifLayananDetail;
use App\Models\Provinsi;
use RealRashid\SweetAlert\Facades\Alert;

class PasienKecelakaanController extends Controller
{
    public function listPasienKecelakaan(Request $request)
    {
        $date       = $request->date;
        $query      = Kunjungan::where('lakalantas','>', 0);

        if($request->date != null)
        {
            $query->whereDate('tgl_masuk', $request->date);
        }

        $kunjungan  = $query->get();

        return view('simrs.igd.pasien_kecelakaan.list_pasien', compact('request','kunjungan'));
    }

    public function detailPasienKecelakaan($kunjungan)
    {
        $kunjungan = Kunjungan::with('pasienKecelakaan')->where('kode_kunjungan', $kunjungan)->first();
        return view('simrs.igd.pasien_kecelakaan.detail_kecelakaan', compact('kunjungan'));
    }

    public function index(Request $request)
    {
        $pasien = null;
        if(!empty($request->rm) || !empty($request->nama) ||  !empty($request->nomorkartu) || !empty($request->nik))
        {
            $query = Pasien::query();
            if ($request->rm && !empty($request->rm)) {
                $query->where('no_rm', $request->rm);
            }
            if ($request->nama && !empty($request->nama)) {
                $query->where('nama_px', 'LIKE', '%' . $request->nama . '%');
            }
            if ($request->nomorkartu && !empty($request->nomorkartu)) {
                $query->where('no_Bpjs', $request->nomorkartu);
            }
            if($request->nik && !empty($request->nik))
            {
                $query->where('nik_bpjs', $request->nik);
            }
            $pasien = $query->limit(100)->get();
        }
       
        return view('simrs.igd.pasien_kecelakaan.index', compact('request','pasien'));
    }

    public function create(Request $request)
    {
        $pasien         = Pasien::firstWhere('no_rm', $request->rm);
        $alasanmasuk    = AlasanMasuk::whereIn('id',['2','3'])->get();
        $paramedis      = Paramedis::where('act', 1)->get();
        $penjamin       = PenjaminSimrs::get();
        $provinsi       = Provinsi::all();

        return view('simrs.igd.pasien_kecelakaan.create', compact('provinsi','alasanmasuk','paramedis','penjamin','pasien'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'tanggal_daftar'    => 'required|date',
                'isBpjs'            => 'required',
                'alasan_masuk_id'   => 'required',
                'lakaLantas'        => 'required',
                'isPerujuk'         => 'required',
                'dokter_id'         => 'required',
                'penjamin_id'       => 'required',
                'noTelp'            => 'required',
                'provinsi'          => 'required',
                'kabupaten'         => 'required',
                'kecamatan'         => 'required',
                'noLP'              => 'required',
                'keterangan'        => 'required',
                'tglKejadian'       => 'required',
            ],
            [
                'tanggal_daftar'    => 'tanggal daftar belum dipilih',
                'isBpjs'            => 'jenis pasien bpjs / umum wajib dipilih',
                'alasan_masuk_id'   => 'alasan masuk wajib dipilih',
                'lakaLantas'        => 'status laka lantas wajib dipilih',
                'isPerujuk'         => 'pasien memiliki instansi rujukan atau tanpa rujukan',
                'dokter_id'         => 'dokter wajib dipilih',
                'penjamin_id'       => 'penjamin wajib dipilih',
                'noTelp'            => 'no telepon wajib diisi',
                'provinsi'          => 'provinsi kejadian wajib dipilih',
                'kabupaten'         => 'kabupaten kejadian wajib dipilih',
                'kecamatan'         => 'kecamatan kejadian wajib dipilih',
                'noLP'              => 'no laporan polisi wajib diisi',
                'keterangan'        => 'keterangan kejadian wajib diisi',
                'tglKejadian'       => 'tanggal kejadian wajib dipilih',
            ],
        );

         // counter increment
         $counter = Kunjungan::latest('counter')
         ->where('no_rm', $request->rm)
         ->where('status_kunjungan', 2)
         ->first();
     if ($counter == null) {
         $c = 1;
     } else {
         $c = $counter->counter + 1;
     }
     
     $unit   = Unit::firstWhere('kode_unit', '1002');
     $pasien = Pasien::where('no_rm', $request->rm)->first();
     $dokter = Paramedis::firstWhere('kode_paramedis', $request->dokter_id);
     
     $createKunjungan                    = new Kunjungan();
     $createKunjungan->counter           = $c;
     $createKunjungan->no_rm             = $request->rm;
     $createKunjungan->kode_unit         = $unit->kode_unit;
     $createKunjungan->tgl_masuk         = now();
     $createKunjungan->kode_paramedis    = $request->dokter_id;
     $createKunjungan->status_kunjungan  = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
     $createKunjungan->prefix_kunjungan  = $unit->prefix_unit;
     $createKunjungan->kode_penjamin     = $request->penjamin_id;
     $createKunjungan->kelas             = 3;
     $createKunjungan->id_alasan_masuk   = $request->alasan_masuk_id;
     $createKunjungan->perujuk           = $request->nama_perujuk??null;
     $createKunjungan->lakaLantas        = $request->lakaLantas == null ? 0 : $request->lakaLantas;
     $createKunjungan->is_ranap_daftar   = 0;
     $createKunjungan->form_send_by      = 0;
     $createKunjungan->jp_daftar         =  $request->isBpjs;
     $createKunjungan->pic2              = Auth::user()->id;
    //  $createKunjungan->pic = Auth::user()->id;
     if ($createKunjungan->save()) {
         $jpPasien               = new JPasienIGD();
         $jpPasien->kunjungan    = $createKunjungan->kode_kunjungan;
         $jpPasien->rm           = $request->rm;
         $jpPasien->nomorkartu   = $pasien->no_Bpjs;
         $jpPasien->is_bpjs      = $request->isBpjs;
         $jpPasien->save();

         if($request->isBpjs == 1)
         {
             $histories = new HistoriesIGDBPJS();
             $histories->kode_kunjungan  = $createKunjungan->kode_kunjungan;
             $histories->noMR            = $createKunjungan->no_rm;
             $histories->noKartu         = trim($pasien->no_Bpjs);
             $histories->ppkPelayanan    = '1018R001';
             $histories->dpjpLayan       = $dokter->kode_dokter_jkn;
             $histories->user            = Auth::user()->name;
             $histories->noTelp          = $request->noTelp;
             $histories->tglSep          = now();
             $histories->jnsPelayanan    = '2';
             $histories->klsRawatHak     = $hakKelas??null;
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
         }else{
            $historiesUmum = new PasienKecelakaan();
            $historiesUmum->kode_kunjungan  = $createKunjungan->kode_kunjungan;
            $historiesUmum->lakaLantas      = $request->lakaLantas == null ? 0 : $request->lakaLantas;
            $historiesUmum->noLP            = $request->lakaLantas > 0 ? $request->noLP:null;
            $historiesUmum->tglKejadian     = $request->lakaLantas > 0 ? $request->tglKejadian:null;
            $historiesUmum->keterangan      = $request->lakaLantas > 0 ? $request->keterangan:null;
            $historiesUmum->kdPropinsi      = $request->lakaLantas > 0 ? $request->provinsi:null;
            $historiesUmum->kdKabupaten     = $request->lakaLantas > 0 ? $request->kabupaten:null;
            $historiesUmum->kdKecamatan     = $request->lakaLantas > 0 ? $request->kecamatan:null;
            $historiesUmum->save();
         }

         $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
         if ($kodelayanan == null) {
             $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
         }

         $tarif_karcis           = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
         $tarif_adm              = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
         $total_bayar_k_a        = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;

         $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
         $nomorlayanandetkarc    = substr($layanandet->id_layanan_detail, 9) + 1;
         $nomorlayanandetadm     = substr($layanandet->id_layanan_detail, 9) + 2;
         // create layanan header
         $createLH                       = new Layanan();
         $createLH->kode_layanan_header  = $kodelayanan;
         $createLH->tgl_entry            = now();
         $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
         $createLH->kode_unit            = $unit->kode_unit;
         $createLH->pic                  = Auth::user()->id;
         $createLH->status_pembayaran    = 'OPN';
         if ($unit->kelas_unit == 1) {
             $createLH->kode_tipe_transaksi  = 1;
             $createLH->status_layanan       = 3; // status 3 nanti di update jadi 1
             $createLH->total_layanan        = $total_bayar_k_a;

             if ($request->penjamin_id == 'P01') {
                 $createLH->tagihan_pribadi = $total_bayar_k_a;
             } else {
                 $createLH->tagihan_penjamin = $total_bayar_k_a;
             }

             if ($createLH->save()) {

                 // create detail karcis
                 $createKarcis                           = new LayananDetail();
                 $createKarcis->id_layanan_detail        = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                 $createKarcis->kode_layanan_header      = $createLH->kode_layanan_header;
                 $createKarcis->kode_tarif_detail        = $unit->kode_tarif_karcis;
                 $createKarcis->total_tarif              = $tarif_karcis->TOTAL_TARIF_CURRENT;
                 $createKarcis->jumlah_layanan           = 1;
                 $createKarcis->total_layanan            = $tarif_karcis->TOTAL_TARIF_CURRENT;
                 $createKarcis->grantotal_layanan        = $tarif_karcis->TOTAL_TARIF_CURRENT;
                 $createKarcis->status_layanan_detail    = 'OPN';
                 $createKarcis->tgl_layanan_detail       = now();
                 $createKarcis->tgl_layanan_detail_2     = now();
                 $createKarcis->row_id_header            = $createLH->id;
                 if ($request->penjamin_id == 'P01') {
                     $createKarcis->tagihan_pribadi      = $tarif_karcis->TOTAL_TARIF_CURRENT;
                 } else {
                     $createKarcis->tagihan_penjamin     = $tarif_karcis->TOTAL_TARIF_CURRENT;
                 }
                 if ($createKarcis->save()) {
                     // create detail admin
                     $createAdm                          = new LayananDetail();
                     $createAdm->id_layanan_detail       = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                     $createAdm->kode_layanan_header     = $createLH->kode_layanan_header;
                     $createAdm->kode_tarif_detail       = $unit->kode_tarif_adm;
                     $createAdm->total_tarif             = $tarif_adm->TOTAL_TARIF_CURRENT;
                     $createAdm->jumlah_layanan          = 1;
                     $createAdm->total_layanan           = $tarif_adm->TOTAL_TARIF_CURRENT;
                     $createAdm->grantotal_layanan       = $tarif_adm->TOTAL_TARIF_CURRENT;
                     $createAdm->status_layanan_detail   = 'OPN';
                     $createAdm->tgl_layanan_detail      = now();
                     $createAdm->tgl_layanan_detail_2    = now();
                     $createAdm->row_id_header           = $createLH->id;
                     if ($request->penjamin_id == 'P01') {
                         $createAdm->tagihan_pribadi     = $tarif_adm->TOTAL_TARIF_CURRENT;
                     } else {
                         $createAdm->tagihan_penjamin    = $tarif_adm->TOTAL_TARIF_CURRENT;
                     }
                     
                     if($createAdm->save())
                     {
                         $createKunjungan->status_kunjungan = 1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                         $createKunjungan->update();

                         $createLH->status_layanan = 1; // status 3 nanti di update jadi 1
                         $createLH->update();
                     }
                 }
             }
         } 
     }
     Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->rm . ' berhasil didaftarkan!');
     return redirect()->route('pasien-kecelakaan.list');
    }
}
