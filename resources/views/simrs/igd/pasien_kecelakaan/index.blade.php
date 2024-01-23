@extends('adminlte::page')

@section('title', 'PASIEN KECELAKAAN')
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h5>FORM PENCARIAN DATA PASIEN</h5>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('pasien-baru.create') }}" class="btn btn-sm bg-purple " target="__blank">PASIEN BARU</a></li>
                <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"  class="btn btn-sm btn-secondary">Kembali</a></li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" size="sm" collapsible title="Cari Pasien :">
                <div class="col-lg-12">
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
                            <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" head-theme="dark" :config="$config" striped
                                bordered hoverable compressed>
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
                                        <td><small>alamat : {{ $data->alamat??'-' }} / <br>
                                                {{ $data->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : (($data->desa == null ? 'Desa: -':'Desa. '.$data->desas->nama_desa_kelurahan ). ($data->kecamatan==null?'Kec. ':' , Kec. ' . $data->kecamatans->nama_kecamatan ). ($data->kabupaten==null?'Kab. ':' - Kab. ' . $data->kabupatens->nama_kabupaten_kota)) }}</small>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary withLoad">daftarkan</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    @endif
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
    <script>
        
    </script>
@endsection
