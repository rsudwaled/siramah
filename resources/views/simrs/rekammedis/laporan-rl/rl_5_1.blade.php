@extends('adminlte::page')
@section('title', 'Laporan RL 5.1')
@section('content_header')
    <h1>Laporan RL 5.1</h1>
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
                        <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm col-md-4" theme="primary"
                            label="Lihat Laporan" />
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-card title="Data Kunjungan" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">PASIEN BARU</span>
                                    <span class="info-box-number"><h4>{{$baru}}</h4></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-sm nowrap" id="myTableBaru">
                            <thead>
                                <tr>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kunjungans1 as $kunjungan)
                                    <tr>
                                        <td>
                                            {{ $kunjungan->no_rm??'-' }}
                                        </td>
                                        <td>{{ $kunjungan->no_rm && $kunjungan->pasien ? $kunjungan->pasien->nama_px : '-' }}</td>
                                        <td>
                                            <strong>
                                                STATUS : {{ $kunjungan->status_kunjungan}} <br>
                                                COUNTER: {{ $kunjungan->counter }} <br>
                                                JENIS: {{ $kunjungan->counter == '1' ? 'BARU' : 'LAMA' }}
                                            </strong>
                                        </td>
                                        <td>
                                            <button class="btn-sm btn-warning btn-detail"
                                                data-no-rm="{{ $kunjungan->no_rm }}" data-start="{{ $startdate }}"
                                                data-end="{{ $enddate }}">Detail</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-user-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">PASIEN LAMA</span>
                                    <span class="info-box-number"><h4>{{$lama}}</h4></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-sm nowrap" id="myTableLama">
                            <thead>
                                <tr>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kunjungans2 as $kunjungan)
                                    <tr>
                                        <td>
                                            {{ $kunjungan->no_rm??'-' }}
                                        </td>
                                        <td>{{ $kunjungan->no_rm && $kunjungan->pasien ? $kunjungan->pasien->nama_px : '-' }}</td>
                                        <td>
                                            <strong>
                                                STATUS : {{ $kunjungan->status_kunjungan}} <br>
                                                COUNTER: {{ $kunjungan->counter }} <br>
                                                JENIS: {{ $kunjungan->counter == '1' ? 'BARU' : 'LAMA' }}
                                            </strong>
                                        </td>
                                        <td>
                                            <button class="btn-sm btn-warning btn-detail"
                                                data-no-rm="{{ $kunjungan->no_rm }}" data-start="{{ $startdate }}"
                                                data-end="{{ $enddate }}">Detail</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Kunjungan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detailContent">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
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
            $('#myTableLama').DataTable({
                "scrollY": "600px", // Set the height of the scroll area
                "scrollCollapse": true, // Allow the table to shrink or grow
                "paging": false // Disable pagination
            });

            $('.btn-detail').on('click', function() {
                var noRm = $(this).data('no-rm');
                var start = $(this).data('start');
                var end = $(this).data('end');
                $.ajax({
                    url: '{{ route('laporan-rm.detail-laporan-rl51') }}', // Pastikan ini adalah URL yang benar untuk API Anda
                    method: 'GET',
                    data: {
                        no_rm: noRm,
                        startdate: start,
                        enddate: end,
                    },
                    success: function(response) {
                        $('#detailContent').html(response);
                        $('#detailModal').modal('show');
                    },
                    error: function() {
                        $('#detailContent').html('<p>Error loading details.</p>');
                    }
                });
            });

        });
    </script>

@endsection
