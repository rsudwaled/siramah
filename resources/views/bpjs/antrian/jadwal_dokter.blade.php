@extends('adminlte::page')
@section('title', 'Jadwal Dokter - Antrian BPJS')
@section('content_header')
    <h1 class="m-0 text-dark">Jadwal Dokter Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Pencarian Jadwal Dokter" theme="secondary" icon="fas fa-info-circle" collapsible>
                <form action="">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tanggal" value="{{ $request->tanggal }}" placeholder="Silahkan Pilih Tanggal"
                        label="Tanggal Periksa" :config="$config" />
                    <x-adminlte-select2 name="kodepoli" id="kodepoli" label="Poliklinik">
                        @foreach ($polikliniks as $poli)
                            <option value="{{ $poli->kodesubspesialis }}"
                                {{ $request->kodepoli == $poli->kodesubspesialis ? 'selected' : null }}>
                                {{ $poli->kodesubspesialis }} - {{ $poli->namasubspesialis }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-button label="Cari Jadwal Dokter" class="mr-auto withLoad" type="submit" theme="success"
                        icon="fas fa-search" />
                </form>
            </x-adminlte-card>
            <div class="col-12">
                @if ($errors->any())
                    <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-adminlte-alert>
                @endif
                <x-adminlte-card title="Referensi Jadwal Dokter Antrian BPJS" theme="secondary" collapsible>
                    @php
                        $heads = ['No.', 'Hari', 'Jadwal', 'Poliklinik', 'Subspesialis', 'Dokter', 'Kuota', 'Action'];
                    @endphp
                    <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" hoverable bordered compressed>
                        @isset($jadwals)
                            @foreach ($jadwals as $jadwal)
                                <tr class="{{ $jadwal->libur ? 'table-danger' : null }}  ">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jadwal->namahari }} {{ $jadwal->libur ? 'LIBUR' : null }} </td>
                                    <td>{{ $jadwal->jadwal }}</td>
                                    <td>{{ $jadwal->namapoli }} ({{ $jadwal->kodepoli }})</td>
                                    <td>{{ $jadwal->namasubspesialis }} ({{ $jadwal->kodesubspesialis }})</td>
                                    <td>{{ $jadwal->namadokter }} ({{ $jadwal->kodedokter }})</td>
                                    <td>{{ $jadwal->kapasitaspasien }}</td>
                                    <td>
                                        @if ($jadwal_save->where('kodesubspesialis', $jadwal->kodesubspesialis)->where('kodedokter', $jadwal->kodedokter)->where('hari', $jadwal->hari)->first())
                                            <button class="btn btn-secondary btn-xs">Sudah Ada</button>
                                        @else
                                            <form action="{{ route('jadwaldokter.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="kodepoli" value="{{ $jadwal->kodepoli }}">
                                                <input type="hidden" name="namapoli" value="{{ $jadwal->namapoli }}">
                                                <input type="hidden" name="kodesubspesialis"
                                                    value="{{ $jadwal->kodesubspesialis }}">
                                                <input type="hidden" name="namasubspesialis"
                                                    value="{{ $jadwal->namasubspesialis }}">
                                                <input type="hidden" name="kodedokter" value="{{ $jadwal->kodedokter }}">
                                                <input type="hidden" name="namadokter" value="{{ $jadwal->namadokter }}">
                                                <input type="hidden" name="hari" value="{{ $jadwal->hari }}">
                                                <input type="hidden" name="namahari" value="{{ $jadwal->namahari }}">
                                                <input type="hidden" name="jadwal" value="{{ $jadwal->jadwal }}">
                                                <input type="hidden" name="kapasitaspasien"
                                                    value="{{ $jadwal->kapasitaspasien }}">
                                                <input type="hidden" name="libur" value="{{ $jadwal->libur }}">
                                                <button type="submit" class="btn btn-success btn-xs">Tambah</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        </div>
    @stop
    @section('plugins.Datatables', true)
    @section('plugins.TempusDominusBs4', true)
    @section('plugins.Select2', true)
