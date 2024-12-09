<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Pasien;

class LaporanPenyakitRawatInapbyYearExport implements FromView
{
    public function view():View
    {
        $from   = request()->input('dari') ;
        $to     = request()->input('sampai') ;
        $diag   = request()->input('diagnosa');
        $lpribyYear = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_KARTU_INDEX_PENYAKIT_RAWAT_INAP_2023`('$from','$to','$diag')");
        $lpribyYear = collect($lpribyYear);
        $rm = $lpribyYear->pluck('NO_RM');
        $pasien = Pasien::whereIn('no_rm', $rm)->get()->keyBy('no_rm');
            // Langkah 5: Tambahkan NIK pasien ke dalam lpribyYear
            $lpribyYear = $lpribyYear->map(function ($item) use ($pasien) {
                $no_rm = $item->NO_RM; // Ambil NO_RM dari laporan
                if (isset($pasien[$no_rm])) {
                    // Jika data pasien dengan no_rm ditemukan, tambahkan nik dan tgl_lahir ke laporan
                    $item->NIK = $pasien[$no_rm]->nik_bpjs;
                    $item->TGL_LAHIR = $pasien[$no_rm]->tgl_lahir;
                } else {
                    // Jika pasien tidak ditemukan, NIK dan Tgl_Lahir akan kosong atau null
                    $item->NIK = null;
                    $item->TGL_LAHIR = null;
                }
                return $item;
            });
        return view('export.laporan.rawat_inap_by_years', compact('lpribyYear'));
    }
}
