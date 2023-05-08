<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', [HomeController::class, 'landingpage'])->name('landingpage');
Auth::routes(['verify' => true]);
Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::get('verifikasi_akun', [VerificationController::class, 'verifikasi_akun'])->name('verifikasi_akun');
Route::post('verifikasi_kirim', [VerificationController::class, 'verifikasi_kirim'])->name('verifikasi_kirim');
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google'); #redirect google login
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback'); #callback google login

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('permission:admin')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
    Route::get('delet_verifikasi', [UserController::class, 'delet_verifikasi'])->name('delet_verifikasi');
});

// bpjs
Route::prefix('bpjs')->name('bpjs.')->group(function () {
    // antrian
    Route::prefix('antrian')->name('antrian.')->group(function () {
        Route::get('status', [AntrianController::class, 'statusTokenAntrian'])->name('status');
        Route::get('poli', [SIMRSPoliklinikController::class, 'poliklik_antrian_bpjs'])->name('poli');
        Route::get('dokter', [SIMRSDokterController::class, 'dokter_antrian_bpjs'])->name('dokter');
        Route::get('jadwal_dokter', [SIMRSJadwalDokterController::class, 'jadwal_dokter_bpjs'])->name('jadwal_dokter');
        Route::get('fingerprint_peserta', [PasienController::class, 'fingerprint_peserta'])->name('fingerprint_peserta');
        Route::get('antrian', [AntrianAntrianController::class, 'antrian'])->name('antrian');
        Route::get('list_task', [AntrianAntrianController::class, 'list_task'])->name('list_task');
        Route::get('dashboard_tanggal', [AntrianAntrianController::class, 'dashboard_tanggal_index'])->name('dashboard_tanggal');
        Route::get('dashboard_bulan', [AntrianAntrianController::class, 'dashboard_bulan_index'])->name('dashboard_bulan');
        Route::get('jadwal_operasi', [SIMRSJadwalOperasiController::class, 'index'])->name('jadwal_operasi');
        Route::get('antrian_per_tanggal', [SIMRSAntrianController::class, 'antrian_per_tanggal'])->name('antrian_per_tanggal');
        Route::get('antrian_per_kodebooking', [SIMRSAntrianController::class, 'antrian_per_kodebooking'])->name('antrian_per_kodebooking');
        Route::get('antrian_belum_dilayani', [SIMRSAntrianController::class, 'antrian_belum_dilayani'])->name('antrian_belum_dilayani');
        Route::get('antrian_per_dokter', [SIMRSAntrianController::class, 'antrian_per_dokter'])->name('antrian_per_dokter');
    });
    // vclaim
    Route::prefix('vclaim')->name('vclaim.')->group(function () {
        Route::get('monitoring_data_kunjungan', [MonitoringController::class, 'monitoring_data_kunjungan_index'])->name('monitoring_data_kunjungan');
        Route::get('monitoring_data_klaim', [MonitoringController::class, 'monitoring_data_klaim_index'])->name('monitoring_data_klaim');
        Route::get('monitoring_pelayanan_peserta', [MonitoringController::class, 'monitoring_pelayanan_peserta_index'])->name('monitoring_pelayanan_peserta');
        Route::get('monitoring_klaim_jasaraharja', [MonitoringController::class, 'monitoring_klaim_jasaraharja_index'])->name('monitoring_klaim_jasaraharja');
        Route::get('referensi', [VclaimVclaimController::class, 'referensi_index'])->name('referensi');
        Route::get('ref_diagnosa_api', [VclaimVclaimController::class, 'ref_diagnosa_api'])->name('ref_diagnosa_api');
        Route::get('ref_poliklinik_api', [VclaimVclaimController::class, 'ref_poliklinik_api'])->name('ref_poliklinik_api');
        Route::get('ref_faskes_api', [VclaimVclaimController::class, 'ref_faskes_api'])->name('ref_faskes_api');
        Route::get('ref_dpjp_api', [VclaimVclaimController::class, 'ref_dpjp_api'])->name('ref_dpjp_api');
        Route::get('ref_provinsi_api', [VclaimVclaimController::class, 'ref_provinsi_api'])->name('ref_provinsi_api');
        Route::get('ref_kabupaten_api', [VclaimVclaimController::class, 'ref_kabupaten_api'])->name('ref_kabupaten_api');
        Route::get('ref_kecamatan_api', [VclaimVclaimController::class, 'ref_kecamatan_api'])->name('ref_kecamatan_api');
        Route::get('surat_kontrol', [VclaimVclaimController::class, 'surat_kontrol_index'])->name('surat_kontrol');
        Route::post('surat_kontrol_store', [SuratKontrolController::class, 'store'])->name('surat_kontrol_store');
        Route::put('surat_kontrol_update', [SuratKontrolController::class, 'update'])->name('surat_kontrol_update');
        Route::delete('surat_kontrol_delete', [SuratKontrolController::class, 'destroy'])->name('surat_kontrol_delete');
    });
});
