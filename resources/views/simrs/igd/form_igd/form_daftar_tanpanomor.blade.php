@extends('adminlte::page')

@section('title', 'Pasien IGD')
@section('content_header')
    <h1>Pasien IGD : {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            
                            <h3 class="profile-username text-center">RM : {{ $pasien->no_rm }}</h3>
                            <p class="text-muted text-center">Nama : {{ $pasien->nama_px }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Jenis Kelamin :
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b></li>
                                <li class="list-group-item"><b>Alamat : {{ $pasien->alamat }}</b></li>
                                <li class="list-group-item"><b>NIK : {{ $pasien->nik_bpjs }}</b></li>
                                <li class="list-group-item"><b>BPJS :
                                        {{ $pasien->no_Bpjs == null ? 'tidak punya bpjs' : $pasien->no_Bpjs }}</b></li>
                                <li class="list-group-item"><b>Telp :
                                        {{ $pasien->no_telp == null ? $pasien->no_hp : $pasien->no_telp }}</b></li>
                            </ul>
                            <a class="btn btn-primary bg-gradient-primary btn-block"><b>No Antri :
                                    -</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <x-adminlte-card theme="primary" size="sm" collapsible title="Riwayat Kunjungan :">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    @php
                                        $heads = ['Kunjungan', 'Kode Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Status'];
                                        $config['order'] = ['0', 'asc'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['scrollY'] = '300px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
                                        striped bordered hoverable compressed>
                                        @foreach ($kunjungan as $item)
                                            <tr>
                                                <td>{{ $item->counter }}</td>
                                                <td>{{ $item->kode_kunjungan }}</td>
                                                <td>{{ $item->unit->nama_unit }}</td>
                                                <td>{{ $item->tgl_masuk }}</td>
                                                <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                                </td>
                                                <td>{{ $item->kode_penjamin }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-success disabled' : ($item->status_kunjungan == 1 ? 'btn-danger' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'kunjungan ditutup' : ($item->status_kunjungan == 1 ? 'kunjungan aktif' : 'kunjungan dibatalkan') }}</button>

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
            <div class="row">
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header">
                            <h4>Status Pasien :</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a class="btn btn-app btn-block bg-maroon"><i class="fas fa-user-tag"></i>
                                            PASIEN UMUM </a>
                                    </div>
                                    <div class="col-lg-6">
                                        <a class="btn btn-app btn-block bg-success"><i class="fas fa-users"></i>
                                            -</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" size="sm" icon="fas fa-info-circle"
                                collapsible title="Form Pendaftaran">
                                <form action="{{ route('store.tanpaAntrianIgd') }}" id="formPendaftaranIGD"
                                    method="post">
                                    @csrf
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="nama_pasien"
                                                                value="{{ $pasien->nama_px }}" disabled label="Nama Pasien"
                                                                enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">
                                                                        {{ $pasien->no_rm }}</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                            <input type="hidden" name="nik"
                                                                value="{{ $pasien->nik_bpjs }}">
                                                            <input type="hidden" name="rm"
                                                                value="{{ $pasien->no_rm }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="unit_ugd_id" value="1002" disabled
                                                                label="Daftar UGD" placeholder="UGD" enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">UGD</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                            <input type="hidden" name="unit" value="1002">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                                <option value="">--Pilih Dokter--</option>
                                                                @foreach ($paramedis as $item)
                                                                    <option value="{{ $item->kode_paramedis }}">
                                                                        {{ $item->nama_paramedis }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tanggal"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal" :config="$config" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                                                <option value="">--Pilih Penjamin--</option>
                                                                @foreach ($penjamin as $item)
                                                                    <option value="{{ $item->kode_penjamin }}">
                                                                        {{ $item->nama_penjamin }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="alasan_masuk_id"
                                                                label="Alasan Pendaftaran">
                                                                <option value="">--Pilih Alasan--</option>
                                                                @foreach ($alasanmasuk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->alasan_masuk }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($knj_aktif == 0)
                                            <x-adminlte-button type="submit"
                                                class="withLoad btn btn-sm m-1 bg-green float-right" id="submitPasien"
                                                label="Simpan Data" />
                                            <a href="{{ route('d-antrian-igd') }}" class=" btn btn-sm btn-flat m-1 bg-danger float-right">Batalkan Pendaftaran</a>
                                        @else
                                            <x-adminlte-button class=" btn btn-sm m-1 bg-danger float-right"
                                                label="tidak bisa lanjut daftar" />
                                            <x-adminlte-button class=" btn btn-sm btn-flat m-1 bg-secondary float-right"
                                                label="Kembali"  />
                                        @endif
                                    </div>
                                </form>
                            </x-adminlte-card>
                        </div>
                    </div>
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
