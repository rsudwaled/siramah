<?php

namespace App\Http\Controllers\IGD\PPRI;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Unit;
use App\Models\AlasanMasuk;
use App\Models\Paramedis;
use App\Models\Penjamin;
use App\Models\PenjaminSimrs;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\TarifLayananDetail;
use App\Models\AntrianPasienIGD;
use App\Models\JPasienIGD;
use App\Models\HistoriesIGDBPJS;

class PPRIController extends Controller
{
    public function kunjunganPoli(Request $request)
    {
        $poli = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $alasanmasuk = AlasanMasuk::orderBy('id', 'asc')->get();
        $paramedis   = Paramedis::where('act', 1)->get();
        $penjamin    = PenjaminSimrs::orderBy('kode_penjamin', 'asc')->get();
        $unit        = Unit::whereIn('kode_unit', ['4002', '4008', '4010', '4011', '3014', '3002', '3003', '3007', '3020'])->orderBy('id', 'asc')->get();
        $tanggal     = now()->format('Y-m-d');
        return view('simrs.igd.ppri.index', compact(
            'poli',
            'alasanmasuk',
            'paramedis',
            'penjamin',
            'unit',
            'unit',
            'tanggal'
        ));
    }

    public function postPPRI(Request $request)
    {
        $unit           = Unit::firstWhere('kode_unit', '=', '1044');
        $penjamin_bpjs  = PenjaminSimrs::whereIn('kode_penjamin', ['P07', 'P08', 'P09', 'P10', 'P011', 'P13', 'P14'])->get();
        $penjamin_lainnya  = PenjaminSimrs::whereIn('kode_penjamin', ['P15', 'P16', 'P18', 'P19', 'P23', 'P24', 'P25', 'P26', 'P28', 'P30'])->get();
        $codeToCheck = $request->penjamin_id;
        if ($penjamin_bpjs->contains('kode_penjamin', $codeToCheck)) {
            // jika terdapat pada penjamin bpjs maka bpjs =1 sama dengan true
            $bpjs = 1;
        } else {
            if ($penjamin_lainnya->contains('kode_penjamin', $codeToCheck)) {
                // bukan penjamin bpjs
                $bpjs = 3;
            } else {
                // penjamin pribadi
                $bpjs = 0;
            }
        }
        $query          = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk', 'desc');
        $latestCounter  = $query->where('status_kunjungan', '=', 2)->first();

        $data           = Kunjungan::where('no_rm', $request->rm)->orderBy('tgl_masuk', 'desc')->where('status_kunjungan', '=', 1)->get();
        $pasien         = Pasien::where('no_rm', $request->rm)->first();
        if (is_null($pasien->no_hp)) {
            $pasien->no_hp = $request->noTelp;
            $pasien->save();
        }

        if ($data->count() > 0) {
            Alert::error('Proses Daftar Gagal!!', 'pasien masih memiliki status kunjungan belum ditutup / aktif!');
            return back();
        }

        // counter increment
        if ($latestCounter === null) {
            $c = 1;
        } else {
            $c = $latestCounter->counter + 1;
        }
        $dokter     = Paramedis::firstWhere('kode_paramedis', $request->dokter_id);

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
        $createKunjungan->perujuk           = $request->nama_perujuk ?? null;
        $createKunjungan->is_ranap_daftar   = 0;
        $createKunjungan->form_send_by      = 0;
        $createKunjungan->is_bpjs_proses    = 0;
        $createKunjungan->jp_daftar         = $bpjs;
        $createKunjungan->pic2              = Auth::user()->id;
        $createKunjungan->pic               = Auth::user()->id_simrs;

        if ($createKunjungan->save()) {
            $jpPasien = new JPasienIGD();
            $jpPasien->kunjungan    = $createKunjungan->kode_kunjungan;
            $jpPasien->rm           = $request->rm;
            $jpPasien->nomorkartu   = $pasien->no_Bpjs;
            $jpPasien->is_bpjs      = $bpjs;
            $jpPasien->save();

            if ($bpjs == 1) {
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
                $histories->klsRawatHak     = $request->kelasRawatHak ?? null;
                $histories->asalRujukan     = '2';
                $histories->tglRujukan      = now();
                $histories->noRujukan       = null;
                $histories->ppkRujukan      = null;
                $histories->diagAwal        = null;
                $histories->lakaLantas      = $request->lakaLantas == null ? 0 : $request->lakaLantas;
                $histories->noLP            = $request->lakaLantas > 0 ? $request->noLP : null;
                $histories->tglKejadian     = $request->lakaLantas > 0 ? $request->tglKejadian : null;
                $histories->keterangan      = $request->lakaLantas > 0 ? $request->keterangan : null;
                $histories->kdPropinsi      = $request->lakaLantas > 0 ? $request->provinsi : null;
                $histories->kdKabupaten     = $request->lakaLantas > 0 ? $request->kabupaten : null;
                $histories->kdKecamatan     = $request->lakaLantas > 0 ? $request->kecamatan : null;
                $histories->response        = null;
                $histories->is_bridging     = 0;
                $histories->status_daftar   = 0;
                $histories->unit            = $unit->kode_unit;
                $histories->save();
            }

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan === null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            $tarif_karcis           = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
            $total_bayar_k_a        =  80000;

            $layanandet             = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
            $nomorlayanandetkarc    = substr($layanandet->id_layanan_detail, 9) + 1;
            // create layanan header
            $createLH                       = new Layanan();
            $createLH->kode_layanan_header  = $kodelayanan;
            $createLH->tgl_entry            = now();
            $createLH->kode_kunjungan       = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit            = $unit->kode_unit;
            $createLH->pic                  = Auth::user()->id??2;
            $createLH->status_pembayaran    = 'OPN';
            if ($unit->kelas_unit == 1) {
                $createLH->kode_tipe_transaksi  = 1;
                $createLH->status_layanan       = 3; // status 3 nanti di update jadi 1
                $createLH->total_layanan        = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->kode_tipe_transaksi  = 1;
                    $createLH->status_layanan       = 3; // status 3 nanti di update jadi 1
                    $createLH->tagihan_pribadi  = $total_bayar_k_a;
                } else {
                    $createLH->kode_tipe_transaksi  = 2;
                    $createLH->status_layanan       = 3; // status 3 nanti di update jadi 1
                    $createLH->tagihan_penjamin = $total_bayar_k_a;
                }

                if ($createLH->save()) {

                    // create detail karcis
                    $createKarcis                           = new LayananDetail();
                    $createKarcis->id_layanan_detail        = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                    $createKarcis->kode_layanan_header      = $createLH->kode_layanan_header;
                    $createKarcis->kode_tarif_detail        = $unit->kode_tarif_karcis;
                    $createKarcis->total_tarif              = 80000;
                    $createKarcis->jumlah_layanan           = 1;
                    $createKarcis->total_layanan            = 80000;
                    $createKarcis->grantotal_layanan        = 80000;
                    $createKarcis->status_layanan_detail    = 'OPN';
                    $createKarcis->tgl_layanan_detail       = now();
                    $createKarcis->tgl_layanan_detail_2     = now();
                    $createKarcis->row_id_header            = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createKarcis->tagihan_pribadi      = 80000;
                    } else {
                        $createKarcis->tagihan_penjamin     = 80000;
                    }
                    if ($createKarcis->save()) {

                        $createKunjungan->status_kunjungan = 1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                        $createKunjungan->update();

                        if ($request->penjamin_id == 'P01') {
                            $createLH->status_layanan       = 1;
                        } else {
                            $createLH->status_layanan       = 2;
                        }
                        $createLH->update();
                    }
                }
            }
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->rm . ' berhasil didaftarkan!');
        return redirect()->route('daftar-igd.v1');
    }
}
