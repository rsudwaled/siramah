<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class LaporanSurvailansExport implements FromView, WithDrawings, ShouldAutoSize
{
    public function view():View
    {
        $from = request()->input('dari') ;
        $to = request()->input('sampai') ;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th = $p2->year;
        $periode = $p1->day."-".$p2->day." ".$p2->monthName;
        $lds = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_SURVAILANS_TERPADU_RAWAT_INAP`('$from','$to')");
        $sumLds = collect($lds);
        return view('export.laporan.lap_diag_survailans_ranap', compact('lds','sumLds','periode','th'));
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/vendor/adminlte/dist/img/rswaledico.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('C1');

        return $drawing;
    }

}
