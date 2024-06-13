<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;

class ThermalPrintController extends Controller
{
    public function cekThermalPrinter(Request $request)
    {
        if (empty($request->printer_connector)) {
            $request['printer_connector'] = "EPSON TM-T82X Receipt";
        }
        return view('admin.thermal_printer', compact([
            'request',
        ]));
    }
    public function cekPrinter(Request $request)
    {
        Log::notice('Test Printer ip : ' . $request->ip());
        if ($request->ip() == "192.168.2.133") {
            $printer = env('PRINTER_CHECKIN');
        } else if ($request->ip() == "192.168.2.51") {
            $printer = env('PRINTER_CHECKIN2');
        } else if ($request->ip() == "192.168.2.232") {
            $printer = env('PRINTER_CHECKIN3');
        } else {
            $printer = env('PRINTER_CHECKIN_MJKN');
        }
        // try {
        $connector = new WindowsPrintConnector($printer);
        $printer = new Printer($connector);
        $printer->text("Connector Printer :\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->text("Test Printer Berhasil.\n");
        $printer->cut();
        $printer->close();
        Alert::success('Success', 'Mesin menyala dan siap digunakan.');
        return redirect()->route('antrianConsole');
        // } catch (\Throwable $th) {
        //     // throw $th;
        //     Alert::error('Error', 'Mesin antrian tidak menyala. Silahkan hubungi admin.');
        //     return redirect()->route('antrianConsole');
        // }
    }
}
