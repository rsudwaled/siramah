@extends('adminlte::page')
@section('title', 'KUNJUNGAN PENUNJANG ')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i> DAFTAR KUNJUNGAN PENUNJANG :
        </h5>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <form action="" method="get">
                                <div class="col-md-8">
                                    <label for="">Tanggal (bulan/tanggal/tahun)</label>
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 text-right">
                            
                        </div>
                    </div>
                    @php
                        $heads = ['Kunjungan','Pasien', 'Alamat', 'Unit','Status Pasien'];
                        $config['order'] = ['3', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($penunjang as $daftar_penunjang)
                            <tr>
                                <td>
                                    <strong>
                                        KODE: {{ $daftar_penunjang->kode_kunjungan }} <br>
                                        TGL: {{ $daftar_penunjang->tgl_masuk }}
                                    </strong>
                                </td>
                                <td>{{ $daftar_penunjang->pasien->nama_px }}</td>
                                <td>{{ $daftar_penunjang->pasien->nama_px }}</td>
                                <td>{{ $daftar_penunjang->unit->nama_unit }}</td>
                                <td>{{ $daftar_penunjang->status->status_kunjungan }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.select2').select2();

            $("#diagnosa").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

        });
    </script>
@endsection
