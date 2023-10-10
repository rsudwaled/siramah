@extends('adminlte::page')
@section('title', 'Pasien')
@section('content_header')
    <h1>Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $total_pasien }}" text="Total Pasien" theme="success" icon="fas fa-users" />
        </div>
        <div class="col-12">
            <x-adminlte-card title="Grafik Pasien" theme="secondary" collapsible="collapsed">
                asdasd
            </x-adminlte-card>
            <x-adminlte-card title="Data Pasien" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah Pasien"
                            icon="fas fa-plus" data-toggle="modal" data-target="#modalCustom" />
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('pasien.index') }}" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian NIK / Nama / No RM / BPJS"
                                igroup-size="sm" value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="outline-primary" label="Cari" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
                @php
                    $heads = ['Kode RM', 'BPJS', 'NIK', 'Nama Pasien (Sex)', 'Tanggal Lahir (Umur)', 'Kecamatan', 'Alamat', 'Tgl Entry', 'Action'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($pasiens as $item)
                        <tr>
                            <td>
                                <a href="{{ route('kunjungan.index') }}?search={{ $item->no_rm }}" target="_blank"
                                    class="text-dark">
                                    <b>
                                        {{ $item->no_rm }}
                                    </b>
                                </a>
                            </td>
                            <td>{{ $item->no_Bpjs }}</td>
                            <td>{{ $item->nik_bpjs }}</td>
                            <td>{{ $item->nama_px }} ({{ $item->jenis_kelamin }})</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->format('Y-m-d') }}
                                ({{ \Carbon\Carbon::parse($item->tgl_lahir)->age }})
                            </td>
                            <td>{{ $item->kecamatans ? $item->kecamatans->nama_kecamatan : '-' }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->tgl_entry }} ({{ $item->pic }})</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit User {{ $item->nama_px }}" data-id="{{ $item->id }}"
                                    data-norm="{{ $item->no_rm }}" data-nokartu="{{ $item->no_Bpjs }}"
                                    data-nik="{{ $item->nik_bpjs }}" data-nama="{{ $item->nama_px }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $pasiens->firstItem() }} sampai {{ $pasiens->lastItem() }} dari total
                        {{ $total_pasien }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $pasiens->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalPasien" title="User" icon="fas fa-user" theme="success" size="xl">
        <form action="" id="formPasien" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="norm" label="Nomor RM" placeholder="Nomor Rekam Medis" enable-old-support
                        required readonly />
                    <x-adminlte-input name="nokartu" label="Nomor Kartu BPJS" placeholder="Nomor Kartu BPJS"
                        enable-old-support required />
                    <x-adminlte-input name="nik" label="NIK" placeholder="Nomor Induk Kependudukan"
                        enable-old-support required />
                    <x-adminlte-input name="nama" label="Nama" placeholder="Nama Lengkap" enable-old-support
                        required />
                    <x-adminlte-input name="no_hp" label="Nomor HP" placeholder="Nomor HP" enable-old-support required />
                    <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Tempat Lahir" enable-old-support
                        required />
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tanggal_lahir" label="Tanggal Lahir" placeholder="Tanggal Lahir"
                        :config="$config" enable-old-support required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select name="gender" label="Jenis Kelamin" enable-old-support>
                        <x-adminlte-options :options="['L' => 'Laki-Laki', 'P' => 'Perempuan']" placeholder="Jenis Kelamin" />
                    </x-adminlte-select>
                    <x-adminlte-select name="Agama" label="Agama" enable-old-support>
                        <x-adminlte-options :options="['Islam', 'Perempuan']" placeholder="Agama" />
                    </x-adminlte-select>
                    <x-adminlte-select name="perkawinan" label="Status Perkawinan" enable-old-support>
                        <x-adminlte-options :options="['Islam', 'Perempuan']" placeholder="Status Perkawinan" />
                    </x-adminlte-select>
                    <x-adminlte-input name="pekerjaan" label="Pekerjaan" placeholder="Pekerjaan" enable-old-support />
                    <x-adminlte-input name="kewarganegaraan" label="Kewarganegaraan" placeholder="Kewarganegaraan"
                        enable-old-support />
                    <x-adminlte-select name="darah" label="Golongan Darah" enable-old-support>
                        <x-adminlte-options :options="['A', 'B', 'AB', 'O']" placeholder="Golongan Darah" />
                    </x-adminlte-select>
                </div>
            </div>
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button id="btnStore" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button id="btnUpdate" class="mr-auto" type="submit" icon="fas fa-edit" theme="warning"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formPasien').trigger("reset");
                $("#role").val('').change();
                $('#modalPasien').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formPasien').trigger("reset");
                // get
                var id = $(this).data("id");
                // set
                $('#id').val(id);
                $('#nama').val($(this).data("nama"));
                $('#norm').val($(this).data("norm"));
                $('#nokartu').val($(this).data("nokartu"));
                $('#nik').val($(this).data("nik"));
                $('#modalPasien').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('user.store') }}";
                $('#formPasien').attr('action', url);
                $("#method").prop('', true);
                $('#formPasien').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('user.index') }}/" + id;
                $('#formPasien').attr('action', url);
                $('#method').val('PUT');
                $('#formPasien').submit();
            });
            $('.btnDelete').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menghapus user ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('user.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
        });
    </script>
@endsection
