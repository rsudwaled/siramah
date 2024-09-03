<div class="col-md-3">
    <x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-info-circle"></i> Status Antrian
                    @switch($antrian->taskid)
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
                    @endswitch
                </a>
            </li>
            <li class="nav-item">
                <a href="#datapasien" class="nav-link">
                    <i class="fas fa-users"></i> Database Pasien
                </a>
            </li>
            <li class="nav-item">
                <a href="#antrian" class="nav-link">
                    <i class="fas fa-user-plus"></i> Antrian
                    @if ($antrian->status)
                        <span class="badge bg-success float-right">Sudah Didaftarkan</span>
                    @else
                        <span class="badge bg-danger float-right">Belum Didaftarkan</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="#kunjungan" class="nav-link">
                    <i class="fas fa-user-plus"></i> Kunjungan
                    @if ($antrian->kunjungan)
                        <span class="badge bg-success float-right">Sudah Didaftarkan</span>
                    @else
                        <span class="badge bg-danger float-right">Belum Kunjungan</span>
                    @endif
                </a>
            </li>
            @if ($antrian->jenispasien == 'JKN')
                <li class="nav-item">
                    <a href="#modalsep" class="nav-link">
                        <i class="fas fa-file-medical"></i> SEP
                        @if ($antrian->sep)
                            <span class="badge bg-success float-right">Sudah Dibuatkan</span>
                        @else
                            <span class="badge bg-danger float-right">Belum Dibuatkan</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#suratkontrol" class="nav-link">
                        <i class="fas fa-file-medical"></i> Surat Kontrol
                        {{-- @if ($antrian->suratkontrols->count())
                            <span class="badge bg-success float-right">Sudah Ada SKontrol Berikutnya</span>
                        @else
                            <span class="badge bg-danger float-right">Belum Ada SKontrol Berikutnya</span>
                        @endif --}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#rujukanfktp" class="nav-link">
                        <i class="fas fa-file-medical"></i> Rujukan FKTP
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#rujukanrs" class="nav-link">
                        <i class="fas fa-file-medical"></i> Rujukan Antar RS
                    </a>
                </li>
            @endif
            @if ($antrian->kunjungan)
                <li class="nav-item">
                    <a href="#cppt" class="nav-link">
                        <i class="fas fa-file-medical"></i> CPPT
                        <span class="badge bg-success float-right">
                            {{ $antrian->pasien ? $antrian->pasien->kunjungans->count() : 0 }} Kunjungan
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#layanan" class="nav-link">
                        <i class="fas fa-hand-holding-medical"></i> Layanan & Tindakan
                        <span class="badge bg-success float-right">
                            {{ $antrian->layanans->count() }} Layanan
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#invoice" class="nav-link">
                        <i class="fas fa-file-invoice-dollar"></i> Invoice Billing
                    </a>
                </li>
            @endif
        </ul>
        <x-slot name="footerSlot">
            <a
                href="{{ route('pendaftaran.rajal') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}&lantai={{ $this->lantai }}&loket={{ $this->loket }}&jenispasien={{ $this->jenispasien }}">
                <x-adminlte-button class="btn-xs mb-1" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
            </a>
            @if ($antrian->taskid == 1 || $antrian->taskid == 2)
                <x-adminlte-button wire:click='panggilpendaftaran' class="btn-xs mb-1" label="Panggil Pendaftaran"
                    theme="primary" icon="fas fa-microphone" />
                <x-adminlte-button wire:click='selesaipendaftaran'
                    wire:confirm='Apakah anda yakin antrian ini telah selesai ?' label="Selesai Pendaftaran"
                    class="btn-xs mb-1" icon="fas fa-check" theme="success" />
            @endif
            @if ($antrian->taskid == 2)
                @if ($antrian?->kunjungan?->status)
                    <x-adminlte-button wire:click='selesaiPendaftaran'
                        wire:confirm='Apakah anda yakin antrian ini telah selesai ?' label="Selesai Pendaftaran"
                        class="btn-xs mb-1" icon="fas fa-check" theme="success" />
                @endif
            @endif
            <x-adminlte-button wire:click='batalpendaftaran'
                wire:confirm='Apakah anda yakin ingin membatalkan antrian dan kunjungan ini ?' label="Batal"
                class="btn-xs mb-1" icon="fas fa-times" theme="danger" />
            {{-- <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                class="btn btn-sm btn-danger withLoad">
                <i class="fas fa-times"></i> Batal
            </a> --}}
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
        </x-slot>
    </x-adminlte-card>
</div>
