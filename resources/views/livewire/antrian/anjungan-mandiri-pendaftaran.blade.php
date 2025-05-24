<div class="row p-1">
    <x-header-anjungan-antrian />
    <div class="col-md-12">
        <x-adminlte-card title="Pendafataran Pasien {{ $jenispasien }}"  theme="success">
            <div wire:loading.remove>
                @if (flash()->message)
                    <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }}">
                        {{ flash()->message }}
                    </x-adminlte-alert>
                @endif
                <h4>Silahkan Pilih Poliklinik : </h4>
                <div class="row">
                    @if (!$namasubspesialis)
                        @foreach ($jadwals->groupby('namasubspesialis') as $key => $jadwal)
                            <div class="col-md-3">
                                <a href="#" wire:click="pilihPoli('{{ $key }}')">
                                    <x-adminlte-card body-class="bg-warning">
                                        <b>{{ strtoupper($key) }}</b>
                                    </x-adminlte-card>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-3">
                            <a href="#" wire:click="pilihPoli('{{ $namasubspesialis }}')">
                                <x-adminlte-card body-class="bg-warning">
                                    <b>{{ strtoupper($namasubspesialis) }}</b>
                                </x-adminlte-card>
                            </a>
                        </div>
                    @endif
                </div>
                @if ($namasubspesialis)
                    <h4>Silahkan pilih dokter : </h4>
                    <div class="row">
                        @foreach ($jadwaldokters as $jadwaldokter)
                            @if (
                                $jadwaldokter->libur ||
                                    count($antrians->where('kodedokter', $jadwaldokter->kodedokter)) >= $jadwaldokter->kapasitaspasien)
                                <div class="col-md-3">
                                    <a href="#">
                                        <x-adminlte-card body-class="bg-danger">
                                            <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                            <b>{{ strtoupper($jadwaldokter->jadwal) }}
                                                {{ $jadwaldokter->libur ? '(TUTUP)' : null }}</b><br>
                                            KUOTA {{ $jadwaldokter->kapasitaspasien }} / TERSEDIA
                                            {{ $jadwaldokter->kapasitaspasien - count($antrians->where('kodedokter', $jadwaldokter->kodedokter)) }}
                                        </x-adminlte-card>
                                    </a>
                                </div>
                            @else
                                <div class="col-md-3">
                                    <a href="#" wire:click="pilihDokter('{{ $jadwaldokter->id }}')">
                                        <x-adminlte-card body-class="bg-warning">
                                            <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                            <b>{{ strtoupper($jadwaldokter->jadwal) }}</b><br>
                                            KUOTA {{ $jadwaldokter->kapasitaspasien }} / TERSEDIA
                                            {{ $jadwaldokter->kapasitaspasien - count($antrians->where('kodedokter', $jadwaldokter->kodedokter)) }}
                                        </x-adminlte-card>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div wire:loading>
                <h2>Loading...</h2>
            </div>
            <x-slot name="footerSlot">
                <a href="{{ route('anjungan.mandiri') }}">
                    <x-adminlte-button class="withLoad" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
                </a>
            </x-slot>
        </x-adminlte-card>
    </div>
</div>
