@extends('adminlte::page')
@section('title', 'RUJUKAN FKTP PASIEN')
@section('content_header')
    <h1>RUJUKAN FKTP PASIEN</h1>
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
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="date" name="startdate" id="startdate" class="form-control"
                                        value="{{ $startdate == null ? \Carbon\Carbon::parse($request->startdate)->format('Y-m-d') : $startdate }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="enddate" id="enddate" class="form-control"
                                        value="{{ $enddate == null ? \Carbon\Carbon::parse($request->enddate)->format('Y-m-d') : $enddate }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 label-class="text-right" igroup-size="sm" name="kodeunit">
                                <option value="-">SEMUA POLIKLINIK</option>
                                @foreach ($units as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ $key == $request->kodeunit ? 'selected' : null }}>
                                        {{ $key }}
                                        {{ strtoupper($item) }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                        <x-adminlte-button type="submit" class="withLoad btn btn-sm col-md-2" theme="primary"
                            label="Lihat Laporan" />
                        <x-adminlte-button type="submit" target="_blank"
                            onclick="javascript: form.action='{{ route('laporan-rm.download') }}';"
                            class="btn btn-sm col-md-2" theme="success" label="Download" />
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-card title="RUJUKAN FKTP PASIEN" theme="primary" collapsible>
                <table class="table table-bordered table-hover table-sm nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Tgl Masuk</th>
                            <th>Nama Pasien</th>
                            <th>SEP</th>
                            <th>No Rujukan</th>
                            <th>Nama FKTP</th>
                            <th>No</th>
                            <th>CEK DATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kunjungans)
                            @foreach ($kunjunganIds as $item)
                                <tr>
                                    <td>{{ $item->tgl_masuk }} <br><strong>( {{ $item->unit->nama_unit }} )</strong></td>
                                    <td><strong>{{ $item->no_rm }}</strong><br> {{ $item->pasien->nama_px }} </td>
                                    <td>{{ $item->no_sep ?? null }}</td>
                                    <td>{{ $item->no_rujukan }}</td>
                                    <td>{{ $item->perujuk ?? 'Belum Ada' }}</td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <button data-norujukan="{{ $item->no_rujukan }}"
                                            class="btn btn-primary btn-sm btn-cekFktp" id="cek-fktp" type="button">Cek
                                            FKTP</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
                                            // location.reload();
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
                                            // location.reload();
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
