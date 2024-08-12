<div class="tab-pane fade" id="tab-laboratorium" role="tabpanel" aria-labelledby="tab-laboratorium-tab">
    @php
        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableLaboratorium" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
    </x-adminlte-datatable>
</div>
