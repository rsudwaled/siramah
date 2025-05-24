<div class="col-md-12">
    <div class="card">
        <header class="bg-green text-white p-1">
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
                        <h1>Anjungan Antrian Pasien</h1>
                        <h4>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</h4>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>
