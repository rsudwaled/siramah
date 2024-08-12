@extends('adminlte::page')
@section('title', 'EDIT PENJAMIN')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> EDIT PENJAMIN :
                </h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="purple" collapsible>
                <div class="row">
                    <div class="col-lg-8">
                        <table id="table1" class="semuaKunjungan table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>COUNT</th>
                                    <th>KUNJUNGAN</th>
                                    <th>NO RM</th>
                                    <th>PASIEN</th>
                                    <th>POLI</th>
                                    <th>STATUS</th>
                                    <th>TANGGAL</th>
                                    <th>PENJAMIN</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>{{ $query->counter }}</td>
                                    <td>{{ $query->kode_kunjungan }}</td>
                                    <td>{{ $query->no_rm }}</td>
                                    <td>{{ $query->pasien->nama_px }}</td>
                                    <td>{{ $query->unit->nama_unit }}</td>
                                    <td>{{ $query->status->status_kunjungan }}</td>
                                    <td>{{ $query->tgl_masuk }}</td>
                                    <td>{{ $query->penjamin_simrs->nama_penjamin }}</td>
                                    <td>{{ $query->counter }}</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="9">
                                        @foreach ($kunjunganSama as $item)
                                        <div class="col-lg-12" style="display: none;">
                                            <div class="small-box {{$item->id_ruangan != null ? 'bg-success':'bg-warning'}}">
                                                <div class="inner">
                                                    <h6>C: {{ $item->counter }} | K: {{ $item->kode_kunjungan }} | U: {{$item->unit->nama_unit}} | R: {{$item->id_ruangan != null ? $item->ruanganRawat->nama_kamar:'-'}}</h6>
                                                    <p>RM: {{ $item->no_rm }} <br>{{ $item->pasien->nama_px }}</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    More info <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <form action="" id="formEditPenjamin" method="post">
                            @csrf
                            <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                @foreach ($penjamin as $item)
                                    <option value="{{ $item->kode_penjamin }}">
                                        {{ $item->nama_penjamin }}</option>
                                @endforeach
                            </x-adminlte-select2>
                            <x-adminlte-button type="submit"
                                onclick="javascript: form.action='{{ route('v1.store-tanpa-noantrian') }}';"
                                class="withLoad btn  btn-sm bg-green float-right" form="formEditPenjamin"
                                label="Simpan Data" />
                        </form>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')

@endsection
