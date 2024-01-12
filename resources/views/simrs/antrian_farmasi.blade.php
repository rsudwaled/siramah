@extends('adminlte::page')

@section('title', 'Antrian Farmasi')

@section('content_header')
    <h1>Antrian Farmasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input name="user" label="User" readonly value="{{ Auth::user()->name }}" />
                        </div>
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Antrian" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
            @if (isset($request->tanggal))
                {{-- info box --}}
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 6)->first()->angkaantrean ?? '0' }}"
                            text="Antrian Saat Ini" theme="primary" class="withLoad" icon="fas fa-sign-in-alt" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 5)->where('status_api', 0)->first()->angkaantrean ?? '0' }}"
                            text="Antrian Selanjutnya" theme="success" icon="fas fa-sign-in-alt"
                            url="{{ route('racikFarmasi',$antrians->where('taskid', 5)->where('status_api', 0)->first()->kodebooking ?? '0') }}"
                            url-text="Panggil Antrian Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', '<', 7)->where('taskid', '>=', 5)->where('status_api', '=', 0)->count() }}"
                            text="Sisa Antrian" theme="warning" icon="fas fa-sign-in-alt" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->count() }}" text="Total Antrian" theme="success"
                            icon="fas fa-sign-in-alt" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{-- belum dilayani --}}
                        <x-adminlte-card
                            title="Antrian Tunggu Farmasi ({{ $antrians->where('taskid', 5)->where('status_api', 0)->count() }} Orang)"
                            theme="warning" icon="fas fa-info-circle" collapsible>
                            @php
                                $heads = ['No', 'No RM / Kartu', 'Poliklinik', 'Action'];
                                $config['order'] = ['0', 'asc'];
                            @endphp
                            <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                @foreach ($antrians->where('taskid', 5)->where('status_api', 0) as $item)
                                    <tr>
                                        <td>
                                            {{ $item->angkaantrean }} / {{ $item->nomorantrean }}<br>
                                            {{ $item->kodebooking }}<br>
                                            @if ($item->taskid == 5)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Farmasi</span>
                                                @endif
                                                @if ($item->status_api == 2)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 6)
                                                <span class="badge bg-success">{{ $item->taskid }}. Racik Obat</span>
                                            @endif
                                            @if ($item->taskid == 7)
                                                <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                            @endif
                                            @if ($item->taskid == 99)
                                                <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->norm }} <br>
                                            <b>{{ $item->nama }}</b> <br>
                                            @isset($item->nomorkartu)
                                                {{ $item->nomorkartu }}
                                            @endisset
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                            <br>{{ $item->jenispasien }}
                                            @if ($item->pasienbaru == 1)
                                                <span class="badge bg-secondary">Baru</span>
                                            @endif
                                            @if ($item->pasienbaru == 0)
                                                <span class="badge bg-secondary">Lama</span>
                                            @endif
                                            @if (isset($item->method))
                                                <span class="badge bg-secondary">{{ $item->method }}</span>
                                            @else
                                                <span class="badge bg-secondary">NULL</span>
                                            @endif
                                            <span class="badge bg-success">{{ $item->kodepoli }}</span>
                                            <br>{{ substr($item->namadokter, 0, 17) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 5)
                                                {{-- panggil pertama --}}
                                                <x-adminlte-button class="btn-xs" label="Racik Obat" theme="success"
                                                    icon="fas fa-prescription-bottle-alt" data-toggle="tooltip"
                                                    title="Racik Obat Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('racikFarmasi', $item->kodebooking) }}'" />
                                            @endif
                                            @if ($item->taskid == 6)
                                                <x-adminlte-button class="btn-xs" label="Selesai Racik" theme="success"
                                                    icon="fas fa-prescription-bottle-alt" data-toggle="tooltip"
                                                    title="Racik Obat Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('selesaiFarmasi', $item->kodebooking) }}'" />
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                    <div class="col-md-6">
                        {{-- sedang dilayani --}}
                        <x-adminlte-card
                            title="Antrian Peracikan Farmasi ({{ $antrians->where('taskid', 6)->count() }} Orang)"
                            theme="primary" icon="fas fa-info-circle" collapsible>
                            @php
                                $heads = ['No', 'No RM / Kartu', 'Poliklinik', 'Action'];
                                $config['order'] = ['0', 'asc'];
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                @foreach ($antrians->where('taskid', 6) as $item)
                                    <tr>
                                        <td>
                                            {{ $item->angkaantrean }} / {{ $item->nomorantrean }}<br>
                                            {{ $item->kodebooking }}<br>
                                            @if ($item->taskid == 5)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Farmasi</span>
                                                @endif
                                                @if ($item->status_api == 2)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 6)
                                                <span class="badge bg-success">{{ $item->taskid }}. Racik Obat</span>
                                            @endif
                                            @if ($item->taskid == 7)
                                                <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                            @endif
                                            @if ($item->taskid == 99)
                                                <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->norm }} <br>
                                            <b>{{ $item->nama }}</b> <br>
                                            @isset($item->nomorkartu)
                                                {{ $item->nomorkartu }}
                                            @endisset
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                            <br>{{ $item->jenispasien }}
                                            @if ($item->pasienbaru == 1)
                                                <span class="badge bg-secondary">Baru</span>
                                            @endif
                                            @if ($item->pasienbaru == 0)
                                                <span class="badge bg-secondary">Lama</span>
                                            @endif
                                            @if (isset($item->method))
                                                <span class="badge bg-secondary">{{ $item->method }}</span>
                                            @else
                                                <span class="badge bg-secondary">NULL</span>
                                            @endif
                                            <span class="badge bg-success">{{ $item->kodepoli }}</span>
                                            <br>{{ substr($item->namadokter, 0, 17) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 5)
                                                {{-- panggil pertama --}}
                                                <x-adminlte-button class="btn-xs withLoad" label="Racik Obat"
                                                    theme="success" icon="fas fa-prescription-bottle-alt"
                                                    data-toggle="tooltip"
                                                    title="Racik Obat Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('racikFarmasi', $item->kodebooking) }}'" />
                                            @endif
                                            @if ($item->taskid == 6)
                                                <x-adminlte-button class="btn-xs withLoad" label="Selesai"
                                                    theme="success" icon="fas fa-prescription-bottle-alt"
                                                    data-toggle="tooltip"
                                                    title="Racik Obat Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('selesaiFarmasi', $item->kodebooking) }}'" />
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                </div>
                {{-- selesai dilayani --}}
                <x-adminlte-card title="Antrian Sudah Pelayanan Farmasi ({{ $antrians->count() }} Orang)" theme="success"
                    icon="fas fa-info-circle" collapsible="collapsed">
                    @php
                        $heads = ['No', 'Kode', 'Tanggal', 'No RM / NIK', 'Jenis / Pasien', 'No Kartu / Rujukan', 'Poliklinik / Dokter', 'Status'];
                        $config['order'] = ['7', 'asc'];
                    @endphp
                    <x-adminlte-datatable id="table3" class="nowrap" :heads="$heads" :config="$config" striped
                        bordered hoverable compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}<br>
                                    {{ $item->nomorantrean }}
                                </td>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>
                                    {{ $item->norm }} <br>
                                    {{ $item->nik }}

                                </td>
                                <td>
                                    {{ $item->nama }}<br>
                                    {{ $item->jenispasien }}
                                    @if ($item->pasienbaru == 1)
                                        <span class="badge bg-secondary">{{ $item->pasienbaru }}. Baru</span>
                                    @endif
                                    @if ($item->pasienbaru == 0)
                                        <span class="badge bg-secondary">{{ $item->pasienbaru }}. Lama</span>
                                    @endif
                                </td>
                                <td>
                                    @isset($item->nomorkartu)
                                        {{ $item->nomorkartu }}
                                    @endisset
                                    @isset($item->nomorkartu)
                                        <br> {{ $item->nomorreferensi }}
                                    @endisset
                                </td>
                                <td>{{ $item->namapoli }} {{ $item->jampraktek }}<br>{{ $item->namadokter }}
                                </td>
                                <td>
                                    @if ($item->taskid == 0)
                                        <span class="badge bg-secondary">Belum Checkin</span>
                                    @endif
                                    @if ($item->taskid == 1)
                                        <span class="badge bg-secondary">{{ $item->taskid }}. Chekcin</span>
                                    @endif
                                    @if ($item->taskid == 2)
                                        <span class="badge bg-secondary">{{ $item->taskid }}. Pendaftaran</span>
                                    @endif
                                    @if ($item->taskid == 3)
                                        @if ($item->status_api == 0)
                                            <span class="badge bg-warning">{{ $item->taskid }}. Belum
                                                Pembayaran</span>
                                        @else
                                            <span class="badge bg-warning">{{ $item->taskid }}. Tunggu Poli</span>
                                        @endif
                                    @endif
                                    @if ($item->taskid == 4)
                                        <span class="badge bg-success">{{ $item->taskid }}. Periksa Poli</span>
                                    @endif
                                    @if ($item->taskid == 5)
                                        @if ($item->status_api == 0)
                                            <span class="badge bg-success">{{ $item->taskid }}. Tunggu
                                                Farmasi</span>
                                        @endif
                                        @if ($item->status_api == 1)
                                            <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                        @endif
                                    @endif
                                    @if ($item->taskid == 6)
                                        <span class="badge bg-success">{{ $item->taskid }}. Racik Obat</span>
                                    @endif
                                    @if ($item->taskid == 7)
                                        <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                    @endif
                                    @if ($item->taskid == 99)
                                        <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
                @if ($antrians->count() > 0)
                    {{-- <x-adminlte-modal id="modalPembayaran" title="Pembayaran Antrian Pasien" size="xl"
                        theme="success" icon="fas fa-user-plus" v-centered>
                        <form name="formLayanan" id="formLayanan" action="{{ route('farmasi.pendaftaran') }}"
                            method="post">
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
                                <dt class="col-sm-3">Administrator</dt>
                                <dd class="col-sm-8">: {{ Auth::user()->name }}</dd>
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
                                        </dl>
                                    </div>
                                    <div class="col-md-7">
                                        <dl class="row">
                                            <dt class="col-sm-4">No Rujukan</dt>
                                            <dd class="col-sm-8">: <span id="nomorreferensi"></span></dd>
                                            <dt class="col-sm-4">Jenis Pasien</dt>
                                            <dd class="col-sm-8">: <span id="jenispasien"></span></dd>
                                            <dt class="col-sm-4">Farmasi</dt>
                                            <dd class="col-sm-8">: <span id="namapoli"></span></dd>
                                            <dt class="col-sm-4">Dokter</dt>
                                            <dd class="col-sm-8">: <span id="namadokter"></span></dd>
                                            <dt class="col-sm-4">Jadwal</dt>
                                            <dd class="col-sm-8">: <span id="jampraktek"></span></dd>
                                            <dt class="col-sm-4">Jenis Kunjungan</dt>
                                            <dd class="col-sm-8">: <span id="jeniskunjungan"></span></dd>
                                        </dl>
                                    </div>
                                </div>
                            </x-adminlte-card>
                            <x-slot name="footerSlot">
                                <x-adminlte-button class="mr-auto" label="Lanjut Farmasi" theme="warning"
                                    icon="fas fa-prescription-bottle-alt"
                                    onclick=" window.location='{{ route('farmasi.lanjut_farmasi', $item->kodebooking) }}'" />
                                <x-adminlte-button label="Selesai" theme="success" icon="fas fa-check"
                                    onclick="window.location='{{ route('farmasi.selesai', $item->kodebooking) }}'" />
                                <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
                            </x-slot>
                        </form>
                    </x-adminlte-modal> --}}
                @endif
            @endif
        </div>
    </div>


    <audio id="myAudio">
        <source src="{{ asset('rsudwaled/tingtung.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        function playAudio() {
            x.play();
        }

        function pauseAudio() {
            x.pause();
        }
    </script>
    <script>
        $(document).ready(function() {
            url = "{{ route('getAntrianFarmasi') }}";
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            var tanggal = "{{ $request->tanggal }}";
            if (tanggal) {
                setInterval(function() {
                    // alert('tanggal');
                    // var dt = new Date($.now());
                    // var time = "{{ $request->tanggal }}" + ' ' + dt.getHours() + ":" + dt.getMinutes() +
                    //     ":" + dt
                    //     .getSeconds();
                    $.get(url, {
                            tanggal: "{{ $request->tanggal }}",
                        })
                        .done(function(data) {
                            console.log(data);
                            if (data.metadata.code == 200) {
                                var x = document.getElementById("myAudio");
                                x.play();
                                Toast.fire({
                                    icon: 'info',
                                    title: "Terdapat antrian " + data.metadata.message +
                                        ' farmasi.'
                                });

                            }

                            // element.innerHTML = time + " " + data.metadata.message + " <br>";
                        })
                        .fail(function(data) {
                            console.log(data);
                            Toast.fire({
                                icon: 'error',
                                title: 'Error'
                            });
                            // element.innerHTML = time + " ERROR <br>";
                        });
                }, 5 * 1000);
            }
        });
    </script>
@endsection
