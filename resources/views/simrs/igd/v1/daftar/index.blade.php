@extends('adminlte::page')
@section('title', 'DAFTAR IGD')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>DAFTAR PENDAFTARAN</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien-baru.create') }}" class="btn btn-sm bg-purple">Pasien
                            Baru</a></li>
                    <li class="breadcrumb-item"><a href="#" class="btn btn-sm bg-danger">Daftar Ranap Langsung</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-kecelakaan.index') }}"
                            class="btn btn-sm btn-primary">Daftar Pasien Kecelakaan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.index') }}"
                            class="btn btn-sm btn-success">Daftar
                            Pasien Bayi</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('daftar-igd.v1') }}"
                            class="btn btn-sm btn-warning"><i class="fas fa-sync"></i></a></li>
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
                                    DATA PENCARIAN PASIEN : <x-adminlte-button label="Refresh Data Pasien"
                                        class="btn-flat btn-sm" theme="warning" icon="fas fa-retweet"
                                        onClick="window.location.reload();" />
                                </h5>

                            </div>
                            @if (isset($pasien))
                                <div class="row">
                                    @php
                                        $heads = ['Pasien', 'Aksi'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['searching'] = false;
                                        $config['scrollY'] = '500px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
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
                                                        <small>
                                                            Alamat : {{ $data->alamat ?? '-' }} / <br>
                                                            {{ $data->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : ($data->desa == null ? 'Desa: -' : 'Desa. ' . $data->desas->nama_desa_kelurahan) . ($data->kecamatan == null ? 'Kec. ' : ' , Kec. ' . $data->kecamatans->nama_kecamatan) . ($data->kabupaten == null ? 'Kab. ' : ' - Kab. ' . $data->kabupatens->nama_kabupaten_kota) }}
                                                        </small> <br>
                                                        <small>Kontak :
                                                            {{ $data->no_tlp == null ? $data->no_hp : $data->no_tlp }}</small>
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <x-adminlte-button type="button" data-rm="{{ $data->no_rm }}"
                                                        data-nama="{{ $data->nama_px }}"
                                                        data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-kontak="{{ $data->no_tlp == null ? $data->no_hp : $data->no_tlp }}"
                                                        class="btn-flat btn-xs btn-pilihPasien bg-purple"
                                                        label="PILIH DATA" />

                                                    <x-adminlte-button type="button" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-rm="{{$data->no_rm}}"
                                                        class="btn-flat btn-xs btn-cekBPJS bg-success"
                                                        label="Cek Status BPJS" />

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
                                            <i class="fas fa-tasks"></i> Form Pendaftaran:
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="" id="formPendaftaranIGD" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="rm" id="rm_terpilih" label="RM PASIEN"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="nama_ortu" id="nama_ortu" label="NAMA ORANGTUA"
                                                    type="text" readonly disable-feedback />
                                                <div class="form-group">
                                                    <label for="exampleInputBorderWidth2">NIK
                                                        <code id="note_nik">(mohon nik WAJIB DIISI)</code></label>
                                                    <input type="number" name="nik_bpjs" id="nik_bpjs"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputBorderWidth2">NO KARTU
                                                        <code id="note_nik">(mohon NO KARTU WAJIB DIISI untuk pasien
                                                            BPJS)</code></label>
                                                    <input type="number" name="no_bpjs" id="no_bpjs"
                                                        class="form-control">
                                                </div>
                                                <x-adminlte-input name="noTelp" id="noTelp" type="number"
                                                    label="No Telpon" />
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tanggal"
                                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                                    :config="$config" />

                                            </div>
                                            <div class="col-lg-6">
                                                <x-adminlte-select name="jp" label="Pilih Unit">
                                                    <option value="">--Pilih Unit--</option>
                                                    <option value="1">IGD</option>
                                                    <option value="0">IGK</option>
                                                </x-adminlte-select>

                                                <div class="form-group">
                                                    <label for="exampleInputBorderWidth2">Jenis Pasien <br>
                                                        <code>
                                                            [ silahkan ceklis untuk pasien bpjs masih proses
                                                            <label for="exampleInputBorderWidth2">BPJS
                                                                <code>( <input type="checkbox" value="0"
                                                                        name="bpjsProses" id="bpjsProses" class="mt-1">
                                                                    )
                                                                </code>
                                                            </label>
                                                            ]
                                                        </code>
                                                    </label>
                                                    <select name="isBpjs" id="isBpjs"class="form-control">
                                                        <option value="">--Pilih Jenis Pasien--</option>
                                                        <option value="0">Pasien UMUM</option>
                                                        @if (!empty($resdescrtipt->response))
                                                            <option value="1"
                                                                {{ $resdescrtipt->response->peserta->statusPeserta->keterangan === 'AKTIF' ? 'selected' : '' }}>
                                                                Pasien BPJS</option>
                                                        @else
                                                            <option value="1">Pasien BPJS</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group" id="show_penjamin_umum">
                                                    <x-adminlte-select2 name="penjamin_id_umum" label="Pilih Penjamin">
                                                        @foreach ($penjamin as $item)
                                                            <option value="{{ $item->kode_penjamin }}">
                                                                {{ $item->nama_penjamin }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="form-group" id="show_penjamin_bpjs">
                                                    <x-adminlte-select2 name="penjamin_id_bpjs"
                                                        label="Pilih Penjamin BPJS">
                                                        @foreach ($penjaminbpjs as $item)
                                                            <option value="{{ $item->kode_penjamin_simrs }}">
                                                                {{ $item->nama_penjamin_bpjs }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                    <option value="">--Pilih Dokter--</option>
                                                    @foreach ($paramedis as $item)
                                                        <option value="{{ $item->kode_paramedis }}">
                                                            {{ $item->nama_paramedis }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Masuk">
                                                    <option value="">--Pilih Alasan--</option>
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->alasan_masuk }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <div class="form-group">
                                                    <label for="exampleInputBorderWidth2">Perujuk
                                                        <code>(nama faskes yang merujuk)</code></label>
                                                    <select name="isPerujuk" id="isPerujuk" class="form-control">
                                                        <option value="0">Tanpa Perujuk</option>
                                                        <option value="1">Tambah Perujuk</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="perujuk">
                                                    <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                                                    <input type="text" name="nama_perujuk" class="form-control"
                                                        id="nama_perujuk">
                                                </div>
                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button type="submit"
                                                        onclick="javascript: form.action='{{ route('v1.store-tanpa-noantrian') }}';"
                                                        class="withLoad btn  btn-sm bg-green float-right"
                                                        form="formPendaftaranIGD" label="Simpan Data" />
                                                    <a href="{{ route('list.antrian') }}"
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
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        const isbpjs = document.getElementById('isBpjs');
        const perujuk = document.getElementById('isPerujuk');
        const select = document.getElementById('status_kecelakaan');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        const nolaporan = document.getElementById('noLP');
        const keterangan = document.getElementById('keterangan');
        const tanggalkejadian = document.getElementById('tglKejadian');
        const provinsi = document.getElementById('provinsi');
        $(select).on('change', function() {
            if (select.value > 0 || select.value == null) {
                document.getElementById('div_stts_kecelakaan').style.display = "block";
            } else {
                nolaporan.value = '';
                keterangan.value = '';
                tanggalkejadian.value = '';
                provinsi.value = '';
                document.getElementById('div_stts_kecelakaan').style.display = "none";
            }
        });
        $('#perujuk').hide();
        $(perujuk).on('change', function() {
            if (perujuk.value > 0 || perujuk.value == null) {
                $('#perujuk').show();
            } else {
                $('#perujuk').hide();
            }
        });
        if (isbpjs.value == 1) {
            $('#show_penjamin_umum').hide();
            $('#show_penjamin_bpjs').show();
        } else {
            $('#show_penjamin_bpjs').hide();
            $('#show_penjamin_umum').show();
        }
        $(isbpjs).on('change', function() {
            if (isbpjs.value > 0 || isbpjs.value == null) {
                $('#show_penjamin_umum').hide();
                $('#show_penjamin_bpjs').show();
            } else {
                $('#show_penjamin_umum').show();
                $('#show_penjamin_bpjs').hide();
            }
        });
        $('.btn-pilihPasien').on('click', function() {
            let rm = $(this).data('rm');
            let nama = $(this).data('nama');
            let nik = $(this).data('nik');
            let nomorkartu = $(this).data('nomorkartu');
            let kontak = $(this).data('kontak');

            $('#rm_terpilih').val(rm);
            $('#nik_bpjs').val(nik);
            $('#nama_ortu').val(nama);
            $('#no_bpjs').val(nomorkartu);
            $('#noTelp').val(kontak);
        });

        $('.btn-cekBPJS').on('click', function() {
            var rm = $(this).data('rm');
            var nik = $(this).data('nik');
            var nomorkartu = $(this).data('nomorkartu');
            if (nik) {
                var cekStatusBPJS = "{{ route('cek-status.v1') }}";
                Swal.fire({
                    title: "CEK STATUS BPJS?",
                    text: "silahkan pilih tombol cek status!",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Cek Status!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: cekStatusBPJS,
                            dataType: 'json',
                            data: {
                                nomorkartu: nomorkartu,
                                nik: nik,
                                rm: rm,
                            },
                            success: function(data) {
                                console.log(data)
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: data.keterangan+' '+ '( jenis : ' + data
                                            .jenisPeserta + ')',
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire({
                                        title: "INFO!",
                                        text: data.keterangan+' '+ '( KODE : ' + data
                                            .jenisPeserta + ')',
                                        icon: "info",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                        });
                    }
                });
            }
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#diagAwal").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            $("#provinsi").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_provinsi_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            nama: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $("#kabupaten").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kabupaten_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodeprovinsi: $("#provinsi option:selected").val(),
                            nama: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $("#kecamatan").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kecamatan_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodekabupaten: $("#kabupaten option:selected").val(),
                            nama: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
