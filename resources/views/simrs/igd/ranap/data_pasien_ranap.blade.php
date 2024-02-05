@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h5>PASIEN RAWAT INAP</h5>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="nama_pasien" class="form-control"
                                        value="{{ $request->nama_pasien != null ? $request->nama_pasien : '' }}"
                                        placeholder="cari nama pasien">
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">Cari</button>
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
                        $heads = ['Tgl Masuk / Kunjungan', 'Pasien', 'Alamat', 'Jenis Pasien', 'Ruangan', 'SPRI / SEP RANAP', 'Detail'];
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
                                    <b>
                                        {{ $item->kode_kunjungan }} <br> ({{ $item->nama_unit }})
                                    </b> <br>
                                    {{ $item->tgl_masuk }}
                                </td>
                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->no_rm]) }}" target="__blank">
                                        <b>{{ $item->nama_px }}</b> <br>RM : {{ $item->no_rm }} <br>NIK :
                                        {{ $item->nik_bpjs }} <br>No Kartu : {{ $item->no_Bpjs }}
                                    </a>
                                </td>
                                <td>alamat : {{ $item->alamat }} / <br></td>
                                <td> {{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}
                                </td>

                                <td>
                                    <b>
                                        Kamar : {{ $item->kamar }} <br>
                                        BED : {{ $item->no_bed }} <br>
                                        Kelas : {{ $item->kelas }} <br>
                                    </b>
                                </td>
                                <td>
                                    @if ($item->jp_daftar == 1)
                                        <b>
                                            SPRI : {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                            <br>
                                            SEP :
                                            {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP RANAP' : $item->no_sep }}
                                        </b>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pasien-ranap.detail', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat">Detail</a>
                                    @if ($item->jp_daftar == 1)
                                        @if ($item->no_spri == null && $item->no_sep == null)
                                            <a href="{{ route('create-sepigd.ranap-bpjs', ['kunjungan' => $item->kode_kunjungan]) }}"
                                                class="btn btn-danger btn-xs btn-block btn-flat">Bridging</a>
                                        @endif
                                    @endif

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
