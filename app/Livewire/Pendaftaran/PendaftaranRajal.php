<?php

namespace App\Livewire\Pendaftaran;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranRajal extends Component
{
    public $antrians = [];
    public $tanggalperiksa, $lantai, $loket, $jenispasien;
    public $search = '';
    public function panggilpendaftaran()
    {
        $antrian = Antrian::where('taskid', 0)
            ->where('method', 'Offline')
            ->where('lantaipendaftaran', $this->lantai)
            ->whereDate('tanggalperiksa', $this->tanggalperiksa)
            ->where('jenispasien', $this->jenispasien)
            ->first();
        if ($antrian) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 2;
            $now = Carbon::now();
            $request['waktu'] = Carbon::now()->timestamp * 1000;
            $antrian->update([
                'taskid' => 2,
                'loket' => $this->loket,
                'status_api' => 1,
                'loket' => $this->loket,
                'keterangan' => "Panggilan ke loket pendaftaran",
                'taskid2' => $now,
                'user' => 'Sistem Siramah',
            ]);
            //panggil urusan mesin antrian
            try {
                // notif wa
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
                return flash('Panggilan Berhasil', 'success');
            } catch (\Throwable $th) {
                return flash($th->getMessage(), 'danger');
            }
            $url = route('pendaftaran.rajal.proses') . "?kodebooking=" . $antrian->kodebooking . "&lantai=" . $this->lantai . "&loket=" . $this->loket;
            return redirect()->to($url);
        } else {
            return flash('Kodebooking tidak ditemukan', 'danger');
        }
    }
    public function prosespendaftaran()
    {
        $antrian = Antrian::where('taskid', 2)
            ->where('method', 'Offline')
            ->where('lantaipendaftaran', $this->lantai)
            ->whereDate('tanggalperiksa', $this->tanggalperiksa)
            ->where('jenispasien', $this->jenispasien)
            ->first();
        if ($antrian) {
            $url = route('pendaftaran.rajal.proses') . "?kodebooking=" . $antrian->kodebooking . "&lantai=" . $this->lantai . "&loket=" . $this->loket;
            return redirect()->to($url);
        } else {
            return flash('Kodebooking tidak ditemukan', 'danger');
        }
    }
    public function mount(Request $request)
    {
        $this->tanggalperiksa = $request->tanggalperiksa;
        $this->lantai = $request->lantai;
        $this->loket = $request->loket;
        $this->jenispasien = $request->jenispasien;
        $this->search = $request->search;
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        if ($this->tanggalperiksa) {
            $this->antrians = Antrian::whereDate('tanggalperiksa', $this->tanggalperiksa)
                ->where('method', 'Offline')
                ->where('jenispasien', 'LIKE', $this->jenispasien . '%')
                ->where('lantaipendaftaran',  'LIKE', '%' . $this->lantai . '%')
                // ->orderBy('taskid', 'asc')
                ->get();
        }
        return view('livewire.pendaftaran.pendaftaran-rajal')
            ->title('Pendaftaran Rawat Jalan');
    }
}
