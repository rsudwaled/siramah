@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran {{ $request->loket ? 'Loket ' . $request->loket . ' Lantai ' . $request->lantai : '' }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Antrian Offline Pasien" theme="secondary"
                collapsible="{{ $request->loket ? 'collapsed' : '' }}">
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date name="tanggal" fgroup-class="col-md-3" igroup-size="sm"
                            label="Tanggal Antrian Pasien" :config="$config"
                            value="{{ $request->tanggal ?? now()->format('Y-m-d') }}" />
                        <x-adminlte-select name="jenispasien" fgroup-class="col-md-3" igroup-size="sm" label="Jenis Pasien">
                            <option value="JKN" {{ $request->jenispasien == 'JKN' ? 'selected' : null }}>BPJS
                            </option>
                            <option value="NON-JKN" {{ $request->jenispasien == 'NON-JKN' ? 'selected' : null }}>UMUM
                            </option>
                        </x-adminlte-select>
                        <x-adminlte-select name="loket" fgroup-class="col-md-3" igroup-size="sm" label="Loket">
                            <x-adminlte-options :options="[
                                1 => 'Loket 1',
                                2 => 'Loket 2',
                                3 => 'Loket 3',
                                4 => 'Loket 4',
                                5 => 'Loket 5',
                            ]" :selected="$request->loket ?? 1" />
                        </x-adminlte-select>
                        <x-adminlte-select name="lantai" fgroup-class="col-md-3" igroup-size="sm" label="Lantai">
                            <x-adminlte-options :options="[
                                1 => 'Lantai 1',
                                2 => 'Lantai 2',
                                3 => 'Lantai 3',
                                4 => 'Lantai 4',
                                5 => 'Lantai 5',
                            ]" :selected="$request->lantai ?? 1" />
                        </x-adminlte-select>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
            @if (isset($antrians))
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('taskid', 0)->where('lantaipendaftaran', $request->lantai)->first()->angkaantrean ?? '0' }}"
                            text="Antrian Selanjutnya" theme="success" icon="fas fa-user-injured"
                            url="{{ route('selanjutnyaPendaftaran', [$request->loket, $request->lantai, $request->jenispasien, $request->tanggal]) }}"
                            url-text="Panggil Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('taskid', '<', 1)->where('lantaipendaftaran', $request->lantai)->count() }}"
                            text="Sisa Antrian" theme="warning" icon="fas fa-user-injured" url="#"
                            url-text="Refresh Antrian" onclick="location.reload();" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('lantaipendaftaran', $request->lantai)->count() }}"
                            text="Total Antrian" theme="primary" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                            title="Proses Pendaftaran Antrian Offline ({{ $antrians->where('taskid', 2)->where('lantaipendaftaran', $request->lantai)->count() }} Orang)">
                            @php
                                $heads = ['No', ' Antrian', 'Pasien', 'Kunjungan', 'Poliklinik', 'Dokter', 'Status', 'Loket', 'Action'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '400px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                                bordered hoverable compressed>
                                @foreach ($antrians->where('taskid', 2)->where('lantaipendaftaran', $request->lantai) as $item)
                                    <tr>
                                        <td>
                                            <b>{{ $item->angkaantrean }}</b>
                                        </td>
                                        <td>
                                            {{ $item->nomorantrean }} / {{ $item->kodebooking }}<br>
                                        </td>
                                        <td>
                                            {{ $item->jenispasien }}
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 0)
                                                Offline
                                            @endif
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->kodepoli }}
                                        </td>
                                        <td>
                                            {{ $item->kodedokter }} - {{ substr($item->namadokter, 0, 19) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 0)
                                                <span class="badge bg-secondary">0. Antri Pendaftaran</span>
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
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Poli</span>
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
                                        <td>
                                            Loket {{ $item->loket }}
                                        </td>
                                        <td>
                                            <a class="btn btn-xs mt-1 btn-success"
                                                href="{{ route('selesaiPendaftaran') }}?kodebooking={{ $item->kodebooking }}">
                                                <i class="fas fa-user-plus"></i> Selesai</a>
                                            <x-adminlte-button class="btn-xs mt-1 withLoad" label="Panggil" theme="primary"
                                                icon="fas fa-volume-down" data-toggle="tooltip"
                                                title="Panggil Antrian {{ $item->nomorantrean }}"
                                                onclick="window.location='{{ route('panggilPendaftaran', [$item->kodebooking, $request->loket, $request->lantai]) }}'" />
                                            <a class="btn btn-xs mt-1 btn-danger withLoad"
                                                href="{{ route('batalpendaftaran') }}?kodebooking={{ $item->kodebooking }}">
                                                <i class="fas fa-times"></i> Batal</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-card title="Total Data Antrian Pasien ({{ $antrians->count() }} Orang)" theme="warning"
                            icon="fas fa-info-circle" collapsible=''>
                            @php
                                $heads = ['No', 'Antrian', 'Pasien', 'Kunjungan', 'Poliklinik', 'Dokter', 'Status', 'Loket', 'Lantai'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '250px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config"
                                bordered hoverable compressed>
                                @foreach ($antrians as $item)
                                    <tr>
                                        <td>
                                            <b>{{ $item->angkaantrean }} </b>
                                        </td>
                                        <td>
                                            {{ $item->nomorantrean }} / {{ $item->kodebooking }}<br>
                                        </td>
                                        <td>
                                            {{ $item->jenispasien }}
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 0)
                                                Offline
                                            @endif
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->namapoli }}
                                        </td>
                                        <td>
                                            {{ $item->kodedokter }} - {{ substr($item->namadokter, 0, 19) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 0)
                                                <span class="badge bg-secondary">0. Antri Pendaftaran</span>
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
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Poli</span>
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
                                        <td>
                                            Loket {{ $item->loket }}
                                        </td>
                                        <td>
                                            Lantai {{ $item->lantaipendaftaran }}
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-adminlte-modal id="daftarBPJS" title="Pendaftaran Rawat Jalan BPJS" theme="warning" icon="fas fa-user-plus"
        size='lg'>
        This is a purple theme modal without animations.
    </x-adminlte-modal>
    <x-adminlte-modal id="daftarUmum" title="Pendaftaran Rawat Jalan UMUM" theme="warning" icon="fas fa-user-plus"
        size='lg'>
        This is a purple theme modal without animations.
    </x-adminlte-modal>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#tableKunjungan').DataTable();
            $('#btnRiwayatRujukan').click(function() {
                $.LoadingOverlay("show");
                var url = "{{ route('rujukan_peserta') }}";
                var nomorkartu = $('#nomorkartu').val();
                var data = {
                    nomorkartu: nomorkartu,
                }
                $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Success ' + data.metadata.code,
                            data.metadata.message,
                            'success'
                        );
                        var table = $('#tableRujukan').DataTable();
                        if (data.response) {
                            table.rows().remove().draw();
                            var rujukans = data.response.rujukan;
                            $.each(rujukans, function(key, value) {
                                table.row.add([
                                    key + 1,
                                    value.tglKunjungan,
                                    value.noKunjungan,
                                    value.pelayanan.nama,
                                    value.poliRujukan.nama,
                                    value.diagnosa.kode + ' ' + value.diagnosa
                                    .nama,
                                    value.provPerujuk.nama,
                                    "<button class='btn btn-warning btn-xs btnPilihRujukan' data-id=" +
                                    value.noKunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);
                                $('.btnPilihRujukan').click(function() {
                                    nomorrujukan = $(this).data("id");
                                    $('#nomorreferensi').val(nomorrujukan);
                                    $('#riwayatRujukan').modal('hide');
                                    // alert(nomorrujukan);

                                });
                            })
                        }
                    },
                    error: function(data) {
                        console.log(data.metadata);
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                    },
                    complete: function(data) {
                        $('#riwayatRujukan').modal('show');
                        $.LoadingOverlay("hide", true);
                    }
                });
            });
            $('#btnRiwayatSuratKontrol').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $('#nomorkartu').val();
                var bulan = "{{ now()->month }}";
                var tahun = "{{ now()->year }}";
                var data = {
                    nomorkartu: nomorkartu,
                    bulan: bulan,
                    formatfilter: 2,
                    tahun: tahun,
                }
                var url = "{{ route('suratkontrol_peserta') }}";
                $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Success ' + data.metadata.code,
                            data.metadata.message,
                            'success'
                        );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                        if (data.response) {
                            var suratkontrols = data.response.list;
                            $.each(suratkontrols, function(key, value) {
                                table.row.add([,
                                    value.tglRencanaKontrol,
                                    "<button class='btn btn-warning btn-xs pilihRujukan' data-id=" +
                                    value.noKunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);
                            })
                        }
                    },
                    error: function(data) {
                        swal.fire(
                            data.statusText + ' ' + data.status,
                            data.responseJSON.data,
                            'error'
                        );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                    },
                    complete: function(data) {
                        $('#riwayatSuratKontrol').modal('show');
                        $.LoadingOverlay("hide");
                    }
                });
            });

        });
    </script>
@endsection
