<?php

namespace App\Http\Controllers\Casemix;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ErmRanapPengajuanPembukaanFormResume;
use App\Models\ErmRanapResumeDiagSekunder;
use App\Models\ErmRanapResumeTindakanOperasiCode;
use App\Models\ErmRanapResumeTindakanProsedureCode;
use App\Models\Kunjungan;
use App\Models\Unit;
use App\Models\ErmRanapResume;
use Illuminate\Support\Facades\Log;

class DataResumePemulanganController extends Controller
{
    public function resumePemulangan(Request $request)
    {
        $searchSep = $request->cari_sep??null;
        $query = Kunjungan::query()->with(['pasien', 'resume', 'alasan_pulang', 'penjamin_simrs']);

        if($searchSep)
        {
            $query->where('no_sep', $request->cari_sep)->where('status_kunjungan', 2)->whereNotNull('tgl_keluar');
        }
        else{

            // Filter berdasarkan ruangan jika ada
            if($request->ruangan==='all')
            {
                $query->where('kode_unit', 'like', '%20%');
            }else{
                $query->where('kode_unit', $request->ruangan);
            }

            // Filter berdasarkan rentang tanggal jika ada
            if ($request->tgl_awal && $request->tgl_akhir) {
                // Menggunakan Carbon untuk memformat tanggal dengan waktu mulai dari 00:00:00 sampai 23:59:59
                $tglAwal = \Carbon\Carbon::parse($request->tgl_awal)->startOfDay();
                $tglAkhir = \Carbon\Carbon::parse($request->tgl_akhir)->endOfDay();

                $query->whereBetween('tgl_keluar', [$tglAwal, $tglAkhir]);
            }

            // Jika tidak ada filter tanggal dan ruangan, ambil data yang relevan berdasarkan tanggal sekarang
            if (!$request->ruangan && !$request->tgl_awal && !$request->tgl_akhir) {
                $query->whereBetween('tgl_keluar', [now(), now()]);
            }

        }

        // Eksekusi query
        $kunjungan = $query->where('status_kunjungan', 2)->get();


        $unit = Unit::where('kelas_unit', 2)->whereNotIn('kode_unit',['2021'])->where('act', 1)->orderBy('nama_unit','asc')->get();
        return view('simrs.casemix.resume_pemulangan.index', compact('kunjungan','unit','request','searchSep'));
    }
    public function verifyResume(Request $request)
    {

       $request->validate([
        'kode_kunjungan' => 'required',
        ]);
        try {
            // Ambil data kunjungan berdasarkan kode kunjungan
            $kunjungan = ErmRanapResume::where('kode_kunjungan', $request->kode_kunjungan)->first();

            if (!$kunjungan) {
                return response()->json(['message' => 'Kunjungan tidak ditemukan.'], 404);
            }

            $finalResume = ErmRanapResume::where('kode_kunjungan', $request->kode_kunjungan)->first();
            $finalResume->status_resume = 1;
            $finalResume->verify_resume = 1;
            $finalResume->user_verify   = Auth::user()->username;
            $finalResume->save();
            // Mengembalikan response sukses
            return response()->json([
                'message' => 'Verifikasi berhasil dilakukan.',
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error saat verifikasi resume: ".$e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat melakukan verifikasi. Silakan coba lagi.',
                'status' => 'error'
            ], 500);
        }
    }

    public function coderView(Request $request, $kode)
    {
        $resume = ErmRanapResume::where('kode_kunjungan', $kode)->first();
        return view('simrs.casemix.resume_pemulangan.coder_diagnosa', compact('resume'));
    }

