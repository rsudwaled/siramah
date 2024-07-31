<?php

namespace App\Livewire\Farmasi;

use App\Models\Kunjungan;
use App\Models\OrderObatHeader;
use Carbon\Carbon;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class AntrianFarmasiRajal extends Component
{
    public $tanggal;
    public $unit;
    public $tracerstatus;
    public $playAudio;
    public $orders = [];
    // public function refreshComponent()
    // {
    //     $this->antrianresep = OrderObatHeader::where('taskid', 5)->where('status', 0)->first();
    //     if ($this->antrianresep) {
    //         $this->playAudio = true;
    //         $this->dispatch('play-audio');
    //     } else {
    //         $this->playAudio = false;
    //     }
    // }
    public function selesai($kunjungan)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $kunjungan)->first();
        $kunjungan->order_obat_header->update([
            'panggil' => 1,
        ]);
        flash('Berhasil panggil antrian', 'success');
    }
    public function refreshComponent()
    {
        if ($this->tracerstatus == "on") {
            if ($this->unit == 4008) {
                $order = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $this->tanggal . "%")
                    ->where('status_order', 1)
                    ->where('kode_unit', $this->unit)
                    ->where('unit_pengirim', '!=', '1016')
                    ->first();
                $connector = env('PRINTER_FARMASI');
            }
            if ($this->unit == 4002) {
                $order = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $this->tanggal . "%")
                    ->where('status_order', 1)
                    ->where('kode_unit', $this->unit)
                    ->where('unit_pengirim', '!=', '1016')
                    ->first();
                if (empty($order)) {
                    $order_yasmin = OrderObatHeader::whereDate('tgl_entry',  $this->tanggal)
                        ->where('status_order', 1)
                        ->where('unit_pengirim', '1016')
                        ->first();
                    $order = $order_yasmin;
                }
                $connector = "smb://192.168.2.29/EPSON TM-T82X Receipt";
            }
            $i = 1;
            if ($order) {
                $no_antrian = OrderObatHeader::whereDate('updated_at', 'LIKE', now()->format('Y-m-d'))
                    ->where('kode_unit', $this->unit)
                    ->get()->count();
                try {
                    $connector = new WindowsPrintConnector($connector);
                    $printer = new Printer($connector);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text("RSUD Waled Kab. Cirebon\n");
                    $printer->setTextSize(2, 2);
                    $printer->text("Resep Obat Farmasi\n");
                    $printer->setTextSize(1, 1);
                    $printer->text("================================================\n");
                    $printer->text($order->kode_layanan_header . "\n");
                    $printer->setTextSize(2, 2);
                    $printer->text(substr($order->kode_layanan_header, 11) . "\n");
                    $printer->setTextSize(1, 1);
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("================================================\n");
                    $printer->setEmphasis(true);
                    $printer->text("No RM : " . $order->no_rm . " \n");
                    $printer->text("Nama Pasien : " . $order->pasien->nama_px . " \n");
                    $printer->setEmphasis(false);
                    $printer->text("Tgl Lahir : " . Carbon::parse($order->pasien->tgl_lahir)->format('d M Y')  . " \n");
                    // $printer->text("Alamat : " . $order->pasien->desas->nama_desa_kelurahan . ', ' . $order->pasien->kecamatans->nama_kecamatan . " \n");
                    $printer->text("Berat Badan : "  . " \n");
                    $printer->text("Kode Layanan : " . $order->kode_layanan_header   . " \n");
                    $printer->text("Diagnosa : " . $order->kunjungan->diagx   . " \n");
                    $printer->text("No SEP : " . $order->kunjungan->no_sep . " \n\n");
                    $printer->text("Poliklinik : " . $order->asal_unit->nama_unit . " \n");
                    $printer->text("Dokter : " . $order->dokter->nama_paramedis . " \n");
                    $printer->text("SIP : " . $order->dokter->sip_dr . " \n\n");

                    $printer->text("================================================\n");
                    $printer->text("Nama Obat @ Jumlah                 Aturan Pakai\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("================================================\n");
                    foreach ($order->detail as $value) {
                        $printer->text($i++ . ". " . $value->kode_barang . " @ " . $value->jumlah_layanan . " " . $value->satuan_barang . "\n");
                        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
                        $printer->text('   ' . $value->aturan_pakai . "\n\n");
                        // $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }
                    // $printer->text($order->detail->first()->keterangan . " \n");
                    $printer->text("================================================\n");
                    $printer->text("Tgl Input : " . $order->tgl_entry . " \n");
                    $printer->text("Tgl Cetak : " . now() . " \n\n");
                    $printer->text("Serah terima obat \n");
                    $printer->text("Nama Penerima : \n");
                    $printer->text("No HP : \n");
                    $printer->text("Ttd Penerima, \n");
                    $printer->text("\n\n\n..............................\n");
                    $printer->cut();
                    $printer->close();
                    $order->update([
                        'status_order' => 2,
                        'updated_at' => now(),
                        'no_antrian' => $no_antrian + 1,
                    ]);
                    $this->playAudio = true;
                    $this->dispatch('play-audio');
                } catch (\Throwable $th) {
                    flash($th->getMessage(), 'danger');
                }
                flash('Berhasil Cetak Resep ' . $order->kode_layanan_header, 'success');
            } else {
                // return $this->sendError('Tidak ada order',  200);
            }
        } else {
        }
    }
    public function render()
    {
        try {
            if ($this->tanggal && $this->unit) {
                $ordersx = OrderObatHeader::with(['kunjungan', 'pasien', 'unit', 'asal_unit', 'dokter', 'penjamin_simrs', 'kunjungan.antrian'])
                    ->whereDate('tgl_entry', $this->tanggal)
                    ->where('status_order', '!=', 0)
                    ->where('status_order', '!=', 99)
                    ->where('kode_unit', $this->unit)
                    ->where('unit_pengirim', '!=', '1016')
                    ->get();
                $this->orders = $ordersx;
            }
            if ($this->tanggal && $this->unit == 4002) {
                $orders_yasmin = OrderObatHeader::with(['kunjungan', 'pasien', 'unit', 'asal_unit', 'dokter', 'penjamin_simrs', 'kunjungan.antrian'])
                    ->whereDate('tgl_entry',  $this->tanggal)
                    ->where('status_order', '!=', 0)
                    ->where('status_order', '!=', 99)
                    ->where('unit_pengirim', '1016')
                    ->get();
                $ordersx = $ordersx->merge($orders_yasmin);
                $this->orders = $ordersx;
            }
        } catch (\Throwable $th) {
            flash($th->getMessage(), 'danger');
        }
        return view('livewire.farmasi.antrian-farmasi-rajal')->title('Antrian Farmasi Rawat Jalan');
    }
}
