@extends('adminlte::page')

@section('title', 'Assesment Ranap')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Assesment Dokter : Rawat Inap</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"
                            class="btn btn-sm btn-flat btn-secondary">kembali</a></li>
                    <li class="breadcrumb-item"><a onClick="window.location.reload();"
                            class="btn btn-sm btn-flat btn-warning">refresh</a></li>

                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" size="sm" collapsible title="List Assesment Rawat Inap">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <x-adminlte-select name="unit" label="Pilih Unit">
                                            <option value="">Semua Unit</option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->kode_unit }}"
                                                    {{ $request->unit == $item->kode_unit ? 'selected' : '' }}>
                                                    {{ $item->nama_unit }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-button type="submit" class="withLoad mt-4 btn-md" theme="primary"
                                            label="Submit Pencarian" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            @php
                                $heads = ['TANGGAL MASUK','KUNJUNGAN', 'PASIEN', 'ALAMAT', 'STATUS', 'AKSI'];
                                $config['order'] = ['0', 'desc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '500px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                                :config="$config" striped bordered hoverable compressed>
                                @foreach ($assesmentRanap as $ranap)
                                    <tr>
                                        <td>
                                            <b>
                                                Tgl Masuk : {{ $ranap->tgl_kunjungan }} <br>
                                            </b>
                                        </td>
                                        <td>
                                            <b>
                                                Kode : {{ $ranap->kunjungan }} ({{ $ranap->nama_unit }}) <br>
                                                Status : {{ $ranap->status }}
                                            </b>
                                        </td>
                                        <td>
                                            <a href="{{ route('edit-pasien', ['rm' => $ranap->rm]) }}" target="__blank">
                                                <b>NAMA : {{ $ranap->pasien }}</b> <br>
                                                RM : {{ $ranap->rm }} <br>
                                                BPJS : {{ $ranap->noKartu }} <br>
                                                NIK : {{ $ranap->nik }} <br>
                                                Gender : {{ $ranap->jk == 'P' ? 'Perempuan' : 'Laki-Laki' }}
                                            </a>
                                        </td>
                                        <td width="15%">
                                            <small>{{ $ranap->alamat }}</small>
                                        </td>
                                        <td>
                                            <b>Daftar :
                                                {{ $ranap->status_pasien_daftar == 1 ? 'PASIEN BPJS' : 'UMUM' }}</b><br>
                                            Pasien : {{ $ranap->status_ranap == 1 ? 'Rawat Inap' : 'Pasien Umum' }} <br>
                                        </td>
                                        <td>
                                            {{-- @if ($ranap->status_pasien_daftar == 1)
                                                <button href="#" data-toggle="modal" data-target="modalSPRI"
                                                    data-id="{{ $ranap->kunjungan }}"
                                                    data-nomorkartu="{{ $ranap->noKartu }}"
                                                    class="btn btn-block bg-purple btn-xs btn-flat btnModalSPRI">SPRI</button>
                                                <a href="{{ route('form-umum.pasien-ranap', ['rm' => $ranap->rm, 'kunjungan' => $ranap->kunjungan]) }}"
                                                    class="btn btn-xs btn-block btn-success btn-flat mt-1">UMUM</a>
                                            @else
                                                <a href="{{ route('form-umum.pasien-ranap', ['rm' => $ranap->rm, 'kunjungan' => $ranap->kunjungan]) }}"
                                                    class="btn btn-xs btn-block btn-primary btn-flat mr-5">UMUM</a>
                                                <a href="{{ route('form-umum.pasien-ranap', ['rm' => $ranap->rm, 'kunjungan' => $ranap->kunjungan]) }}"
                                                    class="btn btn-xs btn-block btn-primary btn-flat mr-5">UMUM</a>
                                            @endif --}}
                                            @php
                                                if(empty($ranap->noKartu))
                                                {
                                                    $nomorKartu = null;
                                                }else{
                                                    $nomorKartu = trim($ranap->noKartu);
                                                }
                                            @endphp
                                            <a href="{{ route('form-umum.pasien-ranap', ['rm' => $ranap->rm, 'kunjungan' => $ranap->kunjungan]) }}"
                                                class="btn btn-xs btn-block btn-primary btn-flat mr-5">DAFTARKAN PASIEN UMUM</a>
                                            @if (!empty($nomorKartu))
                                            <a href="{{ route('daftar.ranap-bpjs', ['nomorkartu' => $nomorKartu, 'kode' => $ranap->kunjungan]) }}"
                                                class="btn btn-xs btn-block btn-success btn-flat mr-5 withLoad ">DAFTARKAN PASIEN BPJS</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalSPRI" title="Buat SPRI terlebih dahulu" theme="primary" size='lg' disable-animations>
        <form>
            <input type="hidden" name="user" id="user" value="{{ Auth::user()->name }}">
            <input type="hidden" name="kodeKunjungan" id="kodeKunjungan">
            <input type="hidden" name="jenispelayanan" id="jenispelayanan" value="1">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="noKartu" id="noKartu" label="No Kartu" readonly />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input-date name="tanggal" label="Tanggal Periksa" :config="$config"
                        value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="poliKontrol" label="Poliklinik dpjp" id="poliklinik">
                        <option selected disabled>Cari Poliklinik</option>
                    </x-adminlte-select2>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="dokter" id="dokter" label="Dokter DPJP">
                        <option selected disabled>Cari Dokter DPJP</option>
                    </x-adminlte-select2>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="submit" theme="success" form="formSPRI" class="btnCreateSPRI" label="Buat SPRI" />
                <x-adminlte-button theme="danger" label="batal" class="btnCreateSPRIBatal" data-dismiss="modal" />
                <x-adminlte-button class="btn bg-gradient-maroon btn-md lanjutkanPROSESDAFTAR"
                    label="ADA PROSES YANG BELUM SELESAI, LANJUTKAN PROSES SEKARANG !!" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
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

            $("#poliklinik").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_poliklinik_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params);
                        return {
                            poliklinik: params.term // search term
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
            $("#dokter").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_dpjp_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            jenispelayanan: $("#jenispelayanan").val(),
                            kodespesialis: $("#poliklinik option:selected").val(),
                            tanggal: $("#tanggal").val(),
                            nama: params.term // search term
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
