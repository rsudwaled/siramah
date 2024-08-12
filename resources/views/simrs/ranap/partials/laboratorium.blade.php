<div class="row">
    @php
        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableLaboratorium" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item['tgl_masuk'] }}</td>
                <td>{{ $item['kode_kunjungan'] }}</td>
                <td>{{ $item['nama_px'] }}</td>
                <td>{{ $item['nama_unit'] }}</td>
                <td>
                    @foreach ($item['pemeriksaan'] as $pemeriksaan)
                        <li>{{ $pemeriksaan }}</li>
                    @endforeach
                </td>
                <td><button class="btn btn-xs btn-primary" onclick="showHasilLab(this)"
                        data-kode="{{ $item['laboratorium'] }}">Lihat</button> </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
</div>
<x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
    icon="fas fa-file-medical" size="xl">
    <iframe id="dataHasilLab" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
@endpush
