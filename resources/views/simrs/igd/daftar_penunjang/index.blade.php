@extends('adminlte::page')

@section('title', 'DAFTAR PENUNJANG')
@section('content_header')
    <div class="alert bg-success alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i> DAFTAR PENUNJANG :
        </h5>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" collapsible>
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
                                                            PASIEN : {{ $data->nama_px }} <br>
                                                            Jenis Kelamin :
                                                            {{ $data->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                                        </b> <br><br>
                                                        <small>
                                                            <b>TTL :
                                                                {{ date('d-m-Y', strtotime($data->tgl_lahir)) ?? '-' }}
                                                            </b> <br>
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
                                                        class="btn-xs btn-pilihPasien bg-purple" label="PILIH DATA" />

                                                    <x-adminlte-button type="button" data-nik="{{ $data->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->no_Bpjs }}"
                                                        data-rm="{{ $data->no_rm }}" class="btn-xs btn-cekBPJS bg-success"
                                                        label="Cek Status BPJS" />

                                                    <x-adminlte-button type="button" data-rm="{{ $data->no_rm }}"
                                                        class="btn-xs btn-cekKunjungan bg-warning mt-1"
                                                        label="Riwayat Kunjungan" />

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
                                    <div class="alert bg-success alert-dismissible">
                                        <h5>
                                            <i class="fas fa-tasks"></i> Form Daftar Penunjang:
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
                                                {{-- <x-adminlte-input name="noTelp" id="noTelp" type="number"
                                                    label="No Telpon" /> --}}
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tanggal"
                                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                                    :config="$config" />

                                            </div>
                                            <div class="col-lg-6">
                                                <x-adminlte-select2 name="antrian_triase" label="Nomor Triase">
                                                    @foreach ($antrian_triase as $triase)
                                                        <option value="{{ $triase->id }}">{{ $triase->no_antri }} |
                                                            <b>{{ $triase->isTriase != null ? $triase->isTriase->klasifikasi_pasien : 'BELUM DI TRIASE' }}</b>
                                                        </option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <x-adminlte-select2 name="unit_penunjang" label="Pilih Penunjang">
                                                    @foreach ($unit as $item)
                                                        <option value="{{ $item->kode_unit }}">
                                                            {{ $item->nama_unit }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <div class="form-group" >
                                                    <x-adminlte-select2 name="penjamin_id_umum" label="Pilih Penjamin">
                                                        @foreach ($penjamin as $item)
                                                            <option value="{{ $item->kode_penjamin }}">
                                                                {{ $item->nama_penjamin }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                
                                                <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Masuk">
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->alasan_masuk }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>

                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button type="submit"
                                                        onclick="javascript: form.action='{{ route('daftar-penunjang.store') }}';"
                                                        class="withLoad btn  btn-sm bg-green float-right"
                                                        form="formPendaftaranIGD" label="Simpan Data" />
                                                    {{-- <a href="{{ route('list.antrian') }}"
                                                    class="float-right btn btn-sm btn-secondary">Kembali</a> --}}
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
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
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
            if (nik || nomorkartu) {
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

        $('.btn-cekKunjungan').click(function(e) {
            $('#modalCekKunjungan').modal('toggle');
            var rm = $(this).data('rm');
            if (rm) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kunjungan-pasien.get') }}?rm=" + rm,
                    dataType: 'JSON',
                    success: function(data) {
                        $.each(data.semua_kunjungan, function(index, riwayat) {
                            var row = "<tr class='riwayat-kunjungan'><td>" + riwayat
                                .kode_kunjungan + "</td><td>" +
                                riwayat.no_rm + "</td><td>" + riwayat.pasien
                                .nama_px +
                                "</td><td>" + riwayat.unit.nama_unit + "</td><td>" +
                                riwayat.status.status_kunjungan + "</td><td>" +
                                riwayat.tgl_masuk + "</td><td>" + (riwayat
                                    .tgl_keluar == null ? 'Belum Pulang' : riwayat
                                    .tgl_keluar) +
                                "</td></tr>";
                            $('.semuaKunjungan tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error appropriately
                    }
                });
            }
        });

        function batalPilih() {
            $(".riwayat-kunjungan").remove();
            $('#modalCekKunjungan').modal('hide');
        }

    </script>
@endsection

