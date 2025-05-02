<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AntrianDevController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\InacbgController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\JadwalOperasiController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('farmasi')->group(function () {
    Route::get('getTipeBarang', [FarmasiController::class, 'getTipeBarang'])->name('getTipeBarang');
    Route::post('getLaporanPengadaanObat', [FarmasiController::class, 'getLaporanPengadaanObat'])->name('getLaporanPengadaanObat');
});

// VCLAIM
Route::prefix('vclaim')->group(function () {
    // MONITORING
    Route::get('monitoring_data_kunjungan', [VclaimController::class, 'monitoring_data_kunjungan'])->name('monitoring_data_kunjungan');
    Route::get('monitoring_data_klaim', [VclaimController::class, 'monitoring_data_klaim'])->name('monitoring_data_klaim');
    Route::get('monitoring_pelayanan_peserta', [VclaimController::class, 'monitoring_pelayanan_peserta'])->name('monitoring_pelayanan_peserta');
    Route::get('monitoring_klaim_jasaraharja', [VclaimController::class, 'monitoring_klaim_jasaraharja'])->name('monitoring_klaim_jasaraharja');
    // PESERTA
    Route::get('peserta_nomorkartu', [VclaimController::class, 'peserta_nomorkartu'])->name('peserta_nomorkartu');
    Route::get('peserta_nik', [VclaimController::class, 'peserta_nik'])->name('peserta_nik');
    // REFERENSI
    Route::get('ref_diagnosa', [VclaimController::class, 'ref_diagnosa'])->name('ref_diagnosa');
    Route::get('ref_poliklinik', [VclaimController::class, 'ref_poliklinik'])->name('ref_poliklinik');
    Route::get('ref_faskes', [VclaimController::class, 'ref_faskes'])->name('ref_faskes');
    Route::get('ref_dpjp', [VclaimController::class, 'ref_dpjp'])->name('ref_dpjp');
    Route::get('ref_provinsi', [VclaimController::class, 'ref_provinsi'])->name('ref_provinsi');
    Route::get('ref_kabupaten', [VclaimController::class, 'ref_kabupaten'])->name('ref_kabupaten');
    Route::get('ref_kecamatan', [VclaimController::class, 'ref_kecamatan'])->name('ref_kecamatan');
    Route::get('ref_diagnosa_prb', [VclaimController::class, 'ref_diagnosa_prb'])->name('ref_diagnosa_prb');
    Route::get('ref_obat_prb', [VclaimController::class, 'ref_obat_prb'])->name('ref_obat_prb');
    Route::get('ref_tindakan', [VclaimController::class, 'ref_tindakan'])->name('ref_tindakan');
    Route::get('ref_kelas_rawat', [VclaimController::class, 'ref_kelas_rawat'])->name('ref_kelas_rawat');
    Route::get('ref_dokter_dpjp', [VclaimController::class, 'ref_dokter'])->name('ref_dokter_dpjp');
    Route::get('ref_spesialistik', [VclaimController::class, 'ref_spesialistik'])->name('ref_spesialistik');
    Route::get('ref_ruang_rawat', [VclaimController::class, 'ref_ruang_rawat'])->name('ref_ruang_rawat');
    Route::get('ref_cara_keluar', [VclaimController::class, 'ref_cara_keluar'])->name('ref_cara_keluar');
    Route::get('ref_pasca_pulang', [VclaimController::class, 'ref_pasca_pulang'])->name('ref_pasca_pulang');
    // RENCANA KONTROL
    Route::post('suratkontrol_insert', [VclaimController::class, 'suratkontrol_insert'])->name('api.suratkontrol_insert');
    Route::put('suratkontrol_update', [SuratKontrolController::class, 'update'])->name('api.suratkontrol_update');
    Route::put('surat_kontrol_update', [VclaimController::class, 'suratkontrol_update'])->name('surat_kontrol_update');
    Route::delete('suratkontrol_delete', [VclaimController::class, 'suratkontrol_delete'])->name('api.suratkontrol_delete');
    Route::post('spri_insert', [VclaimController::class, 'spri_insert'])->name('spri_insert');
    Route::put('spri_update', [VclaimController::class, 'spri_update'])->name('spri_update');
    Route::get('suratkontrol_sep', [SuratKontrolController::class, 'suratkontrol_sep'])->name('suratkontrol_sep');
    Route::get('suratkontrol_nomor', [VclaimController::class, 'suratkontrol_nomor'])->name('suratkontrol_nomor');
    Route::get('suratkontrol_peserta', [VclaimController::class, 'suratkontrol_peserta'])->name('suratkontrol_peserta');
    Route::get('suratkontrol_tanggal', [VclaimController::class, 'suratkontrol_tanggal'])->name('suratkontrol_tanggal');
    Route::get('suratkontrol_poli', [VclaimController::class, 'suratkontrol_poli'])->name('suratkontrol_poli');
    Route::get('suratkontrol_dokter', [VclaimController::class, 'suratkontrol_dokter'])->name('suratkontrol_dokter');
    // RUJUKAN
    Route::get('rujukan_nomor', [VclaimController::class, 'rujukan_nomor'])->name('rujukan_nomor');
    Route::get('rujukan_peserta', [VclaimController::class, 'rujukan_peserta'])->name('rujukan_peserta');
    Route::get('rujukan_rs_nomor', [VclaimController::class, 'rujukan_rs_nomor'])->name('rujukan_rs_nomor');
    Route::get('rujukan_rs_peserta', [VclaimController::class, 'rujukan_rs_peserta'])->name('rujukan_rs_peserta');
    Route::get('rujukan_jumlah_sep', [VclaimController::class, 'rujukan_jumlah_sep'])->name('rujukan_jumlah_sep');
    // SEP
    Route::post('sep_insert', [VclaimController::class, 'sep_insert'])->name('sep_insert');
    Route::get('sep_nomor', [VclaimController::class, 'sep_nomor'])->name('sep_nomor');
    Route::get('sep_update_pulang', [VclaimController::class, 'sep_update_pulang'])->name('sep_update_pulang');
    Route::delete('sep_delete', [VclaimController::class, 'sep_delete'])->name('sep_delete');
    Route::delete('spri_delete', [VclaimController::class, 'spri_delete'])->name('spri_delete');
    // FINGERPRINT
    Route::get('fingerprint_peserta', [VclaimController::class, 'fingerprint_peserta'])->name('fingerprint_peserta');
    Route::get('fingerprint_sep', [VclaimController::class, 'fingerprint_sep'])->name('fingerprint_sep');
});
// ANTRIAN
Route::prefix('antrian')->group(function () {
    // API BPJS
    Route::get('ref_poli', [AntrianDevController::class, 'ref_poli'])->name('ref_poli');
    Route::get('ref_dokter', [AntrianDevController::class, 'ref_dokter'])->name('ref_dokter');
    Route::get('ref_jadwal_dokter', [AntrianDevController::class, 'ref_jadwal_dokter'])->name('ref_jadwal_dokter');
    Route::get('ref_poli_fingerprint', [AntrianDevController::class, 'ref_poli_fingerprint'])->name('ref_poli_fingerprint');
    Route::get('ref_pasien_fingerprint', [AntrianDevController::class, 'ref_pasien_fingerprint'])->name('ref_pasien_fingerprint');
    Route::post('update_jadwal_dokter', [AntrianDevController::class, 'update_jadwal_dokter'])->name('update_jadwal_dokter');
    Route::post('tambah_antrean', [AntrianDevController::class, 'tambah_antrean'])->name('tambah_antrean');
    Route::post('tambah_antrean_farmasi', [AntrianDevController::class, 'tambah_antrean_farmasi'])->name('tambah_antrean_farmasi');
    Route::post('update_antrean', [AntrianDevController::class, 'update_antrean'])->name('update_antrean');
    Route::post('batal_antrean', [AntrianDevController::class, 'batal_antrean'])->name('batal_antrean');
    Route::post('taskid_antrean', [AntrianDevController::class, 'taskid_antrean'])->name('taskid_antrean');
    Route::get('dashboard_tanggal', [AntrianDevController::class, 'dashboard_tanggal'])->name('dashboard_tanggal');
    Route::get('dashboard_bulan', [AntrianDevController::class, 'dashboard_bulan'])->name('dashboard_bulan');
    Route::get('antrian_tanggal', [AntrianDevController::class, 'antrian_tanggal'])->name('antrian_tanggal');
    Route::get('antrian_kodebooking', [AntrianDevController::class, 'antrian_kodebooking'])->name('antrian_kodebooking');
    Route::get('antrian_pendaftaran', [AntrianDevController::class, 'antrian_pendaftaran'])->name('antrian_pendaftaran');
    Route::get('antrian_poliklinik', [AntrianDevController::class, 'antrian_poliklinik'])->name('antrian_poliklinik');
    // API SIMRS
    Route::post('ambil_antrians ', [AntrianController::class, 'ambil_antrians']); #local
    Route::get('token', [AntrianDevController::class, 'token'])->name('token');
    Route::post('status_antrian', [AntrianDevController::class, 'status_antrian'])->name('status_antrian');
    Route::post('ambil_antrian ', [AntrianDevController::class, 'ambil_antrian']); #api mjkn
    Route::post('sisa_antrian', [AntrianDevController::class, 'sisa_antrian'])->name('sisa_antrian');
    Route::post('batal_antrian', [AntrianDevController::class, 'batal_antrian'])->name('batal_antrian');
    Route::post('checkin_antrian', [AntrianDevController::class, 'checkin_antrian'])->name('checkin_antrian');
    Route::post('info_pasien_baru', [AntrianController::class, 'info_pasien_baru'])->name('info_pasien_baru');
    Route::post('jadwal_operasi_rs', [JadwalOperasiController::class, 'jadwal_operasi_rs'])->name('jadwal_operasi_rs');
    Route::post('jadwal_operasi_pasien', [JadwalOperasiController::class, 'jadwal_operasi_pasien'])->name('jadwal_operasi_pasien');
    Route::post('ambil_antrian_farmasi', [AntrianController::class, 'ambil_antrian_farmasi'])->name('ambil_antrian_farmasi');
    Route::post('status_antrian_farmasi', [AntrianController::class, 'status_antrian_farmasi'])->name('status_antrian_farmasi');
    Route::post('update_antrean_pendaftaran', [AntrianController::class, 'update_antrean_pendaftaran'])->name('update_antrean_pendaftaran'); #integrasi bridging pendaftaran agil
    Route::get('bridging_taskid_4', [AntrianController::class, 'bridging_taskid_4'])->name('bridging_taskid_4'); #integrasi bridging pendaftaran agil
    Route::get('panggil_dokter', [AntrianController::class, 'panggil_dokter'])->name('panggil_dokter');
});
// API SIMRS
Route::get('cari_pasien', [PasienController::class, 'cari_pasien'])->name('cari_pasien');
Route::get('pasien_nomorkartu', [PasienController::class, 'pasien_nomorkartu'])->name('pasien_nomorkartu');
Route::get('jadwal_poliklinik', [JadwalDokterController::class, 'jadwal_poliklinik'])->name('jadwal_poliklinik');
Route::get('jadwal_dokter', [JadwalDokterController::class, 'jadwal_dokter'])->name('jadwal_dokter');
Route::get('poliklinik_aktif', [PoliklinikController::class, 'poliklinik_aktif'])->name('poliklinik_aktif');
Route::get('cari_jadwal_dokter', [JadwalDokterController::class, 'cari_jadwal_dokter'])->name('cari_jadwal_dokter');
Route::get('cekKodebooking', [AntrianController::class, 'cekKodebooking'])->name('api.cekKodebooking');
Route::get('poliklinik_by_hari', [JadwalDokterController::class, 'poliklinik_by_hari'])->name('poliklinik_by_hari');
Route::get('jadwal_by_hari', [JadwalDokterController::class, 'jadwal_by_hari'])->name('jadwal_by_hari');
Route::get('disposisi', [DisposisiController::class, 'disposisi'])->name('disposisi');


