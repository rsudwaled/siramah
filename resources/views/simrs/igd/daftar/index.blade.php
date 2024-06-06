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
                    <li class="breadcrumb-item"><a href="#" data-toggle="modal" data-target="#modalCekBpjs"
                        class="btn btn-sm btn-success">Cek BPJS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-baru.create') }}" class="btn btn-sm bg-purple">Pasien
                            Baru</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-kecelakaan.index') }}"
                            class="btn btn-sm btn-primary">Daftar Pasien Kecelakaan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-warning"><i
                                class="fas fa-sync"></i></a></li>
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
                                                            PASIEN : {{ $data->nama_px }} <br>
                                                            Jenis Kelamin : {{ $data->jenis_kelamin=='L'?'Laki-Laki':'Perempuan' }}
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
                                                        data-rm="{{ $data->no_rm }}"
                                                        class="btn-xs btn-cekBPJS bg-success" label="Cek Status BPJS" />

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
                                                <x-adminlte-select2 name="antrian_triase" label="Nomor Triase">
                                                    @foreach ($antrian_triase as $triase)
                                                        <option value="{{ $triase->id }}">{{ $triase->no_antri }} | <b>{{ $triase->isTriase != null ? $triase->isTriase->klasifikasi_pasien:'BELUM DI TRIASE' }}</b></option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <div class="form-group">
                                                    <label for="">Pilih Tujuan</label>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jp" value="1" checked="">
                                                                <label class="form-check-label">UGD UMUM</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jp" value="0">
                                                                <label class="form-check-label">UGD KEBIDANAN</label>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    <x-adminlte-select2 name="penjamin_id_umum" label="Pilih Penjamin">
                                                        @foreach ($penjamin as $item)
                                                            <option value="{{ $item->kode_penjamin }}">
                                                                {{ $item->nama_penjamin }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="form-group" id="show_penjamin_bpjs" style="display: none;">
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

    <div class="modal fade" id="modalCekBpjs" style="display: none;" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CEK STATUS BPJS</h5>
                </div>
                <form id="cekbpjs-status-tanpa-daftar" method="get">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">Nomor Kartu</label>
                                <input type="text" name="cek_nomorkartu" class="form-control" id="cek_nomorkartu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">Nomor NIK</label>
                                <input type="text" name="cek_nik" class="form-control" id="cek_nik">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-cek-bpjs-tanpa-daftar"
                            form="cekbpjs-status-tanpa-daftar">Cek Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCekKunjungan" style="display: none;" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Riwayat Kunjungan</h4>
                </div>
                <div class="modal-body">
                    {{-- <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active btn btn-block btn-success btn-flat" id="rawat-jalan-tab"
                                    data-toggle="pill" href="#rawat-jalan" role="tab" aria-controls="rawat-jalan"
                                    aria-selected="false">Rawat Jalan</a>
                                <a class="nav-link  btn btn-block btn-primary btn-flat" id="rawat-inap-tab"
                                    data-toggle="pill" href="#rawat-inap" role="tab" aria-controls="rawat-inap"
                                    aria-selected="true">Rawat Inap</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane fade active show" id="rawat-jalan" role="tabpanel"
                                    aria-labelledby="rawat-jalan-tab">
                                    <div class="info-box mb-3 bg-success ">
                                        <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">RAWAT JALAN</span>
                                            <span class="info-box-number">Riwayat Pasien Rawat Jalan</span>
                                        </div>

                                    </div>
                                    <table id="table1" class="riwayatKunjungan data-table table table-bordered">

                                        <thead>
                                            <tr>
                                                <th>KUNJUNGAN</th>
                                                <th>NO RM</th>
                                                <th>PASIEN</th>
                                                <th>POLI</th>
                                                <th>STATUS</th>
                                                <th>TGL MASUK</th>
                                                <th>TGL PULANG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane text-left " id="rawat-inap" role="tabpanel"
                                    aria-labelledby="rawat-inap-tab">
                                    <div class="info-box mb-3 bg-primary">
                                        <span class="info-box-icon"><i class="fas fa-procedures"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">RAWAT INAP</span>
                                            <span class="info-box-number">Riwayat Pasien Rawat Inap</span>
                                        </div>
                                    </div>
                                    <table id="table2" class="riwayatRanap data-table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>KUNJUNGAN</th>
                                                <th>NO RM</th>
                                                <th>PASIEN</th>
                                                <th>RUANGAN</th>
                                                <th>STATUS</th>
                                                <th>TGL MASUK</th>
                                                <th>TGL PULANG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-lg-12">
                         <table id="table1" class="semuaKunjungan data-table table table-bordered">
                             <thead>
                                 <tr>
                                     <th>KUNJUNGAN</th>
                                     <th>NO RM</th>
                                     <th>PASIEN</th>
                                     <th>POLI</th>
                                     <th>STATUS</th>
                                     <th>TGL MASUK</th>
                                     <th>TGL PULANG</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                         </table>
                        </div>
                     </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" onclick="batalPilih()">Tutup</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
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
    <script>
        const isbpjs = document.getElementById('isBpjs');
        const perujuk = document.getElementById('isPerujuk');
        const select = document.getElementById('status_kecelakaan');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        const nolaporan = document.getElementById('noLP');
        const keterangan = document.getElementById('keterangan');
        const tanggalkejadian = document.getElementById('tglKejadian');
        const provinsi = document.getElementById('provinsi');

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

        $('.btn-cek-bpjs-tanpa-daftar').on('click', function() {
            var cek_nik = document.getElementById('cek_nik').value;
            var cek_nomorkartu = document.getElementById('cek_nomorkartu').value;
            var cekStatusBPJS = "{{ route('cek-status-bpjs.tanpa-daftar') }}";
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
                            cek_nomorkartu: cek_nomorkartu,
                            cek_nik: cek_nik,
                        },
                        success: function(data) {
                            console.log(data)
                            if (data.code == 200) {
                                Swal.fire({
                                    title: "Success!",
                                    text: data.pasien + '\n ( NIK: '+data.nik + ' ) \n'+data.keterangan + ' ' + '( jenis : ' +
                                        data
                                        .jenisPeserta + ')',
                                    icon: "success",
                                    confirmButtonText: "oke!",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                        document.getElementById('nomorkartu').value = '';
                                        document.getElementById('nik').value = '';
                                        $('#modalCekBpjs').modal('hide');
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
                        // $.each(data.riwayat, function(index, riwayat) {
                        //     var row = "<tr class='riwayat-kunjungan'><td>" + riwayat
                        //         .kode_kunjungan + "</td><td>" +
                        //         riwayat.no_rm + "</td><td>" + riwayat.pasien
                        //         .nama_px +
                        //         "</td><td>" + riwayat.unit.nama_unit + "</td><td>" +
                        //         riwayat.status.status_kunjungan + "</td><td>" +
                        //         riwayat.tgl_masuk + "</td><td>" + (riwayat
                        //             .tgl_keluar == null ? 'Belum Pulang' : riwayat
                        //             .tgl_keluar) +
                        //         "</td></tr>";
                        //     $('.riwayatKunjungan tbody').append(row);
                        // });
                        // $.each(data.ranap, function(index, ranap) {
                        //     var row = "<tr class='riwayat-kunjungan'><td>" + ranap
                        //         .kode_kunjungan + "</td><td>" +
                        //         ranap.no_rm + "</td><td>" + ranap.pasien
                        //         .nama_px +
                        //         "</td><td>" + ranap.unit.nama_unit + "</td><td>" +
                        //         ranap.status.status_kunjungan + "</td><td>" +
                        //         ranap
                        //         .tgl_masuk + "</td><td>" + (ranap.tgl_keluar ==
                        //             null ? 'Belum Pulang' : ranap.tgl_keluar) +
                        //         "</td></tr>";
                        //     $('.riwayatRanap tbody').append(row);
                        // });
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
