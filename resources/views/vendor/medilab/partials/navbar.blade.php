<div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope"></i> <a href="mailto:contact@example.com">brsud.waled@gmail.com</a>
            <i class="bi bi-phone"></i>0898 3311 118
        </div>
        <div class="d-none d-lg-flex social-links align-items-center">
            <a href="#" class="facebook" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.instagram.com/brsudwaled/" target="_blank" class="instagram"><i
                    class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/@rsudwaledkab.cirebon2139" target="_blank" class="youtube"><i
                    class="bi bi-youtube"></i></i></a>
        </div>
    </div>
</div>
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <h1 class="logo me-auto">
            <a href="{{ route('landingpage') }}">
                <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" alt="" class="img-fluid">
                RSUD Waled</a>
        </h1>
        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto active" href="{{ route('landingpage') }}">Home</a></li>
                <li><a class="nav-link scrollto" href="{{ route('landingpage') }}#about">Pelayanan</a></li>
                <li class="dropdown"><a href="#"><span>Jadwal</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('landingpage') }}#jadwalrawatjalan">Jadwal Rawat Jalan</a></li>
                        <li><a href="{{ route('jadwaloperasi_info') }}">Jadwal Operasi</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="{{ route('bukutamu') }}#bukutamu">Buku Tamu</a></li>
                <li><a class="nav-link scrollto" href="#doctors">Bed Monitoring</a></li>
                <li><a class="nav-link scrollto" href="#contact">Kontak</a></li>
                @auth
                    <li><a class="nav-link scrollto" href="{{ route('home') }}">Dashboard</a></li>
                @else
                    <li><a class="nav-link scrollto" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <a href="https://www.siramah.rsudwaled.id/daftar" class="appointment-btn scrollto">
            Daftar
        </a>


    </div>
</header>
