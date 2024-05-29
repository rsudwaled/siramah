@extends('adminlte::page')
@section('title', 'Pasien BPJS PROSES')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>DAFTAR / BPJS PROSES</h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <form action="" method="get">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="date" class="form-control"
                                            value="{{ $request->date != null ? \Carbon\Carbon::parse($request->date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a onClick="window.location.reload();" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync"></i> Refresh</a>
                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        @php
                            $heads = [
                                'Pasien',
                                'Alamat',
                                'Kunjungan',
                                'Tgl Masuk',
                                'Diagnosa',
                                'Status Kunjungan',
                                'Detail',
                            ];
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
