<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Unit;
use App\Models\Paramedis;
use App\Models\PenjaminSimrs;
use App\Models\AlasanMasuk;
use App\Models\Ruangan;
use App\Models\RuanganTerpilihIGD;
use App\Models\AntrianPasienIGD;
use App\Models\PernyataanBPJSPROSES;
use App\Models\TriaseIGD;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\TarifLayanan;
use App\Models\TarifLayananDetail;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IGDUMUMController extends Controller
{
    
    // route yang dipake
    public function listPasienDaftar(Request $request)
    {
        $kunjungan = Kunjungan::where('pic2', Auth::user()->id)->get();
        return view('simrs.igd.kunjungan.list_pasien_byuser', compact('kunjungan'));
    }

    public function updateNOBPJS(Request $request)
    {
        // dd($request->all());
        $data = Pasien::where('nik_bpjs', $request->nik_pas)->first();
        $data->no_Bpjs = $request->no_bpjs;
        $data->update();
        return response()->json($data, 200);
    }

    public function tutupKunjunganPasien(Request $request)
    {
        // dd($request->all());
        if ($request->rm_tk == null && $request->kunjungan_tk) {
            Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
            return back();
        }
        $ttp_k = Kunjungan::where('no_rm', $request->rm_tk)
            ->where('kode_kunjungan', $request->kunjungan_tk)
            ->first();
        if ($ttp_k == null) {
            Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
            return back();
        }
        $ttp_k->status_kunjungan = 2;
        $ttp_k->update();
        Alert::success('success', 'Kunjungan pasien dengan kode : ' . $ttp_k->kode_kunjungan . ' berhasil ditutup');
        return back();
    }
    public function bukaKunjunganPasien(Request $request)
    {
        $buka_k = Kunjungan::where('no_rm', $request->rm_tk)
            ->where('kode_kunjungan', $request->kunjungan_tk)
            ->first();
        if ($buka_k == null) {
            Alert::error('Error!!', 'pasien tidak memiliki kunjungan!');
            return back();
        }
        $buka_k->status_kunjungan = 1;
        $buka_k->update();
        Alert::success('success', 'Kunjungan pasien dengan kode : ' . $buka_k->kode_kunjungan . ' berhasil dibuka');
        return back();
    }

    public function pendaftaranIGDStore(Request $request)
    {
        // dd($request->all());
        $data = Kunjungan::where('no_rm', $request->rm)
            ->where('status_kunjungan', 1)
            ->get();
        if ($data->count() > 0) {
            Alert::error('Proses Daftar Gagal!!', 'pasien masih memiliki status kunjungan belum ditutup!');
            return back();
        }
        $request->validate([
            'nik' => 'required',
            'rm' => 'required',
            'unit' => 'required',
            'dokter_id' => 'required',
            'tanggal' => 'required',
            'penjamin_id' => 'required',
            'alasan_masuk_id' => 'required',
        ]);
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
        $unit = Unit::findOrFail($request->unit);
        $pasien = Pasien::where('no_rm', $request->rm)->first();
        $desa = 'Desa ' . $pasien->desas->nama_desa_kelurahan;
        $kec = 'Kec. ' . $pasien->kecamatans->nama_kecamatan;
        $kab = 'Kab. ' . $pasien->kabupatens->nama_kabupaten_kota;
        $alamat = $pasien->alamat . ' ( ' . $desa . ' - ' . $kec . ' - ' . $kab . ' )';
        
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter = $c;
        $createKunjungan->no_rm = $request->rm;
        $createKunjungan->kode_unit = $unit->kode_unit;
        $createKunjungan->tgl_masuk = now();
        $createKunjungan->kode_paramedis = $request->dokter_id;
        $createKunjungan->status_kunjungan = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan = $unit->prefix_unit;
        $createKunjungan->kode_penjamin = $request->penjamin_id;
        $createKunjungan->kelas = 3;
        $createKunjungan->id_alasan_masuk = $request->alasan_masuk_id;
        $createKunjungan->pic = Auth::user()->id;
        if ($createKunjungan->save()) {
            $ant_upd = AntrianPasienIGD::find($request->id_antrian);
            $ant_upd->no_rm = $request->rm;
            $ant_upd->nama_px = $pasien->nama_px;
            $ant_upd->kode_kunjungan = $createKunjungan->kode_kunjungan;
            $ant_upd->unit = $unit->kode_unit;
            $ant_upd->alamat = $alamat;
            $ant_upd->status = 2;
            $ant_upd->update();

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            $tarif_karcis = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
            $tarif_adm = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header = $kodelayanan;
            $createLH->tgl_entry = now();
            $createLH->kode_kunjungan = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit = $unit->kode_unit;
            $createLH->pic = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 1) {
                $createLH->kode_tipe_transaksi = 1;
                $createLH->status_layanan = 3; // status 3 nanti di update jadi 1
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->tagihan_pribadi = $total_bayar_k_a;
                } else {
                    $createLH->tagihan_penjamin = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail karcis
                    $createKarcis = new LayananDetail();
                    $createKarcis->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                    $createKarcis->kode_layanan_header = $createLH->kode_layanan_header;
                    $createKarcis->kode_tarif_detail = $unit->kode_tarif_karcis;
                    $createKarcis->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->jumlah_layanan = 1;
                    $createKarcis->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->status_layanan_detail = 'OPN';
                    $createKarcis->tgl_layanan_detail = now();
                    $createKarcis->tgl_layanan_detail_2 = now();
                    $createKarcis->row_id_header = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createKarcis->tagihan_pribadi = $total_bayar_k_a;
                    } else {
                        $createKarcis->tagihan_penjamin = $total_bayar_k_a;
                    }
                    if ($createKarcis->save()) {
                        // create detail karcis
                        $createAdm = new LayananDetail();
                        $createAdm->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                        $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                        $createAdm->kode_tarif_detail = $unit->kode_tarif_karcis;
                        $createAdm->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->jumlah_layanan = 1;
                        $createAdm->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->status_layanan_detail = 'OPN';
                        $createAdm->tgl_layanan_detail = now();
                        $createAdm->tgl_layanan_detail_2 = now();
                        $createAdm->row_id_header = $createLH->id;
                        if ($request->penjamin_id == 'P01') {
                            $createAdm->tagihan_pribadi = $total_bayar_k_a;
                        } else {
                            $createAdm->tagihan_penjamin = $total_bayar_k_a;
                        }
                        
                        if($createAdm->save())
                        {
                            $createKunjungan->status_kunjungan =1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                            $createKunjungan->update();

                            $createLH->status_layanan =1; // status 3 nanti di update jadi 1
                            $createLH->update();
                        }
                    }
                }
            } 
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->rm . ' berhasil didaftarkan!');
        return redirect()->route('d-antrian-igd');
    }

    public function pendaftaranIGDKBDStore(Request $request)
    {
        $data = Kunjungan::where('no_rm', $request->rm)
            ->where('status_kunjungan', 1)
            ->get();
        if ($data->count() > 0) {
            Alert::error('Proses Daftar Gagal!!', 'pasien masih memiliki status kunjungan belum ditutup!');
            return back();
        }
        $request->validate([
            'nik' => 'required',
            'rm' => 'required',
            'unit' => 'required',
            'dokter_id' => 'required',
            'tanggal' => 'required',
            'penjamin_id' => 'required',
            'alasan_masuk_id' => 'required',
        ]);
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
        $unit = Unit::findOrFail($request->unit);
        $pasien = Pasien::where('no_rm', $request->rm)->first();
        $desa = 'Desa ' . $pasien->desas->nama_desa_kelurahan;
        $kec = 'Kec. ' . $pasien->kecamatans->nama_kecamatan;
        $kab = 'Kab. ' . $pasien->kabupatens->nama_kabupaten_kota;
        $alamat = $pasien->alamat . ' ( ' . $desa . ' - ' . $kec . ' - ' . $kab . ' )';
        
        $createKunjungan = new Kunjungan();
        $createKunjungan->counter = $c;
        $createKunjungan->no_rm = $request->rm;
        $createKunjungan->kode_unit = $unit->kode_unit;
        $createKunjungan->tgl_masuk = now();
        $createKunjungan->kode_paramedis = $request->dokter_id;
        $createKunjungan->status_kunjungan = 8; //status 8 nanti update setelah header dan detail selesai jadi 1
        $createKunjungan->prefix_kunjungan = $unit->prefix_unit;
        $createKunjungan->kode_penjamin = $request->penjamin_id;
        $createKunjungan->kelas = 3;
        $createKunjungan->id_alasan_masuk = $request->alasan_masuk_id;
        $createKunjungan->pic = Auth::user()->id;
        if ($createKunjungan->save()) {
            $ant_upd = AntrianPasienIGD::find($request->id_antrian);
            $ant_upd->no_rm = $request->rm;
            $ant_upd->nama_px = $pasien->nama_px;
            $ant_upd->kode_kunjungan = $createKunjungan->kode_kunjungan;
            $ant_upd->unit = $unit->kode_unit;
            $ant_upd->alamat = $alamat;
            $ant_upd->status = 2;
            $ant_upd->update();

            $kodelayanan = collect(\DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
            if ($kodelayanan == null) {
                $kodelayanan = $unit->prefix_unit . now()->format('ymd') . str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            $tarif_karcis = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis)->first();
            $tarif_adm = TarifLayananDetail::where('KODE_TARIF_DETAIL', $unit->kode_tarif_adm)->first();
            $total_bayar_k_a = $tarif_adm->TOTAL_TARIF_CURRENT + $tarif_karcis->TOTAL_TARIF_CURRENT;
            // create layanan header
            $createLH = new Layanan();
            $createLH->kode_layanan_header = $kodelayanan;
            $createLH->tgl_entry = now();
            $createLH->kode_kunjungan = $createKunjungan->kode_kunjungan;
            $createLH->kode_unit = $unit->kode_unit;
            $createLH->pic = Auth::user()->id;
            $createLH->status_pembayaran = 'OPN';
            if ($unit->kelas_unit == 1) {
                $createLH->kode_tipe_transaksi = 1;
                $createLH->status_layanan = 3; // status 3 nanti di update jadi 1
                $createLH->total_layanan = $total_bayar_k_a;

                if ($request->penjamin_id == 'P01') {
                    $createLH->tagihan_pribadi = $total_bayar_k_a;
                } else {
                    $createLH->tagihan_penjamin = $total_bayar_k_a;
                }
                // header create
                if ($createLH->save()) {
                    // create layanan detail
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first(); //DET230905000028
                    $nomorlayanandetkarc = substr($layanandet->id_layanan_detail, 9) + 1;
                    $nomorlayanandetadm = substr($layanandet->id_layanan_detail, 9) + 2;

                    // create detail karcis
                    $createKarcis = new LayananDetail();
                    $createKarcis->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetkarc, 6, '0', STR_PAD_LEFT);
                    $createKarcis->kode_layanan_header = $createLH->kode_layanan_header;
                    $createKarcis->kode_tarif_detail = $unit->kode_tarif_karcis;
                    $createKarcis->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->jumlah_layanan = 1;
                    $createKarcis->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                    $createKarcis->status_layanan_detail = 'OPN';
                    $createKarcis->tgl_layanan_detail = now();
                    $createKarcis->tgl_layanan_detail_2 = now();
                    $createKarcis->row_id_header = $createLH->id;
                    if ($request->penjamin_id == 'P01') {
                        $createKarcis->tagihan_pribadi = $total_bayar_k_a;
                    } else {
                        $createKarcis->tagihan_penjamin = $total_bayar_k_a;
                    }
                    if ($createKarcis->save()) {
                        // create detail karcis
                        $createAdm = new LayananDetail();
                        $createAdm->id_layanan_detail = 'DET' . now()->format('ymd') . str_pad($nomorlayanandetadm, 6, '0', STR_PAD_LEFT);
                        $createAdm->kode_layanan_header = $createLH->kode_layanan_header;
                        $createAdm->kode_tarif_detail = $unit->kode_tarif_karcis;
                        $createAdm->total_tarif = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->jumlah_layanan = 1;
                        $createAdm->total_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->grantotal_layanan = $tarif_karcis->TOTAL_TARIF_CURRENT;
                        $createAdm->status_layanan_detail = 'OPN';
                        $createAdm->tgl_layanan_detail = now();
                        $createAdm->tgl_layanan_detail_2 = now();
                        $createAdm->row_id_header = $createLH->id;
                        if ($request->penjamin_id == 'P01') {
                            $createAdm->tagihan_pribadi = $total_bayar_k_a;
                        } else {
                            $createAdm->tagihan_penjamin = $total_bayar_k_a;
                        }
                        
                        if($createAdm->save())
                        {
                            $createKunjungan->status_kunjungan =1;  //status 8 nanti update setelah header dan detail selesai jadi 1
                            $createKunjungan->update();

                            $createLH->status_layanan =1; // status 3 nanti di update jadi 1
                            $createLH->update();
                        }
                    }
                }
            } 
            // dd($createKunjungan,  $ant_upd, $createLH, $createKarcis, $createAdm);
        }
        Alert::success('Daftar Sukses!!', 'pasien dg RM: ' . $request->rm . ' berhasil didaftarkan!');
        return redirect()->route('d-antrian-igd');
    }

    public function batalDaftarIGD(Request $request)
    {
        $data =  AntrianPasienIGD::findOrFail($request->id);
        $data->no_rm = (Null);
        $data->is_px_daftar = (Null);
        $data->update();
        return response()->json($data, 200);
    }

    // pasien (daftar) bpjs beralih ke pasien umum
    public function bpjsToUmum(Request $request)
    {   $data = $request->par;
        $rm = substr($data, 0, 8); 
        $antrian = substr($data, -10);

        // $status_pendaftaran = $request->pendaftaran_id;
        $antrian = AntrianPasienIGD::firstWhere('no_antri',$antrian);
        $pasien = Pasien::firstWhere('no_rm', $rm);
        $kunjungan = Kunjungan::where('no_rm', $rm)->get();
        $knj_aktif = Kunjungan::where('no_rm', $rm)
            ->where('status_kunjungan', 1)
            ->count();

        $unit = Unit::limit(10)->get();
        $alasanmasuk = AlasanMasuk::limit(10)->get();
        $paramedis = Paramedis::where('spesialis', 'UMUM')
            ->where('act', 1)
            ->get();
        $penjamin = PenjaminSimrs::limit(10)
            ->where('act', 1)
            ->get();
       
        return view('simrs.igd.form_igd.form_bpjs_toigd', compact(
            'pasien', 'kunjungan', 'unit', 'paramedis', 'penjamin', 'alasanmasuk', 
            'antrian', 'knj_aktif',
        ));
    }


}