// Route::get('cekRujukanPeserta', [VclaimController::class, 'cekRujukanPeserta'])->name('api.cekRujukanPeserta');
// Route::get('cekRujukanRSPeserta', [VclaimController::class, 'cekRujukanRSPeserta'])->name('api.cekRujukanRSPeserta');
// Route::get('cekSuratKontrolPeserta', [VclaimController::class, 'cekSuratKontrolPeserta'])->name('api.cekSuratKontrolPeserta');

// API SIMRS
Route::prefix('wa')->group(function () {
    Route::post('webhooka', [WhatsappController::class, 'webhook']);
    // Route::post('send_message', [WhatsappController::class, 'send_message_perangkap'])->name('send_message');
});
// APP.RSUDWALED.ID
Route::get('poliklinik_aktif', [PoliklinikController::class, 'poliklinik_aktif'])->name('api.poliklinik_aktif');
Route::prefix('simrs')->name('api.simrs.')->group(function () {
    // Route::get('get_icd10', [ICD10Controller::class, 'get_icd10'])->name('get_icd10');
    // Route::get('get_icd9', [ICD9Controller::class, 'get_icd9'])->name('get_icd9');
    // Route::get('get_obats', [ObatController::class, 'get_obats'])->name('get_obats');
    // Route::get('get_layanans', [LayananController::class, 'get_layanans'])->name('get_layanans');
});
// API SATU SEHAT
// Route::prefix('satusehat')->name('api.satusehat.')->group(function () {
//     Route::get('patient/', [PatientController::class, 'index'])->name('patient_index');
//     Route::get('patient/nik/{nik}', [PatientController::class, 'patient_by_nik'])->name('patient_by_nik');
//     Route::get('patient/id/{id}', [PatientController::class, 'patient_by_id'])->name('patient_by_id');
//     Route::get('patient/name', [PatientController::class, 'patient_by_name'])->name('patient_by_name');

