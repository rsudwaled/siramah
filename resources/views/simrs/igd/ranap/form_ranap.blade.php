@extends('adminlte::page')

@section('title', 'Ranap Umum')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Form Rawat Inap</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><b>DAFTAR</b></li>
                    <li class="breadcrumb-item"><b>RAWAT INAP</b></li>
                    <li class="breadcrumb-item"><b>PASIEN {{ $pasien->nama_px }}</b></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="row bg-primary">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <a href="{{ route('edit-pasien', ['rm' => $pasien->no_rm]) }}"
                                                    target="__blank" class="form-group text-white">
                                                    <h5 class="description-headers">{{ $pasien->nama_px }}</h5>
                                                    <small>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</small>
                                                    <br>
                                                    <span class="description-text">-Pasien-</span> <br>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-headers">
                                                    {{ date('d F Y', strtotime($pasien->tgl_lahir)) }}</h5>
                                                <span class="description-text">-Tanggal Lahir-</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-headers">{{ $pasien->no_rm }}</h5>
                                                <span class="description-text">-No RM-</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-headers">
                                                    NIK : {{ $pasien->nik_bpjs == null ? 'tidak ada' : $pasien->nik_bpjs }}
                                                    <br>
                                                    BPJS :
                                                    {{ trim($pasien->no_Bpjs) == null ? 'tidak ada' : trim($pasien->no_Bpjs) }}
                                                </h5>
                                                <span class="description-text">-NIK & BPJS-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @php
                                        $heads = ['Tgl Masuk / Unit', 'Kunjungan', 'Diagnosa', 'Penjamin', 'Status', 'Pasien Daftar'];
                                        $config['order'] = ['0', 'asc'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['scrollY'] = '300px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
                                        striped bordered hoverable compressed>
                                        @foreach ($kunjungan as $item)
                                            <tr>
                                                <td>
                                                    <b>
                                                        Tgl Masuk : {{ $item->tgl_masuk }} <br>
                                                        Unit : {{ $item->unit->nama_unit }}
                                                    </b>
                                                </td>
                                                <td>
                                                    <b>
                                                        Kode : {{ $item->kode_kunjungan }} <br>
                                                        Counter : {{ $item->counter }} <br>
                                                    </b>
                                                </td>
                                                <td>{{ $item->diagx ?? 'BELUM MELAKUKAN SINGKRONISASI DIAGNOSA' }}
                                                </td>
                                                <td>{{ $item->penjamin_simrs->nama_penjamin }}</td>
                                                <td>{{ $item->status->status_kunjungan }}</td>
                                                <td>
                                                    <b>
                                                        {{ $item->jp_daftar == 0 ? 'PASIEN UMUM' : 'PASIEN BPJS' }}
                                                    </b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <div class="col-lg-12 mb-2">

                                @if (!empty($rujukan))
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-left">ADMIN BOOKING RUANGAN</span>
                                            <span
                                                class="direct-chat-timestamp float-right">{{ $rujukan->tgl_rujukan }}</span>
                                        </div>

                                        <img class="direct-chat-img"
                                            src="{{ asset('vendor/adminlte/dist/img/call-center.png') }}"
                                            alt="Message User Image">

                                        <div class="direct-chat-text">
                                            Informasi booking <b>RI240226/UGD/SRJ/240001</b> <br>RUANGAN TERSEDIA DI :
                                            <br><b>KELAS 3 SEROJA NO BED 2!</b>
                                            {{-- <br><b>NOTE : PASIEN NAIK KELAS</b>  --}}
                                            <br><b>DPJP : {{$rujukan->dokter}}</b><br> 
                                            <small class="text-danger"><i><b>silahkan pilih ruangan sesuai
                                                dengan informasi yang sudah diberikan dengan benar.</b></i></small> <br>
                                            
                                        </div>
                                    </div>
                                @else
                                <a href="#" class="btn bg-danger mb-2" id="infoRuangan"><i
                                    class="fas fa-exclamation-triangle"></i> SAAT INI RUANGAN BELUM DIPILIH <br> OLEH ADMIN RUANGAN</a>
                                @endif


                                
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
                        <div class="col-md-12">
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="0" name="pasienTitipan" id="pasienTitipan">
                                <label for="pasienTitipan"></label>
                            </div>
                            <span class="text text-red"><b id="textDescChange">ceklis apabila pasien titipan</b></span>
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
                                title="DAFTARKAN : {{ $pasien->nama_px }} ( {{ $pasien->no_rm }} )">
                                <form action="{{ route('pasien-ranap-umum.store') }}" method="post" id="submitRanap">
                                    @csrf
                                    <input type="hidden" name="kodeKunjungan" value="{{ $kode }}">
                                    <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                    <input type="hidden" name="idRuangan" id="ruanganSend">
                                    <input type="hidden" name="pasienNitip" id="pasienNitip">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="nama_pasien" value="{{ $pasien->nama_px }}"
                                                    disabled label="Nama Pasien" enable-old-support>
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text text-olive">
                                                            {{ $pasien->no_rm }}</div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-input name="nik_pasien" value="{{ $pasien->nik_bpjs }}"
                                                    disabled label="NIK Pasien" enable-old-support>
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text text-olive">
                                                            NIK PASIEN</div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tanggal_daftar"
                                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    label="Tanggal Masuk" :config="$config" />
                                                <x-adminlte-input name="noTelp"
                                                    value="{{ $pasien->no_tlp == null ? $pasien->no_hp : $pasien->no_tlp }}"
                                                    label="No Telp" placeholder="masukan no telp"
                                                    label-class="text-black">
                                                    <x-slot name="prependSlot">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-phone text-black"></i>
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->alasan_masuk }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <x-adminlte-input name="ruangan" label="Ruangan"
                                                            id="ruanganTerpilih" readonly disabled />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <x-adminlte-input name="bed" label="No Bed" id="bedTerpilih"
                                                            readonly disabled />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <x-adminlte-input name="hak_kelas" label="Hak Kelas"
                                                            id="hakKelas" disabled />
                                                    </div>
                                                </div>

                                                <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                                    @foreach ($penjamin as $item)
                                                        <option value="{{ $item->kode_penjamin }}">
                                                            {{ $item->nama_penjamin }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>

                                                <x-adminlte-select2 name="kode_paramedis" label="Pilih Dokter DPJP">
                                                    <option value="">--Pilih Dokter DPJP--</option>
                                                    @foreach ($paramedis as $item)
                                                        <option value="{{ $item->kode_paramedis }}">
                                                            {{ $item->nama_paramedis }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <x-adminlte-select2 name="diagAwal" id="diagnosa"
                                                    label="Pilih Diagnosa">
                                                </x-adminlte-select2>
                                            </div>

                                        </div>
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right" form="submitRanap"
                                            label="Simpan Data" />
                                        <a href="{{ route('daftar.kunjungan') }}"
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

            $('#cariRuangan').on('click', function() {
                // $("#pilihRuangan").show();
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

            $('#pasienTitipan').click(function(e) {
                if (this.checked) {
                    $("#showTitipan").show();
                    $("#pasienNitip").val(1);
                } else {
                    $("#pasienNitip").val(0);
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
                    $("#ruanganSend").val(id);
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
