<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Pasien;
use Carbon\Carbon;

class MiningExport implements FromView,ShouldAutoSize
{
    public function view():View
    {
        $year = '2023';
        $month = '09';

        $pasienIn = Pasien::join('ts_kunjungan', 'mt_pasien.no_rm', '=', 'ts_kunjungan.no_rm')
        ->where('kode_unit', '1002')->whereYear('tgl_masuk', $year)->whereMonth('tgl_masuk', $month)->get();
        // dd($pasienIn);
        return view('export.mining.mining_pasien', compact('pasienIn'));
    }
}
