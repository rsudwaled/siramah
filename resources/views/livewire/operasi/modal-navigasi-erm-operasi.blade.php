<x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-info-circle"></i> Status Kunjungan {{ $kunjungan->status_kunjungan }}
            </a>
        </li>
        <li class="nav-item">
            <a href="#jadwalOperasi" class="nav-link">
                <i class="fas fa-calendar-alt"></i> Jadwal Operasi
                @if ($kunjungan->jadwal_operasi?->status)
                    <span class="badge bg-success float-right">Sudah Terlaksana</span>
                @else
                    <span class="badge bg-danger float-right">Belum Terlaksana</span>
                @endif
            </a>

        </li>
        <li class="nav-item">
            <a href="#tindakanOperasi" class="nav-link">
                <i class="fas fa-file-medical"></i> Tindakan Kedokteran
                @if ($kunjungan->tindakan_operasi)
                    <span class="badge bg-success float-right">Sudah Diisi</span>
                @else
                    <span class="badge bg-danger float-right">Belum Diisi</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="#laporanOperasi" class="nav-link">
                <i class="fas fa-file-medical"></i> Laporan Operasi
                @if ($kunjungan->laporan_operasi)
                    <span class="badge bg-success float-right">Sudah Diisi</span>
                @else
                    <span class="badge bg-danger float-right">Belum Diisi</span>
                @endif
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
