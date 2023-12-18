@extends('adminlte::page')
@section('title', 'Diagnosa ')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Diagnosa Dokter</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">FILTER</li>
                    <li class="breadcrumb-item">UNIT : {{ $requestUnit->nama_unit ?? '-' }}</li>
                </ol>
            </div>
        </div>
    </div>
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
                                    <option value="{{ $item->kode_unit }}"
                                        {{ $request->unit == $item->kode_unit ? 'selected' : '' }}>{{ $item->nama_unit }}
                                    </option>
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
                <div class="col-lg-8">
                    <x-adminlte-card theme="primary" collapsible title="Assesment Diagnosa Dokter">
                        @php
                            $heads = ['Pasien', 'alamat', 'diagnosa', 'daftar', 'pelayanan', 'action'];
                            $config['order'] = false;
                            $config['paging'] = false;
                            $config['info'] = false;
                            $config['scrollY'] = '600px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                        @endphp
                        <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" head-theme="dark"
                            :config="$config" striped bordered hoverable compressed>
                            @foreach ($pasien_fr as $item)
                                <tr>
                                    <td>
                                        <b>RM : {{ $item->no_rm }}<br>
                                            {{ $item->pasien->nama_px }} <br></b>
                                        KUNJUNGAN : {{ $item->kode_kunjungan }} <br>
                                        ({{ $item->unit->nama_unit }})
                                    </td>
                                    <td>
                                        <small>
                                            alamat : {{ $item->pasien->alamat }} / <br>
                                            {{ $item->pasien->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $item->pasien->desas->nama_desa_kelurahan . ' , Kec. ' . $item->pasien->kecamatans->nama_kecamatan . ' - Kab. ' . $item->pasien->kabupatens->nama_kabupaten_kota }}
                                        </small>
                                    </td>
                                    <td>{{ $item->diag_00 }}</td>
                                    <td>
                                        <span
                                            class="btn-xs btn-flat {{ $item->jpDaftar == null ? '' : ($item->jpDaftar->is_bpjs == 1 ? 'btn-success' : 'btn-secondary') }}">{{ $item->jpDaftar == null ? '-' : ($item->jpDaftar->is_bpjs == 1 ? 'BPJS' : 'UMUM') }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="btn-xs btn-flat {{ $item->is_ranap == 0 ? 'bg-maroon' : ($item->is_ranap == 1 ? 'bg-purple' : 'btn-danger') }}"><small>{{ $item->is_ranap == 0 ? 'BUKAN RANAP' : ($item->is_ranap == 1 ? 'RANAP' : 'BATAL RANAP') }}</small></span>
                                    </td>
                                    <td>
                                        <x-adminlte-button type="button" data-rm="{{ $item->no_rm }}"
                                            data-nama="{{ $item->pasien->nama_px }}"
                                            data-jk="{{ $item->pasien->jenis_kelamin }}"
                                            data-kunjungan="{{ $item->kode_kunjungan }}" data-diagx="{{ $item->diag_00 }}"
                                            theme="primary" class="btn-flat btn-xs btn-singkron" id="btn-singkron"
                                            label="Synch Diagnosa" />
                                    </td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
                <div class="col-lg-4">
                    <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-success">
                            <h3 id="nama_pasien">Nama Pasien</h3>
                            <h5 id="jk">gender pasien</h5>
                        </div>
                        <div class="card-footer mt-3">
                            <div class="col-lg-12">
                                <form id="formSynch" method="post">
                                    @csrf
                                    <div class="col-lg-12">
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
                                        <x-adminlte-input name="refDiagnosa" id="refDiagnosa" label="Diagnosa Dokter"
                                            label-class="primary">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="fas fa-user-md"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-select2 name="diagAwal" id="diagnosa" label="Pilih Diagnosa">
                                        </x-adminlte-select2>
                                    </div>
                                    <x-adminlte-button type="button"
                                        class="btn btn-sm m-1 bg-success float-right btn-synchronize-sep" form="formSynch"
                                        label="update diagnosa" />
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

            $('.btn-synchronize-sep').click(function(e) {
                var urlBridging = "{{ route('synch.diagnosa') }}";
                var urlUpdateOnly = "{{ route('synch-diagnosa.only') }}";
                // $.LoadingOverlay("show");
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success m-2",
                        cancelButton: "btn btn-danger m-2"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Update Diagnosa dan Briding SEP!",
                    icon: "warning",
                    padding: "3em",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Bridging!",
                    cancelButtonText: "Only, Update!",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: urlBridging,
                            dataType: 'json',
                            data: {
                                noMR: $('#noMR').val(),
                                kunjungan: $('#kunjungan').val(),
                                refDiagnosa: $('#refDiagnosa').val(),
                                diagAwal: $('#diagnosa').val(),
                            },
                            success: function(data) {
                                console.info(data.code);
                                if (data.code == 400) {
                                    Swal.fire('Data yang dikirimkan tidak lengkap', '',
                                        'info');
                                    $.LoadingOverlay("hide");
                                }
                                if (data.code == 401) {
                                    Swal.fire(data.message, '',
                                        'info');
                                    $.LoadingOverlay("hide");
                                }
                                console.info(data.data);
                                if (data.data.metaData.code == 200) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Bridging Success!",
                                        text: data.data.metaData.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    swalWithBootstrapButtons.fire({
                                        title: "Bridging Gagal!",
                                        text: data.data.metaData.message +
                                            '( ERROR : ' + data.data.metaData
                                            .code + ')',
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                        });

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel

                    ) {
                        $.ajax({
                            type: 'POST',
                            url: urlUpdateOnly,
                            dataType: 'json',
                            data: {
                                noMR: $('#noMR').val(),
                                kunjungan: $('#kunjungan').val(),
                                refDiagnosa: $('#refDiagnosa').val(),
                                diagAwal: $('#diagnosa').val(),
                            },
                            success: function(data) {
                                if (data.code == 200) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Update Diagnosa Success!",
                                        text: data.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    swalWithBootstrapButtons.fire({
                                        title: "Update Gagal!",
                                        text: data.message + '( ERROR : ' + data
                                            .code + ')',
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                        });
                    }
                });

            });
        });
    </script>
@endsection
