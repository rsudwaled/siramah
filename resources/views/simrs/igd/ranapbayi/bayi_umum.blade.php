@extends('adminlte::page')

@section('title', 'FORM RANAP BAYI')
@section('content_header')
    <h1>FORM RANAP BAYI: {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <div class="col-lg-12 mb-2">
                                <a href="#" class="btn bg-danger mb-2" id="infoRuangan"><i class="fas fa-exclamation-triangle"></i> SAAT INI RUANGAN BELUM DIPILIH</a>
                                <a href="#" class="btn bg-teal mb-2" id="showBed" style="display: none">
                                    <i class="fas fa-bed"></i>
                                </a>
                                <a href="#" class="btn btn-primary mb-2" id="showRuangan" style="display: none">
                                    <i class="fas fa-bed"></i> Tidak ada 
                                </a>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-select name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kode_unit }}">
                                            {{ $item->nama_unit }}</option>
                                    @endforeach
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-select name="kelas_rawat" id="r_kelas_id" label="Kelas Rawat">
                                    <option value="1">KELAS 1</option>
                                    <option value="2">KELAS 2</option>
                                    <option value="3">KELAS 3</option>
                                    <option value="4">VIP</option>
                                    <option value="5">VVIP</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <x-adminlte-button label="Cari Ruangan" data-toggle="modal" data-target="#pilihRuangan"
                                id="cariRuangan" class="bg-purple" />
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" id="div_ranap" icon="fas fa-info-circle" collapsible
                                title="Form Pendaftaran">
                                <form action="{{ route('ranap-bayi.store') }}" method="post" id="submitRanap">
                                    @csrf
                                    <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                    <input type="hidden" name="idRuangan" id="ruanganSend">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="nama_pasien"
                                                                value="{{ $pasien->nama_px }}" disabled label="Nama Pasien"
                                                                enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">
                                                                        {{ $pasien->no_rm }}</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="ruangan_bayi" id="ruanganBayiTerpilih" readonly label="Ruangan Bayi">
                                                            </x-adminlte-input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tanggal_daftar"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal Masuk" :config="$config" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="penjamin_id" label="Pilih Penjamin">
                                                                <option value="">--Pilih Penjamin--</option>
                                                                @foreach ($penjamin as $item)
                                                                    <option value="{{ $item->kode_penjamin }}">
                                                                        {{ $item->nama_penjamin }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="alasan_masuk_id"
                                                                label="Alasan Pendaftaran">
                                                                <option value="">--Pilih Alasan--</option>
                                                                @foreach ($alasanmasuk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->alasan_masuk }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="dpjp" label="Pilih DPJP">
                                                                <option value="">--Pilih Dpjp--</option>
                                                                @foreach ($paramedis as $item)
                                                                    <option value="{{ $item->kode_paramedis }}">
                                                                        {{ $item->nama_paramedis }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right" form="submitRanap"
                                            label="Simpan Data" />
                                        <a href="{{ route('pasien-bayi.cari') }}"
                                            class="btn btn-secondary m-1 btn-sm float-right">Kembali</a>
                                    </div>
                                </form>
                            </x-adminlte-card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="pilihRuangan" title="List Ruangan Tersedia" theme="success" icon="fas fa-bed" size='xl'
        disable-animations>
        <div class="row listruangan" id="idRuangan"></div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop


@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $('#cariRuangan').on('click', function() {
            // $("#pilihRuangan").show();
            var unit = $('#unitTerpilih').val();
            var kelas = $('#r_kelas_id').val();
            $('#hakKelas').val(kelas);
            $('#hakKelas').text('Kelas ' + kelas);
            if (kelas) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-bedruangan-bayi') }}?unit=" + unit + '&kelas=' + kelas,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $.each(res.bed, function(key, value) {
                                $("#idRuangan").append(
                                    '<div class="position-relative p-3 m-2 bg-green ruanganCheck" onclick="chooseRuangan(' +
                                    value.id_ruangan + ', `' + value.nama_kamar + '`, ' +
                                    value.no_bed +
                                    ')" style="height: 100px; width: 150px; margin=5px; border-radius: 2%;"><div class="ribbon-wrapper ribbon-sm"><div class="ribbon bg-warning text-sm">KOSONG</div></div><h6 class="text-left">"' +
                                    value.nama_kamar + '"</h6> <br> NO BED : "' + value
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
                    $("#ruanganSend").val(id);
                    $('#pilihRuangan').modal('toggle');
                    $("#showRuangan").text('RUANGAN : ' + nama);
                    $("#showBed").text('NO : ' + bed);
                    $("#showRuangan").css("display", "block");
                    $("#showBed").css("display", "block");
                    $(".ruanganCheck").remove();

                    $("#ruanganBayiTerpilih").val(nama+' - '+ bed);

                    $("#infoRuangan").css("display", "none");
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }
    </script>
@endsection
