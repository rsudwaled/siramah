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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik"><b>NIK Pasien</b></label>
                                    <div class="input-group">
                                        <input type="text" name="nik" placeholder="Masukan nik Pasien"
                                            value="{{ $request->nik }}" {{ $pasien ? 'readonly' : '' }} id="nik"
                                            class="form-control mr-2">
                                        @empty($pasien)
                                            <span class="m-2"></span>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-warning ">
                                                    <i class="fas fa-search"></i>
                                                    Cek Pasien</button>
                                            </span>
                                        @endempty
                                    </div>
                                </div>
                                @if ($pasien)
                                    <div class="form-group mt-3">
                                        <label for="nomorkartu"><b>No BPJS Pasien</b></label>
                                        <input type="text" name="nomorkartu" readonly class="form-control"
                                            id="nomorkartu" placeholder="Masukan Nama Anda" value="{{ $pasien->no_Bpjs }}">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="norm"><b>No RM</b></label>
                                        <input type="text" name="norm" readonly class="form-control" id="norm"
                                            placeholder="Masukan Nama Anda" value="{{ $pasien->no_rm }}">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="nama"><b>Nam Pasien</b></label>
                                        <input type="text" name="nama" readonly class="form-control" id="nama"
                                            placeholder="Masukan Nama Anda" value="{{ $pasien->nama_px }}">
                                    </div>
                                    <div class="form-group mt-3 mb-3">
                                        <label for="nohp"><b>No HP</b></label>
                                        <input type="text" class="form-control" name="nohp" id="nohp"
                                            placeholder="Masukan nohp Pasien" value="{{ $pasien->no_hp }}" required>
                                    </div>
                                @endif
                            </div>
                            @if ($pasien)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenispasien"><b>Jenis Pasien</b></label>
                                        <select name="jenispasien" class="form-control" id="jenispasien" required
                                            {{ $jadwals ? 'readonly' : '' }}>
                                            <option selected disabled>Pilih Jenis Pasien</option>
                                            <option value="JKN" {{ $request->jenispasien == 'JKN' ? 'selected' : '' }}>
                                                Pasien
                                                BPJS
                                            </option>
                                            <option value="NON-JKN"
                                                {{ $request->jenispasien == 'NON-JKN' ? 'selected' : '' }}>
                                                Pasien
                                                Umum</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="namasubspesialis"><b>Poliklinik</b></label>
                                        <select name="kodepoli" class="form-control" id="kodepoli" required
                                            {{ $jadwals ? 'readonly' : '' }}>
                                            <option selected disabled>Pilih Poliklinik</option>
                                            @foreach ($polikliniks as $poli)
                                                <option value="{{ $poli->kodesubspesialis }}"
                                                    {{ $request->kodepoli == $poli->kodesubspesialis ? 'selected' : '' }}>
                                                    {{ $poli->namasubspesialis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="tanggalperiksa"><b>Tanggal Periksa</b></label>
                                        <div class="input-group date">
                                            <input type="text" id="tanggalperiksa" name="tanggalperiksa"
                                                value="{{ $request->tanggalperiksa }}" class="form-control datetimepicker"
                                                required {{ $jadwals ? 'readonly' : '' }}>
                                        @empty($jadwals)
                                            <span class="m-2"></span>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-warning ">
                                                    <i class="fas fa-search"></i>
                                                    Cek Jadwal</button>
                                            </span>
                                        @endempty
                                    </div>
                                </div>
                                @if ($request->jenispasien == 'JKN' && $request->kodepoli && $jadwals)
                                    <div class="form-group mt-3">
                                        <label for="jeniskunjungan"><b>Jenis Kunjungan</b></label>
                                        <div class="input-group">
                                            <select name="jeniskunjungan" class="form-control" id="jeniskunjungan">
                                                <option selected disabled>Pilih Jenis Kunjungan</option>
                                                <option value="1"
                                                    {{ $request->jeniskunjungan == '1' ? 'selected' : '' }}>Rujukan
                                                    FKTP
                                                </option>
                                                <option value="3"
                                                    {{ $request->jeniskunjungan == '3' ? 'selected' : '' }}>Surat
                                                    Kontrol
                                                </option>
                                                <option value="4"
                                                    {{ $request->jeniskunjungan == '4' ? 'selected' : '' }}>Rujukan
                                                    Antar
                                                    RS</option>
                                            </select>
                                            <span class="m-2"></span>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-warning "><i
                                                        class="fas fa-search"></i>
                                                    Cek Rujukan / Srt. Kontrol</button>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($rujukans)
                                        <div class="form-group mt-3">
                                            <label for="nomorreferensi"><b>Nomor Referensi</b></label>
                                            <div class="input-group">
                                                <select name="nomorreferensi" class="form-control"
                                                    id="nomorreferensi">
                                                    <option selected disabled>Pilih Rujukan / Surat Kontrol</option>
                                                    @foreach ($rujukans as $rujukan)
                                                        <option value="{{ $rujukan->noKunjungan }}">
                                                            {{ $rujukan->noKunjungan }} POLI
                                                            {{ $rujukan->poliRujukan->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                        <div class="form-group mt-3 mb-3">
                                            <button id="save" type="submit"
                                                class="btn btn-success mt-1">Daftar</button>
                                            <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                                Reset Formulir</a>
                                        </div>
                                    @endif
                                    @if ($suratkontrols)
                                        <div class="form-group mt-3">
                                            <label for="nomorreferensi"><b>Nomor Referensi</b></label>
                                            <div class="input-group">
                                                <select name="nomorreferensi" class="form-control"
                                                    id="nomorreferensi">
                                                    <option selected disabled>Pilih Rujukan / Surat Kontrol</option>
                                                    @foreach ($suratkontrols as $rujukan)
                                                        <option value="{{ $rujukan->noSuratKontrol }}">
                                                            {{ $rujukan->noSuratKontrol }} POLI
                                                            {{ $rujukan->namaPoliTujuan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                        <div class="form-group mt-3 mb-3">
                                            <button id="save" type="submit"
                                                class="btn btn-success mt-1">Daftar</button>
                                            <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                                Reset Formulir</a>
                                        </div>
                                    @endif
                                    {{-- <div class="form-group mt-3 mb-3">
                                        <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                            Reset Formulir</a>
                                    </div> --}}
                                @else
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
                                        <div class="form-group mt-3 mb-3">
                                            <button id="save" type="submit"
                                                class="btn btn-success mt-1">Daftar</button>
                                            <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                                Reset Formulir</a>
                                        </div>
                                    @else
                                        <div class="form-group mt-3 mb-3">
                                            <a href="{{ route('daftarOnline') }}" class="btn btn-danger mt-1">
                                                Reset Formulir</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
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
