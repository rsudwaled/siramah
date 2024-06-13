@extends('adminlte::page')

@section('title', 'DAFTAR PPRI')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> PENDAFTARAN PPRI :
                </h5>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('daftar-igd.v1') }}" class="btn btn-sm btn-secondary"
                            style="text-decoration: none;">KEMBALI</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('edit-pasien', ['rm' => $poli->no_rm]) }}" target="__blank" class="btn btn-sm btn-warning"
                            style="text-decoration: none;">EDIT PASIEN</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h5> KUNJUNGAN DARI {{ $poli->pasien->nama_px }}.
                            <small class="float-right">
                                <b>
                                    Tgl Masuk : {{ date('d M Y', strtotime($poli->tgl_masuk)) }}
                                </b>
                            </small>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Refferensi Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                       
                                        <b> Counter : {{ $poli->counter }}<br>
                                            Kode : {{ $poli->kode_kunjungan }}<br>
                                            MASUK : {{ date('d-m-Y H:i:s', strtotime($poli->tgl_masuk)) }}<br>
                                        </b><br>
                                        <b> RM : {{ $poli->no_rm }}<br>
                                            Pasien : {{ $poli->pasien->nama_px }} <br>
                                            TGL LAHIR:  {{ date('d-m-Y', strtotime($poli->pasien->tgl_lahir)) }}<br>
                                        </b><br>
                                        <b>
                                            NIK : {{ $poli->pasien->nik_bpjs }}<br>
                                            BPJS : {{ $poli->pasien->no_Bpjs }}<br>
                                        </b><br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert bg-success alert-dismissible">
                                    <h5>
                                        <i class="fas fa-tasks"></i> Form Daftar PPRI:
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="" id="formPendaftaranIGD" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <x-adminlte-input name="rm" id="rm_terpilih" value="{{ $poli->no_rm }}"
                                                label="RM PASIEN" type="text" readonly disable-feedback />
                                            <x-adminlte-input name="nama_ortu" id="nama_ortu"
                                                value="{{ $poli->pasien->nama_px }}" label="NAMA ORANGTUA" type="text"
                                                readonly disable-feedback />
                                            <div class="form-group">
                                                <label for="exampleInputBorderWidth2">NIK
                                                    <code id="note_nik">(mohon nik WAJIB DIISI)</code></label>
                                                <input type="number" name="nik_bpjs" id="nik_bpjs"
                                                    value="{{ $poli->pasien->nik_bpjs }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputBorderWidth2">NO KARTU
                                                    <code id="note_nik">(mohon NO KARTU WAJIB DIISI untuk pasien
                                                        BPJS)</code></label>
                                                <input type="number" name="no_bpjs" id="no_bpjs"
                                                    value="{{ $poli->pasien->no_Bpjs ?? null }}" class="form-control">
                                            </div>
                                            <x-adminlte-input name="noTelp" id="noTelp" type="number"
                                                    label="No Telpon" value="{{$poli->pasien->no_hp===null?$poli->pasien->no_tlp:$poli->pasien->no_hp}}" />
                                        </div>
                                        <div class="col-lg-6">
                                            @php
                                                $config = ['format' => 'YYYY-MM-DD'];
                                            @endphp
                                            <x-adminlte-input-date name="tanggal"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                                :config="$config" />
                                            <div class="form-group">
                                                <select class="select2 form-control" id="" name="penjamin_id">
                                                    @foreach ($penjamin as $item)
                                                        <option value="{{ $item->kode_penjamin }}">
                                                            {{ $item->nama_penjamin }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                <option value="">--Pilih Dokter--</option>
                                                @foreach ($paramedis as $item)
                                                    <option value="{{ $item->kode_paramedis }}">
                                                        {{ $item->nama_paramedis }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                            <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Masuk">
                                                @foreach ($alasanmasuk as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->alasan_masuk }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                            <div class="form-group">
                                                <label for="exampleInputBorderWidth2">Perujuk
                                                    <code>(nama faskes yang merujuk)</code></label>
                                                <select name="isPerujuk" id="isPerujuk" class="form-control">
                                                    <option value="0">Tanpa Perujuk</option>
                                                    <option value="1">Tambah Perujuk</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="perujuk">
                                                <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                                                <input type="text" name="nama_perujuk" class="form-control"
                                                    id="nama_perujuk">
                                            </div>
                                            <x-adminlte-button type="submit"
                                                onclick="javascript: form.action='{{ route('kunjungan-post.ppri') }}';"
                                                class="withLoad btn  btn-sm bg-green float-right" form="formPendaftaranIGD"
                                                label="Simpan Data" />
                                            <a href="{{ route('daftar-igd.v1') }}"
                                                class="float-right btn btn-sm btn-secondary">Kembali</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        const perujuk = document.getElementById('isPerujuk');
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
        $('#perujuk').hide();
        $(perujuk).on('change', function() {
            if (perujuk.value > 0 || perujuk.value == null) {
                $('#perujuk').show();
            } else {
                $('#perujuk').hide();
            }
        });
    </script>
@endsection
