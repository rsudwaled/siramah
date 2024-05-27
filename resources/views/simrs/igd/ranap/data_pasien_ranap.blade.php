@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')

@section('content_header')
   
@stop
@section('content')
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <form action="" method="get">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn btn-sm bg-purple cekKunjunganPoli" data-toggle="modal" data-target="modalCekKunjunganPoli">CEK KUNJUNGAN</button>
                            <a onClick="window.location.reload();" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync"></i> Refresh</a>
                        </div>
                    </div>
                    @php
                        $heads = [
                            'TGL MASUK ',
                            'PASIEN',
                            'JENIS PASIEN',
                            'KUNJUNGAN',
                            'RUANGAN',
                            'SPRI / SEP RANAP',
                            'DETAIL',
                        ];
                        $config['order'] = ['0', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td>
                                    <b>
                                        {{ $item->tgl_masuk }}
                                    </b>
                                </td>

                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->pasien->no_rm]) }}" target="__blank">
                                        <b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->pasien->no_rm }} <br>NIK :
                                        {{ $item->pasien->nik_bpjs }} <br>No Kartu : {{ $item->pasien->no_Bpjs }}
                                    </a>
                                </td>

                                <td>
                                    <b>{{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}</b>
                                    <br>
                                    {{ $item->penjamin == null ? $item->penjamin_simrs->nama_penjamin : $item->penjamin->nama_penjamin_bpjs }}
                                </td>
                                <td>
                                    <b>
                                        {{ $item->pasien->no_rm }} | (RM PASIEN) <br>
                                        {{ $item->kode_kunjungan }} | ({{ $item->unit->nama_unit }}) <br>
                                        @if (!empty($item->tgl_keluar))
                                            <b>PASIEN SUDAH KELUAR</b>
                                        @else
                                            {{ strtoupper($item->status->status_kunjungan) }}
                                        @endif
                                    </b>
                                </td>
                                <td>
                                    <b>
                                        Kamar : {{ $item->kamar }} <br>
                                        BED : {{ $item->no_bed }} <br>
                                        Kelas : {{ $item->kelas }} <br>
                                    </b>
                                    @if ($item->is_ranap_daftar == 3)
                                        <small class="text-red"><b><i>( PASIEN TITIPAN )</i></b></small>
                                    @endif
                                    @if (!is_null($item->bpjsCheckHistories))
                                        @if (!is_null($item->bpjsCheckHistories->klsRawatNaik))
                                            @php
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 3) {
                                                    $naikKelas = 1;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 4) {
                                                    $naikKelas = 2;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 5) {
                                                    $naikKelas = 3;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 2) {
                                                    $naikKelas = 4;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 1) {
                                                    $naikKelas = 5;
                                                }
                                            @endphp
                                            <small class="text-red"><b><i>(NAIK KELAS :
                                                        Dari-{{ $item->bpjsCheckHistories->klsRawatHak }}
                                                        Ke-{{ $naikKelas }} )</i></b></small>
                                            {{-- @else
                                            <small class="text-red"><b><i>( PASIEN TITIPAN )</i></b></small> --}}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($item->jp_daftar == 1)
                                        <b>
                                            SPRI : {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                            <br>
                                            SEP :
                                            {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP RANAP' : $item->no_sep }}
                                        </b>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pasien-ranap.detail', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat">Detail</a>
                                    @if ($item->jp_daftar == 1)
                                        @if ($item->no_spri == null && $item->no_sep == null)
                                            <a href="{{ route('create-sepigd.ranap-bpjs', ['kunjungan' => $item->kode_kunjungan]) }}"
                                                class="btn btn-danger btn-xs btn-block btn-flat">Bridging</a>
                                        @endif
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCekKunjunganPoli" style="display: none;" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cek Kunjungan Pasien</h4>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">No RM PASIEN</label>
                                <input type="text" name="no_rm" id="no_rm" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btnCreateSPRIBatal"
                            data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-cekKunjungan" id="btn-cekKunjungan">CARI
                            KUNJUNGAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalCekKunjungan" style="display: none;" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">RIWAYAT KUNJUNGAN</h4>
                    <button type="button" class="btn btn-sm btn-default close" onclick="batalPilih()"
                        data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active btn btn-block btn-success btn-flat" id="rawat-jalan-tab"
                                        data-toggle="pill" href="#rawat-jalan" role="tab"
                                        aria-controls="rawat-jalan" aria-selected="false">Rawat Jalan</a>
                                    <a class="nav-link  btn btn-block btn-primary btn-flat" id="rawat-inap-tab"
                                        data-toggle="pill" href="#rawat-inap" role="tab" aria-controls="rawat-inap"
                                        aria-selected="true">Rawat
                                        Inap</a>
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
                                                    <th>RANAP</th>
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
                                        <table id="table1" class="riwayatRanap data-table table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>KUNJUNGAN</th>
                                                    <th>NO RM</th>
                                                    <th>PASIEN</th>
                                                    <th>POLI</th>
                                                    <th>STATUS</th>
                                                    <th>TGL MASUK</th>
                                                    <th>TGL PULANG</th>
                                                    <th>RANAP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                </form>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.cekKunjunganPoli').click(function(e) {
                $('#modalCekKunjunganPoli').modal('toggle');
            });

            $('.btn-cekKunjungan').click(function(e) {
                $('#modalCekKunjunganPoli').modal('hide');
                $('#modalCekKunjungan').modal('toggle');
                var rm = $('#no_rm').val();
                if (rm) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kunjungan-pasien.get') }}?rm=" + rm,
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data.riwayat);
                            $.each(data.riwayat, function(index, riwayat) {
                                var row = "<tr class='riwayat-kunjungan'><td>" + riwayat
                                    .kode_kunjungan + "</td><td>" +
                                    riwayat.no_rm + "</td><td>" + riwayat.pasien
                                    .nama_px +
                                    "</td><td>" + riwayat.unit.nama_unit + "</td><td>" +
                                    riwayat.status.status_kunjungan + "</td><td>" +
                                    riwayat.tgl_masuk + "</td><td>" + (riwayat
                                        .tgl_keluar == null ? 'Belum Pulang' : riwayat
                                        .tgl_keluar) +
                                    "</td><td><button class='btn btn-primary btn-xs'onclick=pilihRiwayat(" +
                                    riwayat.kode_kunjungan + "," + riwayat.no_rm +
                                    ")>Pilih Riwayat</button></td></tr>";
                                $('.riwayatKunjungan tbody').append(row);
                            });
                            $.each(data.ranap, function(index, ranap) {
                                var row = "<tr class='riwayat-kunjungan'><td>" + ranap
                                    .kode_kunjungan + "</td><td>" +
                                    ranap.no_rm + "</td><td>" + ranap.pasien
                                    .nama_px +
                                    "</td><td>" + ranap.unit.nama_unit + "</td><td>" +
                                    ranap.status.status_kunjungan + "</td><td>" +
                                    ranap
                                    .tgl_masuk + "</td><td>" + (ranap.tgl_keluar ==
                                        null ? 'Belum Pulang' : ranap.tgl_keluar) +
                                    "</td><td><button class='btn btn-primary btn-xs'onclick=pilihRiwayat(" +
                                    ranap.kode_kunjungan + "," + ranap.no_rm +
                                    ")>Pilih Riwayat</button></td></tr>";
                                $('.riwayatRanap tbody').append(row);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle error appropriately
                        }
                    });
                }

            });
        });

        function batalPilih() {
            $(".riwayat-kunjungan").remove();
            $('#no_rm').val('');
        }

        function pilihRiwayat(kode, rm) {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Pilih Riwayat Kunjungan untuk daftar Rawat Inap!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Pilih!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('riwayat-ranap.daftar') }}",
                        dataType: 'json',
                        data: {
                            kode: kode,
                            rm: rm,
                        },
                        success: function(response) {
                            window.location.href = response.url;
                        },
                    });
                }
            });
        }
    </script>
@endsection
