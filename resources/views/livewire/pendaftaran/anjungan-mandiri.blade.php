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
        <div class="m-2">
            <h1>ANJUNGAN PENDAFTARAN PASIEN</h1>
        </div>
        <a href="{{ route('anjungan.mandiri.daftar') }}?pasienbaru=0&jenispasien=JKN">
            <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                <h1>PASIEN LAMA BPJS</h1>
            </x-adminlte-card>
        </a>
        <a href="{{ route('anjungan.mandiri.daftar') }}?pasienbaru=1&jenispasien=JKN">
            <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                <h1>PASIEN BARU BPJS</h1>
            </x-adminlte-card>
        </a>
        <a href="{{ route('anjungan.mandiri.daftar') }}?jenispasien=NON-JKN">
            <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                <h1>PASIEN UMUM</h1>
            </x-adminlte-card>
        </a>
        <a href="{{ route('anjungan.mandiri.daftar') }}?jenispasien=NON-JKN">
            <x-adminlte-card class="m-2 withLoad" body-class="bg-primary">
                <h1>JAMINAN LAINNYA</h1>
            </x-adminlte-card>
        </a>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="Cara Pendafataran Melalui MJKN" class="m-2" theme="primary">
            <div class="text-center">
                <img src="{{ asset('portalbpjs.jpg') }}" width="40%" alt="">
                <br>
            </div>
        </x-adminlte-card>
    </div>

</div>
