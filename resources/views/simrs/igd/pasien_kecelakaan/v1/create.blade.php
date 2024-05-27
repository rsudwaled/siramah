@extends('adminlte::page')
@section('title', 'PASIEN KECELAKAAN')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>DAFTAR PASIEN KECELAKAAN</h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item">
                        <a href="{{ route('pasien-kecelakaan.pasien-baru') }}" class="btn btn-sm bg-purple">Pasien Baru</a>
                    </li> --}}
                    <li class="breadcrumb-item">
                        <button class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-pasien-kecelakaan">TAMBAH PASIEN BARU</button>
                    </li>
                    {{-- <li class="breadcrumb-item">
                        <a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-danger">Refresh</a>
                    </li> --}}
                </ol>
            </div>
        </div>
    </div>
    @include('simrs.igd.pasien_kecelakaan.v1.modal_pasien_baru')
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
                                                        data-nama="{{ $data->nama_px }}" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-kontak="{{ $data->no_tlp == null ? $data->no_hp : $data->no_tlp }}"
                                                        class="btn-flat btn-xs btn-pilihPasien bg-purple"
                                                        label="PILIH DATA" />

                                                    <x-adminlte-button type="button" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-rm="{{ $data->no_rm }}"
                                                        class="btn-flat btn-xs btn-cekBPJS bg-success"
                                                        label="Cek Status BPJS" />

                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            @endif

                            @if (isset($newpasien))
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
                                        @foreach ($newpasien as $data)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('edit-pasien', ['rm' => $data->no_rm]) }}"
                                                        target="__blank">
                                                        <b>
                                                            RM : {{ $data->no_rm }}<br>
                                                            NIK : {{ $data->nik_bpjs }} <br>
                                                            BPJS : {{ $data->no_Bpjs }} <br>
                                                            PASIEN : {{ $data->nama_px }}
                                                        </b>
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <x-adminlte-button type="button" data-rm="{{ $data->no_rm }}"
                                                        data-nama="{{ $data->nama_px }}" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-kontak="{{ $data->no_tlp == null ? $data->no_hp : $data->no_tlp }}"
                                                        class="btn-flat btn-xs btn-pilihPasien bg-purple"
                                                        label="PILIH DATA" />

                                                    <x-adminlte-button type="button" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-rm="{{ $data->no_rm }}"
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
                                    <form action="{{ route('pasien-kecelakaan.store') }}" id="formPendaftaranIGD"
                                        method="post">
                                        @csrf
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <x-adminlte-input name="rm" id="rm_terpilih" label="RM PASIEN"
                                                        type="text" readonly disable-feedback />
                                                    <x-adminlte-input name="nama_ortu" id="nama_ortu"
                                                        label="NAMA ORANGTUA" type="text" readonly disable-feedback />
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
                                                    <div class="form-group">
                                                        <label for="">Jenis Pasien</label>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isBpjs" value="0" checked="">
                                                                    <label class="form-check-label">UMUM</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isBpjs" value="1">
                                                                    <label class="form-check-label">BPJS</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="isBpjs" value="2">
                                                                    <label class="form-check-label">BPJS PROSES</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="show_penjamin_umum">
                                                        <x-adminlte-select2 name="penjamin_id_umum"
                                                            label="Pilih Penjamin">
                                                            @foreach ($penjamin as $item)
                                                                <option value="{{ $item->kode_penjamin }}"
                                                                    {{ $item->kode_penjamin == 'P01' ? 'selected' : '' }}>
                                                                    {{ $item->nama_penjamin }}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                    </div>
                                                    <div class="form-group" id="show_penjamin_bpjs"
                                                        style="display: none;">
                                                        <x-adminlte-select2 name="penjamin_id_bpjs"
                                                            label="Pilih Penjamin BPJS">
                                                            @foreach ($penjaminbpjs as $item)
                                                                <option value="{{ $item->kode_penjamin_simrs }}">
                                                                    {{ $item->nama_penjamin_bpjs }}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                    </div>
                                                    <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                                        @foreach ($alasanmasuk as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->alasan_masuk }}</option>
                                                        @endforeach
                                                    </x-adminlte-select>

                                                    <x-adminlte-select name="provinsi" label="Provinsi"
                                                        id="provinsi_pasien">
                                                        @foreach ($provinsi as $item)
                                                            <option value="{{ $item->kode_provinsi }}" {{$item->kode_provinsi==32?'selected':''}}>
                                                                {{ $item->nama_provinsi }}
                                                            </option>
                                                        @endforeach
                                                    </x-adminlte-select>
                                                    <x-adminlte-select name="kabupaten" label="Kabupaten"
                                                        id="kab_pasien">
                                                        @foreach ($kabupaten as $item)
                                                        <option value="{{ $item->kode_kabupaten_kota }}" {{$item->kode_kabupaten_kota==3209?'selected':''}}>
                                                            {{ $item->nama_kabupaten_kota }}
                                                        </option>
                                                        @endforeach
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputBorderWidth2">Perujuk
                                                            <code>(referensi instansi yang
                                                                merujuk)</code>
                                                        </label>
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
                                                    <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                        <option value="">--Pilih Dokter--</option>
                                                        @foreach ($paramedis as $item)
                                                            <option value="{{ $item->kode_paramedis }}">
                                                                {{ $item->nama_paramedis }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>

                                                    <x-adminlte-input name="noTelp" type="number" label="No Telpon" />
                                                    <x-adminlte-input name="noLP" label="NO Laporan Polisi"
                                                        placeholder="no laporan polisi" id="noLP" disable-feedback />
                                                    <x-adminlte-input name="keterangan" id="keterangan"
                                                        label="Keterangan" placeholder="keterangan kecelakaan"
                                                        disable-feedback />
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglKejadian" id="tglKejadian"
                                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        label="Tanggal Kejadian" :config="$config" />
                                                    <x-adminlte-select name="lakaLantas" id="status_kecelakaan"
                                                        label="Status Kecelakaan">
                                                        <option value="1">KLL & BUKAN KECELAKAAN KERJA (BKK)</option>
                                                        <option value="2">KLL & KK</option>
                                                        <option value="3">KECELAKAAN KERJA</option>
                                                    </x-adminlte-select>
                                                    <x-adminlte-select name="kecamatan" label="Kecamatan"
                                                        id="kec_pasien">
                                                        @foreach ($kecamatan as $item)
                                                        <option value="{{ $item->kode_kecamatan }}" {{$item->kode_kecamatan==3209020?'selected':''}}>
                                                            {{ $item->nama_kecamatan }}
                                                        </option>
                                                        @endforeach
                                                    </x-adminlte-select>
                                                    <x-adminlte-select name="desa" label="Desa" id="desa_pasien">
                                                    </x-adminlte-select>
                                                </div>

                                            </div>
                                            <x-adminlte-button type="submit"
                                                class="withLoad btn btn-sm m-1 bg-green float-right " id="submitPasien"
                                                label="Simpan Data" />
                                            <a href="{{ route('daftar-igd.v1') }}"
                                                class="btn btn-sm m-1 bg-secondary float-right">Kembali</a>
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
        const provinsi = document.getElementById('provinsi');
        const modal_provinsi_pasien = document.getElementById('modal_provinsi_pasien');
        const kewarganegaraanSelect = document.getElementById('modal_kewarganegaraan');
        const negaraSelect = document.getElementById('pilih_negara');

        function toggleNegaraSelect() {
            const selectedValue = kewarganegaraanSelect.value;
            negaraSelect.style.display = selectedValue === '0' ? 'block' : 'none';
        }
        kewarganegaraanSelect.addEventListener('change', toggleNegaraSelect);
        toggleNegaraSelect();

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
                                        text: data.keterangan + ' ' + '( jenis : ' +
                                            data
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
                                        text: data.keterangan + ' ' + '( KODE : ' + data
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

            $('#provinsi_pasien').change(function() {
                var prov_pasien = $(this).val();
                if (prov_pasien) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kab-pasien.get') }}?kab_prov_id=" + prov_pasien,
                        dataType: 'JSON',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(kabupatenpasien) {
                            if (kabupatenpasien) {
                                $('#kab_pasien').empty();
                                $("#kab_pasien").append(
                                    ' < option > --Pilih Kabupaten-- < /option>');
                                $.each(kabupatenpasien, function(key, value) {
                                    $('#kab_pasien').append('<option value="' + value
                                        .kode_kabupaten_kota + '">' + value
                                        .nama_kabupaten_kota + '</option>');
                                });
                            } else {
                                $('#kab_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#kab_pasien").empty();
                }
            });

            $('#kab_pasien').change(function() {
                var kec_kab_id = $("#kab_pasien").val();
                if (kec_kab_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kec-pasien.get') }}?kec_kab_id=" + kec_kab_id,
                        dataType: 'JSON',
                        success: function(kecamatanpasien) {
                            console.log(kecamatanpasien);
                            if (kecamatanpasien) {
                                $('#kec_pasien').empty();
                                $("#kec_pasien").append(
                                    ' < option > --Pilih Kecamatan-- < /option>');
                                $.each(kecamatanpasien, function(key, value) {
                                    $('#kec_pasien').append('<option value="' + value
                                        .kode_kecamatan + '">' + value
                                        .nama_kecamatan + '</option>');
                                });
                            } else {
                                $('#kec_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#kec_pasien").empty();
                }
            });

            $('#kec_pasien').change(function() {
                var desa_kec_id = $("#kec_pasien").val();
                if (desa_kec_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('desa-pasien.get') }}?desa_kec_id=" + desa_kec_id,
                        dataType: 'JSON',
                        success: function(desapasien) {
                            console.log(desapasien);
                            if (desapasien) {
                                $('#desa_pasien').empty();
                                $("#desa_pasien").append(
                                    ' < option > --Pilih Desa-- < /option>');
                                $.each(desapasien, function(key, value) {
                                    $('#desa_pasien').append('<option value="' + value
                                        .kode_desa_kelurahan + '">' + value
                                        .nama_desa_kelurahan + '</option>');
                                });
                            } else {
                                $('#desa_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#desa_pasien").empty();
                }
            });

            // modal pasien baru
            $('#modal_provinsi_pasien').change(function() {
                var prov_pasien = $(this).val();
                if (prov_pasien) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kab-pasien.get') }}?kab_prov_id=" + prov_pasien,
                        dataType: 'JSON',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(kabupatenpasien) {
                            if (kabupatenpasien) {
                                $('#modal_kabupaten_pasien').empty();
                                $("#modal_kabupaten_pasien").append(
                                    ' < option > --Pilih Kabupaten-- < /option>');
                                $.each(kabupatenpasien, function(key, value) {
                                    $('#modal_kabupaten_pasien').append('<option value="' + value
                                        .kode_kabupaten_kota + '">' + value
                                        .nama_kabupaten_kota + '</option>');
                                });
                            } else {
                                $('#modal_kabupaten_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#modal_kabupaten_pasien").empty();
                }
            });

            $('#modal_kabupaten_pasien').change(function() {
                var kec_kab_id = $("#modal_kabupaten_pasien").val();
                if (kec_kab_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kec-pasien.get') }}?kec_kab_id=" + kec_kab_id,
                        dataType: 'JSON',
                        success: function(kecamatanpasien) {
                            console.log(kecamatanpasien);
                            if (kecamatanpasien) {
                                $('#modal_kecamatan_pasien').empty();
                                $("#modal_kecamatan_pasien").append(
                                    ' < option > --Pilih Kecamatan-- < /option>');
                                $.each(kecamatanpasien, function(key, value) {
                                    $('#modal_kecamatan_pasien').append('<option value="' + value
                                        .kode_kecamatan + '">' + value
                                        .nama_kecamatan + '</option>');
                                });
                            } else {
                                $('#modal_kecamatan_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#modal_kecamatan_pasien").empty();
                }
            });

            $('#modal_kecamatan_pasien').change(function() {
                var desa_kec_id = $("#modal_kecamatan_pasien").val();
                if (desa_kec_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('desa-pasien.get') }}?desa_kec_id=" + desa_kec_id,
                        dataType: 'JSON',
                        success: function(desapasien) {
                            console.log(desapasien);
                            if (desapasien) {
                                $('#modal_desa_pasien').empty();
                                $("#modal_desa_pasien").append(
                                    ' < option > --Pilih Desa-- < /option>');
                                $.each(desapasien, function(key, value) {
                                    $('#modal_desa_pasien').append('<option value="' + value
                                        .kode_desa_kelurahan + '">' + value
                                        .nama_desa_kelurahan + '</option>');
                                });
                            } else {
                                $('#modal_desa_pasien').empty();
                            }
                        }
                    });
                } else {
                    $("#modal_desa_pasien").empty();
                }
            });

            $('.btn-save-pasien-baru').click(function() {
                var urlSave = "{{ route('pasien-kecelakaan.store-pasien-baru') }}";
                Swal.fire({
                    title: "SIMPAN PASIEN BARU?",
                    text: "Apakah anda sudah mengisi data dengan benar!",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Simpan!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: urlSave,
                            dataType: 'json',
                            data: {
                                modal_nik:$("#modal_nik").val(),
                                modal_no_bpjs:$("#modal_no_bpjs").val(),
                                modal_nama_pasien:$("#modal_nama_pasien").val(),
                                modal_tempat_lahir:$("#modal_tempat_lahir").val(),
                                modal_jk:$("#modal_jk").val(),
                                modal_tgl_lahir:$("#modal_tgl_lahir").val(),
                                modal_agama:$("#modal_agama").val(),
                                modal_pekerjaan:$("#modal_pekerjaan").val(),
                                modal_pendidikan:$("#modal_pendidikan").val(),
                                modal_no_telp:$("#modal_no_telp").val(),
                                modal_provinsi_pasien:$("#modal_provinsi_pasien").val(),
                                modal_kabupaten_pasien:$("#modal_kabupaten_pasien").val(),
                                modal_kecamatan_pasien:$("#modal_kecamatan_pasien").val(),
                                modal_desa_pasien:$("#modal_desa_pasien").val(),
                                modal_alamat_lengkap_pasien:$("#modal_alamat_lengkap_pasien").val(),
                                modal_kewarganegaraan:$("#modal_kewarganegaraan").val(),
                                modal_negara:$("#modal_negara").val(),
                                modal_nama_keluarga:$("#modal_nama_keluarga").val(),
                                modal_kontak:$("#modal_kontak").val(),
                                modal_hub_keluarga:$("#modal_hub_keluarga").val(),
                                modal_alamat_lengkap_sodara:$("#modal_alamat_lengkap_sodara").val(),
                            },
                            success: function(data) {
                                console.log(data)
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: 'Berhasil Simpan!' + ' ' + '( status : ' +
                                            data
                                            .status_pasien +' '+data.status_keluarga +')',
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                            $('#modal-pasien-kecelakaan').hide();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    console.log(data)
                                    Swal.fire({
                                        title: "INFO!",
                                        text: data.message,
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
            });
        });
    </script>
@endsection
