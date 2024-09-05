<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranRajalProses extends Component
{
    public $kodebooking, $tanggalperiksa, $lantai, $loket, $jenispasien;
    public $antrian;
    public function panggilpendaftaran()
    {
        $antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
        if ($antrian->taskid <= 2) {
            // kirim server antrian
            try {
                $tanggal = now()->format('Y-m-d');
                $urutan = $antrian->angkaantrean;
                if ($antrian->jenispasien == 'JKN') {
                    $tipeloket = 'BPJS';
                } else {
                    $tipeloket = 'UMUM';
                }
                $mesin_antrian = DB::connection('mysql3')->table('tb_counter')
                    ->where('tgl', $tanggal)
                    ->where('kategori', $tipeloket)
                    ->where('loket', $this->loket)
                    ->where('lantai', $this->lantai)
                    ->get();
                if ($mesin_antrian->count() < 1) {
                    $mesin_antrian = DB::connection('mysql3')->table('tb_counter')->insert([
                        'tgl' => $tanggal,
                        'kategori' => $tipeloket,
                        'loket' => $this->loket,
                        'counterloket' => $urutan,
                        'lantai' => $this->lantai,
                        'mastercount' => $urutan,
                        'sound' => 'PLAY',
                    ]);
                } else {
                    DB::connection('mysql3')->table('tb_counter')
                        ->where('tgl', $tanggal)
                        ->where('kategori', $tipeloket)
                        ->where('loket', $this->loket)
                        ->where('lantai', $this->lantai)
                        ->limit(1)
                        ->update([
                            // 'counterloket' => $antrian->first()->mastercount + 1,
                            'counterloket' => $urutan,
                            // 'mastercount' => $antrian->first()->mastercount + 1,
                            'mastercount' => $urutan,
                            'sound' => 'PLAY',
                        ]);
                }
            } catch (\Throwable $th) {
                flash($antrian->nomorantrean . ' ' . $th->getMessage(), 'danger');
            }
            // update antrian
            $antrian->taskid = 2;
            $antrian->taskid2 = now();
            $antrian->sync_panggil = 0;
            $antrian->user1 = auth()->user()->id;
            $antrian->update();
            flash('Nomor antrian ' . $antrian->nomorantrean . ' dipanggil.', 'success');
            $this->dispatch('refreshPage');
        } else {
            flash('Nomor antrian ' . $antrian->nomorantrean . ' sudah mendapatkan pelayanan.', 'danger');
        }
    }
    public function panggilmute()
    {
        $antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
        if ($antrian->taskid <= 2) {
            // update antrian
            $antrian->taskid = 2;
            $antrian->taskid2 = now();
            $antrian->sync_panggil = 0;
            $antrian->user1 = auth()->user()->id;
            $antrian->update();
            flash('Nomor antrian ' . $antrian->nomorantrean . ' dipanggil.', 'success');
            $this->dispatch('refreshPage');
        } else {
            flash('Nomor antrian ' . $antrian->nomorantrean . ' sudah mendapatkan pelayanan.', 'danger');
        }
    }
    public function selesaipendaftaran(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $this->kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 3;
        $request['waktu'] = Carbon::now();
        if ($antrian->jenispasien == 'JKN') {
            $request['keterangan'] = "Silahkan menunggu dipoliklinik";
            $request['status_api'] = 1;
        } else {
            $request['keterangan'] = "Silahkan lakukan pembayaran di Loket Pembayaran, setelah itu dapat menunggu dipoliklinik";
            $request['status_api'] = 0;
        }
        // $response = $vclaim->update_antrean($request);
        // if ($response->metadata->code == 200) {
        // } else {
        //     Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
        // }
        $antrian->update([
            'taskid' => $request->taskid,
            'taskid3' => $request->waktu,
            'status_api' => $request->status_api,
            'keterangan' => $request->keterangan,
            'user' => 'Sistem Siramah',
        ]);
        // try {
        //     // notif wa
        //     $wa = new WhatsappController();
        //     $request['message'] = "Anda berhasil di daftarkan atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
        //     $request['number'] = $antrian->nohp;
        //     $wa->send_message($request);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        Alert::success('Pendaftaran Berhasil', 'Nomor Antrian ' . $antrian->nomorantrean . ' telah selesai');
        $url = route('pendaftaran.rajal') . "?tanggalperiksa=" . $antrian->tanggalperiksa . "&lantai=" . $this->lantai . "&loket=" . $this->loket . "&jenispasien=" . $antrian->jenispasien;
        return redirect()->to($url);
    }
    public function batalpendaftaran(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $this->kodebooking)->first();
        $antrian->update([
            'taskid' => 99,
            'status_api' => 0,
            'keterangan' => 'Pasien dibatalkan di pendaftaran',
            'user' => Auth::user()->id,
        ]);
        Alert::error('Pembatalan Berhasil', 'Nomor Antrian ' . $antrian->nomorantrean . ' telah dibatalkan');
        $url = route('pendaftaran.rajal') . "?tanggalperiksa=" . $antrian->tanggalperiksa . "&lantai=" . $this->lantai . "&loket=" . $this->loket . "&jenispasien=" . $antrian->jenispasien;
        return redirect()->to($url);
    }
    public function resetpendaftaran()
    {
        $antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
        // update antrian
        $antrian->taskid = 2;
        $antrian->taskid2 = now();
        $antrian->sync_panggil = 0;
        $antrian->user1 = auth()->user()->id;
        $antrian->update();
        Alert::success('Cancel Pembatalan Berhasil', 'Nomor Antrian ' . $antrian->nomorantrean . ' telah dikembalikan');
        $url = route('pendaftaran.rajal.proses') . "?kodebooking=" . $antrian->kodebooking . "&lantai=" . $this->lantai . "&loket=" . $this->loket;
        return redirect()->to($url);
    }
    public function mount(Request $request)
    {
        $this->kodebooking = $request->kodebooking;
        $this->lantai = $request->lantai;
        $this->loket = $request->loket;
        $this->antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
        $this->jenispasien = $this->antrian->jenispasien;
    }
    public function render()
    {
        return view('livewire.pendaftaran.pendaftaran-rajal-proses')
            ->title('Pendaftaran Rawat Jalan');
    }
}
