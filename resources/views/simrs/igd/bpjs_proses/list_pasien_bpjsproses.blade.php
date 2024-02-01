@extends('adminlte::page')
@section('title', 'Pasien BPJS PROSES')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>DAFTAR / BPJS PROSES</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Filter Data</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input id="new-event" type="date" name="date" class="form-control"
                                                    value="{{ $request->date != null ? \Carbon\Carbon::parse($request->date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    placeholder="Event Title">
                                                <div class="input-group-append">
                                                    <button id="add-new-event" type="submit"
                                                        class="btn btn-primary btn-sm withLoad">Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Data Pasien BPJS Proses</h3>
                    <div class="card-tools">
                        <button type="button" class="btn bg-purple btn-sm">
                            <i class="far fa-id-badge"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-square"></i>
                        </button>
                        <button onClick="window.location.reload();" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body mt-1">
                    <div class="table-responsive mailbox-messages">
                        @php
                            $heads = ['Pasien', 'Alamat', 'Kunjungan', 'Tgl Masuk', 'Diagnosa', 'Status Kunjungan', 'Detail'];
                            $config['order'] = false;
                            $config['paging'] = false;
                            $config['info'] = false;
                            $config['scrollY'] = '600px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                        @endphp
                        <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                            :config="$config" striped bordered hoverable compressed>
                            @foreach ($kunjungan as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('edit-pasien', ['rm' => $item->no_rm]) }}" target="__blank">
                                            <b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->pasien->no_rm }} <br>NIK
                                            :
                                            {{ $item->pasien->nik_bpjs }} <br>No Kartu : {{ $item->pasien->no_Bpjs }}
                                        </a>
                                    </td>
                                    <td>
                                        <small>alamat : {{ $item->pasien->alamat }}</small>
                                    </td>
                                    <td>
                                        @if ($item->lakalantas > 0 && $item->lakalantas == 1)
                                            <small>
                                                <b>KLL & BUKAN KECELAKAAN KERJA (BKK)</b>
                                            </small> <br>
                                        @elseif ($item->lakalantas > 0 && $item->lakalantas == 2)
                                            <small>
                                                <b>KLL & KK</b>
                                            </small> <br>
                                        @elseif ($item->lakalantas > 0 && $item->lakalantas == 3)
                                            <small>
                                                <b>KECELAKAAN KERJA</b>
                                            </small> <br>
                                        @endif
                                        {{ $item->kode_kunjungan }} <br>
                                        ({{ $item->unit->nama_unit }})
                                        <br>

                                    </td>
                                    <td>{{ $item->tgl_masuk }}</td>
                                    <td>{{ $item->diagx }}</td>
                                    <td>{{ $item->status->status_kunjungan }}</td>
                                    <td>
                                        <a href="{{ route('pasien-bpjs-proses.detail', ['kunjungan' => $item->kode_kunjungan]) }}"
                                            class="btn btn-success btn-xs btn-block btn-flat withLoad">Detail</a>

                                    </td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
