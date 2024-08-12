<div>
    @if (flash()->message)
        <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
            {{ flash()->message }}
        </x-adminlte-alert>
    @endif
    <div id="editPermission">
        @if ($form)
            <x-adminlte-card title="Permission" theme="secondary">
                <form>
                    <input type="hidden" wire:model="id" name="id">
                    <x-adminlte-input wire:model="name" fgroup-class="row" label-class="text-left col-3"
                        igroup-class="col-9" igroup-size="sm" name="name" label="Nama"
                        placeholder="Nama Permission" />
                </form>
                <x-slot name="footerSlot">
                    <x-adminlte-button label="Simpan" class="btn-sm" icon="fas fa-save" wire:click="store"
                        wire:confirm="Apakah anda yakin ingin menyimpan permission ?" theme="success" />
                    <x-adminlte-button wire:click='closeForm' class="btn-sm" label="Tutup" theme="danger"
                        icon="fas fa-times" />
                </x-slot>
            </x-adminlte-card>
        @endif
    </div>
    <x-adminlte-card title="Table Permission" theme="secondary">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-button wire:click='openForm' class="btn-sm mb-3" label="Add Permission" theme="success"
                    icon="fas fa-user-plus" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model.live="search" name="search" placeholder="Pencarian Permission"
                    igroup-size="sm">
                    <x-slot name="appendSlot">
                        <x-adminlte-button wire:click="test" theme="primary" label="Cari" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-search"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>
        @php
            $heads = ['#', 'Name', 'Role', 'Action'];
            $config['order'] = [0, 'asc'];
            $config['paging'] = false;
            $config['searching'] = false;
            $config['info'] = false;
            $config['scrollX'] = true;
        @endphp
        <x-adminlte-datatable id="tablePermission" class="text-nowrap" :heads="$heads" :config="$config" bordered
            hoverable compressed>
            @foreach ($permissions as $item)
                <tr wire:key="{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td></td>
                    <td>
                        <a href="#editPermission">
                            <x-adminlte-button label="Edit" class="btn-xs" icon="fas fa-edit"
                                wire:click="edit({{ $item->id }})" theme="warning" />
                        </a>
                        <x-adminlte-button label="Hapus" class="btn-xs" icon="fas fa-trash"
                            wire:click="destroy({{ $item->id }})"
                            wire:confirm="Apakah anda yakin ingin menghapus permission ?" theme="danger" />
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
</div>
