<div class="card" style="font-size: 12px;">
    <div class="card-header p-2">
        <ul class="nav nav-pills" style="font-size: 14px;">
            <li class="nav-item">
                <a class="nav-link active" href="#form-konsultasi" data-toggle="tab">Konsultasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#print-konsultasi" data-toggle="tab">Lihat Print Konsultasi</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            @include('simrs.erm-ranap.dokter.cppt_konsultasi.component_konsultasi.tab_konsultasi')
            <div class="tab-pane" id="print-konsultasi">
                <div class="card">
                    <iframe src="{{ route('dashboard.erm-ranap.perkembangan-pasien.cetakan-konsultasi') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                        height="700px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>