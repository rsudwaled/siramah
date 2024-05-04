@extends('adminlte::page')
@section('title', 'CPPT GIZI')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Assesment Gizi</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('simrs.gizi.index') }}"
                            class="btn btn-sm btn-secondary">Kembali</a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">INFORMASI PASIEN</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td> <strong>DATA PASIEN</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="margin-bottom: 10px;">
                                            <tr>
                                                <td>Nomor RM</td>
                                                <td style="padding-left: 10px;">:</td>
                                                <td>{{ $kunjungan->pasien->no_rm }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pasien</td>
                                                <td style="padding-left: 10px;">:</td>
                                                <td>{{ $kunjungan->pasien->nama_px }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat, Tanggal Lahir</td>
                                                <td style="padding-left: 10px;">:</td>
                                                <td>{{ $kunjungan->pasien->tempat_lahir }},
                                                    {{ Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Kelamin</td>
                                                <td style="padding-left: 10px;">:</td>
                                                <td>{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <td colspan="3" style="text-align: center;"><strong>STATUS ASSESMENT</strong></td>
                                </tr>
                                <tr>
                                    <table>
                                        <tr>
                                            <td>ASSESMENT</td>
                                            <td style="padding-left: 10px;">:</td>
                                            <td> <button class="btn btn-xs btn-success">SUDAH DI ISI</button></td>
                                        </tr>
                                        <tr>
                                            <td>DIAGNOSIS</td>
                                            <td style="padding-left: 10px;">:</td>
                                            <td> <button class="btn btn-xs btn-success">SUDAH DI ISI</button></td>
                                        </tr>
                                        <tr>
                                            <td>INTERVENSI</td>
                                            <td style="padding-left: 10px;">:</td>
                                            <td> <button class="btn btn-xs btn-success">SUDAH DI ISI</button></td>
                                        </tr>
                                        <tr>
                                            <td>MONEV</td>
                                            <td style="padding-left: 10px;">:</td>
                                            <td> <button class="btn btn-xs btn-danger">BELUM DI ISI</button></td>
                                        </tr>
                                    </table>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-12">
            <div class="card card-primary mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vDiagnosisMedis" href="#vDiagnosisMedis">
                    <h3 class="card-title">
                        DIAGNOSIS MEDIS
                    </h3>
                    <div class="card-tools">
                        <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                            <i class="fas fa-edit"></i> Edit Asesmen
                        </button>

                    </div>
                </a>
                <div id="vDiagnosisMedis" class="collapse" role="tabpanel">
                    <div class="card-body">
                        Diagnosais Medis
                    </div>
                    <div class="card-body">
                        <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                            @csrf
                            <div class="row">
                                <table>
                                    <tr>
                                        <td>1.</td>
                                        <td>Risiko malnutrisi berdasarkan hasil skrining gizi oleh perawat, kondisi pasien
                                            termasuk
                                            kategori:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Pasien Dewasa : </td>
                                        <td>Pasien Anak :</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Ringan (Nilai MST 0-1)</span></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Ringan (Nilai STRONG-Kids 0)</span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Sedang (Nilai MST 2-3)</span></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Sedang (Nilai STRONG-Kids 1-3)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Tinggi (Nilai MST 4-5)</span></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Risiko Tinggi (Nilai STRONG-Kids 4-5)</span>
                                        </td>
                                    </tr>
                                    <tr style="padding-top: 30px;">
                                        <td>2.</td>
                                        <td>Pasien mempunyai kondisi khusus:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Ya</span></td>
                                        <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                                style="margin-left: 20px;">Tidak</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Alergi makan:</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>* Telur</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>* Susu Sapi & Produk Olahannya</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>* Kacang Kedelai/Tanah</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>* Gandum</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>* Udang</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>* Ikan</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>* Hazelnut/Almond</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;">Ya</span>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span
                                                            style="margin-left: 20px;">Tidak</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Preskripsi Diet:</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;"></span>
                                                    </td>
                                                    <td>Makanan Biasa</td>
                                                    <td><input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;"></span>
                                                    </td>
                                                    <td>Diet Khusus</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Tindak Lanjut:</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;"></span>
                                                    </td>
                                                    <td>Perlu Asuhan Gizi</td>
                                                    <td><input type="checkbox" class="form-check-input ml-1"
                                                            id="exampleCheck1"><span style="margin-left: 20px;"></span>
                                                    </td>
                                                    <td>Belum Perlu Asuhan Gizi</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-primary mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vAssesment" href="#vAssesment">
                    <h3 class="card-title">
                        DATA ASSESMENT
                    </h3>
                    <div class="card-tools">
                        <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                            <i class="fas fa-edit"></i> Edit Asesmen
                        </button>

                    </div>
                </a>
                <div id="vAssesment" class="collapse" role="tabpanel">
                    <div class="card-body">
                        Data Asesmen Gizi
                    </div>
                    <div class="card-body">
                        <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                            @csrf
                            <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <u><strong>ANTROPOMETRI</strong></u>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="BB" id="BB" type="number"
                                                            label="BB" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="TB" id="TB" type="number"
                                                            label="TB" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="LILA" id="LILA" type="number"
                                                            label="LILA" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="T_LUTUT" id="T_LUTUT" type="number"
                                                            label="Tinggi Lutut" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="LK_ANAK" id="LK_ANAK" type="number"
                                                            label="LK Anak" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="BB_IDEAL" id="BB_IDEAL" type="number"
                                                            label="BB Ideal" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group ">
                                                    <div class="col-lg-12">
                                                        <u><strong>STATUS GIZI</strong></u>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="IMT" id="IMT" type="number"
                                                            label="IMT" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="BB_U" id="BB_U" type="number"
                                                            label="BB/U" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="TB_U" id="TB_U" type="number"
                                                            label="TB/U" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="BB_TB" id="BB_TB" type="number"
                                                            label="BB/TB" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <x-adminlte-input name="LILA_U" id="LILA_U" type="number"
                                                            label="LILA/U" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-lg-12"><strong>RIWAYAT GIZI : </strong></div>
                                        <div class="col-lg-12">
                                            <ol>
                                                <li>
                                                    <strong>Kebiasaan Makan Utama :</strong> <br>
                                                    <table class="mb-3">
                                                        <tr>
                                                            <td style="width: 30%;"><strong>Pagi :</strong></td>
                                                            <td style="width: 25%;"><input type="radio" id="pagi_ya"
                                                                    name="makan_pagi" value="pagi_ya">
                                                                <label for="pagi_ya"><strong>YA</strong></label>
                                                            </td>
                                                            <td style="width: 25%; padding-left:10px;"><input
                                                                    type="radio" id="pagi_tidak" name="pagi"
                                                                    value="pagi_tidak">
                                                                <label for="pagi_tidak"><strong>TIDAK</strong></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;"><strong>Siang :</strong></td>
                                                            <td style="width: 25%;"><input type="radio" id="siang_ya"
                                                                    name="makan_siang" value="siang_ya">
                                                                <label for="siang_ya"><strong>YA</strong></label>
                                                            </td>
                                                            <td style="width: 25%; padding-left:10px;"><input
                                                                    type="radio" id="siang_tidak" name="siang"
                                                                    value="siang_tidak">
                                                                <label for="siang_tidak"><strong>TIDAK</strong></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;"><strong>Sore :</strong></td>
                                                            <td style="width: 25%;"><input type="radio" id="sore_ya"
                                                                    name="makan_sore" value="sore_ya">
                                                                <label for="sore_ya"><strong>YA</strong></label>
                                                            </td>
                                                            <td style="width: 25%; padding-left:10px;"><input
                                                                    type="radio" id="sore_tidak" name="sore"
                                                                    value="sore_tidak">
                                                                <label for="sore_tidak"><strong>TIDAK</strong></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </li>
                                                <li>
                                                    <strong>Kebiasaan Selingan / Cemilan</strong>
                                                    <div class="form-group row col-md-5 mb-3">
                                                        <div class="input-group input-group-sm">
                                                            <input name="kebiasaan_selingan_cemilan" type="text"
                                                                class="form-control">
                                                            <div class="input-group-append"><button
                                                                    class="btn btn-secondary btn-sm">kali/hari </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <strong>Alergi Makanan dan pantangan makanan :</strong>
                                                    <div class="form-group row col-md-6 mb-3">
                                                        <div class="input-group input-group-sm">
                                                            <input name="alergi_malanan_&_pantangan_makanan"
                                                                type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <strong>Gangguan Gastrointestinal : </strong>
                                                    <table class="mb-3">
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="gangguan_gastrointestinal[]" value="a">
                                                                <strong style="margin-left:20px;">a. anoreksia</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;" value="b"
                                                                    name="gangguan_gastrointestinal[]">
                                                                <strong style="margin-left:20px;">b. mual</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;" value="c"
                                                                    name="gangguan_gastrointestinal[]">
                                                                <strong style="margin-left:20px;">c. muntah</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="gangguan_gastrointestinal[]" value="d">
                                                                <strong style="margin-left:20px;">d. diare</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    value="e" name="gangguan_gastrointestinal[]"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;">e. kesulitan
                                                                    mengunyah</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    value="f" name="gangguan_gastrointestinal[]"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;">f. kesulitan
                                                                    menelan</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    value="g" style="margin-left:4px;"
                                                                    name="gangguan_gastrointestinal[]">
                                                                <strong style="margin-left:20px;">g. konstipasi</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    value="h" name="gangguan_gastrointestinal[]"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;">h. gangguan gigi
                                                                    geligi</strong>
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </li>
                                                <li>
                                                    <strong>Bentuk Makanan Sebelum Masuk RS :</strong>
                                                    <table class="mb-3">
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="bentuk_makanan_sebelum_masuk_rs_a">
                                                                <strong style="margin-left:20px;">a. Biasa</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;"
                                                                    name="bentuk_makanan_sebelum_masuk_rs_b">b.
                                                                    Lunak</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;"
                                                                    name="bentuk_makanan_sebelum_masuk_rs_c">c.
                                                                    Saring</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="bentuk_makanan_sebelum_masuk_rs_d">
                                                                <strong style="margin-left:20px;">d. Cair</strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </li>
                                                <li>
                                                    <strong>Asupan Makanan Sebelum Masuk RS :</strong>
                                                    <table class="mb-3">
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="asupan_makanan_sebelum_masuk_rs_a">
                                                                <strong style="margin-left:20px;">a. Lebih</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;"
                                                                    name="asupan_makanan_sebelum_masuk_rs_b">b.
                                                                    Baik</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;">
                                                                <strong style="margin-left:20px;"
                                                                    name="asupan_makanan_sebelum_masuk_rs_c">c.
                                                                    Kurang</strong>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input"
                                                                    style="margin-left:4px;"
                                                                    name="asupan_makanan_sebelum_masuk_rs_d">
                                                                <strong style="margin-left:20px;">d. Buruk</strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="col-lg-12">
                                            <x-adminlte-textarea igroup-size="sm" name="fisik_klinis"
                                                label="Fisik/Klinis" placeholder="silahkan masukan data fisik atau klinis"
                                                rows=5>
                                            </x-adminlte-textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <x-adminlte-button type="submit" theme="primary" class="btn-xs float-right ml-2"
                                            label="Simpan Data" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-primary mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vDiagnosaGizi" href="#vDiagnosaGizi">
                    <h3 class="card-title">
                        DIAGNOSIS GIZI
                    </h3>
                    <div class="card-tools">
                        <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                            <i class="fas fa-edit"></i> Edit Asesmen
                        </button>

                    </div>
                </a>
                <div id="vDiagnosaGizi" class="collapse" role="tabpanel">
                    <div class="card-body">
                        <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-adminlte-textarea igroup-size="sm" name="diagnosa_gizi" label="2. Diagnosa Gizi"
                                        placeholder="silahkan masukan data diagnosa gizi" rows=5>
                                    </x-adminlte-textarea>
                                </div>

                                <div class="col-lg-12">
                                    <x-adminlte-button type="submit" theme="primary" class="btn-xs float-right ml-2"
                                        label="Simpan Data" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-primary mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vIntervensi" href="#vIntervensi">
                    <h3 class="card-title">
                        INTERVENSI
                    </h3>
                    <div class="card-tools">
                        <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                            <i class="fas fa-edit"></i> Edit Asesmen
                        </button>

                    </div>
                </a>
                <div id="vIntervensi" class="collapse" role="tabpanel">
                    <div class="card-body">
                        <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-adminlte-textarea igroup-size="sm" name="diagnosa_gizi" label="3. Intervensi"
                                        placeholder="silahkan masukan data intervensi" rows=5>
                                    </x-adminlte-textarea>
                                </div>
                                <div class="col-lg-12">
                                    <x-adminlte-button type="submit" theme="primary" class="btn-xs float-right ml-2"
                                        label="Simpan Data" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-primary mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vMonitoringEvaluasi"
                    href="#vMonitoringEvaluasi">
                    <h3 class="card-title">
                        MONITORING DAN EVALUASI
                    </h3>
                    <div class="card-tools">
                        <button type="button" onclick="modalAsesmenKeperawatan()" class="btn btn-tool bg-warning">
                            <i class="fas fa-edit"></i> Edit Asesmen
                        </button>

                    </div>
                </a>
                <div id="vMonitoringEvaluasi" class="collapse" role="tabpanel">
                    <div class="card-body">
                        <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-adminlte-textarea igroup-size="sm" name="diagnosa_gizi"
                                        label="4. Monitoring dan Evaluasi"
                                        placeholder="silahkan masukan data monitoring dan evaluasi" rows=5>
                                    </x-adminlte-textarea>
                                </div>
                                <div class="col-lg-12">
                                    <x-adminlte-button type="submit" theme="primary" class="btn-xs float-right ml-2"
                                        label="Simpan Data" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-12">
            <div class="card card-info mb-1">
                <a class="card-header" data-toggle="collapse" data-parent="#vAssesmentGizi" href="#vAssesmentGizi">
                    <h3 class="card-title">
                        Assesment Gizi
                    </h3>
                </a>
                <div id="vAssesmentGizi" class="collapse">
                    <div class="card-body">
                        <x-adminlte-button label="Input Diagnosis Medis" icon="fas fa-plus" theme="success" class="btn-xs"
                            onclick="btnInputAssesment()" />
                        <x-adminlte-button label="Input Assesment" icon="fas fa-plus" theme="success" class="btn-xs"
                            onclick="btnInputAssesment()" />
                        <x-adminlte-button label="Input Diagnosis Gizi" icon="fas fa-plus" theme="success" class="btn-xs"
                            onclick="btnInputDiagnosisGizi()" />
                        <x-adminlte-button label="Input Intervensi Gizi" icon="fas fa-plus" theme="success" class="btn-xs"
                            onclick="btnInputIntervensi()" />
                        <x-adminlte-button label="Input Monitoring Evaluasi" icon="fas fa-plus" theme="success"
                            class="btn-xs" onclick="btnInputMonev()" />
                        <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs"
                            onclick="getObservasiRanap()" />

                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Tanggal Jam</th>
                                    <th>SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya</th>
                                    <th>Instruksi Medis</th>
                                    <th>Ttd Pengisi,</th>
                                    <th>Verifikasi DPJP</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @include('simrs.gizi.cppt.cppt_assesment')
            @include('simrs.gizi.cppt.cppt_diagnosa_gizi')
            @include('simrs.gizi.cppt.cppt_intervensi')
            @include('simrs.gizi.cppt.cppt_monitoring_evaluasi')
        </div>

    </div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
    <script>
        function btnInputAssesment() {
            $.LoadingOverlay("show");
            $("#modalAssesmentGizi").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input_assesment_gizi').val(today);
            $('#modalAssesmentGizi').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnInputDiagnosisGizi() {
            $.LoadingOverlay("show");
            $("#formDiagnosisGizi").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input_diagnosis_gizi').val(today);
            $('#DiagnosisGizi').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnInputIntervensi() {
            $.LoadingOverlay("show");
            $("#formIntervensi").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input_intervensi').val(today);
            $('#Intervensi').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnInputMonev() {
            $.LoadingOverlay("show");
            $("#formMonev").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input_perkembangan').val(today);
            $('#Monev').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
@section('css')

@endsection
