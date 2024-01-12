@extends('adminlte::page')
@section('title', 'Riwayat Pasien')
@section('content_header')
    <h1>Riwayat Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" title="Identitas Pasien">
                <div class="row">
                    <div class="col-md-3">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Nama</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->nama_px }} ({{ $pasien->jenis_kelamin }})</dd>
                            <dt class="col-sm-4 m-0">No RM</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->no_rm }}</dd>
                            <dt class="col-sm-4 m-0">NIK</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->nik_bpjs }}</dd>
                            <dt class="col-sm-4 m-0">No BPJS</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->no_Bpjs }}</dd>
                            <dt class="col-sm-4 m-0">No IHS</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->ihs }}</dd>
                            <dt class="col-sm-4 m-0">No HP</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->no_hp }}</dd>
                            <dt class="col-sm-4 m-0">Tgl Lahir</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->tgl_lahir }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Tgl Entry</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->tgl_entry }}</dd>
                            <dt class="col-sm-4 m-0">PIC</dt>
                            <dd class="col-sm-8 m-0">{{ $pasien->pic }}</dd>
                        </dl>
                    </div>
                </div>
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs" theme="warning" label="Sync BPJS" icon="fas fa-sync" />
                    <x-adminlte-button class="btn-xs" theme="warning" label="Sync Satu Sehat" icon="fas fa-sync" />
                    <x-adminlte-button class="btn-xs" theme="warning" label="Hasil Lab" icon="fas fa-sync" />
                </x-slot>
            </x-adminlte-card>
            <x-adminlte-card theme="secondary" title="Kunjungan Pasien">
                A card without header...
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(function() {

        });
    </script>
@endsection
