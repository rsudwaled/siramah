@extends('adminlte::page')

@section('title', 'Daftar Tanpa Nomor')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Daftar Tanpa Nomor</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"
                            class="btn btn-sm btn-flat btn-secondary">kembali</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-baru.create') }}"
                            class="btn btn-sm btn-flat bg-purple">Pasien Baru</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('v.tanpa-nomor') }}"
                            class="btn btn-sm btn-flat bg-danger">Refresh</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="card-header">
                                <button type="button" class="btn btn-block bg-gradient-danger btn-sm mb-2"><b>DAFTAR TANPA
                                        NOMOR
                                        ANTRIAN</b></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <x-adminlte-card theme="success" size="xl" collapsible>
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="nik" label="NIK" value="{{ $request->nik }}"
                                        placeholder="Cari Berdasarkan NIK">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit" label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="nomorkartu" label="Nomor Kartu" value="{{ $request->nomorkartu }}"
                                        placeholder="Berdasarkan Nomor Kartu BPJS">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit" label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="nama" label="Nama Pasien" value="{{ $request->nama }}"
                                        placeholder="Berdasarkan Nama Pasien">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit" label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="rm" label="No RM" value="{{ $request->rm }}"
                                        placeholder="Berdasarkan Nomor RM">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit" label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                            </div>
                        </form>
                        @if (isset($pasien))
                            <div class="row mt-5">
                                @php
                                    $heads = ['No', 'Pasien', 'Alamat', 'Aksi'];
                                    $config['order'] = false;
                                    $config['paging'] = true;
                                    $config['info'] = false;
                                    $config['scrollY'] = '500px';
                                    $config['scrollCollapse'] = true;
                                    $config['scrollX'] = true;
                                @endphp
                                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config"
                                    striped bordered hoverable compressed>
                                    @foreach ($pasien as $data)
                                        <tr>
                                            <td>
                                                NIK : {{$data->nik_bpjs}} <br>
                                                BPJS : {{$data->no_Bpjs}}
                                            </td>
                                            <td>
                                                <b>{{ $data->no_rm }}</b><br>
                                                {{ $data->nama_px }}
                                            </td>
                                            <td><small>alamat : {{ $data->alamat }} / <br>
                                                    {{ $data->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $data->desas->nama_desa_kelurahan . ' , Kec. ' . $data->kecamatans->nama_kecamatan . ' - Kab. ' . $data->kabupatens->nama_kabupaten_kota }}</small>
                                            </td>
                                            <td>
                                                <a href="{{route('form-daftar.tanpa-nomor',$data->no_rm)}}" class="btn btn-xs btn-primary">daftarkan</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        @endif
                    </x-adminlte-card>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
@endsection
