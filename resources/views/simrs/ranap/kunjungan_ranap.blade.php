@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <h1>Pasien Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card icon="fas fa-filter" title="Filter Pasien Rawat Inap" theme="secondary" collapsible>
                <div class="row">
                    <x-adminlte-select2 fgroup-class="col-md-4" name="kodeunit" label="Ruangan">
                        @foreach ($units as $key => $item)
                            <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                {{ $item }} ({{ $key }})
                            </option>
                        @endforeach
                        <option value="-">SEMUA RUANGAN (-)
                        </option>
                    </x-adminlte-select2>
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date fgroup-class="col-md-4" igroup-size="sm" name="tanggal" label="Tanggal Antrian"
                        :config="$config" value="{{ now()->format('Y-m-d') }}">
                        <x-slot name="appendSlot">
                            <x-adminlte-button class="btn-sm btnGetObservasi" onclick="getPasienRanap()"
                                icon="fas fa-search" theme="primary" label="Submit Pencarian" />
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
            </x-adminlte-card>
        </div>
        {{-- <div class="col-md-3">
            <x-adminlte-small-box title="-" text="Pasien Ranap Aktif" theme="warning" icon="fas fa-user-injured" />
        </div> --}}
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-info-circle" title="Data Pasien Rawat Inap">
                @php
                    $heads = ['Tgl Masuk', 'Tgl Keluar (LOS)', 'Kunjungan', 'Pasien', 'No BPJS', 'Ruangan', 'No SEP', 'Status', 'Action'];
                    $config['order'] = [['7', 'asc']];
                    $config['paging'] = false;
                    $config['processing'] = true;
                    $config['serverside'] = true;
                    $config['scrollY'] = '400px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    {{-- @if ($kunjungans)
                        @foreach ($kunjungans as $kunjungan)
                            @if ($kunjungan->budget)
                                <tr>
                                @else
                                <tr class="table-danger">
                            @endif
                            <td>{{ $kunjungan->tgl_masuk }}</td>
                            <td>{{ $kunjungan->tgl_keluar }}</td>
                            <td>{{ $kunjungan->counter }} / {{ $kunjungan->kode_kunjungan }}</td>
                            <td>{{ $kunjungan->no_rm }} {{ $kunjungan->pasien->nama_px ?? '-' }}</td>
                            <td>{{ $kunjungan->pasien->no_Bpjs ?? '-' }}</td>
                            <td>{{ $kunjungan->unit->nama_unit }}</td>
                            <td>{{ $kunjungan->no_sep }}</td>
                            <td>
                                @if ($kunjungan->status_kunjungan == 1)
                                    <span class="badge badge-success">{{ $kunjungan->status_kunjungan }}.
                                        {{ $kunjungan->status->status_kunjungan }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $kunjungan->status_kunjungan }}.
                                        {{ $kunjungan->status->status_kunjungan }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pasienranapprofile') }}?kode={{ $kunjungan->kode_kunjungan }}"
                                    class="btn btn-primary btn-xs"><i class="fas fa-file-medical"></i> Lihat
                                    ERM</a>
                            </td>
                            </tr>
                        @endforeach
                    @endif --}}
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('js')
    {{-- pasien rawat inap --}}
    <script>
        $(function() {
            var kodeinit = "{{ $request->kodeunit }}";
            if (kodeinit) {
                getPasienRanap();
            }
        });
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

        function getPasienRanap() {
            var ruangan = $("#kodeunit").val();
            var tanggal = $("#tanggal").val();
            var url = "{{ route('get_pasien_ranap') }}?ruangan=" + ruangan + "&tanggal=" + tanggal;
            var table = $('#table1').DataTable();
            table.rows().remove().draw();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var btn = "<a href='{{ route('pasienranapprofile') }}?kode=" + value
                            .kode_kunjungan +
                            "' class='btn btn-primary btn-xs'> <i class='fas fa-file-medical withLoad'></i> Lihat ERM</a>";
                        var addedRow = table.row.add([
                            value.tgl_masuk,
                            value.tgl_keluar,
                            value.counter + ' / ' + value.kode_kunjungan,
                            value.no_rm + ' ' + value.pasien.nama_px,
                            value.pasien.no_Bpjs,
                            value.unit.nama_unit,
                            value.no_sep,
                            value.status.status_kunjungan,
                            btn,
                        ]).draw(false);
                        if (value.budget) {
                            if (!value.budget.kode_cbg) {
                                var addedRowNode = addedRow.node();
                                $(addedRowNode).addClass('table-danger');
                            }
                        } else {
                            var addedRowNode = addedRow.node();
                            $(addedRowNode).addClass('table-danger');
                        }
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
            });
        }
    </script>
@endsection
