@extends('vendor.medilab.master')

@section('title', 'Daftar Rawat Jalan - SIRAMAH-RS Waled')

@section('content')
    <br>
    <br>
    <br>
    @if ($rujukans)
        <section id="faq" class="faq section-bg">
            <div class="container">
                <div class="section-title">
                    <h2>Rujukan FKTP</h2>
                    <p>Silahkan pilih surat rujukan yang masih aktif untuk didaftarkan</p>
                </div>
                <div class="faq-list">
                    <ul>
                        @php
                            $i = 1;
                            $j = 0;
                        @endphp
                        @foreach ($rujukans as $rujukan)
                            <li data-aos="fade-up" data-aos-delay="{{ $j }}">
                                <i class="bx bx-file icon-help"></i>
                                <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-{{ $i }}">
                                    {{ $rujukan->noKunjungan }}
                                    {{ Carbon\Carbon::parse($rujukan->tglKunjungan)->diffInDays(now()) > 90 ? '(Expired)' : '' }}
                                    <i class="bx bx-chevron-down icon-show"></i>
                                    <i class="bx bx-chevron-up icon-close"></i>
                                </a>
                                <div id="faq-list-{{ $i }}"
                                    class="collapse  {{ Carbon\Carbon::parse($rujukan->tglKunjungan)->diffInDays(now()) < 90 ? 'show' : '' }}"
                                    data-bs-parent=".faq-list">
                                    <br>
                                    <dl class="row">
                                        <dt class="col-sm-5">Tgl Rujukan</dt>
                                        <dd class="col-sm-7">
                                            {{ $rujukan->tglKunjungan }}
                                            {{ Carbon\Carbon::parse($rujukan->tglKunjungan)->diffInDays(now()) > 90 ? '(Expired)' : '(Aktif)' }}
                                        </dd>
                                        <dt class="col-sm-5">No Rujukan</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->noKunjungan }}</dd>
                                        <dt class="col-sm-5 ">Pasien</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->peserta->nama }}</dd>
                                        <dt class="col-sm-5">Pelayanan</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->pelayanan->nama }}</dd>
                                        <dt class="col-sm-5">Diagnosa</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->diagnosa->kode }}
                                            {{ $rujukan->diagnosa->nama }}</dd>
                                        <dt class="col-sm-5">Poliklinik</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->poliRujukan->nama }}</dd>
                                        <dt class="col-sm-5">Faskes Perujuk</dt>
                                        <dd class="col-sm-7"> {{ $rujukan->provPerujuk->nama }}</dd>
                                    </dl>

                                    @if (Carbon\Carbon::parse($rujukan->tglKunjungan)->diffInDays(now()) < 90)
                                        <form action="" method="GET">
                                            <input type="hidden" name="jenispasien" value="{{ $request->jenispasien }}">
                                            <input type="hidden" name="tanggalperiksa"
                                                value="{{ $request->tanggalperiksa }}">
                                            <input type="hidden" name="jeniskunjungan"
                                                value="{{ $request->jeniskunjungan }}">
                                            <input type="hidden" name="nomorkartu" value="{{ $request->nomorkartu }}">
                                            <input type="hidden" name="nik" value="{{ $request->nik }}">
                                            <input type="hidden" name="nomorreferensi"
                                                value="{{ $rujukan->noKunjungan }}">
                                            <input type="hidden" name="kodepoli"
                                                value="{{ $rujukan->poliRujukan->kode }}">
                                            <button class="btn btn-xs btn-success">Pilih Rujukan</button>
                                        </form>
                                    @endif

                                </div>
                            </li>
                            @php
                                $i++;
                                $j = $j + 100;
                            @endphp
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>
    @else
        <section id="services" class="services">
            <div class="container">
                <div class="section-title">
                    <h2>Daftar Rawat Jalan</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6 ">
                        @if ($errors->any())
                            <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </x-adminlte-alert>
                        @endif
                        <form action="" id="daftarTamu" method="get">
                            <div class="form-group">
                                <label for="jenispasien"><b>Jenis Pasien</b></label>
                                <select name="jenispasien" class="form-control" id="jenispasien">
                                    <option selected disabled>Pilih Jenis Pasien</option>
                                    <option value="JKN" {{ $request->jenispasien == 'JKN' ? 'selected' : '' }}>Pasien
                                        BPJS
                                    </option>
                                    <option value="NON-JKN" {{ $request->jenispasien == 'NON-JKN' ? 'selected' : '' }}>
                                        Pasien
                                        Umum</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tanggalperiksa"><b>Tanggal Periksa</b></label>
                                <div class="input-group date">
                                    <input type="text" id="tanggalperiksa" name="tanggalperiksa"
                                        value="{{ $request->tanggalperiksa }}" class="form-control datetimepicker">
                                </div>
                            </div>
                            <div class="form-group mt-3 jeniskunjunganC">
                                <label for="jeniskunjungan"><b>Jenis Kunjungan</b></label>
                                <select name="jeniskunjungan" class="form-control" id="jeniskunjungan">
                                    <option selected disabled>Pilih Jenis Kunjungan</option>
                                    <option value="1" {{ $request->jeniskunjungan == '1' ? 'selected' : '' }}>Rujukan
                                        FKTP
                                    </option>
                                    <option value="3" {{ $request->jeniskunjungan == '3' ? 'selected' : '' }}>Surat
                                        Kontrol
                                    </option>
                                    <option value="4" {{ $request->jeniskunjungan == '4' ? 'selected' : '' }}>Rujukan
                                        Antar
                                        RS</option>
                                </select>
                            </div>
                            <div class="form-group mt-3 nomorkartuC">
                                <label for="nomorkartu"><b>No BPJS Pasien</b></label>
                                <input type="text" name="nomorkartu" class="form-control" id="nomorkartu"
                                    placeholder="Masukan Nama Anda" value="{{ $request->nomorkartu }}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="nik"><b>NIK Pasien</b></label>
                                <input type="text" class="form-control" name="nik" id="nik"
                                    placeholder="Masukan nik Pasien" value="{{ $request->nik }}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="nohp"><b>No HP</b></label>
                                <input type="text" class="form-control" name="nohp" id="nohp"
                                    placeholder="Masukan nohp Pasien" value="{{ $request->nohp }}">
                            </div>
                            @if ($request->nomorreferensi)
                                <div class="form-group mt-3">
                                    <label for="nomorreferensi"><b>Nomor Referensi</b></label>
                                    <input type="text" class="form-control" name="nomorreferensi" id="nomorreferensi"
                                        value="{{ $request->nomorreferensi }}">
                                </div>
                            @endif
                            @if ($poli)
                                <div class="form-group mt-3">
                                    <label for="namasubspesialis"><b>Poliklinik</b></label>
                                    <input type="hidden" name="kodepoli" value="{{ $request->kodepoli }}">
                                    <input type="text" class="form-control"
                                        value="{{ $poli->namasubspesialis }} ({{ $poli->kodesubspesialis }})">
                                </div>
                            @endif
                            @if ($jadwals)
                                <div class="form-group mt-3">
                                    <label for="kodedokter"><b>Pilih Jadwal Dokter</b></label>
                                    <select name="kodedokter" class="form-control" id="kodedokter">
                                        <option selected disabled>Pilih Jadwal Dokter</option>
                                        @foreach ($jadwals as $jadwal)
                                            <option value="{{ $jadwal->kodedokter }}"
                                                {{ $request->kodedokter == $jadwal->kodedokter ? 'selected' : '' }}>
                                                {{ $jadwal->jadwal }}
                                                {{ $jadwal->namadokter }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                {{-- tidak ada jadwal --}}
                            @endif
                            <div class="form-group mt-2 mb-5">
                                <div>
                                    <button id="save" type="submit" form="daftarTamu"
                                        class="btn btn-success mt-1">Check</button>
                                    <span class="btn btn-danger mt-1" id="clear">Clear</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#tanggalperiksa").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#jenispasien").on("change", function() {
                var jenispasien = $(this).val();
                if (jenispasien == 'JKN') {
                    $(".jeniskunjunganC").show()
                    $(".nomorkartuC").show()
                } else {
                    $(".jeniskunjunganC").hide()
                    $(".nomorkartuC").hide()
                }
            });
        });
    </script>
@endsection
