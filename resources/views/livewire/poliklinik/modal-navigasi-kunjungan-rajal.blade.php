<div class="col-md-3">
    <x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-info-circle"></i> Status Kunjungan
                    {{-- @switch($antrian->taskid)
                        @case(0)
                            <span class="badge bg-secondary float-right">{{ $antrian->taskid }}. Belum Checkin</span>
                        @break

                        @case(1)
                            <span class="badge bg-warning float-right">{{ $antrian->taskid }}. Tunggu Pendaftaran</span>
                        @break

                        @case(2)
                            <span class="badge bg-primary float-right">{{ $antrian->taskid }}. Proses Pendaftaran</span>
                        @break

                        @case(3)
                            <span class="badge bg-warning float-right">{{ $antrian->taskid }}. Tunggu Dokter</span>
                        @break

                        @case(4)
                            <span class="badge bg-primary float-right">{{ $antrian->taskid }}. Pelayanan Dokter</span>
                        @break

                        @case(5)
                            <span class="badge bg-warning float-right">{{ $antrian->taskid }}. Tunggu Farmasi</span>
                        @break

                        @case(6)
                            <span class="badge bg-primary float-right">{{ $antrian->taskid }}. Pelayanan Farmasi</span>
                        @break

                        @case(7)
                            <span class="badge bg-success float-right">{{ $antrian->taskid }}. Selesai</span>
                        @break

                        @case(99)
                            <span class="badge bg-danger float-right">{{ $antrian->taskid }}. Batal</span>
                        @break

                        @default
                    @endswitch --}}
                </a>
            </li>
            <li class="nav-item">
                <a href="#icare" class="nav-link">
                    <i class="fas fa-info-circle"></i> Icare JKN
                </a>
            </li>
            <li class="nav-item">
                <a href="#sep" class="nav-link">
                    <i class="fas fa-info-circle"></i> SEP
                </a>
            </li>
            <li class="nav-item">
                <a href="#suratkontrol" class="nav-link">
                    <i class="fas fa-info-circle"></i> Surat Kontrol
                </a>
            </li>
        </ul>
        <x-slot name="footerSlot">
            <a
                href="{{ route('kunjungan.poliklinik') }}?tgl_masuk={{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d') }}&kode_unit={{ $kunjungan->kode_unit }}">
                <x-adminlte-button class="btn-xs mb-1" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
            </a>
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
        </x-slot>
    </x-adminlte-card>
</div>
