@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien Bayi')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Kunjungan Kebidanan</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.index') }}"
                            class="btn btn-sm btn-secondary">Kembali</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-baru.bayi-baru') }}"
                            class="btn btn-sm bg-success">Tambah Bayi Baru</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.cari') }}"
                            class="btn btn-sm bg-danger">Refresh</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" size="sm" collapsible title="Riwayat Kunjungan Kebidinanan :">
                <div class="col-lg-12">
                    <div class="row">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="nik" label="NIK" value="{{ $request->nik }}"
                                        placeholder="Cari NIK Orangtua">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="nomorkartu" label="Nomor Kartu"
                                        value="{{ $request->nomorkartu }}" placeholder="Berdasarkan Nomor Kartu Orangtua">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="nama" label="Nama Orangtua" value="{{ $request->nama }}"
                                        placeholder="Berdasarkan Nama Orangtua">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
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
                                        placeholder="Berdasarkan RM Ortu">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
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
                        <div class="col-lg-12">
                            @php
                                $heads = ['DATA BAYI', 'RM ORANGTUA', 'DATA ORANGTUA', 'AKSI'];
                                $config['order'] = ['0', 'desc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '500px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark" :config="$config" striped
                                bordered hoverable compressed>
                                @foreach ($bayi as $item)
                                    <tr>
                                        <td>
                                            RM : {{ $item->rm_bayi }}<br>
                                            <b>NAMA : {{ $item->nama_bayi }}</b><br>
                                            Gender : {{ $item->jk_bayi == 'L' ? 'Laki-Laki' : 'Perempuan' }} <br>
                                            <b>
                                                TTL : {{ $item->tempat_lahir }}, {{ $item->tgl_lahir_bayi }}
                                            </b>
                                        </td>
                                        <td>
                                            RM : {{ $item->rm_ibu }} <br>
                                            <b>NIK : {{ $item->nik_ortu }}</b> <br>
                                            BPJS : {{ $item->no_bpjs_ortu }} <br>
                                        </td>
                                        <td>
                                            <b>Nama : {{ $item->nama_ortu }}</b> <br>
                                            <small>{{ $item->alamat_lengkap_ortu }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('form-umum.ranap-bayi', ['rm' => $item->rm_bayi]) }}"
                                                class="btn bg-purple btn-xs" action="">Daftarkan</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
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
