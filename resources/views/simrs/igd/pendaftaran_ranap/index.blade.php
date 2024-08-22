@extends('adminlte::page')
@section('title', 'PENDAFTARAN RANAP')
@section('content_header')
    <div class="alert bg-success alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> PENDAFTARAN RANAP :
                </h5>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-warning"
                            style="text-decoration: none; color:black; font-weight:500;">
                            Cari Kunjungan
                        </a>
                    </li>
                </ol>
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
                                            <x-adminlte-input name="cari_rm" label="NO RM" value="{{ $request->rm }}"
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
                                        </div>
                                        <div class="col-lg-6">
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
                            @if (isset($kunjungans))
                                <div class="row">
                                    @php
                                        $heads = ['Pasien', 'Alamat', 'Kunjungan', 'Aksi'];
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
                                        @foreach ($kunjungans as $data)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('edit-pasien', ['rm' => $data->no_rm]) }}"
                                                        target="__blank">
                                                        <b>
                                                            RM : {{ $data->no_rm }}<br>
                                                            NIK : {{ $data->pasien->nik_bpjs }} <br>
                                                            BPJS : {{ $data->pasien->no_Bpjs }} <br>
                                                            PASIEN : {{ $data->pasien->nama_px }} <br>
                                                            Jenis Kelamin :
                                                            {{ $data->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                                        </b> <br><br>
                                                        <small>
                                                            <b>TTL :
                                                                {{ date('d-m-Y', strtotime($data->pasien->tgl_lahir)) ?? '-' }}
                                                            </b>
                                                        </small> <br>
                                                        <small>Kontak :
                                                            {{ $data->pasien->no_tlp == null ? $data->pasien->no_hp : $data->pasien->no_tlp }}</small>
                                                    </a>
                                                </td>
                                                <td>
                                                    Alamat : {{ $data->pasien->alamat ?? '-' }} / <br>
                                                    {{ ($data->pasien->lokasiDesa == null ? 'Desa: -' : 'Desa. ' . $data->pasien->lokasiDesa->name) . ($data->pasien->lokasiKecamatan == null ? 'Kec. ' : ' , Kec. ' . $data->pasien->lokasiKecamatan->name) . ($data->pasien->lokasiKabupaten == null ? 'Kab. ' : ' - Kab. ' . $data->pasien->lokasiKabupaten->name) }}
                                                </td>
                                                <td>
                                                    Kode: {{ $data->kode_kunjungan }} <br>
                                                    Unit: {{ $data->unit->nama_unit ?? '-' }} <br><br>
                                                    @if ($data->is_ranap_daftar == 1)
                                                        Jenis: <span class="badge badge-danger">PASIEN RANAP</span>
                                                    @else
                                                        Jenis: <span class="badge badge-warning">PASIEN RAJAL</span>
                                                    @endif
                                                    <br>
                                                    Masuk : {{ $data->tgl_masuk }} <br><br>
                                                    Admin:
                                                    {{ is_object($data->pic) ? ($data->pic->nama_user ? $data->pic->nama_user : 'Nama Admin tidak tersedia') : '-' }}
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <x-adminlte-button type="button" data-rm="{{ $data->no_rm }}"
                                                        data-kode="{{ $data->kode_kunjungan }}"
                                                        data-nama="{{ $data->pasien->nama_px }}"
                                                        data-nik="{{ $data->pasien->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->pasien->no_Bpjs }}"
                                                        data-kontak="{{ $data->pasien->no_tlp == null ? $data->pasien->no_hp : $data->pasien->no_tlp }}"
                                                        class="btn-xs btn-pilihPasien bg-purple" label="PILIH DATA" />

                                                    {{-- <x-adminlte-button type="button"
                                                        data-nik="{{ $data->pasien->nik_bpjs }}"
                                                        data-nomorkartu="{{ $data->pasien->no_Bpjs }}"
                                                        data-rm="{{ $data->no_rm }}"
                                                        class="btn-xs btn-cekBPJS bg-success" label="Cek BPJS" /> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        @if ($errors->any())
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li><strong>{{ $error }}</strong></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <form action="" id="formDaftarRanapIgd" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="rm" id="rm_terpilih" label="RM PASIEN"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="nik" id="nik_pasien" label="NIK"
                                                    type="text" readonly disable-feedback />
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <x-adminlte-input name="kode" id="kode" type="text"
                                                            readonly label="Kunjungan" />
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
                                                <div class="form-group">
                                                    <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                                        @foreach ($penjamin as $item)
                                                            <option value="{{ $item->kode_penjamin }}">
                                                                {{ strtoupper($item->nama_penjamin) }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="nama_pasien" id="nama_pasien" label="NAMA"
                                                    type="text" readonly disable-feedback />
                                                <x-adminlte-input name="noTelp" id="noTelp" type="text"
                                                    label="No Telpon" />
                                                <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ strtoupper($item->alasan_masuk) }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                    <option value="">--Pilih Dokter--</option>
                                                    @foreach ($paramedis as $item)
                                                        <option value="{{ $item->kode_paramedis }}">
                                                            {{ strtoupper($item->nama_paramedis) }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <div class="col-lg-12">
                                                <x-adminlte-select name="is_proses" id="is_proses"
                                                    label="Apakah Penjamin BPJS Proses?">
                                                    <option value="0">TIDAK</option>
                                                    <option value="1">IYA</option>
                                                </x-adminlte-select>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <x-adminlte-input name="inject_sep" id="inject_sep"
                                                            label="NO SEP" type="text" />
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <x-adminlte-input name="inject_spri" id="inject_spri"
                                                            label="NO SPRI/ Rencana Rawat Inap" type="text" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-adminlte-select name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                                    @foreach ($unit as $item)
                                                        <option value="{{ $item->kode_unit }}">
                                                            {{ $item->nama_unit }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <x-adminlte-select name="kelas_rawat" id="r_kelas_id"
                                                            label="Kelas Rawat">
                                                            <option value="1">KELAS 1</option>
                                                            <option value="2">KELAS 2</option>
                                                            <option value="3" selected>KELAS 3</option>
                                                            <option value="4">VIP</option>
                                                            <option value="5">VVIP</option>
                                                        </x-adminlte-select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-adminlte-button label="Cari Ruangan" data-toggle="modal"
                                                            data-target="#pilihRuangan" id="cariRuangan"
                                                            class="bg-purple mt-4" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" id="id_ruangan" name="id_ruangan">
                                            <div class="col-md-4">
                                                <x-adminlte-input name="ruangan" label="Ruangan" id="ruanganTerpilih"
                                                    readonly />
                                            </div>
                                            <div class="col-md-4">
                                                <x-adminlte-input name="bed" label="No Bed" id="bedTerpilih"
                                                    readonly />
                                            </div>
                                            <div class="col-md-4">
                                                <x-adminlte-input name="hak_kelas" label="Hak Kelas" id="hakKelas"
                                                    readonly />
                                            </div>
                                        </div>
                                        <x-adminlte-button type="submit"
                                            onclick="javascript: form.action='{{ route('simrs.pendaftaran-ranap-igd.store') }}';"
                                            class="withLoad btn  btn-sm bg-green float-right" form="formDaftarRanapIgd"
                                            label="Simpan Data" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="pilihRuangan" title="List Ruangan Tersedia" theme="success" icon="fas fa-bed" size='xl'
        disable-animations>
        <div class="row listruangan" id="idRuangan"></div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $('.btn-pilihPasien').on('click', function() {
            let kode = $(this).data('kode');
            let rm = $(this).data('rm');
            let nama = $(this).data('nama');
            let nik = $(this).data('nik');
            let nomorkartu = $(this).data('nomorkartu');
            let kontak = $(this).data('kontak');
            $('#kode').val(kode);
            $('#rm_terpilih').val(rm);
            $('#nik_pasien').val(nik);
            $('#nama_pasien').val(nama);
            $('#no_bpjs').val(nomorkartu);
            $('#noTelp').val(kontak);
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

            $('#cariRuangan').on('click', function() {
                var unit = $('#unitTerpilih').val();
                var kelas = $('#r_kelas_id').val();
                $('#hakKelas').val(kelas);
                $('#hakKelas').text('Kelas ' + kelas);
                if (kelas) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('bed-ruangan.get') }}?unit=" + unit + '&kelas=' + kelas,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res) {
                                $.each(res.bed, function(key, value) {
                                    $("#idRuangan").append(
                                        '<div class="position-relative p-3 m-2 bg-green ruanganCheck" onclick="chooseRuangan(' +
                                        value.id_ruangan + ', `' + value
                                    .nama_kamar + '`, `' +
                                    value.no_bed +
                                    '`)" style="height: 100px; width: 150px; margin=5px; border-radius: 2%;"><div class="ribbon-wrapper ribbon-sm"><div class="ribbon bg-warning text-sm">KOSONG</div></div><h6 class="text-left">"' +
                                        value.nama_kamar +
                                        '"</h6> <br> NO BED : "' + value
                                        .no_bed + '"<br></div></div></div>');
                                });
                            } else {
                                $("#bed_byruangan").empty();
                            }
                        }
                    });
                } else {
                    $("#bed_byruangan").empty();
                }
            });
        });

        function chooseRuangan(id, nama, bed) {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN PILIH RUANGAN ' + nama + ' No ' + bed + ' ?',
                showDenyButton: true,
                confirmButtonText: 'Pilih',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    //
                    $("#id_ruangan").val(id);
                    $("#ruanganTerpilih").val(nama);
                    $("#bedTerpilih").val(bed);
                    $('#pilihRuangan').modal('toggle');
                    $(".ruanganCheck").remove();

                    $("#infoRuangan").css("display", "none");
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }
    </script>
@endsection
