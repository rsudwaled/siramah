<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        dd($request->ip());
        try {
            $connector = new WindowsPrintConnector(env('PRINTER_CHECKIN'));
            $printer = new Printer($connector);
            $printer->text("Connector Printer :\n");
            $printer->text(env('PRINTER_CHECKIN') . "\n");
            $printer->text("Test Printer Berhasil.\n");
            $printer->cut();
            $printer->close();
            Alert::success('Success', 'Mesin menyala dan siap digunakan.');
            return redirect()->route('antrianConsole');
        } catch (\Throwable $th) {
            // throw $th;
            Alert::error('Error', 'Mesin antrian tidak menyala. Silahkan hubungi admin.');
            return redirect()->route('antrianConsole');
        }
    }
}
