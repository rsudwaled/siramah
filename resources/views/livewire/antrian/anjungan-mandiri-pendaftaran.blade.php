<div class="row">
    <div class="col-md-12">
        <div class="card">
            <header class="bg-green text-white p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <img src="{{ asset('vendor/adminlte/dist/img/logo rsudwaled bulet.png') }}" height="90"
                                    alt="">
                                <div class="col">
                                    <h1>RSUD Waled</h1>
                                    <h4>Rumah Sakit Umum Daerah Waled</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4>Anjungan Pelayanan Mandiri</h4>
                            <h6>{{ \Carbon\Carbon::now() }}</h6>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Pendafataran Pasien {{ $jenispasien }}" class="m-2" theme="primary">
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
                            @if ($jadwaldokter->libur)
                                <div class="col-md-3">
                                    <a href="#">
                                        <x-adminlte-card body-class="bg-danger">
                                            <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                            <b>{{ strtoupper($jadwaldokter->jadwal) }}
                                                {{ $jadwaldokter->libur ? '(TUTUP)' : null }}</b><br>
                                            KUOTA {{ $jadwaldokter->kapasitaspasien }}
                                        </x-adminlte-card>
                                    </a>
                                </div>
                            @else
                                <div class="col-md-3">
                                    <a href="#" wire:click="pilihDokter('{{ $jadwaldokter->id }}')">
                                        <x-adminlte-card body-class="bg-warning">
                                            <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                            <b>{{ strtoupper($jadwaldokter->jadwal) }}</b><br>
                                            KUOTA {{ $jadwaldokter->kapasitaspasien }}
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
