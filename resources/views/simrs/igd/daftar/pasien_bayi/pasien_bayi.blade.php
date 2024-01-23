@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien Bayi')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Kunjungan Kebidanan</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"
                            class="btn btn-sm btn-flat btn-secondary">kembali</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.cari') }}"
                            class="btn btn-sm btn-flat bg-purple">Daftar
                            Bayi Luar</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" size="sm" collapsible title="Riwayat Kunjungan Kebidanan :">
                <div class="col-lg-12 rounded">
                    <div class="card">
                        <div class="card-body bg-success">
                            <form action="" method="get">
                                <div class="row ">
                                    <div class="col-md-4">
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="start" label="Tanggal Awal" :config="$config"
                                            value="{{ \Carbon\Carbon::parse($request->start)->format('Y-m-d') }}">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-primary">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                    </div>
                                    <div class="col-md-4">
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="finish" label="Tanggal Akhir " :config="$config"
                                            value="{{ \Carbon\Carbon::parse($request->finish)->format('Y-m-d') }}">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text bg-primary">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                    </div>
                                    <div class="col-md-3">
                                        <x-adminlte-button type="submit" class="withLoad mt-4 float-right" theme="primary" label="Submit Pencarian" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            @php
                                $heads = ['Tgl Masuk / Kunjungan', 'Keluar', 'Orangtua', 'Alamat','Alasan', 'Penjamin', 'Status'];
                                $config['order'] = ['0', 'desc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '500px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark" :config="$config" striped
                                bordered hoverable compressed>
                                @foreach ($kunjungan_igd as $item)
                                    <tr>
                                        <td>
                                            <b>
                                                {{ $item->kode_kunjungan }}<br>({{ $item->unit->nama_unit }})<br>(Counter: {{ $item->counter }})
                                            </b> <br><br>
                                            <small class="text-red"> <b>{{ $item->tgl_masuk }}</b></small>
                                        </td>
                                        <td>{{ $item->tgl_keluar == null ? 'belum keluar' : $item->tgl_keluar }}
                                        <td><b>Nama: {{ $item->pasien->nama_px }}</b><br>RM : {{ $item->pasien->no_rm }}
                                            <br> NIK : {{ $item->pasien->nik_bpjs }} <br>BPJS :
                                            {{ $item->pasien->no_Bpjs == null ? '-' : $item->pasien->no_Bpjs }}
                                        </td>
                                        <td>
                                            <small>
                                                alamat : {{ $item->pasien->alamat ?? '-' }} / <br>
                                                {{ $item->pasien->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : $item->pasien->desas->nama_desa_kelurahan . ' , Kec. ' . $item->pasien->kecamatans->nama_kecamatan . ' - Kab. ' . $item->pasien->kabupatens->nama_kabupaten_kota }}
                                            </small>
                                        </td>
                                        <td>{{ $item->alasan_masuk->alasan_masuk }}</td>
                                        </td>
                                        <td>{{ $item->penjamin_simrs->nama_penjamin }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-block bg-gradient-success btn-block btn-flat btn-xs show-formbayi"
                                                data-kunjungan="{{ $item->kode_kunjungan }}"
                                                data-rmibu="{{ $item->no_rm }}">daftarkan bayi</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-modal id="formBayi" title="Data Bayi" theme="success" size='lg' disable-animations>
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h5>
                            <i class="icon fas fa-users"></i>Informasi Bayi :
                        </h5>
                    </div>
                    <form id="form_pasien_bayi" method="post" action="{{ route('pasien-bayi.store') }}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="isbpjs" id="isbpjs">
                            <input type="hidden" name="isbpjs_keterangan" id="isbpjs_keterangan">
                            <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi *" required
                                placeholder="masukan nama bayi" fgroup-class="col-md-12" disable-feedback />

                            <x-adminlte-input name="tempat_lahir_bayi" id="tempat_lahir_bayi" label="Kota Lahir *" required
                                placeholder="masukan kota ketika bayi lahir" fgroup-class="col-md-12" disable-feedback />

                            @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                            <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" fgroup-class="col-md-6"
                                required label="Tanggal Lahir *" :config="$config"
                                value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi" required
                                fgroup-class="col-md-6">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </x-adminlte-select>
                            <input type="hidden" name="rm_ibu_bayi" id="rm_ibu_bayi">
                            <input type="hidden" name="kunjungan_ortu" id="kunjungan_ortu">

                            <x-adminlte-input name="rm_ibu" id="rm_ibu" label="RM ORANTUA **" type="text" disabled
                                fgroup-class="col-md-6" disable-feedback />
                            <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan **" type="text" disabled
                                fgroup-class="col-md-6" disable-feedback />
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal" class="btn-sm" />
                                <x-adminlte-button form="form_pasien_bayi" class="float-right btn-sm" type="submit" theme="success"
                                    label="Simpan Data" />
                            </x-slot>
                        </div>
                    </form>
                </div>
            </x-adminlte-modal>
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


            $('#kec_ortu').change(function() {
                var desa_kec_id = $("#kec_ortu").val();
                if (desa_kec_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('desa-pasien.get') }}?desa_kec_id=" + desa_kec_id,
                        dataType: 'JSON',
                        success: function(desapasien) {
                            console.log(desapasien);
                            if (desapasien) {
                                $('#desa_ortu').empty();
                                $.each(desapasien, function(key, value) {
                                    $('#desa_ortu').append('<option value="' + value
                                        .kode_desa_kelurahan + '">' + value
                                        .nama_desa_kelurahan + '</option>');
                                });
                            } else {
                                $("#desa_ortu").append(' < option > --Pilih Desa-- < /option>');
                            }
                        }
                    });
                } else {
                    $("#desa_ortu").append(' < option > --Pilih Desa-- < /option>');
                }
            });



            $('.reset_form').click(function(e) {
                $.LoadingOverlay("show");
                $("#form_pasien_bayi")[0].reset();
                document.getElementById('card_desc_bpjs').style.display = "none";
                $.LoadingOverlay("hide");
            });


            $('.show-formbayi').click(function(e) {
                $("#rm_ibu").val($(this).data('rmibu'));
                $("#rm_ibu_bayi").val($(this).data('rmibu'));
                $("#kunjungan").val($(this).data('kunjungan'));
                $("#kunjungan_ortu").val($(this).data('kunjungan'));
                $('#formBayi').modal('show');

            });

            $('.detail-bayi').click(function(e) {
                var detail = $(this).data('rmortu');
                $('.modal-title').text('Bayi dari RM : ' + detail);
                $.ajax({
                    type: 'get',
                    url: "{{ route('detailbayi.byortu') }}",
                    data: {
                        detail: detail
                    },
                    dataType: 'json',

                    success: function(data) {
                        $.LoadingOverlay("show");
                        $.each(data.data, function(key, value) {
                            $('#table1').append("<tr>\
                                            <td>" + value.rm_bayi + "</td>\
                                            <td>" + value.nama_bayi + "</td>\
                                            <td>" + value.jk_bayi + "</td>\
                                            <td>" + value.tgl_lahir_bayi + "</td>\
                                        </tr>");
                        })
                        $.LoadingOverlay("hide");
                    },
                    error: function(res) {
                        console.log('Error:', res);
                    }

                });

                $('#databayi').modal('show');

            });

            // $('.save-bayi').click(function(e) {
            //     $('#formBayi').modal('hide');
            //     // $.LoadingOverlay("show");
            //     $.ajax({
            //         type: "post",
            //         url: "{{ route('pasien-bayi.store') }}",
            //         data: {
            //             rm: $("#rm_ibu").val(),
            //             kunjungan: $("#kunjungan").val(),
            //             nama_bayi: $("#nama_bayi").val(),
            //             jk_bayi: $("#jk_bayi").val(),
            //             tgl_lahir_bayi: $("#tgl_lahir_bayi").val(),
            //             tempat_lahir_bayi: $("#tempat_lahir_bayi").val(),
            //             _token: "{{ csrf_token() }}",
            //         },
            //         dataType: 'JSON',
            //         success: function(res) {
            //             console.log(res);
            //             if (res.status == 200) {
            //                 var rm_bayi = res.bayi.rm_bayi;
            //             }
            //         }
            //     });
            //     $.LoadingOverlay("hide");
            // });
        });

        function batalPilih() {
            $("#show-databayi tr").remove();
        }
    </script>
@endsection
