<?php

namespace App\Livewire\Pendaftaran;

use App\Http\Controllers\AntrianController;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PendaftaranRajalProses extends Component
{
    public $kodebooking, $lantai, $loket;
    public $antrian;
    public function panggilPendaftaran()
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
    public function mount(Request $request)
    {
        $this->kodebooking = $request->kodebooking;
        $this->lantai = $request->lantai;
        $this->loket = $request->loket;
        $this->antrian = Antrian::firstWhere('kodebooking', $this->kodebooking);
    }
    public function render()
    {
        return view('livewire.pendaftaran.pendaftaran-rajal-proses')
            ->title('Pendaftaran Rawat Jalan');
    }
}
