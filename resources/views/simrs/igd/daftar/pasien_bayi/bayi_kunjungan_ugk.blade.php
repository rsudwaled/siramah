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
                    <li class="breadcrumb-item"><a href="{{ route('pasien-bayi.cari') }}" class="btn btn-sm bg-purple">Daftar
                            Data Bayi</a></li>
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
                    <h3 class="card-title">FILTER KUNJUNGAN BY <br> PERIODE TANGGAL</h3>
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
                        $heads = ['Tgl Masuk / Kunjungan', 'Orangtua', 'Alasan', 'Status', 'Penjamin', 'Status'];
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
                                    {{ $item->kode_kunjungan }} | {{ $item->unit->nama_unit }} <br>
                                    <b>Masuk : {{ $item->tgl_masuk }}</b>
                                </td>
                                <td><b>Nama: {{ $item->pasien->nama_px }}</b><br>RM :
                                    {{ $item->pasien->no_rm }}
                                    <br> NIK : {{ $item->pasien->nik_bpjs }} <br>BPJS :
                                    {{ $item->pasien->no_Bpjs == null ? '-' : $item->pasien->no_Bpjs }} <br><br>
                                    <small>
                                        ALAMAT : {{ $item->pasien->alamat ?? '-' }} / <br>
                                        {{ $item->kode_desa < 1101010001 ? 'ALAMAT LENGKAP BELUM DI ISI!' : ($item->desa == null ? 'Desa: -' : 'Desa. ' . $item->desas->nama_desa_kelurahan) . ($item->kecamatan == null ? 'Kec. ' : ' , Kec. ' . $item->kecamatans->nama_kecamatan) . ($item->kabupaten == null ? 'Kab. ' : ' - Kab. ' . $item->kabupatens->nama_kabupaten_kota) }}</small>
                                    </small>
                                </td>
                                <td>{{ $item->alasan_masuk->alasan_masuk }}</td>
                                <td><b>{{ $item->status->status_kunjungan }}</b></td>
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
            <div class="modal fade" id="formBayi" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">FORM DAFTARKAN DATA BAYI PADA SISTEM</h4>
                        </div>
                        <div class="col-lg-12">
                            <div class="alert alert-warning alert-dismissible">
                                <h5>
                                    <i class="icon fas fa-users"></i>APAKAH PASIEN BAYI KEMBAR ??
                                </h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="check_kembar" value="0"
                                                    checked="">
                                                <h6>BUKAN KEMBAR</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="check_kembar" value="1">
                                                <h6>YA, KEMBAR</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-1" id="show_bukankembar">
                                <form id="form_pasien_bayi" method="post" action="{{ route('pasien-bayi.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" id="bayi_created">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="hidden" name="rm_ibu_bayi" id="rm_ibu_bayi">
                                            <input type="hidden" name="kunjungan_ortu" id="kunjungan_ortu">
                                            <x-adminlte-input name="rm_ibu" id="rm_ibu" label="RM ORANTUA **" type="text"
                                                disabled fgroup-class="col-md-12" disable-feedback />
                                            <x-adminlte-input name="kunjungan" id="kunjungan" label="Kunjungan **" type="text"
                                                disabled fgroup-class="col-md-12" disable-feedback />
                                            <input type="hidden" name="isbpjs" id="isbpjs">
                                            <input type="hidden" name="isbpjs_keterangan" id="isbpjs_keterangan">
                                            <div class="col-lg-12">
                                                <x-adminlte-input name="tempat_lahir_bayi" value="CIREBON" id="tempat_lahir_bayi"
                                                    label="Kota Lahir *" placeholder="masukan kota ketika bayi lahir"
                                                    fgroup-class="col-md-12" disable-feedback />
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
                                                <x-adminlte-input-date name="tgl_lahir_bayi" id="tgl_lahir_bayi"
                                                    fgroup-class="col-md-12" label="Tanggal Lahir *" :config="$config"
                                                    value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}">
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text bg-primary">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input-date>
                                                <x-adminlte-select name="jk_bayi" label="Jenis Kelamin *" id="jk_bayi"
                                                    fgroup-class="col-md-12">
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </x-adminlte-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal"
                                            class="btn-sm btn-batal" />
                                        <x-adminlte-button form="form_pasien_bayi" class="float-right btn-sm" type="submit"
                                            theme="success" label="Simpan Data" />
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12" id="show_kembar">
                                <form id="form_pasien_bayi_kembar" method="POST" action="{{ route('bayi-kembar.store') }}">
                                    @csrf
                                    <button type="button" id="tambahBayiKembar" style="display: none;"
                                        class="btn btn-xs btn-primary mb-1">Tambah
                                        Bayi Kembar</button>
                                    <!-- Di sini akan ditambahkan input untuk setiap bayi yang ditambahkan -->
                                    <div class="row" id="form_bayi_kembar">
                                        <input type="hidden" name="rm_ibu_bayi_kembar" id="rm_ibu_bayi_kembar">
                                        <input type="hidden" name="kunjungan_ortu_kembar" id="kunjungan_ortu_kembar">
                                    </div>
                                    <div class="modal-footer" id="footer_bayi_kembar">
                                        <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal"
                                            class="btn-sm btn-batal" />
                                        <x-adminlte-button form="form_pasien_bayi_kembar" class="float-right btn-sm"
                                            type="submit" theme="success" label="Simpan Data" />
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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const check_kembar = document.getElementById('check_kembar');
            $('#footer_bayi_kembar').hide();
            document.querySelectorAll('input[name="check_kembar"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.value === '0') {
                        document.getElementById('show_bukankembar').style.display = 'block';
                        document.getElementById('show_kembar').style.display = 'none';
                        document.getElementById('tambahBayiKembar').style.display = 'none';
                        $('#footer_bayi_kembar').hide();
                    } else {
                        document.getElementById('show_kembar').style.display = 'block';
                        document.getElementById('tambahBayiKembar').style.display = 'block';
                        document.getElementById('show_bukankembar').style.display = 'none';
                        $('#footer_bayi_kembar').show();
                    }
                });
            });
            $(document).ready(function() {
                var counter = 0; // Counter untuk nama elemen input

                $('#tambahBayiKembar').click(function() {
                    counter++;

                    var bayiHtml = '<div class="col-lg-6" id="bayi_' + counter + '">' +
                        '<div class="form-group"><label>Jenis Kelamin Bayi ' + counter +
                        '</label>' +
                        '<select name="jenis_kelamin[]" class="form-control">' +
                        '<option value="L">Laki-Laki</option>' +
                        '<option value="P">Perempuan</option>' +
                        '</select></div>' +
                        '<div class="form-group"><label>Jam Lahir Bayi ' + counter + '<br><code>' +
                        '<b>AM : 00:00 s.d 11.59</b> || <b>PM : 12:00 s.d 00:00</b></code></label>' +
                        '<input name="jam_lahir[]" type="time" class="form-control"></div>' +
                        '<div class="form-group">' +
                        '<label for="tanggal_lahir_' + counter + '">Tanggal Lahir Bayi ' + counter +
                        '</label>' +
                        '<input type="date" id="tanggal_lahir_' + counter +
                        '" name="tanggal_lahir[]" class="form-control" required>' +
                        '<input type="hidden" value="nama_bayi_' + counter +
                        '" name="nama_bayi[]" class="form-control">' +
                        '</div>' +
                        '<button type="button" class="btn btn-danger btn-sm hapusBayi" data-counter="' +
                        counter + '">Hapus</button>' +
                        '<hr>' +
                        '</div>';

                    $('#form_bayi_kembar').append(bayiHtml);
                });
            });

            // Event untuk menghapus input bayi
            $('#form_bayi_kembar').on('click', '.hapusBayi', function() {
                var counter = $(this).data('counter');
                $('#bayi_' + counter).remove();
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
                $("#rm_ibu_bayi_kembar").val($(this).data('rmibu'));
                $("#kunjungan").val($(this).data('kunjungan'));
                $("#kunjungan_ortu").val($(this).data('kunjungan'));
                $("#kunjungan_ortu_kembar").val($(this).data('kunjungan'));
                $('#formBayi').modal('show');
                var detail = $(this).data('rmibu');
                $.ajax({
                    type: 'get',
                    url: "{{ route('detailbayi.byortu') }}",
                    data: {
                        detail: detail
                    },
                    dataType: 'json',

                    success: function(data) {
                        console.info(data);
                        $.LoadingOverlay("show");
                        $.each(data.data, function(key, value) {
                            var link =
                                "{{ route('form-umum.ranap-bayi', ['rm' => ':rm', 'kunjungan' => ':kunjungan']) }}"
                                .replace(':rm', value.rm_bayi)
                                .replace(':kunjungan', value.kunjungan_ortu);
                            var linkEditPasien =
                                "{{ route('edit-pasien', ['rm' => ':rm']) }}"
                                .replace(':rm', value.rm_bayi);
                            var createdDate = new Date(value.created_at);
                            var formattedCreatedAt = createdDate.toLocaleString(
                                'id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    second: 'numeric'
                                });
                            var newItem =
                                "<div class='col-lg-6' ><div class='card-body p-0' ><ul class='products-list product-list-in-card' ><li class='item bayi_byibu'><div><a href='" +
                                link +
                                "' class='product-title' target='_blank'>RM: " + value
                                .rm_bayi +
                                "<span class='badge " + (value.is_kembar_daftar == 0 ?
                                    'badge-success' : 'badge-danger') +
                                " float-right'>" + (value.is_kembar_daftar == 0 ?
                                    'PASIEN BAYI' : 'SUDAH DIDAFTARKAN') +
                                "</span></a><span class='product-description'>" +
                                value.nama_bayi + "<br>(ditambahkan pada : " +
                                formattedCreatedAt + ")</span></div>" +
                                "<br><button type='button' class='btn btn-xs bg-warning mt-1 mr-2' onclick=\"window.open('" +
                                linkEditPasien +
                                "', '_blank')\">EDIT PASIEN</button><button type='button' class='btn btn-xs bg-primary mt-1' onclick=\"window.location.href='" +
                                link +
                                "'\">LANJUT RANAP</button></li></ul></div></div>";

                            $('#bayi_created').append(newItem);
                        });

                        $.LoadingOverlay("hide");
                    },
                    error: function(res) {
                        console.log('Error:', res);
                    }
                });
            });

            $('.btn-batal').click(function(e) {
                $.LoadingOverlay("show");
                location.reload();
                $(".bayi_byibu").remove();
                $.LoadingOverlay("hide");
            });
        });

        function batalPilih() {
            $("#show-databayi tr").remove();
        }
    </script>
@endsection