//     Route::get('practitioner/', [PractitionerController::class, 'index'])->name('practitioner_index');
//     Route::get('practitioner/nik/{nik}', [PractitionerController::class, 'practitioner_by_nik'])->name('practitioner_by_nik');
//     Route::get('practitioner/id/{id}', [PractitionerController::class, 'practitioner_by_id'])->name('practitioner_by_id');
//     Route::get('practitioner/name', [PractitionerController::class, 'practitioner_by_name'])->name('practitioner_by_name');

//     Route::get('organization/', [OrganizationController::class, 'index'])->name('organization_index');
//     Route::get('organization/{id}', [OrganizationController::class, 'organization_by_id'])->name('organization_by_id');
//     Route::post('organization/store', [OrganizationController::class, 'organization_store_api'])->name('organization_store_api');
//     Route::put('organization/update/{id}', [OrganizationController::class, 'organization_update_api'])->name('organization_update_api');

//     Route::get('location/', [LocationController::class, 'index'])->name('location_index');
//     // Route::get('location/show/{id}', [LocationController::class, 'edit'])->name('location_id');
//     Route::post('location/store', [LocationController::class, 'location_store_api'])->name('location_store_api');
//     Route::put('location/update/{id}', [LocationController::class, 'location_update_api'])->name('location_update_api');

