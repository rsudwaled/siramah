@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-12">
                <h5>PASIEN RAWAT INAP</h5>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-7">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="">Filter Data : </label>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="nama_pasien" class="form-control"
                                                value="{{ $request->nama_pasien != null ? $request->nama_pasien : '' }}"
                                                placeholder="cari nama pasien">
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input id="new-event" type="date" name="tanggal" class="form-control"
                                                    value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    placeholder="Event Title">
                                                <div class="input-group-append">
                                                    <button id="add-new-event" type="submit"
                                                        class="btn btn-primary btn-sm withLoad">Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-5 text-right">
                        <button type="button" class="btn btn-sm bg-success cekKunjunganPoli" data-toggle="modal"
                            data-target="modalCekKunjunganPoli">Cek Kunjungan</button>
                        <a onClick="window.location.reload();" class="btn btn-sm btn-warning">Refresh</a>
                    </div>
                </div>
                <x-adminlte-modal id="modalCekKunjunganPoli" class="modal-cek-kunjungan" title="Cek Kunjungan Pasien"
                    theme="success" size='md' disable-animations>
                    <form>
                        <div class="col-lg-12">
                            <x-adminlte-input name="no_rm" id="no_rm" label="No RM PASIEN" />
                        </div>
                        <x-slot name="footerSlot">
                            <x-adminlte-button type="submit" theme="success" class="btn-cekKunjungan" id="btn-cekKunjungan"
                                label="Cek Kunjungan" />
                            <x-adminlte-button theme="danger" label="batal" class="btnCreateSPRIBatal"
                                data-dismiss="modal" />
                        </x-slot>
                    </form>
                </x-adminlte-modal>

                <x-adminlte-modal id="modalCekKunjungan" title="Riwayat Kunjungan Pasien" theme="success" size='xl'>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">
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
                        </div>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="tutup" onclick="batalPilih()" data-dismiss="modal" />
                        </x-slot>
                    </div>
                </x-adminlte-modal>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    @php
                        $heads = ['Tgl Masuk / Kunjungan', 'Pasien', 'Alamat', 'Jenis Pasien', 'Ruangan', 'SPRI / SEP RANAP', 'Detail'];
                        $config['order'] = false;
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
                                        {{ $item->kode_kunjungan }} <br> ({{ $item->nama_unit }})
                                    </b> <br>
                                    {{ $item->tgl_masuk }}
                                </td>
                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->no_rm]) }}" target="__blank">
                                        <b>{{ $item->nama_px }}</b> <br>RM : {{ $item->no_rm }} <br>NIK :
                                        {{ $item->nik_bpjs }} <br>No Kartu : {{ $item->no_Bpjs }}
                                    </a>
                                </td>
                                <td>alamat : {{ $item->alamat }} / <br></td>
                                <td> {{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}
                                </td>

                                <td>
                                    <b>
                                        Kamar : {{ $item->kamar }} <br>
                                        BED : {{ $item->no_bed }} <br>
                                        Kelas : {{ $item->kelas }} <br>
                                    </b>
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
                            $.each(data, function(index, riwayat) {
                                var row = "<tr class='riwayat-kunjungan'><td>" + riwayat
                                    .kode_kunjungan + "</td><td>" +
                                    riwayat.no_rm + "</td><td>" + riwayat.pasien
                                    .nama_px +
                                    "</td><td>" + riwayat.unit.nama_unit + "</td><td>" +
                                    riwayat.status.status_kunjungan + "</td><td>" +
                                    riwayat
                                    .tgl_masuk + "</td><td>" + (riwayat.tgl_keluar ==
                                        null ? 'Belum Pulang' : riwayat.tgl_keluar) +
                                    "</td><td><button class='btn btn-primary btn-xs'onclick=pilihRiwayat(" +riwayat.kode_kunjungan +","+riwayat.no_rm+")>Pilih Riwayat</button></td></tr>";
                                $('.riwayatKunjungan tbody').append(row);
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
                                // if (data.code == 200) {
                                //     Swal.fire({
                                //         title: "Informasi!",
                                //         text: "Pasien bisa di daftarkan Rawat Inap",
                                //         icon: "success",
                                //         confirmButtonText: "oke!",
                                //     }).then((result) => {
                                //         if (result.isConfirmed) {
                                //             window.location.href = response.url;
                                //         }
                                //     });
                                //     $.LoadingOverlay("hide");
                                // } else {
                                //     Swal.fire({
                                //         title: "OOPS!!",
                                //         text: "Pasien Belum Pulang",
                                //         icon: "error",
                                //         confirmButtonText: "oke!",
                                //     }).then((result) => {
                                //         if (result.isConfirmed) {
                                //             location.reload();
                                //         }
                                //     });
                                //     $.LoadingOverlay("hide");
                                // }
                                window.location.href = response.url;
                            },
                        });
                    }
                });
        }
    </script>
@endsection
