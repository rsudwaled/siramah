<?php

namespace App\Http\Controllers;

use App\Models\OrderObatHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class FarmasiController extends APIController
{
    public function tracerOrderObat(Request $request)
    {
        $orders = null;
        if ($request->depo) {
            $orders = OrderObatHeader::with(['kunjungan','pasien','unit','asal_unit','dokter','penjamin_simrs','kunjungan.antrian'])->whereDate('tgl_entry', $request->tanggal)
                ->where('status_order', '!=', 0)
                ->where('kode_unit', $request->depo)
                ->where('unit_pengirim', '!=', '1016')
                ->get();
        }
        if ($request->depo == 4002) {
            $orders_yasmin = OrderObatHeader::with(['kunjungan','pasien','unit','asal_unit','dokter','penjamin_simrs','kunjungan.antrian'])->whereDate('tgl_entry',  $request->tanggal)
                ->where('status_order', '!=', 0)
                ->where('unit_pengirim', '1016')
                ->get();
            $orders = $orders->merge($orders_yasmin);
        }
        return view('simrs.farmasi.tracer_order_obat', compact([
            'request',
            'orders',
        ]));
    }
    public function orderFarmasi(Request $request)
    {
        // $orders = collect(DB::connection('mysql2')->select('CALL TRACER_RESEP_01 ("2023-05-15","4008")'));
        $orders = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $request->tanggal . "%")
            ->where('status_order', '!=', 0)
            ->where('kode_unit', 4008)
            ->get();
        return view('simrs.farmasi.order_farmasi', compact([
            'request',
            'orders',
        ]));
    }
    public function cetakOrderFarmasi(Request $request)
    {
        $order = OrderObatHeader::where('kode_layanan_header', $request->kode)->first();
        $i = 1;
        if ($order) {
            $no_antrian = OrderObatHeader::whereDate('updated_at', 'LIKE', now()->format('Y-m-d'))->get()->count();
            $order->update([
                'status_order' => 2,
                'updated_at' => now(),
                'no_antrian' => $no_antrian + 1,
            ]);
            // dd($order->pasien->desas);
            try {
                $connector = new WindowsPrintConnector(env('PRINTER_FARMASI'));
                $printer = new Printer($connector);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("RSUD Waled Kab. Cirebon\n");
                $printer->text("Order Resep Farmasi\n");
                // $printer->text("================================================\n");
                // $printer->setTextSize(3, 3);
                // $printer->text($no_antrian . "\n");
                // $printer->setTextSize(1, 1);
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("================================================\n");
                $printer->setEmphasis(true);
                $printer->text("No RM : " . $order->no_rm . " \n");
                $printer->text("Nama Pasien : " . $order->pasien->nama_px . " \n");
                $printer->setEmphasis(false);
                $printer->text("Tgl Lahir : " . Carbon::parse($order->pasien->tgl_lahir)->format('d M Y')  . " \n");
                $printer->text("Alamat : " . $order->pasien->desas->nama_desa_kelurahan . ', ' . $order->pasien->kecamatans->nama_kecamatan . " \n");
                $printer->text("Berat Badan : "  . " \n");
                $printer->text("Kode Layanan : " . $order->kode_layanan_header   . " \n");
                $printer->text("No SEP : " . $order->kunjungan->no_sep . " \n\n");
                $printer->text("Poliklinik : " . $order->asal_unit->nama_unit . " \n");
                $printer->text("Dokter : " . $order->dokter->nama_paramedis . " \n");
                $printer->text("SIP Dokter : " . $order->dokter->no_sip . " \n\n");

                $printer->text("================================================\n");
                $printer->text("Nama Obat @ Jumlah                 Aturan Pakai\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("================================================\n");
                foreach ($order->detail as $value) {
                    $printer->text($i++ . ". " . $value->barang->nama_barang . " @ " . $value->jumlah_layanan . " " . $value->satuan_barang . "\n");
                    // $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    $printer->text('   ' . $value->aturan_pakai . "\n\n");
                    // $printer->setJustification(Printer::JUSTIFY_LEFT);
                }
                $printer->text("================================================\n");
                $printer->text("Input By : " . $order->tgl_entry . " \n");
                $printer->text("Tgl Input : " . $order->tgl_entry . " \n");
                $printer->text("Tgl Cetak : " . now() . " \n\n");
                $printer->text("Serah terima obat \n");
                $printer->text("Nama Penerima : \n");
                $printer->text("No HP : \n");
                $printer->text("Ttd Penerima, \n");
                $printer->text("\n\n\n..............................\n");
                $printer->cut();
                $printer->close();
            } catch (\Throwable $th) {
                // throw $th;
                Alert::error($th->getMessage(), 200);
            }
            // try {
            //     $connector = new WindowsPrintConnector(env('PRINTER_FARMASI'));
            //     $printer = new Printer($connector);
            //     $printer->setJustification(Printer::JUSTIFY_CENTER);
            //     $printer->text("RSUD Waled\n");
            //     $printer->text("Antrian Resep Farmasi\n");
            //     // $printer->text("================================================\n");
            //     // $printer->setTextSize(3, 3);
            //     // $printer->text($no_antrian . "\n");
            //     // $printer->setTextSize(1, 1);
            //     // $printer->text($order->kode_layanan_header . "\n");
            //     $printer->setJustification(Printer::JUSTIFY_LEFT);
            //     $printer->text("================================================\n");
            //     $printer->setEmphasis(true);
            //     $printer->text("No RM : " . $order->no_rm . " \n");
            //     $printer->text("Pasien : " . $order->pasien->nama_px . " \n");
            //     $printer->text("No SEP : " . $order->kunjungan->no_sep . " \n\n");
            //     $printer->setEmphasis(false);
            //     $printer->text("Poliklinik : " . $order->asal_unit->nama_unit . " \n");
            //     $printer->text("Dokter : " . $order->dokter->nama_paramedis . " \n");
            //     $printer->text("Tgl Order : " . $order->tgl_entry . " \n");
            //     $printer->text("Tgl Cetak : " . now() . " \n\n");
            //     $printer->text("Silahkan tunggu resep anda sedang diproses oleh farmasi\n");
            //     $printer->cut();
            //     $printer->close();
            //     Alert::success('Success', 'Order Resep Telah Dicetak');
            // } catch (\Throwable $th) {
            //     // throw $th;
            //     Alert::error('Error', $th->getMessage());
            // }
            // Alert::success('Success', 'Berhasil Cetak Resep');
        } else {
            Alert::error('Error', 'Order Resep Tidak Ditemukan');
        }
        return redirect()->back();
    }
    public function selesaiOrderFarmasi(Request $request)
    {
        $order = OrderObatHeader::where('kode_layanan_header', $request->kode)->first();
        $i = 1;
        $order->update([
            'status_order' => 3
        ]);
        Alert::success('Success', 'Order Resep Telah Selsai');
        return redirect()->back();
    }
    public function getOrderObat(Request $request)
    {
        // $order = collect(DB::connection('mysql2')->select('CALL TRACER_RESEP_02 (25)'));
        // dd($request->all());
        if ($request->depo) {
            $order = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $request->tanggal . "%")
                ->where('status_order', 1)
                ->where('kode_unit', $request->depo)
                ->where('unit_pengirim', '!=', '1016')
                ->first();
        }
        if ($request->depo == 4002) {
            if (empty($order)) {
                $order_yasmin = OrderObatHeader::whereDate('tgl_entry',  $request->tanggal)
                    ->where('status_order', 1)
                    ->where('unit_pengirim', '1016')
                    ->first();
                $order = $order_yasmin;
            }
        }

        $i = 1;
        // dd($order->detail->first()->barang);
        if ($order) {
            $no_antrian = OrderObatHeader::whereDate('updated_at', 'LIKE', now()->format('Y-m-d'))
                ->where('kode_unit', $request->depo)
                ->get()->count();
            // dd($order->pasien->desas);
            try {
                if ($order->kode_unit == 4002) {
                    $connector = new WindowsPrintConnector(env('PRINTER_FARMASI_DP1'));
                }
                if ($order->kode_unit == 4008) {
                    $connector = new WindowsPrintConnector(env('PRINTER_FARMASI'));
                }
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
            } catch (\Throwable $th) {
                // throw $th;
                return $this->sendError($th->getMessage(),  200);
            }
            return $this->sendError('Ok', 200);
        } else {
            return $this->sendError('Tidak ada order',  200);
        }
    }
    public function cetakUlangOrderObat(Request $request)
    {

        $order = OrderObatHeader::where('kode_layanan_header', $request->kode)->first();
        $order->update([
            'status_order' => 1
        ]);
        return redirect()->back();
    }
}