//     Route::get('encounter/', [EncounterController::class, 'index'])->name('encounter_index');
//     Route::post('encounter/store', [EncounterController::class, 'encounter_store_api'])->name('encounter_store_api');
// });

// PENUNJANG
// Route::prefix('penunjang')->name('api.penunjang.')->group(function () {
//     Route::get('cari_pasien', [PenunjangController::class, 'cari_pasien'])->name('cari_pasien');
//     Route::get('cari_dokter', [PenunjangController::class, 'cari_dokter'])->name('cari_dokter');
//     Route::get('get_tarif_laboratorium', [PenunjangController::class, 'get_tarif_laboratorium'])->name('get_tarif_laboratorium');
//     Route::get('get_order_layanan', [PenunjangController::class, 'get_order_layanan'])->name('get_order_layanan');
//     Route::get('get_kunjungan_pasien', [PenunjangController::class, 'get_kunjungan_pasien'])->name('get_kunjungan_pasien');
//     Route::get('get_ris_order', [PenunjangController::class, 'get_ris_order'])->name('get_ris_order');
//     Route::post('insert_layanan', [PenunjangController::class, 'insert_layanan'])->name('insert_layanan');
// });
// RIS
// Route::prefix('ris')->name('api.ris.')->group(function () {
//     Route::get('pasien_get', [RISController::class, 'pasien_get'])->name('pasien_get');
//     Route::post('pasien_add', [RISController::class, 'pasien_add'])->name('pasien_add');
//     Route::get('dokter_get', [RISController::class, 'dokter_get'])->name('dokter_get');
//     Route::get('asuransi_get', [RISController::class, 'asuransi_get'])->name('asuransi_get');
//     Route::get('jenispemeriksaan_get', [RISController::class, 'jenispemeriksaan_get'])->name('jenispemeriksaan_get');
//     Route::get('ruangan_get', [RISController::class, 'ruangan_get'])->name('ruangan_get');
//     Route::get('order_get', [RISController::class, 'order_get'])->name('order_get');
// });

// INACBG
Route::prefix('eclaim')->name('api.eclaim.')->group(function () {
    // Route::get('search_diagnosis', [InacbgController::class, 'search_diagnosis'])->name('search_diagnosis');
    // Route::get('search_procedures', [InacbgController::class, 'search_procedures'])->name('search_procedures');
    // Route::get('search_diagnosis_inagrouper', [InacbgController::class, 'search_diagnosis_inagrouper'])->name('search_diagnosis_inagrouper');
    // Route::get('search_procedures_inagrouper', [InacbgController::class, 'search_procedures_inagrouper'])->name('search_procedures_inagrouper');
    // Route::get('rincian_biaya_pasien', [InacbgController::class, 'rincian_biaya_pasien'])->name('rincian_biaya_pasien');
    // Route::post('new_claim', [InacbgController::class, 'new_claim'])->name('new_claim');
    // Route::post('set_claim', [InacbgController::class, 'set_claim'])->name('set_claim');
    // Route::post('set_claim_rajal', [InacbgController::class, 'set_claim_rajal'])->name('set_claim_rajal');
    // Route::post('set_claim_ranap', [InacbgController::class, 'set_claim_ranap'])->name('set_claim_ranap');
    // Route::post('grouper', [InacbgController::class, 'grouper'])->name('grouper');
    // Route::post('get_claim_data', [InacbgController::class, 'get_claim_data'])->name('get_claim_data');
    // Route::post('get_claim_status', [InacbgController::class, 'get_claim_status'])->name('get_claim_status');
});
