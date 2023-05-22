<?php

namespace App\Http\Controllers;

use App\Models\OrderObatHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class FarmasiController extends APIController
{
    public function tracerOrderObat(Request $request)
    {
        // $orders = collect(DB::connection('mysql2')->select('CALL TRACER_RESEP_01 ("2023-05-15","4008")'));
        $orders = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $request->tanggal . "%")
            ->where('status_order', '!=', 0)
            ->where('kode_unit', 4008)
            ->get();

        return view('simrs.farmasi.tracer_order_obat', compact([
            'request',
            'orders',
        ]));
    }
    public function getOrderObat(Request $request)
    {
        // $order = collect(DB::connection('mysql2')->select('CALL TRACER_RESEP_02 (25)'));
        // dd($request->all());
        $order = OrderObatHeader::whereDate('tgl_entry', "LIKE", "%" . $request->tanggal . "%")
            ->where('status_order', 1)
            ->where('kode_unit', 4008)
            ->first();
        $i = 1;
        // dd($order->detail->first()->barang);
        if ($order) {
            try {
                $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
                $printer = new Printer($connector);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);
                $printer->text("Order Resep Farmasi\n");
                $printer->setTextSize(2, 2);
                $printer->text($order->kode_layanan_header . "\n");
                $printer->setTextSize(1, 1);
                $printer->setEmphasis(false);
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("================================================\n");
                $printer->text("No RM : " . $order->no_rm . " \n");
                $printer->text("Pasien : " . $order->pasien->nama_px . " \n");
                $printer->text("No SEP : " . $order->kunjungan->no_sep . " \n\n");
                $printer->text("Poliklinik : " . $order->asal_unit->nama_unit . " \n");
                $printer->text("Dokter : " . $order->dokter->nama_paramedis . " \n");
                $printer->text("Tgl Order : " . $order->tgl_entry . " \n");
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
                $printer->cut();
                $printer->close();
            } catch (\Throwable $th) {
                // throw $th;
                return $this->sendError($th->getMessage(), 500);
            }

            $order->update([
                'status_order' => 2
            ]);
            return $this->sendResponse('Ok', null, 200);
        } else {
            return $this->sendResponse('Tidak ada order', null, 200);
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
