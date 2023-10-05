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
                        <li class="nav-item" id="btnload"><a class="nav-link" href="#tarifpelayanantab"
                                data-toggle="tab">Tarif</a>
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
@section('plugins.Sweetalert2', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
            $(".checkVentilator").hide();
            $(".checkTB").hide();
            $(".checkCovid").hide();
            $(".formbb").hide();
            $('.btnPasien').click(function() {
                $.LoadingOverlay("show");
                // identitas
                $('.namapasien').html($(this).data('namapasien'));
                $('.nama-id').val($(this).data('namapasien'));
                $('.norm').html($(this).data('norm'));
                $('.norm-id').val($(this).data('norm'));
                $('.nomorkartu').html($(this).data('nomorkartu'));
                $('.nomorkartu-id').val($(this).data('nomorkartu'));
                $(".gender-id").val($(this).data('gender'));
                $(".tgllahir-id").val($(this).data('tgllahir'));
                // kunjungan
                $('.kodekunjungan-id').val($(this).data('id'));
                $('.counter-id').val($(this).data('counter'));
                $(".dokter").html($(this).data('dokter'));
                $(".dokter-id").val($(this).data('dokter'));
                $(".sep").html($(this).data('nomorsep'));
                $(".nomorsep-id").val(null);
                $(".kelas").html($(this).data('kelas'));
                $('.kelasrawat-id').val($(this).data('kelas')).change();

                $(".tglmasuk-id").val($(this).data('tglmasuk'));
                $(".ruangan").html($(this).data('ruangan'));
                $(".kunjungan").html($(this).data('id') + "|" + $(this).data('counter'));
                $(".suratkontrol-html").html($(this).data('suratkontrol'));
                $(".nomorsuratkontrol-id").val($(this).data('suratkontrol'));

                var norm = $(this).data('norm');
                var counter = $(this).data('counter');
                var table = $('#tableRincian')
                    .DataTable();
                var tableObat = $('#tableObat')
                    .DataTable();
                var tablePenunjangPasien = $('#tablePenunjang')
                    .DataTable();
                table.rows().remove().draw();
                var urlRincian = "{{ route('api.eclaim.rincian_biaya_pasien') }}?counter=" +
                    counter + "&norm=" + norm;
                $.ajax({
                    url: urlRincian,
                    type: "GET",
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response.rincian,
                                function(key, value) {
                                    table.row.add([
                                            value.TGL,
                                            value.NAMA_UNIT,
                                            value.nama_group_vclaim,
                                            value.NAMA_TARIF,
                                            value.GRANTOTAL_LAYANAN.toLocaleString(
                                                'id-ID'),
                                        ])
                                        .draw(false);
                                    if (value.nama_group_vclaim === 'OBAT') {
                                        tableObat.row.add([
                                                value.TGL,
                                                value.NAMA_UNIT,
                                                value.NAMA_TARIF,
                                                value.GRANTOTAL_LAYANAN.toLocaleString(
                                                    'id-ID'),
                                            ])
                                            .draw(false);
                                    }
                                    if (value.nama_group_vclaim === 'LABORATORIUM') {
                                        tablePenunjangPasien.row.add([
                                                value.TGL,
                                                value.NAMA_UNIT,
                                                value.NAMA_TARIF,
                                                value.GRANTOTAL_LAYANAN.toLocaleString(
                                                    'id-ID'),
                                            ])
                                            .draw(false);
                                    }
                                });
                            $('.prosedur_non_bedah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_non_bedah.toLocaleString(
                                        'id-ID')
                                );
                            $('.tenaga_ahli')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .tenaga_ahli.toLocaleString(
                                        'id-ID')
                                );
                            $('.radiologi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .radiologi.toLocaleString(
                                        'id-ID')
                                );
                            $('.rehabilitasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .rehabilitasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat.toLocaleString(
                                        'id-ID')
                                );
                            $('.alkes')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .alkes.toLocaleString(
                                        'id-ID')
                                );
                            $('.prosedur_bedah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_bedah.toLocaleString(
                                        'id-ID')
                                );
                            $('.keperawatan')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .keperawatan.toLocaleString(
                                        'id-ID')
                                );
                            $('.laboratorium')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .laboratorium.toLocaleString(
                                        'id-ID')
                                );
                            $('.kamar_akomodasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .kamar_akomodasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat_kronis')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kronis.toLocaleString(
                                        'id-ID')
                                );
                            $('.bmhp')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .bmhp.toLocaleString(
                                        'id-ID')
                                );
                            $('.konsultasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .konsultasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.penunjang')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .penunjang.toLocaleString(
                                        'id-ID')
                                );
                            $('.pelayanan_darah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .pelayanan_darah.toLocaleString(
                                        'id-ID')
                                );
                            $('.rawat_intensif')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .rawat_intensif.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat_kemo')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kemo.toLocaleString(
                                        'id-ID')
                                );
                            $('.sewa_alat')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .sewa_alat.toLocaleString(
                                        'id-ID')
                                );
                            $('.tarif_rs')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .tarif_rs.toLocaleString(
                                        'id-ID')
                                );

                            $('#prosedur_non_bedah')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_non_bedah
                                );
                            $('#tenaga_ahli')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .tenaga_ahli
                                );
                            $('#radiologi')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .radiologi
                                );
                            $('#rehabilitasi')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .rehabilitasi
                                );
                            $('#obat')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .obat
                                );
                            $('#alkes')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .alkes
                                );
                            $('#prosedur_bedah')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_bedah
                                );
                            $('#keperawatan')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .keperawatan
                                );
                            $('#laboratorium')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .laboratorium
                                );
                            $('#kamar_akomodasi')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .kamar_akomodasi
                                );
                            $('#obat_kronis')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kronis
                                );
                            $('#bmhp')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .bmhp
                                );
                            $('#konsultasi')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .konsultasi
                                );
                            $('#penunjang')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .penunjang
                                );
                            $('#pelayanan_darah')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .pelayanan_darah
                                );
                            $('#rawat_intensif')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .rawat_intensif
                                );
                            $('#obat_kemo')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kemo
                                );
                            $('#sewa_alat')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .sewa_alat
                                );
                            $('#tarif_rs')
                                .val(
                                    data
                                    .response
                                    .rangkuman
                                    .tarif_rs
                                );

                            if (data.response.budget != null) {
                                $('.kode_inacbg')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .kode_cbg
                                    );
                                $('.description_inacbg')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .deskripsi
                                    );
                                $('.kelas')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .kelas
                                    );
                                $('.tarif_inacbg')
                                    .html(data.response.budget.tarif_inacbg.toLocaleString(
                                        'id-ID'));

                                $('.diagnosa_utama')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .diagnosa_utama
                                    );
                                $('.diagnosa_sekunder')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .diagnosa
                                    );
                                $('.pasien')
                                    .html(
                                        data
                                        .response
                                        .pasien
                                        .nama_px
                                    );
                                $('.kunjungan')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .rm_counter
                                    );
                                $('.rm_counter')
                                    .val(
                                        data
                                        .response
                                        .budget
                                        .rm_counter
                                    );

                                // cek tarif
                                var tarifrs = data.response.rangkuman.tarif_rs;
                                var tarifinacbg = data.response.budget.tarif_inacbg;
                                var kerugian = (tarifrs - tarifinacbg).toLocaleString('id-ID');
                                if (tarifrs > tarifinacbg) {
                                    swal.fire(
                                        'Peringatan Tarif',
                                        'Tarif RS (' + tarifrs +
                                        ') sudah melebihi Tarif INACBG (' + tarifinacbg +
                                        ') kerugian diperikirakan ' + kerugian,
                                        'warning'
                                    );
                                } else {
                                    swal.fire(
                                        'Informasi Tarif',
                                        'Tarif RS belum melebihi Tarif INACBG',
                                        'success'
                                    );
                                }
                            } else {
                                swal.fire(
                                    'Peringatan Groupping',
                                    'Silahkan lakukan groupping sebelum 3 hari dari tanggal masuk',
                                    'warning'
                                );
                            }
                        } else {
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        swal.fire(
                            'Error ' +
                            data
                            .responseJSON
                            .metadata
                            .code,
                            data
                            .responseJSON
                            .metadata
                            .message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
                $('#modalPasien').modal('show');
            });
            $('.btnCariSEP').click(function(e) {
                var nomorkartu = $('.nomorkartu-id').val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                if (value.jnsPelayanan == 1) {
                                    var jenispelayanan = "Rawat Inap";
                                }
                                if (value.jnsPelayanan == 2) {
                                    var jenispelayanan = "Rawat Jalan";
                                }
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    value.diagnosa,
                                    "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('.nomorsep-id').val(nomorsep);
                                $('#modalSEP').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.nomorsep-id').val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#poliKontrol').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli + " (" + value.persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('#poliKontrol').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('#poliKontrol').find(":selected").val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#kodeDokter').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('#kodeDokter').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnPrintSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
            $('.btnEditSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_edit') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
        });
    </script>
    {{-- search select2 --}}
    <script>
        $(function() {
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
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
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_procedures') }}",
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
            // $("#obat").select2({
            //     placeholder: 'Silahkan pilih obat',
            //     theme: "bootstrap4",
            //     ajax: {
            //         url: "{{ route('api.simrs.get_obats') }}",
            //         type: "get",
            //         dataType: 'json',
            //         delay: 100,
            //         data: function(params) {
            //             return {
            //                 search: params.term // search term
            //             };
            //         },
            //         processResults: function(response) {
            //             return {
            //                 results: response
            //             };
            //         },
            //         cache: true
            //     }
            // });
        });
    </script>
    {{-- dynamic input --}}
    <script>
        // row select diagnosa
        $("#rowAdder").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group">' +
                '<select name="diagnosa[]" class="form-control diagnosaID"></select>' +
                '<div class="input-group-append"><button type="button" class="btn btn-xs btn-danger" id="DeleteRow">' +
                '<i class="fas fa-trash "></i> Hapus </button></div>' +
                '</div></div></div>';
            $('#newinput').append(newRowAdd);
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
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
        });
        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#row").remove();
        })
        // row select tindakan
        $("#rowAddTindakan").click(function() {
            newRowAdd =
                '<div id="row" class="row"><div class="col-md-7"><div class="form-group"><div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text">' +
                '<i class="fas fa-hand-holding-medical "></i></span></div>' +
                '<select name="procedure[]" class="form-control procedure "></select></div></div></div>' +
                '<div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend">' +
                '<span class="input-group-text"><b>@</b></span></div><input type="number" class="form-control" value="1">' +
                '</div></div></div><div class="col-md-2"><button type="button" class="btn btn-danger" id="deleteRowTindakan"> ' +
                '<i class="fas fa-trash "></i> </button></div></div>';
            $('#newTindakan').append(newRowAdd);
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_procedures') }}",
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
        });
        $("body").on("click", "#deleteRowTindakan", function() {
            $(this).parents("#row").remove();
        })
    </script>
    {{-- checkbox --}}
    <script>
        function bayiFunc() {
            if ($('#bayi').is(":checked"))
                $(".formbb").show();
            else
                $(".formbb").hide();
        }

        function covidFunc() {
            if ($('#covid').is(":checked"))
                $(".checkCovid").show();
            else
                $(".checkCovid").hide();
        }

        function tbFunc() {
            if ($('#tb').is(":checked"))
                $(".checkTB").show();
            else
                $(".checkTB").hide();
        }

        function perawatanIcuFunc() {
            if ($('#perawatan_icu').is(":checked")) {
                $(".masuk_icu").show();
                $(".checkVentilator").show();
                $(".pake_ventilator").hide();
            } else {
                $(".masuk_icu").hide();
                $(".checkVentilator").hide();
                $(".pake_ventilator").hide();
            }
        }

        function pakeVentilatorFunc() {
            if ($('#ventilator').is(":checked"))
                $(".pake_ventilator").show();
            else
                $(".pake_ventilator").hide();
        }
    </script>
@endsection
