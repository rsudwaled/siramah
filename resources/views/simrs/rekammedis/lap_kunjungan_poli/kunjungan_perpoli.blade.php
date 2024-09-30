@extends('adminlte::page')
@section('title', 'Kunjungan Poliklinik')
@section('content_header')
    <h1>Kunjungan Poliklinik</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Periode Tanggal Dan Unit" theme="secondary" id="hide_div" collapsible>
                <form id="formFilter" action="" method="get">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="date" name="startdate" id="startdate" class="form-control"
                                        value="{{ $startdate == null ? \Carbon\Carbon::now()->format('Y-m-d') : $startdate->format('Y-m-d') }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="enddate" id="enddate" class="form-control"
                                        value="{{ $enddate == null ? \Carbon\Carbon::now()->format('Y-m-d') : $enddate->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 row">
                            <div class="col-lg-8">
                                <x-adminlte-select2 label-class="text-right" igroup-size="sm" name="kodeunit">
                                    <option value="-">SEMUA POLIKLINIK</option>
                                    @foreach ($units as $key => $item)
                                        <option value="{{ $item->kode_unit }}" {{$kodeunit == $item->kode_unit?'selected':''}}>
                                            {{ strtoupper($item->nama_unit) }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4 row">
                            <x-adminlte-button type="submit" class="withLoad btn btn-sm col-md-6" theme="primary"
                                label="Lihat Laporan" />
                            <x-adminlte-button type="submit" target="_blank"
                                onclick="javascript: form.action='{{ route('laporan-rm.kunjungan.exportKunjunganPoli') }}';"
                                class="withLoad btn btn-sm col-md-6" theme="success" label="Download" />
                        </div>

                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-card title="Kunjungan Poliklinik" theme="primary" collapsible>
                @if (!empty($formattedData))
                <table class="table table-bordered table-hover table-sm nowrap" id="myTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            @foreach ($dates as $date)
                                <th>{{ $date->format('d') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formattedData as $unit => $dates)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unit }}</td>
                                @foreach ($dates as $date => $total)
                                    <td>{{ $total }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </x-adminlte-card>
        </div>
    </div>

@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollX": true,
                "scrollY": "600px",
                "scrollCollapse": true, // Allow the table to shrink or grow
                "paging": false // Disable pagination
            });

            $('.btn-cekFktp').on('click', function() {
                var norujukan = $(this).data('norujukan');

                // SweetAlert Konfirmasi
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin cari data FKTP?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tampilkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.LoadingOverlay("show");
                        $.ajax({
                            url: '{{ route('laporan-rm.get-fktp') }}',
                            method: 'GET',
                            data: {
                                norujukan: norujukan
                            },
                            success: function(data) {
                                $.LoadingOverlay("hide");
                                // Menampilkan alert dengan SweetAlert
                                // console.info(data.response.response.rujukan.provPerujuk)
                                console.info(data.code)
                                if (data.code == '200') {
                                    Swal.fire({
                                        title: 'Data Tersedia',
                                        text: data.response.response.rujukan
                                            .provPerujuk.nama + ' | KODE: ' +
                                            data.response.response.rujukan
                                            .provPerujuk.kode,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Reload halaman setelah SweetAlert dikonfirmasi
                                            location.reload();
                                        }
                                    });


                                } else if (data.code != '200') {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'KODE : ' + data.response.metadata
                                            .code + ' | ' + data.response
                                            .metadata.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Reload halaman setelah SweetAlert dikonfirmasi
                                            location.reload();
                                        }
                                    });
                                } else {}
                            },
                            error: function() {
                                $.LoadingOverlay("hide");
                                console.info(data.code)
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat memuat detail.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });


        });
    </script>

@endsection
