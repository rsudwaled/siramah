<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class AnjunganMandiriDaftar extends Component
{
    public $pasienbaru = 1;
    public $antriansebelumnya;
    public $inputidentitas = 'nik';
    public $jenispasien, $nik, $nomorkartu, $nomorreferensi, $poliklinik, $kodepoli, $jadwaldokter, $jeniskunjungan;
    public $polikliniks = [], $jadwals = [];
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
        if ($res->metadata->code == 200) {
            $antrian  = Antrian::firstWhere('kodebooking', $res->response->kodebooking);
            $res = $this->cetakSepAntrian($antrian);
            dd($res);
            flash($res->metadata->message, 'success');
        } else if ($res->metadata->code == 409) {
            $this->antriansebelumnya = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
                ->where('nik', $request->nik)
                ->where('taskid', '<=', 5)
                ->first();
            flash($res->metadata->message, 'danger');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function updatedJadwaldokter()
    {
    }
    public function updatedKodepoli()
    {
        $this->jadwaldokter = null;
        $this->jadwals = [];
        $this->jadwals = JadwalDokter::where('hari', now()->dayOfWeek)->where('kodesubspesialis', $this->kodepoli)->get();
    }
    public function pilihSurat($nomorreferensi, $jeniskunjungan)
    {
        $this->jadwals = [];
        $this->nomorreferensi = $nomorreferensi;
        $this->jeniskunjungan = $jeniskunjungan;
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
                        $this->rujukans = $res->response->rujukan;
                    }
                    $res = $api->rujukan_rs_peserta($request);
                    if ($res->metadata->code == 200) {
                        $this->rujukanrs = $res->response->rujukan;
                    }
                    flash("Pasien Ditemukan atas nama " . $pasien->nama_px, 'success');
                } else {
                    return flash("Mohon maaf, Status Peserta BPJS " . $peserta->statusPeserta->keterangan, 'danger');
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } else {
            return   flash("Mohon maaf, NIK Pasien Tidak Ditemukan", 'danger');
        }
    }
    public function render()
    {
        $this->polikliniks = JadwalDokter::where('hari', now()->dayOfWeek)->select('kodesubspesialis', 'namasubspesialis')->groupBy('kodesubspesialis', 'namasubspesialis')->get();
        return view('livewire.pendaftaran.anjungan-mandiri-daftar')
            ->layout('components.layouts.blank_adminlte');
    }
}
