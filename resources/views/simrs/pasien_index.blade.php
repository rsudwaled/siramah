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
            <x-adminlte-card title="Data Pasien" theme="secondary" collapsible>
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button label="Tambah" class="btn-sm" theme="success" title="Tambah Pasien"
                            icon="fas fa-plus" data-toggle="modal" data-target="#modalCustom" />
                        <a href="{{ route('pasienexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                            Export</a>
                        <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
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
                    $heads = [
                        'No RM',
                        'BPJS',
                        'NIK',
                        'ID',
                        'Nama Pasien (Sex)',
                        'Tanggal Lahir (Umur)',
                        'Kecamatan',
                        'Alamat',
                        'Tgl Entry',
                        'Action',
                    ];
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
                            <td>
                                {{ $item->ihs }}
                                @if ($item->ihs)
                                    <a href="{{ route('patient_sync') }}?norm={{ $item->no_rm }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @else
                                    <a href="{{ route('patient_sync') }}?norm={{ $item->no_rm }}"
                                        class="btn btn-xs btn-warning"> <i class="fas fa-sync"></i> Sync</a>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->format('Y-m-d') }}
                                ({{ \Carbon\Carbon::parse($item->tgl_lahir)->age }})
                            </td>
                            <td>{{ $item->kecamatans ? $item->kecamatans->nama_kecamatan : '-' }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->tgl_entry }} ({{ $item->pic }})</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit User {{ $item->nama_px }}" data-id="{{ $item->idx }}"
                                    data-norm="{{ $item->no_rm }}" data-nokartu="{{ $item->no_Bpjs }}"
                                    data-nik="{{ $item->nik_bpjs }}" data-nama="{{ $item->nama_px }}"
                                    data-tgllahir="{{ $item->tgl_lahir }}" data-tempatlahir="{{ $item->tempat_lahir }}"
                                    data-nohp="{{ $item->no_hp }}" data-telp="{{ $item->no_tlp }}"
                                    data-gender="{{ $item->jenis_kelamin }}" />
                                <a href="{{ route('pasien.show', $item->no_rm) }}" class="btn btn-xs btn-primary"><i
                                        class="fas fa-file-medical" title="Riwayat Pasien {{ $item->nama_px }}"></i></a>
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
    <x-adminlte-modal id="modalPasien" title="Pasien" icon="fas fa-user-injured" theme="success" size="xl">
        <form action="" id="formPasien" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="norm" igroup-size="sm" label="Nomor RM" placeholder="Nomor RM"
                        enable-old-support required readonly />
                    <x-adminlte-input name="nokartu" igroup-size="sm" label="Nomor Kartu BPJS"
                        placeholder="Nomor Kartu BPJS" enable-old-support>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariKartu">
                                <i class="fas fa-sync"></i> Sync
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nik" igroup-size="sm" label="NIK" placeholder="Nomor Induk Kependudukan"
                        enable-old-support>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariNIK">
                                <i class="fas fa-sync"></i> Sync
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nama" igroup-size="sm" label="Nama" placeholder="Nama Lengkap"
                        enable-old-support />
                    <x-adminlte-input name="nohp" igroup-size="sm" label="Nomor HP" placeholder="Nomor HP"
                        enable-old-support />
                    <x-adminlte-select name="gender" igroup-size="sm" label="Jenis Kelamin" enable-old-support>
                        <x-adminlte-options :options="['L' => 'Laki-Laki', 'P' => 'Perempuan']" placeholder="Jenis Kelamin" />
                    </x-adminlte-select>
                    <x-adminlte-input name="tempat_lahir" igroup-size="sm" label="Tempat Lahir"
                        placeholder="Tempat Lahir" enable-old-support />
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tanggal_lahir" igroup-size="sm" label="Tanggal Lahir"
                        placeholder="Tanggal Lahir" :config="$config" enable-old-support />
                </div>
                {{-- <div class="col-md-6">
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
                </div> --}}
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
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
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
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('pasien.store') }}";
                $('#formPasien').attr('action', url);
                $("#method").prop('', true);
                $('#formPasien').submit();

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
                $('#tanggal_lahir').val($(this).data("tgllahir"));
                $('#tempat_lahir').val($(this).data("tempatlahir"));
                $('#nohp').val($(this).data("nohp"));
                $('#gender').val($(this).data("gender")).change();
                $('#modalPasien').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#norm').val();
                var url = "{{ route('pasien.index') }}/" + id;
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
                        var url = "{{ route('pasien.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
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
            });
            $('.btnCariKartu').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $("#nokartu").val();
                var url = "{{ route('peserta_nomorkartu') }}?nomorkartu=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $("#nama").val(pasien.nama);
                            $("#nik").val(pasien.nik);
                            $("#nokartu").val(pasien.noKartu);
                            $("#tanggal_lahir").val(pasien.tglLahir);
                            $("#gender").val(pasien.sex).change();
                            $("#jenispeserta").val(pasien.jenisPeserta.keterangan);
                            $("#fktp").val(pasien.provUmum.nmProvider);
                            $("#hakkelas").val(pasien.hakKelas.kode).change();
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariNIK').click(function() {
                $.LoadingOverlay("show");
                var nik = $("#nik").val();
                var url = "{{ route('peserta_nik') }}?nik=" + nik +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $("#nama").val(pasien.nama);
                            $("#nik").val(pasien.nik);
                            $("#nokartu").val(pasien.noKartu);
                            $("#tanggal_lahir").val(pasien.tglLahir);
                            $("#gender").val(pasien.sex).change();
                            $("#jenispeserta").val(pasien.jenisPeserta.keterangan);
                            $("#fktp").val(pasien.provUmum.nmProvider);
                            $("#hakkelas").val(pasien.hakKelas.kode).change();
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
        });
    </script>
@endsection
