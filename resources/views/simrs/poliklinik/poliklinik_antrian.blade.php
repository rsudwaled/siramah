@extends('adminlte::page')
@section('title', 'Antrian Poliklinik')
@section('content_header')
    <h1>Antrian Poliklinik </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @isset($antrians)
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
            @endisset
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
                        'Action',
                        'Jenis Kjg',
                        'Jenis Px',
                        'Poliklinik',
                        'Dokter',
                        'SEP',
                        'No Referensi',
                        'Surat Kontrol',
                        'Kodeboking',
                        'Cara Daftar',
                    ];
                    $config['order'] = ['5', 'asc'];
                    $config['paging'] = false;
                    $config['info'] = true;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="tableAntrian" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    @isset($antrians)
                        @foreach ($antrians->where('method', '!=', 'Offline') as $item)
                            <tr>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>
                                    @isset($item->nomorkartu)
                                        <a class="text-dark"
                                            href="{{ route('monitoringPelayananPeserta') }}?tanggal={{ now()->format('Y-m-d') }}&nomorkartu={{ $item->nomorkartu }}"
                                            target="blank">{{ $item->nomorkartu }}</a>
                                    @endisset
                                </td>
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
                                <td>
                                    @switch($item->taskid)
                                        @case(3)
                                            @if ($item->status_api == 1)
                                                <x-adminlte-button class="btn-xs mt-1 withLoad" label="3. Panggil" theme="warning"
                                                    data-toggle="tooltip" title="Panggil Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('panggilPoliklinik') }}?kodebooking={{ $item->kodebooking }}'" />
                                            @endif
                                        @break

                                        @case(4)
                                            <x-adminlte-button class="btn-xs mt-1 btnLayani" label="4. Layani" theme="success"
                                                icon="fas fa-hand-holding-medical" data-toggle="tooltop"
                                                title="Layani Pasien {{ $item->nomorantrean }}" data-id="{{ $item->id }}" />
                                        @break

                                        @default
                                        @break
                                    @endswitch
                                    <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-times" data-toggle="tooltop"
                                        title="Batal Antrian {{ $item->nomorantrean }}" onclick="btnBatal(this)"
                                        data-kodebooking="{{ $item->kodebooking }}" data-nama="{{ $item->nama }}" />
                                </td>
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
                                <td>{{ $item->nomorsep }}</td>
                                <td>{{ $item->nomorrujukan }}</td>
                                <td>{{ $item->nomorsuratkontrol }}</td>
                                <td>{{ $item->kodebooking }}</td>
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

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        function btnBatal(button) {
            var kodebooking = $(button).data("kodebooking");
            var nama = $(button).data("nama");
            Swal.fire({
                title: "Konfirmasi Pembatalan Antrian",
                text: "Alasan pembatalan antrian atas nama pasien " + nama + " ?",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Batal",
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.LoadingOverlay("show");
                    var url = "{{ route('batal_antrian') }}";
                    $.post(url, {
                            kodebooking: kodebooking,
                            keterangan: result.value,
                        },
                        function(res, status) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: res.metadata.message,
                                icon: 'info',
                                confirmButtonText: "Oke",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.LoadingOverlay("show");
                                    location.reload();
                                }
                            });
                        });
                }
            });
        }
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btnLayani').click(function() {
                var antrianid = $(this).data('id');
                $.LoadingOverlay("show");
                var url = "{{ route('antrian.index') }}/" + antrianid + '/edit'
                $.get(url, function(data) {
                    $('#kodebooking').html(data.kodebooking);
                    $('#angkaantrean').html(data.angkaantrean);
                    $('#nomorantrean').html(data.nomorantrean);
                    $('#tanggalperiksa').html(data.tanggalperiksa);
                    $('#norm').html(data.norm);
                    $('#nik').html(data.nik);
                    $('#nomorkartu').html(data.nomorkartu);
                    $('#nama').html(data.nama);
                    $('#nohp').html(data.nohp);
                    $('#nomorrujukan').html(data.nomorrujukan);
                    $('#nomorsuratkontrol').html(data.nomorsuratkontrol);
                    $('#nomorsep').html(data.nomorsep);
                    $('#jenispasien').html(data.jenispasien);
                    $('#namapoli').html(data.namapoli);
                    $('#namadokter').html(data.namadokter);
                    $('#jampraktek').html(data.jampraktek);
                    switch (data.jeniskunjungan) {
                        case "1":
                            var jeniskunjungan = "Rujukan FKTP";
                            break;
                        case "2":
                            var jeniskunjungan = "Rujukan Internal";
                            break;
                        case "3":
                            var jeniskunjungan = "Kontrol";
                            break;
                        case "4":
                            var jeniskunjungan = "Rujukan Antar RS";
                            break;
                        default:
                            break;
                    }
                    $('#jeniskunjungan').html(jeniskunjungan);
                    $('#user').html(data.user);
                    $('#antrianid').val(antrianid);
                    $('#namapoli').val(data.namapoli);
                    $('#namap').val(data.kodepoli);
                    $('#namadokter').val(data.namadokter);
                    $('#kodepoli').val(data.kodepoli);
                    $('#kodedokter').val(data.kodedokter);
                    $('#jampraktek').val(data.jampraktek);
                    $('#nomorsep_suratkontrol').val(data.nomorsep);
                    $('#kodepoli_suratkontrol').val(data.kodepoli);
                    $('#namapoli_suratkontrol').val(data.namapoli);
                    var urlLanjutFarmasi = "{{ route('lanjutFarmasi') }}?kodebooking=" + data
                        .kodebooking;
                    $("#lanjutFarmasi").attr("href", urlLanjutFarmasi);

                    var urlLanjutFarmasiRacikan =
                        "{{ route('lanjutFarmasiRacikan') }}?kodebooking=" + data
                        .kodebooking;
                    $("#lanjutFarmasiRacikan").attr("href", urlLanjutFarmasiRacikan);

                    var urlSelesaiPoliklinik = "{{ route('selesaiPoliklinik') }}?kodebooking=" +
                        data
                        .kodebooking;
                    $("#selesaiPoliklinik").attr("href", urlSelesaiPoliklinik);
                    $('#modalPelayanan').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
            $('.btnSuratKontrol').click(function() {
                $('#modalSuratKontrol').modal('show');
            });
        });
    </script>
@endsection
