@extends('adminlte::page')
@section('title', 'EDIT RUANGAN')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> EDIT RUANGAN :
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
                    <div class="col-lg-7">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h5>{{$kunjungan->pasien->nama_px}}</h5>
                                <p>Silahkan Edit ruangan pada form sebelah kanan data kunjungan pasien</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-procedures"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <table id="table1" class="semuaKunjungan table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>KUNJUNGAN</th>
                                    <th>PASIEN</th>
                                    <th>RUANGAN</th>
                                    <th>STATUS</th>
                                    <th>TANGGAL</th>
                                    <th>PENJAMIN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>{{ $kunjungan->kode_kunjungan }}</td>
                                    <td>
                                        RM : {{ $kunjungan->no_rm }} <br>
                                        {{ $kunjungan->pasien->nama_px }}
                                    </td>
                                    <td>{{ $kunjungan->unit->nama_unit }} <br>
                                        {{ $kunjungan->ruanganRawat ? $kunjungan->ruanganRawat->nama_kamar . ' | Bed: ' . $kunjungan->ruanganRawat->no_bed : 'Data ruangan tidak tersedia' }}
                                    </td>
                                    <td>{{ $kunjungan->status->status_kunjungan }}</td>
                                    <td>{{ $kunjungan->tgl_masuk }}</td>
                                    <td>{{ $kunjungan->penjamin_simrs->nama_penjamin }}</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="9">

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-5">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <form id="formEditRuangan" method="post">
                                    @csrf
                                    <input type="hidden" name="kode" value="{{ $kunjungan->kode_kunjungan }}">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <x-adminlte-select name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                                <option value="" selected>PILIH RUANGAN</option>
                                                @foreach ($unit as $item)
                                                    <option value="{{ $item->kode_unit }}">
                                                        {{ $item->nama_unit }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-select name="kelas_rawat" id="r_kelas_id"
                                                        label="Kelas Rawat">
                                                        <option value="1">KELAS 1</option>
                                                        <option value="2">KELAS 2</option>
                                                        <option value="3">KELAS 3</option>
                                                        <option value="4">VIP</option>
                                                        <option value="5">VVIP</option>
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-button label="Cari Ruangan" data-toggle="modal"
                                                        data-target="#pilihRuangan" id="cariRuangan"
                                                        class="bg-purple mt-4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" id="id_ruangan" name="id_ruangan">
                                        <div class="col-md-4">
                                            <x-adminlte-input name="ruangan" label="Ruangan" id="ruanganTerpilih"
                                                readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <x-adminlte-input name="bed" label="No Bed" id="bedTerpilih" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <x-adminlte-input name="hak_kelas" label="Hak Kelas" id="hakKelas" readonly />
                                        </div>
                                    </div>
                                    <x-adminlte-button type="submit"
                                        onclick="javascript: form.action='{{ route('simrs.pendaftaran-ranap-igd.update-ruangan') }}';"
                                        class="withLoad btn  btn-sm bg-green  float-right" form="formEditRuangan"
                                        label="Simpan Data" />
                                    <a href="{{route('pasien.ranap')}}" class="btn btn-sm btn-secondary  float-right">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="pilihRuangan" title="List Ruangan Tersedia" theme="success" icon="fas fa-bed" size='xl'
        disable-animations>
        <div class="row listruangan" id="idRuangan"></div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#cariRuangan').on('click', function() {
                var unit = $('#unitTerpilih').val();
                var kelas = $('#r_kelas_id').val();
                $('#hakKelas').val(kelas);
                $('#hakKelas').text('Kelas ' + kelas);
                if (kelas) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('bed-ruangan.get') }}?unit=" + unit + '&kelas=' + kelas,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res) {
                                $.each(res.bed, function(key, value) {
                                    $("#idRuangan").append(
                                        '<div class="position-relative p-3 m-2 bg-green ruanganCheck" onclick="chooseRuangan(' +
                                        value.id_ruangan + ', `' + value
                                    .nama_kamar + '`, `' +
                                    value.no_bed +
                                    '`)" style="height: 100px; width: 150px; margin=5px; border-radius: 2%;"><div class="ribbon-wrapper ribbon-sm"><div class="ribbon bg-warning text-sm">KOSONG</div></div><h6 class="text-left">"' +
                                        value.nama_kamar +
                                        '"</h6> <br> NO BED : "' + value
                                        .no_bed + '"<br></div></div></div>');
                                });
                            } else {
                                $("#bed_byruangan").empty();
                            }
                        }
                    });
                } else {
                    $("#bed_byruangan").empty();
                }
            });
        });

        function chooseRuangan(id, nama, bed) {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN PILIH RUANGAN ' + nama + ' No ' + bed + ' ?',
                showDenyButton: true,
                confirmButtonText: 'Pilih',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    //
                    $("#id_ruangan").val(id);
                    $("#ruanganTerpilih").val(nama);
                    $("#bedTerpilih").val(bed);
                    $('#pilihRuangan').modal('toggle');
                    $(".ruanganCheck").remove();

                    $("#infoRuangan").css("display", "none");
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }
    </script>
@endsection
