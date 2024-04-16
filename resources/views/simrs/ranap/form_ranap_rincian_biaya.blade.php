<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRincian">
        <h3 class="card-title">
            Rincian Biaya
        </h3>
        <div class="card-tools">
            {{ money($data->rangkuman->tarif_rs, 'IDR') }} <i class="fas fa-file-invoice-dollar"></i>
        </div>
    </a>
    <div id="cRincian" class="collapse show" role="tabpanel">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <style>
                        dd {
                            margin-bottom: 0 !important;
                        }
                    </style>
                    <dl class="row">
                        <dt class="col-sm-5">Prosedur Bedah</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->prosedur_bedah, 'IDR') }} </dd>
                        <dt class="col-sm-5">Prosedur Non Bedah</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->prosedur_non_bedah, 'IDR') }}</dd>
                        <dt class="col-sm-5">Tenaga Ahli</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->tenaga_ahli, 'IDR') }}</dd>
                        <dt class="col-sm-5">Radiologi</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->radiologi, 'IDR') }}</dd>
                        <dt class="col-sm-5">Laboratorium</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->laboratorium, 'IDR') }}</dd>
                        <dt class="col-sm-5">Rehabilitasi</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->rehabilitasi, 'IDR') }}</dd>
                        <dt class="col-sm-5">Sewa Alat</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->sewa_alat, 'IDR') }}</dd>
                        <dt class="col-sm-5">Keperawatan</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->keperawatan, 'IDR') }}</dd>
                        <dt class="col-sm-5">Kamar Akomodasi</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->kamar_akomodasi, 'IDR') }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">Penunjang</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->penunjang, 'IDR') }}</dd>
                        <dt class="col-sm-5">Konsultasi</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->konsultasi, 'IDR') }}</dd>
                        <dt class="col-sm-5">Pelayanan Darah</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->pelayanan_darah, 'IDR') }}</dd>
                        <dt class="col-sm-5">Rawat Intensif</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->rawat_intensif, 'IDR') }}</dd>
                        <dt class="col-sm-5">Obat</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->obat, 'IDR') }}</dd>
                        <dt class="col-sm-5">Alkes</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->alkes, 'IDR') }}</dd>
                        <dt class="col-sm-5">BMHP</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->bmhp, 'IDR') }}</dd>
                        <dt class="col-sm-5">Obat Kronis</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->obat_kronis, 'IDR') }}</dd>
                        <dt class="col-sm-5">Obat Kemo</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->obat_kemo, 'IDR') }}</dd>
                        <dt class="col-sm-5">Tarif TS</dt>
                        <dd class="col-sm-7">: {{ money($data->rangkuman->tarif_rs, 'IDR') }}</dd>
                    </dl>
                </div>
                <button class="btn btn-warning btn-sm" onclick="lihatRincianBiaya()"><i
                        class="fas fa-money-check-alt"></i> Detail Rincian
                    Biaya</button>

            </div>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalRincianBiaya" name="modalRincianBiaya" title="Detail Rincian Biaya" theme="success"
    icon="fas fa-money-check-alt" size="xl">
    <div class="row">
        <div class="col-md-12">
            @php
                $heads = ['Tgl', 'Unit', 'Group Vclaim', 'Nama Tarif', 'Grandtotal'];
                $config['order'] = [0, 'desc'];
                $config['paging'] = false;
                $config['info'] = false;
                $config['info'] = false;
                $config['scrollY'] = '300px';
            @endphp
            <x-adminlte-datatable id="tableRincianBiaya" class="nowrap text-xs" :heads="$heads" :config="$config"
                bordered hoverable compressed>
                @foreach ($data->rincian as $item)
                    <tr>
                        <td>{{ $item->TGL }}</td>
                        <td>{{ $item->NAMA_UNIT }}</td>
                        <td>{{ $item->nama_group_vclaim }}</td>
                        <td>{{ $item->NAMA_TARIF }}</td>
                        <td>{{ $item->GRANTOTAL_LAYANAN }}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<script>
    $(function() {
        $('.biaya_rs_html').html("{{ money($data->rangkuman->tarif_rs, 'IDR') }}");
        var groupping = "{{ $data->groupping }}";
        if (groupping == "true") {
            $('.tarif_eklaim_html').html("{{ money($data->budget->tarif_inacbg ?? 0, 'IDR') }}");
            $('.code_cbg_html').html("{{ $data->budget->kode_cbg ?? 'Belum Groupping' }}");
            var tarif_rs = parseInt("{{ $data->rangkuman->tarif_rs ?? 0 }}");
            var tarif_inacbg = parseInt("{{ $data->budget->tarif_inacbg ?? 0 }}");
            // console.log(tarif_rs);
            // console.log(tarif_inacbg);
            console.log(tarif_rs > tarif_inacbg);
            if (tarif_rs > tarif_inacbg) {
                swal.fire(
                    "Peringatan Tarif Eklaim",
                    "Tarif RS Sudah Melebihi Tarif Klaim, Mohon Periksa kembali pelayanan",
                    'warning'
                );
            } else {
                swal.fire(
                    "Peringatan Groupping Eklaim",
                    "Telah dilakukan groupping, tarif RS masih aman dari tarif Eklaim",
                    'success'
                );
            }
        } else {
            $('.tarif_eklaim_html').html("{{ money(0, 'IDR') }}");
            $('.code_cbg_html').html("Belum Groupping");
            swal.fire(
                "Peringatan Groupping Eklaim",
                "Mohon lakukan Groupping Eklaim, sebelum 3 hari setelah pasien masuk rawat inap",
                'warning'
            );
        }
    });
    function lihatRincianBiaya() {
        $('#modalRincianBiaya').modal('show');
    }
</script>
