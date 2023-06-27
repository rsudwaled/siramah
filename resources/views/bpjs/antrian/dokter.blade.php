@extends('adminlte::page')
@section('title', 'Dokter - Antrian BPJS')
@section('content_header')
    <h1 class="m-0 text-dark">Dokter Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Referensi Dokter Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['No', 'Nama Dokter', 'Kode Dokter', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @foreach ($dokters as $dokter)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dokter->namadokter }}</td>
                            <td>{{ $dokter->kodedokter }}</td>
                            <td>
                                @if ($dokter_jkn_simrs->where('kodedokter', $dokter->kodedokter)->first())
                                    <button class="btn btn-secondary btn-xs">Sudah Ada</button>
                                @else
                                    <form action="{{ route('dokter.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kodedokter" value="{{ $dokter->kodedokter }}">
                                        <input type="hidden" name="namadokter" value="{{ $dokter->namadokter }}">
                                        <button type="submit" class="btn btn-success btn-xs">Tambah</button>
                                    </form>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <a href="{{ route('resetDokter') }}" class="btn btn-warning"><i class="fas fa-sync"></i> Reset Dokter</a>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
