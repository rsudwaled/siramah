@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h5>Pasien Rawat Inap</h5>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="nama_pasien" class="form-control" value="{{$request->nama_pasien != null ? $request->nama_pasien:''}}" placeholder="cari nama pasien">
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a onClick="window.location.reload();" class="btn btn-md btn-warning">Refresh</a>
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
        {{-- <div class="col-md-12">
            <x-adminlte-card title="Filter Data Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal " :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="unit" label="Pilih Unit">
                                <option value="">Semua Unit</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->kode_unit }}"
                                        {{ $request->unit == $item->kode_unit ? 'selected' : '' }}>{{ $item->nama_unit }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div> --}}

        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    @php
                        $heads = ['Tgl Masuk / Kunjungan', 'Pasien', 'Alamat', 'Ruangan', 'detail'];
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
                                    <b>
                                        {{ $item->kode_kunjungan }} <br> ({{ $item->nama_unit }})
                                    </b> <br>
                                    {{ $item->tgl_masuk }}
                                </td>
                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->no_rm]) }}" target="__blank">
                                        <b>{{ $item->nama_px }}</b> <br>RM : {{ $item->no_rm }} <br>NIK :
                                        {{ $item->nik_bpjs }} <br>No Kartu : {{ $item->no_Bpjs }}
                                    </a>
                                </td>
                                <td>alamat : {{ $item->alamat }} / <br></td>

                                <td>
                                    <b>
                                       Kamar : {{$item->kamar}} <br>
                                       BED   :  {{$item->no_bed}} <br>
                                       Kelas : {{$item->kelas}} <br>
                                    </b>
                                </td>
                                <td>
                                    <a href="{{ route('detail.kunjungan', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat">Detail</a>
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

@endsection
