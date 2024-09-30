<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Kunjungan;

class LaporanKunjunganPoli implements FromView
{
    protected $formattedData;
    protected $dates;

    public function __construct($formattedData, $dates)
    {
        $this->formattedData = $formattedData;
        $this->dates = $dates;
    }

    public function view(): View
    {
        return view('export.laporan.lap_kunjungan_poli', [
            'formattedData' => $this->formattedData,
            'dates' => $this->dates
        ]);
    }
}
