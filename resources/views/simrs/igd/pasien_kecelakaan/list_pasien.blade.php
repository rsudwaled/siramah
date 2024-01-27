@extends('adminlte::page')
@section('title', 'Pasien Kecelakaan ')
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h5>Data Pasien Kecelakaan</h5>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('pasien-kecelakaan.index') }}" class="btn btn-sm bg-purple">Daftar Pasien Kecelakaan</a></li>
                <li class="breadcrumb-item"><a onClick="window.location.reload();" 
                        class="btn btn-sm btn-flat btn-warning">refresh</a></li>
                
            </ol>
        </div>
    </div>
</div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Pasien Kecelakaan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="date" label="Tanggal Daftar" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->date)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-button type="submit" class="withLoad mt-4" theme="primary" label="Submit Pencarian" />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    @php
                        $heads = ['Pasien', 'Alamat', 'kunjungan', 'Tgl Masuk', 'Diagnosa', 'No SEP', 'status', 'detail'];
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
                                    <a href="{{route('edit-pasien', ['rm'=>$item->no_rm])}}" target="__blank">
                                        <b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->no_rm }} <br>NIK :
                                        {{ $item->nik_bpjs }} <br>No Kartu : {{ $item->no_Bpjs }}
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
                                    ({{ $item->unit->nama_unit }}) <br>
                                    
                                </td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->diagx }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>{{ $item->status->status_kunjungan }}</td>
                                <td>
                                    <a href="{{route('pasien-kecelakaan.detail',['kunjungan'=>$item->kode_kunjungan])}}" class="btn btn-success btn-xs btn-block btn-flat withLoad">Detail</a>

                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
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
