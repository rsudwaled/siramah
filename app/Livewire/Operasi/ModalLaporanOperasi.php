<?php

namespace App\Livewire\Operasi;

use App\Models\Kunjungan;
use App\Models\LaporanOperasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ModalLaporanOperasi extends Component
{
    public $kunjungan, $laporan;
    public $nomor, $kode, $ruang_operasi, $kamar_operasi, $cytoterencana, $tanggal_operasi, $jam_operasi_mulai, $jam_operasi_selesai, $lama_operasi;
    public $pembedah, $asisten1, $asisten2, $perawat_instrumen, $ahli_anastesi, $jenis_anastesi;
    public $diagnosa_pra_bedah, $indikasi_operasi, $diagnosa_pasca_bedah, $jenis_operasi, $desinfekasi_kulit, $jaringan_dieksisi, $dikirim_lab, $jenis_bahan, $pemeriksaan_laboratorium, $macam_sayatan, $posisi_penderita, $teknik_temuan_operasi;
    public $bhp_khusus, $penggunaan_bhp_khusus, $komplikasi_operasi, $penjabaran_komplikasi, $pendarahan;
    public $kontrol, $puasa, $drain, $infus, $obat, $ganti_balut, $lainnya, $tgl_laporan, $pembuat_laporan;
    public function render()
    {
        return view('livewire.operasi.modal-laporan-operasi');
    }
    public function mount($kunjungan)
    {
        $this->kunjungan = $kunjungan;
        $laporan = LaporanOperasi::firstWhere('kode_kunjungan', $kunjungan->kode_kunjungan);
        $this->laporan = $laporan;
        if ($laporan) {
            $this->kode = $laporan->kode;
            $this->nomor = $laporan->nomor;
            $this->ruang_operasi = $laporan->ruang_operasi;
            $this->kamar_operasi = $laporan->kamar_operasi;
            $this->cytoterencana = $laporan->cytoterencana;
            $this->tanggal_operasi = $laporan->tanggal_operasi;
            $this->jam_operasi_mulai = $laporan->jam_operasi_mulai;
            $this->jam_operasi_selesai = $laporan->jam_operasi_selesai;
            $lama_operasi = null;
            if (
                $laporan->jam_operasi_mulai && $laporan->jam_operasi_selesai
                && $laporan->jam_operasi_mulai !== '0000-00-00 00:00:00'
                && $laporan->jam_operasi_selesai !== '0000-00-00 00:00:00'
            ) {
                $start = Carbon::parse($laporan->jam_operasi_mulai);
                $end = Carbon::parse($laporan->jam_operasi_selesai);
                $diffInHours = $start->diffInHours($end); // Menghitung selisih dalam jam
                $diffInMinutes = $start->diffInMinutes($end) % 60;
                $lama_operasi = $diffInHours . " jam " . $diffInMinutes . " menit";
            }
            $this->lama_operasi = $lama_operasi ?? "-";
            $this->pembedah = $laporan->pembedah;
            $this->asisten1 = $laporan->asisten1;
            $this->asisten2 = $laporan->asisten2;
            $this->perawat_instrumen = $laporan->perawat_instrumen;
            $this->ahli_anastesi = $laporan->ahli_anastesi;
            $this->jenis_anastesi = $laporan->jenis_anastesi;
            $this->diagnosa_pra_bedah = $laporan->diagnosa_pra_bedah;
            $this->indikasi_operasi = $laporan->indikasi_operasi;
            $this->diagnosa_pasca_bedah = $laporan->diagnosa_pasca_bedah;
            $this->jenis_operasi = $laporan->jenis_operasi;
            $this->desinfekasi_kulit = $laporan->desinfekasi_kulit;
            $this->jaringan_dieksisi = $laporan->jaringan_dieksisi;
            $this->dikirim_lab = $laporan->dikirim_lab;
            $this->jenis_bahan = $laporan->jenis_bahan;
            $this->jenis_bahan = $laporan->jenis_bahan;
            $this->pemeriksaan_laboratorium = $laporan->pemeriksaan_laboratorium;
            $this->macam_sayatan = $laporan->macam_sayatan;
            $this->posisi_penderita = $laporan->posisi_penderita;
            $this->teknik_temuan_operasi = $laporan->teknik_temuan_operasi;
            $this->bhp_khusus = $laporan->bhp_khusus;
            $this->penggunaan_bhp_khusus = $laporan->penggunaan_bhp_khusus;
            $this->komplikasi_operasi = $laporan->komplikasi_operasi;
            $this->penjabaran_komplikasi = $laporan->penjabaran_komplikasi;
            $this->pendarahan = $laporan->pendarahan;
            $this->kontrol = $laporan->kontrol;
            $this->puasa = $laporan->puasa;
            $this->drain = $laporan->drain;
            $this->infus = $laporan->infus;
            $this->obat = $laporan->obat;
            $this->ganti_balut = $laporan->ganti_balut;
            $this->lainnya = $laporan->lainnya;
            $this->tgl_laporan = $laporan->tgl_laporan;
            $this->pembuat_laporan = $laporan->pembuat_laporan;
        }
    }
    public function simpan()
    {
        $laporan = LaporanOperasi::updateOrCreate([
            'kode_kunjungan' => $this->kunjungan->kode_kunjungan,
            'no_rm' => $this->kunjungan->no_rm,
        ], [
            'kode' => $this->kode ??  strtoupper(uniqid()),
            'nomor' => $this->nomor,
            'ruang_operasi' => $this->ruang_operasi,
            'kamar_operasi' => $this->kamar_operasi,
            'cytoterencana' => $this->cytoterencana,
            'tanggal_operasi' => $this->tanggal_operasi,
            'jam_operasi_mulai' => $this->jam_operasi_mulai,
            'jam_operasi_selesai' => $this->jam_operasi_selesai,
            'lama_operasi' => $this->lama_operasi,
            'pembedah' => $this->pembedah,
            'asisten1' => $this->asisten1,
            'asisten2' => $this->asisten2,
            'perawat_instrumen' => $this->perawat_instrumen,
            'ahli_anastesi' => $this->ahli_anastesi,
            'jenis_anastesi' => $this->jenis_anastesi,
            //
            'diagnosa_pra_bedah' => $this->diagnosa_pra_bedah,
            'indikasi_operasi' => $this->indikasi_operasi,
            'diagnosa_pasca_bedah' => $this->diagnosa_pasca_bedah,
            'jenis_operasi' => $this->jenis_operasi,
            'desinfekasi_kulit' => $this->desinfekasi_kulit,
            'jaringan_dieksisi' => $this->jaringan_dieksisi,
            'dikirim_lab' => $this->dikirim_lab,
            'jenis_bahan' => $this->jenis_bahan,
            'pemeriksaan_laboratorium' => $this->pemeriksaan_laboratorium,
            'macam_sayatan' => $this->macam_sayatan,
            'posisi_penderita' => $this->posisi_penderita,
            'teknik_temuan_operasi' => $this->teknik_temuan_operasi,
            //
            'bhp_khusus' => $this->bhp_khusus,
            'penggunaan_bhp_khusus' => $this->penggunaan_bhp_khusus,
            'komplikasi_operasi' => $this->komplikasi_operasi,
            'penjabaran_komplikasi' => $this->penjabaran_komplikasi,
            'pendarahan' => $this->pendarahan,
            //
            'kontrol' => $this->kontrol,
            'puasa' => $this->puasa,
            'drain' => $this->drain,
            'infus' => $this->infus,
            'obat' => $this->obat,
            'ganti_balut' => $this->ganti_balut,
            'lainnya' => $this->lainnya,
            'tgl_laporan' => $this->tgl_laporan,
            'pembuat_laporan' => $this->pembuat_laporan,
        ]);

        Alert::success('Success', 'Berhasil simpan laporan operasi');
        $url = route('erm.oprasi') . "?kode_kunjungan=" . $this->kunjungan->kode_kunjungan;
        return redirect()->to($url);
    }
    public function laporan_print(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode_kunjungan);
        $laporan = LaporanOperasi::firstWhere('kode_kunjungan', $request->kode_kunjungan);

        $lama_operasi = null;
        // dd($laporan->jam_operasi_mulai, $laporan->jam_operasi_selesai);
        if ($laporan->jam_operasi_mulai && $laporan->jam_operasi_selesai) {
            $start = Carbon::parse($laporan->jam_operasi_mulai);
            $end = Carbon::parse($laporan->jam_operasi_selesai);
            $diffInHours = $start->diffInHours($end); // Menghitung selisih dalam jam
            $diffInMinutes = $start->diffInMinutes($end) % 60;
            $lama_operasi = $diffInHours . " jam " . $diffInMinutes . " menit";
        }
        // return view('livewire.operasi.pdf_laporan_operasi', compact('laporan','kunjungan'));
        $pdf = Pdf::loadView('livewire.operasi.pdf_laporan_operasi', compact('laporan', 'kunjungan', 'lama_operasi'));
        return $pdf->stream('laporan_operasi.pdf');
    }
}
