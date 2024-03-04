@extends('adminlte::page')
@section('title', 'Tambah Bayi Baru')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Tambah Bayi Baru</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.cari') }}" class="btn btn-sm bg-purple">Data
                            Pasien Bayi Terdaftar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.index') }}"
                            class="btn btn-sm btn-success">Daftar Bayi By Kun Kebidanan</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="purple" collapsible>
                <div class="col-lg-12">
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
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-input name="nik" label="NIK" value="{{ $request->nik }}"
                                            placeholder="Cari Berdasarkan NIK">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-success">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="nomorkartu" label="Nomor Kartu"
                                            value="{{ $request->nomorkartu }}" placeholder="Berdasarkan Nomor Kartu BPJS">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
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
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
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
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="alert alert-success alert-dismissible">
                                <h5>
                                    <i class="icon fas fa-users"></i>Info Orang Tua Bayi:
                                </h5>
                            </div>
                            @if (isset($pasien))
                                <div class="row mt-5">
                                    @php
                                        $heads = ['Pasien', 'Aksi'];
                                        $config['order'] = false;
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['scrollY'] = '500px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" head-theme="dark"
                                        :config="$config" striped bordered hoverable compressed>
                                        @foreach ($pasien as $data)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('edit-pasien', ['rm' => $data->no_rm]) }}"
                                                        target="__blank">
                                                        <b>
                                                            RM : {{ $data->no_rm }}<br>
                                                            NIK : {{ $data->nik_bpjs }} <br>
                                                            BPJS : {{ $data->no_Bpjs }} <br>
                                                            PASIEN : {{ $data->nama_px }}
                                                        </b> <br><br>
                                                        <small>alamat : {{ $data->alamat ?? '-' }} / <br>
                                                            {{ $data->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : ($data->desa == null ? 'Desa: -' : 'Desa. ' . $data->desas->nama_desa_kelurahan) . ($data->kecamatan == null ? 'Kec. ' : ' , Kec. ' . $data->kecamatans->nama_kecamatan) . ($data->kabupaten == null ? 'Kab. ' : ' - Kab. ' . $data->kabupatens->nama_kabupaten_kota) }}</small>
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <x-adminlte-button type="button" data-rm="{{ $data->no_rm }}"
                                                        data-nama="{{ $data->nama_px }}" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        class="btn-flat btn-xs btn-singkron bg-purple" label="PILIH DATA" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert bg-purple alert-dismissible">
                                        <h5>
                                            <i class="icon fas fa-users"></i>Informasi
                                            Bayi :
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="form_add_bayi" method="post"
                                        action="{{ route('pasien-bayi.store-bayi') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="rm_ibu" id="rm_ibu" label="RM ORANGTUA **"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="nama_ortu" id="nama_ortu"
                                                    label="NAMA ORANGTUA **" type="text" readonly disable-feedback />
                                                <x-adminlte-input name="nik_ortu" id="nik_ortu" label="NIK ORANGTUA **"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="no_bpjs" id="no_bpjs" label="BPJS ORANGTUA **"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="kontak" label="Kontak *" placeholder="no tlp"
                                                    disable-feedback />
                                                <x-adminlte-select name="hub_keluarga" label="Hubungan Dengan Pasien *">
                                                    @foreach ($hb_keluarga as $item)
                                                        <option value="{{ $item->kode }}">
                                                            {{ $item->nama_hubungan }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                            </div>
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi *"
                                                    required placeholder="masukan nama bayi" disable-feedback />

                                                <x-adminlte-input name="tempat_lahir_bayi" id="tempat_lahir_bayi"
                                                    label="Kota Lahir *" required
                                                    placeholder="masukan kota ketika bayi lahir" disable-feedback />

                                                @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                                <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" required
                                                    label="Tanggal Lahir *" :config="$config"
                                                    value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text bg-primary">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input-date>
                                                <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi"
                                                    required>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </x-adminlte-select>

                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button form="form_add_bayi"
                                                        class="float-right ml-2 btn-sm" type="submit" theme="success"
                                                        label="Simpan Data" />
                                                    <a href="{{ route('daftar-igd.v1') }}"
                                                        class="float-right btn btn-sm btn-secondary">Kembali</a>
                                                </x-slot>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-singkron').on('click', function() {
                let rm = $(this).data('rm');
                let nama = $(this).data('nama');
                let nik = $(this).data('nik');
                let nomorkartu = $(this).data('nomorkartu');

                $('#rm_ibu').val(rm);
                $('#nik_ortu').val(nik);
                $('#nama_ortu').val(nama);
                $('#no_bpjs').val(nomorkartu);

            });
        });
    </script>
@endsection
