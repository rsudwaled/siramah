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
    <div id="colAnamnesa" class="collapse show" role="tabpanel" aria-labelledby="hAnamnesa">
        <div class="card-body">
            <form action="{{ route('simpan_resume_ranap') }}" name="formResume" id="formResume" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea name="ringkasan_perawatan" label="Ringkasan Perawatan" rows="3"
                            igroup-size="sm" placeholder="Ringkasan Perawatan">
                            {{ $kunjungan->erm_ranap->ringkasan_perawatan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="riwayat_penyakit" label="Riwayat Penyakit" rows="3"
                            igroup-size="sm" placeholder="Riwayat Penyakit">
                            {{ $kunjungan->erm_ranap->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="indikasi_ranap" label="Indikasi Ranap" rows="3"
                            igroup-size="sm" placeholder="Indikasi Ranap">
                            {{ $kunjungan->erm_ranap->indikasi_ranap ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-textarea name="pemeriksaan_fisik" label="Pemeriksaan Fisik" rows="4"
                            igroup-size="sm" placeholder="Pemeriksaan Fisik">
                            {{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? null }}
                        </x-adminlte-textarea>
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
                                <input class="custom-control-input" type="radio" value="Tidak Diambil"
                                    id="shktidakx" name="pengambilan_shk"
                                    {{ $kunjungan->erm_ranap ? ($kunjungan->erm_ranap->pengambilan_shk == 'Tidak Diambil' ? 'checked' : null) : null }}>
                                <label for="shktidakx" class="custom-control-label">Tidak Diambil</label>
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
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <x-adminlte-input-date name="intubasi" label="Ventilator Intubasi"
                        value="{{ $kunjungan->erm_ranap->intubasi ?? null }}" igroup-size="sm" :config="$config"
                        fgroup-class="col-md-2" />
                    <x-adminlte-input-date name="extubasi" label="Ventilator Extubasi"
                        value="{{ $kunjungan->erm_ranap->extubasi ?? null }}" igroup-size="sm" :config="$config"
                        fgroup-class="col-md-2" />
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
                                <x-adminlte-input name="diagnosa_utama" label="Diagnosa Utama"
                                    placeholder="Diagnosa Utama" igroup-size="sm" enable-old-support required
                                    value="{{ $kunjungan->erm_ranap->diagnosa_utama ?? null }}" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-select2 name="icd10_utama" class="diagSekunderResume" igroup-size="sm"
                                    label="ICD-10 Utama">
                                    @if ($kunjungan->erm_ranap)
                                        @if ($kunjungan->erm_ranap->icd10_utama)
                                            <option value="{{ $kunjungan->erm_ranap->icd10_utama }}" selected>
                                                {{ $kunjungan->erm_ranap->icd10_utama }}</option>
                                        @endif
                                    @endif
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button theme="secondary" icon="fas fa-diagnoses" />
                                    </x-slot>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->diagnosa_sekunder)
                                <label>Diagnosa Sekunder </label>
                                @foreach (json_decode($kunjungan->erm_ranap->diagnosa_sekunder) as $key => $item)
                                    <div id="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="input-group col-md-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="diagnosa_sekunder[]" value="{{ $item }}"
                                                        placeholder="Diagnosa Sekunder" required>
                                                </div>
                                                <div class="input-group col-md-6">
                                                    <select name="icd10_sekunder[]"
                                                        class="form-control diagSekunderResume">
                                                        @if (json_decode($kunjungan->erm_ranap->icd10_sekunder)[$key] != '-|Belum Diisi')
                                                            <option
                                                                value="{{ json_decode($kunjungan->erm_ranap->icd10_sekunder)[$key] }}"
                                                                selected>
                                                                {{ json_decode($kunjungan->erm_ranap->icd10_sekunder)[$key] }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            onclick="hapusDiagSekunderResume(this)">
                                                            <i class="fas fa-trash "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="diagnosa_sekunder[]" placeholder="Diagnosa Sekunder">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd10_sekunder[]"
                                                    class="form-control diagSekunderResume">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addDiagSekunderResume()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="diagSekunderBaru"></div>
                            @else
                                <label>Diagnosa Sekunder </label>
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="diagnosa_sekunder[]" placeholder="Diagnosa Sekunder">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd10_sekunder[]"
                                                    class="form-control diagSekunderResume">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addDiagSekunderResume()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="diagSekunderBaru"></div>
                            @endif
                        @else
                            <label>Diagnosa Sekunder </label>
                            <div id="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <input type="text" class="form-control form-control-sm"
                                                name="diagnosa_sekunder[]" placeholder="Diagnosa Sekunder">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select name="icd10_sekunder[]" class="form-control diagSekunderResume">
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-xs btn-success"
                                                    onclick="addDiagSekunderResume()">
                                                    <i class="fas fa-plus "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="diagSekunderBaru"></div>
                        @endif
                    </div>
                    <div class="col-md-6">
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
                        {{-- tindakan operasi --}}
                        @if ($kunjungan->erm_ranap)
                            @if (is_array(json_decode($kunjungan->erm_ranap->tindakan_operasi)) ||
                                    is_object(json_decode($kunjungan->erm_ranap->tindakan_operasi)))
                                <label>Tindakan Operasi</label>
                                @foreach (json_decode($kunjungan->erm_ranap->tindakan_operasi) as $key => $item)
                                    <div id="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="input-group col-md-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="tindakan_operasi[]" value="{{ $item }}"
                                                        placeholder="Tindakan Operasi">
                                                </div>
                                                <div class="input-group col-md-6">
                                                    <select name="icd9_operasi[]" class="form-control icd9operasi">
                                                        @if (json_decode($kunjungan->erm_ranap->icd9_operasi)[$key] != '-|Belum Diisi')
                                                            <option
                                                                value="{{ json_decode($kunjungan->erm_ranap->icd9_operasi)[$key] }}"
                                                                selected>
                                                                {{ json_decode($kunjungan->erm_ranap->icd9_operasi)[$key] }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            onclick="hapusIcdOperasi(this)">
                                                            <i class="fas fa-trash "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="tindakan_operasi[]" placeholder="Tindakan Operasi">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd9_operasi[]" class="form-control icd9operasi">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addIcdOperasi()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="inputIcdOperasi"></div>
                            @else
                                <label>Tindakan Operasi</label>
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="tindakan_operasi[]" placeholder="Tindakan Operasi">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd9_operasi[]" class="form-control icd9operasi">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addIcdOperasi()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="inputIcdOperasi"></div>
                            @endif
                        @else
                            <label>Tindakan Operasi</label>
                            <div id="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <input type="text" class="form-control form-control-sm"
                                                name="tindakan_operasi[]" placeholder="Tindakan Operasi">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select name="icd9_operasi[]" class="form-control icd9operasi">
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-xs btn-success"
                                                    onclick="addIcdOperasi()">
                                                    <i class="fas fa-plus "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="inputIcdOperasi"></div>
                        @endif
                        {{-- tindakan prosedur --}}
                        @if ($kunjungan->erm_ranap)
                            @if (is_array(json_decode($kunjungan->erm_ranap->tindakan_prosedur)) ||
                                    is_object(json_decode($kunjungan->erm_ranap->tindakan_prosedur)))
                                <label>Tindakan Operasi</label>
                                @foreach (json_decode($kunjungan->erm_ranap->tindakan_prosedur) as $key => $item)
                                    <div id="row">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="input-group col-md-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="tindakan_prosedur[]" value="{{ $item }}"
                                                        placeholder="Tindakan Operasi">
                                                </div>
                                                <div class="input-group col-md-6">
                                                    <select name="icd9_prosedur[]" class="form-control icd9operasi">
                                                        @if (json_decode($kunjungan->erm_ranap->icd9_prosedur)[$key] != '-|Belum Diisi')
                                                            <option
                                                                value="{{ json_decode($kunjungan->erm_ranap->icd9_prosedur)[$key] }}"
                                                                selected>
                                                                {{ json_decode($kunjungan->erm_ranap->icd9_prosedur)[$key] }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            onclick="hapusIcdOperasi(this)">
                                                            <i class="fas fa-trash "></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="tindakan_prosedur[]" placeholder="Tindakan Prosedur">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd9_prosedur[]" class="form-control icd9operasi">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addIcdOperasi()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="inputIcdOperasi"></div>
                            @else
                                <label>Tindakan Prosedur</label>
                                <div id="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="input-group col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="tindakan_prosedur[]" placeholder="Tindakan Prosedur">
                                            </div>
                                            <div class="input-group col-md-6">
                                                <select name="icd9_prosedur[]" class="form-control icd9operasi">
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="addIcdTindakan()">
                                                        <i class="fas fa-plus "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="inputIcdTindakan"></div>
                            @endif
                        @else
                            <label>Tindakan Prosedur</label>
                            <div id="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <input type="text" class="form-control form-control-sm"
                                                name="tindakan_prosedur[]" placeholder="Tindakan Prosedur">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <select name="icd9_prosedur[]" class="form-control icd9operasi">
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-xs btn-success"
                                                    onclick="addIcdTindakan()">
                                                    <i class="fas fa-plus "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="inputIcdTindakan"></div>
                        @endif
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
                                @php
                                    $config = ['format' => 'YYYY-MM-DD'];
                                @endphp
                                <x-adminlte-input-date name="tanggal_kontrol"
                                    value="{{ $kunjungan->erm_ranap->tanggal_kontrol ?? null }}" igroup-size="sm"
                                    :config="$config" />
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
                    <x-adminlte-textarea name="kembali_jika" fgroup-class="col-md-4"
                        label="Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi" rows="5"
                        igroup-size="sm" placeholder="Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi">
                        {{ $kunjungan->erm_ranap->kembali_jika ?? null }}
                    </x-adminlte-textarea>
                    <div class="col-md-6">
                        <x-adminlte-input name="nama_keluarga"
                            value="{{ $kunjungan->erm_ranap->nama_keluarga ?? null }}" label="Nama Keluarga"
                            igroup-size="sm" placeholder="Nama Keluarga" />
                        <x-adminlte-input name="nik_keluarga"
                            value="{{ $kunjungan->erm_ranap->nik_keluarga ?? null }}" label="NIK Keluarga"
                            igroup-size="sm" placeholder="NIK Keluarga" />
                        <div class="btn btn-xs btn-secondary" onclick="btnttdPasien()"><i class="fas fa-check"></i>
                            Ttd
                            Dokter</div>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->ttd_keluarga)
                                Sudah di tanda tangani oleh dokter pada {{ $kunjungan->erm_ranap->waktu_ttd_keluarga }}
                            @endif
                        @endif
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="dpjp" value="{{ $kunjungan->dokter->nama_paramedis ?? null }}"
                            label="Dokter DPJP" igroup-size="sm" placeholder="Dokter DPJP" readonly />
                        <div class="btn btn-xs btn-secondary" onclick="btnttdDokter()"><i class="fas fa-check"></i>
                            Ttd Dokter</div>
                        @if ($kunjungan->erm_ranap)
                            @if ($kunjungan->erm_ranap->ttd_dokter)
                                Sudah di tanda tangani oleh dokter pada {{ $kunjungan->erm_ranap->waktu_ttd_dokter }}
                            @endif
                        @endif
                    </div>
                </div>
                <br>
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
<x-adminlte-modal id="modalttd" title="Tanda Tangan Resume Ranap" theme="warning" icon="fas fa-file-medical"
    size='lg'>
    <form id="formttd" action="" name="formttd" method="POST">
        @csrf
        <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" id="ttd_image64" name="image">
        <!-- partial:index.partial.html -->
        <div class="signature-component">
            <canvas id="signature-pad" width="400" height="200"></canvas>
            <div>
                <span class="btn btn-danger mt-1" id="clear">Clear</span>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <button class="btn btn-success mr-auto" onclick="simpanttd()"><i class="fas fa-save"></i>
            Simpan</button>
        <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('css')
    <link rel="stylesheet" href="{{ asset('signature/dist/signature-style.css') }}">
@endpush
@push('js')
    <script src="{{ asset('signature/dist/underscore-min.js') }}"></script>
    <script src="{{ asset('signature/dist/signature-script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#formResume").submit(function(event) {
                var diagSekunderKosong = $(".diagSekunderResume[name='icd10_sekunder[]']");
                diagSekunderKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });
                var icd9operasiKosong = $(".icd9operasi[name='icd9_operasi[]']");
                icd9operasiKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });
                var icd9prosedurKosong = $(".icd9operasi[name='icd9_prosedur[]']");
                icd9prosedurKosong.each(function() {
                    if ($(this).val().length === 0) {
                        $(this).append(
                            '<option value="-|Belum Diisi" selected>Belum Diisi</option>');
                        $(this).trigger('change.select2');
                    }
                });

            });
        });

        function simpanResume() {
            var unfilledSelects = $(".diagSekunderResume[name='icd10_sekunder[]']");
            unfilledSelects.each(function() {
                if ($(this).val().length === 0) {
                    $(this).append('<option value="-" selected>Belum Diisi</option>');
                    $(this).trigger('change.select2');
                }
            });
            $("#formResume").submit();
        }
    </script>
    <script>
        function btnttdDokter() {
            $.LoadingOverlay("show");
            $('#formttd').attr('action', "{{ route('ttd_dokter_resume_ranap') }}");
            $('#modalttd').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnttdPasien() {
            $.LoadingOverlay("show");
            $('#formttd').attr('action', "{{ route('ttd_pasien_resume_ranap') }}");
            $('#modalttd').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanttd() {
            var canvas = document.getElementById("signature-pad");
            var baseimage = canvas.toDataURL();
            $('#ttd_image64').val(baseimage);
            $("#formttd").submit();
        }
    </script>
    <script>
        function addDiagSekunderResume() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="diagnosa_sekunder[]" placeholder="Diagnosa Sekunder" required></div>' +
                '<div class="input-group col-md-6"><select name="icd10_sekunder[]" class="form-control diagSekunderResume"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusDiagSekunderResume(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div> </div>";
            $('#diagSekunderBaru').append(newRowAdd);
            $(".diagSekunderResume").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('get_diagnosis_eclaim') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        }

        function hapusDiagSekunderResume(button) {
            $(button).parents("#row").remove();
        }

        function addIcdOperasi() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="tindakan_operasi[]" placeholder="Tindakan Operasi" required></div>' +
                '<div class="input-group col-md-6"><select name="icd9_operasi[]" class="form-control icd9operasi"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusIcdOperasi(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div></div>";
            $('#inputIcdOperasi').append(newRowAdd);
            $(".icd9operasi").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('get_procedure_eclaim') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

        }

        function hapusIcdOperasi(button) {
            $(button).parents("#row").remove();
        }

        function addIcdTindakan() {
            newRowAdd = '<div id="row"><div class="form-group"><div class="row">' +
                '<div class="input-group col-md-6">' +
                '<input type="text" class="form-control form-control-sm" name="tindakan_prosedur[]" placeholder="Tindakan Prosedur" required></div>' +
                '<div class="input-group col-md-6"><select name="icd9_prosedur[]" class="form-control icd9operasi"></select>' +
                '<div class="input-group-append">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="hapusIcdOperasi(this)">' +
                '<i class="fas fa-trash"></i>' +
                "</button></div></div></div></div></div>";
            $('#inputIcdTindakan').append(newRowAdd);
            $(".icd9operasi").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('get_procedure_eclaim') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        }
    </script>
@endpush
