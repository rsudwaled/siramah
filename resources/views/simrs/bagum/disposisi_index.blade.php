@extends('adminlte::page')
@section('title', 'Disposisi')
@section('content_header')
    <h1>Disposisi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-envelope" collapsible title="Disposisi">
                <div class="row">
                    <div class="col-md-8 mb-1">
                        <x-adminlte-button label="Refresh" class="btn-sm" theme="warning" title="Refresh User"
                            icon="fas fa-sync" onclick="window.location='{{ route('disposisi.index') }}'" />
                    </div>
                    <div class="col-md-4 mb-1">
                        <form action="" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Nama / Perihal"
                                igroup-size="sm" value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari!" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-card>
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @foreach ($surats as $item)
                        <li class="item withLoad">
                            <a href="{{ route('disposisi.edit', $item->id_surat_masuk) }}">
                                @if ($item->disposisi)
                                    @if ($item->tanda_terima)
                                        <div class="product-img rounded-circle bg-success">
                                            <i class="fas fa-clipboard-check fa-xl m-2 d-flex p-2 "></i>
                                        </div>
                                    @else
                                        <div class="product-img rounded-circle bg-warning">
                                            <i class="fas fa-envelope-open-text fa-xl m-2 d-flex p-2 "></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="product-img rounded-circle bg-danger">
                                        <i class="fas fa-envelope fa-xl m-2 d-flex p-2 "></i>
                                    </div>
                                @endif
                                <div class="product-info">
                                    <div class="product-title">
                                        {{ $item->asal_surat }}
                                        @if ($item->tanda_terima)
                                            <span class="badge badge-success float-right">{{ $item->tanda_terima }}</span>
                                        @else
                                            @if ($item->ttd_direktur)
                                                <span class="badge badge-warning float-right">Direktur</span>
                                            @else
                                                <span class="badge badge-danger float-right">Belum</span>
                                            @endif
                                        @endif
                                    </div>
                                    <span class="product-description">
                                        Perihal : <b>{{ $item->perihal }}</b>
                                        @if ($item->disposisi)
                                            <br>
                                            Ditujukan : {{ $item->pengolah }}
                                        @endif
                                        <br>
                                        Tgl Input : {{ $item->created_at }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <br>
                <div class="text float-left ">
                    Data yang ditampilkan {{ $surats->count() }} dari total {{ $surats->total() }}
                </div>
                <div class="float-right pagination-sm">
                    {{ $surats->appends(request()->input())->onEachSide(1)->links() }}
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BsCustomFileInput', true)
