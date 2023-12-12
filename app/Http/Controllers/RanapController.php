<?php

namespace App\Http\Controllers;

use App\Models\ErmRanap;
use App\Models\ErmRanapKeperawatan;
use App\Models\ErmRanapObservasi;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use RealRashid\SweetAlert\Facades\Alert;

class RanapController extends APIController
{
    public function kunjunganranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        // if ($request->tanggal) {
        //     $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
        //     $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
        //     if ($request->kodeunit == '-') {
        //         $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
        //             ->where('tgl_masuk', '<=', $request->tgl_awal)
        //             ->where('tgl_keluar', '>=', $request->tgl_akhir)
        //             ->orWhere('status_kunjungan', 1)
        //             ->whereRelation('unit', 'kelas_unit', '=', 2)
        //             ->with(['pasien', 'budget', 'unit', 'status'])
        //             ->get();
        //     } else {
        //         $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
        //             ->where('tgl_masuk', '<=', $request->tgl_awal)
        //             ->where('tgl_keluar', '>=', $request->tgl_akhir)
        //             ->orWhere('status_kunjungan', 1)
        //             ->where('kode_unit', $request->kodeunit)
        //             ->with(['pasien', 'budget', 'unit', 'status'])
        //             ->get();
        //     }
        // }
        return view('simrs.ranap.kunjungan_ranap', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function get_pasien_ranap(Request $request)
    {
        $kunjungans = null;
        if ($request->tanggal) {
            $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            if ($request->ruangan == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->whereRelation('unit', 'kelas_unit', '=', 2)
                    ->with(['pasien', 'budget', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->ruangan)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->ruangan)
                    ->with(['pasien', 'budget', 'unit', 'status'])
                    ->get();
            }
        }
        return $this->sendResponse($kunjungans);
    }
    public function pasienranapprofile(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'budget',
            'alasan_pulang',
            'surat_kontrol',
            'erm_ranap',
            'erm_ranap_keperawatan',
            // 'layanans', 'layanans.layanan_details',
            // 'layanans.layanan_details.tarif_detail',
            // 'layanans.layanan_details.tarif_detail.tarif',
            // 'layanans.layanan_details.barang',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $kunjungans = null;
        // $kunjungans = Kunjungan::where('no_rm', $kunjungan->no_rm)
        //     ->with([
        //         'unit', 'assesmen_dokter',
        //         'layanans', 'layanans.layanan_details',
        //         'layanans.layanan_details.tarif_detail',
        //         'layanans.layanan_details.tarif_detail.tarif',
        //         'layanans.layanan_details.barang',
        //         'dokter', 'assesmen_perawat'
        //     ])
        //     ->orderBy('tgl_masuk', 'desc')
        //     ->limit(10)->get();
        $biaya_rs = 0;
        // foreach ($pasien->kunjungans->where('counter', $kunjungan->counter) as $kjg) {
        //     $biaya_rs = $biaya_rs + $kjg->layanans->where('status_retur', 'OPN')->sum('total_layanan');
        // }
        return view('simrs.ranap.erm_ranap', compact([
            'kunjungan',
            'pasien',
            'biaya_rs',
        ]));
    }
    public function kunjunganranapaktif(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->kodeunit) {
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            }
        }
        return view('simrs.ranap.kunjungan_ranap_aktif', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function simpan_resume_ranap(Request $request)
    {

        $erm = ErmRanap::updateOrCreate(
            [
                'kode_kunjungan' => $request->kode_kunjungan,
                'norm' => $request->norm,
                'counter' => $request->counter,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Disimpan');
        return redirect()->back();
    }
    public function print_resume_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $erm = $kunjungan->erm_ranap;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_resume_ranap', compact([
            'kunjungan',
            'erm',
            'pasien',
        ]));
    }
    public function simpan_implementasi_evaluasi_keperawatan(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $keperawatan = ErmRanapKeperawatan::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        Alert::success('Success', 'Implementasi Evaluasi Keperawatan disimpan');
        return redirect()->back();
    }
    public function hapus_implementasi_evaluasi_keperawatan(Request $request)
    {
        $keperawatan = ErmRanapKeperawatan::find($request->id);
        if ($keperawatan->user_id == $request->user) {
            $keperawatan->delete();
            Alert::success('Success', 'Implementasi Evaluasi Keperawatan dihapus');
        }
        return redirect()->back();
    }
    public function print_implementasi_evaluasi_keperawatan(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_keperawatan;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_keperawatan', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
    public function simpan_observasi_ranap(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $observasi = ErmRanapObservasi::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        Alert::success('Success', 'Observasi Pasien disimpan');
        return redirect()->back();
    }
    public function get_observasi_ranap(Request $request)
    {
        $observasi = ErmRanapObservasi::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function hapus_obaservasi_ranap(Request $request)
    {
        $observasi = ErmRanapObservasi::find($request->id);
        if ($observasi->user_id == Auth::user()->id) {
            $observasi->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
}
