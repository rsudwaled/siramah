<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAsesemenKeperawatan">
        <h3 class="card-title">
            Asesmen Keperawatan Rawat Inap
        </h3>
        <div class="card-tools">
            <i class="fas fa-file-medical"></i>
        </div>
    </a>
    <div id="cAsesemenKeperawatan" class="collapse" role="tabpanel">
        <div class="card-body">
            Asesmen Keperawatan Rawat Inap
        </div>
    </div>
</div>
<x-adminlte-modal id="modalAsesmenKeperawatan" name="modalAsesmenKeperawatan" title="Asesmen Keperawatan Rawat Inap"
    theme="success" icon="fas fa-file-medical" size="xl">
    <form action="">
        <div class="row">
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tgl_masuk_ruangan" label="Tgl Masuk Ruangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config" required />
                <x-adminlte-input name="nama_unit" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" label="Nama Ruangan" placeholder="Nama Ruangan" readonly />
                <x-adminlte-select name="cara_masuk" label="Cara Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Jalan Kaki</option>
                    <option>Kursi Roda</option>
                    <option>Brankar</option>
                </x-adminlte-select>
                <x-adminlte-select name="asal_masuk" label="Asal Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>IGD</option>
                    <option>Kamar Operasi</option>
                    <option>Rawat Jalan</option>
                    <option>Transfer Ruangan</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-input-date name="tgl_asesmen_awal" label="Tgl Asesmen Awal" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config" required />
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Pasien / Autoanamnese</option>
                    <option>Keluarga / Allonamnese</option>
                </x-adminlte-select>
                <x-adminlte-input name="nama_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nama Keluarga" placeholder="Nama Keluarga" />
                <x-adminlte-input name="hubungan_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Hubungan Keluarga" placeholder="Hubungan Keluarga" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="keadaan_umum" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Keadaan Umum" placeholder="Keadaan Umum" />
                <x-adminlte-input name="diastole" fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" label="Diastole" placeholder="Diastole" />
                <x-adminlte-input name="sistole" fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" label="Sistole" placeholder="Sistole" />
                <x-adminlte-input name="denyut_nadi" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Denyut Nadi" placeholder="Denyut Nadi" />
                <x-adminlte-input name="pernapasan" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Pernapasan" placeholder="Pernapasan" />
                <x-adminlte-input name="suhu" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Suhu" placeholder="Suhu" />
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="provocation" label="Provocation" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Cahaya</option>
                    <option>Gelap</option>
                    <option>Gerakan</option>
                </x-adminlte-select>
                <x-adminlte-select name="quality" label="quality" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Ditusuk</option>
                    <option>Dibakar</option>
                    <option>Ditarik</option>
                    <option>Kram</option>
                    <option>Berdenyut</option>
                    <option>Lainnya</option>
                </x-adminlte-select>
                <x-adminlte-select name="reqion" label="reqion" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Nyeri Tetap</option>
                    <option>Nyeri Berpindah-pindah</option>
                    <option>Gerakan</option>
                </x-adminlte-select>
                <x-adminlte-select name="severity" label="severity" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Nyeri Ringan</option>
                    <option>Nyeri Sedang</option>
                    <option>Nyeri Berat</option>
                </x-adminlte-select>
                <x-adminlte-select name="time" label="time" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Terus Menerus</option>
                    <option>Hilang Timbul</option>
                    <option>
                        < 30 Menit</option>
                    <option>> 30 Menit</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-textarea name="keluhan_utama" label="Keluhan Utama" rows="3" igroup-size="sm"
                    placeholder="Keluhan Utama">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_utama" label="Riwayat Penyakit Utama" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Utama">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_dahulu" label="Riwayat Penyakit Dahulu" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Dahulu">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_keluarga" label="Riwayat Penyakit Keluarga"
                    rows="3" igroup-size="sm" placeholder="Riwayat Penyakit Keluarga">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="riwayat_pernah_dirawat" label="Riwayat Pernah Dirawat" rows="3"
                    igroup-size="sm" placeholder="Riwayat Pernah Dirawat">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_pemakaian_obat" label="Riwayat Pemakaian Obat" rows="3"
                    igroup-size="sm" placeholder="Riwayat Pemakaian Obat">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyerta" label="Riwayat Penyakit Penyerta" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Penyerta">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_alergi" label="Riwayat Alergi" rows="3" igroup-size="sm"
                    placeholder="Riwayat Alergi">
                </x-adminlte-textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Respirasi & Oksigenasi</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="obstruksi_saluran_nafas" label="Obstruksi Saluran Nafas" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="sesak_nafas" label="Sesak Nafas" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select2 name="alat_bantu_nafas" label="Alat Bantu Pernapasan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Binasal Canule</option>
                    <option>Simple Mask</option>
                    <option>Rebreathing Mask</option>
                    <option>Non Rebreathing Mask</option>
                    <option>Endotracheal Tube</option>
                    <option>Trachea Canule</option>
                    <option>Ventilator</option>
                </x-adminlte-select2>
                <x-adminlte-select name="batuk" label="Batuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-input name="warna_sputum" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Warna Sputum" placeholder="Warna Sputum" />
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="bunyi_nafas" label="Bunyi Nafas" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Normal</option>
                    <option>Abnormal</option>
                    <option>Wheezing</option>
                    <option>Rales</option>
                    <option>Rounch</option>
                </x-adminlte-select>
                <x-adminlte-select name="thorax" label="Thorax" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Simetris</option>
                    <option>Tidak Simetris</option>
                </x-adminlte-select>
                <x-adminlte-input name="area_krepitasi" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Area Krepitas" placeholder="Area Krepitas" />
                <x-adminlte-select name="ctt_thorax" label="CTT" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Kardiovaskuler</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="konjungtiva" label="Konjungtiva" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Pucat</option>
                    <option>Merah Muda</option>
                </x-adminlte-select>
                <x-adminlte-select2 name="riwayat_pemasangan_alat" label="Riwayat Pemasangan Alat" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Pace Maker</option>
                    <option>Ring</option>
                </x-adminlte-select2>
                <x-adminlte-select name="keadaan_kulit" label="Keadaan Kulit" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Pucat</option>
                    <option>Cyanosis</option>
                    <option>Hiperemis</option>
                    <option>Ekimosis</option>
                </x-adminlte-select>
                <x-adminlte-select name="temperatur" label="Temperatur" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Hangat</option>
                    <option>Dingin</option>
                    <option>Diaphoresis (Berkeringat)</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="bunyi_jantung" label="Bunyi Jantung" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Normal</option>
                    <option>Murmur</option>
                    <option>Gallop</option>
                    <option>Lainnya</option>
                </x-adminlte-select>
                <x-adminlte-input name="extremitas_crt" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Extremitas CRT" placeholder="Extremitas CRT" />
                <x-adminlte-input name="area_nichiband_trband" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Area Nichiband / TR Band"
                    placeholder="Area Nichiband / TR Band" />
                <x-adminlte-input name="area_edema" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Area Edema" placeholder="Area Edema" />
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Sistem Gastro Intestinal</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="frekuensi_makan" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Frekuensi Makan" />
                <x-adminlte-input name="jumlah_porsi" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Jumlah Porsi" />
                <x-adminlte-select name="mual" label="Mual" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
                <x-adminlte-input name="warna_muntah" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Warna Muntah" />
                <x-adminlte-input name="frekuensi_bab" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Frekuensi BAB" />
                <x-adminlte-input name="warna_bab" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Warna BAB" />
                <x-adminlte-input name="konsistensi_bab" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Konsistensi BAB" />
                <x-adminlte-select name="sklera" label="Sklera" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Ikterik</option>
                    <option>Tidak</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-select name="keadaan_mukosa" label="Keadaan Mukosa" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Lembab</option>
                    <option>Kering</option>
                    <option>Lesi</option>
                    <option>Nodul</option>
                </x-adminlte-select>
                <x-adminlte-input name="warna_lidah" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Warna Lidah" placeholder="Warna Lidah" />
                <x-adminlte-select name="ulkus" label="Ulkus" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Ada</option>
                    <option>Tidak</option>
                </x-adminlte-select>
                <x-adminlte-select name="reflek_menelan" label="Reflek Menelan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Dapat</option>
                    <option>Tidak</option>
                </x-adminlte-select>
                <x-adminlte-select name="reflek_menguyah" label="Reflek Menguyah" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Dapat</option>
                    <option>Tidak</option>
                </x-adminlte-select>
                <x-adminlte-select2 name="alat_bantu_makan" label="Alat Bantu" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>NGT</option>
                    <option>OGT</option>
                </x-adminlte-select2>
                <x-adminlte-select name="stoma_urine" label="Stoma" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Ya</option>
                    <option>Tidak</option>
                </x-adminlte-select>
                <x-adminlte-select2 name="drain" label="Drain" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>Sillicon</option>
                    <option>T-Tube</option>
                    <option>Penrose</option>
                </x-adminlte-select2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-6">
                <h6>Pemeriksaan Sistem Muskola Skeletal</h6>
                <x-adminlte-select name="frakture" label="Frakture" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="mobilitas" label="Mobilitas" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Mandiri</option>
                    <option>Menggunakan Alat Bantu</option>
                </x-adminlte-select>
                <x-adminlte-textarea name="alat_bantu_mobilitas" label="Alat Bantu Mobilitas" rows="2"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    placeholder="Alat Bantu Mobilitas">
                </x-adminlte-textarea>
            </div>
            <div class="col-6">
                <h6>Pemeriksaan Sistem Neurologi</h6>
                <x-adminlte-select name="kesulitan_bicara" label="Kesulitan Bicara" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="kelemahan_alat_gerak" label="Kelemahan Alat Gerak" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="terpasang_evd" label="Terpasang EVD" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ya</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Sistem Urogenital</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-6">
                <x-adminlte-select2 name="perubahan_pola_bak" label="Perubahan Pola BAK" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>Tidak Lampias</option>
                    <option>Sensasi Terbakar saat Miksi</option>
                    <option>Penurunan Pancaran Urine</option>
                </x-adminlte-select2>
                <x-adminlte-input name="frekuensi_bak" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Frekuensi BAK" />
                <x-adminlte-input name="warna_urine" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Warna Urina" />
            </div>
            <div class="col-6">
                <x-adminlte-select2 name="alat_bantu_bak" label="Alat Bantu BAK" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>Dower Kateter</option>
                    <option>Kondom Kateter</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="stoma" label="Stoma" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>Urustomy</option>
                    <option>Nefrostomy</option>
                    <option>Cystostomy</option>
                </x-adminlte-select2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-6">
                <h6>Pemeriksaan Sistem Integumen</h6>
                <x-adminlte-select name="ada_luka" label="Ada Luka" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="ada_benjolan" label="Ada Benjolan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Tidak</option>
                    <option>Ada</option>
                </x-adminlte-select>
                <x-adminlte-select name="suhu_integumen" label="Suhu Integumen" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Hangat</option>
                    <option>Dingin</option>
                    <option>Panas</option>
                </x-adminlte-select>
            </div>
            <div class="col-6">
                <h6>Pemeriksaan Hyigiene</h6>
                <x-adminlte-select name="aktivitas_sehari" label="Aktivitas Sehari" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Mandiri</option>
                    <option>Dibantu</option>
                </x-adminlte-select>
                <x-adminlte-select name="penampilan" label="Penampilan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Bersih</option>
                    <option>Kotor</option>
                </x-adminlte-select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Psikososial & Budaya</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-5">
                <x-adminlte-select name="ekspresi_wajah" label="Ekspresi Wajah" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Cerah</option>
                    <option>Tenang</option>
                    <option>Murung</option>
                    <option>Cemas</option>
                    <option>Ketakutan</option>
                    <option>Panic</option>
                </x-adminlte-select>
                <x-adminlte-select name="kemampuan_bicara" label="Ekspresi Wajah" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Baik</option>
                    <option>Tidak Mau Bicara</option>
                    <option>Tidak Mau Kontak Mata</option>
                </x-adminlte-select>
                <x-adminlte-select name="koping_mekanisme" label="Koping Mekanisme" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Menyelesaikan Masalah Sendiri</option>
                    <option>Selalu Dibantu Bila Ada Masalah</option>
                </x-adminlte-select>
                <x-adminlte-input name="pekerjaan" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Pekerjaan" />
                <x-adminlte-select name="tinggal_bersama" label="Tinggal Bersama" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Suami / Istri</option>
                    <option>Orang Tua</option>
                    <option>Anak</option>
                    <option>Teman</option>
                    <option>Sendiri</option>
                    <option>Keluarga</option>
                    <option>Lain-lain</option>
                </x-adminlte-select>
                <x-adminlte-select name="suku" label="Suku" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Jawa</option>
                    <option>Sunda</option>
                    <option>Batak</option>
                    <option>Tionghoa</option>
                    <option>Lain-lain</option>
                </x-adminlte-select>
            </div>
            <div class="col-7">
                <x-adminlte-select name="agama" label="Agama" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Islam</option>
                    <option>Kristen</option>
                    <option>Katolik</option>
                    <option>Hindu</option>
                    <option>Budha</option>
                    <option>Lain-lain</option>
                </x-adminlte-select>
                <x-adminlte-select2 name="keprihatinan_agama" label="Mengungkapkan keprihatinan yang berhubungan dengan rawat inap" igroup-size="sm" multiple>
                    <option>Tidak</option>
                    <option>Ketidakmampuan untuk mempertahankan praktek spiritual seperti biasa</option>
                    <option>Perasaan Negative tentang system kepercayaan terhadap spiritual</option>
                    <option>Konflik antara kepercayaan spiritual dengan ketentuan system kesehatan</option>
                    <option>Bimbingan Rohani</option>
                    <option>Lain-lain</option>
                </x-adminlte-select2>
                <x-adminlte-textarea name="nilai_kepercayaan" label="Nilai-nilai Kepercayaan" rows="2"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                </x-adminlte-textarea>

            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan Spiritual & Nilai Kepercayaan</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
        </div>
        <x-adminlte-input name="dokter_asesmen_awal" igroup-size="sm" label="Dokter DPJP Asesmen Awal"
            placeholder="Dokter DPJP Asesmen Awal" />
    </form>
</x-adminlte-modal>
@push('js')
    <script>
        function modalAsesmenKeperawatan() {
            $.LoadingOverlay("show");
            $('#modalAsesmenKeperawatan').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
