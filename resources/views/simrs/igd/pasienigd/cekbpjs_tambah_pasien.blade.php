@extends('adminlte::page')
@section('title', 'Tambah pasien')
@section('content_header')
    <div class="alert bg-purple alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i> TAMBAH PASIEN BARU :
        </h5>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-purple">
                <div class="card-header">
                    <h3 class="card-title">PASIEN TERDAFTAR PADA SISTEM</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body" style="display: block;">
                    <table id="table1" class="semuaKunjungan table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NO RM</th>
                                <th>NAMA</th>
                                <th>TTL</th>
                                <th>ALAMAT</th>
                                <th>TGL DIBUAT</th>
                                <th>PETUGAS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasienTerdaftar as $pasien)
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>{{ $pasien->no_rm }}</td>
                                    <td>{{ $pasien->nama_px }}</td>
                                    <td>{{ $pasien->tempat_lahir }}, {{ $pasien->tgl_lahir }}</td>
                                    <td>{{ $pasien->alamat }}</td>
                                    <td>{{ $pasien->tgl_entry }}</td>
                                    <td>{{ $pasien->user_create }}</td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                            <tr class="expandable-body d-none">
                                <td colspan="7">
                                    {{-- <p style="display: none;"></p> --}}
                                    <div class="col-12" style="display: none;">
                                        <div class="card card-primary card-outline card-outline-tabs">
                                            <div class="card-header p-0 border-bottom-0">
                                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-four-home-tab"
                                                            data-toggle="pill" href="#custom-tabs-four-home" role="tab"
                                                            aria-controls="custom-tabs-four-home" aria-selected="true">FORM
                                                            PENDAFTARAN</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-profile-tab"
                                                            data-toggle="pill" href="#custom-tabs-four-profile"
                                                            role="tab" aria-controls="custom-tabs-four-profile"
                                                            aria-selected="false">EDIT PASIEN</a>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                                    <div class="tab-pane fade active show" id="custom-tabs-four-home"
                                                        role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                        <form action="" id="formPendaftaranIGD{{ $pasien->no_rm }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <x-adminlte-input name="rm" id="rm_terpilih"
                                                                        value="{{ $pasien->no_rm }}" label="RM PASIEN"
                                                                        type="text" readonly disable-feedback />
                                                                    <x-adminlte-input name="nama_ortu" id="nama_ortu"
                                                                        value="{{ $pasien->nama_px }}" label="NAMA ORANGTUA"
                                                                        type="text" readonly disable-feedback />
                                                                    <div class="form-group">
                                                                        <label for="exampleInputBorderWidth2">NIK
                                                                            <code id="note_nik">(mohon nik WAJIB
                                                                                DIISI)</code></label>
                                                                        <input type="number" name="nik_bpjs" id="nik_bpjs"
                                                                            value="{{ $pasien->nik_bpjs }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputBorderWidth2">NO KARTU
                                                                            <code id="note_nik">(mohon NO KARTU WAJIB DIISI
                                                                                untuk pasien
                                                                                BPJS)</code></label>
                                                                        <input type="number" name="no_bpjs" id="no_bpjs"
                                                                            value="{{ $pasien->no_Bpjs }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <x-adminlte-input name="noTelp" id="noTelp"
                                                                        type="number"
                                                                        value="{{ $pasien->no_hp ?? $pasien->no_tlp }}"
                                                                        label="No Telpon" />
                                                                    @php
                                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                                    @endphp
                                                                    <x-adminlte-input-date name="tanggal"
                                                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                        label="Tanggal" :config="$config" />

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="">Pilih Tujuan</label>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="jp"
                                                                                        value="1" checked="">
                                                                                    <label class="form-check-label">UGD
                                                                                        UMUM</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="jp"
                                                                                        value="0">
                                                                                    <label class="form-check-label">UGD
                                                                                        KEBIDANAN</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Jenis Pasien</label>
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="isBpjs"
                                                                                        value="0" checked="">
                                                                                    <label
                                                                                        class="form-check-label">UMUM</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="isBpjs"
                                                                                        value="1">
                                                                                    <label
                                                                                        class="form-check-label">BPJS</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="isBpjs"
                                                                                        value="2">
                                                                                    <label class="form-check-label">BPJS
                                                                                        PROSES</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group" id="show_penjamin_umum">
                                                                        <x-adminlte-select2 name="penjamin_id_umum"
                                                                            label="Pilih Penjamin">
                                                                            @foreach ($penjamin as $item)
                                                                                <option
                                                                                    value="{{ $item->kode_penjamin }}">
                                                                                    {{ $item->nama_penjamin }}</option>
                                                                            @endforeach
                                                                        </x-adminlte-select2>
                                                                    </div>
                                                                    <div class="form-group" id="show_penjamin_bpjs"
                                                                        style="display: none;">
                                                                        <x-adminlte-select2 name="penjamin_id_bpjs"
                                                                            label="Pilih Penjamin BPJS">
                                                                            @foreach ($penjaminbpjs as $item)
                                                                                <option
                                                                                    value="{{ $item->kode_penjamin_simrs }}">
                                                                                    {{ $item->nama_penjamin_bpjs }}
                                                                                </option>
                                                                            @endforeach
                                                                        </x-adminlte-select2>
                                                                    </div>
                                                                    <x-adminlte-select2 name="dokter_id"
                                                                        label="Pilih Dokter">
                                                                        <option value="">--Pilih Dokter--</option>
                                                                        @foreach ($paramedis as $item)
                                                                            <option value="{{ $item->kode_paramedis }}">
                                                                                {{ strtoupper($item->nama_paramedis) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </x-adminlte-select2>
                                                                    <x-adminlte-select2 name="alasan_masuk_id"
                                                                        label="Alasan Masuk">
                                                                        @foreach ($alasanmasuk as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->alasan_masuk }}</option>
                                                                        @endforeach
                                                                    </x-adminlte-select2>

                                                                    <div class="form-group" id="perujuk">
                                                                        <label for="exampleInputBorderWidth2">Nama
                                                                            Perujuk</label>
                                                                        <input type="text" name="nama_perujuk"
                                                                            class="form-control" id="nama_perujuk">
                                                                    </div>
                                                                    <x-adminlte-button type="submit"
                                                                        onclick="javascript: form.action='{{ route('v1.store-tanpa-noantrian') }}';"
                                                                        class="withLoad btn  btn-sm bg-green float-right"
                                                                        form="formPendaftaranIGD{{ $pasien->no_rm }}"
                                                                        label="Simpan Data" />
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-four-profile"
                                                        role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                                        <div class="row">
                                                            <input type="hidden" name="rm" id="rm"
                                                                value="{{ $pasien->no_rm }}">
                                                            <x-adminlte-input name="nik_pasien_baru"
                                                                value="{{ $pasien->nik_bpjs }}" label="NIK"
                                                                placeholder="masukan nik" fgroup-class="col-md-3"
                                                                disable-feedback />
                                                            <x-adminlte-input name="no_bpjs" label="BPJS"
                                                                value="{{ $pasien->no_Bpjs }}" placeholder="masukan bpjs"
                                                                fgroup-class="col-md-3" disable-feedback />
                                                            <x-adminlte-input name="nama_pasien_baru" label="Nama"
                                                                value="{{ $pasien->nama_px }}"
                                                                placeholder="masukan nama pasien" fgroup-class="col-md-6"
                                                                disable-feedback />
                                                            <x-adminlte-input name="tempat_lahir" label="Tempat lahir"
                                                                placeholder="masukan tempat"
                                                                value="{{ $pasien->tempat_lahir }}"
                                                                fgroup-class="col-md-4" disable-feedback />
                                                            <x-adminlte-select name="jk" label="Jenis Kelamin"
                                                                fgroup-class="col-md-4">
                                                                <option value="L"
                                                                    {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                    Laki-Laki
                                                                </option>
                                                                <option value="P"
                                                                    {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                    Perempuan
                                                                </option>
                                                            </x-adminlte-select>
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                                $tgl_lahir = date(
                                                                    'Y-m-d',
                                                                    strtotime($pasien->tgl_lahir),
                                                                );
                                                            @endphp
                                                            <div class="col-lg-4">
                                                                <label for="">Tanggal Lahir
                                                                    (bulan/tanggal/tahun)</label>
                                                                <input type="date" class="form-control"
                                                                    name="tgl_lahir" id="tgl_lahir"
                                                                    value="{{ $tgl_lahir }}" :config="$config">
                                                            </div>
                                                            <x-adminlte-select name="agama" label="Agama"
                                                                fgroup-class="col-md-4">
                                                                @foreach ($agama as $item)
                                                                    <option value="{{ $item->ID }}"
                                                                        {{ $pasien->agama == $item->ID ? 'selected' : '' }}>
                                                                        {{ $item->agama }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                            <x-adminlte-select name="pekerjaan" label="Pekerjaan"
                                                                fgroup-class="col-md-4">
                                                                @foreach ($pekerjaan as $item)
                                                                    <option value="{{ $item->ID }}"
                                                                        {{ $pasien->pekerjaan == $item->ID ? 'selected' : '' }}>
                                                                        {{ $item->pekerjaan }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                            <x-adminlte-select name="pendidikan" label="Pendidikan"
                                                                fgroup-class="col-md-4">
                                                                @foreach ($pendidikan as $item)
                                                                    <option value="{{ $item->ID }}"
                                                                        {{ $pasien->pendidikan == $item->ID ? 'selected' : '' }}>
                                                                        {{ $item->pendidikan }}
                                                                    </option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                            <x-adminlte-input name="no_telp" id="no_telp"
                                                                label="No Telpon"
                                                                value="{{ $pasien->no_tlp == null ? $pasien->no_hp : $pasien->no_tlp }}"
                                                                placeholder="masukan no tlp" fgroup-class="col-md-4"
                                                                disable-feedback />
                                                            <x-adminlte-select name="kewarganegaraan"
                                                                id="kewarganegaraan_pasien" label="Kewarganegaraan"
                                                                fgroup-class="col-md-4">
                                                                <option value="1"
                                                                    {{ $pasien->kewarganegaraan == '1' ? 'selected' : '' }}>
                                                                    WNI
                                                                </option>
                                                                <option value="0"
                                                                    {{ $pasien->kewarganegaraan == '0' ? 'selected' : '' }}>
                                                                    WNA
                                                                </option>
                                                            </x-adminlte-select>
                                                            <div class="form-group col-lg-4">
                                                                <label for="exampleInputBorderWidth2">Cari Desa</label>
                                                                <select name="desa_pasien" id="desa_pasien"
                                                                    class="select2 form-control"></select>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="selected_desa_info">Informasi Terpilih</label>
                                                                <input type="text" id="selected_desa_info"
                                                                    placeholder="{{ 'Desa ' . $pasien->lokasiDesa->name . ' - ' . optional($pasien->lokasiKecamatan->kecamatan)->name . ' - ' . optional(optional($pasien->lokasiKecamatan->kecamatan)->lokasiKabupaten)->name }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <x-adminlte-select2 name="negara" label="Negara"
                                                                id="negara_pasien" fgroup-class="col-md-12">
                                                                @foreach ($negara as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ ucfirst(strtolower($pasien->negara)) == $item->nama_negara ? 'selected' : ($pasien->negara == $item->id ? 'selected' : '') }}>
                                                                        {{ $item->nama_negara }}
                                                                    </option>
                                                                @endforeach
                                                            </x-adminlte-select2>

                                                            <x-adminlte-textarea name="alamat_lengkap_pasien"
                                                                label="Alamat Lengkap (RT/RW)"
                                                                fgroup-class="col-md-12">{{ $pasien->alamat }}</x-adminlte-textarea>
                                                            <x-adminlte-button type="submit"
                                                                onclick="javascript: form.action='{{ route('v1.store-tanpa-noantrian') }}';"
                                                                class="withLoad btn  btn-sm bg-green float-right"
                                                                form="formPendaftaranIGD" label="Simpan Data" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-purple collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">FORM TAMBAH PASIEN BARU</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body" style="display: none;">
                    <div class="row">
                        @if ($errors->any())
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('pasien-baru.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputRounded0">NIK <code>*<i>( maksimal 16 angka
                                                            )</i></code></label>
                                                <input class="form-control rounded-0" name="nik_pasien_baru"
                                                    value="{{ old('nik_pasien_baru', $nik) }}" type="text"
                                                    placeholder="masukan nik">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputRounded0">BPJS <code>*<i>( maksimal 16 angka
                                                            )</i></code></label>
                                                <input class="form-control rounded-0" name="no_bpjs" type="text"
                                                    value="{{ old('no_bpjs', $noKartu) }}" placeholder="masukan bpjs">
                                            </div>
                                            <x-adminlte-input name="nama_pasien_baru" label="Nama *"
                                                value="{{ old('nama_pasien_baru', $nama) }}"
                                                placeholder="masukan nama pasien" fgroup-class="col-md-12"
                                                disable-feedback />
                                            <x-adminlte-input name="tempat_lahir" label="Tempat lahir *"
                                                value="{{ old('tempat_lahir') }}" placeholder="masukan tempat"
                                                fgroup-class="col-md-6" disable-feedback />
                                            <x-adminlte-select name="jk" label="Jenis Kelamin *"
                                                fgroup-class="col-md-6">
                                                <option value="L" {{ $gender == 'L' ? 'selected' : '' }}>Laki-Laki
                                                </option>
                                                <option value="P" {{ $gender == 'P' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </x-adminlte-select>
                                            <div class="col-lg-6">
                                                <label for="">Tanggal Lahir (bulan/tanggal/tahun)</label>
                                                <input type="date" class="form-control" name="tgl_lahir"
                                                    value="{{ $tglLahir }}">
                                            </div>
                                            <x-adminlte-select name="agama" label="Agama *" fgroup-class="col-md-6">
                                                @foreach ($agama as $item)
                                                    <option value="{{ $item->ID }}">
                                                        {{ $item->agama }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                            <x-adminlte-select name="pekerjaan" label="Pekerjaan *"
                                                fgroup-class="col-md-6">
                                                @foreach ($pekerjaan as $item)
                                                    <option value="{{ $item->ID }}">
                                                        {{ $item->pekerjaan }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                            <x-adminlte-select name="pendidikan" label="Pendidikan *"
                                                fgroup-class="col-md-6">
                                                @foreach ($pendidikan as $item)
                                                    <option value="{{ $item->ID }}">
                                                        {{ $item->pendidikan }}
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputRounded0">No Telpon <code>*<i>( maksimal 16 angka
                                                            )</i></code></label>
                                                <input class="form-control rounded-0" name="no_telp" type="text"
                                                    value="{{ old('no_telp', '000000000000') }}"
                                                    placeholder="masukan no tlp">
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label for="exampleInputBorderWidth2">Cari Desa</label>
                                                <select name="desa_pasien" id="desa_pasien"
                                                    class="select2 form-control"></select>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label for="selected_desa_info">Informasi Terpilih</label>
                                                <input type="text" id="selected_desa_info" class="form-control "
                                                    placeholder="Pilih desa terlebih dahulu" readonly>
                                            </div>
                                            <x-adminlte-textarea name="alamat_lengkap_pasien"
                                                label="Alamat Lengkap (RT/RW) *" placeholder="Alamat Lengkap (RT/RW)"
                                                fgroup-class="col-md-12" />
                                            <div class="form-group col-md-12">
                                                <div class="col-md-12 row">
                                                    <div class="col-md-12">
                                                        <x-adminlte-select name="kewarganegaraan"
                                                            id="kewarganegaraan_pasien" label="Kewarganegaraan *">
                                                            <option value="1">WNI</option>
                                                            <option value="0">WNA</option>
                                                        </x-adminlte-select>
                                                    </div>
                                                    <div class="col-md-12" style="display: none;" id="pilih_negara">
                                                        <label for="" class="col-md-12">Pilih Negara</label>
                                                        <select id="negara_pasien" name="negara"
                                                            class="form-control select2 ">
                                                            @foreach ($negara as $item)
                                                                <option value="{{ $item->nama_negara }}">
                                                                    {{ $item->nama_negara }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissible">
                                    <h5>
                                        <i class="icon fas fa-users"></i>Info Keluarga
                                        Pasien :
                                    </h5>
                                    <h6>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                name="default_alamat_checkbox" value="1" id="default_alamat">
                                            <label class="form-check-label" for="default_alamat">CEKLIS UNTUK MENYAMAKAN
                                                ALAMAT</label>
                                        </div>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputBorderWidth2">Nama Keluarga</label>
                                        <input type="text" name="nama_keluarga" class="form-control"
                                            id="nama_keluarga">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputBorderWidth2">Hubungan Dengan Pasien</label>
                                        <select name="hub_keluarga" id="hub_keluarga" class="form-control">
                                            @foreach ($hb_keluarga as $item)
                                                <option value="{{ $item->kode }}">
                                                    {{ $item->nama_hubungan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6" id="div_kontak">
                                        <label for="exampleInputBorderWidth2">Kontak</label>
                                        <input type="text" name="kontak" id="kontak" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6" id="div_alamat_keluarga">
                                        <label for="exampleInputBorderWidth2">Alamat Keluarga</label>
                                        <textarea name="alamat_lengkap_sodara" class="form-control" id="alamat_lengkap_sodara" cols="30"
                                            rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-secondary">Kembali</a>
                                <button type="submit" class="btn bg-purple btn-sm">Simpan Pasien</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            $('#desa_pasien').select2({
                ajax: {
                    url: "{{ route('desa-pasien.get') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                    kecamatanName: item.kecamatan_name,
                                    kabupatenName: item.kabupaten_name
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Cari Desa',
                minimumInputLength: 1
            });

            $('#desa_pasien').on('select2:select', function(e) {
                var data = e.params.data;
                var info = 'Desa: ' + data.text;
                $('#selected_desa_info').val(info);
            });
        });

        $(document).ready(function() {
            const defaultCheckbox = document.getElementById('default_alamat');

            $(defaultCheckbox).on('change', function() {
                if (this.checked) {
                    var kontak = $('#no_telp').val();
                    var alamat = $('#alamat_lengkap_pasien').val();

                    $('#alamat_lengkap_sodara').val(alamat); // Mengisi alamat sodara dengan alamat pasien
                    $('#kontak').val(kontak); // Mengisi nomor telepon dengan nomor telepon pasien

                    $('#div_alamat_keluarga').hide();
                    $('#div_kontak').hide(); // Menampilkan nomor telepon

                } else {
                    $('#alamat_lengkap_sodara').val('');
                    $('#kontak').val('');

                    $('#div_alamat_keluarga').show();
                    $('#div_kontak').show(); // Menyembunyikan nomor telepon
                }
            });
        });
    </script>
    <script>
        const isbpjs = document.getElementById('isBpjs');
        document.querySelectorAll('input[name="isBpjs"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === '0') {
                    document.getElementById('show_penjamin_umum').style.display = 'block';
                    document.getElementById('show_penjamin_bpjs').style.display = 'none';
                } else {
                    document.getElementById('show_penjamin_bpjs').style.display = 'block';
                    document.getElementById('show_penjamin_umum').style.display = 'none';
                }
            });
        });
    </script>
    <script>
        const kewarganegaraanSelect = document.getElementById('kewarganegaraan_pasien');
        const negaraSelect = document.getElementById('pilih_negara');

        // Function to show or hide the negara select based on the selected value of kewarganegaraan
        function toggleNegaraSelect() {
            const selectedValue = kewarganegaraanSelect.value;
            negaraSelect.style.display = selectedValue === '0' ? 'block' : 'none';
        }

        // Add event listener to the kewarganegaraan select
        kewarganegaraanSelect.addEventListener('change', toggleNegaraSelect);

        // Call the function initially to set the initial state of the negara select
        toggleNegaraSelect();
    </script>
@endsection
