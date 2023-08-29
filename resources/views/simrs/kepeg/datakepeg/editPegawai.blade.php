@extends('adminlte::page')
@section('title', 'Edit Pegawai')
@section('content_header')
    <h1>Edit Pegawai {{ $data->nama_lengkap }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card title="Edit Data Pegawai" theme="success" collapsible>
                <form action="{{ route('data-kepeg.update', $data->id) }}" id="myform" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @php
                        $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <div class="col-lg-6">
                            <x-adminlte-input type="number" value="{{ $data->nik }}" name="nik" label="NIK"
                                placeholder="NIK" enable-old-support required />
                            <x-adminlte-input type="number" value="{{ $data->nip }}" name="nip" label="NIP"
                                placeholder="NIP" enable-old-support required />
                            <x-adminlte-input type="number" value="{{ $data->nip_lama }}" name="nip_lama" label="NIP Lama"
                                placeholder="NIP Lama" enable-old-support />
                            <x-adminlte-input value="{{ $data->nama_lengkap }}" name="nama_lengkap" label="Nama Pegawai"
                                placeholder="Nama Pegawai" enable-old-support required />
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->tempat_lahir }}" name="tempat_lahir" label="Tempat Lahir"
                                        placeholder="Cirebon" enable-old-support required />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="tanggal_lahir" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal Lahir" :config="$config" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-select2 name="jenis_kelamin" required id="jenis_kelamin" label="jenis_kelamin">
                                        <option {{$data->jenis_kelamin === "L" ? 'selected' : ''}} value="L">Laki-Laki</option>
                                        <option {{$data->jenis_kelamin === "P" ? 'selected' : ''}} value="P">Perempuan</option>
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            
                            <x-adminlte-input value="{{ $data->alamat }}" name="alamat" label="Alamat"
                                placeholder="alamat" enable-old-support required />
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->unit_kerja }}" name="unit_kerja" label="Unit Kerja"
                                        enable-old-support required />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->status }}" name="status" label="Status Pegawai"
                                        placeholder="Status Pegawai" enable-old-support required />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->pangkat }}" name="pangkat" label="Pangkat Pegawai"
                                        placeholder="Pangkat Pegawai" enable-old-support required />
                                </div>
                            </div>
                            
                        </div>
                        {{-- right col --}}
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->jabatan }}" name="jabatan" label="Jabatan Pegawai"
                                        placeholder="Jabatan Pegawai" enable-old-support required />
                                </div>
                                <div class="col-md-8">
                                    <x-adminlte-input value="{{ $data->struktural }}" name="struktural" label="Struktural Pegawai"
                                        placeholder="Struktural Pegawai" enable-old-support required />
                                </div>
                            </div>
                            <div class="row">
                                @php
                                $config = ['format' => 'YYYY-MM-DD'];
                                @endphp
                                <div class="col-md-3">
                                    <x-adminlte-input value="{{ $data->eselon }}" name="eselon" label="Eselon Pegawai"
                                        placeholder="Eselon" enable-old-support />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input-date name="tmt_jabatan" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="TMT Jabatan" :config="$config" />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input-date name="tmt_cpns_kontrak" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="TMT CPNS Kontrak" :config="$config" />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input-date name="tmt_pns_pt" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="TMT PNS" :config="$config" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <x-adminlte-input value="{{ $data->gol }}" name="gol" label="Gol Pegawai"
                                        placeholder="Gol Pegawai" enable-old-support />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input-date name="tmt_golru" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="TMT Golru" :config="$config" />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input value="{{ $data->tahun }}" name="tahun" label="Tahun Pegawai"
                                    enable-old-support required />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input value="{{ $data->bulan }}" name="bulan" label="Bulan Pegawai"
                                        placeholder="Bulan Pegawai" enable-old-support required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <x-adminlte-select2 name="jenjang" required id="jenjang" label="jenjang">
                                        @foreach ($pendidikan as $pd)
                                            <option {{$data->jenjang == $pd->id_tingkat ? 'selected' : ''}} value="{{$pd->id_tingkat}}">{{$pd->nama_tingkat}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input value="{{ $data->jurusan }}" name="jurusan" label="Jurusan Pendidikan"
                                        enable-old-support required />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-select2 name="id_bidang" required id="id_bidang" label="Bidang">
                                        @foreach ($bidang as $bd)
                                            <option {{$data->id_bidang == $bd->id ? 'selected' : ''}} value="{{$bd->id}}">{{$bd->nama_bidang}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <x-adminlte-input value="{{ $data->format_pendidikan }}" name="format_pendidikan" label="Format Pendidikan"
                                        enable-old-support required />
                                </div>
                                <div class="col-md-3">
                                    <x-adminlte-input-date name="tahun_kelulusan" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tahun Kelulusan" :config="$config" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->no_str }}" name="no_str" label="No Str"
                                        enable-old-support required />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="tgl_str" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal STR" :config="$config" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="tgl_berlaku_str" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal Berlaku STR" :config="$config" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input value="{{ $data->no_sip }}" name="no_sip" label="No SIP"
                                        enable-old-support required />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="tgl_sip" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal SIP" :config="$config" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input-date name="tgl_berlaku_sip" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                        label="Tanggal Berlaku SIP" :config="$config" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-button form="myform" type="submit" class="float-right" theme="success" label="Simpan" />
            <a href="{{ route('data-kepeg.get') }}" class="btn btn-danger mr-1 float-right">Kembali</a>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)

