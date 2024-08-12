<div class="tab-pane fade" id="tab-radiologi" role="tabpanel" aria-labelledby="tab-radiologi-tab">
    @php
        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableRadiologi" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
    </x-adminlte-datatable>
</div>
