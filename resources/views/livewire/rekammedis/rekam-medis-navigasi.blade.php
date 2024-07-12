<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a href="#historikunjungan" class="nav-link">
            <i class="fas fa-file-invoice-dollar"></i> Histori Kunjungan
        </a>
    </li>
    <li class="nav-item">
        <a href="#file" class="nav-link">
            <i class="fas fa-copy"></i> File Penunjang
        </a>
    </li>
    <li class="nav-item">
        <a href="#sep" class="nav-link">
            <i class="fas fa-file-alt"></i> SEP
        </a>
    </li>
    <li class="nav-item">
        <a href="#rincianbiaya" class="nav-link">
            <i class="fas fa-file-invoice-dollar"></i> Rincian Biaya
        </a>
    </li>
    <li class="nav-item">
        <a href="#asesmenperawat" class="nav-link">
            <i class="fas fa-user-nurse"></i> Asesmen Perawat
        </a>
    </li>
    <li class="nav-item">
        <a href="#asesmendokter" class="nav-link">
            <i class="fas fa-user-md"></i> Asesmen Dokter
        </a>
    </li>
    <li class="nav-item">
        <a href="#casemixmanager" class="nav-link">
            <i class="fas fa-user-md"></i> Casemix Manager
            @if ($kunjungan->budget)
                @if ($kunjungan->budget->final)
                    <span class="badge bg-success float-right">Sudah Final</span>
                @else
                    <span class="badge bg-warning float-right">Belum Final</span>
                @endif
            @else
                <span class="badge bg-danger float-right">Belum</span>
            @endif
        </a>
    </li>

</ul>
