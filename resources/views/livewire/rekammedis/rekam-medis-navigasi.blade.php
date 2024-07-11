<div class="col-md-3">
    <x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="#sep" class="nav-link">
                    <i class="fas fa-file-invoice-dollar"></i> Histori Kunjungan
                </a>
            </li>
            <li class="nav-item">
                <a href="#sep" class="nav-link">
                    <i class="fas fa-file-alt"></i> SEP
                </a>
            </li>
            <li class="nav-item">
                <a href="#file" class="nav-link">
                    <i class="fas fa-copy"></i> File Penunjang
                </a>
            </li>
            <li class="nav-item">
                <a href="#rincianbiaya" class="nav-link">
                    <i class="fas fa-user-nurse"></i> Asesmen Perawat
                </a>
            </li>
            <li class="nav-item">
                <a href="#rincianbiaya" class="nav-link">
                    <i class="fas fa-user-md"></i> Asesmen Dokter
                </a>
            </li>
            <li class="nav-item">
                <a href="#rincianbiaya" class="nav-link">
                    <i class="fas fa-file-invoice-dollar"></i> Rincian Biaya
                </a>
            </li>

        </ul>
        <x-slot name="footerSlot">
            <x-adminlte-button class="btn-xs mb-1" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
        </x-slot>
    </x-adminlte-card>
</div>
