<x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-info-circle"></i> Status Kunjungan {{$kunjungan->status_kunjungan}}
            </a>
        </li>
        <li class="nav-item">
            <a href="#jadwalOperasi" class="nav-link">
                <i class="fas fa-calendar-alt"></i> Jadwal Operasi
            </a>
        </li>
        <li class="nav-item">
            <a href="#laporanOperasi" class="nav-link">
                <i class="fas fa-file-medical"></i> Tindakan Kedokteran
            </a>
        </li>
        <li class="nav-item">
            <a href="#laporanOperasi" class="nav-link">
                <i class="fas fa-file-medical"></i> Laporan Operasi
            </a>
        </li>
        <x-slot name="footerSlot">
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
        </x-slot>
</x-adminlte-card>
