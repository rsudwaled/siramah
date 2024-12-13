<div class="col-md-12" style="font-size: 12px;">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills" style="font-size: 14px;">
                <li class="nav-item">
                    <a class="nav-link active" href="#form-implementasi-evaluasi" data-toggle="tab">FORM IMPLEMENTASI DAN EVALUASI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#table-data-implementasi-evaluasi" data-toggle="tab">LIHAT CETAKAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#table-edit-data-implementasi-evaluasi" data-toggle="tab">DATA IMPLEMENTASI DAN EVALUASI</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="form-implementasi-evaluasi">
                    @include('simrs.erm-ranap.perawat.form.implementasi_evaluasi.form_implementasi_evaluasi')
                </div>
                <div class="tab-pane" id="table-data-implementasi-evaluasi">
                    <div class="card">
                        <iframe src="{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.cetakan-implementasi-evaluasi') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                            height="700px" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="tab-pane" id="table-edit-data-implementasi-evaluasi">
                    @include('simrs.erm-ranap.perawat.form.implementasi_evaluasi.form_edit_implementasi_evaluasi')
                </div>
            </div>
        </div>
    </div>
</div>
