<div class="col-md-12" style="font-size: 12px;">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills" style="font-size: 14px;">
                <li class="nav-item">
                    <a class="nav-link active" href="#form-assesmen" data-toggle="tab">FORM ASESMEN AWAL MEDIS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#table-data-assemen-medis" data-toggle="tab">LIHAT CETAKAN</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" id="table-data-assemen-medis">
                    <div class="card">
                        <iframe src="{{ route('dashboard.erm-ranap.assesmen-medis.cetakan-asesmen-awal-medis') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                            height="700px" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="tab-pane active" id="form-assesmen">
                    @include('simrs.erm-ranap.dokter.form.form_asesmen_awal_medis')
                </div>
            </div>
        </div>
    </div>
</div>
