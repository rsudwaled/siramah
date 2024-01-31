@extends('adminlte::page')
@section('title', 'Kunjungan ')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Data Kunjungan</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="unit" id="unit" class="form-control select2">
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->kode_unit }}"
                                                {{ $request->unit == $item->kode_unit ? 'selected' : '' }}>
                                                {{ $item->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">Submit Pencarian</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a onClick="window.location.reload();" class="btn btn-md btn-warning">Refresh</a>
                                </div>
                            </div>
                        </form>
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    @php
                        $heads = ['Pasien', 'Alamat', 'Kunjungan', 'Tgl Masuk', 'Diagnosa', 'No SEP', 'Status Kunjungan', 'Status Daftar', 'Detail'];
                        $config['order'] = false;
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->rm]) }}" target="__blank">
                                        <b>{{ $item->pasien }}</b> <br>RM : {{ $item->rm }} <br>NIK :
                                        {{ $item->nik }} <br>No Kartu : {{ $item->noKartu }}
                                    </a>
                                </td>
                                <td>alamat : {{ $item->alamat }} / <br>
                                </td>
                                <td>
                                    @if ($item->lakaLantas > 0)
                                        <small>
                                            <b>PASIEN KECELAKAAN</b>
                                        </small> <br>
                                    @endif
                                    {{ $item->kunjungan }} <br>
                                    ({{ $item->nama_unit }})
                                    <br>

                                </td>
                                <td>{{ $item->tgl_kunjungan }}</td>
                                <td>{{ $item->diagx }}</td>
                                <td>{{ $item->sep }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <b>
                                        {{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar==0 ? 'UMUM' :'BPJS PROSES') }}
                                    </b>
                                </td>
                                <td>
                                    <a href="{{ route('detail.kunjungan', ['kunjungan' => $item->kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat withLoad">Detail</a>

                                </td>
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
            $('.btn-singkron').on('click', function() {
                let diag = $(this).data('diagx');
                let kunj = $(this).data('kunjungan');
                let rm = $(this).data('rm');
                let nama = $(this).data('nama');
                let jk = $(this).data('jk');
                let jk_dsc = jk == 'P' ? 'perempuan' : 'laki-laki';
                $('#refDiagnosa').val(diag);
                $('#kunjungan').val(kunj);
                $('#noMR').val(rm);
                $('#nama_pasien').text(nama);
                $('#jk').text(jk_dsc);
            });

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
