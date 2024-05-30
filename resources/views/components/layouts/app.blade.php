@extends('adminlte::page')

@section('content_top_nav_left')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('profile') }}" class="nav-link">{{ Auth::user()->name }} </a>
    </li>
@endsection

@section('title', $title ?? config('app.name'))

@section('content_header')
    <h1>{{ $title ?? config('app.name') }}</h1>
@stop

@section('content')
    {{ $slot }}
@stop
