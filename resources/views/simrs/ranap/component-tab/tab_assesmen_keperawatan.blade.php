<div class="tab-pane fade" id="tab-assesmen-keperawatan" role="tabpanel" aria-labelledby="tab-assesmen-keperawatan-tab">
    <div class="row">
        <div class="col-lg-3">
            <a href="#" onclick="modalAsesmenKeperawatan()">
                <div class="info-box mb-3 bg-warning text-center">
                    <span class="info-box-icon"><i class="fas fa-edit text-white"></i></span>
                    <div class="info-box-content">
                        <h5 class="info-box-text">EDIT ASSESMEN</h5>
                    </div>
                </div>
            </a>
            @if ($kunjungan->asesmen_ranap)
                <a href="#" onclick="printAsesmenAwal()">
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="fas fa-print"></i></span>
                        <div class="info-box-content">
                            <h6 class="info-box-text">Print</h6>
                        </div>
                    </div>
                </a>
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <h6 class="info-box-text">Sudah Asesmen</h6>
                    </div>
                </div>
            @else
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-exclamation"></i></span>
                    <div class="info-box-content">
                        <h6 class="info-box-text">Belum Assesmen</h6>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-9">
            <iframe src="{{ route('print_asesmen_ranap_keperawatan') }}?kode={{ $kunjungan->kode_kunjungan }}"
                width="100%" height="500px" frameborder="0"></iframe>
        </div>
    </div>
</div>
