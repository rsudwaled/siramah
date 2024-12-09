<?php

namespace App\Livewire\Poliklinik;

use App\Http\Controllers\VclaimController;
use App\Models\Kunjungan;
use App\Models\Paramedis;
use App\Models\Unit;
use Illuminate\Http\Request;
use Livewire\Component;

class ModalSep extends Component
{
    public $antrian, $kunjungan, $kodebooking, $antrian_id, $nomorreferensi;
    public $polikliniks = [], $dokters = [], $diagnosas = [], $diagnosa;
    public $nomorkartu, $tanggal, $seps = [], $form = false;
    public $asalRujukan, $rujukans = [], $suratkontrols = [];
    public $noKartu, $noMR, $nama, $tglSep, $ppkPelayanan, $jnsPelayanan, $klsRawatHak, $tglRujukan, $noRujukan, $ppkRujukan, $catatan, $diagAwal, $tujuan = "", $eksekutif, $tujuanKunj = 0, $flagProcedure = "", $kdPenunjang = "", $assesmentPel = "", $noSurat = "", $kodeDPJP = "", $dpjpLayan = "", $noTelp, $user;
    public function render()
    {
        return view('livewire.pendaftaran.modal-sep');
    }
    public function mount(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $this->nomorkartu = $kunjungan->pasien?->no_Bpjs;
        $this->noKartu = $kunjungan->pasien?->no_Bpjs;
        $this->noMR = $kunjungan->pasien?->no_rm;
        $this->nama = $kunjungan->pasien?->nama_px;
        $this->noTelp = $kunjungan->pasien?->no_hp;
        // $this->klsRawatHak = $kunjungan->pasien?->hakkelas;
        $this->polikliniks = Unit::where('KDPOLI', '!=', null)->pluck('nama_unit', 'KDPOLI');
        $this->dokters = Paramedis::where('kode_dokter_jkn', '!=', null)->pluck('nama_paramedis', 'kode_dokter_jkn');
        $this->cariSEP();
    }
    // public function buatSEP()
    // {
    //     $this->validate([
    //         "tglSep" => "required",
    //         "noKartu" => "required",
    //         "nama" => "required",
    //         "noMR" => "required",
    //         "noTelp" => "required",
    //         'noRujukan' => 'required_if:noSurat,null',
    //         'noSurat' => 'required_if:noRujukan,null',
    //         "jnsPelayanan" => "required",
    //         // "tujuan" => "required",
    //         // "dpjpLayan" => "required",
    //         "diagAwal" => "required",
    //         "catatan" => "required",
    //         "tujuanKunj" => "required",
    //     ]);
    //     $api  = new VclaimController();
    //     // surat kontrol
    //     if ($this->noSurat) {
    //         $request = new Request([
    //             "noSuratKontrol" => $this->noSurat,
    //         ]);
    //         $res = $api->suratkontrol_nomor($request);
    //         if ($res->metadata->code == 200) {
    //             if ($res->response->jnsKontrol == 1) {
    //                 $spri = $res->response;
    //                 $this->kodeDPJP = $res->response->kodeDokter;
    //                 $this->asalRujukan = 2;
    //                 $this->noRujukan = $spri->noSuratKontrol;
    //                 $this->tglRujukan = $spri->tglRencanaKontrol;
    //                 $this->ppkRujukan = "0125S007";
    //             } else {
    //                 $this->kodeDPJP = $res->response->kodeDokter;
    //                 $rujukan = $res->response->sep->provPerujuk;
    //                 $this->asalRujukan = $rujukan->asalRujukan;
    //                 $this->noRujukan = $rujukan->noRujukan;
    //                 $this->tglRujukan = $rujukan->tglRujukan;
    //                 $this->ppkRujukan = $rujukan->kdProviderPerujuk;
    //             }
    //         } else {
    //             return flash($res->metadata->message, 'danger');
    //         }
    //         $this->nomorreferensi = $this->noSurat;
    //     }
    //     // rujukan
    //     else {
    //         $this->nomorreferensi = $this->noRujukan;
    //         $request = new Request([
    //             "nomorrujukan" => $this->noRujukan,
    //         ]);
    //         if ($this->asalRujukan == 1) {
    //             $res = $api->rujukan_nomor($request);
    //         } else {
    //             $res = $api->rujukan_rs_nomor($request);
    //         }
    //         if ($res->metadata->code == 200) {
    //             $rujukan = $res->response->rujukan;
    //             $this->asalRujukan = $this->asalRujukan;
    //             $this->noRujukan = $rujukan->noKunjungan;
    //             $this->tglRujukan = $rujukan->tglKunjungan;
    //             $this->ppkRujukan = $rujukan->provPerujuk->kode;
    //             flash($res->metadata->message, 'success');
    //         } else {
    //             return flash($res->metadata->message, 'danger');
    //         }
    //     }
    //     $request = new Request([
    //         "noKartu" => $this->noKartu,
    //         "tglSep" => $this->tglSep,
    //         "noKartu" => $this->noKartu,
    //         "nama" => $this->nama,
    //         "noMR" => $this->noMR,
    //         "noTelp" => $this->noTelp,
    //         'noRujukan' => $this->noRujukan,
    //         'asalRujukan' => $this->asalRujukan,
    //         'tglRujukan' => $this->tglRujukan,
    //         'ppkRujukan' => $this->ppkRujukan,
    //         'noSurat' => $this->noSurat,
    //         'kodeDPJP' => $this->kodeDPJP,
    //         "jnsPelayanan" => $this->jnsPelayanan,
    //         "tujuan" => $this->tujuan,
    //         "dpjpLayan" => $this->dpjpLayan,
    //         "diagAwal" => $this->diagAwal,
    //         "catatan" => $this->catatan,
    //         "tujuanKunj" => $this->tujuanKunj,
    //         "flagProcedure" => $this->flagProcedure,
    //         "kdPenunjang" => $this->kdPenunjang,
    //         "assesmentPel" => $this->assesmentPel,
    //         "eksekutif" => $this->eksekutif ?? 0,
    //         "ppkPelayanan" => "0125S007",
    //         "klsRawatHak" => $this->klsRawatHak,
    //         "user" => auth()->user()->name,
    //     ]);
    //     $res = $api->sep_insert($request);
    //     if ($res->metadata->code == 200) {
    //         $antrian = Antrian::find($this->antrian_id);
    //         if ($antrian) {
    //             $antrian->update([
    //                 'sep' =>  $res->response->sep->noSep,
    //                 'nomorreferensi' =>  $this->nomorreferensi,
    //                 'nomorsuratkontrol' =>  $this->noSurat,
    //                 'nomorrujukan' =>  $this->noRujukan,
    //             ]);
    //         }
    //         if ($this->antrian) {
    //             $this->antrian->update([
    //                 'sep' =>  $res->response->sep->noSep,
    //                 'nomorreferensi' =>  $this->nomorreferensi,
    //                 'nomorsuratkontrol' =>  $this->noSurat,
    //                 'nomorrujukan' =>  $this->noRujukan,
    //             ]);
    //         }
    //         if ($this->kunjungan) {
    //             $this->kunjungan->update([
    //                 'sep' =>  $res->response->sep->noSep,
    //                 'nomorreferensi' =>  $this->nomorreferensi,
    //             ]);
    //         }
    //         $this->cariSEP();
    //         $this->form = 0;
    //         $this->dispatch('refreshPage');
    //         return flash($res->metadata->message, 'success');
    //     } else {
    //         return flash($res->metadata->message, 'danger');
    //     }
    // }
    // public function hapusSurat($noSep)
    // {
    //     $request = new Request([
    //         "noSep" => $noSep,
    //         "user" => auth()->user()->name,
    //     ]);
    //     $api = new VclaimController();
    //     $res = $api->sep_delete($request);
    //     if ($res->metadata->code == 200) {
    //         if ($this->antrian) {
    //             $this->antrian->update([
    //                 'sep' => null,
    //                 'nomorreferensi' => null,
    //                 'nomorsuratkontrol' =>  null,
    //                 'nomorrujukan' =>  null,
    //             ]);
    //         }
    //         if ($this->kunjungan) {
    //             $this->kunjungan->update([
    //                 'sep' =>  null,
    //                 'nomorreferensi' =>  null,
    //             ]);
    //         }
    //         $this->cariSEP();
    //         $this->dispatch('refreshPage');
    //         return flash($res->metadata->message, 'success');
    //     } else {
    //         return flash($res->metadata->message, 'danger');
    //     }
    // }
    // public function cariRujukan()
    // {
    //     $this->validate([
    //         'asalRujukan' => 'required',
    //         'noKartu' => 'required',
    //     ]);
    //     $api  = new VclaimController();
    //     $request = new Request([
    //         "nomorkartu" => $this->noKartu,
    //     ]);
    //     if ($this->asalRujukan == 1) {
    //         $res = $api->rujukan_peserta($request);
    //     } else {
    //         $res = $api->rujukan_rs_peserta($request);
    //     }
    //     if ($res->metadata->code == 200) {
    //         $this->rujukans = [];
    //         foreach ($res->response->rujukan as $key => $value) {
    //             $this->rujukans[] = [
    //                 'no' => $key + 1,
    //                 'noKunjungan' => $value->noKunjungan,
    //                 'tglKunjungan' => $value->tglKunjungan,
    //                 'namaPoli' => $value->poliRujukan->nama,
    //                 'jenisPelayanan' => $value->pelayanan->nama,
    //             ];
    //         }
    //         return flash($res->metadata->message, 'success');
    //     } else {
    //         return flash($res->metadata->message, 'danger');
    //     }
    // }
    // public function cariSuratKontrol()
    // {
    //     $this->validate([
    //         'tglSep' => 'required',
    //         'noKartu' => 'required',
    //     ]);
    //     $api  = new VclaimController();
    //     $request = new Request([
    //         "nomorkartu" => $this->nomorkartu,
    //         "formatfilter" => 2,
    //         "bulan" => Carbon::parse($this->tglSep)->format('m'),
    //         "tahun" => Carbon::parse($this->tglSep)->format('Y'),
    //     ]);
    //     $res = $api->suratkontrol_peserta($request);
    //     if ($res->metadata->code == 200) {
    //         $this->suratkontrols = [];
    //         foreach ($res->response->list as $key => $value) {
    //             $this->suratkontrols[] = [
    //                 'no' => $key + 1,
    //                 'noSuratKontrol' => $value->noSuratKontrol,
    //                 'tglRencanaKontrol' => $value->tglRencanaKontrol,
    //                 'namaPoliTujuan' => $value->namaPoliTujuan,
    //                 'terbitSEP' => $value->terbitSEP,
    //             ];
    //         }
    //         return flash($res->metadata->message, 'success');
    //     } else {
    //         return flash($res->metadata->message, 'danger');
    //     }
    // }
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
    // public function updatedDiagAwal()
    // {
    //     $this->validate([
    //         'diagAwal' => 'required|min:3',
    //     ]);
    //     try {
    //         $api = new VclaimController();
    //         $request = new Request([
    //             'diagnosa' => $this->diagAwal,
    //         ]);
    //         $res = $api->ref_diagnosa($request);
    //         if ($res->metadata->code == 200) {
    //             $this->diagnosas = [];
    //             foreach ($res->response->diagnosa as $key => $value) {
    //                 $this->diagnosas[] = [
    //                     'kode' => $value->kode,
    //                     'nama' => $value->nama,
    //                 ];
    //             }
    //         } else {
    //             return flash($res->metadata->message, 'danger');
    //         }
    //     } catch (\Throwable $th) {
    //         return flash($th->getMessage(), 'danger');
    //     }
    // }
    public function openForm()
    {
        $this->form = $this->form ?  false : true;
    }
}
