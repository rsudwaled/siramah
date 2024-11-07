@extends('adminlte::page')
@section('title', 'Bridging Bpjs')

@section('content_header')
    <div class="alert bg-success alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> BRIDGING BPJS RAWAT INAP
                </h5>
            </div>
            <div class="col-sm-8">
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="rm" label="NO RM" value="{{ $request->rm }}"
                                            placeholder="Masukan Nomor RM ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="nama" label="NAMA PASIEN" value="{{ $request->nama }}"
                                            placeholder="Masukan Nama Pasien ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="cari_desa" label="CARI BERDASARKAN DESA"
                                            value="{{ $request->cari_desa }}"
                                            placeholder="Masukan nama desa dengan lengkap...">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="cari_kecamatan" label="CARI BERDASARKAN KECAMATAN"
                                            value="{{ $request->cari_kecamatan }}"
                                            placeholder="Masukan nama kecamatan dengan lengkap...">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="nomorkartu" label="NOMOR KARTU"
                                            value="{{ $request->nomorkartu }}" placeholder="Masukan Nomor Kartu BPJS ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-success">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="nik" label="NIK (NOMOR INDUK KEPENDUDUKAN)"
                                            value="{{ $request->nik }}" placeholder="Masukan nomor NIK ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-success">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 row">
            <div class="col-8">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <form action="" method="get">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input id="new-event" type="date" name="start" class="form-control"
                                                value="{{ $request->start != null ? \Carbon\Carbon::parse($request->start)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                placeholder="Event Title">
                                            <input id="new-event" type="date" name="finish" class="form-control"
                                                value="{{ $request->finish != null ? \Carbon\Carbon::parse($request->finish)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                placeholder="Event Title">
                                            <div class="input-group-append">
                                                <button id="add-new-event" type="submit"
                                                    class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-lg-6 text-right">
                                <a href="{{route('pasien.ranap')}}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-sync"></i> Bersihkan Pencarian</a>
                            </div> --}}
                        </div>
                        <div class="col-12 row">
                            @php
                                $heads = [
                                    'KUNJUNGAN',
                                    'PASIEN',
                                    'RUANGAN',
                                    'DIAGNOSA',
                                    'SPRI / SEP RANAP',
                                    'TAHAPAN BRIDGING',
                                ];
                                $config['order'] = ['0', 'desc'];
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
                                                {{ $item->pasien->no_rm }} | (RM PASIEN) <br>
                                                {{ $item->kode_kunjungan }} | ({{ $item->unit->nama_unit }}) <br>
                                                @if (!empty($item->tgl_keluar))
                                                    <b>PASIEN SUDAH KELUAR</b>
                                                @else
                                                    <strong
                                                        class="{{ $item->status_kunjungan == 1 ? 'text-success' : 'text-danger' }}">{{ strtoupper($item->status->status_kunjungan) }}</strong>
                                                @endif
                                            </b>
                                        </td>
                                        <td>
                                            <a href="{{ route('edit-pasien', ['rm' => $item->pasien->no_rm]) }}"
                                                target="__blank">
                                                <b>{{ $item->pasien->nama_px }}</b> <br>RM :
                                                {{ $item->pasien->no_rm }}
                                                <br>NIK :
                                                {{ $item->pasien->nik_bpjs }} <br>No Kartu :
                                                {{ $item->pasien->no_Bpjs }}
                                            </a>
                                        </td>
                                        <td>
                                            <b>
                                                {{ $item->tgl_masuk }}
                                            </b><br>
                                            <b>
                                                Kamar : {{ $item->kamar }} <br>
                                                BED : {{ $item->no_bed }} <br>
                                                Kelas : {{ $item->kelas }} <br>
                                            </b>
                                            @if ($item->is_ranap_daftar == 3)
                                                <small class="text-red"><b><i>( PASIEN TITIPAN )</i></b></small>
                                            @endif
                                            @if (!is_null($item->bpjsCheckHistories))
                                                @if (!is_null($item->bpjsCheckHistories->klsRawatNaik))
                                                    @php
                                                        if ($item->bpjsCheckHistories->klsRawatNaik == 3) {
                                                            $naikKelas = 1;
                                                        }
                                                        if ($item->bpjsCheckHistories->klsRawatNaik == 4) {
                                                            $naikKelas = 2;
                                                        }
                                                        if ($item->bpjsCheckHistories->klsRawatNaik == 5) {
                                                            $naikKelas = 3;
                                                        }
                                                        if ($item->bpjsCheckHistories->klsRawatNaik == 2) {
                                                            $naikKelas = 4;
                                                        }
                                                        if ($item->bpjsCheckHistories->klsRawatNaik == 1) {
                                                            $naikKelas = 5;
                                                        }
                                                    @endphp
                                                    <small class="text-red"><b><i>(NAIK KELAS :
                                                                Dari-{{ $item->bpjsCheckHistories->klsRawatHak }}
                                                                Ke-{{ $naikKelas }} )</i></b></small>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="width: 15%;">
                                            {{ $item->diagx ?? '-' }}
                                        </td>
                                        <td style="width: 20%;">
                                            @if ($item->jp_daftar == 1)
                                                <b>
                                                    SPRI :
                                                    {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                                    <br>
                                                    SEP :
                                                    {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP' : $item->no_sep }}
                                                    <br>
                                                </b>
                                            @endif
                                        </td>
                                        <td>
                                            @if (empty($item->diagx))
                                                <button type="button"
                                                    class="btn btn-info btn-xs btn-block btnUpdateDiagnosa"
                                                    data-kunjungan="{{ $item->kode_kunjungan }}">
                                                    <i class="fas fa-file-contract"></i>
                                                    Update Diagnosa
                                                </button>
                                            @endif
                                            @if ($item->jp_daftar == 1)
                                                @if (empty($item->no_spri) && !empty($item->diagx))
                                                    <button type="button"
                                                        class="btn btn-primary btn-xs btn-block btnModalSPRI"
                                                        data-id="{{ $item->kode_kunjungan }}"
                                                        data-nomorkartu="{{ $item->pasien->no_Bpjs }}"
                                                        data-toggle="modal" data-target="modalSPRI">
                                                        <i class="fas fa-file-contract"></i>SPRI
                                                    </button>
                                                @endif
                                            @endif
                                            @if (empty($item->no_sep) && !empty($item->diagx))
                                                <button type="button" class="btn bg-purple btn-xs btn-block btnCreateSEPIGD"
                                                    data-spri="{{ $item->no_spri }}"
                                                    data-kunjungan="{{ $item->kode_kunjungan }}"
                                                    data-nomorkartu="{{ $item->pasien->no_Bpjs }}">
                                                    <i class="fas fa-file-contract"></i>SEP
                                                </button>
                                            @endif
                                            @if (!empty($item->diagx) && !empty($item->no_sep) && !empty($item->no_spri))
                                                <span class="badge badge-success">Selesai Bridging</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('simrs.igd.bridging_bpjs.modal_spri.create_spri')
                                    @include('simrs.igd.bridging_bpjs.modal_update_diagnosa.update_diagnosa')
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">VERIFIKASI BERHASIL</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="products-list product-list-in-card overflow-auto" style="max-height: 600px;">
                            <ul class="list-unstyled">
                                @foreach ($kunjungan->whereNotNull('no_spri') as $item)
                                    <li class="item m-1">
                                        <div class="col-12 row">
                                            <div class="col-6 row">
                                                <a href="{{ route('edit-pasien', ['rm' => $item->pasien->no_rm]) }}"
                                                    class="col-12">
                                                    <b>{{ $item->pasien->nama_px }}</b>
                                                </a>
                                                <span class="col-12">
                                                    RM: {{ $item->pasien->no_rm }} <br>
                                                    NIK: {{ $item->pasien->nik_bpjs }} <br>
                                                    No Kartu: {{ $item->pasien->no_Bpjs }}
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div class="col-12">
                                                    <span class="float-right">
                                                        SPRI:
                                                        {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                                        @if ($item->no_spri)
                                                            <x-adminlte-button type="button"
                                                                data-spri="{{ $item->no_spri }}" theme="danger"
                                                                class="btn-xs btn-deleteSPRI" id="btn-deleteSPRI"
                                                                label="Hapus" />
                                                        @endif
                                                    </span> <br><br>
                                                    <span class="float-right">
                                                        SEP:
                                                        {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP' : $item->no_sep }}
                                                        @if ($item->no_sep)
                                                            <x-adminlte-button type="button"
                                                                data-sep="{{ $item->no_sep }}" theme="danger"
                                                                class="btn-xs btn-deleteSEPRawatInap" id="btn-deleteSEPRawatInap"
                                                                label="Hapus" />
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </li>
                                @endforeach
                            </ul>
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
                    url: "{{ route('dokter-bypoli.get') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params)
                        return {
                            kodePoli: $("#poliklinik option:selected").val() // search term
                        };
                    },
                    processResults: function(response) {
                        console.info(response)
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            $('.btnUpdateDiagnosa').click(function(e) {
                var kunjungan = $(this).data('kunjungan');
                $('#kode_update').val(kunjungan);
                $('#modalUpdateDiagnosa').modal('toggle');
            });

            $('.btnModalSPRI').click(function(e) {
                var kunjungan = $(this).data('id');
                var noKartu = $(this).data('nomorkartu');
                $('#noKartu').val(noKartu);
                $('#kodeKunjungan').val(kunjungan);
                $('.lanjutkanPROSESDAFTAR').hide();
                $('#modalSPRI').modal('toggle');
            });

            $('.btnCreateSPRI').click(function(e) {
                var kodeKunjungan = $("#kodeKunjungan").val();
                var noKartu = $("#noKartu").val();
                var kodeDokter = $("#dokter").val();
                var poliKontrol = $("#poliklinik option:selected").val();
                var tglRencanaKontrol = $("#tanggal").val();
                var user = $("#user").val();
                var url = "{{ route('bridging-igd.create-spri') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        noKartu: noKartu,
                        kodeDokter: kodeDokter,
                        poliKontrol: poliKontrol,
                        tglRencanaKontrol: tglRencanaKontrol,
                        kodeKunjungan: kodeKunjungan,
                        user: user,
                    },
                    success: function(data) {

                        if (data.metadata.code == 200) {
                            Swal.fire('SPRI BERHASIL DIBUAT', '', 'success');
                            $("#createSPRI").modal('toggle');
                            window.location.reload();
                            $.LoadingOverlay("hide");
                        } else {
                            Swal.fire(data.metadata.message + '( ERROR : ' + data.metadata
                                .code + ')', '', 'error');
                            $.LoadingOverlay("hide");
                        }
                    },

                });
            });

            $('.btnDetailRanap').click(function(e) {
                $('#detailRanap').modal('toggle');
            });
            $('.btnCreateSEPIGD').click(function(e) {
                var kunjungan = $(this).data('kunjungan');
                var noKartu = $(this).data('nomorkartu');
                var urlSEP = "{{ route('bridging-igd.create-sep-ranap') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Generate SEP IGD!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Generate!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: urlSEP,
                            dataType: 'json',
                            data: {
                                kunjungan: kunjungan,
                                nomorkartu: noKartu,
                            },
                            success: function(data) {
                                if (data.data.metaData.code == 200) {
                                    Swal.fire({
                                        title: "Generate Success!",
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
                                    Swal.fire({
                                        title: "Generate Gagal!",
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
                    }
                });
            });

            $('.btn-deleteSEPRawatInap').click(function(e) {
                var sep = $(this).data('sep');
                var deleteSEP = "{{ route('bridging-igd.delete-sep-ranap') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin Hapus SEP?",
                    text: "untuk menghapus data SEP!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteSEP,
                            data: {
                                noSep: sep,
                            },
                            success: function(data) {
                                if (data.metadata.code == 200) {
                                    Swal.fire({
                                        title: "HAPUS SEP BERHASIL!",
                                        text: data.metadata.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire({
                                        title: "HAPUS SEP GAGAL!",
                                        text: data.metadata.message +
                                            '( ERROR : ' + data
                                            .metadata.code + ')',
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
            $('.btn-deleteSPRI').click(function(e) {
                var spri = $(this).data('spri');
                var deleteSPRI = "{{ route('bridging-igd.delete-spri') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin Hapus SPRI?",
                    text: "untuk menghapus data SPRI!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteSPRI,
                            data: {
                                noSuratKontrol: spri,
                            },
                            success: function(data) {
                                if (data.metadata.code == 200) {
                                    Swal.fire({
                                        title: "HAPUS SPRI BERHASIL!",
                                        text: data.metadata.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire({
                                        title: "HAPUS SPRI GAGAL!",
                                        text: data.metadata.message +
                                            '( ERROR : ' + data
                                            .metadata.code + ')',
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
