<nav
    class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
        @can(['pendaftaran-igd'])
            <li class="nav-item d-none d-sm-inline-block mr-1">
                <a href="#" data-toggle="modal" data-target="#modalCekBpjs" class="btn btn-sm btn-success">CEK STATUS
                    BPJS</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block mr-1">
                <button class="btn btn-sm bg-warning cekKunjunganPoli" data-toggle="modal"
                    data-target="modalCekKunjunganPoli">CEK KUNJUNGAN</button>
            </li>
            <li class="nav-item d-none d-sm-inline-block mr-1">
                <a href="{{ route('pasien-baru.create') }}" class="btn btn-sm bg-purple">Pasien Baru</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block mr-1">
                <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#modal-cetak-label">CETAK
                    LABEL</button>
            </li>
        @else
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link">Waktu Server {{ now() }}</a>
            </li>
        @endcan

    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if (Auth::user())
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
