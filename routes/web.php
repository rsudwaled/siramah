<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\FileRekamMedisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\JadwalOperasiController;
use App\Http\Controllers\KPOController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ParamedisController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\ThermalPrintController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use App\Http\Livewire\Users;
use App\Models\JadwalDokter;
use App\Models\Pasien;
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
// route default
Route::get('', [HomeController::class, 'landingpage'])->name('landingpage'); #ok
Auth::routes(); #ok
Route::get('verifikasi_akun', [VerificationController::class, 'verifikasi_akun'])->name('verifikasi_akun');
Route::post('verifikasi_kirim', [VerificationController::class, 'verifikasi_kirim'])->name('verifikasi_kirim');
Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
Route::get('delet_verifikasi', [UserController::class, 'delet_verifikasi'])->name('delet_verifikasi');
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google'); #redirect google login
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback'); #callback google login
// layanan umum
Route::get('bukutamu', [BukuTamuController::class, 'bukutamu'])->name('bukutamu');
Route::post('bukutamu', [BukuTamuController::class, 'store'])->name('bukutamu_store');
Route::post('printerlabel', [ThermalPrintController::class, 'printerlabel'])->name('printerlabel');
Route::get('suratkontrol_print', [SuratKontrolController::class, 'print'])->name('suratkontrol_print');

// daftar online
// Route::get('daftarOnline', [AntrianController::class, 'daftarOnline'])->name('daftarOnline');
// Route::get('checkAntrian', [AntrianController::class, 'checkAntrian'])->name('checkAntrian');
// Route::get('batalPendaftaran', [AntrianController::class, 'batalPendaftaran'])->name('batalPendaftaran');

// mesin antrian
Route::get('antrianConsole', [AntrianController::class, 'antrianConsole'])->name('antrianConsole');
Route::get('checkinAntrian', [AntrianController::class, 'checkinAntrian'])->name('checkinAntrian');
Route::get('checkinCetakSEP', [AntrianController::class, 'checkinCetakSEP'])->name('checkinCetakSEP');
Route::get('checkinKarcisAntrian', [AntrianController::class, 'checkinKarcisAntrian'])->name('checkinKarcisAntrian');


Route::get('jadwaldokterPoli', [JadwalDokterController::class, 'jadwaldokterPoli'])->name('jadwaldokterPoli');
Route::get('daftarBpjsOffline', [AntrianController::class, 'daftarBpjsOffline'])->name('daftarBpjsOffline');
Route::get('daftarUmumOffline', [AntrianController::class, 'daftarUmumOffline'])->name('daftarUmumOffline');
Route::get('cekPrinter', [AntrianController::class, 'cekPrinter'])->name('cekPrinter');
Route::get('checkinUpdate', [AntrianController::class, 'checkinUpdate'])->name('checkinUpdate');

