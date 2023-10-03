@extends('adminlte::page')
@section('title', 'Rawat Inap ' . $kunjungan->pasien->nama_px)
@section('content_header')
    <h1>Rawat Inap {{ $kunjungan->pasien->nama_px }} </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h6 class="text-center">
                        {{ $kunjungan->pasien->nama_px }}
                    </h6>
                    <p class="text-muted text-center">
                        {{ $kunjungan->pasien->no_rm }}
                    </p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <dl>
                                <dt>No RM</dt>
                                <dd>
                                    {{ $kunjungan->pasien->no_rm }}
                                </dd>
                                <dt>No BPJS</dt>
                                <dd>
                                    {{ $kunjungan->pasien->no_Bpjs }}
                                </dd>
                                <dt>NIK</dt>
                                <dd>
                                    {{ $kunjungan->pasien->nik_bpjs }}
                                </dd>
                            </dl>
                        </li>
                        <li class="list-group-item">
                            <dl>
                                <dt>Ruangan</dt>
                                <dd>
                                    {{ $kunjungan->unit->nama_unit }}
                                </dd>
                                <dt>Kelas</dt>
                                <dd>
                                    {{ $kunjungan->kelas }}
                                </dd>
                                <dt>SEP</dt>
                                <dd>
                                    {{ $kunjungan->no_sep }}
                                </dd>
                                <dt>Dokter DPJP</dt>
                                <dd>
                                    {{ $kunjungan->dokter->nama_paramedis }}
                                </dd>
                            </dl>
                        </li>
                        <li class="list-group-item">
                            <dl>
                                <dt>Tarif RS</dt>
                                <dd>{{ money($budget->rangkuman->tarif_rs, 'IDR') }}</dd>
                                <dt>Tarif INACBG</dt>
                                <dd>{{ $budget->budget ? money($budget->budget->tarif_inacbg, 'IDR') : 'Belum Groupping' }}
                                </dd>
                                <dt>Diagnosa Utama</dt>
                                <dd>{{ $budget->budget ? $budget->budget->diagnosa_utama : 'Belum Groupping' }}</dd>
                                <dt>Diagnosa Sekunder</dt>
                                <dd>{{ $budget->budget ? $budget->budget->diagnosa : 'Belum Groupping' }}</dd>
                                <dt>Kode INACBG</dt>
                                <dd>{{ $budget->budget ? $budget->budget->kode_cbg : 'Belum Groupping' }}</dd>
                                <dt>Keterangan</dt>
                                <dd>{{ $budget->budget ? $budget->budget->deskripsi : 'Belum Groupping' }}</dd>
                            </dl>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#grouppingtab" data-toggle="tab">Groupping</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#tarifpelayanantab" data-toggle="tab">Tarif</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#obatPasien">Obat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#penunjangPasien">Penunjang</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#suratkontroltab" data-toggle="tab">Surat
                                Kontrol</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#pemulangantab" data-toggle="tab">Pemulangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#verifikasi">Verfikasi</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="grouppingtab">
                            Groupping Pasien
                            <form action="{{ route('claim_ranap') }}" id="formGroupper" method="POST">
                                @csrf
                                <input type="hidden" name="counter" id="counter" class="counter-id" value="">
                                <input type="hidden" name="kodekunjungan" id="kodekunjungan" class="kodekunjungan-id"
                                    value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                            label="Nomor SEP" placeholder="Nomor SEP" readonly>
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSEP">
                                                    <i class="fas fa-search"></i> Cari SEP
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('simrs.ranap.identitas')
                                    </div>

                                    <div class="col-md-4">
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                        @endphp
                                        <x-adminlte-input-date name="tglmasuk" class="tglmasuk-id" label="Tgl Masuk"
                                            igroup-size="sm" :config="$config" readonly />
                                        <x-adminlte-input name="dokter_dpjp" class="dokter-id" label="Dokter DPJP"
                                            igroup-size="sm" placeholder="Dokter DPJP" readonly />
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
                                                    value="1" onchange="perawatanIcuFunc();">
                                                <label for="perawatan_icu" class="custom-control-label">Perawatan
                                                    ICU</label>
                                            </div>
                                            <x-adminlte-input name="lama_icu" label="Lama ICU" fgroup-class="masuk_icu"
                                                igroup-size="sm" placeholder="Lama hari ICU" type="number" />
                                            <div class="custom-control custom-checkbox checkVentilator">
                                                <input class="custom-control-input" type="checkbox" id="ventilator"
                                                    value="1" onchange="pakeVentilatorFunc();">
                                                <label for="ventilator" class="custom-control-label">Ventilator
                                                    ICU</label>
                                            </div>
                                            <x-adminlte-input name="intubasi" label="Tgl Intubasi"
                                                fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                                            <x-adminlte-input name="ekstubasi" label="Tgl Ekstubasi"
                                                fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="bayi"
                                                    value="1" onchange="bayiFunc();">
                                                <label for="bayi" class="custom-control-label">Bayi</label>
                                            </div>
                                            <x-adminlte-input name="berat_badan" label="Berat Badan"
                                                fgroup-class="formbb" igroup-size="sm" placeholder="Berat Badan" />
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="tb"
                                                    value="1" onchange="tbFunc();">
                                                <label for="tb" class="custom-control-label">Pasien
                                                    TB</label>
                                            </div>
                                            <x-adminlte-input name="no_reg_tb" label="No Register TB"
                                                fgroup-class="checkTB" placeholder="No Register TB" igroup-size="sm" />
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="covid"
                                                    value="1" onchange="covidFunc();">
                                                <label for="covid" class="custom-control-label">Pasien
                                                    COVID-19</label>
                                            </div>
                                            <x-adminlte-input name="no_claim_covid" label="No Claim COVID-19"
                                                fgroup-class="checkCovid" placeholder="No Claim COVID-19"
                                                igroup-size="sm" />
                                        </div>
                                        <x-adminlte-input name="sistole" label="Sistole" igroup-size="sm"
                                            placeholder="Sistole" type="number" />
                                        <x-adminlte-input name="distole" label="Diastole" igroup-size="sm"
                                            placeholder="Diastole" type="number" />
                                    </div>
                                </div>
                                {{-- diagnosa --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- multipe diagnosa --}}
                                        <br><br>
                                        <h6>Diagnosa & Tindakan</h6>
                                        <label class=" mb-2">Diagnosa ICD-10</label>
                                        <button id="rowAdder" type="button" class="btn btn-xs btn-success  mb-2">
                                            <span class="fas fa-plus">
                                            </span> Tambah Diagnosa
                                        </button>
                                        <div id="row">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <select name="diagnosa[]" class="form-control diagnosaID ">
                                                    </select>
                                                    <div class="input-group-append"><button type="button"
                                                            class="btn btn-xs btn-warning ">
                                                            <i class="fas fa-diagnoses "></i> Diagnosa
                                                            Utama </button></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="newinput"></div>
                                        {{-- multipe tindakan --}}
                                        <label class="mb-2">Tindakan ICD-9</label>
                                        <button id="rowAddTindakan" type="button" class="btn btn-xs btn-success  mb-2">
                                            <span class="fas fa-plus">
                                            </span> Tambah Tindakan
                                        </button>
                                        <div id="rowTindakan" class="row">
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
                                                <button type="button" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-hand-holding-medical "></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="newTindakan"></div>
                                    </div>
                                </div>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
                                </x-slot>
                            </form>
                            <x-adminlte-button theme="success" class="mr-auto withLoad" label="Groupper" type="submit"
                                form="formGroupper" />
                        </div>
                        <div class="tab-pane" id="tarifpelayanantab">
                            Tarif pelayanan
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">Prosedur Bedah</dt>
                                        <dd class="col-sm-7">: <span class="prosedur_non_bedah"></span></dd>
                                        <dt class="col-sm-5">Prosedur Non Bedah</dt>
                                        <dd class="col-sm-7">: <span class="prosedur_bedah"></span></dd>
                                        <dt class="col-sm-5">Tenaga Ahli</dt>
                                        <dd class="col-sm-7">: <span class="tenaga_ahli"></span></dd>
                                        <dt class="col-sm-5">radiologi</dt>
                                        <dd class="col-sm-7">: <span class="radiologi"></span></dd>
                                        <dt class="col-sm-5">laboratorium</dt>
                                        <dd class="col-sm-7">: <span class="laboratorium"></span></dd>
                                        <dt class="col-sm-5">rehabilitasi</dt>
                                        <dd class="col-sm-7">: <span class="rehabilitasi"></span></dd>
                                        <dt class="col-sm-5">sewa_alat</dt>
                                        <dd class="col-sm-7">: <span class="sewa_alat"></span></dd>
                                        <dt class="col-sm-5">keperawatan</dt>
                                        <dd class="col-sm-7">: <span class="keperawatan"></span></dd>
                                        <dt class="col-sm-5">kamar_akomodasi</dt>
                                        <dd class="col-sm-7">: <span class="kamar_akomodasi"></span></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">penunjang</dt>
                                        <dd class="col-sm-7">: <span class="penunjang"></span></dd>
                                        <dt class="col-sm-5">konsultasi</dt>
                                        <dd class="col-sm-7">: <span class="konsultasi"></span></dd>
                                        <dt class="col-sm-5">pelayanan_darah</dt>
                                        <dd class="col-sm-7">: <span class="pelayanan_darah"></span></dd>
                                        <dt class="col-sm-5">rawat_intensif</dt>
                                        <dd class="col-sm-7">: <span class="rawat_intensif"></span></dd>
                                        <dt class="col-sm-5">obat</dt>
                                        <dd class="col-sm-7">: <span class="obat"></span></dd>
                                        <dt class="col-sm-5">alkes</dt>
                                        <dd class="col-sm-7">: <span class="alkes"></span></dd>
                                        <dt class="col-sm-5">bmhp</dt>
                                        <dd class="col-sm-7">: <span class="bmhp"></span></dd>
                                        <dt class="col-sm-5">obat_kronis</dt>
                                        <dd class="col-sm-7">: <span class="obat_kronis"></span></dd>
                                        <dt class="col-sm-5">obat_kemo</dt>
                                        <dd class="col-sm-7">: <span class="obat_kemo"></span></dd>
                                        <dt class="col-sm-5">tarif_rs</dt>
                                        <dd class="col-sm-7">: <span class="tarif_rs"></span></dd>
                                    </dl>
                                </div>
                                <div class="col-md-12">
                                    @php
                                        $heads = ['TGL', 'NAMA_UNIT', 'GROUP_VCLAIM', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                    @endphp
                                    <x-adminlte-datatable id="tableRincian" class="nowrap text-xs" :heads="$heads"
                                        :config="$config" bordered hoverable compressed>
                                        @foreach ($budget->rincian as $item)
                                            <tr>
                                                <td>{{ $item->TGL }}</td>
                                                <td>{{ $item->NAMA_UNIT }}</td>
                                                <td>{{ $item->nama_group_vclaim }}</td>
                                                <td>{{ $item->NAMA_TARIF }}</td>
                                                <td>{{ money($item->GRANTOTAL_LAYANAN, 'IDR') }}</td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="obatPasien">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $heads = ['TGL', 'NAMA_UNIT', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                    @endphp
                                    <x-adminlte-datatable id="tableObat" class="nowrap text-xs" :heads="$heads"
                                        :config="$config" bordered hoverable compressed>
                                        @foreach (collect($budget->rincian)->where('nama_group_vclaim', '==', 'OBAT') as $item)
                                            <tr>
                                                <td>{{ $item->TGL }}</td>
                                                <td>{{ $item->NAMA_UNIT }}</td>
                                                <td>{{ $item->NAMA_TARIF }}</td>
                                                <td>{{ money($item->GRANTOTAL_LAYANAN, 'IDR') }}</td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="penunjangPasien">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $heads = ['TGL', 'NAMA_UNIT', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                    @endphp
                                    <x-adminlte-datatable id="tablePenunjang" class="nowrap text-xs" :heads="$heads"
                                        :config="$config" bordered hoverable compressed>
                                        @foreach (collect($budget->rincian)->where('nama_group_vclaim', '==', 'LABORATORIUM') as $item)
                                            <tr>
                                                <td>{{ $item->TGL }}</td>
                                                <td>{{ $item->NAMA_UNIT }}</td>
                                                <td>{{ $item->NAMA_TARIF }}</td>
                                                <td>{{ money($item->GRANTOTAL_LAYANAN, 'IDR') }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach (collect($budget->rincian)->where('nama_group_vclaim', '==', 'RADIOLOGI') as $item)
                                            <tr>
                                                <td>{{ $item->TGL }}</td>
                                                <td>{{ $item->NAMA_UNIT }}</td>
                                                <td>{{ $item->NAMA_TARIF }}</td>
                                                <td>{{ money($item->GRANTOTAL_LAYANAN, 'IDR') }}</td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="suratkontroltab">
                            <x-adminlte-alert theme="warning" icon="fas fa-info-circle" title="Surat Kontrol Pasien">
                                Nomor Surat Kontrol Pasien : <b><span class="suratkontrol-html">Belum Dibuatkan Surat
                                        Kontrol</span></b>
                                <br><br>
                                <input type="hidden" name="nomorsuratkontrol" class="nomorsuratkontrol-id"
                                    value="">
                                <button class="btn btn-xs btn-success btnPrintSuratKontrol">Print Surat
                                    Kontrol</button>
                                <button class="btn btn-xs btn-primary btnEditSuratKontrol">Edit Surat Kontrol</button>
                            </x-adminlte-alert>
                            <form action="{{ route('suratkontrol_simpan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="counter" id="counter" class="counter-id" value="">
                                <input type="hidden" name="kodekunjungan" id="kodekunjungan" class="kodekunjungan-id"
                                    value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        @include('simrs.ranap.identitas')
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                            label="Nomor SEP" placeholder="Nomor SEP" readonly>
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSEP">
                                                    <i class="fas fa-search"></i> Cari SEP
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                            label="Tanggal Rencana Kontrol" value="{{ $request->tglRencanaKontrol }}"
                                            placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariPoli">
                                                    <i class="fas fa-search"></i> Cari Poli
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                        <x-adminlte-select igroup-size="sm" name="poliKontrol" label="Poliklinik">
                                            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariDokter">
                                                    <i class="fas fa-search"></i> Cari Dokter
                                                </div>
                                            </x-slot>
                                        </x-adminlte-select>
                                        <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                                            <option selected disabled>Silahkan Klik Cari Dokter</option>
                                        </x-adminlte-select>
                                        <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                            placeholder="Catatan Pasien" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-save"></i>
                                    Buat
                                    Surat Kontrol</button>
                            </form>
                        </div>
                        <div class="tab-pane" id="pemulangantab">
                            Pemulangan Pasien
                            <form action="{{ route('pemulangan_sep_pasien') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" class="kodebooking-id">
                                <div class="row">
                                    <div class="col-md-6">
                                        @include('simrs.ranap.identitas')
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="noSep" class="nomorsep-id" igroup-size="sm"
                                            label="Nomor SEP" placeholder="Nomor SEP" readonly>
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSEP">
                                                    <i class="fas fa-search"></i> Cari SEP
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-select igroup-size="sm" name="statusPulang" label="Alasan Pulang">
                                            <option selected disabled>Pilih Alasan Pulang</option>
                                            <option value="1">Atas Persetujuan Dokter</option>
                                            <option value="3">Atas Permintaan Sendiri</option>
                                            <option value="4">Meninggal</option>
                                            <option value="5">Lain-lain</option>
                                        </x-adminlte-select>
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tglPulang" igroup-size="sm" label="Tanggal Pulang"
                                            value="{{ now()->format('Y-m-d') }}" placeholder="Pilih Tanggal Pulang"
                                            :config="$config" />
                                        <p class="text-danger">Isi Jika Pasien Meninggal</p>
                                        <x-adminlte-input-date name="tglMeninggal" igroup-size="sm"
                                            label="Tanggal Meninggal" placeholder="Pilih Tanggal Meninggal"
                                            :config="$config" />
                                        <x-adminlte-input name="noSuratMeninggal" class="suratmeninggal-id"
                                            igroup-size="sm" label="Nomor Surat Meninggal"
                                            placeholder="Nomor Surat Meninggal" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning withLoad">
                                    <i class="fas fa-save"></i> Pulangkan Pasien</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="verifikasi">
                            <form action="{{ route('update_claim') }}" id="formUpdateClaim" method="POST">
                                @csrf
                                <input type="hidden" name="rm_counter" class="rm_counter">
                                <x-adminlte-textarea name="saran" label="Saran Verifikasi" placeholder="Saran..." />
                                <x-adminlte-select name="status" label="Status Verifikasi">
                                    <option value="0">Belum Verifikasi</option>
                                    <option value="99">Perbaiki</option>
                                    <option selected value="1">Verfikasi Casemix Ruangan</option>
                                    <option value="2">Verifikasi Casemix RS</option>
                                </x-adminlte-select>
                                <x-adminlte-input igroup-size="sm" name="user" label="User Verifikasi"
                                    value="{{ Auth::user()->name }}" readonly />
                                <x-adminlte-button theme="success" class="mr-auto" label="Groupper" type="submit"
                                    form="formUpdateClaim" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
