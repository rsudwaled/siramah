@extends('adminlte::page')

@section('title', 'DETAIL PENDAFTARAN PASIEN RANAP')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>DETAIL PENDAFTARAN PASIEN RANAP</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien.ranap') }}"
                            class="btn btn-sm btn-secondary">Kembali</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('edit.kunjungan', ['kunjungan' => $kunjungan->kode_kunjungan]) }}"
                            class="btn btn-sm btn-warning withLoad">Edit Pendaftaran</a></li>
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
                        <h5> BRIDGING PASIEN : {{ $kunjungan->pasien->nama_px }}.
                            <small class="float-right">Tgl Masuk :
                                {{ date('d M Y', strtotime($kunjungan->tgl_masuk)) }}</small>
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <div class="card">
                            <div class="card-body {{ $kunjungan->no_sep == null ? 'bg-danger' : 'bg-success' }}">
                                <div class="row ">
                                    <div class="col-sm-6 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">
                                                {{ $kunjungan->no_spri ?? 'SILAHKAN BUAT SPRI!' }}</h5>
                                            <span
                                                class="description-text">-{{ $kunjungan->no_spri != null ? 'SPRI SELESAI DIBUAT!' : 'BUAT SPRI' }}
                                                - </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-6">
                                        <div class="description-block">
                                            <h5 class="description-header ">{{ $kunjungan->no_sep ?? 'SILAHKAN BUAT SEP!' }}
                                            </h5>
                                            <span class="description-text">-
                                                {{ $kunjungan->no_spri != null ? 'SEP SELESAI DIBUAT!' : 'BUAT SEP' }} -</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <div class="card">
                            <div class="card-body bg-primary">
                                <div class="row ">
                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">RUANGAN : {{ $kunjungan->kamar }}</h5>
                                            <span class="description-text">- RUANGAN - </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">NO : {{ $kunjungan->no_bed }}</h5>
                                            <span class="description-text">- NO BED -</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">KELAS : {{ $kunjungan->kelas }}</h5>
                                            <span class="description-text">- KELAS -</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block">
                                            <h5 class="description-header ">HAK KELAS : {{ $kunjungan->hak_kelas }}</h5>
                                            <span class="description-text">- HAK KELAS -</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Nomor</th>
                                    <th>Diagnosa</th>
                                    <th>Tanggal Lahir</th>
                                    <th>BPJS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Counter : {{ $kunjungan->counter }}<br>
                                        <b>
                                            Kode : {{ $kunjungan->kode_kunjungan }}<br>
                                        </b>
                                    </td>
                                    <td>
                                        <b>RM : {{ $kunjungan->pasien->no_rm }}</b><br>
                                        Pasien : {{ $kunjungan->pasien->nama_px }} <br>

                                    </td>
                                    <td>
                                        <b>
                                            NIK : {{ $kunjungan->pasien->nik_bpjs }}<br>
                                            BPJS : {{ $kunjungan->pasien->no_Bpjs }}<br>
                                        </b>
                                    </td>
                                    <td>
                                        {{ $kunjungan->diagx ?? 'Belum Ada diagnosa' }}
                                    </td>
                                    <td>
                                        {{ date('d F Y', strtotime($kunjungan->pasien->tgl_lahir)) }}
                                    </td>
                                    <td>
                                        <b>
                                            SEP : {{ $kunjungan->no_sep ?? '-' }} <br>
                                            SPRI : {{ $kunjungan->no_spri ?? '-' }}
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{ route('pasien.ranap') }}" class="btn btn-success float-right m-1 withLoad"
                            style="margin-right: 5px;">
                            <i class="fas fa-file-signature"></i> Selesaikan Pendaftaran
                        </a>
                        @if ($kunjungan->status_kunjungan == 1)
                            @if (empty($kunjungan->diagx))
                                <button type="button" class="btn btn-danger float-right m-1 btnUpdateDiagnosa"
                                    data-kunjungan="{{ $kunjungan->kode_kunjungan }}">
                                    <i class="fas fa-file-contract"></i>
                                    Update Diagnosa
                                </button>
                            @else
                                @if (empty($kunjungan->no_sep))
                                    <button type="button" class="btn bg-purple float-right m-1 btnSEPIGD"
                                        data-spri="{{ $kunjungan->no_spri }}"
                                        data-kunjungan="{{ $kunjungan->kode_kunjungan }}"
                                        data-nomorkartu="{{ $kunjungan->pasien->no_Bpjs }}">
                                        <i class="fas fa-file-contract"></i>
                                        Generate SEP
                                    </button>
                                @endif
                                @if (empty($kunjungan->no_spri))
                                    <button type="button" class="btn btn-primary float-right m-1 btnModalSPRI"
                                        data-id="{{ $kunjungan->kode_kunjungan }}"
                                        data-nomorkartu="{{ $kunjungan->pasien->no_Bpjs }}" data-toggle="modal"
                                        data-target="modalSPRI"><i class="fas fa-file-contract"></i>
                                        BUAT SPRI </button>
                                @endif
                            @endif
                        @endif


                    </div>
                    <x-adminlte-modal id="modalSPRI" title="Buat SPRI terlebih dahulu" theme="primary" size='lg'
                        disable-animations>
                        <form>
                            <input type="hidden" name="user" id="user" value="{{ Auth::user()->name }}">
                            {{-- <input type="hidden" name="user" id="user" value="test"> --}}
                            <input type="hidden" name="kodeKunjungan" id="kodeKunjungan">
                            <input type="hidden" name="jenispelayanan" id="jenispelayanan" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-adminlte-input name="noKartu" id="noKartu" label="No Kartu" readonly />
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
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
                                <x-adminlte-button type="submit" theme="success" form="formSPRI" class="btnCreateSPRI"
                                    label="Bridging SPRI" />
                                <x-adminlte-button theme="danger" label="batal" class="btnCreateSPRIBatal"
                                    data-dismiss="modal" />
                                <x-adminlte-button class="btn bg-gradient-maroon btn-md lanjutkanPROSESDAFTAR"
                                    label="ADA PROSES YANG BELUM SELESAI, LANJUTKAN PROSES SEKARANG !!" />
                            </x-slot>
                        </form>
                    </x-adminlte-modal>
                    <x-adminlte-modal id="modalUpdateDiagnosa" title="Update Diagnosa ICD 10" theme="info"
                        size='lg' disable-animations>
                        <form id="formUpdateDiagnosa" method="post"
                            action="{{ route('simrs.pendaftaran-ranap-igd.update-diagnosa-kunjungan') }}">
                            @csrf
                            <input type="hidden" name="kode_update" id="kode_update">
                            <div class="col-lg-12">
                                <x-adminlte-select2 name="diagAwal" id="diagnosa" label="Pilih Diagnosa">
                                </x-adminlte-select2>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button type="submit" theme="success" form="formUpdateDiagnosa"
                                    label="Update Diagnosa" />
                            </x-slot>
                        </form>
                    </x-adminlte-modal>
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
                // if ($('#modalSPRI').show()) {
                //     var url = "{{ route('cekprosesdaftar.spri') }}?noKartu=" + noKartu;
                //     $.ajax({
                //         type: "GET",
                //         url: url,
                //         dataType: 'JSON',
                //         success: function(data) {
                //             console.log(data.cekSPRI);
                //             if (data.cekSPRI == null) {
                //                 Swal.fire('PASIEN BELUM PUNYA SPRI. SILAHKAN BUAT SPRI', '',
                //                     'info');
                //             } else {
                //                 $('.lanjutkanPROSESDAFTAR').show();
                //                 $('.btnCreateSPRI').hide();
                //                 $('.btnCreateSPRIBatal').hide();
                //                 $('.lanjutkanPROSESDAFTAR').click(function(e) {
                //                     location.href =
                //                         "{{ route('ranapbpjs') }}/?no_kartu=" + data
                //                         .cekSPRI.noKartu;
                //                 });
                //             }
                //         }
                //     });
                // }
                $('#modalSPRI').modal('toggle');
            });

            $('.btnCreateSPRI').click(function(e) {
                var kodeKunjungan = $("#kodeKunjungan").val();
                var noKartu = $("#noKartu").val();
                var kodeDokter = $("#dokter").val();
                var poliKontrol = $("#poliklinik option:selected").val();
                var tglRencanaKontrol = $("#tanggal").val();
                var user = $("#user").val();
                var url = "{{ route('pasien-ranap.createspri') }}";
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

            $('.btnSEPIGD').click(function(e) {
                var kunjungan = $(this).data('kunjungan');
                var noKartu = $(this).data('nomorkartu');
                var urlSEP = "{{ route('bridging.sepigd') }}";
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

        });
    </script>
@endsection
