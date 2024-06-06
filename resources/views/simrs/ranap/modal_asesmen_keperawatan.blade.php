<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAsesemenKeperawatan">
        <h3 class="card-title">
            Asesmen Keperawatan Rawat Inap
        </h3>
        <div class="card-tools">
            <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                <i class="fas fa-edit"></i> Edit Asesmen
            </button>
            @if ($kunjungan->asesmen_ranap_keperawatan)
                <button type="button" class="btn btn-tool bg-warning" onclick="printAsesmenKeperawatan()"
                    title="Print">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Asesmen
                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-check"></i> Belum Asesmen
                </button>
            @endif
        </div>
    </a>
    <div id="cAsesemenKeperawatan" class="collapse" role="tabpanel">
        <div class="card-body">
            <iframe src="{{ route('print_asesmen_ranap_keperawatan') }}?kode={{ $kunjungan->kode_kunjungan }}"
                width="100%" height="700px" frameborder="0"></iframe>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalAsesmenKeperawatan" name="modalAsesmenKeperawatan" title="Asesmen Keperawatan Rawat Inap"
    theme="success" icon="fas fa-file-medical" size="xl">
    <form action="{{ route('simpan_asesmen_ranap_keperawatan') }}" name="formAsesmenKeperawatan"
        id="formAsesmenKeperawatan" method="POST">
        @csrf
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" name="no_rm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="rm_counter" value="{{ $kunjungan->no_rm }}|{{ $kunjungan->counter }}">
        <input type="hidden" name="nama" value="{{ $kunjungan->pasien->nama_px }}">
        <div class="row">
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tgl_masuk_ruangan" label="Tgl Masuk Ruangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->tgl_masuk_ruangan ?? ($kunjungan->asesmen_ranap->tgl_masuk_ruangan ?? null) }}"
                    required />
                <input type="hidden" name="kode_unit" value="{{ $kunjungan->unit->kode_unit }}">
                <x-adminlte-input name="nama_unit" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" label="Nama Ruangan" placeholder="Nama Ruangan"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->nama_unit ?? ($kunjungan->asesmen_ranap->nama_unit ?? $kunjungan->unit->nama_unit) }}"
                    readonly required />
                <x-adminlte-select name="cara_masuk" label="Cara Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->cara_masuk == 'Brankar' ? 'selected' : null) : null }}>
                        Brankar
                    </option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->cara_masuk == 'Kursi Roda' ? 'selected' : null) : null }}>
                        Kursi Roda</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->cara_masuk == 'Jalan Kaki' ? 'selected' : null) : null }}>
                        Jalan Kaki</option>
                </x-adminlte-select>
                <x-adminlte-select name="asal_masuk" label="Asal Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->asal_masuk == 'IGD' ? 'selected' : null) : null }}>
                        IGD</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->asal_masuk == 'Kamar Operasi' ? 'selected' : null) : null }}>
                        Kamar Operasi</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->asal_masuk == 'Rawat Jalan' ? 'selected' : null) : null }}>
                        Rawat Jalan</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->asal_masuk == 'Transfer Ruangan' ? 'selected' : null) : null }}>
                        Transfer Ruangan</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-input-date name="tgl_asesmen_keperawatan" id="tglasesmenawal" label="Tgl Asesmen Perawat"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    :config="$config" required
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->tgl_asesmen_keperawatan ?? now() }}" />
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->sumber_data == 'Pasien / Autoanamnese' ? 'selected' : null) : null }}>
                        Pasien / Autoanamnese</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->sumber_data == 'Keluarga / Allonamnese' ? 'selected' : null) : null }}>
                        Keluarga / Allonamnese</option>
                </x-adminlte-select>
                <x-adminlte-input name="nama_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nama Keluarga" placeholder="Nama Keluarga"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->nama_keluarga ?? ($kunjungan->asesmen_ranap_keperawatan->nama_keluarga ?? null) }}"
                    required />
                <x-adminlte-input name="hubungan_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Hubungan Keluarga" placeholder="Hubungan Keluarga"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->hubungan_keluarga ?? ($kunjungan->asesmen_ranap_keperawatan->nama_keluarga ?? null) }}"
                    required />
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Anamnesa</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="keluhan_utama" label="Keluhan Utama" rows="3" igroup-size="sm"
                    placeholder="Keluhan Utama" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->keluhan_utama ?? ($kunjungan->asesmen_ranap->keluhan_utama ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_pernah_dirawat" label="Riwayat Pernah Dirawat" rows="3"
                    igroup-size="sm" placeholder="Riwayat Pernah Dirawat" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_pernah_dirawat ?? ($kunjungan->asesmen_ranap->riwayat_pernah_dirawat ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_pengobatan" label="Riwayat Pengobatan" rows="3"
                    igroup-size="sm" placeholder="Riwayat Pengobatan" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_pengobatan ?? ($kunjungan->asesmen_ranap->riwayat_pengobatan ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_alergi" label="Riwayat Alergi" rows="3" igroup-size="sm"
                    placeholder="Riwayat Alergi" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_alergi ?? ($kunjungan->asesmen_ranap->riwayat_alergi ?? null) }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="riwayat_penyerta" label="Riwayat Penyakit Penyerta" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Penyerta" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_penyerta ?? ($kunjungan->asesmen_ranap->riwayat_penyerta ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_utama" label="Riwayat Penyakit Utama" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Utama" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_penyakit_utama ?? ($kunjungan->asesmen_ranap->riwayat_penyakit_utama ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_dahulu" label="Riwayat Penyakit Dahulu" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Dahulu" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_penyakit_dahulu ?? ($kunjungan->asesmen_ranap->riwayat_penyakit_dahulu ?? null) }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_keluarga" label="Riwayat Penyakit Keluarga"
                    rows="3" igroup-size="sm" placeholder="Riwayat Penyakit Keluarga" required>
                    {{ $kunjungan->asesmen_ranap_keperawatan->riwayat_penyakit_keluarga ?? ($kunjungan->asesmen_ranap->riwayat_penyakit_keluarga ?? null) }}
                </x-adminlte-textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Tanda-tanda Vital</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="keadaan_umum" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Keadaan Umum"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->keadaan_umum ?? ($kunjungan->asesmen_ranap->keadaan_umum ?? null) }}"
                    required />
                <x-adminlte-select name="kesadaran" label="Kesadaran" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->kesadaran == 'Compos Mentis' ? 'selected' : null) : null }}>
                        Compos Mentis</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->kesadaran == 'Apatis' ? 'selected' : null) : null }}>
                        Apatis</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->kesadaran == 'Somnolent' ? 'selected' : null) : null }}>
                        Somnolent</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->kesadaran == 'Sopor' ? 'selected' : null) : null }}>
                        Sopor</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->kesadaran == 'Coma' ? 'selected' : null) : null }}>
                        Coma</option>
                </x-adminlte-select>
                <x-adminlte-input name="diastole" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Diastole"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->diastole ?? ($kunjungan->asesmen_ranap->diastole ?? null) }}"
                    required />
                <x-adminlte-input name="sistole" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Sistole"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->sistole ?? ($kunjungan->asesmen_ranap->sistole ?? null) }}"
                    required />
                <x-adminlte-input name="pernapasan" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Pernapasan"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->pernapasan ?? ($kunjungan->asesmen_ranap->pernapasan ?? null) }}"
                    required />
                <x-adminlte-input name="suhu" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Suhu"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->keadaan_umum ?? ($kunjungan->asesmen_ranap_keperawatan->keadaan_umum ?? ($kunjungan->asesmen_ranap->suhu ?? null)) }}"
                    required />
                <x-adminlte-input name="denyut_nadi" type="number" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nadi"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->denyut_nadi ?? ($kunjungan->asesmen_ranap->denyut_nadi ?? null) }}"
                    required />
            </div>
            <div class="col-md-6">
                <img src="{{ asset('nyeri_nrs.png') }}" width="100%" alt="">
                <x-adminlte-input name="skala_nyeri" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Skala Nyeri"
                    value="{{ $kunjungan->asesmen_ranap_keperawatan->skala_nyeri ?? ($kunjungan->asesmen_ranap->skala_nyeri ?? 0) }}"
                    required />
                <x-adminlte-select name="provocation" label="Provocation" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->provocation == 'Cahaya' ? 'selected' : null) : null }}>
                        Cahaya</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->provocation == 'Gelap' ? 'selected' : null) : null }}>
                        Gelap</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->provocation == 'Gerakan' ? 'selected' : null) : null }}>
                        Gerakan</option>
                </x-adminlte-select>
                <x-adminlte-select name="quality" label="Quality" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Ditusuk' ? 'selected' : null) : null }}>
                        Ditusuk</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Dibakar' ? 'selected' : null) : null }}>
                        Dibakar</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Ditarik' ? 'selected' : null) : null }}>
                        Ditarik</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Kram' ? 'selected' : null) : null }}>
                        Kram</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Berdenyut' ? 'selected' : null) : null }}>
                        Berdenyut</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->quality == 'Lainnya' ? 'selected' : null) : null }}>
                        Lainnya</option>
                </x-adminlte-select>
                <x-adminlte-select name="region" label="Region" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->region == 'Nyeri Tetap' ? 'selected' : null) : null }}>
                        Nyeri Tetap</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->region == 'Nyeri Berpindah-pindah' ? 'selected' : null) : null }}>
                        Nyeri Berpindah-pindah</option>
                </x-adminlte-select>
                <x-adminlte-select name="severity" label="Severity" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->severity == 'Nyeri Ringan' ? 'selected' : null) : null }}>
                        Nyeri Ringan</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->severity == 'Nyeri Sedang' ? 'selected' : null) : null }}>
                        Nyeri Sedang</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->severity == 'Nyeri Berat' ? 'selected' : null) : null }}>
                        Nyeri Berat</option>
                </x-adminlte-select>
                <x-adminlte-select name="time" label="Time" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->time == 'Terus Menerus' ? 'selected' : null) : null }}>
                        Terus Menerus</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->time == 'Hilang Timbul' ? 'selected' : null) : null }}>
                        Hilang Timbul</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->time == '< 30 Menit' ? 'selected' : null) : null }}>
                        < 30 Menit</option>
                    <option
                        {{ $kunjungan->asesmen_ranap_keperawatan ? ($kunjungan->asesmen_ranap_keperawatan->time == '> 30 Menit' ? 'selected' : null) : null }}>
                        > 30 Menit</option>
                </x-adminlte-select>
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
                <x-adminlte-select2 name="keprihatinan_agama"
                    label="Mengungkapkan keprihatinan yang berhubungan dengan rawat inap" igroup-size="sm" multiple>
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
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" class="mr-auto" label="Simpan" type="submit" icon="fas fa-save"
            form="formAsesmenKeperawatan" />
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalAsesmenKeperawatan() {
            $.LoadingOverlay("show");
            $('#modalAsesmenKeperawatan').modal('show');
            $.LoadingOverlay("hide");
        }

        function printAsesmenKeperawatan() {
            var url = "{{ route('print_asesmen_ranap_keperawatan') }}?kode={{ $kunjungan->kode_kunjungan }}";
            window.open(url, '_blank');
        }
    </script>
@endpush
