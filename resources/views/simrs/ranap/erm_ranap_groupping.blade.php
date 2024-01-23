<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cGroupping">
        <h3 class="card-title">
            Groupping E-Klaim
        </h3>
        <div class="card-tools">
            Rp. <span class="tarif_eklaim_html">-</span> <i class="fas fa-file-medical"></i>
        </div>
    </a>
    <div id="cGroupping" class="collapse" role="tabpanel">
        <div class="card-body">
            <form action="{{ route('claim_ranap_v3') }}" id="formGroupper" method="POST">
                @csrf
                <input type="hidden" name="counter" id="counter" class="counter-id"
                    value="{{ $kunjungan->counter }}">
                <input type="hidden" name="kodekunjungan" id="kodekunjungan" class="kodekunjungan-id"
                    value="{{ $kunjungan->kode_kunjungan }}">
                <div class="row">
                    <div class="col-md-4">
                        <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm" label="Nomor SEP"
                            placeholder="Nomor SEP" value="{{ $kunjungan->no_sep }}" readonly>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariSEP">
                                    <i class="fas fa-search"></i> Cari SEP
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" value="{{ $pasien->no_Bpjs }}"
                            igroup-size="sm" label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                        <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                            placeholder="No RM " value="{{ $pasien->no_rm }}" readonly />
                        <x-adminlte-input name="nama" class="nama-id" value="{{ $pasien->nama_px }}"
                            label="Nama Pasien" igroup-size="sm" placeholder="Nama Pasien" readonly />
                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                            placeholder="Nomor HP" />
                        <input type="hidden" name="gender" value="{{ $pasien->jenis_kelamin }}">
                        <input type="hidden" name="tgllahir" value="{{ $pasien->tgl_lahir }}">
                    </div>
                    <div class="col-md-4">
                        @php
                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                        @endphp
                        <x-adminlte-input-date name="tglmasuk" class="tglmasuk-id" label="Tgl Masuk"
                            value="{{ $kunjungan->tgl_masuk }}" igroup-size="sm" :config="$config" readonly />
                        <x-adminlte-input name="dokter_dpjp" class="dokter-id" label="Dokter DPJP"
                            value="{{ $kunjungan->dokter->nama_paramedis }}" igroup-size="sm" placeholder="Dokter DPJP"
                            readonly />
                        <x-adminlte-select name="kelas_rawat" class="kelasrawat-id" label="Kelas Rawat"
                            igroup-size="sm">
                            <option value="3" selected>Kelas 3</option>
                            <option value="2">Kelas 2</option>
                            <option value="1">Kelas 1</option>
                        </x-adminlte-select>
                        <x-adminlte-select name="cara_masuk" label="Cara Masuk" igroup-size="sm">
                            <option value="gp">Rujukan FKTP</option>
                            <option value="hosp-trans">Rujukan FKRTL</option>
                            <option value="mp">Rujukan Spesialis</option>
                            <option value="outp">Dari Rawat Jalan</option>
                            <option value="inp">Dari Rawat Inap</option>
                            <option value="emd">Dari Rawat Darurat</option>
                            <option value="born">Lahir di RS</option>
                            <option value="nursing">Rujukan Panti Jompo</option>
                            <option value="psych">Rujukan dari RS Jiwa</option>
                            <option value="rehab"> Rujukan Fasilitas Rehab</option>
                            <option value="other">Lain-lain</option>
                        </x-adminlte-select>
                        <x-adminlte-select name="discharge_status" label="Cara Pulang" igroup-size="sm">
                            <option value="1">Atas persetujuan dokter</option>
                            <option value="2">Dirujuk</option>
                            <option value="3">Atas permintaan sendiri</option>
                            <option value="4">Meninggal</option>
                            <option value="5">Lain-lain</option>
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="perawatan_icu"
                                    value="1" onchange="checkIcu();">
                                <label for="perawatan_icu" class="custom-control-label">Perawatan
                                    ICU</label>
                            </div>
                            <x-adminlte-input name="lama_icu" label="Lama ICU" fgroup-class="masuk_icu"
                                igroup-size="sm" placeholder="Lama hari ICU" type="number" />
                            <div class="custom-control custom-checkbox checkVentilator">
                                <input class="custom-control-input" type="checkbox" id="ventilator" value="1"
                                    onchange="checkVenti();">
                                <label for="ventilator" class="custom-control-label">Ventilator
                                    ICU</label>
                            </div>
                            <x-adminlte-input name="inkubasi" label="Tgl Inubasi"
                                fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                            <x-adminlte-input name="ekstubasi" label="Tgl Ekstubasi"
                                fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="bayi" value="1"
                                    onchange="checkBayi();">
                                <label for="bayi" class="custom-control-label">Bayi</label>
                            </div>
                            <x-adminlte-input name="berat_badan" label="Berat Badan (gram)" fgroup-class="formbb"
                                igroup-size="sm" placeholder="Berat Badan (gram)" />
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="tb" value="1"
                                    onchange="checkTB();">
                                <label for="tb" class="custom-control-label">Pasien
                                    TB</label>
                            </div>
                            <x-adminlte-input name="no_reg_tb" label="No Register TB" fgroup-class="checkTB"
                                placeholder="No Register TB" igroup-size="sm" />
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="covid" value="1"
                                    onchange="checkCovid();">
                                <label for="covid" class="custom-control-label">Pasien
                                    COVID-19</label>
                            </div>
                            <x-adminlte-input name="no_claim_covid" label="No Claim COVID-19"
                                fgroup-class="checkCovid" placeholder="No Claim COVID-19" igroup-size="sm" />
                        </div>
                        <x-adminlte-input name="sistole" value="{{ $groupping->sistole ?? null }}" label="Sistole"
                            igroup-size="sm" placeholder="Sistole" type="number" />
                        <x-adminlte-input name="diastole" value="{{ $groupping->diastole ?? null }}"
                            label="Diastole" igroup-size="sm" placeholder="Diastole" type="number" />
                    </div>
                </div>
                <div class="row">
                    {{-- diagnosa --}}
                    <div class="col-md-6">
                        <label class=" mb-2">Diagnosa ICD-10</label>
                        <button id="rowAdder" type="button" class="btn btn-xs btn-success  mb-2">
                            <span class="fas fa-plus">
                            </span> Tambah Diagnosa
                        </button>
                        @if ($groupping)
                            @if (is_array(json_decode($groupping->diagnosa)) || is_object(json_decode($groupping->diagnosa)))
                                @foreach (json_decode($groupping->diagnosa) as $item)
                                    <div id="row">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-diagnoses "></i>
                                                    </span>
                                                </div>
                                                <select name="diagnosa[]" class="form-control diagnosaID ">
                                                    <option value="{{ $item }}" selected>{{ $item }}
                                                    </option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-xs btn-danger "
                                                        id="DeleteRow">
                                                        <i class="fas fa-trash "></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <div id="row">
                                <div class="form-group">
                                    <select name="diagnosa[]" class="form-control diagnosaID ">
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-xs btn-danger " id="DeleteRow">
                                            <i class="fas fa-trash "></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div id="newinput"></div>
                    </div>
                    {{-- tindakan --}}
                    <div class="col-md-6">
                        <label class="mb-2">Tindakan ICD-9</label>
                        <button id="rowAddTindakan" type="button" class="btn btn-xs btn-success  mb-2">
                            <span class="fas fa-plus">
                            </span> Tambah Tindakan
                        </button>
                        @if ($groupping)
                            @if (is_array(json_decode($groupping->procedure)) || is_object(json_decode($groupping->procedure)))
                                @foreach (json_decode($groupping->procedure) as $item)
                                    <div id="row" class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select name="procedure[]" class="form-control procedure ">
                                                    <option value="{{ $item }}" selected>
                                                        {{ $item }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <b>@</b>
                                                        </span>
                                                    </div>
                                                    <input type="number" class="form-control" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                id="deleteRowTindakan">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <div id="row" class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-hand-holding-medical "></i>
                                                </span>
                                            </div>
                                            <select name="procedure[]" class="form-control procedure ">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <b>@</b>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger" id="deleteRowTindakan">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div id="newTindakan"></div>
                    </div>
                </div>
            </form>
            <x-adminlte-button theme="success" class="mr-auto withLoad" label="Groupper" type="submit"
                icon="fas fa-diagnose" form="formGroupper" />
        </div>
    </div>
</div>
