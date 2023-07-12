@extends('adminlte::page')
@section('title', 'Surat Kontrol Poliklinik')
@section('content_header')
    <h1>Surat Kontrol Poliklinik</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Antrian" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="kodepoli" label="Poliklinik">
                                @foreach ($unit as $item)
                                    <option value="{{ $item->KDPOLI }}"
                                        {{ $item->KDPOLI == $request->kodepoli ? 'selected' : null }}>
                                        {{ $item->nama_unit }} ({{ $item->KDPOLI }})
                                    </option>
                                @endforeach
                                <option value="" {{ $request->kodepoli ? '' : 'selected' }}>SEMUA POLIKLINIK (-)
                                </option>
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($kunjungans))
            <div class="col-md-12">
                <x-adminlte-card title="Kunjungan Poliklinik ({{ $kunjungans->count() }} Orang)" theme="primary"
                    icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Tanggal Masuk', 'Kode', 'Pasien', 'BPJS / NIK', 'Antrian', 'Action', 'SEP / Ref', 'Poliklinik'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr class={{ $item->surat_kontrol ? 'text-success' : null }}>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $item->tgl_masuk }}

                                </td>
                                <td>
                                    {{ $item->kode_kunjungan }}
                                    <br>{{ $item->antrian->kodebooking ?? '' }}
                                </td>
                                <td>
                                    RM :
                                    {{ $item->no_rm ? $item->no_rm : null }}<br>
                                    <b>{{ $item->pasien ? $item->pasien->nama_px : null }}</b>
                                </td>
                                <td>
                                    {{ $item->pasien ? $item->pasien->no_Bpjs : null }}
                                    <br>
                                    {{ $item->pasien ? $item->pasien->nik_bpjs : null }}
                                </td>
                                <td>
                                    @if ($item->antrian)
                                        @if ($item->antrian->taskid == 0)
                                            <span class="badge bg-secondary">Belum Checkin</span>
                                        @endif
                                        @if ($item->antrian->taskid == 1)
                                            <span class="badge bg-secondary">{{ $item->antrian->taskid }}. Chekcin</span>
                                        @endif
                                        @if ($item->antrian->taskid == 2)
                                            <span class="badge bg-secondary">{{ $item->antrian->taskid }}.
                                                Pendaftaran</span>
                                        @endif
                                        @if ($item->antrian->taskid == 3)
                                            @if ($item->antrian->status_api == 0)
                                                <span class="badge bg-warning">{{ $item->antrian->taskid }}. Belum
                                                    Pembayaran</span>
                                            @else
                                                <span class="badge bg-warning">{{ $item->antrian->taskid }}. Tunggu
                                                    Poli</span>
                                                <x-adminlte-button class="btn-xs mt-1 withLoad" label="Panggil"
                                                    theme="warning" icon="fas fa-volume-down" data-toggle="tooltip"
                                                    title="Panggil Antrian {{ $item->antrian->nomorantrean }}"
                                                    onclick="window.location='{{ route('panggilPoliklinik') }}?kodebooking={{ $item->antrian->kodebooking }}'" />
                                            @endif
                                        @endif
                                        @if ($item->antrian->taskid == 4)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Periksa
                                                Poli</span>

                                            <x-adminlte-button class="btn-xs mt-1 btnLayani" label="Layani" theme="success"
                                                icon="fas fa-hand-holding-medical" data-toggle="tooltop"
                                                title="Layani Pasien {{ $item->antrian->nomorantrean }}"
                                                data-id="{{ $item->antrian->id }}" />
                                        @endif
                                        @if ($item->antrian->taskid == 5)
                                            @if ($item->antrian->status_api == 0)
                                                <span class="badge bg-success">{{ $item->antrian->taskid }}. Tunggu
                                                    Farmasi</span>
                                            @endif
                                            @if ($item->antrian->status_api == 1)
                                                <span class="badge bg-success">{{ $item->antrian->taskid }}. Selesai</span>
                                            @endif
                                        @endif
                                        @if ($item->antrian->taskid == 6)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Racik Obat</span>
                                        @endif
                                        @if ($item->antrian->taskid == 7)
                                            <span class="badge bg-success">{{ $item->antrian->taskid }}. Selesai</span>
                                        @endif
                                        @if ($item->antrian->taskid == 99)
                                            <span class="badge bg-danger">{{ $item->antrian->taskid }}. Batal</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">98. Tidak Bridging</span>
                                    @endif
                                    {{-- @if ($item->taskid == 3)
                                        @if ($item->status_api == 1)
                                        @endif
                                    @endif --}}
                                </td>
                                <td>
                                    <x-adminlte-button class="btn-xs btnBuatSuratKontrol" label="S. Kontrol" theme="primary"
                                        icon="fas fa-file-medical" data-toggle="tooltop" title="Buat Surat Kontrol"
                                        data-id="{{ $item->kode_kunjungan }}" />
                                </td>
                                <td>
                                    SEP : {{ $item->no_sep }} <br>
                                    Ref : {{ $item->no_rujukan }}
                                </td>
                                <td>{{ $item->unit->nama_unit }}<br>{{ $item->dokter->nama_paramedis }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                    Catatan : <br>
                    *Warna teks hijau adalah kunjungan yang telah dibuatkan surat kontrol.
                </x-adminlte-card>
            </div>
            <div class="col-md-12">
                <x-adminlte-card title="Surat Kontrol Poliklinik ({{ $surat_kontrols->count() }})" theme="success"
                    icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['Tgl Dibuat', 'Tgl Kontrol', 'No S. Kontrol', 'Pasien', 'Poliklinik / Dokter', 'No SEP Asal'];
                        $config['paging'] = false;
                        $config['order'] = ['2', 'desc'];
                        $config['info'] = false;
                        $config['scrollX'] = true;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" striped
                        bordered hoverable compressed>
                        @foreach ($surat_kontrols as $item)
                            <tr>
                                <td>{{ $item->tglTerbitKontrol }}</td>
                                <td>{{ $item->tglRencanaKontrol }}</td>
                                <td>{{ $item->noSuratKontrol }}
                                    <br>
                                    <a href="{{ route('suratKontrolPrint', $item->noSuratKontrol) }}" target="_blank"
                                        class="btn btn-xs btn-success" data-toggle="tooltip"
                                        title="Print Surat Kontrol {{ $item->kode_kunjungan }}"> <i
                                            class="fas fa-print"></i> Print</a>
                                    <x-adminlte-button class="btn-xs btnEditSuratKontrol" label="Edit" theme="warning"
                                        icon="fas fa-edit" data-toggle="tooltip"
                                        title="Edit Surat Kontrol {{ $item->noSuratKontrol }}"
                                        data-id="{{ $item->id }}" />

                                </td>
                                <td>
                                    {{ $item->nama }} <br>
                                    {{ $item->noKartu }}
                                </td>
                                <td>{{ $item->namaPoliTujuan }} <br>
                                    {{ $item->namaDokter }}
                                </td>
                                <td>{{ $item->noSepAsalKontrol }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
            <x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" title="Surat Kontrol Rawat Jalan"
                theme="success" icon="fas fa-file-medical" v-centered>
                <form id="formSuratKontrol" name="formSuratKontrol">
                    @csrf
                    <x-adminlte-input name="nama_suratkontrol" label="Nama Pasien" readonly />
                    <x-adminlte-input name="nomorkartu_suratkontrol" label="Nomor BPJS" readonly />
                    <x-adminlte-input name="nomorsep_suratkontrol" label="Nomor SEP" placeholder="Cari nomor SEP" readonly>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="primary" id="btnCariSEP" label="Cari!" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-search"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nomor_suratkontrol" placeholder="Nomor Surat Kontrol"
                        label="Nomor Surat Kontrol" readonly />
                    @php
                        $config = [
                            'format' => 'YYYY-MM-DD',
                            'dayViewHeaderFormat' => 'MMMM YYYY',
                            'minDate' => 'js:moment()',
                            'daysOfWeekDisabled' => [0],
                        ];
                    @endphp
                    <x-adminlte-input-date name="tanggal_suratkontrol" label="Tanggal Rencana Surat Kontrol"
                        :config="$config" placeholder="Pilih Tanggal Surat Kontrol ..."
                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="kodepoli_suratkontrol" label="Poliklinik">
                        @foreach ($unit as $item)
                            <option value="{{ $item->KDPOLI }}"
                                {{ $item->KDPOLI == $request->kodepoli ? 'selected' : null }}>
                                {{ $item->nama_unit }} ({{ $item->KDPOLI }})
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="kodedokter_suratkontrol" label="DPJP Surat Kontrol">
                        @foreach ($dokters as $item)
                            <option value="{{ $item->kode_dokter_jkn }}"
                                {{ $item->kode_dokter_jkn == $request->kodedokter ? 'selected' : null }}>
                                {{ $item->nama_paramedis }} ({{ $item->kode_dokter_jkn }})
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-slot name="footerSlot">
                        <x-adminlte-button id="btnStore" class="mr-auto" icon="fas fa-file-medical" theme="success"
                            label="Buat Surat Kontrol" />
                        <x-adminlte-button id="btnUpdate" class="mr-auto" icon="fas fa-edit" theme="warning"
                            label="Update Surat Kontrol" />
                        <x-adminlte-button id="btnDelete" icon="fas fa-trash" theme="danger" label="Hapus"
                            data-toggle="tooltip" title="Delete Surat Kontrol {{ $item->noSuratKontrol }}" />
                        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
                    </x-slot>
                </form>
            </x-adminlte-modal>
            <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success"
                icon="fas fa-file-medical" size="xl" v-centered>
                <table id="tableSEP" class="table table-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>tglSep</th>
                            <th>tglPlgSep</th>
                            <th>noSep</th>
                            <th>jnsPelayanan</th>
                            <th>poli</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </x-adminlte-modal>
            <x-adminlte-modal id="modalPelayanan" title="Pelayanan Pasien Poliklinik" size="xl" theme="success"
                icon="fas fa-user-plus" v-centered static-backdrop scrollable>
                <form name="formLayanan" id="formLayanan" action="" method="post">
                    @csrf
                    <input type="hidden" name="antrianid" id="antrianid" value="">
                    <dl class="row">
                        <dt class="col-sm-3">Kode Booking</dt>
                        <dd class="col-sm-8">: <span id="kodebooking"></span></dd>
                        <dt class="col-sm-3">Antrian</dt>
                        <dd class="col-sm-8">: <span id="angkaantrean"></span> / <span id="nomorantrean"></span>
                        </dd>
                        <dt class="col-sm-3 ">Tanggal Perikasa</dt>
                        <dd class="col-sm-8">: <span id="tanggalperiksa"></span></dd>
                    </dl>
                    <x-adminlte-card theme="primary" title="Informasi Kunjungan Berobat">
                        <div class="row">
                            <div class="col-md-5">
                                <dl class="row">
                                    <dt class="col-sm-4">No RM</dt>
                                    <dd class="col-sm-8">: <span id="norm"></span></dd>
                                    <dt class="col-sm-4">NIK</dt>
                                    <dd class="col-sm-8">: <span id="nik"></span></dd>
                                    <dt class="col-sm-4">No BPJS</dt>
                                    <dd class="col-sm-8">: <span id="nomorkartu"></span></dd>
                                    <dt class="col-sm-4">Nama</dt>
                                    <dd class="col-sm-8">: <span id="nama"></span></dd>
                                    <dt class="col-sm-4">No HP</dt>
                                    <dd class="col-sm-8">: <span id="nohp"></span></dd>
                                    <dt class="col-sm-4">Jenis Pasien</dt>
                                    <dd class="col-sm-8">: <span id="jenispasien"></span></dd>
                                </dl>
                            </div>
                            <div class="col-md-7">
                                <dl class="row">
                                    <dt class="col-sm-4">Jenis Kunjungan</dt>
                                    <dd class="col-sm-8">: <span id="jeniskunjungan"></span></dd>
                                    <dt class="col-sm-4">No SEP</dt>
                                    <dd class="col-sm-8">: <span id="nomorsep"></span></dd>
                                    <dt class="col-sm-4">No Rujukan</dt>
                                    <dd class="col-sm-8">: <span id="nomorrujukan"></span></dd>
                                    <dt class="col-sm-4">No Surat Kontrol</dt>
                                    <dd class="col-sm-8">: <span id="nomorsuratkontrol"></span></dd>
                                    <dt class="col-sm-4">Poliklinik</dt>
                                    <dd class="col-sm-8">: <span id="namapoli"></span></dd>
                                    <dt class="col-sm-4">Dokter</dt>
                                    <dd class="col-sm-8">: <span id="namadokter"></span></dd>
                                    <dt class="col-sm-4">Jadwal</dt>
                                    <dd class="col-sm-8">: <span id="jampraktek"></span></dd>
                                </dl>
                            </div>
                        </div>
                    </x-adminlte-card>
                    <x-adminlte-card theme="primary" title="E-Rekam Medis Pasien" collapsible="collapsed">
                        <div class="row">
                            Kosong
                        </div>
                    </x-adminlte-card>
                    <x-slot name="footerSlot">
                        {{-- <x-adminlte-button class="mr-auto btnSuratKontrol" label="Buat Surat Kontrol" theme="primary"
                            icon="fas fa-prescription-bottle-alt" /> --}}
                        <a href="#" id="lanjutFarmasi" class="btn btn-success withLoad"> <i
                                class="fas fa-prescription-bottle-alt"></i>Farmasi Non-Racikan</a>
                        <a href="#" id="lanjutFarmasiRacikan" class="btn btn-success withLoad"> <i
                                class="fas fa-prescription-bottle-alt"></i>Farmasi Racikan</a>
                        <a href="#" id="selesaiPoliklinik" class="btn btn-warning withLoad"> <i
                                class="fas fa-check"></i> Selesai</a>
                        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
                    </x-slot>
                </form>
            </x-adminlte-modal>
        @endif
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(function() {
            $('.btnEditSuratKontrol').click(function() {
                $('#btnStore').hide();
                $('#btnUpdate').show();
                var nomorsuratkontrol = $(this).data('id');
                var url = "{{ route('suratkontrol.index') }}/" + nomorsuratkontrol + "/edit";
                $.LoadingOverlay("show");
                $.get(url, function(data) {
                    $('#nama_suratkontrol').val(data.nama);
                    $('#nomor_suratkontrol').val(data.noSuratKontrol);
                    $('#nomorsep_suratkontrol').val(data.noSepAsalKontrol);
                    $('#tanggal_suratkontrol').val(data.tglRencanaKontrol);
                    $('#kodepoli_suratkontrol').val(data.poliTujuan).trigger('change');
                    $('#kodedokter_suratkontrol').val(data.kodeDokter).trigger('change');
                    $('#modalSuratKontrol').modal('show');
                    $.LoadingOverlay("hide", true);
                });
            });
            $('.btnBuatSuratKontrol').click(function() {
                $('#btnStore').show();
                $('#btnUpdate').hide();
                var kodekunjungan = $(this).data('id');
                var url = "{{ route('kunjungan.index') }}/" + kodekunjungan + "/edit";
                $.LoadingOverlay("show");
                $.get(url, function(data) {
                    $('#formSuratKontrol').trigger("reset");
                    $('#nama_suratkontrol').val(data.namaPasien);
                    $('#nomorkartu_suratkontrol').val(data.nomorkartu);
                    $('#nomorsep_suratkontrol').val(data.noSEP);
                    $('#kodepoli_suratkontrol').val(data.kodePoli).trigger('change');
                    $('#kodedokter_suratkontrol').val(data.kodeDokter).trigger('change');
                    $('#modalSuratKontrol').modal('show');
                    $.LoadingOverlay("hide", true);
                });
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol.store') }}";
                $.ajax({
                    data: $('#formSuratKontrol').serialize(),
                    url: url,
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            var urlPrint =
                                "{{ route('landingpage') }}/suratkontrol_print?nomorsuratkontrol=" +
                                data
                                .response.noSuratKontrol;
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Surat Kontrol Berhasil Dibuat dengan Nomor ' +
                                    data
                                    .response.noSuratKontrol,
                                footer: "<a href=" + urlPrint +
                                    " target='_blank'>Print Surat Kontrol</a>"
                            }).then(okay => {
                                if (okay) {
                                    $.LoadingOverlay("show");
                                    location.reload();
                                }
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_update') }}";
                $.ajax({
                    data: $('#formSuratKontrol').serialize(),
                    url: url,
                    type: "PUT",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            swal.fire(
                                'Success',
                                'Surat Kontrol Berhasil Diperbaharui dengan Nomor ' + data
                                .response
                                .noSuratKontrol,
                                'success'
                            ).then(okay => {
                                if (okay) {
                                    $.LoadingOverlay("show");
                                    location.reload();
                                }
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnDelete').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_delete') }}";
                $.ajax({
                    data: $('#formSuratKontrol').serialize(),
                    url: url,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Success',
                            'Data berhasil dihapus',
                            'success'
                        ).then(okay => {
                            if (okay) {
                                $.LoadingOverlay("show");
                                location.reload();
                            }
                        });
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnCariSEP').click(function(e) {
                var nomorkartu = $('#nomorkartu_suratkontrol').val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                console.log(value);
                                if (value.jnsPelayanan == 1) {
                                    var jenispelayanan = "Rawat Inap";
                                }
                                if (value.jnsPelayanan == 2) {
                                    var jenispelayanan = "Rawat Jalan";
                                }
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('#nomorsep_suratkontrol').val(nomorsep);
                                $('#modalSEP').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnLayani').click(function() {
                var antrianid = $(this).data('id');
                $.LoadingOverlay("show");
                $.get("{{ route('antrian.index') }}" + '/' + antrianid + '/edit', function(data) {
                    $('#kodebooking').html(data.kodebooking);
                    $('#angkaantrean').html(data.angkaantrean);
                    $('#nomorantrean').html(data.nomorantrean);
                    $('#tanggalperiksa').html(data.tanggalperiksa);
                    $('#norm').html(data.norm);
                    $('#nik').html(data.nik);
                    $('#nomorkartu').html(data.nomorkartu);
                    $('#nama').html(data.nama);
                    $('#nohp').html(data.nohp);
                    $('#nomorrujukan').html(data.nomorrujukan);
                    $('#nomorsuratkontrol').html(data.nomorsuratkontrol);
                    $('#nomorsep').html(data.nomorsep);
                    $('#jenispasien').html(data.jenispasien);
                    $('#namapoli').html(data.namapoli);
                    $('#namadokter').html(data.namadokter);
                    $('#jampraktek').html(data.jampraktek);
                    switch (data.jeniskunjungan) {
                        case "1":
                            var jeniskunjungan = "Rujukan FKTP";
                            break;
                        case "2":
                            var jeniskunjungan = "Rujukan Internal";
                            break;
                        case "3":
                            var jeniskunjungan = "Kontrol";
                            break;
                        case "4":
                            var jeniskunjungan = "Rujukan Antar RS";
                            break;
                        default:
                            break;
                    }
                    $('#jeniskunjungan').html(jeniskunjungan);
                    $('#user').html(data.user);
                    $('#antrianid').val(antrianid);
                    $('#namapoli').val(data.namapoli);
                    $('#namap').val(data.kodepoli);
                    $('#namadokter').val(data.namadokter);
                    $('#kodepoli').val(data.kodepoli);
                    $('#kodedokter').val(data.kodedokter);
                    $('#jampraktek').val(data.jampraktek);
                    $('#nomorsep_suratkontrol').val(data.nomorsep);
                    $('#kodepoli_suratkontrol').val(data.kodepoli);
                    $('#namapoli_suratkontrol').val(data.namapoli);
                    var urlLanjutFarmasi = "{{ route('lanjutFarmasi') }}?kodebooking=" + data
                        .kodebooking;
                    $("#lanjutFarmasi").attr("href", urlLanjutFarmasi);
                    var urlLanjutFarmasiRacikan =
                        "{{ route('lanjutFarmasiRacikan') }}?kodebooking=" + data
                        .kodebooking;
                    $("#lanjutFarmasiRacikan").attr("href", urlLanjutFarmasiRacikan);
                    var urlSelesaiPoliklinik = "{{ route('selesaiPoliklinik') }}?kodebooking=" +
                        data
                        .kodebooking;
                    $("#selesaiPoliklinik").attr("href", urlSelesaiPoliklinik);
                    $('#modalPelayanan').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
        });
    </script>
@endsection

@section('css')
    <style>
        table {
            table-layout: fixed
        }

        td {
            overflow: hidden;
            white-space: nowrap
        }
    </style>
@endsection
