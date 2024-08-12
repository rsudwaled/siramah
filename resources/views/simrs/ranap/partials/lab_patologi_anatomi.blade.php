<div class="row">
    @php
        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tablePatologi" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
        @foreach ($data as $patologi)
            <tr>
                <td>{{ $patologi['tgl_masuk'] }}</td>
                <td>{{ $patologi['kode_kunjungan'] }}</td>
                <td>{{ $patologi['nama_px'] }}</td>
                <td>{{ $patologi['nama_unit'] }}</td>
                <td>{{ $patologi['pemeriksaan'] }}</td>
                <td>
                    <button class="btn btn-xs btn-primary" onclick="showHasilPa(this)"
                        data-kode="{{ $patologi['detail_id'] }}">Lihat</button>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
</div>
<x-adminlte-modal id="modalLabPA" name="modalLabPA" title="Hasil Patologi Anatomi Pasien" theme="success"
    icon="fas fa-file-medical" size="xl">
    <iframe id="dataHasilLabPa" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <a href="" id="urlHasilLabPa" target="_blank" class="btn btn-primary mr-auto">
            <i class="fas fa-download "></i>Download</a>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
