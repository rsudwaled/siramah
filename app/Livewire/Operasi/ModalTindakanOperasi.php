<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use App\Models\TindakanOperasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ModalTindakanOperasi extends Component
{
    public $kunjungan, $tindakan;
    public $kode, $nomor, $dokter_pelaksana, $pemberi_informasi, $jabatan, $penerima_informasi, $hubungan_pasien;
    public $diagnosa, $dasar_diagnosa, $tindakan_kedokteran, $indikasi_tindakan, $tata_cara, $tujuan, $resiko, $komplikasi, $prognosis, $alternatif_resiko, $lainnya, $ttd_dokter, $ttd_pasien;
    public function render()
    {
        return view('livewire.operasi.modal-tindakan-operasi');
    }
    public function mount($kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $tindakan = TindakanOperasi::firstWhere('kode_kunjungan', $kunjungan->kode_kunjungan);
        $this->tindakan = $tindakan;
        if ($tindakan) {
            $this->dokter_pelaksana = $tindakan->dokter_pelaksana;
            $this->pemberi_informasi = $tindakan->pemberi_informasi;
            $this->jabatan = $tindakan->jabatan;
            $this->penerima_informasi = $tindakan->penerima_informasi;
            $this->hubungan_pasien = $tindakan->hubungan_pasien;
            //
            $this->diagnosa = $tindakan->diagnosa;
            $this->dasar_diagnosa = $tindakan->dasar_diagnosa;
            $this->tindakan_kedokteran = $tindakan->tindakan_kedokteran;
            $this->indikasi_tindakan = $tindakan->indikasi_tindakan;
            $this->tata_cara = $tindakan->tata_cara;
            $this->tujuan = $tindakan->tujuan;
            $this->resiko = $tindakan->resiko;
            $this->komplikasi = $tindakan->komplikasi;
            $this->prognosis = $tindakan->prognosis;
            $this->alternatif_resiko = $tindakan->alternatif_resiko;
            $this->lainnya = $tindakan->lainnya;
            $this->ttd_dokter = $tindakan->ttd_dokter;
            $this->ttd_pasien = $tindakan->ttd_pasien;
        }
    }
    public function simpan()
    {
        $laporan = TindakanOperasi::updateOrCreate([
            'kode_kunjungan' => $this->kunjungan->kode_kunjungan,
            'no_rm' => $this->kunjungan->no_rm,
        ], [
            'kode' => $this->kode ??  strtoupper(uniqid()),
            'nomor' => $this->nomor,
            'dokter_pelaksana' => $this->dokter_pelaksana,
            'pemberi_informasi' => $this->pemberi_informasi,
            'jabatan' => $this->jabatan,
            'penerima_informasi' => $this->penerima_informasi,
            'hubungan_pasien' => $this->hubungan_pasien,
            //
            'diagnosa' => $this->diagnosa,
            'dasar_diagnosa' => $this->dasar_diagnosa,
            'tindakan_kedokteran' => $this->tindakan_kedokteran,
            'indikasi_tindakan' => $this->indikasi_tindakan,
            'tata_cara' => $this->tata_cara,
            'tujuan' => $this->tujuan,
            'resiko' => $this->resiko,
            'komplikasi' => $this->komplikasi,
            'prognosis' => $this->prognosis,
            'alternatif_resiko' => $this->alternatif_resiko,
            'lainnya' => $this->lainnya,
            'ttd_dokter' => $this->ttd_dokter,
            'ttd_pasien' => $this->ttd_pasien,
        ]);
        Alert::success('Success', 'Berhasil simpan tindakan operasi');
        $url = route('erm.oprasi') . "?kode_kunjungan=" . $this->kunjungan->kode_kunjungan;
        return redirect()->to($url);
    }
    public function tindakan_print (Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode_kunjungan);
        $tindakan = TindakanOperasi::firstWhere('kode_kunjungan', $request->kode_kunjungan);
        // return view('livewire.operasi.pdf_tindakan_operasi', compact('laporan','kunjungan'));
        $pdf = Pdf::loadView('livewire.operasi.pdf_tindakan_operasi', compact('tindakan', 'kunjungan'));
        return $pdf->stream('tindakan_operasi.pdf');
    }
}
