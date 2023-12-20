<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRincian">
        <h3 class="card-title">
            Rincian Biaya
        </h3>
        <div class="card-tools">
            Rp <span class="biaya_rs_html">-</span> <i class="fas fa-file-invoice-dollar"></i>
        </div>
    </a>
    <div id="cRincian" class="collapse" role="tabpanel">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">Prosedur Bedah</dt>
                        <dd class="col-sm-7">: <span class="prosedur_non_bedah"></span></dd>
                        <dt class="col-sm-5">Prosedur Non Bedah</dt>
                        <dd class="col-sm-7">: <span class="prosedur_bedah"></span></dd>
                        <dt class="col-sm-5">Tenaga Ahli</dt>
                        <dd class="col-sm-7">: <span class="tenaga_ahli"></span></dd>
                        <dt class="col-sm-5">radiologi</dt>
                        <dd class="col-sm-7">: <span class="radiologi"></span></dd>
                        <dt class="col-sm-5">laboratorium</dt>
                        <dd class="col-sm-7">: <span class="laboratorium"></span></dd>
                        <dt class="col-sm-5">rehabilitasi</dt>
                        <dd class="col-sm-7">: <span class="rehabilitasi"></span></dd>
                        <dt class="col-sm-5">sewa_alat</dt>
                        <dd class="col-sm-7">: <span class="sewa_alat"></span></dd>
                        <dt class="col-sm-5">keperawatan</dt>
                        <dd class="col-sm-7">: <span class="keperawatan"></span></dd>
                        <dt class="col-sm-5">kamar_akomodasi</dt>
                        <dd class="col-sm-7">: <span class="kamar_akomodasi"></span></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">penunjang</dt>
                        <dd class="col-sm-7">: <span class="penunjang"></span></dd>
                        <dt class="col-sm-5">konsultasi</dt>
                        <dd class="col-sm-7">: <span class="konsultasi"></span></dd>
                        <dt class="col-sm-5">pelayanan_darah</dt>
                        <dd class="col-sm-7">: <span class="pelayanan_darah"></span></dd>
                        <dt class="col-sm-5">rawat_intensif</dt>
                        <dd class="col-sm-7">: <span class="rawat_intensif"></span></dd>
                        <dt class="col-sm-5">obat</dt>
                        <dd class="col-sm-7">: <span class="obat"></span></dd>
                        <dt class="col-sm-5">alkes</dt>
                        <dd class="col-sm-7">: <span class="alkes"></span></dd>
                        <dt class="col-sm-5">bmhp</dt>
                        <dd class="col-sm-7">: <span class="bmhp"></span></dd>
                        <dt class="col-sm-5">obat_kronis</dt>
                        <dd class="col-sm-7">: <span class="obat_kronis"></span></dd>
                        <dt class="col-sm-5">obat_kemo</dt>
                        <dd class="col-sm-7">: <span class="obat_kemo"></span></dd>
                        <dt class="col-sm-5">tarif_rs</dt>
                        <dd class="col-sm-7">: <span class="tarif_rs"></span></dd>
                    </dl>
                </div>
                <div class="col-md-12">
                    @php
                        $heads = ['Tgl', 'Unit', 'Group Vclaim', 'Nama Tarif', 'Grandtotal'];
                        $config['order'] = [0,'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="tableRincianBiaya" class="nowrap text-xs" :heads="$heads"
                        :config="$config" bordered hoverable compressed>
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
</div>
