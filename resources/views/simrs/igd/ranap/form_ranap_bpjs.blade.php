@extends('adminlte::page')

@section('title', 'RANAP BPJS')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Form Daftar</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><b>RAWAT INAP</b></li>
                    <li class="breadcrumb-item"><b>PASIEN BPJS</b></li>
                    <li class="breadcrumb-item"><a href="{{ route('list-assesment.ranap') }}"
                            class="btn btn-sm btn-flat btn-secondary">kembali</a></li>
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
                                                    BPJS : {{ trim($pasien->no_Bpjs) == null ? 'tidak ada' : trim($pasien->no_Bpjs) }}
                                                </h5>
                                                <span class="description-text">-NIK & BPJS-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @php
                                        $heads = ['Tgl Masuk / Unit', 'Kunjungan', 'Diagnosa', 'Penjamin', 'Status'];
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
                                                <td>{{ $item->diagx ?? 'BELUM MELAKUKAN SINGKRONISASI DIAGNOSA' }}</td>
                                                <td>{{ $item->penjamin->nama_penjamin_bpjs }}</td>
                                                <td>{{ $item->status->status_kunjungan }}</td>
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
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success card-outline">
                                <div class="card-body">
                                    <a href="#" class="btn bg-danger mb-2" id="infoRuangan"><i
                                            class="fas fa-exclamation-triangle"></i> SAAT INI RUANGAN BELUM DIPILIH</a>
                                    <div class="col-md-12">
                                        <x-adminlte-select2 name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->kode_unit }}">
                                                    {{ $item->nama_unit }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-md-12">
                                        <x-adminlte-select name="kelas_rawat" id="r_kelas_id" label="Kelas Rawat" disabled>
                                            <option value="1" {{ $kodeKelas == 1 ? 'selected' : '' }}>KELAS 1
                                            </option>
                                            <option value="2" {{ $kodeKelas == 2 ? 'selected' : '' }}>KELAS 2
                                            </option>
                                            <option value="3" {{ $kodeKelas == 3 ? 'selected' : '' }}>KELAS 3
                                            </option>
                                            <option value="4" {{ $kodeKelas == 4 ? 'selected' : '' }}>VIP</option>
                                            <option value="5" {{ $kodeKelas == 5 ? 'selected' : '' }}>VVIP</option>
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="icheck-primary d-inline ml-2">
                                            <input type="checkbox" value="0" name="naikKelasRawat" id="naikKelasRawat">
                                            <label for="naikKelasRawat"></label>
                                        </div>

                                        <span class="text text-red"><b id="textDescChange">ceklis apabila pasien naik
                                                kelas
                                                rawat</b></span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <x-adminlte-button label="Cari Ruangan" data-toggle="modal" data-target="#pilihRuangan"
                                        id="cariRuangan" class="bg-purple btn-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                                title="Daftarkan : {{ $pasien->nama_px }} ( {{ $pasien->no_rm }} )">
                                <form action="{{ route('store.ranap-bpjs') }}" method="post" id="submitRanap">
                                    @csrf
                                    <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                    <input type="hidden" name="idRuangan" id="ruanganSend">
                                    <input type="hidden" name="crad" id="c_rad">
                                    <input type="hidden" name="noKartuBPJS" id="noKartuBPJS"
                                        value="{{ trim($pasien->no_Bpjs) }}">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tanggal_daftar" id="tanggal_daftar"
                                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    label="Tanggal Masuk" :config="$config" />
                                                <x-adminlte-input name="noTelp" label="No Telp"
                                                    placeholder="masukan no telp" label-class="text-black">
                                                </x-adminlte-input>
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
                                                <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                                    <option value="">--Pilih Alasan--</option>
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->alasan_masuk }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <div class="form-group mb-2">
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="0" name="katarak">
                                                        <label for="katarak"></label>
                                                    </div>
                                                    <span class="text text-red"><b>ceklis
                                                            apabila pasien katarak, dan akan dioperasi</b></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                
                                                <x-adminlte-select2 name="kode_paramedis" label="Pilih DPJP">
                                                    <option value="">--Pilih Dokter--</option>
                                                    @foreach ($paramedis as $item)
                                                        <option value="{{ $item->kode_dokter_jkn }}">
                                                            {{ $item->nama_paramedis }}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                                <x-adminlte-select name="penjamin_id" label="Pilih Penjamin">
                                                    <option value="">--Pilih Penjamin--</option>
                                                    @foreach ($penjamin as $item)
                                                        <option value="{{ $item->kode_penjamin }}">
                                                            {{ $item->nama_penjamin }}</option>
                                                    @endforeach
                                                </x-adminlte-select>

                                                <x-adminlte-select2 name="diagAwal" id="diagnosa"
                                                    label="Pilih Diagnosa">
                                                </x-adminlte-select2>

                                                <x-adminlte-select name="lakaLantas" id="status_kecelakaan"
                                                    label="Status Kecelakaan">
                                                    <option value="">--Status Kecelakaan--</option>
                                                    <option value="0">BUKAN KECELAKAAN LALU LINTAS (BKLL)
                                                    </option>
                                                    <option value="1">KLL & BUKAN KECELAKAAN KERJA (BKK)
                                                    </option>
                                                    <option value="2">KLL & KK</option>
                                                    <option value="3">KECELAKAAN KERJA</option>
                                                </x-adminlte-select>

                                            </div>
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12" id="div_stts_kecelakaan"
                                                            style="display: none;">
                                                            <div class="card card-danger card-outline">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <x-adminlte-input name="noLP"
                                                                                label="NO LP"
                                                                                placeholder="no laporan polisi"
                                                                                disable-feedback />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <x-adminlte-input name="keterangan"
                                                                                label="Keterangan"
                                                                                placeholder="keterangan kecelakaan"
                                                                                disable-feedback />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            @php
                                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                                            @endphp
                                                                            <x-adminlte-input-date name="tglKejadian"
                                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                label="Tanggal Kejadian"
                                                                                :config="$config" />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <x-adminlte-select2 name="provinsi"
                                                                                label="Provinsi">
                                                                                <option selected disabled>Cari Provinsi
                                                                                </option>
                                                                            </x-adminlte-select2>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <x-adminlte-select2 name="kabupaten"
                                                                                label="Kota / Kabupaten">
                                                                                <option selected disabled>Cari Kota /
                                                                                    Kabupaten</option>
                                                                            </x-adminlte-select2>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <x-adminlte-select2 name="kecamatan"
                                                                                label="Kecamatan">
                                                                                <option selected disabled>Cari Kecamatan
                                                                                </option>
                                                                            </x-adminlte-select2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="naikKelasDesc1">
                                                            <x-adminlte-select name="pembiayaan"
                                                                label="pembiayaan (pasien naik kelas)" id="pembiayaan">
                                                                <option value="1">PRIBADI</option>
                                                                <option value="2">PEMBERI KERJA</option>
                                                                <option value="3">ASURANSI KESEHATAN TAMBAHAN</option>
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-6" id="naikKelasDesc2">
                                                            <x-adminlte-input name="penanggungJawab"
                                                                label="Penanggung Jawab (pasien naik kelas)"
                                                                placeholder="jika pembiayaan oleh pemberi kerja atau tambahan layanan kesehatan"
                                                                label-class="text-black">
                                                            </x-adminlte-input>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-button type="button"
                                            class="withLoad btn btn-sm m-1 bg-green float-right btn-flat btn-simpan"
                                            form="submitRanap" label="Simpan Data" />
                                        <a href="{{route('list-assesment.ranap')}}"
                                            class="btn btn-secondary btn-flat m-1 btn-sm float-right">Kembali</a>
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

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        const select = document.getElementById('status_kecelakaan');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        $(select).on('change', function() {
            if (select.value > 0 || select.value == null) {
                document.getElementById('div_stts_kecelakaan').style.display = "block";
            } else {
                document.getElementById('div_stts_kecelakaan').style.display = "none";
            }

        });
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
                                    .nama_kamar + '`, `' + value.no_bed +
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
            $("#naikKelasDesc1").hide();
            $("#naikKelasDesc2").hide();
            $('#naikKelasRawat').click(function(e) {
                if (this.checked) {
                    $("#r_kelas_id").removeAttr("disabled");
                    $("#textDescChange").text("pasien memilih naik kelas rawat");
                    $("#c_rad").val(1);
                    $("#naikKelasDesc1").show();
                    $("#naikKelasDesc2").show();
                } else {
                    $("#r_kelas_id").attr("disabled", true);
                    $("#textDescChange").text("ceklis apabila pasien naik kelas rawat / edit kelas");
                    $("#c_rad").val(0);
                    $("#naikKelasDesc1").hide();
                    $("#naikKelasDesc2").hide();
                }
            });

            $("#provinsi").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_provinsi_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
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
            $("#kabupaten").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kabupaten_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodeprovinsi: $("#provinsi option:selected").val(),
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
            $("#kecamatan").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kecamatan_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodekabupaten: $("#kabupaten option:selected").val(),
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

            $('.btn-simpan').click(function(e) {
                var urlUpdateOnly = "{{ route('create-sepigd.ranap-bpjs') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin Simpan?",
                    text: "simpan data pendaftaran rawat inap!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Simpan!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
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
                                    Swal.fire({
                                        title: "Success!",
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
                                    Swal.fire({
                                        title: "Gagal!",
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
