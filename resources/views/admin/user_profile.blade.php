@extends('adminlte::page')

@section('title', 'Profil ' . $user->name)

@section('content_header')
    <h1>Profil</h1>
@stop

@section('content')
    <div class="row">
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
                        <b class="nav-link">Phone <b class="float-right ">{{ $user->phone }}</b></b>
                    </li>
                    <li class="nav-item">
                        <b class="nav-link">Email <b class="float-right ">{{ $user->email }}</b></b>
                    </li>
                    <li class="nav-item">
                        <b class="nav-link">Role <b class="float-right ">
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </b></b>
                    </li>
                </ul>

            </x-adminlte-profile-widget>
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Identitas User" theme="primary">
                <form action="{{ route('user.update', $user->id) }}" id="formUpdate" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="role" value="{{ $user->roles->first()->name }}">
                    <x-adminlte-input name="name" label="Nama" value="{{ $user->name }}" placeholder="Nama Lengkap"
                        enable-old-support required />
                    <x-adminlte-input name="phone" type="number" value="{{ $user->phone }}" label="Nomor HP / Telepon"
                        placeholder="Nomor HP / Telepon yang dapat dihubungi" enable-old-support />
                    <x-adminlte-input name="email" type="email" value="{{ $user->email }}" label="Email"
                        placeholder="Email" enable-old-support required />
                    <x-adminlte-input name="username" label="Username" value="{{ $user->username }}" placeholder="Username"
                        enable-old-support required />
                    <x-adminlte-input name="password" type="password" value="" label="Password"
                        placeholder="Password" />
                    <x-adminlte-input name="password_confirmation" value="" type="password"
                        label="Konfirmasi Password" placeholder="Konfirmasi Password" />
                </form>
                <x-slot name="footerSlot">
                    <x-adminlte-button label="Update" type="submit" form="formUpdate" theme="warning" icon="fas fa-edit" />
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>
@stop
