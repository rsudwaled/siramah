@extends('adminlte::page')
@section('title', 'Kunjungan Radiologi')
@section('content_header')
    <h1>Kunjungan Radiologi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card icon="fas fa-filter" title="Filter Kunjungan Laboratorium" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date fgroup-class="col-md-3" igroup-size="sm" name="tanggal" label="Tanggal Antrian"
                            :config="$config" value="{{ $request->tanggal ?? now()->format('Y-m-d') }}" />
                        <x-adminlte-select2 fgroup-class="col-md-3" name="kodeunit" label="Ruangan">
                            <option value="-" {{ $request->kodeunit ? '-' : 'selected' }}>SEMUA RUANGAN (-)
                            </option>
                            @foreach ($units as $key => $item)
                                <option value="{{ $key }}" {{ $key == $request->kodeunit ? 'selected' : null }}>
                                    {{ $item }} ({{ $key }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        @if ($kunjungans)
            <div class="col-md-12">
                <x-adminlte-card theme="secondary" icon="fas fa-info-circle"
                    title="Total Pasien ({{ $kunjungans ? $kunjungans->count() : 0 }} Orang)">
                    @php
                        $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Status', 'Action'];
                        // $config['order'] = [['7', 'asc']];
                        $config['paging'] = false;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->counter }} / {{ $item->kode_kunjungan }}</td>
                                <td>{{ $item->pasien->no_rm }} / {{ $item->pasien->nama_px }}</td>
                                <td>{{ $item->unit->nama_unit }}</td>
                                <td>
                                    @foreach ($item->layanans->where('kode_unit', 3020) as $lab)

                                        @foreach ($lab->layanan_details as $laydet)
                                            - {{ $laydet->tarif_detail->tarif->NAMA_TARIF }} <br>
                                        @endforeach
                                    @endforeach
                                </td>
                                <td></td>
                                <td>
                                    <div class="btn btn-xs btn-primary btnHasilLab"
                                        data-fileurl="http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id={{ $item->pasien->no_rm }}&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV">
                                        Lihat Hasil</div>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
        icon="fas fa-file-medical" size="xl">
        <iframe id="dataHasilLab" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
                <i class="fas fa-download "></i>Download</a>
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)

@section('js')
    {{-- hasil lab --}}
    <script>
        $(function() {
            $('.btnHasilLab').click(function() {
                $('#dataHasilLab').attr('src', $(this).data('fileurl'));
                $('#urlHasilLab').attr('href', $(this).data('fileurl'));
                $('#modalHasilLab').modal('show');
            });
        });
    </script>
@endsection
