@extends('adminlte::page')
@section('title', 'Role & Permssion')
@section('content_header')
    <h1>Role & Permission</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $roles->count() }}" text="Total Role" theme="success" icon="fas fa-users-cog" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $permissions->count() }}" text="Total Permission" theme="success"
                icon="fas fa-user-shield" />
        </div>
        <div class="col-12">
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
                <div class="col-md-7">
                    <x-adminlte-card title="Tabel Role" theme="secondary" collapsible>
                        <div class="row">
                            <div class="col-md-7">
                                <x-adminlte-button id="tambahRole" label="Tambah Role" class="btn-sm" theme="success"
                                    title="Tambah Role" icon="fas fa-plus" />
                            </div>
                            <div class="col-md-5">
                                <form action="{{ route('role.index') }}" method="get">
                                    <x-adminlte-input name="role" placeholder="Pencarian Role" igroup-size="sm"
                                        value="{{ $request->role }}">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button type="submit" theme="outline-primary" label="Cari!" />
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
                            $heads = ['Role', 'Permission', 'User', 'Action'];
                            $config['paging'] = false;
                            $config['lengthMenu'] = false;
                            $config['searching'] = false;
                            $config['info'] = false;
                            $config['responsive'] = true;
                        @endphp
                        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered
                            compressed>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @forelse ($item->permissions as $permission)
                                            <span class="badge badge-warning">{{ $permission->name }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $item->users->count() }}
                                    </td>
                                    <td>
                                        <x-adminlte-button class="btn-xs editRole" theme="warning" icon="fas fa-edit"
                                            title="Edit {{ $item->name }}" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-permission="{{ $item->permissions->pluck('name') }}" />
                                        <x-adminlte-button class="btn-xs deleteRole" theme="danger" icon="fas fa-trash-alt"
                                            title="Hapus Permission {{ $item->name }} " data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
                <div class="col-md-5">
                    <x-adminlte-card title="Tabel Permission" theme="secondary" collapsible>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-button label="Tambah Permission" class="btn-sm" theme="success"
                                    title="Tambah Permission" icon="fas fa-plus" id="tambahPermission" />
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('role.index') }}" method="get">
                                    <x-adminlte-input name="permission" placeholder="Pencarian Permission" igroup-size="sm"
                                        value="{{ $request->permission }}">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button type="submit" theme="outline-primary" label="Cari!" />
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
                            $heads = ['Permission', 'Role', 'Action'];
                            $config['paging'] = false;
                            $config['lengthMenu'] = false;
                            $config['searching'] = false;
                            $config['info'] = false;
                            $config['responsive'] = true;
                        @endphp
                        <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered
                            compressed>
                            @foreach ($permissions as $item)
                                <tr>
                                    <td>
                                        <span class="badge badge-warning">{{ $item->name }}</span>
                                    </td>
                                    <td>
                                        {{ $item->roles->count() }}
                                    </td>
                                    <td>
                                        <x-adminlte-button class="btn-xs editPermission" theme="warning" icon="fas fa-edit"
                                            title="Edit {{ $item->name }}" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" />
                                        <x-adminlte-button class="btn-xs deletePermission" theme="danger"
                                            icon="fas fa-trash-alt" title="Hapus Permission {{ $item->name }} "
                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalRole" icon="fas fa-users-cog" title="Role" theme="success" v-centered static-backdrop>
        <form action="" id="formRole" method="POST">
            @csrf
            <input type="hidden" name="id" id="idRole">
            <input type="hidden" name="_method" id="methodRole">
            <x-adminlte-input id="nameRole" name="name" label="Nama" placeholder="Nama Role" enable-old-support
                required />
            <x-adminlte-select2 id="permissionRole" name="permission[]" label="Permission"
                placeholder="Silahkan pilih permission" enable-old-support multiple required>
                @foreach ($permissions as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </x-adminlte-select2>
        </form>
        <form id="formDeleteRole" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button id="storeRole" class="mr-auto" theme="success" label="Simpan" icon="fas fa-save" />
            <x-adminlte-button id="updateRole" class="mr-auto" theme="warning" label="Edit" icon="fas fa-edit" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalPermission" icon="fas fa-user-shield" title="Permission" theme="success" v-centered
        static-backdrop>
        <form action="" id="formPermission" method="post">
            @csrf
            <input type="hidden" name="id" id="idPermission">
            <input type="hidden" name="_method" id="methodPermission">
            <x-adminlte-input id="namePermission" name="name" label="Nama" placeholder="Nama Lengkap"
                enable-old-support required />
        </form>
        <form id="formDeletePermission" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button id="storePermission" class="mr-auto" theme="success" label="Simpan"
                icon="fas fa-save" />
            <x-adminlte-button id="updatePermission" class="mr-auto" theme="warning" label="Edit"
                icon="fas fa-edit" />
            <x-adminlte-button theme="danger" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            // crud role
            $('#tambahRole').click(function() {
                $.LoadingOverlay("show");
                $('#storeRole').show();
                $('#updateRole').hide();
                $('#formRole').trigger("reset");
                $("#permissionRole").val(null).trigger('change');
                $('#modalRole').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.editRole').click(function() {
                $.LoadingOverlay("show");
                $('#storeRole').hide();
                $('#updateRole').show()
                $('#formUser').trigger("reset");
                // get
                var id = $(this).data("id");
                var name = $(this).data("name");
                var permission = $(this).data("permission");
                // set
                $('#idRole').val(id);
                $('#nameRole').val(name);
                $("#permissionRole").val(permission).trigger('change');
                $('#modalRole').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#storeRole').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('role.store') }}";
                $('#formRole').attr('action', url);
                $("#methodRole").prop('', true);
                $('#formRole').submit();

            });
            $('#updateRole').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('role.store') }}";
                $('#formRole').attr('action', url);
                $("#methodRole").prop('', true);
                $('#formRole').submit();
            });
            $('.deleteRole').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menghapus role ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('role.index') }}/" + id;
                        $('#formDeleteRole').attr('action', url);
                        $('#formDeleteRole').submit();
                    }
                })
            });
            // crud permission
            $('#tambahPermission').click(function() {
                $.LoadingOverlay("show");
                $('#storePermission').show();
                $('#updatePermission').hide();
                $('#formPermission').trigger("reset");
                $('#modalPermission').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.editPermission').click(function() {
                $.LoadingOverlay("show");
                $('#storePermission').hide();
                $('#updatePermission').show()
                $('#formPermission').trigger("reset");
                // get
                var id = $(this).data("id");
                var name = $(this).data("name");
                // set
                $('#idPermission').val(id);
                $('#namePermission').val(name);
                $('#modalPermission').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#storePermission').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('permission.store') }}";
                $('#formPermission').attr('action', url);
                $("#methodPermission").prop('', true);
                $('#formPermission').submit();

            });
            $('#updatePermission').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('permission.store') }}";
                $('#formPermission').attr('action', url);
                $("#methodPermission").prop('', true);
                $('#formPermission').submit();
            });
            $('.deletePermission').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menghapus permission ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('permission.index') }}/" + id;
                        $('#formDeletePermission').attr('action', url);
                        $('#formDeletePermission').submit();
                    }
                })
            });
        });
    </script>
@endsection
