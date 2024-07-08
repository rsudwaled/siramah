@extends('adminlte::page')
@section('title', 'User Management')
@section('content_header')
    <h1>User Management</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $users_total }}" text="User Terdaftar" theme="success" icon="fas fa-users" />
        </div>
        <div class="col-12">
            <x-adminlte-card title="Data User" theme="secondary" collapsible>
                @if ($errors->any())
                    <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-adminlte-alert>
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button id="btnTambah" name="btnTambah" label="Tambah" class="btn-sm" theme="success"
                            title="Tambah User" icon="fas fa-plus" />
                        <x-adminlte-button label="Refresh" class="btn-sm" theme="warning" title="Refresh User"
                            icon="fas fa-sync" onclick="window.location='{{ route('user.index') }}'" />
                        <a href="{{ route('userexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                            Export</a>
                        <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('user.index') }}" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian Nama" igroup-size="sm"
                                value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari!" />
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
                    $heads = ['Id', 'Nama', 'Username', 'Phone', 'Email', 'Role', 'Simrs', 'Verify', 'Updated_at', 'Action'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>
                                {{ $item->phone }}
                            </td>
                            <td>
                                {{ $item->email }}
                            </td>
                            <td>
                                @foreach ($item->roles as $role)
                                    <span class="badge bg-success">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $item->id_simrs }}
                            </td>
                            <td>
                                @if ($item->email_verified_at == null)
                                    <i class="fas fa-user-times text-danger" data-toggle="tooltip"
                                        title="Email User Belum Terverifikasi"></i>
                                @else
                                    <i class="fas fa-user-check text-success" data-toggle="tooltip"
                                        title="Email User Terverifikasi"></i>
                                @endif
                                @isset($item->verificator)
                                    {{ $item->verificator->name }}
                                @endisset
                            </td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit User {{ $item->name }}" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-phone="{{ $item->phone }}"
                                    data-email="{{ $item->email }}" data-username="{{ $item->username }}"
                                    data-role="{{ $item->getRoleNames()->first() }}" />

                                @if ($item->email_verified_at)
                                    <x-adminlte-button class="btn-xs" theme="danger" icon="fas fa-user-times"
                                        title="Non-Verify User {{ $item->name }}"
                                        onclick="window.location='{{ route('user_verifikasi', $item) }}'" />
                                @else
                                    <x-adminlte-button class="btn-xs" theme="success" icon="fas fa-user-check"
                                        title="Verify User {{ $item->name }}"
                                        onclick="window.location='{{ route('user_verifikasi', $item) }}'" />
                                    <x-adminlte-button class="btn-xs btnDelete" theme="danger" icon="fas fa-trash-alt"
                                        title="Hapus User {{ $item->name }} " data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <div class="text-info float-left ">
                    Data yang ditampilkan {{ $users->count() }} dari total {{ $users_total }}
                </div>
                <div class="float-right pagination-sm">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalUser" title="User" icon="fas fa-user" theme="success" v-centered static-backdrop>
        <form action="" id="formUser" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="name" label="Nama" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-select2 id="role" name="role" label="Role / Jabatan" enable-old-support required>
                <option value="" selected disabled>Pilih Role / Jabatan</option>
                @foreach ($roles as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-input name="phone" type="number" label="Nomor HP / Telepon"
                placeholder="Nomor HP / Telepon yang dapat dihubungi" enable-old-support />
            <x-adminlte-input name="email" type="email" label="Email" placeholder="Email" enable-old-support
                required />
            <x-adminlte-input name="username" label="Username" placeholder="Username" enable-old-support required />
            <x-adminlte-input name="password" type="password" label="Password" placeholder="Password" required />
            <x-adminlte-input name="password_confirmation" type="password" label="Konfirmasi Password"
                placeholder="Konfirmasi Password" required />
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
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formUser').trigger("reset");
                $("#role").val('').change();
                $('#modalUser').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formUser').trigger("reset");
                // get
                var id = $(this).data("id");
                var name = $(this).data("name");
                var phone = $(this).data("phone");
                var email = $(this).data("email");
                var username = $(this).data("username");
                var role = $(this).data("role");
                // set
                $('#id').val(id);
                $('#name').val(name);
                $("#role").val(role).change();
                $('#phone').val(phone);
                $('#email').val(email);
                $('#username').val(username);
                $('#modalUser').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('user.store') }}";
                $('#formUser').attr('action', url);
                $("#method").prop('', true);
                $('#formUser').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('user.index') }}/" + id;
                $('#formUser').attr('action', url);
                $('#method').val('PUT');
                $('#formUser').submit();
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


    <x-adminlte-modal id="modalImport" title="Import User" icon="fas fa-user-injured" theme="success" static-backdrop>
        <form action="{{ route('userimport') }}" id="formImport" name="formImport" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-adminlte-input-file name="file" placeholder="Pilih file Import" igroup-size="sm"
                label="File Import Obat" />
            <x-slot name="footerSlot">
                <x-adminlte-button form="formImport" class="mr-auto withLoad" type="submit" icon="fas fa-save"
                    theme="success" label="Import" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
    <script>
        $(function() {
            $('.btnModalImport').click(function() {
                $.LoadingOverlay("show");
                $('#modalImport').modal('show');
                $.LoadingOverlay("hide");
            });
        });
    </script>

@endsection
