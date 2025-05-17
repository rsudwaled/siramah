<div>
    <x-flash-message />
    @if ($formImport)
        <x-modal size="lg" title="Import Data" icon="fas fa-file-import" theme="dark">
            <x-adminlte-input-file wire:model='fileImport' name="fileImport"
                placeholder="{{ $fileImport ? $fileImport->getClientOriginalName() : 'Pilih File Import' }}"
                igroup-size="sm" label="File Import" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="btn-sm" wire:click='import' class="btn-sm" icon="fas fa-save" theme="success"
                    label="Import" wire:confirm='Apakah anda yakin akan mengimport data dokter ?' />
                <x-adminlte-button theme="danger" wire:click='openFormImport' class="btn-sm" icon="fas fa-times"
                    label="Tutup" data-dismiss="modal" />
            </x-slot>
        </x-modal>
    @endif
    @if ($form)
        <x-modal size="xl" title="User" icon="fas fa-user" theme="dark">
            <form>
                <input hidden wire:model="id" name="id">
                <x-adminlte-input wire:model="name" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="name" label="Nama" />
                <x-adminlte-input wire:model="username" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="username" label="Username" />
                <x-adminlte-input wire:model="email" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="email" type="email" label="Email" />
                <x-adminlte-input wire:model="phone" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="phone" label="Phone" />
                <x-adminlte-select wire:model="role" name="role" label="Role" fgroup-class="row"
                    label-class="text-left col-3" igroup-class="col-9" igroup-size="sm">
                    <option value="">--Pilih Role--</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-input wire:model="password" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" type="password" name="password" label="Password"
                    placeholder="Kosongkan jika tidak ingin ada perubahan" />
            </form>
            <x-slot name="footerSlot">
                <x-adminlte-button label="Simpan" class="btn-sm" icon="fas fa-save" wire:click="simpan"
                    wire:confirm="Apakah anda yakin ingin menambahkan user ?" form="formUpdate" theme="success" />
                <x-adminlte-button class="btn-sm" wire:click="tambah" label="Batal" theme="danger"
                    icon="fas fa-times" />
            </x-slot>
        </x-modal>
    @endif
    <div>
        <x-adminlte-card title="Data User" theme="secondary" icon="fas fa-users">
            <div class="row ">
                <div class="col-md-6">
                    <x-adminlte-button class="btn-sm mb-2" wire:click='tambah' title="Tambah User" theme="success"
                        icon="fas fa-user-plus" />
                    <x-adminlte-button wire:click='export'
                        wire:confirm='Apakah anda yakin akan mendownload file user saat ini ? ' class="btn-sm mb-2"
                        title="Export" theme="primary" icon="fas fa-file-export" />
                    <x-adminlte-button wire:click='openFormImport' class="btn-sm mb-2" title="Import"
                        theme="primary" icon="fas fa-file-import" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-select wire:model.live="searchRole" name="searchRole" igroup-size="sm">
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $key => $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-user-tie" title="Role" />
                        </x-slot>
                    </x-adminlte-select>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model.live="search" name="search" placeholder="Pencarian"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-search" title="Pencarian" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                <thead>
                    <tr>
                        <th wire:click="sort('id')">#
                            @if ($sortBy == 'id')
                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"
                                    style="float: right;"></i>
                            @endif
                        </th>
                        <th wire:click="sort('name')">Nama
                            @if ($sortBy == 'name')
                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"
                                    style="float: right;"></i>
                            @endif
                        </th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th wire:click="sort('role')">Role
                            @if ($sortBy == 'role')
                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"
                                    style="float: right;"></i>
                            @endif
                        </th>
                        <th>Action</th>
                        <th>PIC</th>
                        <th wire:click="sort('email_verified_at')">Verify
                            @if ($sortBy == 'email_verified_at')
                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"
                                    style="float: right;"></i>
                            @endif
                        </th>
                        <th wire:click="sort('updated_at')">Updated
                            @if ($sortBy == 'updated_at')
                                <i class="fas fa-sort-alpha-{{ $sortDirection == 'asc' ? 'down' : 'up' }}"
                                    style="float: right;"></i>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr wire:key="{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </td>
                                   <td>
                                <x-adminlte-button class="btn-xs" wire:click="edit('{{ $user->id }}')"
                                    theme="warning" icon="fas fa-edit" />
                                <x-adminlte-button wire:click="verifikasi('{{ $user->id }}')"
                                    wire:confirm="Apakah anda yakin ingin memverifikasi user {{ $user->name }} ?"
                                    class="btn-xs" title="Verifikasi Email"
                                    theme="{{ $user->email_verified_at ? 'danger' : 'success' }}"
                                    icon="fas fa-{{ $user->email_verified_at ? 'times' : 'check' }}" />
                                <x-adminlte-button wire:click='hapus({{ $user->id }})'
                                    wire:confirm="Apakah anda yakin ingin menghapus user {{ $user->name }} ?"
                                    class="btn-xs" title="Hapus User" theme="danger" icon="fas fa-trash" />
                            </td>
                            <td>{{ $user->pic }}</td>
                            <td>{{ $user->email_verified_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </x-adminlte-card>
    </div>
</div>
