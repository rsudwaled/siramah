<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\Paramedis;
use App\Models\Penjamin;
use App\Models\Poliklinik;
use App\Models\TarifLayananDetail;
use App\Models\Tracer;
use App\Models\Transaksi;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranController extends APIController
{
    // anjungan
    public function antrianConsole()
    {
        $jadwals = JadwalDokter::where('hari',  now()->dayOfWeek)
            ->orderBy('namasubspesialis', 'asc')->get();
        $antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))->get();
        return view('simrs.antrian_console', compact(
            [
                'jadwals',
                'antrians',
            ]
        ));
    }
    public function mesinantrian()
    {
        $jadwals = JadwalDokter::where('hari',  now()->dayOfWeek)
            ->orderBy('namasubspesialis', 'asc')->get();
        $antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))->get();
        return view('simrs.antrian_mesin', compact(
            [
                'jadwals',
                'antrians',
            ]
        ));
    }
    public function testmesinantrian(Request $request)
    {
        return view('simrs.antrian_testprint');
    }
    public function checkinAntrian(Request $request)
    {
        $antrian = null;
        $kunjungan = null;
        if ($request->kodebooking) {
            $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
            if ($antrian) {
                $kunjungan =  $antrian->kunjungan;
            } else {
                Alert::error('Maaf', 'Kodebooking tidak ditemukan');
            }
        }
        return view('simrs.antrian_checkin', compact([
            'request',
            'antrian',
            'kunjungan',
        ]));
    }
    public function checkinKarcisAntrian(Request $request)
    {
        $now = Carbon::parse(DB::connection('mysql2')->select('select sysdate() as time')[0]->time);
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if ($antrian) {
            if (!Carbon::parse($antrian->tanggalperiksa)->isToday()) {
                Alert::error('Maaf', 'Tanggal periksa anda bukan hari ini.');
                return redirect()->back();
            }
            $request['waktu'] = $now->timestamp * 1000;
            $unit = Unit::firstWhere('KDPOLI', $antrian->kodepoli);
            $paramedis = Paramedis::firstWhere('kode_dokter_jkn', $antrian->kodedokter);
            $tarifkarcis = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis);
            $tarifadm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_adm);
            if ($antrian->jenispasien == "JKN") {
                $request['taskid'] = 3;
                $request['status_api'] = 1;
                $request['jenispasien'] = "JKN";
                $jkunjungan = [1 => 'RUJUKAN FKTP', 3 => 'KONTROL', 4 =>  'RUJUKAN ANTAR-RS'];
                $request['jeniskunjungan_print'] = $jkunjungan[$antrian->jeniskunjungan];
                $request['keterangan'] = "Untuk pasien peserta JKN silahkan dapat langsung menunggu ke POLIKINIK " . $antrian->namapoli;
                $vclaim = new VclaimController();
                $request["nomorkartu"] = $antrian->nomorkartu;
                $request["tanggal"] = $antrian->tanggalperiksa;
                $peserta = $vclaim->peserta_nomorkartu($request);
                $peserta = $peserta->response->peserta;
                $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first(); // get peserta
                $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs; // get peserta

                // rj jkn tipe transaki 2 status layanan 2 status layanan detail opn
                $tipetransaksi = 2;
                $statuslayanan = 2;
                // rj jkn masuk ke tagihan penjamin
                $tagihanpenjamin_karcis = $tarifkarcis->TOTAL_TARIF_NEW;
                $tagihanpenjamin_adm = $tarifadm->TOTAL_TARIF_NEW;
                $totalpenjamin =  $tarifkarcis->TOTAL_TARIF_NEW + $tarifadm->TOTAL_TARIF_NEW;
                $tagihanpribadi_karcis = 0;
                $tagihanpribadi_adm = 0;
                $totalpribadi =  0;
            } else {
                $request['taskid'] = 3;
                $request['status_api'] = 0;
                $request['kodepenjamin'] = "P01";
                $request['jenispasien'] = "NON-JKN";
                $request['jeniskunjungan_print'] = 'KUNJUNGAN UMUM';
                $request['keterangan'] = "Untuk pasien peserta NON-JKN silahkan lakukan pembayaran terlebih dahulu di Loket Pembayaran samping BJB";
                // rj umum tipe transaki 1 status layanan 1 status layanan detail opn
                $tipetransaksi = 1;
                $statuslayanan = 1;
                // rj umum masuk ke tagihan pribadi
                $tagihanpenjamin_karcis = 0;
                $tagihanpenjamin_adm = 0;
                $totalpenjamin =  0;
                $tagihanpribadi_karcis = $tarifkarcis->TOTAL_TARIF_NEW;
                $tagihanpribadi_adm = $tarifadm->TOTAL_TARIF_NEW;
                $request['tarifkarcis'] =  $tarifkarcis->TOTAL_TARIF_NEW;
                $request['tarifadm'] =  $tarifadm->TOTAL_TARIF_NEW;
                $totalpribadi = $tarifkarcis->TOTAL_TARIF_NEW + $tarifadm->TOTAL_TARIF_NEW;
            }
            if ($antrian->kode_kunjungan == null) {
                try {
                    // insert kunjungan, layanan header dan detail
                    // hitung counter kunjungan
                    $counterx = Kunjungan::where('no_rm', $antrian->norm)->orderBy('counter', 'DESC')->first();
                    if (empty($counterx)) {
                        $counter = 1;
                    } else {
                        $counter = $counterx->counter + 1;
                    }
                    $kodelayanan = collect(DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
                    if ($kodelayanan == null) {
                        //   get transaksi sebelumnya
                        $trx_lama = Transaksi::where('unit', $unit->kode_unit)
                            ->whereBetween('tgl', [Carbon::now()->startOfDay(), [Carbon::now()->endOfDay()]])
                            ->count();
                        // get kode layanan
                        $kodelayanan = $unit->prefix_unit . now()->format('y') . now()->format('m') . now()->format('d')  . str_pad($trx_lama + 1, 6, '0', STR_PAD_LEFT);
                        //  insert transaksi
                        $trx_baru = Transaksi::create([
                            'tgl' => now()->format('Y-m-d'),
                            'no_trx_layanan' => $kodelayanan,
                            'unit' => $unit->kode_unit,
                        ]);
                    }
                    // insert ts kunjungan status 8
                    $kunjungan  = Kunjungan::create(
                        [
                            'counter' => $counter,
                            'no_rm' => $antrian->norm,
                            'kode_unit' => $unit->kode_unit,
                            'tgl_masuk' => $now,
                            'kode_paramedis' => $paramedis->kode_paramedis,
                            'status_kunjungan' => 8,
                            'prefix_kunjungan' => $unit->prefix_unit,
                            'kode_penjamin' => $request->kodepenjamin,
                            'pic' => 1319,
                            'id_alasan_masuk' => 1,
                            'kelas' => 3,
                            'hak_kelas' => $request->klsRawatHak,
                            'no_sep' =>  $request->nomorsep,
                            'no_rujukan' => $antrian->nomorrujukan,
                            'diagx' =>   $request->catatan,
                            'created_at' => $now,
                            'keterangan2' => 'MESIN_2',
                        ]
                    );
                    $kunjungan = Kunjungan::where('no_rm', $antrian->norm)->where('counter', $counter)->first();
                    $antrian->update([
                        'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    ]);
                    //  insert layanan header
                    $layananbaru = Layanan::create(
                        [
                            'kode_layanan_header' => $kodelayanan,
                            'tgl_entry' => $now,
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'kode_unit' => $unit->kode_unit,
                            'kode_tipe_transaksi' => $tipetransaksi,
                            'status_layanan' => $statuslayanan,
                            'pic' => '1319',
                            'keterangan' => 'Layanan header melalui antrian sistem',
                        ]
                    );
                    //  insert layanan header dan detail karcis admin konsul 25 + 5 = 30
                    //  DET tahun bulan `tanggal b`aru urutan 6 digit kanan
                    //  insert layanan detail karcis
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
                    $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1;
                    $karcis = LayananDetail::create(
                        [
                            'id_layanan_detail' => "DET" . $now->format('y') . $now->format('m') . $now->format('d')  . $nomorlayanandet,
                            'row_id_header' => $layananbaru->id,
                            'kode_layanan_header' => $layananbaru->kode_layanan_header,
                            'kode_tarif_detail' => $tarifkarcis->KODE_TARIF_DETAIL,
                            'total_tarif' => $tarifkarcis->TOTAL_TARIF_NEW,
                            'jumlah_layanan' => 1,
                            'tagihan_pribadi' => $tagihanpribadi_karcis,
                            'tagihan_penjamin' => $tagihanpenjamin_karcis,
                            'total_layanan' => $tarifkarcis->TOTAL_TARIF_NEW,
                            'grantotal_layanan' => $tarifkarcis->TOTAL_TARIF_NEW,
                            'kode_dokter1' => $paramedis->kode_paramedis, // ambil dari mt paramdeis
                            'tgl_layanan_detail' =>  $now,
                            'status_layanan_detail' => "OPN",
                            'tgl_layanan_detail_2' =>  $now,
                        ]
                    );
                    //  insert layanan detail admin
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
                    $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1 + 1;
                    $adm = LayananDetail::create(
                        [
                            'id_layanan_detail' => "DET" . $now->format('y') . $now->format('m') . $now->format('d')  . $nomorlayanandet,
                            'row_id_header' => $layananbaru->id,
                            'kode_layanan_header' => $layananbaru->kode_layanan_header,
                            'kode_tarif_detail' => $tarifadm->KODE_TARIF_DETAIL,
                            'total_tarif' => $tarifadm->TOTAL_TARIF_NEW,
                            'jumlah_layanan' => 1,
                            'tagihan_pribadi' =>  $tagihanpribadi_adm,
                            'tagihan_penjamin' =>  $tagihanpenjamin_adm,
                            'total_layanan' => $tarifadm->TOTAL_TARIF_NEW,
                            'grantotal_layanan' => $tarifadm->TOTAL_TARIF_NEW,
                            'kode_dokter1' => 0,
                            'tgl_layanan_detail' =>  $now,
                            'status_layanan_detail' => "OPN",
                            'tgl_layanan_detail_2' =>  $now,
                        ]
                    );
                    //  update layanan header total tagihan
                    $layananbaru->update([
                        'total_layanan' => $tarifkarcis->TOTAL_TARIF_NEW + $tarifadm->TOTAL_TARIF_NEW,
                        'tagihan_pribadi' => $totalpribadi,
                        'tagihan_penjamin' => $totalpenjamin,
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                    dd($th);
                }
            }
            $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $antrian->kode_kunjungan);
            if ($kunjungan) {
                $kunjungan->update([
                    'status_kunjungan' => 1,
                    'no_sep' => $antrian->nomorsep,
                ]);
            }
            if (env('BRIDGING_ANTRIAN_BPJS')) {
                $request['kodebooking'] = $antrian->kodebooking;
                $request['taskid'] = 3;
                $request['waktu'] = now();
                $api = new AntrianController();
                $res = $api->update_antrean($request);
            }
            $antrian->update([
                'taskid' => $request->taskid,
                'taskid1' => now()->setTimezone('Asia/Jakarta'),
                'taskid3' => now()->setTimezone('Asia/Jakarta'),
                'status_api' => $request->status_api,
                'keterangan' =>  $request->keterangan,
            ]);
            $api = new AntrianController();
            // $res = $api->update_antrean($request);
            // insert tracer tc_tracer_header
            $tracerbaru = Tracer::updateOrCreate([
                'kode_kunjungan' => $kunjungan->kode_kunjungan,
                'tgl_tracer' => $now->format('Y-m-d'),
                'id_status_tracer' => 1,
                'cek_tracer' => "N",
            ]);
            // if ($res->metadata->code == 200) {
            //     Alert::success('Success', 'OK');
            // } else {
            //     Alert::error('Error', $res->metadata->message);
            // }
            Alert::success('Success', 'OK');
            $this->print_karcis($request, $kunjungan);
            return redirect()->back();
        } else {
            Alert::error('Error', "Antrian Tidak Ditemukan");
            return redirect()->back();
        }
    }
    function checkinCetakSEP(Request $request)
    {
        $vclaim = new VclaimController();
        $now = Carbon::parse(DB::connection('mysql2')->select('select sysdate() as time')[0]->time);
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $request['noKartu'] = $antrian->nomorkartu;
        $request['tglSep'] = $antrian->tanggalperiksa;
        $request['ppkPelayanan'] = "1018R001";
        $request['jnsPelayanan'] = "2";
        $request['klsRawatHak'] = "3";
        $request['asalRujukan'] = "1";
        $request['tglRujukan'] =  $now;
        $request['noMR'] = $antrian->norm;
        // check backdate
        if (!Carbon::parse($antrian->tanggalperiksa)->isToday()) {
            return $this->sendError("Tanggal periksa bukan hari ini.", 400);
        }
        if ($antrian->taskid == 99) {
            return $this->sendError("Antrian telah dibatalkan sebelumnya.", 400);
        }
        // get jadwal poliklinik dari simrs
        $jadwals = JadwalDokter::where("hari",  Carbon::parse($antrian->tanggalperiksa)->dayOfWeek)
            ->where("kodesubspesialis", $antrian->kodepoli)
            ->get();
        // tidak ada jadwal
        if (!isset($jadwals)) {
            return $this->sendError("Tidak ada jadwal poliklinik dihari tersebut", 404);
        }
        // get jadwal dokter
        $jadwal = $jadwals->where('kodedokter', $antrian->kodedokter)->first();
        // tidak ada dokter
        if (!isset($jadwal)) {
            return $this->sendError("Tidak ada jadwal dokter dihari tersebut",  404);
        }
        if ($jadwal->libur == 1) {
            return $this->sendError("Jadwal Dokter dihari tersebut sedang diliburkan.",  403);
        }
        if (empty($antrian->nomorsep)) {
            // daftar pake surat kontrol
            if ($antrian->jeniskunjungan == 3) {
                $request['nomorreferensi'] = $antrian->nomorsuratkontrol;
                $request['noSuratKontrol'] = $antrian->nomorsuratkontrol;
                $request['noTelp'] = $antrian->nohp;
                $request['user'] = "Mesin Antrian";
                $suratkontrol = $vclaim->suratkontrol_nomor($request);
                // berhasil get surat kontrol
                if ($suratkontrol->metadata->code == 200) {
                    $suratkontrol = $suratkontrol;
                    $request['nomorsuratkontrol'] = $antrian->nomorsuratkontrol;
                    if ($suratkontrol->response->sep->jnsPelayanan == "Rawat Jalan") {
                        $request['nomorrujukan'] = $suratkontrol->response->sep->provPerujuk->noRujukan;
                        $request['jeniskunjungan_print'] = 'KONTROL';
                        $request['nomorreferensi'] = $antrian->nomorrujukan;
                        $data = $vclaim->rujukan_nomor($request);
                        if ($data->metadata->code != 200) {
                            $data = $vclaim->rujukan_rs_nomor($request);
                        }
                        // berhasil get rujukan
                        if ($data->metadata->code == 200) {
                            $data = $data;
                            $rujukan = $data->response->rujukan;
                            $peserta = $rujukan->peserta;
                            $diganosa = $rujukan->diagnosa;
                            $tujuan = $rujukan->poliRujukan;
                            $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first(); // get peserta
                            // $request['kodepenjamin'] = 'P13';
                            $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs; // get peserta
                            // tujuan rujukan
                            // ppkPelayanan
                            $request['ppkPelayanan'] = "1018R001";
                            $request['jnsPelayanan'] = "2";
                            // peserta
                            $request['klsRawatHak'] = $peserta->hakKelas->kode; // get peserta
                            $request['klsRawatNaik'] = ""; // get peserta
                            // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                            // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                            // asal rujukan
                            $request['asalRujukan'] = $data->response->asalFaskes; // get surat kontrol
                            $request['tglRujukan'] = $rujukan->tglKunjungan; // get surat kontrol
                            $request['noRujukan'] =   $rujukan->noKunjungan; // get surat kontrol
                            $request['ppkRujukan'] = $rujukan->provPerujuk->kode; // get surat kontrol
                            // diagnosa
                            $request['catatan'] =  $diganosa->nama; // get surat kontrol
                            $request['diagAwal'] =  $diganosa->kode; // get surat kontrol
                            // poli tujuan
                            $request['tujuan'] =  $antrian->kodepoli; // get antrian
                            $request['eksekutif'] =  0;
                            // dpjp
                            $request['tujuanKunj'] = "2";
                            $request['flagProcedure'] = "";
                            $request['kdPenunjang'] = "";
                            $request['assesmentPel'] = "2";
                            $request['noSurat'] = $request->nomorsuratkontrol; // get antrian
                            $request['kodeDPJP'] = $suratkontrol->response->kodeDokter;
                            $request['dpjpLayan'] =  $suratkontrol->response->kodeDokter;
                        }
                        // gagal get rujukan
                        else {
                            return $this->sendError($data->metadata->message,  400);
                        }
                    } else {
                        $request['nomorkartu'] = $antrian->nomorkartu;
                        $request['tanggal'] = $antrian->tanggalperiksa;
                        $data = $vclaim->peserta_nomorkartu($request);
                        // berhasil get rujukan
                        if ($data->metadata->code == 200) {
                            $data = $data;
                            $peserta = $data->response->peserta;
                            $diagnosa = $suratkontrol->response->sep->diagnosa;
                            $asalRujukan = $suratkontrol->response->sep->provPerujuk->asalRujukan;
                            $tglRujukan = $suratkontrol->response->sep->provPerujuk->tglRujukan;
                            $noRujukan = $suratkontrol->response->sep->noSep;
                            $ppkRujukan = $suratkontrol->response->sep->provPerujuk->kdProviderPerujuk;
                            $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first(); // get peserta
                            $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs; // get peserta
                            // $request['kodepenjamin'] = 'P13';
                            // tujuan rujukan
                            $request['ppkPelayanan'] = "1018R001";
                            $request['jnsPelayanan'] = "2";
                            // peserta
                            $request['klsRawatHak'] = $peserta->hakKelas->kode; // get peserta
                            $request['klsRawatNaik'] = ""; // get peserta
                            // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                            // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                            // asal rujukan
                            $request['asalRujukan'] = $asalRujukan; // get surat kontrol
                            $request['tglRujukan'] = $tglRujukan; // get surat kontrol
                            $request['noRujukan'] =   $noRujukan; // get surat kontrol
                            $request['ppkRujukan'] = $ppkRujukan; // get surat kontrol
                            // diagnosa
                            $request['catatan'] =  $diagnosa; // get surat kontrol
                            $request['diagAwal'] = str_replace(" ", "", explode('-', $diagnosa)[0]);
                            // poli tujuan
                            $request['tujuan'] =  $antrian->kodepoli; // get antrian
                            $request['eksekutif'] =  0;
                            // dpjp
                            $request['tujuanKunj'] = "0";
                            $request['flagProcedure'] = "";
                            $request['kdPenunjang'] = "";
                            $request['assesmentPel'] = "";
                            $request['noSurat'] = $request->nomorsuratkontrol; // get antrian
                            $request['kodeDPJP'] = $suratkontrol->response->kodeDokter;
                            $request['dpjpLayan'] =  $suratkontrol->response->kodeDokter;
                        }
                    }
                }
                // gagal get surat kontrol
                else {
                    return $this->sendError($suratkontrol->metadata->message,  400);
                }
            }
            // daftar pake rujukan
            else {
                $request['nomorrujukan'] = $antrian->nomorreferensi;
                $request['nomorreferensi'] = $antrian->nomorreferensi;
                if ($antrian->jeniskunjungan == 4) {
                    $data = $vclaim->rujukan_rs_nomor($request);
                } else  if ($antrian->jeniskunjungan == 1) {
                    $data = $vclaim->rujukan_nomor($request);
                }
                // berhasil get rujukan
                if ($data->metadata->code == 200) {
                    $data = $data;
                    $rujukan = $data->response->rujukan;
                    $peserta = $rujukan->peserta;
                    $diganosa = $rujukan->diagnosa;
                    $tujuan = $rujukan->poliRujukan;
                    // peserta
                    $request['noMR'] = $peserta->mr->noMR;
                    $request['klsRawatHak'] = $peserta->hakKelas->kode;
                    $request['klsRawatNaik'] = "";
                    // asal rujukan
                    $request['asalRujukan'] = $data->response->asalFaskes;
                    $request['tglRujukan'] = $rujukan->tglKunjungan;
                    $request['noRujukan'] =   $request->nomorreferensi;
                    $request['ppkRujukan'] = $rujukan->provPerujuk->kode;
                    // diagnosa
                    $request['catatan'] =  $diganosa->nama;
                    $request['diagAwal'] =  $diganosa->kode;
                    // poli tujuan
                    $request['tujuan'] =  $antrian->kodepoli;
                    $request['eksekutif'] =  0;
                    // dpjp
                    $request['tujuanKunj'] = "0";
                    $request['flagProcedure'] = "";
                    $request['kdPenunjang'] = "";
                    $request['assesmentPel'] = "";
                    // $request['noSurat'] = "";
                    $request['kodeDPJP'] = "";
                    $request['dpjpLayan'] = $antrian->kodedokter;
                    $request['noTelp'] = $antrian->nohp;
                    $request['user'] = "Mesin Antrian";
                }
                // gagal get rujukan
                else {
                    return $this->sendError($data->metadata->message,  400);
                }
            }
            $res = $vclaim->sep_insert($request);
            // berhasil buat sep
            if ($res->metadata->code == 200) {
                // update antrian res
                $sep = $res->response->sep;
                $request["nomorsep"] = $sep->noSep;
                $antrian->update([
                    "nomorsep" => $request->nomorsep
                ]);
                // print sep
                $this->print_sep($request, $sep);
                Alert::success('Succes', 'Cetak SEP');
                return redirect()->back();
            }
            // gagal buat sep
            else {
                Alert::error('Maaf', $res->metadata->message);
                return redirect()->back();
            }
        } else {
            $request['noSep'] = $antrian->nomorsep;
            $res = $vclaim->sep_nomor($request);
            $sep = $res->response;
            $this->print_sep_ulang($request, $sep);
            Alert::success('Succes', 'Cetak Ulang SEP');
            return redirect()->back();
        }
    }
    public function daftarBpjsOffline(Request $request)
    {
        try {
            Log::notice('Antrian Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else {
                $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->close();
        } catch (\Throwable $th) {
            Alert::error('Error ' . 'Printer Mesin Antrian Tidak Menyala');
            return redirect()->back();
        }
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrianConsole');
        }
        // get jadwal
        $jadwal = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrianConsole');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $response = $this->ambil_antrian_offline($request);
        if ($response->metadata->code == 200) {
            // cek printer
            try {
                Log::notice('Antrian Printer ip : ' . $request->ip());
                if ($request->ip() == "192.168.2.133") {
                    $printer = env('PRINTER_CHECKIN');
                } else {
                    $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
                }
                $connector = new WindowsPrintConnector($printer);
                $printer = new Printer($connector);
                $printer->close();
            } catch (\Throwable $th) {
                return $this->sendError('Printer Mesin Antrian Tidak Menyala',  201);
            }
            $antrian = $response->response;
            $this->print_karcis_offline($request, $antrian);
            Alert::success('Success', 'Anda berhasil mendaftar dengan antrian ' . $antrian->angkaantrean . " / " . $antrian->nomorantrean);
            return redirect()->route('antrianConsole');
        } else {
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            return redirect()->route('antrianConsole');
        }
    }
    public function daftarUmumOffline(Request $request)
    {
        try {
            Log::notice('Antrian Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else {
                $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->close();
        } catch (\Throwable $th) {
            Alert::error('Error ' . 'Printer Mesin Antrian Tidak Menyala');
            return redirect()->back();
        }
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrianConsole');
        }
        // get jadwal
        $jadwal = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrianConsole');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'NON-JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $response = $this->ambil_antrian_offline($request);
        if ($response->metadata->code == 200) {
            $antrian = $response->response;
            $this->print_karcis_offline($request, $antrian);
            Alert::success('Success', 'Anda berhasil mendaftar dengan antrian ' . $antrian->angkaantrean . " / " . $antrian->nomorantrean);
            return redirect()->route('antrianConsole');
        } else {
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            return redirect()->route('antrianConsole');
        }
    }
    public function ambil_antrian_offline_bpjs(Request $request)
    {
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrianConsole');
        }
        // get jadwal
        $jadwal = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrianConsole');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $response = $this->ambil_antrian_offline($request);
        if ($response->metadata->code == 200) {
            $antrian = $response->response;
            return $this->print_karcis_antrian($request, $antrian);
        } else {
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            return redirect()->route('mesinantrian');
        }
    }
    public function ambil_antrian_offline_umum(Request $request)
    {
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $request->kodesubspesialis;
        $validator = Validator::make(request()->all(), [
            "kodesubspesialis" => "required",
            "kodedokter" => "required",
        ]);
        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('antrianConsole');
        }
        // get jadwal
        $jadwal = JadwalDokter::where('kodesubspesialis', $request->kodesubspesialis)
            ->where('kodedokter', $request->kodedokter)
            ->where('hari', now()->dayOfWeek)->first();
        if ($jadwal == null) {
            Alert::error('Error',  "Jadwal tidak ditemukan");
            return redirect()->route('antrianConsole');
        }
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'NON-JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $response = $this->ambil_antrian_offline($request);
        if ($response->metadata->code == 200) {
            $antrian = $response->response;
            return $this->print_karcis_antrian($request, $antrian);
        } else {
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            return redirect()->route('mesinantrian');
        }
    }
    public function print_karcis_antrian(Request $request, $antrian)
    {
        return view('simrs.antrian_karcis_print', compact([
            'request',
            'antrian',
        ]));
    }
    public function ambil_antrian_offline(Request $request) #ambil antrian mesin antrian
    {
        $validator = Validator::make(request()->all(), [
            "kodepoli" => "required",
            "tanggalperiksa" => "required",
            "kodedokter" => "required",
            "jampraktek" => "required",
            "jenispasien" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        // check tanggal
        if (Carbon::parse($request->tanggalperiksa)->endOfDay()->isPast()) {
            return $this->sendError("Tanggal periksa sudah terlewat", 400);
        }
        if (Carbon::parse($request->tanggalperiksa) >  Carbon::now()->addDay(6)) {
            return $this->sendError("Antrian hanya dapat dibuat untuk 7 hari ke kedepan", 400);
        }
        $poli = Poliklinik::where('kodesubspesialis', $request->kodepoli)->first();
        $request['lantaipendaftaran'] = $poli->lantaipendaftaran;
        $request['lokasi'] = $poli->lantaipendaftaran;
        if ($request->jenispasien == "NON-JKN") {
            $request['lantaipendaftaran'] = 1;
        }
        // cek jadwal
        $api = new AntrianController();
        $jadwal = $api->status_antrian($request);
        if ($jadwal->metadata->code == 200) {
            $jadwal = $jadwal->response;
            $request['namapoli'] = $jadwal->namapoli;
            $request['namadokter'] = $jadwal->namadokter;
        } else {
            $message = $jadwal->metadata->message;
            // kirim notif
            $wa = new WhatsappController();
            $request['notif'] = 'Method ' . $request->method . ' jadwal , ' . $message;
            $wa->send_notif($request);
            return $this->sendError('Mohon maaf , ' . $message, 400);
        }
        $antrian_poli = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodepoli', $request->kodepoli)
            ->count();
        $antrian_lantai = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
            ->where('method', $request->method)
            ->where('lantaipendaftaran', $request->lantaipendaftaran)
            ->where('jenispasien', $request->jenispasien)
            ->count();
        $request['nomorantrean'] = $request->kodepoli . "-" .  str_pad($antrian_poli + 1, 3, '0', STR_PAD_LEFT);
        $request['angkaantrean'] = $antrian_lantai + 1;
        $request['kodebooking'] = strtoupper(uniqid());
        // estimasi
        $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
        $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(10 * ($antrian_poli + 1));
        $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
        $request['sisakuotajkn'] =  $jadwal->sisakuotajkn - 1;
        $request['kuotajkn'] = $jadwal->kuotajkn;
        $request['sisakuotanonjkn'] = $jadwal->sisakuotanonjkn - 1;
        $request['kuotanonjkn'] = $jadwal->kuotanonjkn;
        $request['keterangan'] = "Silahkan menunggu panggilan di loket Pendaftaran Lantai " . $request->lantaipendaftaran;
        // tambah antrian database
        $antrian = Antrian::create([
            "kodebooking" => $request->kodebooking,
            "nomorkartu" => $request->nomorkartu,
            "nik" => $request->nik,
            "nohp" => $request->nohp,
            "kodepoli" => $request->kodepoli,
            "norm" => $request->norm,
            "pasienbaru" => $request->pasienbaru,
            "tanggalperiksa" => $request->tanggalperiksa,
            "kodedokter" => $request->kodedokter,
            "jampraktek" => $request->jampraktek,
            "jeniskunjungan" => 0,
            "nomorreferensi" => $request->nomorreferensi,
            "method" => $request->method,
            "nomorrujukan" => $request->nomorRujukan,
            "nomorsuratkontrol" => $request->noSuratKontrol,
            'nomorsep' => $request->nomorsep,
            "kode_kunjungan" => $request->kode_kunjungan,
            "jenispasien" => $request->jenispasien,
            "namapoli" => $request->namapoli,
            "namadokter" => $request->namadokter,
            "nomorantrean" => $request->nomorantrean,
            "angkaantrean" => $request->angkaantrean,
            "estimasidilayani" => $request->estimasidilayani,
            "sisakuotajkn" => $request->sisakuotajkn,
            "kuotajkn" => $request->kuotajkn,
            "sisakuotanonjkn" => $request->sisakuotanonjkn,
            "kuotanonjkn" => $request->kuotanonjkn,
            "keterangan" => $request->keterangan,
            "lokasi" => $request->lokasi,
            "lantaipendaftaran" => $request->lantaipendaftaran,
            "status_api" => 1,
            "taskid" => 0,
            "user" => "System Antrian",
            "nama" => $request->nama,
        ]);
        $response = [
            "nomorantrean" => $request->nomorantrean,
            "angkaantrean" => $request->angkaantrean,
            "kodebooking" => $request->kodebooking,
            "norm" => $request->norm,
            "namapoli" => $request->namapoli,
            "namadokter" => $request->namadokter,
            "estimasidilayani" => $request->estimasidilayani,
            "sisakuotajkn" => $request->sisakuotajkn,
            "kuotajkn" => $request->kuotajkn,
            "sisakuotanonjkn" => $request->sisakuotanonjkn,
            "kuotanonjkn" => $request->kuotanonjkn,
            "keterangan" => $request->keterangan,
        ];
        return $this->sendResponse($response, 200);
    }
    function print_karcis_offline(Request $request, $antrian)
    {
        try {
            Carbon::setLocale('id');
            date_default_timezone_set('Asia/Jakarta');
            $now = Carbon::now();
            Log::notice('Antrian Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else {
                $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->setEmphasis(true);
            $printer->text("ANTRIAN RAWAT JALAN\n");
            $printer->text("RSUD WALED KAB. CIREBON\n");
            $printer->setEmphasis(false);
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Angka Antrian Pendaftaran :\n");
            $printer->setTextSize(3, 3);
            $printer->text($antrian->angkaantrean . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("Kode Booking : " . $antrian->kodebooking . "\n");
            $printer->text("Lokasi Pendaftaran Lantai " . $request->lantaipendaftaran . " \n");
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Jenis Kunj. : " . $request->method . ' ' . $request->jenispasien . "\n");
            $printer->text("No. Antrian Poli : " . $antrian->nomorantrean . "\n");
            $printer->text("Poliklinik : " . $antrian->namapoli . "\n");
            $printer->text("Dokter : " . $antrian->namadokter . "\n");
            $printer->text("Jam, Tanggal : " . $request->jampraktek . ', ' . Carbon::parse($request->tanggalperiksa)->format('d M Y') . "\n");
            $printer->text("================================================\n");
            $printer->text("Keterangan : \n" . $antrian->keterangan . "\n");
            $printer->text("================================================\n");
            $printer->text("Waktu Cetak Karic : " . $now . "\n");
            $printer->cut();
            $printer->close();
        } catch (\Throwable $th) {
            return $this->sendError('Printer Mesin Antrian Tidak Menyala',  201);
        }
    }
    function print_karcis(Request $request,  $kunjungan)
    {
        $antrian =  Antrian::firstWhere('kodebooking', $request->kodebooking);
        // dd($request->all(), $antrian);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        if ($request->ip() == "192.168.2.133") {
            $printer = env('PRINTER_CHECKIN');
        } else {
            $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
        }
        $connector = new WindowsPrintConnector($printer);
        $printer = new Printer($connector);
        $printer->setEmphasis(true);
        $printer->text("ANTRIAN RAWAT JALAN\n");
        $printer->text("RSUD WALED KAB. CIREBON\n");
        $printer->setEmphasis(false);
        $printer->text("================================================\n");
        $printer->text("No. RM : " . $antrian->norm . "\n");
        $printer->text("Nama : " . $antrian->nama . "\n");
        // $printer->text("NIK : " . $request->nik . "\n");
        // $printer->text("No. Kartu JKN : " . $request->nomorkartu . "\n");
        $printer->text("No. Telp. : " . $antrian->nohp . "\n");
        if ($request->jenispasien == "JKN") {
            $printer->text("No. Rujukan : " . $antrian->nomorrujukan . "\n");
            $printer->text("No. Surat Kontrol : " . $antrian->nomorsuratkontrol . "\n");
            $printer->text("No. SEP : " . $antrian->nomorsep . "\n");
        }
        $printer->text("================================================\n");
        $printer->text("Jenis Kunj. : " . $request->jeniskunjungan_print . "\n");
        $printer->text("Poliklinik : " . $antrian->namapoli . "\n");
        $printer->text("Dokter : " . $antrian->namadokter . "\n");
        $printer->text("Jam Praktek : " . $antrian->jampraktek . "\n");
        $printer->text("Tanggal : " . Carbon::parse($antrian->tanggalperiksa)->format('d M Y') . "\n");
        $printer->text("================================================\n");
        $printer->text("Keterangan : \n" . $request->keterangan . "\n");
        if ($request->jenispasien != "JKN") {
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Biaya Karcis Poli : " . money($request->tarifkarcis, 'IDR') . "\n");
            $printer->text("Biaya Administrasi : " . money($request->tarifadm, 'IDR') . "\n");
        }
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Jenis Pasien :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->jenispasien . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Kode Booking : " . $antrian->kodebooking . "\n");
        $printer->text("Kode Kunjungan : " . $kunjungan->kode_kunjungan . "\n");
        // $printer->qrCode($request->kodebooking, Printer::QR_ECLEVEL_L, 10, Printer::QR_MODEL_2);
        $printer->text("================================================\n");
        $printer->text("Nomor Antrian Poliklinik :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->nomorantrean . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Lokasi Poliklinik Lantai " . $antrian->lokasi . " \n");
        $printer->text("================================================\n");
        $printer->text("Angka Antrian :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->angkaantrean . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Lokasi Pendaftaran Lantai " . $antrian->lantaipendaftaran . " \n");
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Waktu Cetak : " . $now . "\n");
        $printer->cut();
        $printer->close();
    }
    function print_sep(Request $request, $sep)
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $for_sep = ['POLIKLINIK', 'FARMASI', 'ARSIP'];
        // $for_sep = ['PERCOBAAN'];
        foreach ($for_sep as  $value) {
            Log::notice('Antrian Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else {
                $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->setEmphasis(true);
            $printer->text("SURAT ELEGTABILITAS PASIEN (SEP)\n");
            $printer->text("RSUD WALED KAB. CIREBON\n");
            $printer->setEmphasis(false);
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("SEP untuk " . $value . "\n");
            $printer->text("Nomor SEP :\n");
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->text($sep->noSep . "\n");
            $printer->setEmphasis(false);
            $printer->setTextSize(1, 1);
            $printer->text("Tgl SEP : " . $sep->tglSep . " \n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("================================================\n");
            $printer->text("Nama Pasien : " . $sep->peserta->nama . " \n");
            $printer->text("Nomor Kartu : " . $sep->peserta->noKartu . " \n");
            // $printer->text("No. RM : " . $sep->peserta->mr->noMR . "\n");
            $printer->text("No. Telepon : " . $request->noTelp . "\n");
            $printer->text("Hak Kelas : " . $sep->peserta->hakKelas . " \n");
            $printer->text("Jenis Peserta : " . $sep->peserta->jnsPeserta . " \n\n");
            $printer->text("Jenis Pelayanan : " . $sep->jnsPelayanan . " \n");
            $printer->text("Poli / Spesialis : " . $sep->poli . "\n");
            $printer->text("COB : -\n");
            $printer->text("Diagnosa Awal : " . $sep->diagnosa . "\n");
            $printer->text("Faskes Perujuk : " . $request->faskesPerujuk . "\n");
            $printer->text("Catatan : " . $sep->catatan . "\n\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Cirebon, " . $now->format('d-m-Y') . " \n\n\n\n");
            $printer->text("RSUD Waled \n\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Cetakan : " . $now . "\n");
            $printer->cut();
            $printer->close();
        }
    }
    function print_sep_ulang(Request $request, $sep)
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $for_sep = ['POLIKLINIK', 'FARMASI', 'ARSIP'];
        // $for_sep = ['PERCOBAAN'];
        foreach ($for_sep as  $value) {
            Log::notice('Antrian Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else {
                $printer = "smb://192.168.2.51/EPSON TM-T82X Receipt";
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->setEmphasis(true);
            $printer->text("SURAT ELEGTABILITAS PASIEN (SEP)\n");
            $printer->text("RSUD WALED KAB. CIREBON\n");
            $printer->setEmphasis(false);
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("SEP untuk " . $value . "\n");
            $printer->text("Nomor SEP :\n");
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->text($sep->noSep . "\n");
            $printer->setEmphasis(false);
            $printer->setTextSize(1, 1);
            $printer->text("Tgl SEP : " . $sep->tglSep . " \n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("================================================\n");
            $printer->text("Nama Pasien : " . $sep->peserta->nama . " \n");
            $printer->text("Nomor Kartu : " . $sep->peserta->noKartu . " \n");
            $printer->text("No. RM : " . $sep->peserta->noMr . "\n");
            $printer->text("Hak Kelas : " . $sep->peserta->hakKelas . " \n");
            $printer->text("Jenis Peserta : " . $sep->peserta->jnsPeserta . " \n\n");
            $printer->text("Jenis Pelayanan : " . $sep->jnsPelayanan . " \n");
            $printer->text("Poli / Spesialis : " . $sep->poli . "\n");
            $printer->text("COB : -\n");
            $printer->text("Diagnosa Awal : " . $sep->diagnosa . "\n");
            $printer->text("Catatan : " . $sep->catatan . "\n\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Cirebon, " . $now->format('d-m-Y') . " \n\n\n\n");
            $printer->text("RSUD Waled \n\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Cetakan : " . $now . "\n");
            $printer->cut();
            $printer->close();
        }
    }
    // pendaftaran
    public function antrianPendaftaran(Request $request)
    {
        $antrians = null;
        if ($request->tanggal && $request->loket && $request->jenispasien  && $request->lantai) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->where('method', 'Offline')
                ->where('jenispasien', $request->jenispasien)
                ->where('lantaipendaftaran', $request->lantai)
                ->get();
        }
        return view('simrs.pendaftaran.pendaftaran_antrian', compact([
            'antrians',
            'request',
        ]));
    }
    public function batalpendaftaran(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $antrian->update([
            'taskid' => 99,
            'status_api' => 0,
            'keterangan' => 'Pasien dibatalkan di pendaftaran',
            'user' => Auth::user()->id,
        ]);
        Alert::toast('Pasien dibatalkan', 'success');
        return redirect()->back();
    }
}
