@extends('adminlte::page')
@section('title', 'Monitoring Resume Ranap')
@section('content_header')
    <h1>Monitoring Resume Ranap</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card icon="fas fa-filter" title="Filter Resume Ranap" theme="secondary" collapsible>
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
        @if ($resumes)
            <div class="col-md-12">
                <x-adminlte-card theme="secondary" icon="fas fa-info-circle" title="Total Pasien">
                    @php
                        $heads = ['Tgl Masuk', 'Tgl Pulang', 'Kunjungan', 'No RM', 'Pasien', 'Unit', 'Status', 'Action'];
                        // $config['order'] = [['7', 'asc']];
                        $config['paging'] = false;
                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($resumes as $item)
                            <tr>
                                <td>{{ $item->kunjungan->tgl_masuk }}</td>
                                <td>{{ $item->kunjungan->tgl_keluar }}</td>
                                <td>{{ $item->kunjungan->counter }}/{{ $item->kunjungan->kode_kunjungan }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->pasien->nama_px }}</td>
                                <td>{{ $item->kunjungan->unit->nama_unit }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="" class="btn btn-xs btn-success"><i class="fas fa-check"></i> Verif</a>
                                    <a target="_blank" href="{{ route('lihat_resume_ranap') }}?kode={{ $item->kode_kunjungan }}"
                                        class="btn btn-xs btn-primary"><i class="fas fa-eye"></i> Lihat</a>
                                    <a href="" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    {{-- <x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
        icon="fas fa-file-medical" size="xl">
        <iframe id="dataHasilLab" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
                <i class="fas fa-download "></i>Download</a>
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal> --}}
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
