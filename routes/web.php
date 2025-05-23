<?php

use App\Http\Controllers\AntrianController;
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
use App\Http\Controllers\SuratLampiranController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\ThermalPrintController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\LaporanPenyakitRawatJalanController;
use App\Http\Controllers\LaporanPenyakitRawatInapController;
use App\Http\Controllers\LaporanPenyakitRawatInapPenelitianController;
use App\Http\Controllers\LaporanPenyakitRawatJalanPenelitianController;
use App\Http\Controllers\LaporanDiagnosaSurvailansInapController;
use App\Http\Controllers\LaporanDiagnosaSurvailansRawatJalanController;
use App\Http\Controllers\RM\LaporanRmController;
use App\Http\Controllers\FormulirRL1Controller;
use App\Http\Controllers\FormulirRL2Controller;
use App\Http\Controllers\FormulirRL3Controller;
use App\Http\Controllers\FormulirRL4Controller;
use App\Http\Controllers\FormulirRL5Controller;
use App\Http\Controllers\CPPTController;
use App\Http\Controllers\EklaimController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\IcareController;
use App\Http\Controllers\IGD\SEP\SEPController;
use App\Http\Controllers\InacbgController;
use App\Http\Controllers\JabatanKerjaController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\KebutuhanJurusanController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatologiAnatomiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\RanapController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RM\DiagnosaPolaPenyakitController;
use App\Http\Controllers\SatuSehatController;
use App\Livewire\Antrian\AnjunganMandiriPendaftaran;
use App\Livewire\Antrian\AntrianPendaftaran;
use App\Http\Controllers\BridgingIgd\BridgingIgdController;
use App\Livewire\Antrian\DisplayAntrianKlinik;
use App\Livewire\Antrian\DisplayJadwalRajal;
use App\Livewire\Bagianumum\LaporanSuratMasuk;
use App\Livewire\Bpjs\Antrian\AntreanBelumLayani;
use App\Livewire\Bpjs\Antrian\AntreanDokter;
use App\Livewire\Bpjs\Antrian\AntreanKodebooking;
use App\Livewire\Bpjs\Antrian\AntreanTanggal;
use App\Livewire\Bpjs\Antrian\DashboardBulan;
use App\Livewire\Bpjs\Antrian\DashboardTanggal;
use App\Livewire\Bpjs\Antrian\ListTaskid;
use App\Livewire\Bpjs\Antrian\RefDokter;
use App\Livewire\Bpjs\Antrian\RefJadwalDokter;
use App\Livewire\Bpjs\Antrian\RefPesertaFingerprint;
use App\Livewire\Bpjs\Antrian\RefPoliklinik;
use App\Livewire\Bpjs\Antrian\RefPoliklinikFingerprint;
use App\Livewire\Bpjs\Vclaim\MonitoringDataKlaim;
use App\Livewire\Bpjs\Vclaim\MonitoringDataKunjungan;
use App\Livewire\Bpjs\Vclaim\MonitoringKlaimJasaRaharja;
use App\Livewire\Bpjs\Vclaim\MonitoringPelayananPeserta;
use App\Livewire\Bpjs\Vclaim\Peserta;
use App\Livewire\Bpjs\Vclaim\Referensi;
use App\Livewire\Bpjs\Vclaim\Rujukan;
use App\Livewire\Bpjs\Vclaim\RujukanKeluar;
use App\Livewire\Bpjs\Vclaim\Sep;
use App\Livewire\Bpjs\Vclaim\SuratKontrol;
use App\Livewire\Casemix\CasemixRajal;
use App\Livewire\Casemix\CasemixRajalDetail;
use App\Livewire\Farmasi\AntrianFarmasiRajal;
use App\Livewire\Farmasi\DisplayAntrianFarmasi;
use App\Livewire\Farmasi\LaporanPengadaanFarmasi;
use App\Livewire\Inacbg\PrintClaim;
use App\Livewire\Operasi\ErmOperasi;
use App\Livewire\Operasi\JadwalOperasiIndex;
use App\Livewire\Operasi\KunjunganOperasi;
use App\Livewire\Operasi\KunjunganPasienOperasi;
use App\Livewire\Operasi\LaporanPasienOperasi;
use App\Livewire\Operasi\ModalLaporanOperasi;
use App\Livewire\Operasi\ModalTindakanOperasi;
use App\Livewire\Pendaftaran\AnjunganMandiri;
use App\Livewire\Pendaftaran\AnjunganMandiriDaftar;
use App\Livewire\Pendaftaran\PendaftaranRajal;
use App\Livewire\Pendaftaran\PendaftaranRajalProses;
use App\Livewire\Pendaftaran\PendaftranRajal;
use App\Livewire\Poliklinik\AntrianPoliklinikProses;
use App\Livewire\Poliklinik\AntrianPoliklinikRajal;
use App\Livewire\Poliklinik\DashboardAntrianRajal;
use App\Livewire\Poliklinik\KunjunganPoliklinik;
use App\Livewire\Poliklinik\KunjunganPoliklinikPasien;
use App\Livewire\Poliklinik\MonitoringWaktuAntrian;
use App\Livewire\Poliklinik\MonitoringWaktuAntrianBulan;
use App\Livewire\User\ProfilIndex;
use App\Livewire\Rekammedis\MonitoringAntrianRajal;
use App\Livewire\Rekammedis\RekamMedisRajal;
use App\Livewire\Rekammedis\RekamMedisRajalDetail;
use App\Livewire\User\RolePermission;
use App\Livewire\User\UserIndex;
use App\Livewire\Wa\WhatsappIndex;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!asd
|
*/
// route default
Route::get('', [HomeController::class, 'landingpage'])->name('landingpage');
Auth::routes();
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google');
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback');
// layanan umum
Route::get('bukutamu', [BukuTamuController::class, 'bukutamu'])->name('bukutamu');
Route::post('bukutamu', [BukuTamuController::class, 'store'])->name('bukutamu_store');
// layanan umum
Route::get('jadwaloperasi_info', [JadwalOperasiController::class, 'jadwaloperasi_info'])->name('jadwaloperasi_info');
Route::get('jadwaloperasi_display', [JadwalOperasiController::class, 'jadwaloperasi_display'])->name('jadwaloperasi_display');
// anjungan antrian
Route::get('mesinantrian', [PendaftaranController::class, 'mesinantrian'])->name('mesinantrian');
Route::get('testmesinantrian', [PendaftaranController::class, 'testmesinantrian'])->name('testmesinantrian');
Route::get('ambil_antrian_offline_bpjs', [PendaftaranController::class, 'ambil_antrian_offline_bpjs'])->name('ambil_antrian_offline_bpjs');
Route::get('ambil_antrian_offline_umum', [PendaftaranController::class, 'ambil_antrian_offline_umum'])->name('ambil_antrian_offline_umum');
Route::get('print_karcis_antrian', [PendaftaranController::class, 'print_karcis_antrian'])->name('print_karcis_antrian');
// anjungan mandiri
Route::get('anjungan-mandiri', AnjunganMandiri::class)->name('anjungan.mandiri');
Route::get('anjungan-mandiri-daftar', AnjunganMandiriDaftar::class)->name('anjungan.mandiri.daftar');
Route::get('anjungan-mandiri-pendaftaran', AnjunganMandiriPendaftaran::class)->name('anjungan.mandiri.pendaftaran');
Route::get('anjungan-cetak-karcis-umum', [AnjunganMandiri::class, 'cetakKarcisUmum'])->name('anjungan.cetak.karcis.umum');
Route::get('anjungan-cetak-karcis-bpjs', [AnjunganMandiri::class, 'cetakKarcisBpjs'])->name('anjungan.cetak.karcis.bpjs');
Route::get('test-cetak-karcis', [AnjunganMandiri::class, 'testCetakKarcis'])->name('test.cetak.karcis');
Route::get('display-jadwal-rajal', DisplayJadwalRajal::class)->name('display.jadwal.rajal');
Route::get('karcis-antrian/{kodebooking}', [AnjunganMandiriDaftar::class, 'cetakUlang'])->name('karcis.antrian');
// Route::get('antrianConsole', [PendaftaranController::class, 'antrianConsole'])->name('antrianConsole');
Route::get('antrianConsole', AnjunganMandiri::class)->name('antrianConsole');
Route::get('checkinPendaftaran', [PendaftaranController::class, 'checkinPendaftaran'])->name('checkinPendaftaran');
Route::get('cetakSEPAntrian', [PendaftaranController::class, 'cetakSEPAntrian'])->name('cetakSEPAntrian');
Route::get('cetakAntrianOnline', [PendaftaranController::class, 'cetakAntrianOnline'])->name('cetakAntrianOnline');
Route::get('checkinAntrian', [PendaftaranController::class, 'checkinAntrian'])->name('checkinAntrian');
Route::get('checkinCetakSEP', [PendaftaranController::class, 'checkinCetakSEP'])->name('checkinCetakSEP');
Route::get('checkinKarcisAntrian', [PendaftaranController::class, 'checkinKarcisAntrian'])->name('checkinKarcisAntrian');
Route::get('daftarBpjsOffline', [PendaftaranController::class, 'daftarBpjsOffline'])->name('daftarBpjsOffline');
Route::get('jadwaldokterPoli', [JadwalDokterController::class, 'jadwaldokterPoli'])->name('jadwaldokterPoli');
Route::get('daftarUmumOffline', [PendaftaranController::class, 'daftarUmumOffline'])->name('daftarUmumOffline');
Route::get('cekPrinter', [ThermalPrintController::class, 'cekPrinter'])->name('cekPrinter');
Route::get('checkinUpdate', [AntrianController::class, 'checkinUpdate'])->name('checkinUpdate');
// display antrian
Route::get('displayAntrianPoliklinik', [PoliklinikController::class, 'displayAntrianPoliklinik'])->name('displayAntrianPoliklinik');
Route::get('getdisplayAntrianPoliklinik', [PoliklinikController::class, 'getdisplayAntrianPoliklinik'])->name('getdisplayAntrianPoliklinik');
Route::get('updatePanggilanDisplayAntrian', [PoliklinikController::class, 'updatePanggilanDisplayAntrian'])->name('updatePanggilanDisplayAntrian');
Route::get('displayantrianklinik/{lantai}', DisplayAntrianKlinik::class)->name('displayantrianklinik');
Route::get('displayantrianfarmasi/{lantai}', [AntrianController::class, 'displayantrianfarmasi'])->name('displayantrianfarmasi');
Route::get('displaynomorfarmasi/{lantai}', [AntrianController::class, 'displaynomorfarmasi'])->name('displaynomorfarmasi');
Route::get('panggilnomorfarmasi', [AntrianController::class, 'panggilnomorfarmasi'])->name('panggilnomorfarmasi');
// cppt
Route::get('cppt', [CPPTController::class, 'getCPPT'])->name('cppt.get');
Route::get('cppt_print', [CPPTController::class, 'getCPPTPrint'])->name('cppt-rajal-print.get');
Route::get('cppt_print_anestesi', [CPPTController::class, 'getCPPTPrintAnestesi'])->name('cppt-anestesi-print.get');
// Sep Downloader
Route::controller(App\Http\Controllers\Casemix\SepDownloaderController::class)->prefix('sep-downloader')->name('simrs.sep-downloader.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/download-all', 'downloadAll')->name('downloadAll');
    Route::get('/stream/{no_sep}/{id}', 'stream')->name('stream');
    Route::get('/download-single', 'downloadSingle')->name('downloadSingle');
    Route::get('/download/{id}', 'download')->name('download');
});
// settingan umum
// Route::get('get_city', [LaravotLocationController::class, 'get_city'])->name('get_city');
// Route::get('get_district', [LaravotLocationController::class, 'get_district'])->name('get_district');
// Route::get('get_village', [LaravotLocationController::class, 'get_village'])->name('get_village');
// auth
Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home'); #ok
    Route::get('profil', ProfilIndex::class)->name('profil');
    Route::middleware(['can:admin'])->get('user', UserIndex::class)->name('user');
    Route::middleware(['can:admin'])->get('role-permission', RolePermission::class)->name('role.permission');
    Route::middleware(['can:admin'])->get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
    Route::middleware(['can:admin'])->get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
    Route::middleware(['can:admin'])->get('testThermalPrinter', [ThermalPrintController::class, 'cekPrinter'])->name('testThermalPrinter');
    Route::middleware(['can:admin'])->get('whatsapp', WhatsappIndex::class)->name('whatsapp');

    Route::get('check-db-connection', [HomeController::class, 'checkConnection'])->name('cek-connection'); #ok
    // admin
    Route::middleware('permission:admin')->group(function () {
        Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
        Route::get('pasienexport', [UserController::class, 'pasienexport'])->name('pasienexport');
        Route::get('rekammedis/rajal', RekamMedisRajal::class)->name('rekammedis.rajal');
    });
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('paramedis', ParamedisController::class);
    Route::resource('jadwaldokter', JadwalDokterController::class);
    Route::resource('jadwaloperasi', JadwalOperasiController::class);
    Route::resource('suratmasuk', SuratMasukController::class);
    Route::get('laporan-suratmasuk', LaporanSuratMasuk::class)->name('laporan.suratmasuk');
    Route::get('laporan-suratmasuk-print', [SuratMasukController::class, 'laporansuratmasukprint'])->name('laporan.suratmasuk.print');
    Route::resource('suratlampiran', SuratLampiranController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('efilerm', FileRekamMedisController::class);
    Route::resource('scanfilerm', FileRekamMedisController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('kpo', KPOController::class);
    // Route::resource('vclaim', VclaimController::class);
    Route::prefix('inacbg')->group(function () {
        Route::get('print_claim', PrintClaim::class)->name('print_klaim');
    });
    Route::get('bpjs/antrian/refpoliklinik', RefPoliklinik::class)->name('antrian.refpoliklinik')->lazy();

    Route::prefix('satusehat')->group(function () {
        Route::get('token_generate', [SatuSehatController::class, 'token_generate'])->name('token_generate');
        Route::get('patient', [PatientController::class, 'index'])->name('patient');
        Route::get('patient_by_nik', [PatientController::class, 'patient_by_nik'])->name('patient_by_nik');
        Route::get('patient_sync', [PatientController::class, 'patient_sync'])->name('patient_sync');
        Route::get('practitioner', [PractitionerController::class, 'index'])->name('practitioner');
        Route::get('practitioner_by_nik', [PractitionerController::class, 'practitioner_by_nik'])->name('practitioner_by_nik');
        Route::get('practitioner_sync', [PractitionerController::class, 'practitioner_sync'])->name('practitioner_sync');
        Route::get('organization', [OrganizationController::class, 'index'])->name('organization');
        Route::get('organization_sync', [OrganizationController::class, 'organization_sync'])->name('organization_sync');
        Route::get('location', [LocationController::class, 'index'])->name('location');
        Route::get('location_sync', [LocationController::class, 'location_sync'])->name('location_sync');
        Route::get('encounter', [EncounterController::class, 'encounter'])->name('encounter');
        Route::get('table_kunjungan_encounter', [EncounterController::class, 'table_kunjungan_encounter'])->name('table_kunjungan_encounter');
        Route::get('encounter_sync', [EncounterController::class, 'encounter_sync'])->name('encounter_sync');
        Route::post('encounter_update', [EncounterController::class, 'encounter_update'])->name('encounter_update');
    });
    // pendaftaran
    // Route::get('antrianPendaftaran', [PendaftaranController::class, 'antrianPendaftaran'])->name('antrianPendaftaran');
    Route::get('antrianPendaftaran', PendaftaranRajal::class)->name('antrianPendaftaran');
    // Route::get('pendaftaran-rajal', [PendaftaranController::class, 'antrianPendaftaran'])->name('pendaftaran-rajal');
    Route::get('pendaftaran-rajal', PendaftaranRajal::class)->name('pendaftaran.rajal');
    Route::get('pendaftaran-rajal-proses', PendaftaranRajalProses::class)->name('pendaftaran.rajal.proses');
    Route::get('jadwalDokterAntrian', [JadwalDokterController::class, 'index'])->name('jadwalDokterAntrian');
    Route::post('daftarBridgingAntrian', [AntrianController::class, 'daftarBridgingAntrian'])->name('daftarBridgingAntrian');
    Route::get('selanjutnyaPendaftaran/{loket}/{lantai}/{jenispasien}/{tanggal}', [AntrianController::class, 'selanjutnyaPendaftaran'])->name('selanjutnyaPendaftaran');
    Route::get('panggilPendaftaran/{kodebooking}/{loket}/{lantai}', [AntrianController::class, 'panggilPendaftaran'])->name('panggilPendaftaran');
    Route::get('batalpendaftaran', [PendaftaranController::class, 'batalpendaftaran'])->name('batalpendaftaran');
    Route::get('selesaiPendaftaran', [AntrianController::class, 'selesaiPendaftaran'])->name('selesaiPendaftaran');
    Route::get('antrianCapaian', [AntrianController::class, 'antrianCapaian'])->name('antrianCapaian');
    // kasir
    Route::get('antrianKasir', [AntrianController::class, 'antrianKasir'])->name('antrianKasir');
    // poliklinik
    Route::get('antrianPoliklinik', [AntrianController::class, 'antrianPoliklinik'])->name('antrianPoliklinik');
    Route::get('kunjungan-poliklinik', KunjunganPoliklinik::class)->name('kunjungan.poliklinik');
    Route::get('kunjungan-poliklinik-pasien', KunjunganPoliklinikPasien::class)->name('kunjungan.poliklinik.pasien');
    Route::get('antrian-poliklinik-rajal', AntrianPoliklinikRajal::class)->name('antrian.poliklinik.rajal');
    Route::get('antrian-poliklinik-proses', AntrianPoliklinikProses::class)->name('antrian.poliklinik.proses');

    Route::get('monitoringAntrianRajal', [AntrianController::class, 'monitoringAntrianRajal'])->name('monitoringAntrianRajal');
    Route::get('batalAntrian', [AntrianController::class, 'batalAntrian'])->name('batalAntrian');
    Route::get('panggilPoliklinik', [AntrianController::class, 'panggilPoliklinik'])->name('panggilPoliklinik');
    Route::get('panggilUlangPoliklinik', [AntrianController::class, 'panggilUlangPoliklinik'])->name('panggilUlangPoliklinik');
    Route::get('lanjutFarmasi', [AntrianController::class, 'lanjutFarmasi'])->name('lanjutFarmasi');
    Route::get('lanjutFarmasiRacikan', [AntrianController::class, 'lanjutFarmasiRacikan'])->name('lanjutFarmasiRacikan');
    Route::get('selesaiPoliklinik', [AntrianController::class, 'selesaiPoliklinik'])->name('selesaiPoliklinik');
    Route::get('kunjunganPoliklinik', [AntrianController::class, 'kunjunganPoliklinik'])->name('kunjunganPoliklinik');
    Route::get('kunjunganrajal', [AntrianController::class, 'kunjunganrajal'])->name('kunjunganrajal');
    Route::get('ermrajal', [AntrianController::class, 'ermrajal'])->name('ermrajal');
    Route::get('icare', [IcareController::class, 'icare'])->name('icare');
    Route::get('jadwalDokterPoliklinik', [JadwalDokterController::class, 'jadwalDokterPoliklinik'])->name('jadwalDokterPoliklinik');
    Route::get('laporanAntrianPoliklinik', [AntrianController::class, 'laporanAntrianPoliklinik'])->name('laporanAntrianPoliklinik');
    Route::get('laporanKunjunganPoliklinik', [KunjunganController::class, 'laporanKunjunganPoliklinik'])->name('laporanKunjunganPoliklinik');
    Route::get('dashboardTanggalAntrianPoliklinik', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrianPoliklinik');
    Route::get('dashboardBulanAntrianPoliklinik', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrianPoliklinik');
    Route::get('suratKontrolPrint/{suratkontrol}', [SuratKontrolController::class, 'suratKontrolPrint'])->name('suratKontrolPrint');
    // operasi
    Route::get('kunjungan-pasien-operasi', KunjunganPasienOperasi::class)->name('kunjungan.pasien.operasi');
    Route::get('laporan-pasien-operasi', LaporanPasienOperasi::class)->name('laporan.pasien.operasi');
    Route::get('erm-operasi', ErmOperasi::class)->name('erm.oprasi');
    Route::get('print-laporan-operasi', [ModalLaporanOperasi::class, 'laporan_print'])->name('print.laporan.operasi');
    Route::get('print-tindakan-operasi', [ModalTindakanOperasi::class, 'tindakan_print'])->name('print.tindakan.operasi');
    Route::get('jadwal-operasi', JadwalOperasiIndex::class)->name('jadwal.oprasi');
    //  rekammedis
    Route::get('rekam-medis-rajal', RekamMedisRajal::class)->name('rekam-medis-rajal');
    Route::get('rekam-medis-rajal-detail', RekamMedisRajalDetail::class)->name('rekam-medis-rajal-detail');
    Route::get('dashboard-antrian-rajal', DashboardAntrianRajal::class)->name('dashboard.antrian.rajal');
    Route::get('monitoring-antrian-rajal', MonitoringAntrianRajal::class)->name('monitoring-antrian-rajal');
    Route::get('monitoring-waktu-antrian', MonitoringWaktuAntrian::class)->name('monitoring-waktu-antrian');
    Route::get('monitoring-waktu-antrian-bulan', MonitoringWaktuAntrianBulan::class)->name('monitoring-waktu-antrian-bulan');
    //  casemix
    Route::get('casemix-rajal', CasemixRajal::class)->name('casemix-rajal');
    Route::get('casemix-rajal-detail', CasemixRajalDetail::class)->name('casemix-rajal-detail');
    // rajal
    Route::get('resume-rajal-print', [RekamMedisController::class, 'resumerajalprint'])->name('resume-rajal-print');
    Route::get('sep-print', [RekamMedisController::class, 'seprajalprint'])->name('sep-rajal-print');
    // ranap
    Route::get('pasienRanapAktif', [RanapController::class, 'kunjunganranap'])->name('pasienRanapAktif');
    Route::get('pasienRanap', [RanapController::class, 'kunjunganranap'])->name('pasienRanap');
    Route::get('pasienRanapPasien', [RanapController::class, 'kunjunganranap'])->name('pasienRanapPasien');
    Route::get('kunjunganranapaktif', [RanapController::class, 'kunjunganranap'])->name('kunjunganranapaktif');
    // Route::post('claim_ranap_v2', [InacbgController::class, 'claim_ranap_v2'])->name('claim_ranap_v2');
    Route::post('claim_ranap_v3', [InacbgController::class, 'claim_ranap_v3'])->name('claim_ranap_v3');
    Route::get('get_diagnosis_eclaim', [InacbgController::class, 'get_diagnosis_eclaim'])->name('get_diagnosis_eclaim');
    Route::get('get_procedure_eclaim', [InacbgController::class, 'get_procedure_eclaim'])->name('get_procedure_eclaim');
    Route::post('claim_ranap', [InacbgController::class, 'claim_ranap'])->name('claim_ranap');

    Route::get('kunjunganranap', [RanapController::class, 'kunjunganranap'])->name('kunjunganranap');
    Route::get('pasienranapprofile', [RanapController::class, 'pasienranapprofile'])->name('pasienranapprofile');
    Route::get('get_rincian_biaya', [RanapController::class, 'get_rincian_biaya'])->name('get_rincian_biaya');

    Route::get('get_kunjungan_pasien', [RanapController::class, 'get_kunjungan_pasien'])->name('get_kunjungan_pasien');
    Route::get('get_hasil_laboratorium', [RanapController::class, 'get_hasil_laboratorium'])->name('get_hasil_laboratorium');
    Route::get('get_hasil_radiologi', [RanapController::class, 'get_hasil_radiologi'])->name('get_hasil_radiologi');
    Route::get('get_file_upload', [RanapController::class, 'get_file_upload'])->name('get_file_upload');
    Route::get('get_hasil_patologi', [RanapController::class, 'get_hasil_patologi'])->name('get_hasil_patologi');
    Route::get('get_surat_kontrol', [SuratKontrolController::class, 'get_surat_kontrol'])->name('get_surat_kontrol');
    Route::get('monitoring_resume_ranap', [RanapController::class, 'monitoring_resume_ranap'])->name('monitoring_resume_ranap');
    Route::get('form_resume_ranap', [RanapController::class, 'form_resume_ranap'])->name('form_resume_ranap');
    Route::get('table_resume_ranap', [RanapController::class, 'table_resume_ranap'])->name('table_resume_ranap');
    Route::get('lihat_resume_ranap', [RanapController::class, 'lihat_resume_ranap'])->name('lihat_resume_ranap');
    Route::post('ttd_dokter_resume_ranap', [RanapController::class, 'ttd_dokter_resume_ranap'])->name('ttd_dokter_resume_ranap');
    Route::post('ttd_pasien_resume_ranap', [RanapController::class, 'ttd_pasien_resume_ranap'])->name('ttd_pasien_resume_ranap');
    Route::post('simpan_resume_ranap', [RanapController::class, 'simpan_resume_ranap'])->name('simpan_resume_ranap');
    Route::get('verif_resume_ranap', [RanapController::class, 'verif_resume_ranap'])->name('verif_resume_ranap');
    Route::get('revisi_resume_ranap', [RanapController::class, 'revisi_resume_ranap'])->name('revisi_resume_ranap');
    Route::get('print_resume_ranap', [RanapController::class, 'print_resume_ranap'])->name('print_resume_ranap');
    Route::post('simpan_implementasi_evaluasi_keperawatan', [RanapController::class, 'simpan_implementasi_evaluasi_keperawatan'])->name('simpan_implementasi_evaluasi_keperawatan');
    Route::post('simpan_keperawatan_ranap', [RanapController::class, 'simpan_keperawatan_ranap'])->name('simpan_keperawatan_ranap');
    Route::get('hapus_implementasi_evaluasi_keperawatan', [RanapController::class, 'hapus_implementasi_evaluasi_keperawatan'])->name('hapus_implementasi_evaluasi_keperawatan');
    Route::post('hapus_keperawatan_ranap', [RanapController::class, 'hapus_keperawatan_ranap'])->name('hapus_keperawatan_ranap');
    Route::get('get_keperawatan_ranap', [RanapController::class, 'get_keperawatan_ranap'])->name('get_keperawatan_ranap');
    Route::get('print_implementasi_evaluasi_keperawatan', [RanapController::class, 'print_implementasi_evaluasi_keperawatan'])->name('print_implementasi_evaluasi_keperawatan');
    Route::post('simpan_observasi_ranap', [RanapController::class, 'simpan_observasi_ranap'])->name('simpan_observasi_ranap');
    Route::post('hapus_obaservasi_ranap', [RanapController::class, 'hapus_obaservasi_ranap'])->name('hapus_obaservasi_ranap');
    Route::get('get_observasi_ranap', [RanapController::class, 'get_observasi_ranap'])->name('get_observasi_ranap');
    Route::get('print_obaservasi_ranap', [RanapController::class, 'print_obaservasi_ranap'])->name('print_obaservasi_ranap');
    Route::post('simpan_perkembangan_ranap', [RanapController::class, 'simpan_perkembangan_ranap'])->name('simpan_perkembangan_ranap');
    Route::post('hapus_perkembangan_ranap', [RanapController::class, 'hapus_perkembangan_ranap'])->name('hapus_perkembangan_ranap');
    Route::post('verifikasi_soap_ranap', [RanapController::class, 'verifikasi_soap_ranap'])->name('verifikasi_soap_ranap');
    Route::get('get_perkembangan_ranap', [RanapController::class, 'get_perkembangan_ranap'])->name('get_perkembangan_ranap');
    Route::get('print_perkembangan_ranap', [RanapController::class, 'print_perkembangan_ranap'])->name('print_perkembangan_ranap');
    Route::post('simpan_mppa', [RanapController::class, 'simpan_mppa'])->name('simpan_mppa');
    Route::get('print_mppa', [RanapController::class, 'print_mppa'])->name('print_mppa');
    Route::post('simpan_mppb', [RanapController::class, 'simpan_mppb'])->name('simpan_mppb');
    Route::get('print_mppb', [RanapController::class, 'print_mppb'])->name('print_mppb');
    Route::post('simpan_asesmen_ranap_awal', [RanapController::class, 'simpan_asesmen_ranap_awal'])->name('simpan_asesmen_ranap_awal');
    Route::post('simpan_rencana_asuhan_terpadu', [RanapController::class, 'simpan_rencana_asuhan_terpadu'])->name('simpan_rencana_asuhan_terpadu');
    Route::get('print_asesmen_ranap_awal', [RanapController::class, 'print_asesmen_ranap_awal'])->name('print_asesmen_ranap_awal');
    Route::post('simpan_asesmen_ranap_keperawatan', [RanapController::class, 'simpan_asesmen_ranap_keperawatan'])->name('simpan_asesmen_ranap_keperawatan');
    Route::get('print_asesmen_ranap_keperawatan', [RanapController::class, 'print_asesmen_ranap_keperawatan'])->name('print_asesmen_ranap_keperawatan');
    // laboratorium
    Route::get('hasillaboratorium', [LaboratoriumController::class, 'hasillaboratorium'])->name('hasillaboratorium');
    // radiologi
    Route::get('hasilradiologi', [RadiologiController::class, 'hasilradiologi'])->name('hasilradiologi');
    // patologi
    Route::get('hasillabpa', [PatologiAnatomiController::class, 'hasillabpa'])->name('hasillabpa');
    // farmasi
    Route::get('antrianFarmasi', [AntrianController::class, 'antrianFarmasi'])->name('antrianFarmasi');
    Route::get('antrian-farmasi-rajal', AntrianFarmasiRajal::class)->name('antrian.farmasi.rajal');
    Route::get('laporan-pengadaan-farmasi', LaporanPengadaanFarmasi::class)->name('laporan.pengadaan.farmasi');
    Route::get('getAntrianFarmasi', [AntrianController::class, 'getAntrianFarmasi'])->name('getAntrianFarmasi');
    Route::get('racikFarmasi/{kodebooking}', [AntrianController::class, 'racikFarmasi'])->name('racikFarmasi');
    Route::get('selesaiFarmasi/{kodebooking}', [AntrianController::class, 'selesaiFarmasi'])->name('selesaiFarmasi');
    Route::get('tracerOrderObat', [FarmasiController::class, 'tracerOrderObat'])->name('tracerOrderObat');
    Route::get('orderFarmasi', [FarmasiController::class, 'orderFarmasi'])->name('orderFarmasi');
    Route::get('cetakOrderFarmasi', [FarmasiController::class, 'cetakOrderFarmasi'])->name('cetakOrderFarmasi');
    Route::get('selesaiOrderFarmasi', [FarmasiController::class, 'selesaiOrderFarmasi'])->name('selesaiOrderFarmasi');
    Route::get('getOrderObat', [FarmasiController::class, 'getOrderObat'])->name('getOrderObat');
    Route::get('getOrderResep', [FarmasiController::class, 'getOrderResep'])->name('getOrderResep');
    Route::get('cetakUlangOrderObat', [FarmasiController::class, 'cetakUlangOrderObat'])->name('cetakUlangOrderObat');
    Route::get('kpo/tanggal/{tanggal}', [KPOController::class, 'kunjungan_tanggal'])->name('kpo.kunjungan_tanggal');
    Route::get('kpoRanap', [KPOController::class, 'kpoRanap'])->name('kpoRanap');
    // casemix
    Route::get('diagnosaRawatJalan', [PoliklinikController::class, 'diagnosaRawatJalan'])->name('diagnosaRawatJalan');
    Route::get('pasienranappulang', [KunjunganController::class, 'pasienRanapPulang'])->name('pasienranappulang');
    Route::get('kunjunganpasienranap', [KunjunganController::class, 'kunjunganpasienranap'])->name('kunjunganpasienranap');
    Route::get('bukakunjungan', [KunjunganController::class, 'bukakunjungan'])->name('bukakunjungan');
    Route::get('tutupkunjungan', [KunjunganController::class, 'tutupkunjungan'])->name('tutupkunjungan');
    Route::get('laporan_eklaim_ranap', [EklaimController::class, 'laporan_eklaim_ranap'])->name('laporan_eklaim_ranap');
    Route::middleware(['can:bpjs'])->group(function () {
        Route::get('bpjs/antrian/refpoliklinik', RefPoliklinik::class)->name('antrian.refpoliklinik')->lazy();
        Route::get('bpjs/antrian/refdokter', RefDokter::class)->name('antrian.refdokter')->lazy();
        Route::get('bpjs/antrian/refjadwaldokter', RefJadwalDokter::class)->name('antrian.refjadwaldokter')->lazy();
        Route::get('bpjs/antrian/refpoliklinik-fingerprint', RefPoliklinikFingerprint::class)->name('antrian.refpoliklinik.fingerprint')->lazy();
        Route::get('bpjs/antrian/refpeserta-fingerprint', RefPesertaFingerprint::class)->name('antrian.refpeserta.fingerprint')->lazy();
        Route::get('bpjs/antrian/listtaskid', ListTaskid::class)->name('antrian.listtaskid')->lazy();
        Route::get('bpjs/antrian/dashboardtanggal', DashboardTanggal::class)->name('antrian.dashboardtanggal')->lazy();
        Route::get('bpjs/antrian/dashboardbulan', DashboardBulan::class)->name('antrian.dashboardbulan')->lazy();
        Route::get('bpjs/antrian/antreantanggal', AntreanTanggal::class)->name('antrian.antreantanggal')->lazy();
        Route::get('bpjs/antrian/antreankodebooking/{kodebooking}', AntreanKodebooking::class)->name('antrian.antreankodebooking')->lazy();
        Route::get('bpjs/antrian/antreanbelumlayani', AntreanBelumLayani::class)->name('antrian.antreanbelumlayani')->lazy();
        Route::get('bpjs/antrian/antreandokter', AntreanDokter::class)->name('antrian.antreandokter')->lazy();
    });
    Route::middleware(['can:bpjs'])->group(function () {
        Route::get('bpjs/vclaim/monitoring-data-kunjungan', MonitoringDataKunjungan::class)->name('vclaim.monitoring.datakunjungan')->lazy();
        Route::get('bpjs/vclaim/monitoring-data-klaim', MonitoringDataKlaim::class)->name('vclaim.monitoring.dataklaim')->lazy();
        Route::get('bpjs/vclaim/monitoring-pelayanan-peserta', MonitoringPelayananPeserta::class)->name('vclaim.monitoring.pelayananpeserta')->lazy();
        Route::get('bpjs/vclaim/monitoring-klaim-jasa-raharja', MonitoringKlaimJasaRaharja::class)->name('vclaim.monitoring.klaimjasaraharja')->lazy();
        Route::get('bpjs/vclaim/peserta-bpjs', Peserta::class)->name('vclaim.peserta.bpjs')->lazy();
        Route::get('bpjs/vclaim/referensi', Referensi::class)->name('vclaim.referensi')->lazy();
        Route::get('bpjs/vclaim/surat-kontrol', SuratKontrol::class)->name('vclaim.suratkontrol')->lazy();
        Route::get('bpjs/vclaim/suratkontrol_print', [SuratKontrolController::class, 'suratkontrol_print'])->name('vclaim.suratkontrol_print');
        Route::get('bpjs/vclaim/rujukan', Rujukan::class)->name('vclaim.rujukan')->lazy();
        Route::get('bpjs/vclaim/rujukan-keluar', RujukanKeluar::class)->name('vclaim.rujukan')->lazy();
        Route::get('bpjs/vclaim/sep', Sep::class)->name('vclaim.sep')->lazy();
        Route::get('bpjs/vclaim/sep_print', [SEPController::class, 'sep_print'])->name('vclaim.sep_print');
        //    rujukan-keluar
    });
    // antrian bpjs
    // Route::get('statusAntrianBpjs', [AntrianController::class, 'statusAntrianBpjs'])->name('statusAntrianBpjs');
    // Route::get('poliklikAntrianBpjs', [PoliklinikController::class, 'poliklikAntrianBpjs'])->name('poliklikAntrianBpjs');
    // Route::get('dokterAntrianBpjs', [DokterController::class, 'dokterAntrianBpjs'])->name('dokterAntrianBpjs');
    // Route::get('resetDokter', [DokterController::class, 'resetDokter'])->name('resetDokter');
    // Route::get('jadwalDokterAntrianBpjs', [JadwalDokterController::class, 'jadwalDokterAntrianBpjs'])->name('jadwalDokterAntrianBpjs');
    // Route::get('fingerprintPeserta', [PasienController::class, 'fingerprintPeserta'])->name('fingerprintPeserta');
    // Route::get('antrianBpjs', [AntrianController::class, 'antrianBpjs'])->name('antrianBpjs');
    // Route::get('listTaskID', [AntrianController::class, 'listTaskID'])->name('listTaskID');
    // Route::get('dashboardTanggalAntrian', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrian');
    // Route::get('dashboardBulanAntrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrian');
    // Route::get('jadwalOperasi', [JadwalOperasiController::class, 'jadwalOperasi'])->name('jadwalOperasi');
    // Route::get('antmonitoringPelayananPesertarianPerTanggal', [AntrianController::class, 'antrianPerTanggal'])->name('antrianPerTanggal');
    // Route::get('monitoringAntrian', [AntrianController::class, 'monitoringAntrian'])->name('monitoringAntrian');
    // Route::get('antrianPerKodebooking', [AntrianController::class, 'antrianPerKodebooking'])->name('antrianPerKodebooking');
    // Route::get('antrianBelumDilayani', [AntrianController::class, 'antrianBelumDilayani'])->name('antrianBelumDilayani');
    // Route::get('antrianPerDokter', [AntrianController::class, 'antrianPerDokter'])->name('antrianPerDokter');
    // vclaim bpjs
    // Route::get('monitoringDataKunjungan', [VclaimController::class, 'monitoringDataKunjungan'])->name('monitoringDataKunjungan');
    // Route::get('monitoringDataKlaim', [VclaimController::class, 'monitoringDataKlaim'])->name('monitoringDataKlaim');
    Route::get('monitoringPelayananPeserta', [VclaimController::class, 'monitoringPelayananPeserta'])->name('monitoringPelayananPeserta');
    // Route::get('monitoringKlaimJasaraharja', [VclaimController::class, 'monitoringKlaimJasaraharja'])->name('monitoringKlaimJasaraharja');
    // Route::get('referensiVclaim', [VclaimController::class, 'referensiVclaim'])->name('referensiVclaim');
    Route::get('ref_diagnosa_api', [VclaimController::class, 'ref_diagnosa_api'])->name('ref_diagnosa_api');
    Route::get('ref_diagnosa_api2', [VclaimController::class, 'ref_diagnosa_api2'])->name('ref_diagnosa_api2');
    Route::get('ref_poliklinik_api', [VclaimController::class, 'ref_poliklinik_api'])->name('ref_poliklinik_api');
    Route::get('ref_faskes_api', [VclaimController::class, 'ref_faskes_api'])->name('ref_faskes_api');
    Route::get('ref_dpjp_api', [VclaimController::class, 'ref_dpjp_api'])->name('ref_dpjp_api');
    Route::get('ref_provinsi_api', [VclaimController::class, 'ref_provinsi_api'])->name('ref_provinsi_api');
    Route::get('ref_kabupaten_api', [VclaimController::class, 'ref_kabupaten_api'])->name('ref_kabupaten_api');
    Route::get('ref_kecamatan_api', [VclaimController::class, 'ref_kecamatan_api'])->name('ref_kecamatan_api');
    // Route::get('suratKontrolBpjs', [SuratKontrolController::class, 'suratKontrolBpjs'])->name('suratKontrolBpjs');
    // Route::get('sep_internal', [VclaimController::class, 'sepInternal'])->name('sep_internal');
    // Route::delete('sep_internal_delete', [VclaimController::class, 'sepInternalDelete'])->name('sep_internal_delete');

    // suratkontrol
    Route::post('suratkontrol_simpan', [SuratKontrolController::class, 'suratkontrol_simpan'])->name('suratkontrol_simpan');
    Route::get('suratkontrol_edit', [SuratKontrolController::class, 'suratkontrol_edit'])->name('suratkontrol_edit');
    Route::post('suratkontrol_update', [SuratKontrolController::class, 'suratkontrol_update'])->name('suratkontrol_update');
    Route::post('suratkontrol_update_v2', [SuratKontrolController::class, 'suratkontrol_update_v2'])->name('suratkontrol_update_v2');
    Route::get('suratkontrol_delete', [SuratKontrolController::class, 'suratkontrol_delete'])->name('suratkontrol_delete');
    Route::get('suratkontrol_print', [SuratKontrolController::class, 'suratkontrol_print'])->name('suratkontrol_print');
    // sep
    Route::post('pemulangan_sep_pasien', [KunjunganController::class, 'pemulangan_sep_pasien'])->name('pemulangan_sep_pasien');
    Route::get('rujukanBpjs', [RujukanController::class, 'rujukanBpjs'])->name('rujukanBpjs');
    Route::post('update_claim', [InacbgController::class, 'update_claim'])->name('update_claim');
    // laporan penyakit rawat jalan
    Route::get('LaporanPenyakitRawatJalan', [LaporanPenyakitRawatJalanController::class, 'LaporanPenyakitRawatJalan'])->name('laporan-rawa-jalan.get');
    Route::get('LaporanPenyakitRawatJalan/Export', [LaporanPenyakitRawatJalanController::class, 'exportExcel'])->name('laporan-rawa-jalan.export');
    Route::get('LaporanPenyakitRawatJalan/Data', [LaporanPenyakitRawatJalanController::class, 'dataAjax'])->name('laporan-rawa-jalan.dataAjax');
    // penyakit rawat jalan by yaers
    Route::get('LaporanPenyakitRawatJalanbyYears', [LaporanPenyakitRawatJalanPenelitianController::class, 'LaporanPenyakitRawatJalan'])->name('laporan-rawa-jalanbyYears.get');
    Route::get('LaporanPenyakitRawatJalanbyYears/Export', [LaporanPenyakitRawatJalanPenelitianController::class, 'exportExcel'])->name('laporan-rawa-jalanbyYears.export');
    // laporan penyakit rawat Inap
    Route::get('LaporanPenyakitRawatInap', [LaporanPenyakitRawatInapController::class, 'LaporanPenyakitRawatInap'])->name('laporan-rawa-inap.get');
    Route::get('LaporanPenyakitRawatInap/Export', [LaporanPenyakitRawatInapController::class, 'exportExcel'])->name('laporan-rawa-inap.export');
    Route::get('LaporanPenyakitRawatInap/Data', [LaporanPenyakitRawatInapController::class, 'dataAjax'])->name('laporan-rawa-inap.dataAjax');
    // penyakit rawat Inap by years
    Route::get('LaporanPenyakitRawatInapbyYears', [LaporanPenyakitRawatInapPenelitianController::class, 'LaporanPenyakitRawatInap'])->name('laporan-rawa-inapByYear.get');
    Route::get('LaporanPenyakitRawatInapbyYears/Export', [LaporanPenyakitRawatInapPenelitianController::class, 'exportExcel'])->name('laporan-rawa-inapByYear.export');
    // laporan survailans rawat inap
    Route::get('LaporanDiagnosaSurvailansInap', [LaporanDiagnosaSurvailansInapController::class, 'LaporanSurvailans'])->name('laporan-survailans.get');
    Route::get('LaporanDiagnosaSurvailansInap/Export', [LaporanDiagnosaSurvailansInapController::class, 'exportExcel'])->name('laporan-survailans.export');
    // laporan survailans rawat jalan
    Route::get('LaporanDiagnosaSurvailansRawatJalan', [LaporanDiagnosaSurvailansRawatJalanController::class, 'LaporanSurvailans'])->name('laporan-survailans-rajal.get');
    Route::get('LaporanDiagnosaSurvailansRawatJalan/Export', [LaporanDiagnosaSurvailansRawatJalanController::class, 'exportExcel'])->name('laporan-survailans-rajal.export');
    // formulir RL 1
    Route::get('FormulirRL1', [FormulirRL1Controller::class, 'FormulirRL1'])->name('frl-1.get');
    Route::get('FormulirRL1_2', [FormulirRL1Controller::class, 'FormulirRL1_2'])->name('frl-1-2.get');
    Route::get('FormulirRL1_3', [FormulirRL1Controller::class, 'FormulirRL1_3'])->name('frl-1-3.get');
    // formulir RL 2
    Route::get('FormulirRL2', [FormulirRL2Controller::class, 'FormulirRL2'])->name('frl-2.get');
    // formulir RL 3
    Route::get('FormulirRL3_1', [FormulirRL3Controller::class, 'FormulirRL3_1'])->name('frl-3-1.get');
    Route::get('FormulirRL3_2', [FormulirRL3Controller::class, 'FormulirRL3_2'])->name('frl-3-2.get');
    Route::get('FormulirRL3_3', [FormulirRL3Controller::class, 'FormulirRL3_3'])->name('frl-3-3.get');
    Route::get('FormulirRL3_4', [FormulirRL3Controller::class, 'FormulirRL3_4'])->name('frl-3-4.get');
    Route::get('FormulirRL3_5', [FormulirRL3Controller::class, 'FormulirRL3_5'])->name('frl-3-5.get');
    Route::get('FormulirRL3_6', [FormulirRL3Controller::class, 'FormulirRL3_6'])->name('frl-3-6.get');
    Route::get('FormulirRL3_7', [FormulirRL3Controller::class, 'FormulirRL3_7'])->name('frl-3-7.get');
    Route::get('FormulirRL3_8', [FormulirRL3Controller::class, 'FormulirRL3_8'])->name('frl-3-8.get');
    Route::get('FormulirRL3_9', [FormulirRL3Controller::class, 'FormulirRL3_9'])->name('frl-3-9.get');
    Route::get('FormulirRL3_10', [FormulirRL3Controller::class, 'FormulirRL3_10'])->name('frl-3-10.get');
    Route::get('FormulirRL3_11', [FormulirRL3Controller::class, 'FormulirRL3_11'])->name('frl-3-11.get');
    Route::get('FormulirRL3_12', [FormulirRL3Controller::class, 'FormulirRL3_12'])->name('frl-3-12.get');
    Route::get('FormulirRL3_13', [FormulirRL3Controller::class, 'FormulirRL3_13'])->name('frl-3-13.get');
    Route::get('FormulirRL3_14', [FormulirRL3Controller::class, 'FormulirRL3_14'])->name('frl-3-14.get');
    Route::get('FormulirRL3_15', [FormulirRL3Controller::class, 'FormulirRL3_15'])->name('frl-3-15.get');
    // formulir RL 4
    Route::get('FormulirRL4-1/versi-6', [FormulirRL4Controller::class, 'FormulirRL41Versi6'])->name('frl-4-1-versi6.get');
    Route::get('FormulirRL4-2/versi-6', [FormulirRL4Controller::class, 'FormulirRL42Versi6'])->name('frl-4-2-versi6.get');
    Route::get('FormulirRL4-3/versi-6', [FormulirRL4Controller::class, 'FormulirRL43Versi6'])->name('frl-4-3-versi6.get');
    Route::get('export/FormulirRL41', [FormulirRL4Controller::class, 'FormulirRL41Export'])->name('frl-4-1.export');
    Route::get('export/FormulirRL42', [FormulirRL4Controller::class, 'FormulirRL42Export'])->name('frl-4-2.export');
    Route::get('export/FormulirRL43', [FormulirRL4Controller::class, 'FormulirRL43Export'])->name('frl-4-3.export');
    Route::get('FormulirRL4AK', [FormulirRL4Controller::class, 'FormulirRL4AK'])->name('frl-4-AK.get');
    Route::get('FormulirRL4B', [FormulirRL4Controller::class, 'FormulirRL4B'])->name('frl-4-B.get');
    Route::get('FormulirRL4BK', [FormulirRL4Controller::class, 'FormulirRL4BK'])->name('frl-4-BK.get');
    // formulir RL 5
    Route::get('FormulirRL5_1/versi-6', [FormulirRL5Controller::class, 'FormulirRL5_1Versi6'])->name('frl-5-1.get');
    Route::get('export/FormulirRL5_1', [FormulirRL5Controller::class, 'FormulirRL5_1Export'])->name('frl-5-1.export');
    Route::get('FormulirRL5_2/versi-6', [FormulirRL5Controller::class, 'FormulirRL5_2Versi6'])->name('frl-5-2.get');
    Route::get('FormulirRL5_3/versi-6', [FormulirRL5Controller::class, 'FormulirRL5_3Versi6'])->name('frl-5-3.get');
    // Route::get('FormulirRL5_3_Perunit', [FormulirRL5Controller::class, 'FormulirRL5_3Perunit'])->name('frl-53perunit.get');
    Route::post('FormulirRL5_3/DaftarPenyakitRawatInap', [FormulirRL5Controller::class, 'FormulirRL5_3P'])->name('get-rl-5-3-d');
    Route::get('FormulirRL5_4', [FormulirRL5Controller::class, 'FormulirRL5_4'])->name('frl-5_4.get');
    Route::post('FormulirRL5_4/DaftarPenyakitRawatJalan', [FormulirRL5Controller::class, 'FormulirRL5_4P'])->name('get-rl-5-4-u');
    Route::get('FormulirRL5_5', [FormulirRL5Controller::class, 'FormulirRL5_5'])->name('frl-5_5.get');
    // custom frl 5.4
    Route::get('cetakresumedokter/{rm}/{counter}/{kode_unit}', [CPPTController::class, 'getResumeDokter'])->name('resume-dokter.get');
    Route::get('getK', [CPPTController::class, 'getK'])->name('resume-dokter-k.get');
    Route::get('getC', [CPPTController::class, 'getC'])->name('resume-dokter-c.get');
    // jabatan Kerja
    Route::get('data-jabatan', [JabatanKerjaController::class, 'dataJabatan'])->name('jabatan-kepeg.get');
    Route::post('tambah-jabatan', [JabatanKerjaController::class, 'addJabatan'])->name('jabatan.add');
    Route::get('data-jabatan/{id_jabatan}/edit', [JabatanKerjaController::class, 'editJabatan'])->name('jabatan-kepeg.edit');
    Route::put('data-jabatan/{id_jabatan}/update', [JabatanKerjaController::class, 'updateJabatan'])->name('jabatan-kepeg.update');
    Route::post('tambah-bidang', [JabatanKerjaController::class, 'addBidang'])->name('bidang.add');
    Route::post('bidang-pegawai', [JabatanKerjaController::class, 'dataBidang'])->name('import-data-bidang');
    Route::get('data-bidang/{id_bidang}/edit', [JabatanKerjaController::class, 'editBidang'])->name('bidang-kepeg.edit');
    Route::put('data-bidang/{id_bidang}/update', [JabatanKerjaController::class, 'updateBidang'])->name('bidang-kepeg.update');
    // kepegawaian
    Route::get('data-pegawai', [KepegawaianController::class, 'vData'])->name('data-kepeg.get');
    Route::get('data-pegawai-add', [KepegawaianController::class, 'pegawaiAdd'])->name('data-kepeg.add');
    Route::post('data-pegawai-store', [KepegawaianController::class, 'pegawaiStore'])->name('data-kepeg.store');
    Route::post('data-pegawai/import', [KepegawaianController::class, 'importData'])->name('import-data');
    Route::get('data-pegawai/{id}/edit', [KepegawaianController::class, 'editPegawai'])->name('data-kepeg.edit');
    Route::put('data-pegawai/update/{id}', [KepegawaianController::class, 'updatePegawai'])->name('data-kepeg.update');
    Route::post('data-pegawai/set-pegawai/{id}', [KepegawaianController::class, 'setStatusPegawai'])->name('data-kepeg.setstatus');
    Route::get('pegawai-nonaktif', [KepegawaianController::class, 'pegawaiNonaktif'])->name('pegawai-nonaktif.get');
    Route::post('data-pegawai/set-pegawai-aktif/{id}', [KepegawaianController::class, 'setStatusPegawaiAktif'])->name('data-kepeg.setstatusaktif');
    Route::get('pegawai-mutasi', [KepegawaianController::class, 'pegawaiMutasi'])->name('pegawai-mutasi.get');
    Route::get('pegawai-mutasi-add', [KepegawaianController::class, 'pegawaiMutasiAdd'])->name('pegawai-mutasi.add');
    Route::post('pegawai-mutasi-store', [KepegawaianController::class, 'pegawaiMutasiStore'])->name('pegawai-mutasi.store');
    Route::post('kebutuhan-jurusan/import', [KebutuhanJurusanController::class, 'importJurusan'])->name('data-jurusan.import');
    Route::get('kebutuhan-jurusan', [KebutuhanJurusanController::class, 'kebutuhanJurusan'])->name('data-jurusan.get');
    Route::post('kebutuhan-jurusan-add', [KebutuhanJurusanController::class, 'kebutuhanJurusanAdd'])->name('data-jurusan.add');
    Route::get('kebutuhan-jurusan/{id}/edit', [KebutuhanJurusanController::class, 'editKebutuhan'])->name('data-kebutuhan.edit');
    Route::put('kebutuhan-jurusan/update/{id}', [KebutuhanJurusanController::class, 'updateKebutuhan'])->name('data-kebutuhan.update');

    // diagnosa pola penyakit
    Route::get('rawat-inap/diagnosa-pola-penyakit', [DiagnosaPolaPenyakitController::class, 'diagnosaPenyakitRawatInap'])->name('diagnosa-pola-penyakit-rawat-inap');
    Route::get('rawat-jalan/diagnosa-pola-penyakit', [DiagnosaPolaPenyakitController::class, 'diagnosaPenyakitRawatJalan'])->name('diagnosa-pola-penyakit-rawat-jalan');
    Route::get('Export/rawat-inap/diagnosa-pola-penyakit', [DiagnosaPolaPenyakitController::class, 'exportExcel'])->name('diagnosa-pola-penyakit.export');
    Route::get('Export/rawat-jalan/diagnosa-pola-penyakit', [DiagnosaPolaPenyakitController::class, 'exportExcelRajal'])->name('diagnosa-pola-penyakit-rajal.export');

    // Display Antrian
    Route::controller(App\Http\Controllers\DisplayAntrian\DisplayAntrianController::class)->prefix('display-antrian')->name('simrs.display-antrian.')->group(function () {
        Route::get('/farmasi', 'farmasi')->name('farmasi');
    });
    // Laporan Index
    Route::controller(App\Http\Controllers\LaporanIndex\LaporanIndexRMController::class)->prefix('laporan-index')->name('laporan-index.')->group(function () {
        // Laporan Index
        Route::controller(App\Http\Controllers\LaporanIndex\IndexKematianController::class)->prefix('index-operasi')->name('index_operasi.')->group(function () {
            Route::get('/', 'index')->name('index');
        });
        Route::controller(App\Http\Controllers\LaporanIndex\IndexKematianController::class)->prefix('index-kematian')->name('index_kematian.')->group(function () {
            Route::get('/', 'indexKematian')->name('index');
        });
    });

    // Laporan Index
    Route::controller(App\Http\Controllers\LaporanIndex\IndexKematianController::class)->prefix('index-operasi')->name('laporanindex.index_operasi.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // Laporan Index
    Route::controller(App\Http\Controllers\LaporanIndex\IndexDokterController::class)->prefix('index-dokter')->name('laporanindex.index_dokter.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export', 'export')->name('export');
    });

    // Start Gizi
    Route::controller(App\Http\Controllers\Gizi\GiziController::class)->prefix('gizi')->name('simrs.gizi.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{kunjungan}/{counter}/assesment', 'createAssesment')->name('create.assesment');
        // assesement
        Route::get('/get-assesment', 'getAssesment')->name('get-assesment');
        Route::post('/assesment', 'addAssesment')->name('add.assesment');

        Route::post('/assesment/store', 'storeAssesment')->name('store.assesment');
        // diagnosis gizi
        Route::post('/diagnosis/store', 'storeDiagnosis')->name('store.diagnosis');
        Route::get('/diagnosis-get', 'getDiagnosis')->name('get-diagnosis');
        // intervensi gizi
        Route::post('/intervensi/store', 'storeIntervensi')->name('store.intervensi');
        Route::get('/intervensi-get', 'getIntervensi')->name('get-intervensi');
        // monitoring dan evaluasi
        Route::post('/monev/store', 'storeMonev')->name('store.monev');
        Route::get('/monev-get', 'getMonev')->name('get-monev');
    });

    // End GIZI

    // VIEW TERBARU
    Route::get('/dashboard-igd', [App\Http\Controllers\IGD\Dashboard\DashboardController::class, 'getDataAll'])->name('dashboard-igd');

    // antrian terbaru
    Route::get('/list-antrian', [App\Http\Controllers\IGD\Antrian\AntrianController::class, 'listAntrian'])->name('list.antrian');
    Route::get('/antrian/{no}/{jp}/', [App\Http\Controllers\IGD\Antrian\AntrianController::class, 'terpilihAntrian'])->name('terpilih.antrian');

    // daftar igd
    Route::get('/daftar/form-igd/{no}/{rm}/{jp}/', [App\Http\Controllers\IGD\Daftar\DaftarIGDController::class, 'formIGD'])->name('form.daftar-igd');
    Route::post('/daftar/form-igd/store', [App\Http\Controllers\IGD\Daftar\DaftarIGDController::class, 'store'])->name('form.daftar-create');

    // daftar igk
    Route::get('/daftar/form-igk/{no}/{rm}/{jp}/', [App\Http\Controllers\IGD\Daftar\DaftarIGKController::class, 'formIGK'])->name('form.daftar-igk');
    Route::post('/daftar/form-igk/store', [App\Http\Controllers\IGD\Daftar\DaftarIGKController::class, 'store'])->name('form-igk.daftar-create');

    // daftar tanpa nomor antrian
    Route::get('/penjamin-umum', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'penjaminUmum'])->name('penjamin.umum');
    Route::get('/penjamin-bpjs', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'penjaminBPJS'])->name('penjamin.bpjs');
    Route::get('/daftar/tanpa-nomor', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'vTanpaNomor'])->name('v.tanpa-nomor');
    Route::get('/form-daftar/tanpa-nomor/{rm}', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'formDaftarTanpaNomor'])->name('form-daftar.tanpa-nomor');
    Route::post('/daftar/tanpa-nomor/store', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'daftarTanpaNomorStore'])->name('form-tanpanomor.store');
    Route::put('/update-nik-bpjs-pasien', [App\Http\Controllers\IGD\Daftar\DaftarTanpaNomorController::class, 'updateNOBPJS'])->name('update-nobpjs.pasien');

    // pasien baru
    Route::get('/bpjs-pasien-baru/create', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'createPasienBaruFromBpjsCek'])->name('pasien-baru.create_frombpjs');
    Route::get('/pasien-igd/baru', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'index'])->name('pasien-baru.create');
    Route::post('/pasien-igd/baru/store', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'pasienBaruIGD'])->name('pasien-baru.store');
    Route::get('/get-kabupaten-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getKabPasien'])->name('kab-pasien.get');
    Route::get('/get-kecamatan-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getKecPasien'])->name('kec-pasien.get');
    Route::get('/get-desa-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getDesaPasien'])->name('desa-pasien.get');
    Route::get('/get-kabupaten-keluarga-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getKlgKabPasien'])->name('klg-kab-pasien.get');
    Route::get('/get-kecamatan-keluarga-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getKlgKecPasien'])->name('klg-kec-pasien.get');
    Route::get('/get-desa-keluarga-pasien', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'getKlgDesaPasien'])->name('klg-desa-pasien.get');
    Route::get('/pasien-edit/{rm}', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'editPasien'])->name('edit-pasien');
    Route::put('/pasien-update', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'updatePasien'])->name('update-pasien.update');
    Route::get('/cek-pasien-pulang', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'cekPasien'])->name('cek-pasien-pulang');
    Route::get('export/cek-pasien-pulang', [App\Http\Controllers\IGD\Pasien\PasienIGDController::class, 'cekPasienExport'])->name('cek-pasien-pulang.export');

    // pasien bayi
    Route::get('/pasien-bayi/kunjungan-kebidanan', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'index'])->name('pasien-bayi.index');
    Route::get('/list-kunjungan/kebidanan', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'listKunjunganUGK'])->name('list-kunjungan.ugk');
    Route::get('/tambah/pasien-bayi', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'formAddBayi'])->name('pasien-baru.bayi-baru');
    Route::get('/pasien-bayi/cari-data', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'cariBayi'])->name('pasien-bayi.cari');
    Route::get('/cari-detail-bayi', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'bayiPerorangtua'])->name('detailbayi.byortu');
    Route::post('/pasien-bayi/store', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'bayiStore'])->name('pasien-bayi.store');
    Route::post('/store-bayi-baru', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'formBayiStore'])->name('pasien-bayi.store-bayi');
    Route::post('/store-bayi-kembar', [App\Http\Controllers\IGD\Daftar\PasienBayiController::class, 'bayiKembarStore'])->name('bayi-kembar.store');

    //RANAP BAYI
    Route::get('/ranap-bpjs/pasien-bayi/', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapBPJSBayi'])->name('ranap-bayi-bpjs.igk');
    Route::get('/ranap-umum/pasien-bayi', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapUMUMBayi'])->name('ranap-bayi-umum.igk');
    Route::get('/ranap-umum/pasien-bayi/ruangan', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'getBedByRuangan'])->name('get-bedruangan-bayi');
    Route::get('/bayi-daftar/rawat-inap/{rm}/{kunjungan}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'formRanapBayi'])->name('form-umum.ranap-bayi');
    Route::post('/ranap-umum/pasien-bayi/store', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapBayiStore'])->name('ranap-bayi.store');
    Route::get('/ranap-bpjs', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapBPJS'])->name('ranapbpjs');

    //  list assesment ranap
    Route::get('/list-pasien/assesment-ranap', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'listPasienRanap'])->name('list-assesment.ranap');
    Route::get('/list-pasien/form-ranap/{rm}/{kunjungan}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapUmum'])->name('form-umum.pasien-ranap');
    Route::post('/ranap-umum/pasien/store', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'pasienRanapStore'])->name('pasien-ranap-umum.store');
    Route::post('/ranap-umum/pasien/spri', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'createSPRI'])->name('pasien-ranap.createspri');
    Route::post('/ranap/spri-create', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'createSPRI'])->name('spri.create');
    Route::put('/ranap/spri-update/', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'updateSPRI'])->name('spri.update');
    Route::get('/ranap/spri-get/', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'getSPRI'])->name('spri.get');
    Route::get('/ranap/spri-check/', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'cekProsesDaftarSPRI'])->name('cekprosesdaftar.spri');
    Route::get('/get-bed-byruangan', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'getBedByRuangan'])->name('bed-ruangan.get');
    Route::get('/get-dokter-byPoli', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'getDokterByPoli'])->name('dokter-bypoli.get');

    //RANAP BRIDGING
    Route::get('/pasien-rawat-inap', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'dataPasienRanap'])->name('pasien.ranap');
    Route::get('ranap/detail-kunjungan/{kunjungan}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'detailPasienRanap'])->name('pasien-ranap.detail');
    Route::get('/ranap/pasien-bpjs/{nomorkartu}/{kode}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'daftarRanapBPJS'])->name('daftar.ranap-bpjs');
    Route::post('/ranap/pasien-bpjs/store', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'daftarRanapBPJSStore'])->name('store.ranap-bpjs');
    Route::get('bridging-steps/ranap/pasien-bpjs/{kunjungan}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'ranapCreateSEPRanap'])->name('create-sepigd.ranap-bpjs');
    Route::post('bridging/sep-igd', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'bridgingSEPIGD'])->name('bridging.sepigd');
    Route::delete('sep/delete', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'deleteSEP'])->name('sep_ranap.delete');
    Route::delete('spri/delete', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'deleteSPRI'])->name('spri_ranap.delete');

    // Bridging Bpjd dari IGD versi baru
    Route::prefix('bridging-igd')->name('bridging-igd.')->group(function () {
        Route::get('/ranap', [BridgingIgdController::class, 'listRawatInap'])->name('list-ranap');
        Route::get('/get-data-persiapan-bridging', [BridgingIgdController::class, 'getDataPersiapanBridging'])->name('get-data-persiapan-bridging');
        Route::post('/update-diagnosa', [BridgingIgdController::class, 'updateDiagKunjungan'])->name('update-diagnosa-kunjungan');
        Route::post('/create-spri', [BridgingIgdController::class, 'createSpri'])->name('create-spri');
        Route::delete('/delete-spri', [BridgingIgdController::class, 'deleteSPRI'])->name('delete-spri');
        Route::post('/create-sep-ranap', [BridgingIgdController::class, 'createSEPRanap'])->name('create-sep-ranap');
        Route::delete('/delete-sep-ranap', [BridgingIgdController::class, 'deleteSEPRanap'])->name('delete-sep-ranap');
        // synch dari kunjungan ke table histories bpjs
        Route::post('/sync/kunjungan-tohistoriesbpjs', [BridgingIgdController::class, 'sychKunjunganToHistoryBpjs'])->name('post-kunjungan-tohistories-ranap');
        Route::get('/print-sep', [BridgingIgdController::class, 'sepPrint'])->name('sep-print');

        // rawat inap erm
        Route::get('/cari-sukon', [BridgingIgdController::class, 'cariSuratKontrol'])->name('cari-sukon');
        Route::get('/get-icd10', [BridgingIgdController::class, 'getIcd10'])->name('get-icd10');
        Route::get('/get-icd9', [BridgingIgdController::class, 'getIcd9'])->name('get-icd9');
    });

    //RANAP 1 X 24 Jam
    Route::get('1x24jam/daftar-ranap', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'getRiwayatRanap'])->name('riwayat-ranap.daftar');
    Route::get('daftar-ranap/{diffInHours}/{rm}/{kode}', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'formRanap1X24Jam'])->name('riwayat-ranap.daftarkan-pasien');
    Route::post('create-ranap/1x24jam', [App\Http\Controllers\IGD\Ranap\RanapController::class, 'createRanap1X24Jam'])->name('daftar-ranap-byriwayat.simpan-pasien');

    // synch diagnosa
    Route::get('/daftar-diagnosa/synch-diagnosa-assesment', [App\Http\Controllers\IGD\DiagnosaSynch\DiagnosaSynchController::class, 'vDiagnosaAssesment'])->name('v.diagnosa');
    Route::post('/diagnosa-and-bridging/synch-diagnosa-assesment/post', [App\Http\Controllers\IGD\DiagnosaSynch\DiagnosaSynchController::class, 'synchDiagnosaAndBridging'])->name('synch.diagnosa');
    Route::post('/diagnosa-only/synch-diagnosa-assesment/post', [App\Http\Controllers\IGD\DiagnosaSynch\DiagnosaSynchController::class, 'synchDiagnosa'])->name('synch-diagnosa.only');

    // IGD Bridging SEP
    Route::post('/bridging-sep/igd', [App\Http\Controllers\IGD\SEP\SEPController::class, 'bridgingSEP'])->name('bridging-sep');
    Route::put('/update-sep/igd', [App\Http\Controllers\IGD\SEP\SEPController::class, 'updateSep'])->name('update-sep.igd');
    Route::post('/pengajuan-backdate', [App\Http\Controllers\IGD\SEP\SEPController::class, 'sepBackdate'])->name('backdate-sep');

    // Kunjungan
    Route::get('/get-kunjungan-pasien', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'RiwayatKunjunganPasien'])->name('kunjungan-pasien.get');
    Route::get('/daftar-kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'daftarKunjungan'])->name('daftar.kunjungan');
    Route::get('/detail-kunjungan/{jpdaftar}/{kunjungan}', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'detailKunjungan'])->name('detail.kunjungan');
    Route::get('/edit-kunjungan/{kunjungan}', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'editKunjungan'])->name('edit.kunjungan');
    Route::put('/update-kunjungan/{kunjungan}', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'updateKunjungan'])->name('update.kunjungan');
    Route::get('/get-kunjungan/by-user', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'getKunjunganByUser'])->name('kunjungan-byuser.get');
    Route::put('/sync-desktop-to-webapps', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'sycnDesktopToWebApps'])->name('sync-dekstop-towebapps');
    Route::get('/label/cetak', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'cetakLabel'])->name('cetak-label-igd');
    Route::get('/cetak/{sep}', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'cetakSEPPrint'])->name('cetak-sep-igd');
    Route::put('close/status-kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'tutupKunjungan'])->name('status.tutup-kunjungan');
    Route::put('open/status-kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'bukaKunjungan'])->name('status.buka-kunjungan');
    Route::get('ep/get-kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'getKunjunganEp'])->name('get-kunjungan.ep');
    Route::post('ep/update-penjamin', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'updatePenjamin'])->name('update-penjamin.ep');
    Route::post('/insert-sep/kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'insertSepKunjungan'])->name('insert-sep.kunjungan');
    Route::post('/batalkan/kunjungan', [App\Http\Controllers\IGD\Kunjungan\KunjunganController::class, 'batalKunjungan'])->name('update-batal.kunjungan');
    // Pasien Kecelakaan
    Route::get('/pasien-kecelakaan', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'index'])->name('pasien-kecelakaan.index');
    Route::get('list/pasien-kecelakaan', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'listPasienKecelakaan'])->name('pasien-kecelakaan.list');
    Route::get('detail/pasien-kecelakaan/{kunjungan}', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'detailPasienKecelakaan'])->name('pasien-kecelakaan.detail');
    Route::get('/create/pasien-kecelakaan', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'create'])->name('pasien-kecelakaan.create');
    Route::post('/store/pasien-kecelakaan-store', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'store'])->name('pasien-kecelakaan.store');
    Route::get('/buat-pasien-baru/pasien-kecelakaan', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'createPasienKec'])->name('pasien-kecelakaan.pasien-baru');
    Route::post('/store-pasien-baru/pasien-kecelakaan', [App\Http\Controllers\IGD\PasienKecelakaan\PasienKecelakaanController::class, 'pasienKecStore'])->name('pasien-kecelakaan.store-pasien-baru');
    // Pasien BPJS Proses
    Route::get('/pasien-bpjsproses/list-pasien', [App\Http\Controllers\IGD\BPJSPROSES\BpjsProsesController::class, 'listPasienBpjsProses'])->name('pasien-bpjs-proses.index');
    Route::get('detail/pasien-proses/{kunjungan}', [App\Http\Controllers\IGD\BPJSPROSES\BpjsProsesController::class, 'detailPasienBPJSPROSES'])->name('pasien-bpjs-proses.detail');

    // IGD VERSI 1
    Route::get('cari-pasien/pasien-lama', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'cariPasienLama'])->name('cari-pasien-lama');
    Route::get('daftar/pasien-igd', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'index'])->name('daftar-igd.v1');
    Route::post('simpan/pasien-tanpa-nomor', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'storeTanpaNoAntrian'])->name('v1.store-tanpa-noantrian');
    Route::post('simpan-versi2/pasien-tanpa-nomor', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'storeTanpaNoAntrianV2IgdIgk'])->name('v2.store-tanpa-noantrian');
    Route::post('simpan-versi2/pasien-ranap', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'storeTanpaNoAntrianV2Ranap'])->name('v2.store-tanpa-noantrian-ranap');
    Route::post('simpan-versi2/pasien-penunjang', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'storeTanpaNoAntrianV2Penunjang'])->name('v2.store-tanpa-noantrian-penunjang');
    Route::get('cek-status/bpjs', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'cekStatusBPJS'])->name('cek-status.v1');
    Route::get('tanpa-daftar/cek-status/bpjs', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'cekStatusBPJSTanpaDaftar'])->name('cek-status-bpjs.tanpa-daftar');
    Route::get('cek-kunjungan/{no_rm}', [App\Http\Controllers\IGD\V1\DaftarIGDController::class, 'getKunjunganPasien'])->name('cek-kunjungan-pasien-terpilih');

    // DAFTAR PENUNJANG
    Route::get('penujang/daftar', [App\Http\Controllers\IGD\Penunjang\DaftarPenunjangController::class, 'index'])->name('penunjang.index');
    Route::post('post/daftar-penunjang', [App\Http\Controllers\IGD\Penunjang\DaftarPenunjangController::class, 'store'])->name('daftar-penunjang.store');
    Route::get('kunjungan-penunjang', [App\Http\Controllers\IGD\Penunjang\DaftarPenunjangController::class, 'kunjunganPenunjang'])->name('kunjungan-penunjang.list');
    // PPRI
    Route::get('kunjungan-poli', [App\Http\Controllers\IGD\PPRI\PPRIController::class, 'kunjunganPoli'])->name('kunjungan-poli.ppri');
    Route::post('post/kunjungan-poli', [App\Http\Controllers\IGD\PPRI\PPRIController::class, 'postPPRI'])->name('kunjungan-post.ppri');

    // Start Gizi
    Route::controller(App\Http\Controllers\Keuangan\KeuanganController::class)->prefix('keuangan')->name('simrs.keuangan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/copy-selected', 'copyTable')->name('copy_totable');
    });


    // Tracer User Pendaftaran
    Route::controller(App\Http\Controllers\IGD\TracerPendaftaran\TracerUserController::class)->prefix('tracer-pendaftaran')->name('simrs.tracer-pendaftaran.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export-byuser', 'exportByUser')->name('export-byuser');
    });

    // Pendafataran Ranap IGD
    Route::controller(App\Http\Controllers\IGD\V1\DaftarRanapIGDController::class)->prefix('igd-ranap')->name('simrs.pendaftaran-ranap-igd.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/ruangan/edit/{kunjungan}', 'editRuangan')->name('edit-ruangan');
        Route::post('/ruangan/update', 'updateRuangan')->name('update-ruangan');
        Route::post('/diagnosa-icd10/update', 'updateDiagnosaKunjungan')->name('update-diagnosa-kunjungan');
    });

    Route::controller(App\Http\Controllers\RM\LaporanRmController::class)->prefix('laporan-rm')->name('simrs.laporan-rm.')->group(function () {
        Route::get('/diagnosa-C00-C99', 'laporanc00')->name('laporan.C00');
        Route::get('/export/diagnosa-C00-C99', 'laporanc00Export')->name('laporan-export.C00');
    });

    // Laporan Rekam Medis
    Route::controller(App\Http\Controllers\LaporanRekamMedis\LaporanRekamMedisController::class)->prefix('laporan-rm')->name('laporan-rm.')->group(function () {
        Route::get('/laporan-rl-51', 'laporanRL51')->name('rl-51');
        Route::get('detail-kunjungan/laporan-rl51', 'detailLaporanRL51')->name('detail-laporan-rl51');
        Route::get('/laporan-rl-52', 'LaporanRL52')->name('rl-52');
        Route::get('detail-kunjungan/laporan-rl52', 'detailLaporanRL52')->name('detail-laporan-rl52');
        // laporan pasien rujukan fktp
        Route::get('/pasien-rujukan-fktp', 'pasienRujukanFktp')->name('pasien-rujukan');
        Route::get('/get-fktp', 'getFktp')->name('get-fktp');
        Route::get('/download-fktp', 'download')->name('download');
        // laporan pasien rawat inap perruangan
        Route::get('/pasien-ranap/peruangan', 'laporanRanapPeruangan')->name('pasien-ranap-peruangan');

        // Laporan kunjungan poliklinik
        Route::controller(App\Http\Controllers\LaporanRekamMedis\KunjunganPoliklinikController::class)->prefix('kunjungan')->name('kunjungan.')->group(function () {
            Route::get('/kunjungan-poliklinik', 'lapKunjunganPoli')->name('kunjungan-poliklinik');
            Route::get('download/kunjungan-poliklinik', 'exportKunjunganPoli')->name('exportKunjunganPoli');
        });

        Route::controller(App\Http\Controllers\LaporanRekamMedis\PenyakitKasusBaruController::class)->prefix('kasus-baru')->name('kasus-baru.')->group(function () {
            Route::get('/menular-dm', 'menularDM')->name('menular-dm');
            Route::get('download/menular-dm', 'downloadMenularDM')->name('download.menular-dm');
            Route::get('/hypertensi', 'hypertensi')->name('hypertensi');
            Route::get('download/hypertensi', 'downloadHypertensi')->name('download.hypertensi');
            Route::get('/ppok', 'ppok')->name('ppok');
            Route::get('download/ppok', 'downloadPpok')->name('download.ppok');
            Route::get('/jantung', 'jantung')->name('jantung');
            Route::get('download/jantung', 'downloadJantung')->name('download.jantung');
            Route::get('/stroke', 'stroke')->name('stroke');
            Route::get('download/stroke', 'downloadStroke')->name('download.stroke');
        });

        Route::controller(App\Http\Controllers\LaporanRekamMedis\PembukaanFormResumeController::class)->prefix('pembukaan-form-resume')->name('pembukaan-form-resume.')->group(function () {
            Route::get('/data-pengajuan', 'pengajuan')->name('pengajuan');
        });
    });

    // Casemix
    Route::controller(App\Http\Controllers\Casemix\DataResumePemulanganController::class)->prefix('casemix-resume')->name('casemix-resume.')->group(function () {
        Route::get('/data-resume', 'resumePemulangan')->name('data.resume');
        Route::get('pengajuan-pembukaan/data-resume', 'pembukaanAksesResume')->name('pengajuan-pembukaan.resume');
        Route::get('verify-resume', 'verifyResume')->name('verify.resume');
        Route::get('/coder-diagnosa-resume/{kode}', 'coderView')->name('coder.diagnosa');
        Route::post('/coder-diagnosa-resume/store', 'coderStoreDiagnosa')->name('coder-diagnosa.store');
    });

    // Casemix Cari SEP
    Route::controller(App\Http\Controllers\Casemix\CariSepController::class)->prefix('casemix-cari-sep')->name('casemix-cari-sep.')->group(function () {
        Route::get('/', 'viewCariSep')->name('index');
        Route::get('/get-sep', 'getSep')->name('get-sep');
        Route::get('/download', 'getSepDownload')->name('get-sep-download');
    });
    // pencarian pasien
    Route::controller(App\Http\Controllers\IGD\V1\PencarianPasienController::class)->prefix('pencarian')->name('data-pasien.')->group(function () {
        Route::get('/pasien-terdaftar', 'cariPasienTerdaftar')->name('cari-pasien-terdaftar');
    });

    // ERM RAWAT INAP V1.1
    Route::controller(App\Http\Controllers\ERMRANAP\RencanaAsuhanController::class)->prefix('rencana-asuhan')->name('rawat-inap.rencana-asuhan.')->group(function () {
        Route::get('get-rencana-asuhan', 'getDataRencana')->name('get-rencana-asuhan');
        Route::post('simpan_rencana_asuhan_terpadu', 'simpan_rencana_asuhan_terpadu')->name('simpan_rencana_asuhan_terpadu');
        Route::get('edit-rencana-asuhan', 'getRencanaAsuhData')->name('edit-rencana-asuhan');
        Route::post('hapus-rencana-asuhan', 'hapusRencanaAsuhan')->name('hapus_rencana_asuhan');
    });

    Route::controller(App\Http\Controllers\ERMRANAP\DashboardErmRanapController::class)->prefix('erm-ranap')->name('dashboard.erm-ranap.')->group(function () {
        Route::get('dashboard', 'dashboardERMRanap')->name('dashboard');
        Route::get('get-rincian-biaya', 'get_rincian_biaya')->name('rincian-biaya');
        Route::get('/assesmen-awal-medis', 'assesmenAwalMedis')->name('assesmen-awal-medis');
        Route::get('/edukasi', 'assesmenKebutuhanEdukasi')->name('assesmen-kebutuhan-edukasi');
        Route::get('/konsultasi', 'konsultasi')->name('konsultasi');
        Route::get('/anastesi', 'assesmenPraAnastesi')->name('assesmen-pra-anastesi');
        Route::get('/tindakan', 'informasiTindakan')->name('informasi-tindakan');
        Route::get('/catatan-mpp-a', 'catatanMPPA')->name('catatan-mpp-a');
        Route::post('/simpan/catatan-mpp-a', 'catatanMPPAStore')->name('catatan-mpp-a.store');
        Route::get('/catatan-mpp-b', 'catatanMPPB')->name('catatan-mpp-b');

        Route::get('/get-berkas', 'getBerkasFile')->name('get-berkas-file');


        // versi perbaikan view
        Route::get('/riwayat/{kode_kunjungan}', 'getRiwayatDetails')->name('riwayat.details');
        // dashboard versi 2
        Route::controller(App\Http\Controllers\ERMRANAP\Dashboard\DashboardDokterController::class)->prefix('dokters')->name('dokters.')->group(function () {
            Route::get('/dashboard-dokter', 'dashboardDokter')->name('dashboard');
            Route::get('/get-penunjang-radiologi', 'getPenunjangRadiologi')->name('penunjang-radiologi');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\Dokter\AssesmenMedisController::class)->prefix('assesmen-medis')->name('assesmen-medis.')->group(function () {
            Route::post('/assesmen-medis/store', 'storeAssesmen')->name('store-assesmen');
            Route::get('cetakan/asesmen-awal-medis', 'printAsesmenRanapAwal')->name('cetakan-asesmen-awal-medis');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\Obat\RekonsiliasiObatController::class)->prefix('rekonsiliasi-obat')->name('rekonsiliasi-obat.')->group(function () {
            Route::post('store/rekonsiliasi-obat', 'storeObat')->name('store-obat');
            Route::put('update/rekonsiliasi-obat/{id}', 'updateObat')->name('update-obat');
            Route::delete('delete/rekonsiliasi-obat/{id}', 'deleteObat')->name('delete-obat');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\RencanaAsuhan\RencanaAsuhanController::class)->prefix('rencana-asuhan')->name('rencana-asuhan.')->group(function () {
            Route::post('/rencana-asuhan/store', 'storeRencanaAsuhan')->name('store-rencana-asuhan');
            Route::put('update/rencana-asuhan/{id}', 'updateRencana')->name('update-rencana');
            Route::delete('delete/rencana-asuhan/{id}', 'deleteRencana')->name('delete-rencana');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\Perkembangan\PerkembanganPasienController::class)->prefix('perkembangan-pasien')->name('perkembangan-pasien.')->group(function () {
            Route::post('store/perkembangan-pasien', 'storePerkembangan')->name('store-perkembangan');
            Route::get('get-data-perkembangan', 'getPerkembangan')->name('get-perkembangan');
            Route::put('update/perkembangan-pasien/{id}', 'updatePerkembangan')->name('update-perkembangan');
            Route::delete('delete/perkembangan-pasien/{id}', 'deletePerkembangan')->name('delete-perkembangan');
            Route::post('konsultasi/store', 'storeKonsultasi')->name('store-konsultasi');
            Route::get('get-data-konsultasi', 'getKonsultasiData')->name('get-konsultasi');
            Route::get('cetakan/konsultasi', 'printKonsultasi')->name('cetakan-konsultasi');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\Penunjang\PenunjangController::class)->prefix('penunjang')->name('penunjang.')->group(function () {
            Route::get('/list-penujang', 'getPenunjang')->name('get-penunjang');
            Route::get('/kpo-elektronik', 'kpoElektronik')->name('kpo-elektronik');
            Route::get('/rekonsiliasi-obat', 'rekonsiliasiObat')->name('rekonsiliasi-obat');
            Route::get('/rencana-asuhan-terpadu', 'rencanaAsuhanTerpadu')->name('rencana-asuhan-terpadu');
            Route::get('/grouping', 'grouping')->name('grouping');
            // get data riwayat pasien
            Route::get('/riwayat-poliklinik', 'riwayatPoliklinik')->name('riwayat-poliklinik');
        });
        // pemulangan pasien
        Route::controller(App\Http\Controllers\ERMRANAP\ResumePemulanganController::class)->prefix('resume-pemulangan')->name('resume-pemulangan.')->group(function () {
            Route::get('/resume', 'viewResume')->name('resume');
            Route::get('v1/resume', 'viewResumeCepat')->name('resume.cepat');
            Route::post('/store-resume', 'storeResume')->name('store-resume');
            Route::get('/print-resume', 'printResume')->name('print-resume');
        });
        Route::controller(App\Http\Controllers\ERMRANAP\SuratKontrolController::class)->prefix('surat-kontrol')->name('surat-kontrol.')->group(function () {
            Route::get('/create', 'create')->name('create');
        });

        Route::controller(App\Http\Controllers\ERMRANAP\Perawat\RanapPerawatController::class)->prefix('perawat')->name('perawat.')->group(function () {
            Route::get('/assesmen-awal-keperawatan', 'assesmenAwalKeperawatan')->name('assesmen-awal-keperawatan');
            Route::get('/implementasi-evaluasi', 'implementasiEvaluasi')->name('implementasi-evaluasi');
            Route::get('/lembar-edukasi', 'lembarEdukasi')->name('lembar-edukasi');
            Route::get('/catatan-mpp-a', 'catatanMPPA')->name('catatan-mpp-a');
            Route::get('/catatan-mpp-b', 'catatanMPPB')->name('catatan-mpp-b');
            Route::get('/cppt-perawat', 'cpptPerawat')->name('cppt-perawat');
            Route::get('/rencana-pemulangan-pasien', 'rencanaPemulanganPasien')->name('rencana-pemulangan-pasien');

            Route::controller(App\Http\Controllers\ERMRANAP\Perawat\AsesmenPerawatController::class)->prefix('assesmen-awal')->name('assesmen-awal.')->group(function () {
                Route::post('store/assesmen-awal', 'storeAsesmenPerawat')->name('store-assesmen');
                Route::get('cetakan/asesmen-awal-keperawatan', 'printAsesmenAwalKeperawatan')->name('cetakan-asesmen-awal-keperawatan');
            });
            Route::controller(App\Http\Controllers\ERMRANAP\Perawat\ImplementasiEvaluasiController::class)->prefix('implementasi-evaluasi')->name('implementasi-evaluasi.')->group(function () {
                Route::post('store', 'storeImplementasiEvaluasi')->name('store-implementasi-evaluasi');
                Route::put('update/{id}', 'updateImplementasiEvaluasi')->name('update-implementasi-evaluasi');
                Route::get('cetakan-implementasi-evaluasi', 'printImplementasiEvaluasi')->name('cetakan-implementasi-evaluasi');
                Route::get('show-data-implementasi', 'showDataImplementasiEvaluasi')->name('showdata-implementasi-evaluasi');
                Route::post('verifikasi', 'verifikasiImplementasiEvaluasi')->name('verifikasi-implementasi-evaluasi');
            });

            Route::controller(App\Http\Controllers\ERMRANAP\Perkembangan\PerkembanganPasienController::class)->prefix('cppt-perawat')->name('cppt-perawat.')->group(function () {
                Route::post('store/perkembangan-pasien', 'storeCPPTPerawat')->name('store-perkembangan');
                Route::put('update/perkembangan-pasien/{id}', 'updateCPPTPerawat')->name('update-perkembangan');
                // Route::delete('delete/rencana-asuhan/{id}', 'deleteRencana')->name('delete-rencana');
            });
        });
    });

    Route::controller(App\Http\Controllers\ERMRANAP\ResumePemulanganController::class)->prefix('resume-pemulangan.vbeta')->name('resume-pemulangan.vbeta.')->group(function () {
        Route::get('v1beta/resume', 'viewResumeCepat')->name('resume-vbeta.cepat');
        Route::post('/store-resume', 'storeResume')->name('store-resume');
        Route::get('/print-resume', 'printResume')->name('print-resume');
        Route::get('/get-icd', 'getIcd10Data')->name('get-icd10');
        Route::get('/get-dokter-dpjp', 'getDokters')->name('get-dokter');
        Route::get('/pasien-rawat-inap', 'pasienRanap')->name('list-pasien-ranap');
        Route::post('/send-final', 'sendResume')->name('send-final');
        Route::post('/post-pengajuan-pembukaan-resume', 'postPengajuanPembukaanFormResume')->name('post.pengajuan-pembukaan-resume');
        Route::post('/update-status-casemix/{id}', 'statusPublishCasemix')->name('publish-casemix');
    });
    // End GIZI
});