Route::get('home', [HomeController::class, 'index'])->name('home'); #ok
Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile'); #ok
    // settingan umum
    Route::get('get_city', [LaravotLocationController::class, 'get_city'])->name('get_city');
    Route::get('get_district', [LaravotLocationController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [LaravotLocationController::class, 'get_village'])->name('get_village');
    Route::get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
    Route::get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
    Route::get('testThermalPrinter', [ThermalPrintController::class, 'testThermalPrinter'])->name('testThermalPrinter');
    Route::get('whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
    // route resource
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('paramedis', ParamedisController::class);
    Route::resource('jadwaldokter', JadwalDokterController::class);
    Route::resource('jadwaloperasi', JadwalOperasiController::class);
    Route::resource('suratmasuk', SuratMasukController::class);
    Route::resource('suratlampiran', SuratLampiranController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('efilerm', FileRekamMedisController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('kpo', KPOController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('vclaim', VclaimController::class);

    // pendaftaran
    Route::get('antrianPendaftaran', [AntrianController::class, 'antrianPendaftaran'])->name('antrianPendaftaran');
    Route::get('jadwalDokterAntrian', [JadwalDokterController::class, 'index'])->name('jadwalDokterAntrian');
    Route::post('daftarBridgingAntrian', [AntrianController::class, 'daftarBridgingAntrian'])->name('daftarBridgingAntrian');
    Route::get('selanjutnyaPendaftaran/{loket}/{lantai}/{jenispasien}/{tanggal}', [AntrianController::class, 'selanjutnyaPendaftaran'])->name('selanjutnyaPendaftaran');
    Route::get('panggilPendaftaran/{kodebooking}/{loket}/{lantai}', [AntrianController::class, 'panggilPendaftaran'])->name('panggilPendaftaran');
    Route::get('selesaiPendaftaran', [AntrianController::class, 'selesaiPendaftaran'])->name('selesaiPendaftaran');
    Route::get('antrianCapaian', [AntrianController::class, 'antrianCapaian'])->name('antrianCapaian');
    // poliklinik
    Route::get('antrianPoliklinik', [AntrianController::class, 'antrianPoliklinik'])->name('antrianPoliklinik');
    Route::get('batalAntrian', [AntrianController::class, 'batalAntrian'])->name('batalAntrian');
    Route::get('panggilPoliklinik', [AntrianController::class, 'panggilPoliklinik'])->name('panggilPoliklinik');
    Route::get('panggilUlangPoliklinik', [AntrianController::class, 'panggilUlangPoliklinik'])->name('panggilUlangPoliklinik');
    Route::get('lanjutFarmasi', [AntrianController::class, 'lanjutFarmasi'])->name('lanjutFarmasi');
    Route::get('lanjutFarmasiRacikan', [AntrianController::class, 'lanjutFarmasiRacikan'])->name('lanjutFarmasiRacikan');
    Route::get('selesaiPoliklinik', [AntrianController::class, 'selesaiPoliklinik'])->name('selesaiPoliklinik');
    Route::get('kunjunganPoliklinik', [AntrianController::class, 'kunjunganPoliklinik'])->name('kunjunganPoliklinik');
    Route::get('jadwalDokterPoliklinik', [JadwalDokterController::class, 'jadwalDokterPoliklinik'])->name('jadwalDokterPoliklinik');
    Route::get('pasienPoliklinik', [PasienController::class, 'index'])->name('pasienPoliklinik');
    Route::get('laporanAntrianPoliklinik', [AntrianController::class, 'laporanAntrianPoliklinik'])->name('laporanAntrianPoliklinik');
    Route::get('laporanKunjunganPoliklinik', [KunjunganController::class, 'laporanKunjunganPoliklinik'])->name('laporanKunjunganPoliklinik');
    Route::get('dashboardTanggalAntrianPoliklinik', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrianPoliklinik');
    Route::get('dashboardBulanAntrianPoliklinik', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrianPoliklinik');
    Route::get('suratKontrolPrint/{suratkontrol}', [SuratKontrolController::class, 'suratKontrolPrint'])->name('suratKontrolPrint');
    // farmasi
    Route::get('antrianFarmasi', [AntrianController::class, 'antrianFarmasi'])->name('antrianFarmasi');
    Route::get('getAntrianFarmasi', [AntrianController::class, 'getAntrianFarmasi'])->name('getAntrianFarmasi');
    Route::get('racikFarmasi/{kodebooking}', [AntrianController::class, 'racikFarmasi'])->name('racikFarmasi');
    Route::get('selesaiFarmasi/{kodebooking}', [AntrianController::class, 'selesaiFarmasi'])->name('selesaiFarmasi');
    Route::get('tracerOrderObat', [FarmasiController::class, 'tracerOrderObat'])->name('tracerOrderObat');
    Route::get('orderFarmasi', [FarmasiController::class, 'orderFarmasi'])->name('orderFarmasi');
    Route::get('cetakOrderFarmasi', [FarmasiController::class, 'cetakOrderFarmasi'])->name('cetakOrderFarmasi');
    Route::get('selesaiOrderFarmasi', [FarmasiController::class, 'selesaiOrderFarmasi'])->name('selesaiOrderFarmasi');

    Route::get('getOrderObat', [FarmasiController::class, 'getOrderObat'])->name('getOrderObat');
    Route::get('cetakUlangOrderObat', [FarmasiController::class, 'cetakUlangOrderObat'])->name('cetakUlangOrderObat');
    Route::get('kpo/tanggal/{tanggal}', [KPOController::class, 'kunjungan_tanggal'])->name('kpo.kunjungan_tanggal');
    // antrian bpjs
    Route::get('statusAntrianBpjs', [AntrianController::class, 'statusAntrianBpjs'])->name('statusAntrianBpjs');
    Route::get('poliklikAntrianBpjs', [PoliklinikController::class, 'poliklikAntrianBpjs'])->name('poliklikAntrianBpjs');
    Route::get('dokterAntrianBpjs', [DokterController::class, 'dokterAntrianBpjs'])->name('dokterAntrianBpjs');
    Route::get('jadwalDokterAntrianBpjs', [JadwalDokterController::class, 'jadwalDokterAntrianBpjs'])->name('jadwalDokterAntrianBpjs');
    Route::get('fingerprintPeserta', [PasienController::class, 'fingerprintPeserta'])->name('fingerprintPeserta');
    Route::get('antrianBpjsConsole', [AntrianController::class, 'antrianConsole'])->name('antrianBpjsConsole');
    Route::get('antrianBpjs', [AntrianController::class, 'antrianBpjs'])->name('antrianBpjs');
    Route::get('listTaskID', [AntrianController::class, 'listTaskID'])->name('listTaskID');
    Route::get('dashboardTanggalAntrian', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrian');
    Route::get('dashboardBulanAntrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrian');
    Route::get('jadwalOperasi', [JadwalOperasiController::class, 'jadwalOperasi'])->name('jadwalOperasi');
    Route::get('antrianPerTanggal', [AntrianController::class, 'antrianPerTanggal'])->name('antrianPerTanggal');
    Route::get('antrianPerKodebooking', [AntrianController::class, 'antrianPerKodebooking'])->name('antrianPerKodebooking');
    Route::get('antrianBelumDilayani', [AntrianController::class, 'antrianBelumDilayani'])->name('antrianBelumDilayani');
    Route::get('antrianPerDokter', [AntrianController::class, 'antrianPerDokter'])->name('antrianPerDokter');
    // vclaim bpjs
    Route::get('monitoringDataKunjungan', [VclaimController::class, 'monitoringDataKunjungan'])->name('monitoringDataKunjungan');
    Route::get('monitoringDataKlaim', [VclaimController::class, 'monitoringDataKlaim'])->name('monitoringDataKlaim');
    Route::get('monitoringPelayananPeserta', [VclaimController::class, 'monitoringPelayananPeserta'])->name('monitoringPelayananPeserta');
    Route::get('monitoringKlaimJasaraharja', [VclaimController::class, 'monitoringKlaimJasaraharja'])->name('monitoringKlaimJasaraharja');
    Route::get('referensiVclaim', [VclaimController::class, 'referensiVclaim'])->name('referensiVclaim');
    Route::get('suratKontrolBpjs', [SuratKontrolController::class, 'suratKontrolBpjs'])->name('suratKontrolBpjs');
    Route::get('rujukanBpjs', [RujukanController::class, 'rujukanBpjs'])->name('rujukanBpjs');
});
