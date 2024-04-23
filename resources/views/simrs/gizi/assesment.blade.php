@extends('adminlte::page')
@section('title', 'CPPT GIZI')
@section('content_header')
    <h1>CPPT GIZI </h1>
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
        <div class="col-12">
            <x-adminlte-card title="DIAGNOSIS MEDIS" theme="primary" collapsible="collapsed">
                <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                    @csrf
                    <div class="row">
                        <table>
                            <tr>
                                <td>1.</td>
                                <td>Risiko malnutrisi berdasarkan hasil skrining gizi oleh perawat, kondisi pasien termasuk
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
                                        style="margin-left: 20px;">Risiko Sedang (Nilai STRONG-Kids 1-3)</span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                        style="margin-left: 20px;">Risiko Tinggi (Nilai MST 4-5)</span></td>
                                <td><input type="checkbox" class="form-check-input ml-1" id="exampleCheck1"><span
                                        style="margin-left: 20px;">Risiko Tinggi (Nilai STRONG-Kids 4-5)</span></td>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;">Tidak</span>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;"></span></td>
                                            <td>Makanan Biasa</td>
                                            <td><input type="checkbox" class="form-check-input ml-1"
                                                    id="exampleCheck1"><span style="margin-left: 20px;"></span></td>
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
                                                    id="exampleCheck1"><span style="margin-left: 20px;"></span></td>
                                            <td>Perlu Asuhan Gizi</td>
                                            <td><input type="checkbox" class="form-check-input ml-1"
                                                    id="exampleCheck1"><span style="margin-left: 20px;"></span></td>
                                            <td>Belum Perlu Asuhan Gizi</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </x-adminlte-card>
            <x-adminlte-card title="DATA ASSESMENT" theme="primary" collapsible>
                <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                    @csrf
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
                                                    <td style="width: 50%;"><strong>Pagi :</strong></td>
                                                    <td style="width: 25%;"><input type="checkbox"
                                                            class="form-check-input"> <strong>YA</strong> </td>
                                                    <td style="width: 25%; padding-left:10px;"><input type="checkbox"
                                                            class="form-check-input"> <strong>TIDAK</strong> </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Siang : </strong></td>
                                                    <td style="width: 25%;"><input type="checkbox"
                                                            class="form-check-input"> <strong>YA</strong> </td>
                                                    <td style="width: 25%; padding-left:10px;"><input type="checkbox"
                                                            class="form-check-input"> <strong>TIDAK</strong> </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sore : </strong></td>
                                                    <td style="width: 25%;"><input type="checkbox"
                                                            class="form-check-input"> <strong>YA</strong> </td>
                                                    <td style="width: 25%; padding-left:10px;"><input type="checkbox"
                                                            class="form-check-input"> <strong>TIDAK</strong> </td>
                                                </tr>
                                            </table>
                                        </li>
                                        <li>
                                            <strong>Kebiasaan Selingan / Cemilan</strong>
                                            <div class="form-group row col-md-5 mb-3">
                                                <div class="input-group input-group-sm">
                                                    <input name="kebiasaan_selingan_cemilan " type="text"
                                                        class="form-control">
                                                    <div class="input-group-append"><button
                                                            class="btn btn-secondary btn-sm">kali/hari </button></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li> 
                                            <strong>Alergi Makanan dan pantangan makanan :</strong>
                                            <div class="form-group row col-md-6 mb-3">
                                                <div class="input-group input-group-sm">
                                                    <input name="alergi_malanan_&_pantangan_makanan" type="text"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <strong>Gangguan Gastrointestinal :</strong>
                                            <table class="mb-3">
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;" name="gangguan_gastrointestinal_a">
                                                        <strong style="margin-left:20px;">a. anoreksia</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="gangguan_gastrointestinal_b">b. mual</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="gangguan_gastrointestinal_c">c. muntah</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;" name="gangguan_gastrointestinal_d">
                                                        <strong style="margin-left:20px;">d. diare</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="gangguan_gastrointestinal_e">e. kesulitan
                                                            mengunyah</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="gangguan_gastrointestinal_f">f. kesulitan
                                                            menelan</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;" name="gangguan_gastrointestinal_g">
                                                        <strong style="margin-left:20px;">g. konstipasi</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="gangguan_gastrointestinal_h">h. gangguan gigi
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
                                                            name="bentuk_makanan_sebelum_masuk_rs_b">b. Lunak</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="bentuk_makanan_sebelum_masuk_rs_c">c. Saring</strong>
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
                                                            name="asupan_makanan_sebelum_masuk_rs_b">b. Baik</strong>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input"
                                                            style="margin-left:4px;">
                                                        <strong style="margin-left:20px;"
                                                            name="asupan_makanan_sebelum_masuk_rs_c">c. Kurang</strong>
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
                                    <x-adminlte-textarea igroup-size="sm" name="fisik_klinis" label="Fisik/Klinis"
                                        placeholder="silahkan masukan data fisik atau klinis" rows=5>
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
            </x-adminlte-card>
            <x-adminlte-card title="DIAGNOSIS GIZI" theme="primary" collapsible="collapsed">
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
            </x-adminlte-card>
            <x-adminlte-card title="INTERVENSI" theme="primary" collapsible="collapsed">
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
            </x-adminlte-card>
            <x-adminlte-card title="MONITORING DAN EVALUASI" theme="primary" collapsible="collapsed">
                <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-textarea igroup-size="sm" name="diagnosa_gizi" label="4. Monitoring dan Evaluasi"
                                placeholder="silahkan masukan data monitoring dan evaluasi" rows=5>
                            </x-adminlte-textarea>
                        </div>
                        <div class="col-lg-12">
                            <x-adminlte-button type="submit" theme="primary" class="btn-xs float-right ml-2"
                                label="Simpan Data" />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

    </div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')

@endsection
@section('css')

@endsection
