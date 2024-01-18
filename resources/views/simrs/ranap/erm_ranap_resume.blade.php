<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colAnamnesa">
        <h3 class="card-title">
            Ringkasan Pasien Pulang
        </h3>
        <div class="card-tools">
            @if ($kunjungan->erm_ranap)
                Diisi oleh {{ $kunjungan->erm_ranap->pic1 }} <i class="fas fa-check-circle"></i>
            @else
                Belum diisi <i class="fas fa-times-circle"></i>
            @endif
        </div>
    </a>
    <div id="colAnamnesa" class="collapse" role="tabpanel" aria-labelledby="hAnamnesa">
        <div class="card-body">
            <form action="{{ route('simpan_resume_ranap') }}" name="formResume" id="formResume" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
                <div class="row">
                    <x-adminlte-textarea name="ringkasan_perawatan" fgroup-class="col-md-4" label="Ringkasan Perawatan"
                        rows="3" igroup-size="sm" placeholder="Ringkasan Perawatan">
                        {{ $kunjungan->erm_ranap->ringkasan_perawatan ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="riwayat_penyakit" fgroup-class="col-md-4" label="Riwayat Penyakit"
                        rows="3" igroup-size="sm" placeholder="Riwayat Penyakit">
                        {{ $kunjungan->erm_ranap->riwayat_penyakit ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="indikasi_ranap" fgroup-class="col-md-4" label="Indikasi Ranap"
                        rows="3" igroup-size="sm" placeholder="Indikasi Ranap">
                        {{ $kunjungan->erm_ranap->indikasi_ranap ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="pemeriksaan_fisik" fgroup-class="col-md-6" label="Pemeriksaan Fisik"
                        rows="4" igroup-size="sm" placeholder="Pemeriksaan Fisik">
                        {{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="suhu" class="col-sm-4 col-form-label">Suhu Tubuh</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="suhu" id="suhu"
                                            value="{{ $kunjungan->erm_ranap->suhu ?? null }}" placeholder="Suhu Tubuh">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tensi_darah" class="col-sm-4 col-form-label">Tekanan Darah</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="tensi_darah" id="tensi_darah"
                                            value="{{ $kunjungan->erm_ranap->tensi_darah ?? null }}"
                                            placeholder="Tekanan Darah">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="denyut_nadi" class="col-sm-4 col-form-label">Denyut Nadi</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="denyut_nadi" id="denyut_nadi"
                                            value="{{ $kunjungan->erm_ranap->denyut_nadi ?? null }}"
                                            placeholder="Denyut Nadi">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="pernapasan" class="col-sm-4 col-form-label">Pernapasan</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="pernapasan" id="pernapasan"
                                            value="{{ $kunjungan->erm_ranap->pernapasan ?? null }}"
                                            placeholder="Pernapasan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="berat_badan" class="col-sm-4 col-form-label">Berat Bdn Bayi</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="berat_badan" id="berat_badan"
                                            value="{{ $kunjungan->erm_ranap->berat_badan ?? null }}"
                                            placeholder="Berat Bdn Bayi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kesadaran" class="col-sm-4 col-form-label">Kesadaran</label>
                                    <div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control" name="kesadaran" id="kesadaran"
                                            value="{{ $kunjungan->erm_ranap->kesadaran ?? null }}"
                                            placeholder="Kesadaran">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <div class="col-md-4 text-center text-secondary">
                        <h5>Pemeriksaan Penunjang & Lainnya</h5>
                    </div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <x-adminlte-textarea name="catatan_laboratorium" fgroup-class="col-md-3"
                        label="Pemeriksaan Laboratorium" rows="3" igroup-size="sm"
                        placeholder="Pemeriksaan Laboratorium">
                        {{ $kunjungan->erm_ranap->catatan_laboratorium ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="catatan_radiologi" fgroup-class="col-md-3"
                        label="Pemeriksaan Radiologi" rows="3" igroup-size="sm"
                        placeholder="Pemeriksaan Radiologi">
                        {{ $kunjungan->erm_ranap->catatan_radiologi ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="catatan_penunjang" fgroup-class="col-md-3"
                        label="Pemeriksaan Penunjang Lainnya" rows="3" igroup-size="sm"
                        placeholder="Pemeriksaan Penunjang Lainnya">
                        {{ $kunjungan->erm_ranap->catatan_penunjang ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="hasil_konsultasi" fgroup-class="col-md-3" label="Hasil Konsultasi"
                        rows="3" igroup-size="sm" placeholder="Hasil Konsultasi">
                        {{ $kunjungan->erm_ranap->hasil_konsultasi ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-2">
                        <b>Pengambilan SHK</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Ya" id="shkya"
                                    name="pemeriksaan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pemeriksaan_shk == 'Ya' ? 'checked' : null) : null }}>
                                <label for="shkya" class="custom-control-label">Ya</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="shktidak"
                                    name="pemeriksaan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pemeriksaan_shk == 'Tidak' ? 'checked' : null) : null }}>
                                <label for="shktidak" class="custom-control-label">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <b>SHK Diambil Dari :</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak Diambil" id="shktidak"
                                    name="pengambilan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengambilan_shk == 'Tidak Diambil' ? 'checked' : null) : null }}>
                                <label for="shktidak" class="custom-control-label">Tidak Diambil</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Vena" id="shkvena"
                                    name="pengambilan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengambilan_shk == 'Vena' ? 'checked' : null) : null }}>
                                <label for="shkvena" class="custom-control-label">Vena</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tumit" id="shktumit"
                                    name="pengambilan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengambilan_shk == 'Tumit' ? 'checked' : null) : null }}>
                                <label for="shktumit" class="custom-control-label">Tumit</label>
                            </div>
                        </div>
                    </div>
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tanggal_shk" label="Tgl Pengambilan SHK"
                        value="{{ $kunjungan->erm_ranap->tanggal_shk ?? null }}" igroup-size="sm" :config="$config"
                        fgroup-class="col-md-2" />
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <div class="col-md-4 text-center text-secondary">
                        <h5>Diagnosa ICD 10 & Tindakan ICD-9 CM</h5>
                    </div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea name="diagnosa_masuk" label="Diagnosa Masuk" rows="3"
                            igroup-size="sm" placeholder="Diagnosa Masuk">
                            {{ $kunjungan->erm_ranap->diagnosa_masuk ?? null }}
                        </x-adminlte-textarea>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-textarea name="diagnosa_utama" label="Diagnosa Utama" rows="1"
                                    igroup-size="sm" placeholder="Diagnosa Utama">
                                    {{ $kunjungan->erm_ranap->diagnosa_utama ?? null }}
                                </x-adminlte-textarea>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-textarea name="diagnosa_icd10" label="Diagnosa ICD-10" rows="1"
                                    igroup-size="sm" placeholder="Diagnosa ICD-10">
                                    {{ $kunjungan->erm_ranap->diagnosa_icd10 ?? null }}
                                </x-adminlte-textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-textarea name="diagnosa_sekunder" label="Diagnosa Sekunder"
                                    rows="6" igroup-size="sm" placeholder="Diagnosa Sekunder">
                                    {{ $kunjungan->erm_ranap->diagnosa_sekunder ?? null }}
                                </x-adminlte-textarea>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-textarea name="diagnosa_icd10" label="Diagnosa ICD-10" rows="6"
                                    igroup-size="sm" placeholder="Diagnosa ICD-10">
                                    {{ $kunjungan->erm_ranap->diagnosa_icd10 ?? null }}
                                </x-adminlte-textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-textarea name="tindakan_operasi" label="Tindakan Operasi" rows="5"
                                    igroup-size="sm" placeholder="Tindakan Operasi">
                                    {{ $kunjungan->erm_ranap->tindakan_operasi ?? null }}
                                </x-adminlte-textarea>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-textarea name="tindakan_icd9" label="Tindakan Operasi ICD-9"
                                    rows="5" igroup-size="sm" placeholder="Tindakan ICD-9">
                                    {{ $kunjungan->erm_ranap->tindakan_icd9 ?? null }}
                                </x-adminlte-textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggal_operasi" label="Tgl Operasi"
                                        value="{{ $kunjungan->erm_ranap->tanggal_operasi ?? null }}" igroup-size="sm"
                                        :config="$config" fgroup-class="col-md-4" />
                                    @php
                                        $config = ['format' => 'HH:mm:ss'];
                                    @endphp
                                    <x-adminlte-input-date name="awal_operasi" label="Awal Operasi"
                                        value="{{ $kunjungan->erm_ranap->awal_operasi ?? null }}" igroup-size="sm"
                                        :config="$config" fgroup-class="col-md-4" />
                                    <x-adminlte-input-date name="akhir_operasi" label="Akhir Operasi"
                                        value="{{ $kunjungan->erm_ranap->akhir_operasi ?? null }}" igroup-size="sm"
                                        :config="$config" fgroup-class="col-md-4" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-textarea name="tindakan_prosedur" label="Tindakan Prosedur"
                                    rows="5" igroup-size="sm" placeholder="Tindakan Prosedur">
                                    {{ $kunjungan->erm_ranap->tindakan_prosedur ?? null }}
                                </x-adminlte-textarea>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-textarea name="tindakan_icd9" label="Tindakan Operasi ICD-9"
                                    rows="5" igroup-size="sm" placeholder="Tindakan ICD-9">
                                    {{ $kunjungan->erm_ranap->tindakan_icd9 ?? null }}
                                </x-adminlte-textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <div class="col-md-4 text-center text-secondary">
                        <h5>Pemulangan & Kondisi</h5>
                    </div>
                    <div class="col-md-4">
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <b>Cara Pulang</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Sembuh / Perbaikan"
                                    id="psembuh" name="cara_pulang"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->cara_pulang == 'Sembuh / Perbaikan' ? 'checked' : null) : null }}>
                                <label for="psembuh" class="custom-control-label">Sembuh / Perbaikan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="ppindahrs" value="Pindah RS"
                                    name="cara_pulang"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->cara_pulang == 'Pindah RS' ? 'checked' : null) : null }}>
                                <label for="ppindahrs" class="custom-control-label">Pindah RS</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="Pulang Paksa" type="radio"
                                    id="pplngpaksa" name="cara_pulang"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->cara_pulang == 'Pulang Paksa' ? 'checked' : null) : null }}>
                                <label for="pplngpaksa" class="custom-control-label">Pulang Paksa</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="Meninggal" type="radio" id="pmninggal"
                                    name="cara_pulang"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->cara_pulang == 'Meninggal' ? 'checked' : null) : null }}>
                                <label for="pmninggal" class="custom-control-label">Meninggal</label>
                            </div>
                            <x-adminlte-textarea name="cara_pulang_text" rows="2" igroup-size="sm"
                                placeholder="Keterangan Lainnya">
                                {{ $kunjungan->erm_ranap->cara_pulang_text ?? '' }}
                            </x-adminlte-textarea>
                        </div>
                    </div>
                    <x-adminlte-textarea name="kondisi_umum" label="Keadaan Umum" fgroup-class="col-md-3"
                        rows="5" igroup-size="sm" placeholder="Keadaan Umum">
                        {{ $kunjungan->erm_ranap->kondisi_umum ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="kondisi_pulang" label="Kondisi Pulang" fgroup-class="col-md-3"
                        rows="5" igroup-size="sm" placeholder="Kondisi Pulang">
                        {{ $kunjungan->erm_ranap->kondisi_pulang ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-3">
                        <b>Pengobatan Dilanjutkan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Poliklinik RSUD Waled"
                                    id="ppoli" name="pengobatan_lanjutan"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Poliklinik RSUD Waled' ? 'checked' : null) : null }}>
                                <label for="ppoli" class="custom-control-label">Poliklinik RSUD Waled</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="prslain" value="RS Lain"
                                    name="pengobatan_lanjutan"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengobatan_lanjutan == 'RS Lain' ? 'checked' : null) : null }}>
                                <label for="prslain" class="custom-control-label">RS Lain</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="Puskesmas" type="radio" id="ppuskesmas"
                                    name="pengobatan_lanjutan"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Puskesmas' ? 'checked' : null) : null }}>
                                <label for="ppuskesmas" class="custom-control-label">Puskesmas</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="Dokter Praktek" type="radio"
                                    id="pdokterpraktek" name="pengobatan_lanjutan"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Dokter Praktek' ? 'checked' : null) : null }}>
                                <label for="pdokterpraktek" class="custom-control-label">Dokter Praktek</label>
                            </div>
                            <x-adminlte-textarea name="pengobatan_lanjutan_text" rows="2" igroup-size="sm"
                                placeholder="Keterangan Lainnya">
                                {{ $kunjungan->erm_ranap->pengobatan_lanjutan_text ?? '' }}
                            </x-adminlte-textarea>
                        </div>
                    </div>
                    <x-adminlte-textarea name="instruksi_pulang" fgroup-class="col-md-4" label="Instruksi Pulang"
                        rows="5" igroup-size="sm" placeholder="Instruksi Pulang">
                        {{ $kunjungan->erm_ranap->instruksi_pulang ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="tanggal_kontrol" class="col-sm-3 col-form-label">Tgl Kontrol</label>
                            <div class="col-sm-9 input-group input-group-sm">
                                <input class="form-control" name="tanggal_kontrol" id="tanggal_kontrol"
                                    value="{{ $kunjungan->erm_ranap->tanggal_kontrol ?? null }}"
                                    placeholder="Tgl Kontrol">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kontrol_ke" class="col-sm-3 col-form-label">Kontrol Ke</label>
                            <div class="col-sm-9 input-group input-group-sm">
                                <input class="form-control" name="kontrol_ke" id="kontrol_ke"
                                    value="{{ $kunjungan->erm_ranap->kontrol_ke ?? null }}" placeholder="Kontrol Ke">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diet" class="col-sm-3 col-form-label">Diet</label>
                            <div class="col-sm-9 input-group input-group-sm">
                                <input class="form-control" name="diet" id="diet"
                                    value="{{ $kunjungan->erm_ranap->diet ?? null }}" placeholder="Diet">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="latihan" class="col-sm-3 col-form-label">Latihan</label>
                            <div class="col-sm-9 input-group input-group-sm">
                                <input class="form-control" name="latihan" id="latihan"
                                    value="{{ $kunjungan->erm_ranap->latihan ?? null }}" placeholder="Latihan">
                            </div>
                        </div>
                    </div>
                    <x-adminlte-textarea name="kembali_jika" fgroup-class="col-md-4" label="Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi"
                        rows="5" igroup-size="sm" placeholder="Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi">
                        {{ $kunjungan->erm_ranap->kembali_jika ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-6">
                        <x-adminlte-input name="nama_keluarga"
                            value="{{ $kunjungan->erm_ranap->nama_keluarga ?? null }}" label="Nama Keluarga"
                            igroup-size="sm" placeholder="Nama Keluarga" />
                        <x-adminlte-input name="nik_keluarga"
                            value="{{ $kunjungan->erm_ranap->nik_keluarga ?? null }}" label="NIK Keluarga"
                            igroup-size="sm" placeholder="NIK Keluarga" />
                    </div>
                    {{-- <x-adminlte-textarea name="tindakan" label="Tindakan / Prosedur" rows="3" igroup-size="sm"
                        placeholder="Tindakan / Prosedur">
                        {{ $kunjungan->erm_ranap->tindakan ?? null }}
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="tindakan_icd9" label="Tindakan Operasi ICD-9" rows="3"
                        igroup-size="sm" placeholder="Tindakan ICD-9">
                        {{ $kunjungan->erm_ranap->tindakan_icd9 ?? null }}
                    </x-adminlte-textarea> --}}
                    {{-- <div class="col-md-4">
                    </div> --}}
                </div>
                @if ($kunjungan->erm_ranap)
                    @if ($kunjungan->erm_ranap->status == 2)
                        <div class="btn btn-secondary"><i class="fas fa-check"></i> Sudah Diverifikasi</div>
                    @else
                        <button type="submit" form="formResume" class="btn btn-success">
                            <i class="fas fa-edit"></i> Edit \ Simpan
                        </button>
                    @endif
                @else
                    <button type="submit" form="formResume" class="btn btn-success">
                        <i class="fas fa-edit"></i> Edit \ Simpan
                    </button>
                @endif


                {{-- <a class="btn btn-primary"
                    href="{{ route('print_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}"><i
                        class="fas fa-save"></i> Final Resume</a> --}}
                <a class="btn btn-warning" target="_blank"
                    href="{{ route('print_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}"><i
                        class="fas fa-print"></i> Print</a>
            </form>
        </div>
    </div>
</div>
