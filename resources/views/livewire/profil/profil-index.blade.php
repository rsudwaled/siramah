<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-4">
        <x-adminlte-profile-widget name="{{ $user->name }}" desc="{{ $user->email }}" theme="primary"
            img="{{ $user->adminlte_image() }}">
            <ul class="nav flex-column col-md-12">
                <li class="nav-item">
                    <b class="nav-link">Nama <b class="float-right ">{{ $user->name }}</b></b>
                </li>
                <li class="nav-item">
                    <b class="nav-link">Username <b class="float-right ">{{ $user->username }}</b></b>
                </li>
                <li class="nav-item">
                    <b class="nav-link">No HP <b class="float-right ">{{ $user->phone }}</b></b>
                </li>
                <li class="nav-item">
                    <b class="nav-link">Email <b class="float-right ">{{ $user->email }}</b></b>
                </li>
                <li class="nav-item">
                    <b class="nav-link">Verifikasi <b class="float-right ">{{ $user->email_verified_at }}</b></b>
                </li>
            </ul>
        </x-adminlte-profile-widget>
    </div>
    <div class="col-md-8">
        <x-adminlte-card title="Identitas User" theme="primary">
            <form>
                <x-adminlte-input wire:model="name" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="name" label="Nama" />
                <x-adminlte-input wire:model="username" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="username" label="Username" />
                <x-adminlte-input wire:model="phone" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="phone" label="Phone" />
                <x-adminlte-input wire:model="email" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="email" type="email" label="Email" />
                <x-adminlte-input wire:model="password" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" name="password" type="password" label="Password"
                    placeholder="Isi apabila ingin merubah passowrd" />
            </form>
            <x-slot name="footerSlot">
                <x-adminlte-button label="Simpan" wire:click="save"
                    wire:confirm="Apakah anda ingin menyimpan data profil {{ $user->name }} ?" form="formUpdate"
                    theme="warning" icon="fas fa-save" />
            </x-slot>
        </x-adminlte-card>
    </div>
</div>
