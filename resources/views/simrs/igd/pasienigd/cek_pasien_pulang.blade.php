@extends('adminlte::page')
@section('title', 'DATA PASIEN PULANG')
@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <h5>DATA PASIEN PULANG</h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <form action="" method="get">
                            <div class="row col-lg-12">
                                <div class="col-md-5">
                                    <label for="tanggal">Ruangan</label>
                                    <div class="input-group">
                                       <select name="unit" id="unit" class="form-control">
                                        @foreach ($unit as $r)
                                        <option value="{{ $r->kode_unit }}" {{$request->unit==$r->kode_unit?'selected':''}}>{{ $r->nama_unit }}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-7 row">
                                    <label for="tanggal">Tanggal Pulang</label>
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control "
                                            value="{{ $request->tanggal ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Tanggal Pulang">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit" class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                        </div>
                                        <button type="submit"
                                            onclick="javascript: form.action='{{ route('cek-pasien-pulang.export') }}';"
                                            target="_blank" class="btn btn-success btn-sm ml-2 float-right">Export
                                            Excel</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    @php
                        $heads = ['Pasien', 'Ruangan','Tanggal Keluar', 'Kunjungan', 'Diagnosa', 'SEP'];
                        $config['order'] = ['3', 'desc'];
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
                                <b>{{ $item->pasien }}</b> <br>RM : {{ $item->rm }} <br>NIK :
                                {{ $item->nik }} <br>No Kartu : {{ $item->noKartu }}
                            </td>
                            <td>
                                @if (!empty($item->kamar) || !empty($item->bed))
                                    {{$item->kamar}} | {{$item->bed}}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{$item->tgl_pulang}}</td>
                            <td>
                                @if ($item->lakaLantas > 0)
                                    <small>
                                        <b>PASIEN KECELAKAAN</b>
                                    </small> <br>
                                @endif
                                {{ $item->rm }} | <b>(RM PASIEN)</b> <br>
                                {{ $item->kunjungan }} | <b>({{ $item->nama_unit }})</b>
                                <br>
                                <b>
                                    {{ $item->status }}
                                </b>
                            </td>

                            <td>{{ $item->diagx }}</td>
                            <td>
                                {{ $item->sep }}
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

@endsection
