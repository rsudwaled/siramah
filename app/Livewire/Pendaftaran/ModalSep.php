<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\VclaimController;
use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalSep extends Component
{
    public $antrian, $kodebooking, $antrian_id, $nomorreferensi;
    public $polikliniks = [], $dokters = [], $diagnosas = [], $diagnosa;
    public $nomorkartu, $tanggal, $seps = [], $form = false;
    public $asalRujukan, $rujukans = [], $suratkontrols = [];
    public $noKartu, $noMR, $nama, $tglSep, $ppkPelayanan, $jnsPelayanan, $klsRawatHak, $tglRujukan, $noRujukan, $ppkRujukan, $catatan, $diagAwal, $tujuan, $eksekutif, $tujuanKunj = 0, $flagProcedure = "", $kdPenunjang = "", $assesmentPel = "", $noSurat, $kodeDPJP, $dpjpLayan, $noTelp, $user;

    public function hapusSurat($noSep)
    {
        $request = new Request([
            "noSep" => $noSep,
            "user" => auth()->user()->name,
        ]);
        $api = new VclaimController();
        $res = $api->sep_delete($request);
        if ($res->metadata->code == 200) {
            $antrian = Antrian::firstWhere('nomorsep', $noSep);
            if ($antrian) {
                $antrian->update([
                    'sep' =>  null,
                ]);
                $antrian->kunjungan?->update([
                    'sep' =>  null,
                ]);
            }
            $this->form = false;
            $this->cariSEP();
            flash($res->metadata->message, 'success');
        } else {
            flash($res->metadata->message, 'danger');
        }
    }
    public function buatSEP()
    {
        $this->validate([
            "tglSep" => "required",
            "noKartu" => "required",
            "nama" => "required",
            "noMR" => "required",
            "noTelp" => "required",
            'noRujukan' => 'required_if:noSurat,null',
            'noSurat' => 'required_if:noRujukan,null',
            "jnsPelayanan" => "required",
            "tujuan" => "required",
            "dpjpLayan" => "required",
            "diagAwal" => "required",
            "catatan" => "required",
            "tujuanKunj" => "required",
        ]);
        $api  = new VclaimController();
        if ($this->noSurat) {
            $request = new Request([
                "noSuratKontrol" => $this->noSurat,
            ]);
            $res = $api->suratkontrol_nomor($request);
            if ($res->metadata->code == 200) {
                $rujukan = $res->response->sep->provPerujuk;
                $this->asalRujukan = $rujukan->asalRujukan;
                $this->noRujukan = $rujukan->noRujukan;
                $this->tglRujukan = $rujukan->tglRujukan;
                $this->ppkRujukan = $rujukan->kdProviderPerujuk;
                flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
            $this->nomorreferensi = $this->noSurat;
        } else {
            $this->nomorreferensi = $this->noRujukan;
            $request = new Request([
                "nomorrujukan" => $this->noRujukan,
            ]);
            if ($this->asalRujukan == 1) {
                $res = $api->rujukan_nomor($request);
            } else {
                $res = $api->rujukan_rs_nomor($request);
            }
            if ($res->metadata->code == 200) {
                $rujukan = $res->response->rujukan;
                $this->asalRujukan = $this->asalRujukan;
                $this->noRujukan = $rujukan->noKunjungan;
                $this->tglRujukan = $rujukan->tglKunjungan;
                $this->ppkRujukan = $rujukan->peserta->provUmum->kdProvider;
                flash($res->metadata->message, 'success');
            } else {
                return flash($res->metadata->message, 'danger');
            }
        }
        $request = new Request([
            "noKartu" => $this->noKartu,
            "tglSep" => $this->tglSep,
            "noKartu" => $this->noKartu,
            "nama" => $this->nama,
            "noMR" => $this->noMR,
            "noTelp" => $this->noTelp,
            'noRujukan' => $this->noRujukan,
            'asalRujukan' => $this->asalRujukan,
            'tglRujukan' => $this->tglRujukan,
            'ppkRujukan' => $this->ppkRujukan,
            'noSurat' => $this->noSurat,
            "jnsPelayanan" => $this->jnsPelayanan,
            "tujuan" => $this->tujuan,
            "dpjpLayan" => $this->dpjpLayan,
            "diagAwal" => $this->diagAwal,
            "catatan" => $this->catatan,
            "tujuanKunj" => $this->tujuanKunj,
            "flagProcedure" => $this->flagProcedure,
            "kdPenunjang" => $this->kdPenunjang,
            "assesmentPel" => $this->assesmentPel,
            "eksekutif" => $this->eksekutif ?? 0,
            "ppkPelayanan" => "1018R001",
            "klsRawatHak" => "3",
            "user" => auth()->user()->name,
        ]);
        $res = $api->sep_insert($request);
        if ($res->metadata->code == 200) {
            $antrian = Antrian::find($this->antrian_id);
            if ($antrian) {
                $antrian->update([
                    'nomorsep' =>  $res->response->sep->noSep,
                    'nomorreferensi' =>  $this->nomorreferensi,
                    'nomorsuratkontrol' =>  $this->noSurat,
                    'nomorrujukan' =>  $this->noRujukan,
                ]);
                $antrian->kunjungan?->update([
                    'sep' =>  $res->response->sep->noSep,
                    'nomorreferensi' =>  $this->nomorreferensi,
                ]);
            }
            $this->dispatch('refreshPage');
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariRujukan()
    {
        $this->validate([
            'asalRujukan' => 'required',
            'noKartu' => 'required',
        ]);
        $api  = new VclaimController();
        $request = new Request([
            "nomorkartu" => $this->noKartu,
        ]);
        if ($this->asalRujukan == 1) {
            $res = $api->rujukan_peserta($request);
        } else {
            $res = $api->rujukan_rs_peserta($request);
        }
        if ($res->metadata->code == 200) {
            $this->rujukans = [];
            foreach ($res->response->rujukan as $key => $value) {
                $this->rujukans[] = [
                    'no' => $key + 1,
                    'noKunjungan' => $value->noKunjungan,
                    'tglKunjungan' => $value->tglKunjungan,
                    'namaPoli' => $value->poliRujukan->nama,
                    'jenisPelayanan' => $value->pelayanan->nama,
                ];
            }
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariSuratKontrol()
    {
        $this->validate([
            'tglSep' => 'required',
            'noKartu' => 'required',
        ]);
        $api  = new VclaimController();
        $request = new Request([
            "nomorkartu" => $this->nomorkartu,
            "formatfilter" => 2,
            "bulan" => Carbon::parse($this->tglSep)->format('m'),
            "tahun" => Carbon::parse($this->tglSep)->format('Y'),
        ]);
        $res = $api->suratkontrol_peserta($request);
        if ($res->metadata->code == 200) {
            $this->suratkontrols = [];
            foreach ($res->response->list as $key => $value) {
                $this->suratkontrols[] = [
                    'no' => $key + 1,
                    'noSuratKontrol' => $value->noSuratKontrol,
                    'tglRencanaKontrol' => $value->tglRencanaKontrol,
                    'namaPoliTujuan' => $value->namaPoliTujuan,
                    'terbitSEP' => $value->terbitSEP,
                ];
            }
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function cariSEP()
    {
        $this->validate([
            'nomorkartu' => 'required',
        ]);
        $api = new VclaimController();
        $request = new Request([
            'nomorkartu' => $this->nomorkartu,
            'tanggalMulai' => now()->subDays(90)->format('Y-m-d'),
            'tanggalAkhir' => now()->format('Y-m-d'),
        ]);
        $res = $api->monitoring_pelayanan_peserta($request);
        if ($res->metadata->code == 200) {
            $this->seps = [];
            $this->seps = $res->response->histori;
            return flash($res->metadata->message, 'success');
        } else {
            return flash($res->metadata->message, 'danger');
        }
    }
    public function updatedDiagAwal()
    {
        $this->validate([
            'diagAwal' => 'required|min:3',
        ]);
        try {
            $api = new VclaimController();
            $request = new Request([
                'diagnosa' => $this->diagAwal,
            ]);
            $res = $api->ref_diagnosa($request);
            if ($res->metadata->code == 200) {
                $this->diagnosas = [];
                foreach ($res->response->diagnosa as $key => $value) {
                    $this->diagnosas[] = [
                        'kode' => $value->kode,
                        'nama' => $value->nama,
                    ];
                }
            } else {
                return flash($res->metadata->message, 'danger');
            }
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function openForm()
    {
        $this->form = $this->form ?  false : true;
    }
    public function mount(Antrian $antrian)
    {
        $this->antrian = $antrian;
        $this->nomorkartu = $antrian->nomorkartu;
        $this->kodebooking = $antrian->kodebooking;
        $this->antrian_id = $antrian->id;
        $this->noKartu = $antrian->nomorkartu;
        $this->noMR = $antrian->norm;
        $this->nama = $antrian->nama;
        $this->noTelp = $antrian->nohp;
        $this->polikliniks = Unit::where('KDPOLI', '!=', null)->pluck('nama_unit', 'KDPOLI');
        $this->dokters = Dokter::pluck('namadokter', 'kodedokter');
    }
    public function render()
    {
        return view('livewire.pendaftaran.modal-sep');
    }
}
