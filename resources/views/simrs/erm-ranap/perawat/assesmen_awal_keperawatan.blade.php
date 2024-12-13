<div class="col-md-12" style="font-size: 12px;">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills" style="font-size: 14px;">
                <li class="nav-item">
                    <a class="nav-link active" href="#form-assesmen-keperawatan" data-toggle="tab">Form Asesmen Keperawatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#table-data-assemen-awal-keperawatan" data-toggle="tab">LIHAT CETAKAN</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="form-assesmen-keperawatan">
                    @include('simrs.erm-ranap.perawat.form.form_asesmen_keperawatan')
                </div>
                <div class="tab-pane" id="table-data-assemen-awal-keperawatan">
                    <div class="card">
                        <iframe src="{{ route('dashboard.erm-ranap.perawat.assesmen-awal.cetakan-asesmen-awal-keperawatan') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                            height="700px" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@endpush