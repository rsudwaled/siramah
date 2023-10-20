@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <h1>Pasien Rawat Inap </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Pasien Rawat Inap" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = [
                                'timePicker' => false,
                                'locale' => ['format' => 'YYYY/MM/DD'],
                            ];
                        @endphp
                        <x-adminlte-date-range fgroup-class="col-md-4" igroup-size="sm" name="tanggal"
                            label="Tanggal Rawat Inap" :config="$config" value="{{ $request->tanggal }}" />
                        <x-adminlte-select2 fgroup-class="col-md-4" igroup-size="sm" name="kodeunit" label="Ruangan">
                            <option value="" {{ $request->kodeunit ? '-' : 'selected' }}>SEMUA RUANGAN (-)
                            </option>
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }} ({{ $key }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" icon="fas fa-search"
                        label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        @if ($kunjungans)
            <div class="col-md-12">
                <x-adminlte-card theme="secondary" icon="fas fa-info-circle"
                    title="Data Pasien Rawat Inap Pulang ({{ $kunjungans->count() }} Orang)">
                    @php
                        $heads = ['Tgl Masuk', 'Tgl Keluar', 'No RM', 'Pasien', 'SEP', 'Alasan Pulang', 'ICU', 'Total Tarif', 'Non Bedah', 'Bedah', 'Konsultasi', 'Tng Ahli', 'Keperawatan', 'R Medis', 'Rad', 'Lab'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['scrollX'] = true;
                        $config['scrollY'] = '400px';
                    @endphp
                    @if ($errors->any())
                        <x-adminlte-alert theme="danger" title="Danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </x-adminlte-alert>
                    @endif
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            @switch($item->cek)
                                @case('1')
                                    <tr class="table-success">
                                    @break

                                    @case('0')
                                    @break

                                    @default
                                    <tr class="table-warning">
                                    @break
                                @endswitch
                                <td>{{ $item->tmasuk }}</td>
                                <td>{{ $item->tmasuk }}</td>
                                <td>{{ $item->no_rm }}</td>
                                <td>{{ $item->NAMA }}</td>
                                <td>{{ $item->sep }}</td>
                                <td>{{ $item->alasan_pulang }}</td>
                                <td>{{ $item->HARI_RAWAT_INTENSIV }}</td>
                                <td>{{ money($item->TOTAL, 'IDR') }}</td>
                                <td>{{ money($item->PROSEDURE_NON_BEDAH, 'IDR') }}</td>
                                <td>{{ money($item->PROSEDURE_BEDAH, 'IDR') }}</td>
                                <td>{{ money($item->KONSULTASI, 'IDR') }}</td>
                                <td>{{ money($item->TENAGA_AHLI, 'IDR') }}</td>
                                <td>{{ money($item->KEPERAWATAN, 'IDR') }}</td>
                                <td>{{ money($item->REHABILITASI_MEDIK, 'IDR') }}</td>
                                <td>{{ money($item->RADIOLOGI, 'IDR') }}</td>
                                <td>{{ money($item->LABORATORIUM, 'IDR') }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalKunjungan" title="Riwayat Pasien Ranap" icon="fas fa-user-injured" size="xl"
        theme="success" scrollable>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pl-1 pt-1">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tarifpelayanantab" data-toggle="pill">Tarif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#obatPasien">Obat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#penunjangPasien">Penunjang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#verifikasi">Verfikasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tarifpelayanantab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-5">Prosedur Bedah</dt>
                                            <dd class="col-sm-7">: <span class="prosedur_bedah"></span></dd>
                                            <dt class="col-sm-5">Prosedur Non Bedah</dt>
                                            <dd class="col-sm-7">: <span class="prosedur_non_bedah"></span></dd>
                                            <dt class="col-sm-5">Tenaga Ahli</dt>
                                            <dd class="col-sm-7">: <span class="tenaga_ahli"></span></dd>
                                            <dt class="col-sm-5">radiologi</dt>
                                            <dd class="col-sm-7">: <span class="radiologi"></span></dd>
                                            <dt class="col-sm-5">laboratorium</dt>
                                            <dd class="col-sm-7">: <span class="laboratorium"></span></dd>
                                            <dt class="col-sm-5">rehabilitasi</dt>
                                            <dd class="col-sm-7">: <span class="rehabilitasi"></span></dd>
                                            <dt class="col-sm-5">sewa_alat</dt>
                                            <dd class="col-sm-7">: <span class="sewa_alat"></span></dd>
                                            <dt class="col-sm-5">keperawatan</dt>
                                            <dd class="col-sm-7">: <span class="keperawatan"></span></dd>
                                            <dt class="col-sm-5">kamar_akomodasi</dt>
                                            <dd class="col-sm-7">: <span class="kamar_akomodasi"></span></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-5">penunjang</dt>
                                            <dd class="col-sm-7">: <span class="penunjang"></span></dd>
                                            <dt class="col-sm-5">konsultasi</dt>
                                            <dd class="col-sm-7">: <span class="konsultasi"></span></dd>
                                            <dt class="col-sm-5">pelayanan_darah</dt>
                                            <dd class="col-sm-7">: <span class="pelayanan_darah"></span></dd>
                                            <dt class="col-sm-5">rawat_intensif</dt>
                                            <dd class="col-sm-7">: <span class="rawat_intensif"></span></dd>
                                            <dt class="col-sm-5">obat</dt>
                                            <dd class="col-sm-7">: <span class="obat"></span></dd>
                                            <dt class="col-sm-5">alkes</dt>
                                            <dd class="col-sm-7">: <span class="alkes"></span></dd>
                                            <dt class="col-sm-5">bmhp</dt>
                                            <dd class="col-sm-7">: <span class="bmhp"></span></dd>
                                            <dt class="col-sm-5">obat_kronis</dt>
                                            <dd class="col-sm-7">: <span class="obat_kronis"></span></dd>
                                            <dt class="col-sm-5">obat_kemo</dt>
                                            <dd class="col-sm-7">: <span class="obat_kemo"></span></dd>
                                            <dt class="col-sm-5">tarif_rs</dt>
                                            <dd class="col-sm-7">: <span class="tarif_rs"></span></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-12">
                                        @php
                                            $heads = ['TGL', 'NAMA_UNIT', 'GROUP_VCLAIM', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                            $config['paging'] = false;
                                            $config['info'] = false;
                                        @endphp
                                        <x-adminlte-datatable id="tableRincian" class="nowrap text-xs" :heads="$heads"
                                            :config="$config" bordered hoverable compressed>
                                        </x-adminlte-datatable>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="obatPasien">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $heads = ['TGL', 'NAMA_UNIT', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                            $config['paging'] = false;
                                            $config['info'] = false;
                                        @endphp
                                        <x-adminlte-datatable id="tableObat" class="nowrap text-xs" :heads="$heads"
                                            :config="$config" bordered hoverable compressed>
                                        </x-adminlte-datatable>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="penunjangPasien">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $heads = ['TGL', 'NAMA_UNIT', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                            $config['paging'] = false;
                                            $config['info'] = false;
                                        @endphp
                                        <x-adminlte-datatable id="tablePenunjang" class="nowrap text-xs" :heads="$heads"
                                            :config="$config" bordered hoverable compressed>
                                        </x-adminlte-datatable>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="verifikasi">
                                <form action="{{ route('update_claim') }}" id="formUpdateClaim" method="POST">
                                    @csrf
                                    <input type="hidden" name="rm_counter" class="rm_counter">
                                    <x-adminlte-textarea name="saran" label="Saran Verifikasi"
                                        placeholder="Saran..." />
                                    <x-adminlte-select name="status" label="Status Verifikasi">
                                        <option value="0">Belum Verifikasi</option>
                                        <option value="99">Perbaiki</option>
                                        <option selected value="1">Verfikasi Casemix Ruangan</option>
                                        <option value="2">Verifikasi Casemix RS</option>
                                    </x-adminlte-select>
                                    <x-adminlte-input igroup-size="sm" name="user" label="User Verifikasi"
                                        value="{{ Auth::user()->name }}" readonly />
                                    <x-adminlte-button theme="success" class="mr-auto" label="Groupper" type="submit"
                                        form="formUpdateClaim" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            $('.btnKunjungan').click(function() {
                $.LoadingOverlay("show");
                // identitas
                $('.namapasien').html($(this).data('namapasien'));
                $('.nama-id').val($(this).data('namapasien'));
                $('.norm').html($(this).data('norm'));
                $('.norm-id').val($(this).data('norm'));
                $('.nomorkartu').html($(this).data('nomorkartu'));
                $('.nomorkartu-id').val($(this).data('nomorkartu'));
                $(".gender-id").val($(this).data('gender'));
                $(".tgllahir-id").val($(this).data('tgllahir'));
                // kunjungan
                $('.kodekunjungan-id').val($(this).data('id'));
                $('.counter-id').val($(this).data('counter'));
                $(".dokter").html($(this).data('dokter'));
                $(".dokter-id").val($(this).data('dokter'));
                $(".sep").html($(this).data('nomorsep'));
                $(".nomorsep-id").val(null);
                $(".kelas").html($(this).data('kelas'));
                $('.kelasrawat-id').val($(this).data('kelas')).change();
                $(".tglmasuk-id").val($(this).data('tglmasuk'));
                $(".ruangan").html($(this).data('ruangan'));
                $(".kunjungan").html($(this).data('id') + "|" + $(this).data('counter'));
                $(".suratkontrol-html").html($(this).data('suratkontrol'));
                $(".nomorsuratkontrol-id").val($(this).data('suratkontrol'));
                var norm = $(this).data('norm');
                var counter = $(this).data('counter');
                var table = $('#tableRincian')
                    .DataTable();
                var tableObat = $('#tableObat')
                    .DataTable();
                var tablePenunjangPasien = $('#tablePenunjang')
                    .DataTable();
                table.rows().remove().draw();
                tableObat.rows().remove().draw();
                tablePenunjangPasien.rows().remove().draw();
                var urlRincian = "{{ route('api.eclaim.rincian_biaya_pasien') }}?counter=" +
                    counter + "&norm=" + norm;
                $.ajax({
                    url: urlRincian,
                    type: "GET",
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response.rincian,
                                function(key, value) {
                                    table.row.add([
                                            value.TGL,
                                            value.NAMA_UNIT,
                                            value.nama_group_vclaim,
                                            value.NAMA_TARIF,
                                            value.GRANTOTAL_LAYANAN
                                            .toLocaleString(
                                                'id-ID'),
                                        ])
                                        .draw(false);
                                    if (value.nama_group_vclaim === 'OBAT') {
                                        tableObat.row.add([
                                                value.TGL,
                                                value.NAMA_UNIT,
                                                value.NAMA_TARIF,
                                                value.GRANTOTAL_LAYANAN
                                                .toLocaleString(
                                                    'id-ID'),
                                            ])
                                            .draw(false);
                                    }
                                    if (value.nama_group_vclaim === 'LABORATORIUM') {
                                        tablePenunjangPasien.row.add([
                                                value.TGL,
                                                value.NAMA_UNIT,
                                                value.NAMA_TARIF,
                                                value.GRANTOTAL_LAYANAN
                                                .toLocaleString(
                                                    'id-ID'),
                                            ])
                                            .draw(false);
                                    }
                                });
                            $('.prosedur_non_bedah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_non_bedah.toLocaleString(
                                        'id-ID')
                                );
                            $('.tenaga_ahli')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .tenaga_ahli.toLocaleString(
                                        'id-ID')
                                );
                            $('.radiologi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .radiologi.toLocaleString(
                                        'id-ID')
                                );
                            $('.rehabilitasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .rehabilitasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat.toLocaleString(
                                        'id-ID')
                                );
                            $('.alkes')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .alkes.toLocaleString(
                                        'id-ID')
                                );
                            $('.prosedur_bedah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .prosedur_bedah.toLocaleString(
                                        'id-ID')
                                );
                            $('.keperawatan')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .keperawatan.toLocaleString(
                                        'id-ID')
                                );
                            $('.laboratorium')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .laboratorium.toLocaleString(
                                        'id-ID')
                                );
                            $('.kamar_akomodasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .kamar_akomodasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat_kronis')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kronis.toLocaleString(
                                        'id-ID')
                                );
                            $('.bmhp')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .bmhp.toLocaleString(
                                        'id-ID')
                                );
                            $('.konsultasi')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .konsultasi.toLocaleString(
                                        'id-ID')
                                );
                            $('.penunjang')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .penunjang.toLocaleString(
                                        'id-ID')
                                );
                            $('.pelayanan_darah')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .pelayanan_darah.toLocaleString(
                                        'id-ID')
                                );
                            $('.rawat_intensif')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .rawat_intensif.toLocaleString(
                                        'id-ID')
                                );
                            $('.obat_kemo')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .obat_kemo.toLocaleString(
                                        'id-ID')
                                );
                            $('.sewa_alat')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .sewa_alat.toLocaleString(
                                        'id-ID')
                                );
                            $('.tarif_rs')
                                .html(
                                    data
                                    .response
                                    .rangkuman
                                    .tarif_rs.toLocaleString(
                                        'id-ID')
                                );
                        } else {
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        swal.fire(
                            'Error ' +
                            data
                            .responseJSON
                            .metadata
                            .code,
                            data
                            .responseJSON
                            .metadata
                            .message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
                $('#modalKunjungan').modal('show');
            });
        });
    </script>
@endsection
