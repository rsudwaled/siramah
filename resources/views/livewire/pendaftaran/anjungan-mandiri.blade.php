<div class="row">
    <x-header-anjungan-antrian />
    <div class="col-md-6">
        <x-adminlte-card title="Menu Anjungan Pelayanan Mandiri" class="m-2" theme="success">
            <a href="{{ route('anjungan.mandiri.daftar') }}?jenispasien=JKN">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-success">
                    <h1>AMBIL ANTRIAN BPJS</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('anjungan.mandiri.pendaftaran') }}?jenispasien=NON-JKN">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-success">
                    <h1>AMBIL ANTRIAN UMUM</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('display.jadwal.rajal') }}">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-success">
                    <h1>JADWAL DOKTER</h1>
                </x-adminlte-card>
            </a>
            <a href="{{ route('anjungan.checkin') }}">
                <x-adminlte-card class="m-2 withLoad" body-class="bg-success">
                    <h1>CHECKIN MANUAL</h1>
                </x-adminlte-card>
            </a>
            <x-slot name="footerSlot">
                <a href="{{ route('test.cetak.karcis') }}">
                    <x-adminlte-button icon="fas fa-print" class="withLoad" theme="warning" label="Test Print" />
                </a>
                <a href="{{ route('anjungan.mandiri.pendaftaran') }}?jenispasien=JKN">
                    <x-adminlte-button icon="fas fa-print" class="withLoad" theme="warning" label="BPJS Pendaftaran" />
                </a>
            </x-slot>
        </x-adminlte-card>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="Checkin Melalui MJKN" class="m-2" theme="success">
            <div class="text-center">
                <img src="{{ asset('portalbpjs.jpg') }}" width="50%" alt="">
                <br>
            </div>
        </x-adminlte-card>
    </div>

</div>
