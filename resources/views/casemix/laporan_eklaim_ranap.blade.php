@extends('adminlte::page')
@section('title', 'Laporan E-Klaim Ranap')
@section('content_header')
    <h1>Laporan E-Klaim Ranap</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card icon="fas fa-filter" title="Filter Laporan E-Klaim Ranap" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date fgroup-class="col-md-3" igroup-size="sm" name="tanggal" label="Tanggal"
                            :config="$config" value="{{ $request->tanggal ?? now()->format('Y-m-d') }}" />
                        <x-adminlte-select igroup-size="sm" fgroup-class="col-md-3" name="jenistgl" label="Jenis Tanggal">
                            <option value="pulang">Tanggal Pulang</option>
                            <option value="masuk">Tanggal Masuk</option>
                        </x-adminlte-select>
                        <x-adminlte-select2 fgroup-class="col-md-3" name="kodeunit" label="Ruangan">
                            <option value="-" {{ $request->kodeunit ? '-' : 'selected' }}>SEMUA RUANGAN (-)
                            </option>
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }} ({{ $key }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        @if ($kunjungans)
            <div class="col-md-12">
                <x-adminlte-card theme="secondary" icon="fas fa-info-circle"
                    title="Total Pasien ({{ $kunjungans ? $kunjungans->count() : 0 }} Orang)">
                    @php
                        $heads = ['Tgl Masuk', 'Tgl Keluar', 'Pasien', 'Unit', 'INACBG', 'Total Biaya', 'Tarif Eklaim'];
                        $config['order'] = [['0', 'asc']];
                        $config['paging'] = false;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr class="btnDetail" data-norm="{{ $item->pasien->no_rm }}"
                                data-nama="{{ $item->pasien->nama_px }}" data-nomorkartu="{{ $item->pasien->no_Bpjs }}"
                                data-nik="{{ $item->pasien->nik_bpjs }}" data-tgllahir="{{ $item->pasien->tgl_lahir }}"
                                data-jeniskelamin="{{ $item->pasien->jenis_kelamin }}" data-counter="{{ $item->counter }}"
                                data-tglmasuk="{{ $item->tgl_masuk }}" data-kodekunjungan="{{ $item->kode_kunjungan }}"
                                data-tglkeluar="{{ $item->tgl_keluar }}" data-unit="{{ $item->unit->nama_unit }}"
                                data-dokter="{{ $item->dokter->nama_paramedis }}" data-kelasrawat="{{ $item->kelas }}"
                                data-status="{{ $item->status->status_kunjungan }}"
                                data-kodeinacbg="{{ $item->budget->kode_cbg ?? '-' }}"
                                data-tarifinacbg="{{ $item->budget ? money($item->budget->tarif_inacbg, 'IDR') : '-' }}">
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->tgl_keluar }}</td>
                                <td>{{ $item->pasien->no_rm }} {{ $item->pasien->nama_px }}</td>
                                <td>{{ $item->unit->nama_unit }}</td>
                                <td>{{ $item->budget->kode_cbg ?? '-' }}</td>
                                <td>{{ $item->tagihan ? money($item->tagihan->total_biaya, 'IDR') : '-' }}</td>
                                <td>{{ $item->budget ? money($item->budget->tarif_inacbg, 'IDR') : '-' }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalDetail" name="modalDetail" title="Detail Kunjungan" theme="success"
        icon="fas fa-file-medical" size="xl">
        <x-adminlte-card theme="primary" theme-mode="outline">
            <div class="row">
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">No RM</dt>
                        <dd class="col-sm-8">: <span class="norm"></span></dd>
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">: <span class="nama"></span> (<span class="jeniskelamin"></span>)</dd>
                        <dt class="col-sm-4">No BPJS</dt>
                        <dd class="col-sm-8">: <span class="nomorkartu"></span></dd>
                        <dt class="col-sm-4">NIK</dt>
                        <dd class="col-sm-8">: <span class="nik"></span></dd>
                        <dt class="col-sm-4">Tgl Lahir</dt>
                        <dd class="col-sm-8">: <span class="tgllahir"></span></dd>
                        <dt class="col-sm-4">Hak Kelas</dt>
                        <dd class="col-sm-8">: <span class="hakkelas"></span></dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Kunjungan</dt>
                        <dd class="col-sm-8">: <span class="counter"></span>/<span class="kodekunjungan"></span></dd>
                        <dt class="col-sm-4">Tgl Masuk</dt>
                        <dd class="col-sm-8">: <span class="tglmasuk"></span></dd>
                        <dt class="col-sm-4">Tgl Keluar</dt>
                        <dd class="col-sm-8">: <span class="tglkeluar"></span></dd>
                        <dt class="col-sm-4">Unit</dt>
                        <dd class="col-sm-8">: <span class="unit"></span></dd>
                        <dt class="col-sm-4">Dokter DPJP</dt>
                        <dd class="col-sm-8">: <span class="dokter"></span></dd>
                        <dt class="col-sm-4">Kelas Rawat</dt>
                        <dd class="col-sm-8">: <span class="kelasrawat"></span></dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">: <span class="status"></span></dd>
                        <dt class="col-sm-4">Alasan Pulang</dt>
                        <dd class="col-sm-8">: <span class="nama"></span></dd>
                        <dt class="col-sm-4">Diag. Utama</dt>
                        <dd class="col-sm-8">: <span class="norm"></span></dd>
                        <dt class="col-sm-4">Diag. Sekunder</dt>
                        <dd class="col-sm-8">: <span class="nama"></span></dd>
                        <dt class="col-sm-4">Kode INACBG</dt>
                        <dd class="col-sm-8">: <span class="kodeinacbg"></span></dd>
                        <dt class="col-sm-4">Tarif E-Klaim</dt>
                        <dd class="col-sm-8">: <span class="tarifinacbg"></span></dd>
                        <dt class="col-sm-4">Tarif RS</dt>
                        <dd class="col-sm-8">: <span class="tarif_rs"></span></dd>
                    </dl>
                </div>
            </div>
        </x-adminlte-card>
        <x-adminlte-card theme="primary" title="Rincian Biaya Pasien">
            <div class="row">
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-5">prosedur_non_bedah</dt>
                        <dd class="col-sm-7">: <span class="prosedur_non_bedah"></span></dd>
                        <dt class="col-sm-5">prosedur_bedah</dt>
                        <dd class="col-sm-7">: <span class="prosedur_bedah"></span></dd>
                        <dt class="col-sm-5">tenaga_ahli</dt>
                        <dd class="col-sm-7">: <span class="tenaga_ahli"></span></dd>
                        <dt class="col-sm-5">konsultasi</dt>
                        <dd class="col-sm-7">: <span class="konsultasi"></span></dd>
                        <dt class="col-sm-5">keperawatan</dt>
                        <dd class="col-sm-7">: <span class="keperawatan"></span></dd>
                        <dt class="col-sm-5">penunjang</dt>
                        <dd class="col-sm-7">: <span class="penunjang"></span></dd>
                        <dt class="col-sm-5">tarif_rs</dt>
                        <dd class="col-sm-7">: <span class="tarif_rs"></span></dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-5">radiologi</dt>
                        <dd class="col-sm-7">: <span class="radiologi"></span></dd>
                        <dt class="col-sm-5">laboratorium</dt>
                        <dd class="col-sm-7">: <span class="laboratorium"></span></dd>
                        <dt class="col-sm-5">pelayanan_darah</dt>
                        <dd class="col-sm-7">: <span class="pelayanan_darah"></span></dd>
                        <dt class="col-sm-5">rehabilitasi</dt>
                        <dd class="col-sm-7">: <span class="rehabilitasi"></span></dd>
                        <dt class="col-sm-5">kamar_akomodasi</dt>
                        <dd class="col-sm-7">: <span class="kamar_akomodasi"></span></dd>
                        <dt class="col-sm-5">rawat_intensif</dt>
                        <dd class="col-sm-7">: <span class="rawat_intensif"></span></dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-5">obat</dt>
                        <dd class="col-sm-7">: <span class="obat"></span></dd>
                        <dt class="col-sm-5">obat_kronis</dt>
                        <dd class="col-sm-7">: <span class="obat_kronis"></span></dd>
                        <dt class="col-sm-5">obat_kemo</dt>
                        <dd class="col-sm-7">: <span class="obat_kemo"></span></dd>
                        <dt class="col-sm-5">alkes</dt>
                        <dd class="col-sm-7">: <span class="alkes"></span></dd>
                        <dt class="col-sm-5">bmhp</dt>
                        <dd class="col-sm-7">: <span class="bmhp"></span></dd>
                        <dt class="col-sm-5">sewa_alat</dt>
                        <dd class="col-sm-7">: <span class="sewa_alat"></span></dd>
                    </dl>
                </div>
            </div>
        </x-adminlte-card>
        <x-slot name="footerSlot">
            <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
                <i class="fas fa-download "></i>Download</a>
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(function() {
            $('.btnDetail').click(function() {
                $.LoadingOverlay("show");
                var norm = $(this).data('norm');
                var counter = $(this).data('counter');

                $('.norm').html($(this).data('norm'));
                $('.nama').html($(this).data('nama'));
                $('.nomorkartu').html($(this).data('nomorkartu'));
                $('.nik').html($(this).data('nik'));
                $('.tgllahir').html($(this).data('tgllahir'));
                $('.hakkelas').html($(this).data('hakkelas'));
                $('.jeniskelamin').html($(this).data('jeniskelamin'));

                $('.counter').html($(this).data('counter'));
                $('.kodekunjungan').html($(this).data('kodekunjungan'));
                $('.tglmasuk').html($(this).data('tglmasuk'));
                $('.tglkeluar').html($(this).data('tglkeluar'));
                $('.unit').html($(this).data('unit'));
                $('.dokter').html($(this).data('dokter'));
                $('.kelasrawat').html($(this).data('kelasrawat'));

                $('.status').html($(this).data('status'));
                $('.alasanpulang').html($(this).data('alasanpulang'));
                $('.sep').html($(this).data('sep'));
                $('.tarifinacbg').html($(this).data('tarifinacbg'));
                $('.kodeinacbg').html($(this).data('kodeinacbg'));








                var urlRincian = "{{ route('api.eclaim.rincian_biaya_pasien') }}?counter=" +
                    counter + "&norm=" + norm;
                var table = $('#tableRincian')
                    .DataTable();
                table.rows().remove().draw();
                $.ajax({
                    url: urlRincian,
                    type: "GET",
                    success: function(data) {
                        if (data.metadata.code == 200) {
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
                            if (data.response.budget != null) {
                                $('.kode_inacbg')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .kode_cbg
                                    );
                                $('.description_inacbg')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .deskripsi
                                    );
                                $('.kelas')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .kelas
                                    );
                                $('.tarif_inacbg')
                                    .html(data.response.budget.tarif_inacbg.toLocaleString(
                                        'id-ID'));

                                $('.diagnosa_utama')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .diagnosa_utama
                                    );
                                $('.diagnosa_sekunder')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .diagnosa
                                    );
                                $('.pasien')
                                    .html(
                                        data
                                        .response
                                        .pasien
                                        .nama_px
                                    );
                                $('.kunjungan')
                                    .html(
                                        data
                                        .response
                                        .budget
                                        .rm_counter
                                    );
                                $('.rm_counter')
                                    .val(
                                        data
                                        .response
                                        .budget
                                        .rm_counter
                                    );

                                // cek tarif
                                var tarifrs = data.response.rangkuman.tarif_rs;
                                var tarifinacbg = data.response.budget.tarif_inacbg;
                                var kerugian = (tarifrs - tarifinacbg).toLocaleString('id-ID');
                                if (tarifrs > tarifinacbg) {
                                    swal.fire(
                                        'Peringatan Tarif',
                                        'Tarif RS (' + tarifrs +
                                        ') sudah melebihi Tarif INACBG (' + tarifinacbg +
                                        ') kerugian diperikirakan ' + kerugian,
                                        'warning'
                                    );
                                } else {
                                    swal.fire(
                                        'Informasi Tarif',
                                        'Tarif RS belum melebihi Tarif INACBG',
                                        'success'
                                    );
                                }
                            } else {
                                swal.fire(
                                    'Peringatan Groupping',
                                    'Silahkan lakukan groupping sebelum 3 hari dari tanggal masuk',
                                    'warning'
                                );
                            }
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
                $('#modalDetail').modal('show');
            });
        });
    </script>
@endsection
