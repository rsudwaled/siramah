@extends('adminlte::page')

@section('title', 'RANAP BAYI BPJS')
@section('content_header')
    <h1>RANAP BAYI BPJS : {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ strtoupper($pasien->nama_bayi) }}</h3>
                            <p class="text-muted text-center"><b>RM BAYI : {{ $pasien->rm_bayi }}</b></p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Jenis Kelamin :
                                        {{ $pasien->jk_bayi == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b></li>
                                <li class="list-group-item"><b>Nama Ortu : {{ $pasien->nama_ortu }}</b></li>
                                <li class="list-group-item"><b>BPJS Ortu:
                                        {{ $pasien->no_bpjs_ortu == null ? 'tidak punya bpjs' : $pasien->no_bpjs_ortu }}</b>
                                </li>
                            </ul>
                            <div class="col-md-12">
                                <x-adminlte-select2 name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                    <option value="2004">PERINATOLOGI</option>
                                    <option value="2013">NICU</option>
                                </x-adminlte-select2>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-select name="kelas_rawat" id="r_kelas_id" label="Kelas Rawat">
                                    <option value="1" {{ $kodeKelas == 1 ? 'selected' : '' }}>KELAS 1</option>
                                    <option value="2" {{ $kodeKelas == 2 ? 'selected' : '' }}>KELAS 2</option>
                                    <option value="3" {{ $kodeKelas == 3 ? 'selected' : '' }}>KELAS 3</option>
                                    <option value="4" {{ $kodeKelas == 4 ? 'selected' : '' }}>VIP</option>
                                    <option value="5" {{ $kodeKelas == 5 ? 'selected' : '' }}>VVIP</option>
                                </x-adminlte-select>
                            </div>
                            <x-adminlte-button label="Cari Ruangan" data-toggle="modal" data-target="#pilihRuangan"
                                id="cariRuangan" class="bg-purple btn-block" />
                        </div>
                    </div>

                    <div class="card-footer">

                        <a href="#" class="btn bg-teal btn-block" id="showBed" style="display: none">
                            <i class="fas fa-bed"></i>
                        </a>
                        <a href="#" class="btn btn-primary btn-block" id="showRuangan" style="display: none">
                            <i class="fas fa-bed"></i> Tidak ada
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" id="div_ranap" icon="fas fa-info-circle" collapsible
                                title="Form Pendaftaran">
                                <form id="submitRanap">
                                    @csrf
                                    <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                    <input type="hidden" name="idRuangan" id="ruanganSend">
                                    <input type="hidden" name="crad" id="c_rad">
                                    <input type="hidden" name="noKartuBPJS" id="noKartuBPJS"
                                        value="{{ $pasien->no_bpjs_ortu }}">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="col-md-12">
                                                                <x-adminlte-input name="nama_pasien"
                                                                    value="{{ strtoupper($pasien->nama_bayi) }}" disabled
                                                                    label="Nama Bayi" enable-old-support>
                                                                    <x-slot name="prependSlot">
                                                                        <div class="input-group-text text-olive">
                                                                            {{ $pasien->rm_bayi }}</div>
                                                                    </x-slot>
                                                                </x-adminlte-input>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                @php
                                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                                @endphp
                                                                <x-adminlte-input-date name="tanggal_daftar"
                                                                    id="tanggal_daftar"
                                                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                    label="Tanggal Masuk" :config="$config" />
                                                            </div>
                                                            <div class="col-md-12">
                                                                <x-adminlte-select2 name="diagAwal" label="diagAwal"
                                                                    id="diagAwal">
                                                                    <option value="">--Pilih Diagnosa--</option>
                                                                    @foreach ($icd as $item)
                                                                        <option value="{{ $item->diag }}">
                                                                            {{ $item->diag }} || {{ $item->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </x-adminlte-select2>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <x-adminlte-select name="alasan_masuk_id"
                                                                    label="Alasan Pendaftaran">
                                                                    <option value="">--Pilih Alasan--</option>
                                                                    @foreach ($alasanmasuk as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->alasan_masuk }}</option>
                                                                    @endforeach
                                                                </x-adminlte-select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="col-md-12">
                                                                <x-adminlte-input name="nik_ortu"
                                                                    value="{{ $pasien->nik_ortu }}" disabled
                                                                    label="NIK Ortu" enable-old-support>
                                                                    <x-slot name="prependSlot">
                                                                        <div class="input-group-text text-olive">
                                                                            NIK ORTU</div>
                                                                    </x-slot>
                                                                </x-adminlte-input>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <x-adminlte-input name="namaOrtu" label="Nama Orangtua"
                                                                    placeholder="nama orangtua" value="{{ $pasien->nama_ortu }}"
                                                                    label-class="text-black">
                                                                </x-adminlte-input>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <x-adminlte-input name="noTelp" label="No Telp"
                                                                    placeholder="masukan no telp" value="{{ $pasien->no_hp_ortu==null? $pasien->no_telp_ortu : $pasien->no_hp_ortu }}"
                                                                    label-class="text-black">
                                                                </x-adminlte-input>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <x-adminlte-input name="hak_kelas"
                                                                    value="{{ $kodeKelas }}"
                                                                    placeholder="{{ $kelas }}" label="Hak Kelas"
                                                                    disabled />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right ranapCreateData"
                                            form="submitRanap" label="Simpan Data" />
                                        <a href="{{ route('kunjungan.ranap') }}"
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
            $('#cariRuangan').on('click', function() {
                var unit = $('#unitTerpilih').val();
                var kelas = $('#r_kelas_id').val();
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
            $('#editSPRI').click(function(e) {
                var nomorsuratkontrol = $('#noSPRI').val();
                var url = "{{ route('spri.get') }}?noSuratKontrol=" + nomorsuratkontrol;
                $.LoadingOverlay("show");
                $.get(url, function(data) {
                    $('#tglRencanaKontrol').val(data.spri.tglRencanaKontrol);
                    $('#poliKontrol').val(data.spri.poliKontrol).trigger('change');
                    $('#dokter').val(data.spri.kodeDokter).trigger('change');
                    $('#updateSPRI').modal('show');
                    $.LoadingOverlay("hide", true);
                });


            });

            $('#btnUpdateSPRI').click(function(e) {
                var noSPRI = $('#noSPRI').val();
                var tglRencanaKontrol = $('#tglRencanaKontrol').val();
                var poliKontrol = $('#poliKontrol').val();
                var kodeDokter = $('#dokter').val();
                var user = $('#user').val();
                swal.fire({
                    icon: 'question',
                    title: 'ANDA YAKIN UPDATE SPRI ' + noSPRI + ' ?',
                    showDenyButton: true,
                    confirmButtonText: 'YA',
                    denyButtonText: `Tidak`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('spri.update') }}?noSPRI=" + noSPRI;
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: 'PUT',
                            url: url,
                            data: {
                                noSPRI: noSPRI,
                                tglRencanaKontrol: tglRencanaKontrol,
                                poliKontrol: poliKontrol,
                                kodeDokter: kodeDokter,
                                user: user,
                            },
                            success: function(data) {
                                console.log(data)
                                if (data.res.metadata.code == 200) {
                                    Swal.fire('SPRI BERHASIL DIUPDATE', '', 'success');
                                    location.reload();
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire(data.res.metadata.message + '( ERROR : ' +
                                        data.res.metadata.code + ')', '', 'error');
                                    $.LoadingOverlay("hide");
                                }

                            },

                        });
                    }
                })
            });
            $("#hapusSPRI").hide();
            $('#hapusSPRI').click(function(e) {
                var noSPRI = $('#noSuratKontrol').val();
                swal.fire({
                    icon: 'question',
                    title: 'ANDA YAKIN HAPUS NO SPRI ' + noSPRI + ' ?',
                    showDenyButton: true,
                    confirmButtonText: 'Hapus',
                    denyButtonText: `Batal`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('spri_delete') }}";
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                noSuratKontrol: noSPRI,
                                user: 'coba',
                            },
                            success: function(data) {

                                if (data.metadata.code == 200) {
                                    Swal.fire('SPRI BERHASIL DIHAPUS', '', 'success');
                                    location.reload();
                                } else {
                                    Swal.fire(data.metadata.message + '( ERROR : ' +
                                        data.metadata
                                        .code + ')', '', 'error');
                                }
                            },

                        });
                    }
                })
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
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }
    </script>
@endsection
