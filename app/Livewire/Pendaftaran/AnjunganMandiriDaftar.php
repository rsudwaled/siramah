<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Penjamin;
use App\Models\TarifLayananDetail;
use App\Models\Transaksi;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class AnjunganMandiriDaftar extends Component
{
    public $pasienbaru = 1;
    public $keyInput = 1;
    public $antriansebelumnya;
    public $inputidentitas = 'nik';
    public $jenispasien, $nik, $nomorkartu, $nomorreferensi, $poliklinik, $kodepoli, $jadwaldokter, $jeniskunjungan;
    public $polikliniks = [], $jadwals = [], $jadwaldokters = [], $namasubspesialis;
    public $rujukans = [], $suratkontrols = [], $rujukanrs = [];
    protected $queryString = ['pasienbaru', 'jenispasien'];
    public function addDigit($digit)
    {
        if ($this->inputidentitas == 'nik') {
            $this->nik .= $digit;
        } else {
            $this->nomorkartu .= $digit;
        }
    }
    public function deleteDigit()
    {
        if ($this->inputidentitas == 'nik') {
            $this->nik = substr($this->nik, 0, -1);
        } else {
            $this->nomorkartu = substr($this->nomorkartu, 0, -1);
        }
    }
    public function updatedInputidentitas()
    {
        $this->rujukanrs = [];
        $this->rujukans = [];
        $this->suratkontrols = [];
        $this->keyInput = 1;
        $this->reset(['nik', 'nomorkartu', 'nomorreferensi', 'jadwaldokter']);
    }
    public function updatedKodepoli()
    {
        $this->jadwaldokter = null;
        $this->jadwals = [];
        $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->where('kodesubspesialis', $this->kodepoli)->get();
    }
    public function cariPasien()
    {
        $this->nomorreferensi = null;
        $this->kodepoli = null;
        $this->jadwals = [];
        $this->rujukans = [];
        $this->suratkontrols = [];
        $this->rujukanrs = [];
        if ($this->nik) {
            $pasien = Pasien::firstWhere('nik_bpjs', $this->nik);
        } else if ($this->nomorkartu) {
            $pasien = Pasien::firstWhere('no_Bpjs', $this->nomorkartu);
        } else {
            return flash("Mohon maaf, Silahkan isi salah satu nik atau nomor BPJS", 'danger');
        }
        if ($pasien) {
            $this->keyInput = 0;
            $this->nomorkartu = $pasien->no_Bpjs;
            $this->nik = $pasien->nik_bpjs;
            $api = new VclaimController();
            $request = new Request([
                'nik' => $pasien->nik_bpjs,
                'tanggal' => now()->format('Y-m-d'),
            ]);
            $res = $api->peserta_nik($request);
            if ($res->metadata->code == 200) {
                $peserta = $res->response->peserta;
                $status = $peserta->statusPeserta->kode;
                if ($status == 0) {
                    $request = new Request([
                        'nomorkartu' =>  $peserta->noKartu,
                        'tanggal' => now()->format('Y-m-d'),
                    ]);
                    $res = $api->suratkontrol_peserta($request);
                    if ($res->metadata->code == 200) {
                        $this->suratkontrols = $res->response->list;
                    }
                    $res = $api->rujukan_peserta($request);
                    if ($res->metadata->code == 200) {
                        $threeMonthsAgo = Carbon::now()->subMonths(3);
                        $this->rujukans = collect($res->response->rujukan)->filter(function ($rujukan) use ($threeMonthsAgo) {
                            return Carbon::parse($rujukan->tglKunjungan)->greaterThanOrEqualTo($threeMonthsAgo);
                        });
                    }
                    $res = $api->rujukan_rs_peserta($request);
                    if ($res->metadata->code == 200) {
                        $threeMonthsAgo = Carbon::now()->subMonths(3);
                        $this->rujukans = collect($res->response->rujukan)->filter(function ($rujukan) use ($threeMonthsAgo) {
                            return Carbon::parse($rujukan->tglKunjungan)->greaterThanOrEqualTo($threeMonthsAgo);
                        });
                    }
                    flash("Pasien Ditemukan atas nama " . $pasien->nama_px, 'success');
                } else {
                    return flash("Mohon maaf, Status Peserta BPJS " . $peserta->statusPeserta->keterangan, 'danger');
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } else {
            return flash("Mohon maaf, NIK Pasien Tidak Ditemukan", 'danger');
        }
    }
    public function pilihSurat($nomorreferensi, $jeniskunjungan, $kodepoli)
    {
        $this->jadwals = [];
        $this->nomorreferensi = $nomorreferensi;
        $this->jeniskunjungan = $jeniskunjungan;
        $this->kodepoli = $kodepoli;
        $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->where('kodesubspesialis', $this->kodepoli)->get();
    }
    public function cetakUlang($kodebooking)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $pasien = Pasien::firstWhere('nik_bpjs', $antrian->nik);
        if (!$antrian->sep) {
            $res = $this->cetakSepAntrian($antrian);
            if ($res->metadata->code == 200) {
                // return flash("Berhasil Cetak Ulang Antrian", 'success');
            } else {
                // return $res->metadata->message;
            }
        }
        // $antrian->update([
        //     'taskid' => 3,
        //     'taskid3' => now(),
        //     'user1' => "Anjungan Pelayanan Mandiri RSUD Waled",
        // ]);
        return view('livewire.pendaftaran.karcis-antrian', compact('antrian', 'pasien'));
    }

    public function daftar(Request $request)
    {
        $this->validate([
            'nik' => 'required',
            'nomorkartu' => 'required',
            'nomorreferensi' => 'required',
            'kodepoli' => 'required',
            'jadwaldokter' => 'required',
            'jeniskunjungan' => 'required',
        ]);
        $pasien = Pasien::firstWhere('nik_bpjs', $this->nik);
        $jadwal = JadwalDokter::find($this->jadwaldokter);
        $request['nomorkartu'] = $pasien->no_Bpjs;
        $request['nik'] = $pasien->nik_bpjs;
        $request['nohp'] =  '089529909036';
        $request['norm'] = $pasien->no_rm;
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodedokter'] = $jadwal->kodedokter;
        $request['kodepoli'] = $jadwal->kodepoli;
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'JKN';
        $request['jeniskunjungan'] = $this->jeniskunjungan;
        $request['nomorreferensi'] = $this->nomorreferensi;
        $api = new AntrianController();
        // ambil antrian
        $res = $api->ambil_antrian($request);
        if ($res->metadata->code != 200) {
            return flash($res->metadata->message, 'danger');
        }
        $antrian  = Antrian::firstWhere('kodebooking', $res->response->kodebooking);
        $antrian->update([
            'taskid' => 99,
        ]);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 3;
        $request['waktu'] = now();
        // update antrian jadi 3
        $res = $api->update_antrean($request);
        if ($res->metadata->code != 200) {
            return flash($res->metadata->message, 'danger');
        }
        // cetak e-sep
        $res = $this->cetakSepAntrian($request);
        if ($res->metadata->code != 200) {
            return flash($res->metadata->message, 'danger');
        }
        $request['nomorsep'] = $res->response->sep->noSep;
        $antrian->update([
            'nomorsep' => $request->nomorsep,
        ]);
        // create kunjungan dan layanan
        $res = $this->createKunjungan($antrian, $request);
        $antrian->update([
            'taskid' => 3,
            "keterangan" => 'Anjungan Pelayanan Mandiri',
            "taskid1" => now(),
            "taskid3" => now(),
            "user1" => 'Anjungan Pelayanan Mandiri',
            "method" => 'Anjungan Pelayanan Mandiri',
        ]);
        $url = route('anjungan.cetak.karcis.bpjs') . "?kodebooking=" . $antrian->kodebooking;
        return redirect()->to($url);
    }
    public function cetakSepAntrian(Request $request)
    {
        $vclaim = new VclaimController();
        // pake surat kontrol
        if ($request->jeniskunjungan == 3) {
            $request['nomorsuratkontrol'] = $request->nomorreferensi;
            $request['noSuratKontrol'] = $request->nomorsuratkontrol;
            $request['noTelp'] = $request->nohp;
            $request['user'] = "Mesin Antrian";
            $suratkontrol = $vclaim->suratkontrol_nomor($request);
            // berhasil get surat kontrol
            if ($suratkontrol->metadata->code == 200) {
                $suratkontrol = $suratkontrol;
                if ($suratkontrol->response->sep->jnsPelayanan == "Rawat Jalan") {
                    $request['nomorkartu'] = $request->nomorkartu;
                    $request['tanggal'] = $request->tanggalperiksa;
                    $data = $vclaim->peserta_nomorkartu($request);
                    if ($data->metadata->code == 200) {
                        $data = $data;
                        $peserta = $data->response->peserta;
                        $request['nomorrujukan'] = $suratkontrol->response->sep->provPerujuk->noRujukan;
                        $sep = $suratkontrol->response->sep;
                        // berhasil get rujukan
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
                        $request['asalRujukan'] = $sep->provPerujuk->asalRujukan; // get surat kontrol
                        $request['tglRujukan'] = $sep->provPerujuk->tglRujukan; // get surat kontrol
                        $request['noRujukan'] = $sep->provPerujuk->noRujukan; // get surat kontrol
                        $request['ppkRujukan'] = $sep->provPerujuk->kdProviderPerujuk; // get surat kontrol
                        // diagnosa
                        $request['catatan'] =  explode(' - ', $sep->diagnosa)[1]; // get surat kontrol
                        $request['diagAwal'] =  explode(' - ', $sep->diagnosa)[0]; // get surat kontrol
                        // poli tujuan
                        $request['tujuan'] =  $request->kodepoli; // get antrian
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
                } else {
                    $request['nomorkartu'] = $request->nomorkartu;
                    $request['tanggal'] = $request->tanggalperiksa;
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
                        $request['tujuan'] =  $request->kodepoli; // get antrian
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
        }
        // pake rujukan
        else {
            $request['nomorrujukan'] = $request->nomorreferensi;
            $request['nomorreferensi'] = $request->nomorreferensi;
            $vclaim = new VclaimController();
            if ($request->jeniskunjungan == 4) {
                $data = $vclaim->rujukan_rs_nomor($request);
            } else if ($request->jeniskunjungan == 1) {
                $data = $vclaim->rujukan_nomor($request);
            }
            if ($data->metadata->code == 200) {
                $data = $data;
                $rujukan = $data->response->rujukan;
                $peserta = $rujukan->peserta;
                $diganosa = $rujukan->diagnosa;
                $tujuan = $rujukan->poliRujukan;
                $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first();
                $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs;
                // $request['kodepenjamin'] = 'P13';
                // tujuan rujukan
                $request['ppkPelayanan'] = "1018R001";
                $request['jnsPelayanan'] = "2";
                // peserta
                $request['klsRawatHak'] = $peserta->hakKelas->kode;
                $request['klsRawatNaik'] = "";
                // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                // asal rujukan
                $request['asalRujukan'] = $data->response->asalFaskes;
                $request['tglRujukan'] = $rujukan->tglKunjungan;
                $request['noRujukan'] =   $request->nomorreferensi;
                $request['ppkRujukan'] = $rujukan->provPerujuk->kode;
                // diagnosa
                $request['catatan'] =  $diganosa->nama;
                $request['diagAwal'] =  $diganosa->kode;
                // poli tujuan
                $request['tujuan'] =  $request->kodepoli;
                $request['eksekutif'] =  0;
                // dpjp
                $request['tujuanKunj'] = "0";
                $request['flagProcedure'] = "";
                $request['kdPenunjang'] = "";
                $request['assesmentPel'] = "";
                // $request['noSurat'] = "";
                $request['kodeDPJP'] = "";
                $request['dpjpLayan'] = $request->kodedokter;
                $request['noTelp'] = $request->nohp;
                $request['nohp'] = $request->nohp;
                $request['user'] = "Mesin Antrian";
            }
        }
        $request = new Request([
            'noKartu' => $request->nomorkartu,
            'noMR' => $request->norm,
            'tglSep' => $request->tanggalperiksa,
            'ppkPelayanan' => "1018R001",
            'jnsPelayanan' => "2",
            'klsRawatHak' => "3",
            // rujukan
            'asalRujukan' => $request->asalRujukan,
            'tglRujukan' => $request->tglRujukan,
            "noRujukan" => $request->noRujukan,
            "ppkRujukan" => $request->ppkRujukan,
            "diagAwal" => $request->diagAwal,
            // data sep
            "catatan" => "Cetak SEP melalui Anjungan Pelayanan Mandiri",
            "tujuan" => $request->kodepoli,
            "eksekutif" => 0, #0
            "tujuanKunj" => $request->tujuanKunj, #0
            "flagProcedure" => "", #0
            "kdPenunjang" => "", #0
            "assesmentPel" =>  $request->assesmentPel, #0
            "dpjpLayan" => $request->kodedokter,
            "noTelp" => $request->nohp,
            "noSurat" => $request->nomorsuratkontrol ?? "",
            "kodeDPJP" => $request->kodedokter,
            "user" => "Anjungan Pelayanan Mandiri RSUD Waled",
        ]);
        $api = new VclaimController();
        $res = $api->sep_insert($request);
        return $res;
    }
    public function createKunjungan($antrian, Request $request)
    {
        try {
            $unit = Unit::firstWhere('KDPOLI', $antrian->kodepoli);
            $tarifkarcis = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis);
            $tarifadm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_adm);
            // rj jkn tipe transaki 2 status layanan 2 status layanan detail opn
            $tipetransaksi = 2;
            $statuslayanan = 2;
            // rj jkn masuk ke tagihan penjamin
            $tagihanpenjamin_karcis = $tarifkarcis->tarif_rajal;
            $tagihanpenjamin_adm = $tarifadm->tarif_rajal;
            $totalpenjamin =  $tarifkarcis->tarif_rajal + $tarifadm->tarif_rajal;
            $tagihanpribadi_karcis = 0;
            $tagihanpribadi_adm = 0;
            $totalpribadi =  0;
            $paramedis = Paramedis::firstWhere('kode_dokter_jkn', $antrian->kodedokter);
            // hitung counter kunjungan
            $kunjungan = Kunjungan::where('no_rm', $antrian->norm)->orderBy('counter', 'DESC')->first();
            if (empty($kunjungan)) {
                $counter = 1;
            } else {
                $counter = $kunjungan->counter + 1;
            }
            // insert ts kunjungan status 8
            $kunjungan  = Kunjungan::create(
                [
                    'counter' => $counter,
                    'no_rm' => $antrian->norm,
                    'kode_unit' => $unit->kode_unit,
                    'tgl_masuk' => now(),
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
                    'created_at' => now(),
                    'keterangan2' => 'MESIN_2',
                ]
            );
            $kunjungan = Kunjungan::where('no_rm', $antrian->norm)->where('counter', $counter)->first();
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
            //  insert layanan header
            $layananbaru = Layanan::create(
                [
                    'kode_layanan_header' => $kodelayanan,
                    'tgl_entry' => now(),
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'kode_unit' => $unit->kode_unit,
                    'kode_tipe_transaksi' => $tipetransaksi,
                    'status_layanan' => $statuslayanan,
                    'pic' => '1319',
                    'keterangan' => 'Layanan header melalui antrian sistem',
                ]
            );
            //  insert layanan header dan detail karcis admin konsul 25 + 5 = 30
            //  DET tahun bulan `tanggal baru urutan 6 digit kanan
            //  insert layanan detail karcis
            $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
            $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1;
            $karcis = LayananDetail::create(
                [
                    'id_layanan_detail' => "DET" . now()->format('ymd') . $nomorlayanandet,
                    'row_id_header' => $layananbaru->id,
                    'kode_layanan_header' => $layananbaru->kode_layanan_header,
                    'kode_tarif_detail' => $tarifkarcis->KODE_TARIF_DETAIL,
                    'total_tarif' => $tarifkarcis->tarif_rajal,
                    'jumlah_layanan' => 1,
                    'tagihan_pribadi' => $tagihanpribadi_karcis,
                    'tagihan_penjamin' => $tagihanpenjamin_karcis,
                    'total_layanan' => $tarifkarcis->tarif_rajal,
                    'grantotal_layanan' => $tarifkarcis->tarif_rajal,
                    'kode_dokter1' => $paramedis->kode_paramedis, // ambil dari mt paramdeis
                    'tgl_layanan_detail' =>   now(),
                    'status_layanan_detail' => "OPN",
                    'tgl_layanan_detail_2' =>   now(),
                ]
            );
            //  insert layanan detail admin
            $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
            $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1;
            $adm = LayananDetail::create(
                [
                    'id_layanan_detail' => "DET" .  now()->format('ymd') . $nomorlayanandet,
                    'row_id_header' => $layananbaru->id,
                    'kode_layanan_header' => $layananbaru->kode_layanan_header,
                    'kode_tarif_detail' => $tarifadm->KODE_TARIF_DETAIL,
                    'total_tarif' => $tarifadm->tarif_rajal,
                    'jumlah_layanan' => 1,
                    'tagihan_pribadi' =>  $tagihanpribadi_adm,
                    'tagihan_penjamin' =>  $tagihanpenjamin_adm,
                    'total_layanan' => $tarifadm->tarif_rajal,
                    'grantotal_layanan' => $tarifadm->tarif_rajal,
                    'kode_dokter1' => 0,
                    'tgl_layanan_detail' =>  now(),
                    'status_layanan_detail' => "OPN",
                    'tgl_layanan_detail_2' =>  now(),
                ]
            );
            //  update layanan header total tagihan
            $layananbaru->update([
                'total_layanan' => $tarifkarcis->tarif_rajal + $tarifadm->tarif_rajal,
                'tagihan_pribadi' => $totalpribadi,
                'tagihan_penjamin' => $totalpenjamin,
            ]);
            $antrian->update([
                "kode_kunjungan" => $kunjungan->kode_kunjungan,
            ]);
            $kunjungan->update([
                'status_kunjungan' => 1,
            ]);
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function render()
    {
        if (count($this->polikliniks) == 0) {
            $this->polikliniks = Unit::where('KDPOLI', '!=', null)->get();
        }
        return view('livewire.pendaftaran.anjungan-mandiri-daftar')
            ->layout('components.layouts.blank_adminlte');
    }
}
