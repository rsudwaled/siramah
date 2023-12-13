@extends('adminlte::page')
@section('title', 'Kunjungan ')
@section('content_header')
    <h1>Kunjungan @if(!empty($request->unit)){{ $request->nama_unit  }} @endif</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal " :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="unit" label="Pilih Unit">
                                <option value="">Semua Unit</option>
                              @foreach ($unit as $item)
                                <option value="{{$item->kode_unit}}" {{ $request->unit == $item->kode_unit ? 'selected' : '' }}>{{$item->nama_unit}}</option>
                              @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-7">
                    <x-adminlte-card theme="primary" collapsible title="Assesment Diagnosa Dokter">
                        @php
                            $heads = ['Pasien', 'Alamat', 'kunjungan', 'Unit', 'Diagnosa', 'status', 'action'];
                            $config['order'] = false;
                            $config['paging'] = true;
                            $config['info'] = false;
                            $config['scrollY'] = '500px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                        @endphp
                        <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" :config="$config"
                            striped bordered hoverable compressed>

                            @foreach ($pasien_fr as $item)
                                {{-- <tr>
                                    <td><b>{{ $item->no_rm }}</b></td>
                                    <td>alamat : {{ $item->pasien->alamat }} / <br>
                                        {{ $item->pasien->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $item->pasien->desas->nama_desa_kelurahan . ' , Kec. ' . $item->pasien->kecamatans->nama_kecamatan . ' - Kab. ' . $item->pasien->kabupatens->nama_kabupaten_kota }}
                                    </td>
                                    <td>{{ $item->kode_kunjungan }}</td>
                                    <td>{{ $item->kode_unit }} ({{ $item->unit->nama_unit }})</td>
                                    <td>{{ $item->diag_00 }}</td>
                                    <td><button type="button"
                                            class="btn btn-danger btn-flat btn-xs">{{ $item->status_bridging == 0 ? 'Belum Bridging' : ($item->status_bridging == 1 ? 'bridging success' : 'gagal') }}</button>
                                    </td>
                                    <td>
                                        <x-adminlte-button type="button" data-rm="{{ $item->no_rm }}"
                                            data-nama="{{ $item->pasien->nama_px }}"
                                            data-jk="{{ $item->pasien->jenis_kelamin }}"
                                            data-kunjungan="{{ $item->kode_kunjungan }}"
                                            data-diagx="{{ $item->diag_00 }}" theme="primary"
                                            class="btn-flat btn-xs btn-singkron" id="btn-singkron"
                                            label="Synch Diagnosa" />
                                    </td>
                                </tr> --}}
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
                <div class="col-lg-5">
                    <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-success">
                            <h3 id="nama_pasien">Nama Pasien</h3>
                            <h5 id="jk">gender pasien</h5>
                        </div>
                        <div class="card-footer mt-3">
                            <div class="col-lg-12">
                                <form action="{{ route('diagnosa-pasien.update') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-input name="noMR" id="noMR" label="RM"
                                                label-class="primary">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-file-alt"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                            <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan"
                                                label-class="primary">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-person-booth"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-input name="refDiagnosa" id="refDiagnosa"
                                                label="Diagnosa Dokter" label-class="primary">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-user-md"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                            <x-adminlte-select2 name="diagAwal" id="diagnosa"
                                                label="Pilih Diagnosa">
                                                <x-slot name="prependSlot">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-stethoscope"></i>
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-select2>
                                        </div>
                                    </div>
                                    <x-adminlte-button type="submit"
                                        class="btn btn-sm m-1 bg-primary float-right" label="update diagnosa" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <x-adminlte-card theme="primary" collapsible title="Kunjungan Bridging">
                @php
                    $heads = ['Pasien', 'Alamat', 'kunjungan','Tgl Masuk','Diagnosa','No SEP', 'status', 'detail'];
                    $config['order'] = false;
                    $config['paging'] = true;
                    $config['info'] = false;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped
                    bordered hoverable compressed>
                    @foreach ($kunjungan as $item)
                        <tr>
                            <td><b>{{ $item->pasien }}</b> <br>RM : {{ $item->rm }} <br>NIK :
                                {{ $item->nik }} <br>No Kartu : {{ $item->noKartu }}</td>
                            <td>alamat : {{ $item->alamat }} / <br>
                            </td>
                            <td>{{ $item->kunjungan }} <br> ({{ $item->nama_unit }})</td>
                            <td>{{ $item->tgl_kunjungan }}</td>
                            <td>{{ $item->diagx }}</td>
                            <td>{{ $item->sep }}</td>
                            <td>{{ $item->status}}</td>
                            <td>
                                <x-adminlte-button type="button" data-rm="{{ $item->rm }}"
                                    data-nama="{{ $item->pasien}}"
                                    data-jk="{{ $item->jk }}"
                                    data-kunjungan="{{ $item->kunjungan }}"
                                    data-diagx="{{ $item->diagx }}" theme="success" class="btn-flat btn-sm"
                                    label="detail" />

                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
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
