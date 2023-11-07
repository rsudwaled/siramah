@extends('adminlte::page')
@section('title', 'ERM Rawat Inap')
@section('content_header')
    <h1>ERM Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('kunjunganranapaktif') }}?kodeunit={{ $kunjungan->kode_unit }}"
                class="btn btn-sm mb-2 btn-danger withLoad"><i class="fas fa-arrow-left"></i> Kembali</a>
            @include('simrs.ranap.erm_ranap_profil')
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayat --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRiwayat"
                                aria-expanded="true">
                                <h3 class="card-title">
                                    Riwayat Kunjungan
                                </h3>
                            </a>
                            <div id="cRiwayat" class="show collapse" role="tabpanel">
                                <div class="card-body">
                                    @php
                                        $heads = ['Data Registrasi', 'Anamnesa', 'Penunjang', 'Pemeriksaan Dokter', 'Obat'];
                                        $config['searching'] = false;
                                        $config['ordering'] = false;
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['scrollY'] = '500px';
                                    @endphp
                                    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered
                                        hoverable compressed>
                                        @foreach ($pasien->kunjungans->sortByDesc('tgl_masuk') as $item)
                                            <tr>
                                                <td width="10%">
                                                    {{ $item->counter }} / {{ $item->kode_kunjungan }} <br>
                                                    {{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d/m/Y h:m:s') }}
                                                    @if ($item->tgl_keluar)
                                                        - {{ $item->tgl_keluar }}
                                                    @endif <br>
                                                    <b> {{ $item->unit->nama_unit }}</b><br>
                                                    {{ $item->dokter->nama_paramedis }}<br>
                                                    @if ($item->status_kunjungan == 1)
                                                        <span class="badge badge-success">Kunjungan Aktif</span>
                                                    @endif
                                                </td>
                                                <td width="30%">
                                                    @if ($item->assesmen_perawat)
                                                        <dl>
                                                            <dt>Keluhan Utama :</dt>
                                                            <dd>
                                                                {{ $item->assesmen_perawat->keluhanutama }}
                                                            </dd>
                                                            <dt>Tanda Vital :</dt>
                                                            <dd>
                                                                Tekanan Darah : {{ $item->assesmen_perawat->tekanandarah }}
                                                                <br>
                                                                Frekuensi Nadi :
                                                                {{ $item->assesmen_perawat->frekuensinadi }} <br>
                                                                Frekuensi Nafas :
                                                                {{ $item->assesmen_perawat->frekuensinapas }} <br>
                                                                Tinggi / Berat Badan :
                                                                {{ $item->assesmen_perawat->tinggibadan }} cm /
                                                                {{ $item->assesmen_perawat->beratbadan }} kg<br>
                                                                Suhu Tubuh :
                                                                {{ $item->assesmen_perawat->suhutubuh }} <br>
                                                            </dd>
                                                            <dt>Rencana Keperawatan :</dt>
                                                            <dd>
                                                                {{ $item->assesmen_perawat->rencanakeperawatan }}
                                                            </dd>
                                                            <dt>Tindakan Keperawatan :</dt>
                                                            <dd>
                                                                {{ $item->assesmen_perawat->tindakankeperawatan }}
                                                            </dd>
                                                            <dt>Diagnosis Keperawatan :</dt>
                                                            <dd>
                                                                {{ $item->assesmen_perawat->diagnosis }}
                                                            </dd>
                                                        </dl>
                                                    @endif
                                                </td>
                                                <td width="10%">
                                                    @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                                                        <div class="btn btn-xs btn-primary btnHasilLab"
                                                            data-fileurl="http://192.168.2.74/smartlab_waled/his/his_report?hisno={{ $lab->kode_layanan_header }}">
                                                            Hasil {{ $lab->kode_layanan_header }}</div>
                                                        <br>
                                                        @foreach ($lab->layanan_details as $laydet)
                                                            - {{ $laydet->tarif_detail->tarif->NAMA_TARIF }} <br>
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                                <td width="30%">
                                                    @if ($item->assesmen_dokter)
                                                        <dl>
                                                            <dt>Diagnosa </dt>
                                                            <dd>Diagnosa Kerja :
                                                                {{ $item->assesmen_dokter->diagnosakerja }} <br>
                                                                Diagnosa Banding :
                                                                {{ $item->assesmen_dokter->diagnosabanding }}</dd>
                                                            <dt>Rencana Kerja </dt>
                                                            <dd>{{ $item->assesmen_dokter->rencanakerja }}</dd>
                                                            <dt>Keluhan Pasien </dt>
                                                            <dd>{{ $item->assesmen_dokter->keluhan_pasien }}</dd>
                                                            <dt>Keluhan Pasien </dt>
                                                            <dd>{{ $item->assesmen_dokter->pemeriksaan_fisik }}</dd>
                                                            <dt>Tindak Lanjut </dt>
                                                            <dd>{{ $item->assesmen_dokter->tindak_lanjut }} <br>
                                                                {{ $item->assesmen_dokter->keterangan_tindak_lanjut }}
                                                            </dd>
                                                            <dt>Tindak Lanjut </dt>
                                                            <dd>{{ $item->assesmen_dokter->tindakanmedis }}</dd>
                                                        </dl>
                                                    @endif
                                                    {{-- {{ $item->assesmen_dokter }} --}}
                                                </td>
                                                <td width="20%">
                                                    @foreach ($item->layanans->whereIn('kode_unit', ['4008', '4002', '4010']) as $obat)
                                                        @foreach ($obat->layanan_details as $laydet)
                                                            @if ($laydet->barang)
                                                                <b>{{ $laydet->barang->nama_barang }}</b><br>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                        <x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
                            icon="fas fa-file-medical" size="xl">
                            <iframe id="dataHasilLab" src="" height="600px" width="100%"
                                title="Iframe Example"></iframe>
                            <x-slot name="footerSlot">
                                <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
                                    <i class="fas fa-download "></i>Download</a>
                                <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
                            </x-slot>
                        </x-adminlte-modal>
                        {{-- rincian --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRincian">
                                <h3 class="card-title">
                                    Rincian Biaya
                                </h3>
                            </a>
                            <div id="cRincian" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <table class="table table-bordered table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tanggal
                                                <th>Nama Unit</th>
                                                <th>Group Vclaim</th>
                                                <th>Nama Tarif</th>
                                                <th>Grand Total Tarif</th>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($pasien->kunjungans->where('counter', $kunjungan->counter) as $kjg)
                                                @foreach ($kjg->layanans->where('status_retur', 'OPN') as $item)
                                                    <tr>
                                                        <td>{{ $item->tgl_entry }}</td>
                                                        <td>{{ $item->kode_layanan_header }}</td>
                                                        <td>{{ money($item->total_layanan, 'IDR') }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    $total = $total + $kjg->layanans->where('status_retur', 'OPN')->sum('total_layanan');
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{ money($total, 'IDR') }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            {{-- @foreach ($kjg->layanans as $item)
                                                <tr>
                                                    <td>{{ $item->tgl_entry }}</td>
                                                    <td>{{ $item->kode_layanan_header }}</td>
                                                    <td>{{ money($item->total_layanan, 'IDR') }}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{ money($kunjungan->layanans->sum('total_layanan'), 'IDR') }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- icare --}}
                        {{-- <div class="card card-info mb-1">
                            <div class="card-header" role="tab">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#cIcare" aria-expanded="true">
                                        I-Care JKN
                                    </a>
                                </h3>
                            </div>
                            <div id="cIcare" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    @if ($urlicare)
                                        <iframe src="{{ $urlicare }}" width="100%" height="500px"
                                            frameborder="0"></iframe>
                                        {{ $messageicare }}
                                    @else
                                        Mohon Maaf ! {{ $messageicare }}
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                        {{-- groupping --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cGroupping">
                                <h3 class="card-title">
                                    Groupping E-Klaim
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->budget)
                                        Sudah Groupping
                                        {{ $kunjungan->budget->updated_at }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Groupping <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cGroupping" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="{{ route('claim_ranap_v2') }}" id="formGroupper" method="POST">
                                        @csrf
                                        <input type="hidden" name="counter" id="counter" class="counter-id"
                                            value="{{ $kunjungan->counter }}">
                                        <input type="hidden" name="kodekunjungan" id="kodekunjungan"
                                            class="kodekunjungan-id" value="{{ $kunjungan->kode_kunjungan }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                    label="Nomor SEP" placeholder="Nomor SEP"
                                                    value="{{ $kunjungan->no_sep }}" readonly>
                                                    <x-slot name="appendSlot">
                                                        <div class="btn btn-primary btnCariSEP">
                                                            <i class="fas fa-search"></i> Cari SEP
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                    value="{{ $pasien->no_Bpjs }}" igroup-size="sm" label="Nomor Kartu"
                                                    placeholder="Nomor Kartu" readonly />
                                                <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                    igroup-size="sm" placeholder="No RM " value="{{ $pasien->no_rm }}"
                                                    readonly />
                                                <x-adminlte-input name="nama" class="nama-id"
                                                    value="{{ $pasien->nama_px }}" label="Nama Pasien" igroup-size="sm"
                                                    placeholder="Nama Pasien" readonly />
                                                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                    igroup-size="sm" placeholder="Nomor HP" />
                                                <input type="hidden" name="gender"
                                                    value="{{ $pasien->jenis_kelamin }}">
                                                <input type="hidden" name="tgllahir" value="{{ $pasien->tgl_lahir }}">
                                            </div>
                                            <div class="col-md-4">
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                                @endphp
                                                <x-adminlte-input-date name="tglmasuk" class="tglmasuk-id"
                                                    label="Tgl Masuk" value="{{ $kunjungan->tgl_masuk }}"
                                                    igroup-size="sm" :config="$config" readonly />
                                                <x-adminlte-input name="dokter_dpjp" class="dokter-id"
                                                    label="Dokter DPJP" value="{{ $kunjungan->dokter->nama_paramedis }}"
                                                    igroup-size="sm" placeholder="Dokter DPJP" readonly />
                                                <x-adminlte-select name="kelas_rawat" class="kelasrawat-id"
                                                    label="Kelas Rawat" igroup-size="sm">
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
                                                <x-adminlte-select name="discharge_status" label="Cara Pulang"
                                                    igroup-size="sm">
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
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="perawatan_icu" value="1"
                                                            onchange="perawatanIcuFunc();">
                                                        <label for="perawatan_icu" class="custom-control-label">Perawatan
                                                            ICU</label>
                                                    </div>
                                                    <x-adminlte-input name="lama_icu" label="Lama ICU"
                                                        fgroup-class="masuk_icu" igroup-size="sm"
                                                        placeholder="Lama hari ICU" type="number" />
                                                    <div class="custom-control custom-checkbox checkVentilator">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="ventilator" value="1"
                                                            onchange="pakeVentilatorFunc();">
                                                        <label for="ventilator" class="custom-control-label">Ventilator
                                                            ICU</label>
                                                    </div>
                                                    <x-adminlte-input name="intubasi" label="Tgl Intubasi"
                                                        fgroup-class="col-md-4 masuk_icu pake_ventilator"
                                                        igroup-size="sm" />
                                                    <x-adminlte-input name="ekstubasi" label="Tgl Ekstubasi"
                                                        fgroup-class="col-md-4 masuk_icu pake_ventilator"
                                                        igroup-size="sm" />
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="bayi" value="1" onchange="bayiFunc();">
                                                        <label for="bayi" class="custom-control-label">Bayi</label>
                                                    </div>
                                                    <x-adminlte-input name="berat_badan" label="Berat Badan"
                                                        fgroup-class="formbb" igroup-size="sm"
                                                        placeholder="Berat Badan" />
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tb" value="1" onchange="tbFunc();">
                                                        <label for="tb" class="custom-control-label">Pasien
                                                            TB</label>
                                                    </div>
                                                    <x-adminlte-input name="no_reg_tb" label="No Register TB"
                                                        fgroup-class="checkTB" placeholder="No Register TB"
                                                        igroup-size="sm" />
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="covid" value="1" onchange="covidFunc();">
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
                                                <label class=" mb-2">Diagnosa ICD-10</label>
                                                <button id="rowAdder" type="button"
                                                    class="btn btn-xs btn-success  mb-2">
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
                                                <button id="rowAddTindakan" type="button"
                                                    class="btn btn-xs btn-success  mb-2">
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
                                                                <select name="procedure[]"
                                                                    class="form-control procedure ">
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
                                                                <input type="number" class="form-control"
                                                                    value="1">
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
                                    </form>
                                    <x-adminlte-button theme="success" class="mr-auto withLoad" label="Groupper"
                                        type="submit" icon="fas fa-diagnose" form="formGroupper" />
                                </div>
                            </div>
                        </div>
                        {{-- anamnesa --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colAnamnesa">
                                <h3 class="card-title">
                                    Anamnesis & Pemeriksaan Fisik
                                </h3>
                            </a>
                            <div id="colAnamnesa" class="collapse" role="tabpanel" aria-labelledby="hAnamnesa">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- dokter --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cDokter">
                                <h3 class="card-title">
                                    Pemeriksaan Spesialistik
                                </h3>
                            </a>
                            <div id="cDokter" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- laboratorium --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                href="#cLaboratorium">
                                <h3 class="card-title">
                                    Laboratorium
                                </h3>
                            </a>
                            <div id="cLaboratorium" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    {{-- <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Data Registrasi</th>
                                                <th>Pemeriksaan Lab</th>
                                                <th>Hasil Lab</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pasien->kunjungans->sortByDesc('tgl_masuk') as $item)
                                                @if ($item->layanans->where('kode_unit', 3002))
                                                    <tr>
                                                        <td>
                                                            {{ $item->counter }} / {{ $item->kode_kunjungan }} <br>
                                                            {{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d/m/Y h:m:s') }}
                                                            @if ($item->tgl_keluar)
                                                                - {{ $item->tgl_keluar }}
                                                            @endif <br>
                                                            <b> {{ $item->unit->nama_unit }}</b><br>
                                                            {{ $item->dokter->nama_paramedis }}<br>
                                                            @if ($item->status_kunjungan == 1)
                                                                <span class="badge badge-success">Kunjungan Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                                                                @foreach ($lab->layanan_details as $laydet)
                                                                    - {{ $laydet->tarif_detail->tarif->NAMA_TARIF }} <br>
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                                                                <div class="btn btn-xs btn-primary btnHasilLab"
                                                                    data-fileurl="http://192.168.2.74/smartlab_waled/his/his_report?hisno={{ $lab->kode_layanan_header }}">
                                                                    Hasil {{ $lab->kode_layanan_header }}</div>
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table> --}}
                                    <div class="row">
                                        @foreach ($pasien->kunjungans->sortByDesc('tgl_masuk') as $item)
                                            @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                                                <div class="col-md-6">
                                                    <iframe width="100%" height="400px"
                                                        src="http://192.168.2.74/smartlab_waled/his/his_report?hisno={{ $lab->kode_layanan_header }}"
                                                        frameborder="0"></iframe>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- radiologi --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRadiologi">
                                <h3 class="card-title">
                                    Radiologi
                                </h3>
                            </a>
                            <div id="cRadiologi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- tindakan --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cTindakan">
                                <h3 class="card-title">
                                    Tindakan
                                </h3>
                            </a>
                            <div id="cTindakan" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- resep --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cResepObat">
                                <h3 class="card-title">
                                    Resep Obat
                                </h3>
                            </a>
                            <div id="cResepObat" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                        {{-- suratkontrol --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                href="#cSuratKontrol">
                                <h3 class="card-title">
                                    Surat Kontrol
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->surat_kontrol)
                                        Sudah Dibuatkan Surat Kontrol {{ $kunjungan->surat_kontrol->noSuratKontrol }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dibuatkan Surat Kontrol <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cSuratKontrol" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    @if ($kunjungan->surat_kontrol)
                                        <input type="hidden" name="nomorsuratkontrol" class="nomorsuratkontrol-id"
                                            value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}">
                                        <form action="{{ route('suratkontrol_update_v2') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSuratKontrol" igroup-size="sm"
                                                        label="Nomor Surat Kontrol" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}"
                                                        readonly />
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSepAsalKontrol }}"
                                                        readonly />
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        value="{{ $kunjungan->surat_kontrol->tglRencanaKontrol }}"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select2 igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
                                                        <option value="{{ $kunjungan->surat_kontrol->poliTujuan }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaPoliTujuan }}
                                                        </option>
                                                        <option disabled>Silahkan Klik Cari Poliklinik</option>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariDokter">
                                                                <i class="fas fa-search"></i> Cari Dokter
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-select2>
                                                    <x-adminlte-select2 igroup-size="sm" name="kodeDokter"
                                                        label="Dokter">
                                                        <option value="{{ $kunjungan->surat_kontrol->kodeDokter }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaDokter }}</option>
                                                        <option disabled>Silahkan Klik Cari Dokter</option>
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning withLoad">
                                                <i class="fas fa-save"></i> Update</button>
                                            <div class="btn  btn-success btnPrintSuratKontrol"> <i
                                                    class="fas fa-print"></i> Print</div>
                                            <a href="{{ route('suratkontrol_delete') }}?nomorsuratkontrol={{ $kunjungan->surat_kontrol->noSuratKontrol }}"
                                                class="btn btn-danger withLoad">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </form>
                                    @else
                                        <form action="{{ route('suratkontrol_simpan') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="counter" id="counter"
                                                value="{{ $kunjungan->counter }}" class="counter-id" value="">
                                            <input type="hidden" name="kodekunjungan" id="kodekunjungan"
                                                class="kodekunjungan-id" value="{{ $kunjungan->kode_kunjungan }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                        placeholder="Nomor SEP" readonly>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariSEP">
                                                                <i class="fas fa-search"></i> Cari SEP
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
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
                                            <button type="submit" class="btn btn-warning withLoad"> <i
                                                    class="fas fa-save"></i>
                                                Buat
                                                Surat Kontrol</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- pemulangan --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cPulang">
                                <h3 class="card-title">
                                    Pemulangan Pasien
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->tgl_keluar)
                                        Sudah Dipulangkan {{ $kunjungan->tgl_keluar }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dipulangkan <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cPulang" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="{{ route('pemulangan_sep_pasien') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kodebooking" class="kodebooking-id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                    value="{{ $pasien->no_Bpjs }}" igroup-size="sm" label="Nomor Kartu"
                                                    placeholder="Nomor Kartu" readonly />
                                                <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                    igroup-size="sm" placeholder="No RM " value="{{ $pasien->no_rm }}"
                                                    readonly />
                                                <x-adminlte-input name="nama" class="nama-id"
                                                    value="{{ $pasien->nama_px }}" label="Nama Pasien" igroup-size="sm"
                                                    placeholder="Nama Pasien" readonly />
                                                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                    igroup-size="sm" placeholder="Nomor HP" />
                                                <input type="hidden" name="gender"
                                                    value="{{ $pasien->jenis_kelamin }}">
                                                <input type="hidden" name="tgllahir" value="{{ $pasien->tgl_lahir }}">
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-input name="noSep" class="nomorsep-id" igroup-size="sm"
                                                    label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                    placeholder="Nomor SEP" readonly>
                                                    <x-slot name="appendSlot">
                                                        <div class="btn btn-primary btnCariSEP">
                                                            <i class="fas fa-search"></i> Cari SEP
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-select igroup-size="sm" name="statusPulang"
                                                    label="Alasan Pulang">
                                                    <option selected disabled>Pilih Alasan Pulang</option>
                                                    <option value="1">Atas Persetujuan Dokter</option>
                                                    <option value="3">Atas Permintaan Sendiri</option>
                                                    <option value="4">Meninggal</option>
                                                    <option value="5">Lain-lain</option>
                                                </x-adminlte-select>
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tglPulang" igroup-size="sm"
                                                    label="Tanggal Pulang" value="{{ now()->format('Y-m-d') }}"
                                                    placeholder="Pilih Tanggal Pulang" :config="$config" />
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
                            </div>
                        </div>
                        {{-- filepenunjang --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collapseFile">
                                <h3 class="card-title">
                                    File Penunjang
                                </h3>
                            </a>
                            <div id="collapseFile" class="collapse" role="tabpanel" aria-labelledby="headFile">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn  btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl">
        @php
            $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
            compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    {{-- gorupping --}}
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
            });
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
            $(".checkVentilator").hide();
            $(".checkTB").hide();
            $(".checkCovid").hide();
            $(".formbb").hide();
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
        });
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
    {{-- hasil lab --}}
    <script>
        $(function() {
            $('.btnHasilLab').click(function() {
                $('#dataHasilLab').attr('src', $(this).data('fileurl'));
                $('#urlHasilLab').attr('href', $(this).data('fileurl'));
                $('#modalHasilLab').modal('show');
            });
        });
    </script>
    {{-- suratkontrol --}}
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
@endsection
