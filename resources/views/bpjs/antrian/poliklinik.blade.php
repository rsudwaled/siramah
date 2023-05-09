@extends('adminlte::page')
@section('title', 'Poliklinik - Antrian BPJS')
@section('content_header')
    <h1>Poliklinik Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Referensi Poliklinik Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['Nama Subspesialis', 'Kode Subspesialis', 'Nama Poli', 'Kode Poli', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @if ($polikliniks)
                        @foreach ($polikliniks as $poliklinik)
                            <tr>
                                <td>{{ $poliklinik->nmsubspesialis }}</td>
                                <td>{{ $poliklinik->kdsubspesialis }}</td>
                                <td>{{ $poliklinik->nmpoli }}</td>
                                <td>{{ $poliklinik->kdpoli }}</td>
                                <td>
                                    @if ($poliklinik_save->where('kodesubspesialis', $poliklinik->kdsubspesialis)->first())
                                        <button class="btn btn-secondary btn-xs">Sudah Ada</button>
                                    @else
                                        <form action="{{ route('poliklinik.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="kodepoli" value="{{ $poliklinik->kdpoli }}">
                                            <input type="hidden" name="namapoli" value="{{ $poliklinik->nmpoli }}">
                                            <input type="hidden" name="kodesubspesialis"
                                                value="{{ $poliklinik->kdsubspesialis }}">
                                            <input type="hidden" name="namasubspesialis"
                                                value="{{ $poliklinik->nmsubspesialis }}">
                                            <button type="submit" class="btn btn-success btn-xs">Tambah</button>
                                        </form>
                                    @endif
                                </td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
            <x-adminlte-card title="Referensi Poliklinik Fingerprint Antrian BPJS" theme="secondary" collapsible>
                @php
                    $heads = ['Nama Subspesialis', 'Kode Subspesialis', 'Nama Poli', 'Kode Poli', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" hoverable bordered compressed>
                    @if ($fingerprint)
                        @foreach ($fingerprint as $poliklinik)
                            <tr>
                                <td>{{ $poliklinik->namasubspesialis }}</td>
                                <td>{{ $poliklinik->kodesubspesialis }}</td>
                                <td>{{ $poliklinik->namapoli }}</td>
                                <td>{{ $poliklinik->kodepoli }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
