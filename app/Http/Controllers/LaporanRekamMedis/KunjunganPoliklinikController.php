<?php

namespace App\Http\Controllers\LaporanRekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKunjunganPoli;

class KunjunganPoliklinikController extends Controller
{
    public function lapKunjunganPoli(Request $request)
    {
        // Mendapatkan tanggal mulai dan akhir dari request
        $startdate  = $request->startdate ? Carbon::parse($request->startdate) : Carbon::now()->startOfMonth();
        $enddate    = $request->enddate ? Carbon::parse($request->enddate) : Carbon::now()->endOfMonth();

        // Mengambil semua unit dengan kelas_unit 1
        $units = Unit::whereIn('kelas_unit', [1])->where('ACT', 1)->get();

        $query = Kunjungan::with('unit')
            ->whereIn('status_kunjungan', [2, 3]);

        // Periksa apakah kodeunit berbeda dari '-'
        if ($request->kodeunit != '-') {
            $query->where('kode_unit', $request->kodeunit);
        }

        $query = Kunjungan::with('unit')
        ->whereIn('status_kunjungan', [2, 3]);

    if ($request->kodeunit != '-') {
        $query->where('kode_unit', $request->kodeunit);
    }

    $startdate = Carbon::parse($request->startdate);
    $enddate = Carbon::parse($request->enddate);
    $kodeunit = $request->kodeunit??null;

    $query->whereBetween('tgl_masuk', [$startdate->format('Y-m-d'), $enddate->format('Y-m-d')])
        ->select(DB::raw('DATE(tgl_masuk) as tgl_masuk'), 'kode_unit', DB::raw('COUNT(*) as total_kunjungan'))
        ->groupBy(DB::raw('DATE(tgl_masuk)'), 'kode_unit');

    $kunjungans = $query->get();

    // Mengelompokkan data berdasarkan unit
    $data = $kunjungans->groupBy('kode_unit');

    // Mendapatkan semua tanggal dalam rentang yang dipilih
    $dates = collect();
    for ($date = $startdate->copy(); $date->lte($enddate); $date->addDay()) {
        $dates->push($date->copy());
    }

    // Format data untuk tampilan
    $formattedData = [];
    foreach ($data as $kodeUnit => $records) {
        $unitName = $records->first()->unit->nama_unit ;
        $formattedData[$unitName] = [];
        foreach ($dates as $date) {
            $formattedData[$unitName][$date->format('Y-m-d')] = 0; // Default value
        }
        foreach ($records as $record) {
            $formattedData[$unitName][$record->tgl_masuk] = $record->total_kunjungan;
        }
    }

        return view('simrs.rekammedis.lap_kunjungan_poli.kunjungan_perpoli', compact('dates','formattedData','request','kodeunit','startdate','enddate','units','kunjungans'));
    }
    public function exportKunjunganPoli(Request $request)
    {
        $startdate = Carbon::parse($request->startdate);
        $enddate = Carbon::parse($request->enddate);

        $query = Kunjungan::with('unit')
            ->whereIn('status_kunjungan', [2, 3]);

        if ($request->kodeunit != '-') {
            $query->where('kode_unit', $request->kodeunit);
        }

        $query->whereBetween('tgl_masuk', [$startdate->format('Y-m-d'), $enddate->format('Y-m-d')])
            ->select(DB::raw('DATE(tgl_masuk) as tgl_masuk'), 'kode_unit', DB::raw('COUNT(*) as total_kunjungan'))
            ->groupBy(DB::raw('DATE(tgl_masuk)'), 'kode_unit');

        $kunjungans = $query->get();
        $data = $kunjungans->groupBy('kode_unit');

        $dates = collect();
        for ($date = $startdate->copy(); $date->lte($enddate); $date->addDay()) {
            $dates->push($date->copy());
        }

        $formattedData = [];
        foreach ($data as $kodeUnit => $records) {
            $unitName = $records->first()->unit->nama_unit;
            $formattedData[$unitName] = [];
            foreach ($dates as $date) {
                $formattedData[$unitName][$date->format('Y-m-d')] = 0;
            }
            foreach ($records as $record) {
                $formattedData[$unitName][$record->tgl_masuk] = $record->total_kunjungan;
            }
        }
        return Excel::download(new LaporanKunjunganPoli($formattedData, $dates), 'laporan_kunjungan_poli.xlsx');
    }
}
