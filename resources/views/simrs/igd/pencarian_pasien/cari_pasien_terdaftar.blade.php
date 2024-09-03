@extends('adminlte::page')
@section('title', 'PENCARIAN PASIEN')
@section('content_header')
    <div class="alert bg-success alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> PENCARIAN PASIEN :
                </h5>
            </div>
            <div class="col-sm-8">
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row" style="margin-top: -20px;">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <x-adminlte-input name="rm" label="NO RM" value="{{ $request->rm }}"
                                                placeholder="Masukan Nomor RM ....">
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                        label="Cari!" />
                                                </x-slot>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text text-primary">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                            <x-adminlte-input name="nama" label="NAMA PASIEN"
                                                value="{{ $request->nama }}" placeholder="Masukan Nama Pasien ....">
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                        label="Cari!" />
                                                </x-slot>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text text-primary">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                        </div>
                                        <div class="col-lg-6">
                                            <x-adminlte-input name="cari_desa" label="CARI BERDASARKAN DESA"
                                                value="{{ $request->cari_desa }}"
                                                placeholder="Masukan nama desa dengan lengkap...">
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                        label="Cari!" />
                                                </x-slot>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text text-primary">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                            <x-adminlte-input name="cari_kecamatan" label="CARI BERDASARKAN KECAMATAN"
                                                value="{{ $request->cari_kecamatan }}"
                                                placeholder="Masukan nama kecamatan dengan lengkap...">
                                                <x-slot name="appendSlot">
                                                    <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                        label="Cari!" />
                                                </x-slot>
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text text-primary">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $heads = ['RM', 'NAMA', 'TGL LAHIR', 'ALAMAT', 'WILAYAH', 'KUNJUNGAN TERAKHIR'];
                                    $config['paging'] = false;
                                    $config['order'] = ['0', 'desc'];
                                    $config['info'] = false;
                                    $config['searching'] = true;
                                    $config['scrollY'] = '500px';
                                    $config['scrollCollapse'] = true;
                                    $config['scrollX'] = true;
                                @endphp
                                <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                                    :config="$config" striped bordered hoverable compressed>
                                    @foreach ($pasiens as $pasien)
                                        <tr>
                                            <td>{{ $pasien->no_rm }}</td>
                                            <td style="width: 15%">
                                                {{ $pasien->nama_px }} <br>
                                                NIK: {{ $pasien->nik_bpjs??'-' }} <br>
                                                BPJS: {{ $pasien->no_Bpjs??'-' }}
                                            </td>
                                            <td style="width: 12%">{{ strtoupper($pasien->tempat_lahir) . ', ' . \Carbon\Carbon::parse($pasien->tgl_lahir)->format('Y-m-d') }}</td>
                                            <td>{{ $pasien->alamat }}</td>
                                            <td>
                                                {{ ($pasien->lokasiDesa == null ? 'Desa: -' : 'Desa. ' . $pasien->lokasiDesa->name) . ($pasien->lokasiKecamatan == null ? 'Kec. ' : ' , Kec. ' . $pasien->lokasiKecamatan->name) . ($pasien->lokasiKabupaten == null ? 'Kab. ' : ' - Kab. ' . $pasien->lokasiKabupaten->name) }}
                                            </td>
                                            <td>
                                                @php
                                                    // Cari pasien berdasarkan no_rm
                                                    $pasienModel = App\Models\Pasien::where(
                                                        'no_rm',
                                                        $pasien->no_rm,
                                                    )->first();

                                                    // Jika pasien ditemukan, cari kunjungan terakhir
                                                    $latest = $pasienModel
                                                        ? $pasienModel->kunjungans()->latest('tgl_masuk')->first()
                                                        : null;
                                                @endphp
                                                {{ $latest->tgl_masuk??'-' }} <br> <strong>( {{$latest->prefix_kunjungan??'-'}})</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
@endsection
