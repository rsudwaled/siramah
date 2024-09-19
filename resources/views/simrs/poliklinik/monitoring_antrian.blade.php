@extends('adminlte::page')
@section('title', 'Monitoring Antrian ' . $request->tanggal)
@section('content_header')
    <h1>Monitoring Antrians</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- @isset($antrians)
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 4)->first()->nomorantrean ?? '0' }}"
                            text="Antrian Saat Ini" theme="primary" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 3)->where('status_api', 1)->first()->nomorantrean ?? '0' }}"
                            text="Antrian Selanjutnya" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', '<', 4)->where('taskid', '>=', 1)->count() }}"
                            text="Sisa Antrian" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '!=', 99)->count() }}" text="Total Antrian"
                            theme="success" icon="fas fa-user-injured" />
                    </div>
                </div>
            @endisset --}}
            <x-adminlte-card title="Data Antrian Pasien" theme="secondary">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date igroup-size="sm" name="tanggal" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 igroup-size="sm" name="kodepoli">
                                @foreach ($polis as $item)
                                    <option value="{{ $item->kodesubspesialis }}"
                                        {{ $item->kodesubspesialis == $request->kodepoli ? 'selected' : null }}>
                                        {{ $item->namasubspesialis }} ({{ $item->kodesubspesialis }})
                                    </option>
                                @endforeach
                                <option value="" {{ $request->kodepoli ? '' : 'selected' }}>SEMUA POLIKLINIK (-)
                                </option>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-clinic-medical"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 igroup-size="sm" name="kodedokter">
                                <option value="">SEMUA DOKTER (-)</option>
                                @foreach ($dokters as $item)
                                    <option value="{{ $item->kode_dokter_jkn }}"
                                        {{ $item->kode_dokter_jkn == $request->kodedokter ? 'selected' : null }}>
                                        {{ $item->nama_paramedis }} ({{ $item->kode_dokter_jkn }})
                                    </option>
                                @endforeach
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Cari" />
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                    </div>
                </form>
                @php
                    $heads = [
                        'Tanggal',
                        'No',
                        'No RM',
                        'No BPJS',
                        'Nama Pasien',
                        'Taskid',
                        'Kodeboking',
                        'Taskid3',
                        'Taskid4',
                        'Taskid5',
                        'Taskid6',
                        'Taskid7',
                        'Action',
                        'JenisKunjungan',
                        'JenisPasien',
                        'Poliklinik',
                        'Dokter',
                        'Method',
                    ];
                    $config['order'] = ['5', 'asc'];
                    $config['paging'] = false;
                    $config['info'] = true;
                    // $config['scrollY'] = '500px';
                    // $config['scrollCollapse'] = true;
                    // $config['scrollX'] = true;
                    $config['lengthMenu'] = [10, 50, 100, 500];
                @endphp
                <x-adminlte-datatable id="tableAntrian" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed with-buttons>
                    @isset($antrians)
                        @foreach ($antrians->where('taskid', '!=', 99) as $item)
                            <tr>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @switch($item->taskid)
                                        @case(0)
                                            <span class="badge bg-secondary">96.Belum Checkin</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-secondary">{{ $item->taskid }}. Chekcin</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-secondary">{{ $item->taskid }}. Pendaftaran</span>
                                        @break

                                        @case(3)
                                            @if ($item->status_api == 0)
                                                <span class="badge bg-warning">{{ $item->taskid }}. Belum
                                                    Pembayaran</span>
                                            @else
                                                <span class="badge bg-warning">{{ $item->taskid }}. Tunggu Poli</span>
                                            @endif
                                        @break

                                        @case(4)
                                            <span class="badge bg-success">{{ $item->taskid }}. Periksa Poli</span>
                                        @break

                                        @case(5)
                                            @if ($item->status_api == 0)
                                                <span class="badge bg-success">{{ $item->taskid }}. Tunggu Farmasi</span>
                                            @endif
                                            @if ($item->status_api == 1)
                                                <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                            @endif
                                        @break

                                        @case(6)
                                            <span class="badge bg-warning">{{ $item->taskid }}. Racik Farmasi</span>
                                        @break

                                        @case(7)
                                            <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                        @break

                                        @case(99)
                                            <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->taskid3 }}</td>
                                <td>{{ $item->taskid4 }}</td>
                                <td>{{ $item->taskid5 }}</td>
                                <td>{{ $item->taskid6 }}</td>
                                <td>{{ $item->taskid7 }}</td>
                                <td></td>
                                <td>
                                    @switch($item->jeniskunjungan)
                                        @case(1)
                                            Rujukan FKTP
                                        @break

                                        @case(2)
                                            Umum
                                        @break

                                        @case(3)
                                            Kontrol
                                        @break

                                        @case(4)
                                            Rujukan RS
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>{{ $item->jenispasien }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->namadokter }}</td>

                                <td>{{ $item->method }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalPelayanan" title="Pelayanan Pasien Poliklinik" size="xl" theme="success"
        icon="fas fa-user-plus" v-centered static-backdrop scrollable>
        <form name="formLayanan" id="formLayanan" action="" method="post">
            @csrf
            <input type="hidden" name="antrianid" id="antrianid" value="">
            <dl class="row">
                <dt class="col-sm-3">Kode Booking</dt>
                <dd class="col-sm-8">: <span id="kodebooking"></span></dd>
                <dt class="col-sm-3">Antrian</dt>
                <dd class="col-sm-8">: <span id="angkaantrean"></span> / <span id="nomorantrean"></span>
                </dd>
                <dt class="col-sm-3 ">Tanggal Perikasa</dt>
                <dd class="col-sm-8">: <span id="tanggalperiksa"></span></dd>
            </dl>
            <x-adminlte-card theme="primary" title="Informasi Kunjungan Berobat">
                <div class="row">
                    <div class="col-md-5">
                        <dl class="row">
                            <dt class="col-sm-4">No RM</dt>
                            <dd class="col-sm-8">: <span id="norm"></span></dd>
                            <dt class="col-sm-4">NIK</dt>
                            <dd class="col-sm-8">: <span id="nik"></span></dd>
                            <dt class="col-sm-4">No BPJS</dt>
                            <dd class="col-sm-8">: <span id="nomorkartu"></span></dd>
                            <dt class="col-sm-4">Nama</dt>
                            <dd class="col-sm-8">: <span id="nama"></span></dd>
                            <dt class="col-sm-4">No HP</dt>
                            <dd class="col-sm-8">: <span id="nohp"></span></dd>
                            <dt class="col-sm-4">Jenis Pasien</dt>
                            <dd class="col-sm-8">: <span id="jenispasien"></span></dd>
                        </dl>
                    </div>
                    <div class="col-md-7">
                        <dl class="row">
                            <dt class="col-sm-4">Jenis Kunjungan</dt>
                            <dd class="col-sm-8">: <span id="jeniskunjungan"></span></dd>
                            <dt class="col-sm-4">No SEP</dt>
                            <dd class="col-sm-8">: <span id="nomorsep"></span></dd>
                            <dt class="col-sm-4">No Rujukan</dt>
                            <dd class="col-sm-8">: <span id="nomorrujukan"></span></dd>
                            <dt class="col-sm-4">No Surat Kontrol</dt>
                            <dd class="col-sm-8">: <span id="nomorsuratkontrol"></span></dd>
                            <dt class="col-sm-4">Poliklinik</dt>
                            <dd class="col-sm-8">: <span id="namapoli"></span></dd>
                            <dt class="col-sm-4">Dokter</dt>
                            <dd class="col-sm-8">: <span id="namadokter"></span></dd>
                            <dt class="col-sm-4">Jadwal</dt>
                            <dd class="col-sm-8">: <span id="jampraktek"></span></dd>
                        </dl>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" title="E-Rekam Medis Pasien" collapsible="collapsed">
                <div class="row">
                    Kosong
                </div>
            </x-adminlte-card>
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto btnSuratKontrol" label="Buat Surat Kontrol" theme="primary"
                    icon="fas fa-prescription-bottle-alt" />
                <a href="#" id="lanjutFarmasi" class="btn btn-success withLoad"> <i
                        class="fas fa-prescription-bottle-alt"></i>Farmasi Non-Racikan</a>
                <a href="#" id="lanjutFarmasiRacikan" class="btn btn-success withLoad"> <i
                        class="fas fa-prescription-bottle-alt"></i>Farmasi Racikan</a>
                <a href="#" id="selesaiPoliklinik" class="btn btn-warning withLoad"> <i class="fas fa-check"></i>
                    Selesai</a>
                <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
