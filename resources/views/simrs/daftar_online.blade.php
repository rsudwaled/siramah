@extends('vendor.medilab.master')

@section('title', 'Daftar Rawat Jalan - SIRAMAH-RS Waled')

@section('content')
    <br>
    <br>
    <br>
    <section id="services" class="services">
        <div class="container">
            <div class="section-title">
                <h2>Daftar Rawat Jalan</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form action="" id="formDaftarWeb">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik"><b>NIK Pasien</b></label>
                                    <div class="input-group">
                                        <input type="text" name="nik" placeholder="Masukan nik Pasien"
                                            value="{{ $request->nik }}" id="nik" class="form-control mr-2">

                                    </div>
                                </div>
                                <div id="formPasien">
                                    <div class="form-group mt-3">
                                        <label for="nomorkartu"><b>No BPJS Pasien</b></label>
                                        <input type="text" name="nomorkartu" readonly class="form-control"
                                            id="nomorkartu" placeholder="Masukan Nama Anda" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="norm"><b>No RM</b></label>
                                        <input type="text" name="norm" readonly class="form-control" id="norm"
                                            placeholder="Masukan Nama Anda" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="namapasien"><b>Nam Pasien</b></label>
                                        <input type="text" name="namapasien" readonly class="form-control"
                                            id="namapasien" placeholder="Masukan Nama Anda" required>
                                    </div>
                                    <div class="form-group mt-3 mb-3">
                                        <label for="nohp"><b>No HP</b></label>
                                        <input type="text" class="form-control" name="nohp" id="nohp"
                                            placeholder="Masukan nohp Pasien" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group formJenispasien">
                                    <label for="jenispasien"><b>Jenis Pasien</b></label>
                                    <select name="jenispasien" class="form-control" id="jenispasien" required
                                        {{ $jadwals ? 'readonly' : '' }}>
                                        <option selected disabled>Pilih Jenis Pasien</option>
                                        <option value="JKN" {{ $request->jenispasien == 'JKN' ? 'selected' : '' }}>
                                            Pasien
                                            BPJS
                                        </option>
                                        <option value="NON-JKN" {{ $request->jenispasien == 'NON-JKN' ? 'selected' : '' }}>
                                            Pasien
                                            Umum</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3 formPoliklinik">
                                    <label for="namasubspesialis"><b>Poliklinik</b></label>
                                    <select name="kodepoli" class="form-control" id="kodepoli" required>
                                        <option selected disabled>Pilih Poliklinik</option>
                                        @foreach ($polikliniks as $poli)
                                            <option value="{{ $poli->kodesubspesialis }}"
                                                {{ $request->kodepoli == $poli->kodesubspesialis ? 'selected' : '' }}>
                                                {{ $poli->namasubspesialis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-3 formTanggalPeriksa">
                                    <label for="tanggalperiksa"><b>Tanggal Periksa</b></label>
                                    <div class="input-group date">
                                        <input type="text" id="tanggalperiksa" name="tanggalperiksa"
                                            value="{{ now()->format('Y-m-d') }}" class="form-control datetimepicker"
                                            required>

                                    </div>
                                </div>
                                <div class="form-group mt-3 formJenisKunjungan">
                                    <label for="jeniskunjungan"><b>Jenis Kunjungan</b></label>
                                    <div class="input-group">
                                        <select name="jeniskunjungan" class="form-control" id="jeniskunjungan">
                                            <option selected disabled>Pilih Jenis Kunjungan</option>
                                            <option value="1" {{ $request->jeniskunjungan == '1' ? 'selected' : '' }}>
                                                Rujukan
                                                FKTP
                                            </option>
                                            <option value="3" {{ $request->jeniskunjungan == '3' ? 'selected' : '' }}>
                                                Surat
                                                Kontrol
                                            </option>
                                            <option value="4" {{ $request->jeniskunjungan == '4' ? 'selected' : '' }}>
                                                Rujukan
                                                Antar
                                                RS</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group mt-3 formNomorReferensi">
                                    <label for="nomorreferensi"><b>Nomor Referensi</b></label>
                                    <div class="input-group">
                                        <select name="nomorreferensi" class="form-control" id="nomorreferensi">
                                            <option selected disabled>Pilih Rujukan / Surat Kontrol</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-3 formDokter">
                                    <label for="kodedokter"><b>Pilih Jadwal Dokter</b></label>
                                    <select name="kodedokter" class="form-control" id="kodedokter">
                                        <option selected disabled>Pilih Jadwal Dokter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-3 mb-3">
                                <div id="btnDaftar" class="btn btn-success mt-1">Daftar</div>
                                <div id="cekPasien" class="btn btn-warning mt-1"><i class="fas fa-search"></i> Cek Pasien
                                </div>
                                <div id="cekJadwalPoli" class="btn btn-warning mt-1"><i class="fas fa-search"></i> Cek
                                    Jadwal</div>
                                <div id="cekNomorReferensi" class="btn btn-warning mt-1"><i class="fas fa-search"></i>
                                    Cek Rujukan / Srt. Kontrol</div>
                                <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                    Reset Formulir</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(function() {
            $("#tanggalperiksa").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#formPasien").hide();
            $(".formJenispasien").hide();
            $(".formPoliklinik").hide();
            $(".formTanggalPeriksa").hide();
            $(".formJenisKunjungan").hide();
            $(".formDokter").hide();
            $(".formNomorReferensi").hide();
            $("#cekJadwalPoli").hide();
            $("#cekNomorReferensi").hide();
            $("#btnDaftar").hide();
            $("#cekPasien").on("click", function() {
                $("body").append("<div id='preloader'></div>");
                var nik = $('#nik').val();
                var url = "{{ route('api.cekPasien') }}?nik=" + nik;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            var pasien = data.response;
                            $("#formPasien").show();
                            $(".formJenispasien").show();
                            $("#nomorkartu").val(pasien.no_Bpjs);
                            $("#norm").val(pasien.no_rm);
                            $("#namapasien").val(pasien.nama_px);
                            $("#nohp").val(pasien.no_hp);
                            $("#cekPasien").hide();
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data pasien ditemukan atas nama ' + pasien
                                    .nama_px,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire({
                                title: 'Maaf',
                                text: data.metadata.message,
                                icon: 'error',
                                confirmButtonText: 'Tutup'
                            });
                        }
                        $("#preloader").remove();
                    },
                    error: function(data) {
                        alert('Error');
                        $("#preloader").remove();
                    },
                });
            });
            $("#jenispasien").on("change", function() {
                var jenispasien = $(this).val();
                if (jenispasien == 'JKN') {
                    $(".formPoliklinik").hide()
                    $(".formTanggalPeriksa").show()
                    $(".formJenisKunjungan").show();
                    $("#cekJadwalPoli").hide();
                    $("#cekNomorReferensi").show();
                } else {
                    $(".formPoliklinik").show()
                    $(".formTanggalPeriksa").show()
                    $(".formJenisKunjungan").hide();
                    $("#cekJadwalPoli").show();
                    $("#cekNomorReferensi").hide();
                }
            });
            // umum
            $("#cekJadwalPoli").on("click", function() {
                $("body").append("<div id='preloader'></div>");
                var kodepoli = $('#kodepoli').val();
                var tanggal = $('#tanggalperiksa').val();
                var url = "{{ route('api.cekJadwalPoli') }}";
                var data = {
                    kodepoli: kodepoli,
                    tanggal: tanggal,
                };
                $('#kodedokter')
                    .empty()
                    .append('<option selected disabled>Pilih Jadwal Dokter</option>');
                $.ajax({
                    url: url,
                    data: data,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            var jadwal = data.response;
                            $(".formDokter").show();
                            $("#btnDaftar").show();
                            jadwal.forEach(element => {
                                $('#kodedokter').append($('<option>', {
                                    value: element.kodedokter,
                                    text: element.namadokter
                                }));
                            });
                            Swal.fire({
                                title: 'Success',
                                text: 'Jadwal dokter poliklinik ditemukan ada ' + data
                                    .response.length + ' dokter',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire({
                                title: 'Maaf',
                                text: data.metadata.message,
                                icon: 'error',
                                confirmButtonText: 'Tutup'
                            });
                        }
                        $("#preloader").remove();

                    },
                    error: function(data) {
                        console.log(data);
                        alert('Error');
                        $("#preloader").remove();
                    },
                });
            });
            // jkn
            $("#cekNomorReferensi").on("click", function() {
                $("body").append("<div id='preloader'></div>");
                var jeniskunjungan = $('#jeniskunjungan').val();
                var tanggal = $('#tanggalperiksa').val();
                var nomorkartu = $('#nomorkartu').val();
                switch (jeniskunjungan) {
                    case '1':
                        var data = {
                            nomorkartu: nomorkartu,
                            tanggal: tanggal,
                        };
                        var urlData = "{{ route('api.cekRujukanPeserta') }}?" + data;
                        console.log(urlData);
                        $.ajax({
                            url: "{{ route('api.cekRujukanPeserta') }}",
                            data: {
                                nomorkartu: nomorkartu,
                                tanggal: tanggal,
                            },
                            type: "GET",
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data.metadata.code == 200) {
                                    var rujukans = data.response;
                                    rujukans.forEach(element => {
                                        console.log(element);
                                        $('#nomorreferensi').append('<option value="' +
                                            element.noKunjungan +
                                            '" data-kodepoli="' + element
                                            .poliRujukan.kode + '" >' + element
                                            .noKunjungan + ' POLI ' + element
                                            .poliRujukan.nama + '</option>');
                                    });
                                    $(".formNomorReferensi").show();
                                    $("#cekNomorReferensi").hide();
                                } else {
                                    alert(data.metadata.message);
                                }
                                $("#preloader").remove();
                            },
                            error: function(data) {
                                console.log(data);
                                alert('Error');
                                $("#preloader").remove();

                            },
                        });
                        break;

                    case '4':
                        var data = {
                            nomorkartu: nomorkartu,
                            tanggal: tanggal,
                        };
                        var urlData = "{{ route('api.cekRujukanPeserta') }}?" + data;
                        console.log(urlData);

                        $.ajax({
                            url: "{{ route('api.cekRujukanRSPeserta') }}",
                            data: {
                                nomorkartu: nomorkartu,
                                tanggal: tanggal,
                            },
                            type: "GET",
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data.metadata.code == 200) {
                                    var rujukans = data.response;
                                    rujukans.forEach(element => {
                                        console.log(element);
                                        $('#nomorreferensi').append('<option value="' +
                                            element.noKunjungan +
                                            '" data-kodepoli="' + element
                                            .poliRujukan.kode + '" >' + element
                                            .noKunjungan + ' POLI ' + element
                                            .poliRujukan.nama + '</option>');
                                    });
                                    $(".formNomorReferensi").show();
                                    $("#cekNomorReferensi").hide();
                                } else {
                                    alert(data.metadata.message);
                                }
                                $("#preloader").remove();
                            },
                            error: function(data) {
                                console.log(data);
                                alert('Error');
                                $("#preloader").remove();
                            },
                        });
                        break;

                    default:
                        alert('Silahkan pilih jenis kunjungan');
                        $("#preloader").remove();
                        break;
                }
            });
            $("#nomorreferensi").change(function() {
                var kodepoli = $(this).find(':selected').attr('data-kodepoli');
                $(".formPoliklinik").show();
                $("#kodepoli").val(kodepoli).change();
                $("#cekJadwalPoli").show();
            });
            $("#btnDaftar").on("click", function() {
                $("body").append("<div id='preloader'></div>");
                var url = "{{ route('api.ambilAntrianWeb') }}";
                var data = $('#formDaftarWeb').serialize();
                var urlData = "{{ route('api.ambilAntrianWeb') }}" + data;
                $.ajax({
                    url: url,
                    data: data,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            console.log(data);
                            Swal.fire({
                                title: 'Success',
                                text: 'Berhasil booking pendaftaran online',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                window.location.href =
                                    "{{ route('checkAntrian') }}?kodebooking=" + data
                                    .response.kodebooking;
                            })
                        } else if (data.metadata.code == 409) {
                            Swal.fire({
                                title: 'Maaf',
                                text: data.metadata.message,
                                icon: 'error',
                                confirmButtonText: 'Tutup'
                            });
                        } else {
                            Swal.fire({
                                title: 'Maaf',
                                text: data.metadata.message,
                                icon: 'error',
                                confirmButtonText: 'Tutup'
                            });
                        }
                        $("#preloader").remove();
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Error');
                        $("#preloader").remove();
                    },
                });
            });
        });
    </script>
@endsection
