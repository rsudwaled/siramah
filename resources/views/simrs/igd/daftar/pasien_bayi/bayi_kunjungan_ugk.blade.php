@extends('adminlte::page')

@section('title', 'KUNJUNGAN KEBIDANAN')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>KUNJUNGAN KEBIDANAN</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.cari') }}" class="btn btn-sm bg-purple">Data Bayi</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">FILTER KUNJUNGAN BY PERIODE TANGGAL</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body">
                    <form action="" method="get">
                        <div class="row ">
                            <div class="col-md-12">
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
                            <div class="col-md-12">
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
                            <div class="col-md-12">
                                <x-adminlte-button type="submit" class="withLoad mt-4 float-right" theme="primary"
                                    label="Submit Pencarian" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    @php
                        $heads = ['Tgl Masuk / Kunjungan', 'Orangtua', 'Alamat', 'Alasan', 'Penjamin', 'Status'];
                        $config['order'] = ['0', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '500px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($kunjungan_igd as $item)
                            <tr>
                                <td>
                                    {{ $item->kode_kunjungan }} <br>
                                    <b>Masuk : {{ $item->tgl_masuk }}</b>
                                </td>
                                <td><b>Nama: {{ $item->pasien->nama_px }}</b><br>RM :
                                    {{ $item->pasien->no_rm }}
                                    <br> NIK : {{ $item->pasien->nik_bpjs }} <br>BPJS :
                                    {{ $item->pasien->no_Bpjs == null ? '-' : $item->pasien->no_Bpjs }}
                                </td>
                                <td>
                                    <small>
                                        alamat : {{ $item->pasien->alamat ?? '-' }} / <br>
                                        {{ $item->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : ($item->desa == null ? 'Desa: -' : 'Desa. ' . $item->desas->nama_desa_kelurahan) . ($item->kecamatan == null ? 'Kec. ' : ' , Kec. ' . $item->kecamatans->nama_kecamatan) . ($item->kabupaten == null ? 'Kab. ' : ' - Kab. ' . $item->kabupatens->nama_kabupaten_kota) }}</small>
                                    </small>
                                </td>
                                <td>{{ $item->alasan_masuk->alasan_masuk }}</td>
                                </td>
                                <td>{{ $item->penjamin_simrs->nama_penjamin }}</td>
                                <td>
                                    <button type="button"
                                        class="btn btn-block bg-gradient-success btn-block btn-flat btn-xs show-formbayi"
                                        data-kunjungan="{{ $item->kode_kunjungan }}"
                                        data-rmibu="{{ $item->no_rm }}">DAFTARKAN BAYI</button>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
            <x-adminlte-modal id="formBayi" title="FORM DAFTARKAN DATA BAYI PADA SISTEM" theme="success" size='lg' disable-animations static-backdrop>
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h5>
                            <i class="icon fas fa-users"></i>Informasi Bayi :
                        </h5>
                    </div>
                    <form id="form_pasien_bayi" method="post" action="{{ route('pasien-bayi.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="rm_ibu_bayi" id="rm_ibu_bayi">
                                <input type="hidden" name="kunjungan_ortu" id="kunjungan_ortu">

                                <x-adminlte-input name="rm_ibu" id="rm_ibu" label="RM ORANTUA **" type="text"
                                    disabled fgroup-class="col-md-12" disable-feedback />
                                <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan **" type="text"
                                    disabled fgroup-class="col-md-12" disable-feedback />
                            </div>
                            <div class="col-lg-6">
                                <input type="hidden" name="isbpjs" id="isbpjs">
                                <input type="hidden" name="isbpjs_keterangan" id="isbpjs_keterangan">
                                <x-adminlte-input name="nama_bayi" id="nama_bayi" label="Nama Bayi *" required
                                    placeholder="masukan nama bayi" fgroup-class="col-md-12" disable-feedback />

                                <x-adminlte-input name="tempat_lahir_bayi" id="tempat_lahir_bayi" label="Kota Lahir *"
                                    required placeholder="masukan kota ketika bayi lahir" fgroup-class="col-md-12"
                                    disable-feedback />
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputBorderWidth2">Jam Lahir Bayi <br>
                                            <code>
                                                <b>AM : 00:00 s.d 11.59</b> || <b>PM : 12:00 s.d 00:00</b>
                                            </code>
                                        </label>
                                        <x-adminlte-input name="jam_lahir_bayi" type="time" disable-feedback />
                                    </div>
                                </div>
                                @php $config = ['format' => 'DD-MM-YYYY']; @endphp
                                <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi" fgroup-class="col-md-12"
                                    required label="Tanggal Lahir *" :config="$config"
                                    value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-primary">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-date>
                                <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi" required
                                    fgroup-class="col-md-12">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </x-adminlte-select>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal" class="btn-sm" />
                                <x-adminlte-button form="form_pasien_bayi" class="float-right btn-sm" type="submit"
                                    theme="success" label="Simpan Data" />
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

        });

        function batalPilih() {
            $("#show-databayi tr").remove();
        }
    </script>
@endsection
