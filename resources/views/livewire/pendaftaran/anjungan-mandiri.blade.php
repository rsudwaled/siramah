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
    <div class="col-md-6">
        <x-adminlte-card title="Menu Anjungan Pelayanan Mandiri" class="m-2" theme="primary">
            <a href="{{ route('anjungan.mandiri.daftar') }}?jenispasien=JKN">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                    <h1>AMBIL ANTRIAN BPJS</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('anjungan.mandiri.pendaftaran') }}?jenispasien=NON-JKN">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                    <h1>AMBIL ANTRIAN UMUM</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('display.jadwal.rajal') }}">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                    <h1>JADWAL DOKTER</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('checkinAntrian') }}">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                    <h1>CHECKIN ANTRIAN</h1>
                </x-adminlte-card>
            </a>
            <x-slot name="footerSlot">
                <a href="{{ route('test.cetak.karcis') }}">
                    <x-adminlte-button icon="fas fa-print" class="withLoad" theme="warning" label="Test Print" />
                </a>
                {{-- <a href="{{ route('anjungan.mandiri.pendaftaran') }}?jenispasien=JKN">
                    <x-adminlte-button icon="fas fa-print" class="withLoad" theme="warning" label="BPJS Pendaftaran" />
                </a> --}}
            </x-slot>
        </x-adminlte-card>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="Checkin Melalui MJKN" class="m-2" theme="primary">
            <div class="text-center">
                <img src="{{ asset('portalbpjs.jpg') }}" width="50%" alt="">
                <br>
            </div>
        </x-adminlte-card>
    </div>

</div>
