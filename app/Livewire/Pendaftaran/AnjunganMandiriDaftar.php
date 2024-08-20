<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function cetakUlang($kodebooking)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $pasien = Pasien::firstWhere('nik_bpjs', $antrian->nik);
        if (!$antrian->sep) {
            $res = $this->cetakSepAntrian($antrian);
            if ($res->metadata->code == 200) {
                dd($res);
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
    public function cetakSepAntrian(Antrian $antrian)
    {
        $tujuanKunjungan = "0";
        $assesmentPel = "";
        $asalRujukan = null;
        $tglRujukan = null;
        $noRujukan = null;
        $ppkRujukan = null;
        $diagAwal = null;
        $kodedokter = null;
        $api = new VclaimController();
        switch ($antrian->jeniskunjungan) {
            case '1':
                dd($antrian);
                break;
            case '3':
                $tujuanKunjungan = "2";
                $assesmentPel = "2";
                $request = new Request([
                    'noSuratKontrol' => $antrian->nomorsuratkontrol,
                ]);
                $res = $api->suratkontrol_nomor($request);
                if ($res->metadata->code == 200) {

                    $kodedokter =  $res->response->kodeDokter;
                    $asalRujukan = $res->response->sep->provPerujuk->asalRujukan;
                    $tglRujukan = $res->response->sep->provPerujuk->tglRujukan;
                    $noRujukan = $res->response->sep->provPerujuk->noRujukan;
                    $ppkRujukan = $res->response->sep->provPerujuk->kdProviderPerujuk;
                    $diagAwal = str_replace(" ", "", explode('-', $res->response->sep->diagnosa)[0]);
                    if ($res->response->tglRencanaKontrol != now()->format('Y-m-d')) {
                        $request = new Request([
                            "noSuratKontrol" => $res->response->noSuratKontrol,
                            "noSEP" => $res->response->sep->noSep,
                            "kodeDokter" => $res->response->kodeDokter,
                            "poliKontrol" => $res->response->poliTujuan,
                            "tglRencanaKontrol" => now()->format('Y-m-d'),
                            "user" => "Anjungan Pelayanan Mandiri RSUD Waled",
                        ]);
                        $api = new VclaimController();
                        $updatesuratkontrol = $api->suratkontrol_update($request);
                    }
                }
                break;
            case '4':
                dd($antrian);
                break;

            default:
                break;
        }
        $request = new Request([
            'noKartu' => $antrian->nomorkartu,
            'noMR' => $antrian->norm,
            'tglSep' => $antrian->tanggalperiksa,
            'ppkPelayanan' => "1018R001",
            'jnsPelayanan' => "2",
            'klsRawatHak' => "3",
            // rujukan
            'asalRujukan' => $asalRujukan,
            'tglRujukan' => $tglRujukan,
            "noRujukan" => $noRujukan,
            "ppkRujukan" => $ppkRujukan,
            "diagAwal" => $diagAwal,
            // data sep
            "catatan" => "cetak sep mesin anjungan",
            "tujuan" => $antrian->kodepoli,
            "eksekutif" => 0, #0
            "tujuanKunj" => $tujuanKunjungan, #0
            "flagProcedure" => "", #0
            "kdPenunjang" => "", #0
            "assesmentPel" =>  $assesmentPel, #0
            "dpjpLayan" => $kodedokter,
            "noTelp" => $antrian->nohp,
            "noSurat" => $antrian->nomorsuratkontrol ?? "",
            "kodeDPJP" => $kodedokter ?? $antrian->kodedokter,
            "user" => "Anjungan Pelayanan Mandiri RSUD Waled",
        ]);
        $api = new VclaimController();
        $res = $api->sep_insert($request);
        return $res;
    }
    public function daftar()
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
        $request = new Request([
            'nomorkartu' => $pasien->no_Bpjs,
            'nik' => $pasien->nik_bpjs,
            'nohp' =>  '089529909036',
            'norm' => $pasien->no_rm,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'kodedokter' => $jadwal->kodedokter,
            'kodepoli' => $jadwal->kodepoli,
            'jampraktek' => $jadwal->jadwal,
            'jenispasien' => 'JKN',
            'jeniskunjungan' => $this->jeniskunjungan,
            'nomorreferensi' => $this->nomorreferensi,
        ]);
        $api = new AntrianController();
        $res = $api->ambil_antrian($request);
        if ($res->metadata->code != 200) {
            return flash($res->metadata->message, 'danger');
        }
        $antrian  = Antrian::firstWhere('kodebooking', $res->response->kodebooking);
        $antrian->update([
            'taskid' => 99,
        ]);
        $request = new Request([
            'kodebooking' => $antrian->kodebooking,
            'taskid' => 3,
            'waktu' => now(),
        ]);
        $res = $api->update_antrean($request);
        dd($request->all(), $res);
        $res = $this->cetakSepAntrian($antrian);
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
    public function pilihSurat($nomorreferensi, $jeniskunjungan, $kodepoli)
    {
        $this->jadwals = [];
        $this->nomorreferensi = $nomorreferensi;
        $this->jeniskunjungan = $jeniskunjungan;
        $this->kodepoli = $kodepoli;
        $this->polikliniks = Unit::where('KDPOLI', '!=', null)->get();
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
    public function pilihPoliUmum($key)
    {
        $this->namasubspesialis = $key;
        $this->jadwaldokters = JadwalDokter::where('hari', now()->dayOfWeek)->where('namasubspesialis', $key)->get();
    }
    public function pilihDokterUmum($id, Request $request)
    {
        $jadwal = JadwalDokter::find($id);
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        $request['kodepoli'] = $jadwal->kodesubspesialis;
        $request['kodedokter'] = $jadwal->kodedokter;
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jenispasien'] = 'NON-JKN';
        $request['method'] = 'Offline';
        // ambil antrian offline
        $api = new PendaftaranController();
        $res = $api->ambil_antrian_offline($request);
        if ($res->metadata->code == 200) {
            $url = route('anjungan.cetak.karcis.umum') . "?kodebooking=" . $res->response->kodebooking;
            return redirect()->to($url);
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function render()
    {
        if ($this->jenispasien == "NON-JKN") {
            if (count($this->jadwals) == 0) {
                $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->get();
            }
        }
        return view('livewire.pendaftaran.anjungan-mandiri-daftar')
            ->layout('components.layouts.blank_adminlte');
    }
}