    public function coderStoreDiagnosa(Request $request)
    {

        $id_resume          = $request->id_resume;
        $kode               = $request->kode;
        $rm                 = $request->rm;
        $kunjungan_counter  = $request->kunjungan_counter;

        $diagnosaSekunder   = $request->diagnosa_sekunder;
        $tindakanOperasi    = $request->tindakan_operasi;
        $tindakanProsedure  = $request->tindakan_prosedure;

        $resume = ErmRanapResume::where('kode_kunjungan', $kode)->first();
        $resume->diagnosa_utama = $request->diagnosa_utama_casemix??'';
        $resume->save();
        if (is_array($diagnosaSekunder) && count($diagnosaSekunder) > 0)
        {
            foreach ($diagnosaSekunder as $diagnosa) {
                $parts = explode(" - ", $diagnosa);
                if (count($parts) == 2) {
                    $kodeDiagnosa = $parts[0]; // Bagian pertama adalah kode (misal: D64)
                    $keterangan = $parts[1]; // Bagian kedua adalah keterangan (misal: Other anaemias)
                    ErmRanapResumeDiagSekunder::updateOrCreate(
                        [
                            'kunjungan_counter' => $kunjungan_counter,
                            'id_resume'         => $id_resume, // ID resume
                            'kode_diagnosa'     => $kodeDiagnosa, // Kode diagnosa
                        ],
                        [
                            'id_resume'         => $id_resume, // Nomor rekam medis
                            'kode'              => $kode, // Nomor rekam medis
                            'rm'                => $rm, // Nomor rekam medis
                            'kunjungan_counter' => $kunjungan_counter, // Kunjungan counter
                            'kode_diagnosa'     => $kodeDiagnosa, // Kode diagnosa
                            'diagnosa'          => $keterangan, // Keterangan diagnosa
                            'user'              => Auth::user()->username, // Username user yang melakukan tindakan
                        ]
                    );
                } else {
                    // Menangani jika format diagnosa tidak sesuai
                    \Log::warning("Format diagnosa tidak valid: " . $diagnosa);
                }
            }
        }

        if (is_array($tindakanOperasi) && count($tindakanOperasi) > 0)
        {
            foreach ($tindakanOperasi as $operasi) {
                $parts = explode(" - ", $operasi);
                if (count($parts) == 2) {
                    $kodeTindakan = $parts[0]; // Bagian pertama adalah kode (misal: D64)
                    $keterangan = $parts[1]; // Bagian kedua adalah keterangan (misal: Other anaemias)
                    ErmRanapResumeTindakanOperasiCode::updateOrCreate(
                        [
                            'kunjungan_counter' => $kunjungan_counter,
                            'id_resume'         => $id_resume, // ID resume
                            'kode_tindakan'     => $kodeTindakan, // Kode diagnosa
                        ],
                        [
                            'id_resume'         => $id_resume,
                            'kode'              => $kode,
                            'rm'                => $rm,
                            'kunjungan_counter' => $kunjungan_counter,
                            'kode_tindakan'     => $kodeTindakan,
                            'nama_tindakan'     => $keterangan,
                            'user'              => Auth::user()->username,
                        ]
                    );
                } else {
                    \Log::warning("Format diagnosa tidak valid: " . $diagnosa);
                }
            }
        }

        if (is_array($tindakanProsedure) && count($tindakanProsedure) > 0)
        {
            foreach ($tindakanProsedure as $prosedure) {
                $parts = explode(" - ", $prosedure);
                if (count($parts) == 2) {
                    $kodeProsedure = $parts[0]; // Bagian pertama adalah kode (misal: D64)
                    $keterangan = $parts[1]; // Bagian kedua adalah keterangan (misal: Other anaemias)
                    ErmRanapResumeTindakanProsedureCode::updateOrCreate(
                        [
                            'kunjungan_counter' => $kunjungan_counter,
                            'id_resume'         => $id_resume, // ID resume
                            'kode_procedure'     => $kodeProsedure, // Kode diagnosa
                        ],
                        [
                            'id_resume'         => $id_resume,
                            'kode'              => $kode,
                            'rm'                => $rm,
                            'kunjungan_counter' => $kunjungan_counter,
                            'kode_procedure'    => $kodeProsedure,
                            'nama_procedure'    => $keterangan,
                            'user'              => Auth::user()->username,
                        ]
                    );
                } else {
                    \Log::warning("Format diagnosa tidak valid: " . $diagnosa);
                }
            }
        }
        return back()->with('success', 'Data Berhasil Disimpan!.');
    }

    public function pembukaanAksesResume(Request $request)
    {
        $pengajuan = ErmRanapPengajuanPembukaanFormResume::where('status_aproval', 0)->get();
        $countPengajuan = count($pengajuan);
        return view('simrs.casemix.resume_pemulangan.data_pengajuan_pembukaan_resume', compact('pengajuan','countPengajuan'));
    }
}
