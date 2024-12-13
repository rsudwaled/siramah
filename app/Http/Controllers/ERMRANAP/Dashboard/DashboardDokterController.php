<?php

namespace App\Http\Controllers\ERMRANAP\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\BudgetControl;
use App\Models\AsesmenRanap;
use App\Models\PerkembanganPasien;
use App\Models\Kunjungan;
use App\Models\AsesmenHeader;
use App\Models\ErmRanapKonsultasiDokter;
use App\Models\AsesmenDokterRajal;

class DashboardDokterController extends Controller
{
    public function dashboardDokter(Request $request)
    {
        $kode = $request->kode;
        $kunjungan = Kunjungan::with([
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'alasan_pulang',
            'surat_kontrol',
            'groupping',
            'erm_ranap',
            'asesmen_ranap',
            'asuhan_terpadu',
            'asesmen_ranap_keperawatan',
        ])->firstWhere('kode_kunjungan', $kode);

        $riwayatKunjungan = Kunjungan::with('unit')
            ->where('no_rm', $kunjungan->no_rm)
            ->orderBy('counter', 'desc')
            ->get();
        $pasien     = $kunjungan->pasien;
        $header     = AsesmenHeader::where('kode', $kode)->first();
        $response   = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $kunjungan->no_rm . "','" . $kunjungan->counter . "','','')"));
        $grandTotal = $response->sum("GRANTOTAL_LAYANAN");

        return view('simrs.erm-ranap.dashboard.dashboard_erm_ranap_dokter_v2', compact('kunjungan','pasien','grandTotal','header','riwayatKunjungan'));
    }

    public function getPenunjangRadiologi(Request $request)
    {
        $no_rm      = $request->no_rm;
        $kodeunit   = '3003';
        $data       = [];
        
        if ($no_rm) {
            // radiologi
            $kunjungans = Kunjungan::where('no_rm', $no_rm)
                ->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
    
            foreach ($kunjungans as $kunjungan) {
                foreach ($kunjungan->layanans->where('kode_unit', $kodeunit) as $value) {
                    // Iterasi melalui layanan_details
                    foreach ($value->layanan_details as $laydet) {
                        $data[] = [
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'tgl_masuk' => $kunjungan->tgl_masuk,
                            'counter' => $kunjungan->counter,
                            'no_rm' => $kunjungan->no_rm,
                            'nama_px' => $kunjungan->pasien->nama_px,
                            'nama_unit' => $kunjungan->unit->nama_unit,
                            'header_id' => $value->id,
                            'detail_id' => $laydet->id,
                            'pemeriksaan' => $laydet->tarif_detail->tarif->NAMA_TARIF,
                        ];
                    }
                }
            }
        }
        return response()->json($data);
    }
    
}
