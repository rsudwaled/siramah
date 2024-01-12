<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion"
        href="#cLaboratorium">
        <h3 class="card-title">
            Laboratorium
        </h3>
    </a>
    <div id="cLaboratorium" class="collapse" role="tabpanel">
        <div class="card-body">
            <div class="row">
                @foreach ($kunjungans->sortByDesc('tgl_masuk') as $item)
                    @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                        <div class="col-md-6">
                            <iframe width="100%" height="400px"
                                src="http://192.168.2.74/smartlab_waled/his/his_report?hisno={{ $lab->kode_layanan_header }}"
                                frameborder="0"></iframe>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
