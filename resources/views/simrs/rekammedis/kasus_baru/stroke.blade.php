@extends('adminlte::page')
@section('title', 'Penyakit Kasus Baru')
@section('content_header')
    <h1>Penyakit Stroke</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="secondary" collapsible>
                <form id="formFilter" action="" method="get">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" name="startdate" id="startdate" class="form-control"
                                value="{{ $startdate == null ? \Carbon\Carbon::parse($request->startdate)->format('Y-m-d') : $startdate }}">
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="enddate" id="enddate" class="form-control"
                                value="{{ $enddate == null ? \Carbon\Carbon::parse($request->enddate)->format('Y-m-d') : $enddate }}">
                        </div>
                        <div class="col-md-4 row">
                            <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm col-md-4 mr-2"
                                theme="primary" label="Lihat Laporan" />
                            <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm col-md-4"
                                theme="success" label="Export Excel" target="_blank"
                                onclick="javascript: form.action='{{ route('laporan-rm.kasus-baru.download.stroke') }}';" />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-card title="Data Kunjungan" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-hover table-sm nowrap" id="myTableBaru">
                            <thead>
                                <tr>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kasus Baru</th>
                                    <th>Kasus Lama</th>
                                    <th>Tgl Masuk</th>
                                    <th>Tgl Keluar</th>
                                    <th>Kode ICD</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>Kota</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $dm)
                                    <tr>
                                        <td>{{ $dm->NO_RM }}</td>
                                        <td>{{ $dm->NAMA_PASIEN }}</td>
                                        <td>{{ $dm->umur }}</td>
                                        <td>{{ $dm->jenis_kelamin }}</td>
                                        <td>{{ $dm->kasus_BARU }}</td>
                                        <td>{{ $dm->kasus_LAMA }}</td>
                                        <td>{{ $dm->TGL_MASUK }}</td>
                                        <td>{{ $dm->TGL_KELUAR }}</td>
                                        <td>{{ $dm->KODEICD }}</td>
                                        <td>{{ $dm->DESA }}</td>
                                        <td>{{ $dm->KECAMATAN }}</td>
                                        <td>{{ $dm->KOTA }}</td>
                                        <td>{!! wordwrap($dm->ALAMAT ?? '-', 50, "<br>\n") !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

@endsection
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTableBaru').DataTable({
                "scrollY": "600px", // Set the height of the scroll area
                "scrollCollapse": true, // Allow the table to shrink or grow
                "paging": false // Disable pagination
            });

        });
    </script>

@endsection
