<div class="row">
    @php
        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableRadiologi" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
        @foreach ($data as $radiologi)
            <tr>
                <td>{{$radiologi['tgl_masuk']}}</td>
                <td>{{$radiologi['kode_kunjungan']}}</td>
                <td>{{$radiologi['nama_px']}}</td>
                <td>{{$radiologi['nama_unit']}}</td>
                <td>{{$radiologi['pemeriksaan']}}</td>
                <td>
                    <button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)"  data-norm="{{$radiologi['no_rm']}}">Rontgen</button>
                    <button class="btn btn-xs btn-success" onclick="lihatExpertiseRad(this)"  data-header="{{$radiologi['header_id']}}" data-detail="{{$radiologi['detail_id']}}">Expertise</button>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
</div>
<x-adminlte-modal id="modalRongsen" name="modalRongsen" title="Hasil Rontgen Pasien" theme="success"
    icon="fas fa-file-medical" size="xl">
    <iframe id="dataUrlRongsen" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
