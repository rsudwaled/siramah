@extends('layouts_erm.app')
@push('style')
@endpush
@section('content')
    <div class="col-12">
        <div class="card" style="font-size: 12px;">
            <div class="card-header p-2">
                <ul class="nav nav-pills" style="font-size: 14px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="#resume-kepulangan-pasien" data-toggle="tab">RINGKASAN PASIEN
                            PULANG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#hasil-resume" data-toggle="tab">Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content ">
                    <div class="tab-pane active" id="resume-kepulangan-pasien">
                        @if (session('error'))
                            <script>
                                alert('{{ session('error') }}');
                            </script>
                        @endif
                        <form action="{{ route('dashboard.erm-ranap.resume-pemulangan.store-resume') }}"
                            name="formEvaluasiMPPA" id="formEvaluasiMPPA" method="POST">
                            @csrf
                            <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                            <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
                            <input type="hidden" name="diagnosa_utama_icd10_desc"
                                value="{{ $resume->diagnosa_utama_icd10_desc ?? '' }}">
                            <div class="row">
                                <div class="col-12 row">
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label for="RM Pasien">RM Pasien</label>
                                            <input type="text" name="rm_pasien" value="{{ $pasien->no_rm }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="Tgl Lahir">Tgl Lahir</label>
                                            <input type="text" name="tgl_lahir_pasien"
                                                value="{{ Carbon\Carbon::parse($pasien->tgl_lahir)->format('Y-m-d') }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="Nama Pasien">Nama Pasien</label>
                                            <input type="text" name="nama_pasien" value="{{ $pasien->nama_px }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label for="Jenis Kelamin">Jenis Kelamin</label>
                                            <input type="text" name="jk_pasien" value="{{ $pasien->jenis_kelamin }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="Nama Dokter">Nama Dokter</label>
                                            <select name="nama_dpjp" id="nama_dpjp" class="select2 form-control">
                                                @if (!empty($resume->kode_dokter))
                                                    <option value="{{ $resume->kode_dokter }}" selected>{{ $resume->dpjp }}
                                                    </option>
                                                @else
                                                    <option value="">Pilih Nama Dokter</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="Tgl Cetak">Tgl Cetak</label>
                                            <input type="date" name="tgl_cetak"
                                                value="{{ \Carbon\Carbon::parse($resume->tgl_cetak ?? now())->format('Y-m-d') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">FORM RINGKASAN PASIEN PULANG</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 38%;">
                                                            <div class="form-group">
                                                                <label for="tgl_masuk">Tgl Masuk:</label>
                                                                <input type="date" name="tgl_masuk" id="tgl_masuk"
                                                                    value="{{ $resume->tgl_masuk ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="waktu_masuk">Jam Masuk:</label>
                                                                <input type="time" name="waktu_masuk" id="waktu_masuk"
                                                                    value="{{ $resume->jam_masuk ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="ruang_rawat_masuk">Ruang Rawat:</label>
                                                                <input type="text" name="ruang_rawat_masuk"
                                                                    value="{{ $resume->ruang_rawat_masuk ?? '' }}"
                                                                    id="ruang_rawat_masuk" class="form-control">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="tgl_keluar">Tgl Keluar:</label>
                                                                <input type="date" name="tgl_keluar" id="tgl_keluar"
                                                                    value="{{ $resume->tgl_keluar ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="waktu_keluar">Jam Keluar:</label>
                                                                <input type="time" name="waktu_keluar"
                                                                    value="{{ $resume->jam_keluar ?? '' }}"
                                                                    id="waktu_keluar" class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="ruang_rawat_keluar">Ruang Rawat:</label>
                                                                <input type="text" name="ruang_rawat_keluar"
                                                                    value="{{ $resume->ruang_rawat_keluar ?? '' }}"
                                                                    id="ruang_rawat_keluar" class="form-control">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="lama_rawat">Lama Rawat:</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $resume->lama_rawat ?? '' }}"
                                                                        name="lama_rawat" id="lama_rawat">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Hari</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="bb_bayi_lahir">
                                                                    Berat Badan Bayi Lahir < 1 Bulan:</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $resume->bb_bayi_lahir ?? '' }}"
                                                                                name="bb_bayi_lahir" id="bb_bayi_lahir">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text">Kg</span>
                                                                            </div>
                                                                        </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <label for="grafida">
                                                                Grafida:</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="grafida"
                                                                    value="{{ $resume->grafida ?? '' }}" id="grafida">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Minggu</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 row mt-1">
                                                                <table style="width: 100%; margin:0; padding:0;">
                                                                    <tr>
                                                                        <td
                                                                            style="margin:2px; padding:2px; text-align:center;">
                                                                            <strong>PEMERIKSAAN SHK</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="margin:0; padding:2px;">
                                                                            <div class="form-group"
                                                                                style="margin:0; padding:0;">
                                                                                <input type="checkbox"
                                                                                    name="pemeriksaan_shk_ya"
                                                                                    {{ ($resume->pemeriksaan_shk_ya ?? '') == 'on' ? 'checked' : '' }}>
                                                                                <label for="pemeriksaan_shk_ya">Pemeriksaan
                                                                                    SHK (YA)</label>
                                                                            </div>
                                                                            <div class="form-group"
                                                                                style="margin:0; padding:0;">
                                                                                <input type="checkbox"
                                                                                    name="pemeriksaan_shk_tidak"
                                                                                    {{ ($resume->pemeriksaan_shk_tidak ?? '') == 'on' ? 'checked' : '' }}>
                                                                                <label
                                                                                    for="pemeriksaan_shk_tidak">Pemeriksaan
                                                                                    SHK (TIDAK)</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="margin:0; padding:2px;">
                                                                            <div class="form-group"
                                                                                style="margin:0; padding:0;">
                                                                                <input type="checkbox"
                                                                                    name="diambil_dari_tumit"
                                                                                    {{ ($resume->diambil_dari_tumit ?? '') == 'on' ? 'checked' : '' }}>
                                                                                <label for="diambil_dari_tumit">Diambil
                                                                                    Dari (TUMIT)</label>
                                                                            </div>
                                                                            <div class="form-group"
                                                                                style="margin:0; padding:0;">
                                                                                <input type="checkbox"
                                                                                    name="diambil_dari_vena"
                                                                                    {{ ($resume->diambil_dari_vena ?? '') == 'on' ? 'checked' : '' }}>
                                                                                <label for="diambil_dari_vena">Diambil Dari
                                                                                    (VENA)</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="margin:0; padding:2px;">
                                                                            <div class="form-group"
                                                                                style="margin:0; padding:0;">
                                                                                <label for="tgl_pengambilan_shk">TGL
                                                                                    Pengambilan</label>
                                                                                <input type="date"
                                                                                    name="tgl_pengambilan_shk"
                                                                                    class="form-control"
                                                                                    value="{{ $resume->tgl_pengambilan_shk ?? '' }}">
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                </table>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Ringkasan Perawatan</strong></td>
                                                        <td colspan="2">
                                                            <textarea style="font-size:12px;" name="ringkasan_perawatan" id="ringkasan_perawatan" rows="5"
                                                                class="form-control">{{ $resume->ringkasan_perawatan ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Riwayat Penyakit</strong></td>
                                                        <td colspan="2">
                                                            <textarea style="font-size:12px;" name="riwayat_penyakit" id="riwayat_penyakit" rows="5"
                                                                class="form-control">{{ $resume->riwayat_penyakit ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Indikasi Rawat Inap</strong></td>
                                                        <td colspan="2">
                                                            <textarea style="font-size:12px;" name="indikasi_rawat_inap" id="indikasi_rawat_inap" rows="5"
                                                                class="form-control">{{ $resume->indikasi_ranap ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Pemeriksaan Fisik</strong></td>
                                                        <td colspan="2">
                                                            <textarea style="font-size:12px;" name="pemeriksaan_fisik" id="pemeriksaan_fisik" rows="5"
                                                                class="form-control">{{ $resume->pemeriksaan_fisik ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    @if ($umur == 0 || $umur < 30)
                                                        <tr>
                                                            <td colspan="3">
                                                                <table style="width: 100%; height: 100%; border:none;">
                                                                    <tr>
                                                                        <td colspan="7" style="text-align: center;">
                                                                            <strong>Apgar Score</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: center;">Menit</td>
                                                                        <td style="text-align: center;">A</td>
                                                                        <td style="text-align: center;">P</td>
                                                                        <td style="text-align: center;">G</td>
                                                                        <td style="text-align: center;">A</td>
                                                                        <td style="text-align: center;">R</td>
                                                                        <td style="text-align: center;">TOTAL</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: center;">1 Menit</td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="a_1menit" id="a_1menit"
                                                                                value="{{ $resume->a_1menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('a_1menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="ap_1menit" id="ap_1menit"
                                                                                value="{{ $resume->ap_1menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('ap_1menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="apg_1menit" id="apg_1menit"
                                                                                value="{{ $resume->apg_1menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('apg_1menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="apga_1menit" id="apga_1menit"
                                                                                value="{{ $resume->apga_1menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('apga_1menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="apgar_1menit" id="apgar_1menit"
                                                                                value="{{ $resume->apgar_1menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('apgar_1menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="text" class="form-control"
                                                                                name="total_apgar_1menit"
                                                                                value="{{ $resume->total_apgar_1menit ?? 0 }}"
                                                                                id="total_apgar_1menit" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="text-align: center;">5 Menit</td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="a_5menit" id="a_5menit"
                                                                                value="{{ $resume->a_5menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('a_5menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                name="ap_5menit" id="ap_5menit"
                                                                                value="{{ $resume->ap_5menit ?? 0 }}"
                                                                                oninput="updateTotal(); checkNegative('ap_5menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                value="{{ $resume->apg_5menit ?? 0 }}"
                                                                                name="apg_5menit" id="apg_5menit"
                                                                                oninput="updateTotal(); checkNegative('apg_5menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                value="{{ $resume->apga_5menit ?? 0 }}"
                                                                                name="apga_5menit" id="apga_5menit"
                                                                                oninput="updateTotal(); checkNegative('apga_5menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="number" class="form-control"
                                                                                value="{{ $resume->apgar_5menit ?? 0 }}"
                                                                                name="apgar_5menit" id="apgar_5menit"
                                                                                oninput="updateTotal(); checkNegative('apgar_5menit')">
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <input type="text" class="form-control"
                                                                                name="total_apgar_5menit"
                                                                                value="{{ $resume->total_apgar_5menit ?? 0 }}"
                                                                                id="total_apgar_5menit" readonly>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="3" style="margin:0px;">
                                                            <table>
                                                                <tr>
                                                                    <td style="position: relative; height: 100%;">
                                                                        <div
                                                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(270deg); white-space: nowrap;">
                                                                            <strong>PEMERIKSAAN PENUNJANG</strong>
                                                                        </div>
                                                                    </td>

                                                                    <td style="width: 100%;">
                                                                        <table
                                                                            style="width: 100%; height: 100%; border:none;">
                                                                            <tr>
                                                                                <td style="width: 36%; padding: 10px;">
                                                                                    Laboratorium</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <textarea name="penunjang_laboratorium" id="penunjang_laboratorium" rows="5" class="form-control"
                                                                                        style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->penunjang_lab ?? '' }}</textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style=" padding: 10px;">
                                                                                    Radiologi</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <textarea name="penunjang_radiologi" id="penunjang_radiologi" rows="5" class="form-control"
                                                                                        style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->penunjang_radiologi ?? '' }}</textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style=" padding: 10px;">
                                                                                    Penunjang Lainnya</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <textarea name="penunjang_lainya" id="penunjang_lainya" rows="5" class="form-control"
                                                                                        style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->penunjang_lainnya ?? '' }}</textarea>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong style="margin: 0.5rem 0;">Hasil Konsultasi</strong>
                                                        </td>
                                                        <td colspan="2">
                                                            <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="5" class="form-control"
                                                                style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->hasil_konsultasi ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong style="margin: 0.5rem 0;">Diagnosa Masuk</strong>
                                                        </td>
                                                        <td colspan="2">
                                                            <textarea name="diagnosa_masuk" id="diagnosa_masuk" rows="5" class="form-control"
                                                                style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->diagnosa_masuk ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="margin:0px;">
                                                            <table>
                                                                <tr>
                                                                    <td style="position: relative; height: 100%;">
                                                                        <div
                                                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(270deg); white-space: nowrap;">
                                                                            <strong>DIAGNOSA KELUAR</strong>
                                                                        </div>
                                                                    </td>

                                                                    <td style="width: 100%;">
                                                                        <table
                                                                            style="width: 100%; height: 100%; border:none;">
                                                                            <tr>
                                                                                <td style="width: 36%; padding: 10px;">
                                                                                    Diagnosa Utama</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12 row">
                                                                                        <div class="col-8">
                                                                                            <input type="text"
                                                                                                name="cari_icd10utama"
                                                                                                id="cari_icd10utama"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <button type="button"
                                                                                                class="btn btn-md btn-primary"
                                                                                                id="btn-cari-icd10">Cari</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 row mt-1">
                                                                                        <div class="col-12">
                                                                                            <input type="text"
                                                                                                name="diagnosa_utama"
                                                                                                id="diagnosa_utama"
                                                                                                class="form-control"
                                                                                                value="{{ $resume->diagnosa_utama ?? '' }}"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style=" padding: 10px;">
                                                                                    Diagnosa Sekunder</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12 row mt-1">
                                                                                        <div class="col-8">
                                                                                            <input type="text"
                                                                                                name="cari_icd10sekunder"
                                                                                                id="cari_icd10sekunder"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <button type="button"
                                                                                                class="btn btn-md btn-primary"
                                                                                                id="btn-cari-icd10sekunder">Cari</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 row mt-2">
                                                                                        <div class="col-12">

                                                                                            {{-- Tabel Diagnosa Sekunder --}}
                                                                                            @if (!empty($resume) && !empty($resume->diagnosa_sekunder))
                                                                                                @php
                                                                                                    $sekunder = explode(
                                                                                                        '|',
                                                                                                        $resume->diagnosa_sekunder,
                                                                                                    );
                                                                                                    $sekunder_str = implode(
                                                                                                        '|',
                                                                                                        $sekunder,
                                                                                                    );
                                                                                                @endphp

                                                                                                <input type="hidden"
                                                                                                    name="diagnosa_sekunder_update"
                                                                                                    id="diagnosa_sekunder_update"
                                                                                                    class="form-control col-12"
                                                                                                    value="{{ $sekunder_str }}">

                                                                                                <table
                                                                                                    class="table table-bordered"
                                                                                                    id="sekunder-table">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Diagnosa
                                                                                                                Yang Sudah
                                                                                                                Dipilih</th>
                                                                                                            <th>Aksi</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody
                                                                                                        id="sekunder-table-body">
                                                                                                        @foreach ($sekunder as $index => $diagnosa)
                                                                                                            <tr
                                                                                                                id="row-sekunder-{{ $index }}">
                                                                                                                <td
                                                                                                                    style="margin: 0; padding:2px; padding-left:10px;">
                                                                                                                    {{ $diagnosa }}
                                                                                                                </td>
                                                                                                                <td
                                                                                                                    style="margin: 0; padding:2px;">
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="btn btn-xs btn-danger"
                                                                                                                        onclick="removeDiagnosa({{ $index }})">Hapus</button>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif
                                                                                            <table
                                                                                                class="table table-bordered"
                                                                                                id="selectedDiagnosaTable">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Nama
                                                                                                            Diagnosa
                                                                                                        </th>
                                                                                                        <th>Kode ICD-10
                                                                                                        </th>
                                                                                                        <th>Aksi</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody></tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="hiddenDiagnosaData">
                                                                                        <!-- Di sini kita akan menambahkan input tersembunyi untuk data diagnosa -->
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style=" padding: 10px;">
                                                                                    Komplikasi</td>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12">
                                                                                        <input type="text"
                                                                                            style="font-size: 12px;"
                                                                                            value="{{ $resume->komplikasi ?? '' }}"
                                                                                            name="komplikasi"
                                                                                            id="komplikasi"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong style="margin: 0.5rem 0;">Tindakan Operasi</strong>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-12 row mt-1">
                                                                <div class="col-8">
                                                                    <input type="text" name="cari_icd9_tindakanoperasi"
                                                                        id="cari_icd9_tindakanoperasi"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" class="btn btn-md btn-primary"
                                                                        id="btn-cari-icd9tindakan-operasi">Cari</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 row mt-1">
                                                                {{-- Tabel Tindakan Operasi --}}
                                                                @if (!empty($resume) && !empty($resume->tindakan_operasi))
                                                                    @php
                                                                        $tindakan = explode(
                                                                            '|',
                                                                            $resume->tindakan_operasi,
                                                                        );
                                                                        $tindakan_str = implode('|', $tindakan);
                                                                    @endphp

                                                                    <input type="hidden" name="tindakan_operasi_update"
                                                                        id="tindakan_operasi_update"
                                                                        value="{{ $tindakan_str }}">

                                                                    <table class="table table-bordered"
                                                                        id="tindakan-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tindakan Yang Sudah Dipilih</th>
                                                                                <th>Aksi</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tindakan-table-body">
                                                                            @foreach ($tindakan as $index => $operasi)
                                                                                <tr id="row-tindakan-{{ $index }}">
                                                                                    <td
                                                                                        style="margin: 0; padding:2px; padding-left:10px;">
                                                                                        {{ $operasi }}</td>
                                                                                    <td style="margin: 0; padding:2px;">
                                                                                        <button type="button"
                                                                                            class="btn btn-xs btn-danger"
                                                                                            onclick="removeTindakanOperasi({{ $index }})">Hapus</button>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endif
                                                            </div>
                                                            <table class="table table-bordered"
                                                                id="selectedTindakanOperasiTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Diagnosa</th>
                                                                        <th>Kode ICD-9</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                        </div>
                                    </div>
                                    <div id="hiddenTindakanData">
                                        <!-- Di sini kita akan menambahkan input tersembunyi untuk data diagnosa -->
                                    </div>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 38%;">
                                            <div class="form-group">
                                                <label for="tgl_operasi">Tgl Operasi:</label>
                                                <input type="date" name="tgl_operasi" id="tgl_operasi"
                                                    value="{{ $resume->tgl_operasi ?? '' }}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="waktu_mulai_operasi">Waktu Mulai:</label>
                                                <input type="time" name="waktu_mulai_operasi"
                                                    value="{{ $resume->waktu_operasi_mulai ?? '' }}"
                                                    id="waktu_mulai_operasi" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="waktu_selesai_operasi">Waktu Selesai:</label>
                                                <input type="time" name="waktu_selesai_operasi"
                                                    value="{{ $resume->waktu_operasi_selesai ?? '' }}"
                                                    id="waktu_selesai_operasi" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong style="margin: 0.5rem 0;">Sebab Kematian</strong>
                                        </td>
                                        <td colspan="2">
                                            <textarea name="sebab_kematian" id="sebab_kematian" rows="5" class="form-control"
                                                style="width: 100%; resize: vertical; font-size:12px;">{{ $resume->sebab_kematian ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                                        </td>
                                        <td colspan="2">
                                            <div class="col-12 row mt-1">
                                                <div class="col-8">
                                                    <input type="text" name="cari_icd9_tindakanprosedure"
                                                        id="cari_icd9_tindakanprosedure" class="form-control">
                                                </div>
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-md btn-primary"
                                                        id="btn-cari-icd9tindakan-prosedure">Cari</button>
                                                </div>
                                            </div>
                                            <div class="col-12 row mt-2">
                                                <div class="col-12">
                                                    {{-- Tabel Tindakan Prosedur --}}
                                                    @if (!empty($resume) && !empty($resume->tindakan_prosedure))
                                                        @php
                                                            $tindakanProsedure = explode(
                                                                '|',
                                                                $resume->tindakan_prosedure,
                                                            );
                                                            $prosedure_str = implode('|', $tindakanProsedure);
                                                        @endphp

                                                        <input type="hidden" name="tindakan_prosedure_update"
                                                            id="tindakan_prosedure_update" value="{{ $prosedure_str }}">

                                                        <table class="table table-bordered" id="prosedure-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tindakan Prosedure Yang Sudah Dipilih</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tindakan-prosedure-table-body">
                                                                @foreach ($tindakanProsedure as $index => $prosedure)
                                                                    <tr id="row-prosedure-{{ $index }}">
                                                                        <td
                                                                            style="margin: 0; padding:2px; padding-left:10px;">
                                                                            {{ $prosedure }}</td>
                                                                        <td style="margin: 0; padding:2px;">
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-danger"
                                                                                onclick="removeTindakanProsedure({{ $index }})">Hapus</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                    <table class="table table-bordered"
                                                        id="selectedTindakanProsedureTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Diagnosa</th>
                                                                <th>Kode ICD-9</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="hiddenTindakanProsedureData">
                                                <!-- Di sini kita akan menambahkan input tersembunyi untuk data diagnosa -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: center;">
                                            <strong style="margin: 0.5rem 0;">Pengobatan Selama
                                                Dirawat</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            @if ($riwayatObat->isNotEmpty())
                                                @php
                                                    // Membagi data menjadi kelompok per 10 baris
                                                    $chunks = $riwayatObat->chunk(10);
                                                @endphp
                                                <div class="col-12 row">
                                                    @foreach ($chunks as $chunk)
                                                        <div class="col-3 mb-1">
                                                            <table style="width: 100%; font-size:10px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Obat</th>
                                                                        <th>Jumlah</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($chunk as $obat)
                                                                        <tr>
                                                                            <td>{{ $obat['nama_barang'] }}
                                                                            </td>
                                                                            <td>{{ $obat['qty'] }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="col-12 text-center">
                                                    Data tidak ditemukan.
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: center;">
                                            <strong style="margin: 0.5rem 0;">Obat Untuk Pulang</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            @php
                                                // Pastikan resume ditemukan sebelum mencoba akses propertinya
                                                if ($resume) {
                                                    $obatPulang = App\Models\ErmRanapResumeObatPulang::where(
                                                        'id_resume',
                                                        $resume->id,
                                                    )->get();
                                                } else {
                                                    $obatPulang = collect(); // Jika resume tidak ditemukan, gunakan koleksi kosong
                                                }
                                            @endphp

                                            <table class="table table-bordered" id="obat-pulang-table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th><button type="button" class="btn btn-sm btn-primary"
                                                                onclick="addRowObatPulang()">Tambah Row</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($obatPulang) > 0)
                                                        @foreach ($obatPulang as $obat)
                                                            <tr>
                                                                <td><input type="text" class="form-control"
                                                                        name="nama_obat[]"
                                                                        value="{{ $obat->nama_obat }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="jumlah[]" value="{{ $obat->jumlah }}"></td>
                                                                <td><button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="removeRowObatPulang(this)">Hapus</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" class="form-control"
                                                                    name="nama_obat[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="jumlah[]">
                                                            </td>
                                                            <td><button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="removeRowObatPulang(this)">Hapus</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            @php
                                                $caraKeluar =
                                                    isset($resume) && isset($resume->cara_keluar)
                                                        ? json_decode($resume->cara_keluar, true)
                                                        : null;
                                            @endphp
                                            <div class="col-12 row">
                                                <div class="col-1"><strong style="margin: 0.5rem 0;">Cara
                                                        Keluar: </strong> </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="sembuh_perbaikan"
                                                            {{ isset($caraKeluar['sembuh_perbaikan']) && $caraKeluar['sembuh_perbaikan'] == 'on' ? 'checked' : '' }}>
                                                        <label for="sembuh_perbaikan">Sembuh/Perbaikan</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'pindah_rs' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="pindah_rs"
                                                            {{ isset($caraKeluar['pindah_rs']) && $caraKeluar['pindah_rs'] == 'on' ? 'checked' : '' }}>
                                                        <label for="pindah_rs">Pindah RS</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'pulang_paksa' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="pulang_paksa"
                                                            {{ isset($caraKeluar['pulang_paksa']) && $caraKeluar['pulang_paksa'] == 'on' ? 'checked' : '' }}>
                                                        <label for="pulang_paksa">Pulang Paksa</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'meninggal' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="meninggal"
                                                            {{ isset($caraKeluar['meninggal']) && $caraKeluar['meninggal'] == 'on' ? 'checked' : '' }}>
                                                        <label for="meninggal">Meninggal</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <!-- Mengisi input text dengan nilai dari cara_keluar_lainnya, jika ada -->
                                                    <input type="text" name="cara_keluar_lainnya"
                                                        class="form-control col-12"
                                                        value="{{ $caraKeluar['cara_lainya'] ?? '' }}">
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="col-12 row">
                                                <div class="col-3" style="border-right: 1px solid rgb(198, 198, 198)">
                                                    Konsisi Pulang : <br>
                                                    <textarea style="font-size: 12px;" name="kondisi_pulang" id="kondisi_pulang" cols="30" rows="4"
                                                        class="form-control">{{ $resume->kondisi_pulang ?? '' }}</textarea>
                                                </div>
                                                <div class="col-3" style="border-right: 1px solid rgb(198, 198, 198)">
                                                    Keadaan Umum : <br>
                                                    <textarea style="font-size: 12px;" name="keadaan_umum" id="keadaan_umum" cols="30" rows="4"
                                                        class="form-control">{{ $resume->keadaan_umum ?? '' }}</textarea>
                                                </div>
                                                <div class="col-2" style="border-right: 1px solid rgb(198, 198, 198)">
                                                    Kesadaran : <br>
                                                    <textarea style="font-size: 12px;" name="kesadaran" id="kesadaran" cols="30" rows="4"
                                                        class="form-control">{{ $resume->kesadaran ?? '' }}</textarea>
                                                </div>
                                                <div class="col-2" style="border-right: 1px solid rgb(198, 198, 198)">
                                                    Tekanan Darah : <br>
                                                    <textarea style="font-size: 12px;" name="tekanan_darah" id="tekanan_darah" cols="30" rows="4"
                                                        class="form-control">{{ $resume->tekanan_darah ?? '' }}</textarea>
                                                </div>
                                                <div class="col-2">
                                                    Nadi : <br>
                                                    <textarea style="font-size: 12px;" name="nadi" id="nadi" cols="30" rows="4"
                                                        class="form-control">{{ $resume->nadi ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            @php
                                                // Memeriksa apakah $resume dan $resume->pengobatan_dilanjutkan ada
                                                $pengobatan =
                                                    isset($resume) && isset($resume->pengobatan_dilanjutkan)
                                                        ? json_decode($resume->pengobatan_dilanjutkan, true)
                                                        : null;
                                            @endphp
                                            <div class="col-12 row">
                                                <div class="col-1"><strong style="margin: 0.5rem 0;">Pengobatan
                                                        Dilanjutkan:</strong></div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'poliklinik_rswaled' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="poliklinik_rswaled"
                                                            {{ isset($pengobatan['poliklinik_rswaled']) && $pengobatan['poliklinik_rswaled'] == 'on' ? 'checked' : '' }}>
                                                        <label for="poliklinik_rswaled">Poliklinik RS
                                                            Waled</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'rs_lain' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="rs_lain"
                                                            {{ isset($pengobatan['rs_lain']) && $pengobatan['rs_lain'] == 'on' ? 'checked' : '' }}>
                                                        <label for="rs_lain">RS Lain</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'puskesmas' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="puskesmas"
                                                            {{ isset($pengobatan['puskesmas']) && $pengobatan['puskesmas'] == 'on' ? 'checked' : '' }}>
                                                        <label for="puskesmas">Puskesmas</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <!-- Menambahkan kondisi untuk mengecek apakah 'dokter_praktek' ada dan nilainya 'on' -->
                                                        <input type="checkbox" name="dokter_praktek"
                                                            {{ isset($pengobatan['dokter_praktek']) && $pengobatan['dokter_praktek'] == 'on' ? 'checked' : '' }}>
                                                        <label for="dokter_praktek">Dokter Praktek</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" name="pengobatan_lanjutan_lainnya"
                                                        class="form-control col-12"
                                                        value="{{ $pengobatan['lainnya'] ?? '' }}">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <strong style="margin: 0.5rem 0;">Instruksi
                                                        Pulang</strong>
                                                </div>
                                                <div class="col-10">
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td> Kontrol</td>
                                                            <td> Tgl: <input type="date" class="form-control"
                                                                    value="{{ $resume->tgl_kontrol ?? '' }}"
                                                                    name="tgl_kontrol">
                                                            </td>
                                                            <td> Di: <input type="text" class="form-control"
                                                                    style="font-size: 12px;"
                                                                    value="{{ $resume->lokasi_kontrol ?? '' }}"
                                                                    name="lokasi_kontrol"></td>
                                                        </tr>
                                                        <tr>
                                                            <td> Diet</td>
                                                            <td colspan="2">
                                                                <textarea style="font-size: 12px;" name="diet" id="diet" cols="30" rows="4"
                                                                    class="form-control">{{ $resume->diet ?? '' }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Latihan</td>
                                                            <td colspan="2">
                                                                <textarea style="font-size: 12px;" name="latihan" id="latihan" cols="30" rows="4"
                                                                    class="form-control">{{ $resume->latihan ?? '' }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                Segera kembali ke Rumah Sakit, langsung ke
                                                                Gawat
                                                                Darurat, bila terjadi: <br>
                                                                <textarea style="font-size: 12px;" name="keterangan_kembali" id="keterangan_kembali" cols="30" rows="4"
                                                                    class="form-control">{{ $resume->keterangan_kembali ?? '' }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>

                {{-- @if ($resume)
                    <div class="form-actions col-12 text-right">
                        <button type="submit" class="btn btn-primary">Final Resume</button>
                    </div>
                @else
                    <div class="form-actions col-12">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                @endif --}}
                <div class="form-actions col-12 text-right">
                    <button type="submit" class="btn btn-primary">Final Resume</button>
                </div>
                <div class="form-actions col-12">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
            <div class="tab-pane " id="hasil-resume">
                <iframe src="{{ route('resume-pemulangan.vbeta.print-resume') }}?kode={{ $kunjungan->kode_kunjungan }}"
                    width="100%" height="700px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal untuk menampilkan data -->
    <div class="modal" id="modalkodeicd10" tabindex="-1" role="dialog" aria-labelledby="modalkodeicd10Label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalkodeicd10Label">Data ICD-10</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div id="loading" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Loading...</p>
                    </div>
                    <table class="table table-bordered" id="tabelDiagnosa">
                        <thead>
                            <tr>
                                <th>Nama Diagnosa</th>
                                <th>Kode ICD-10</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data ICD-10 akan dimasukkan di sini -->
                        </tbody>
                    </table>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-cari-icd10').click(function() {
                var keyword = $('#cari_icd10utama').val();
                if (keyword.length === 0) {
                    alert("Masukkan kode atau nama diagnosa!");
                    return;
                }

                // Tampilkan loading spinner
                $('#loading').show();
                $('#tabelDiagnosa tbody').html(''); // Bersihkan tabel sebelum menampilkan data

                // Menjalankan Ajax untuk mengambil data ICD-10
                $.ajax({
                    url: "{{ route('bridging-igd.get-icd10') }}", // Gantilah dengan URL API yang benar
                    method: "GET",
                    data: {
                        keyword: keyword
                    }, // Mengirimkan kata kunci pencarian ke server
                    dataType: "json",
                    success: function(response) {
                        // Sembunyikan loading spinner
                        $('#loading').hide();

                        // Memunculkan modal
                        $('#modalkodeicd10').modal('show');

                        if (response.metadata.code == "200" && response.diagnosa.length > 0) {
                            // Mengisi tabel dengan data dari response
                            $.each(response.diagnosa, function(index, item) {
                                var row = '<tr>' +
                                    '<td>' + item.nama + '</td>' +
                                    '<td>' + item.kode + '</td>' +
                                    '<td><button class="btn btn-primary pilih-diagnosa" data-nama="' +
                                    item.nama + '" data-kode="' + item.kode +
                                    '">Pilih</button></td>' +
                                    '</tr>';
                                $('#tabelDiagnosa tbody').append(row);
                            });
                        } else {
                            // Jika data tidak ditemukan
                            $('#tabelDiagnosa tbody').html(
                                '<tr><td colspan="3">Data tidak ditemukan!</td></tr>');
                        }
                    },
                    error: function() {
                        // Sembunyikan loading spinner
                        $('#loading').hide();
                        alert("Terjadi kesalahan saat mencari data!");
                    }
                });
            });

            // Menangani pemilihan diagnosa
            $(document).on('click', '.pilih-diagnosa', function() {
                var namaDiagnosa = $(this).data('nama');
                var kodeDiagnosa = $(this).data('kode');
                console.log(namaDiagnosa);
                // Masukkan data yang dipilih ke dalam input readonly
                $('#diagnosa_utama').val(namaDiagnosa);

                // Menutup modal
                $('#modalkodeicd10').modal('hide');
            });
        });

        $(document).ready(function() {
            // Fungsi untuk mencari ICD-10 sekunder
            $('#btn-cari-icd10sekunder').click(function() {
                var keyword = $('#cari_icd10sekunder').val();
                if (keyword.length === 0) {
                    alert("Masukkan kode atau nama diagnosa!");
                    return;
                }

                // Tampilkan loading spinner
                $('#loading').show();
                $('#tabelDiagnosa tbody').html(''); // Bersihkan tabel sebelum menampilkan data

                // Menjalankan Ajax untuk mengambil data ICD-10
                $.ajax({
                    url: "{{ route('bridging-igd.get-icd10') }}", // Gantilah dengan URL API yang benar
                    method: "GET",
                    data: {
                        keyword: keyword
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#loading').hide();
                        $('#modalkodeicd10').modal('show');

                        if (response.metadata.code == "200" && response.diagnosa.length > 0) {
                            // Mengisi tabel dengan data dari response
                            $.each(response.diagnosa, function(index, item) {
                                var row = '<tr>' +
                                    '<td>' + item.nama + '</td>' +
                                    '<td>' + item.kode + '</td>' +
                                    '<td><button class="btn btn-primary pilih-diagnosa-sekunder" data-nama="' +
                                    item.nama + '" data-kode="' + item.kode +
                                    '">Pilih</button></td>' +
                                    '</tr>';
                                $('#tabelDiagnosa tbody').append(row);
                            });
                        } else {
                            $('#tabelDiagnosa tbody').html(
                                '<tr><td colspan="3">Data tidak ditemukan!</td></tr>');
                        }
                    },
                    error: function() {
                        $('#loading').hide();
                        alert("Terjadi kesalahan saat mencari data!");
                    }
                });
            });

            // Menangani pemilihan diagnosa
            $(document).on('click', '.pilih-diagnosa-sekunder', function() {
                var diagnosa = $(this).data('nama');
                var kode = $(this).data('kode');

                // Masukkan data yang dipilih ke dalam tabel pilihan
                var row = '<tr data-kode="' + kode + '">' +
                    '<td>' + diagnosa + '</td>' +
                    '<td>' + kode + '</td>' +
                    '<td><button class="btn btn-sm btn-danger hapus-diagnosa">Hapus</button></td>' +
                    '</tr>';
                $('#selectedDiagnosaTable tbody').append(row);

                $('#hiddenDiagnosaData').append('<input type="hidden" name="diagnosa_sekunder[]" value="' +
                    diagnosa + '">');
                $('#hiddenDiagnosaData').append(
                    '<input type="hidden" name="kode_diagnosa_sekunder[]" value="' + kode + '">');
                // Clear input setelah memilih diagnosa
                $('#diagnosa_sekunder').val('');
                $('#kode_diagnosa_sekunder').val('');

                // Menutup modal
                $('#modalkodeicd10').modal('hide');
            });

            // Menghapus diagnosa yang dipilih
            $(document).on('click', '.hapus-diagnosa', function() {
                $(this).closest('tr').remove();
            });
        });

        $(document).ready(function() {
            // Fungsi untuk mencari ICD-10 sekunder
            $('#btn-cari-icd9tindakan-operasi').click(function() {
                var keyword = $('#cari_icd9_tindakanoperasi').val();
                if (keyword.length === 0) {
                    alert("Masukkan kode atau nama diagnosa!");
                    return;
                }

                // Tampilkan loading spinner
                $('#loading').show();
                $('#tabelDiagnosa tbody').html(''); // Bersihkan tabel sebelum menampilkan data

                // Menjalankan Ajax untuk mengambil data ICD-10
                $.ajax({
                    url: "{{ route('bridging-igd.get-icd9') }}", // Gantilah dengan URL API yang benar
                    method: "GET",
                    data: {
                        procedure: keyword
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#loading').hide();
                        $('#modalkodeicd10').modal('show');

                        if (response.metadata.code == "200" && response.icd9.length > 0) {
                            // Mengisi tabel dengan data dari response
                            $.each(response.icd9, function(index, item) {
                                var row = '<tr>' +
                                    '<td>' + item.nama + '</td>' +
                                    '<td>' + item.kode + '</td>' +
                                    '<td><button class="btn btn-primary pilih-tindakan-operasi" data-nama="' +
                                    item.nama + '" data-kode="' + item.kode +
                                    '">Pilih</button></td>' +
                                    '</tr>';
                                $('#tabelDiagnosa tbody').append(row);
                            });
                        } else {
                            $('#tabelDiagnosa tbody').html(
                                '<tr><td colspan="3">Data tidak ditemukan!</td></tr>');
                        }
                    },
                    error: function() {
                        $('#loading').hide();
                        alert("Terjadi kesalahan saat mencari data!");
                    }
                });
            });

            // Menangani pemilihan diagnosa
            $(document).on('click', '.pilih-tindakan-operasi', function() {
                var diagnosa = $(this).data('nama');
                var kode = $(this).data('kode');

                // Masukkan data yang dipilih ke dalam tabel pilihan
                var row = '<tr data-kode="' + kode + '">' +
                    '<td>' + diagnosa + '</td>' +
                    '<td>' + kode + '</td>' +
                    '<td><button class="btn btn-sm btn-danger hapus-tindakan">Hapus</button></td>' +
                    '</tr>';
                $('#selectedTindakanOperasiTable tbody').append(row);

                $('#hiddenTindakanData').append('<input type="hidden" name="tindakan_operasi[]" value="' +
                    diagnosa + '">');
                $('#hiddenTindakanData').append(
                    '<input type="hidden" name="kode_tindakan_operasi[]" value="' + kode + '">');
                // Clear input setelah memilih diagnosa
                $('#tindakan_operasi').val('');
                $('#kode_tindakan_operasi').val('');

                // Menutup modal
                $('#modalkodeicd10').modal('hide');
            });

            // Menghapus diagnosa yang dipilih
            $(document).on('click', '.hapus-tindakan', function() {
                $(this).closest('tr').remove();
            });
        });

        $(document).ready(function() {
            // Fungsi untuk mencari ICD-10 sekunder
            $('#btn-cari-icd9tindakan-prosedure').click(function() {
                var keyword = $('#cari_icd9_tindakanprosedure').val();
                if (keyword.length === 0) {
                    alert("Masukkan kode atau nama diagnosa!");
                    return;
                }

                // Tampilkan loading spinner
                $('#loading').show();
                $('#tabelDiagnosa tbody').html(''); // Bersihkan tabel sebelum menampilkan data

                // Menjalankan Ajax untuk mengambil data ICD-10
                $.ajax({
                    url: "{{ route('bridging-igd.get-icd9') }}", // Gantilah dengan URL API yang benar
                    method: "GET",
                    data: {
                        procedure: keyword
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#loading').hide();
                        $('#modalkodeicd10').modal('show');

                        if (response.metadata.code == "200" && response.icd9.length > 0) {
                            // Mengisi tabel dengan data dari response
                            $.each(response.icd9, function(index, item) {
                                var row = '<tr>' +
                                    '<td>' + item.nama + '</td>' +
                                    '<td>' + item.kode + '</td>' +
                                    '<td><button class="btn btn-primary pilih-tindakan-prosedure" data-nama="' +
                                    item.nama + '" data-kode="' + item.kode +
                                    '">Pilih</button></td>' +
                                    '</tr>';
                                $('#tabelDiagnosa tbody').append(row);
                            });
                        } else {
                            $('#tabelDiagnosa tbody').html(
                                '<tr><td colspan="3">Data tidak ditemukan!</td></tr>');
                        }
                    },
                    error: function() {
                        $('#loading').hide();
                        alert("Terjadi kesalahan saat mencari data!");
                    }
                });
            });

            // Menangani pemilihan diagnosa
            $(document).on('click', '.pilih-tindakan-prosedure', function() {
                var diagnosa = $(this).data('nama');
                var kode = $(this).data('kode');

                // Masukkan data yang dipilih ke dalam tabel pilihan
                var row = '<tr data-kode="' + kode + '">' +
                    '<td>' + diagnosa + '</td>' +
                    '<td>' + kode + '</td>' +
                    '<td><button class="btn btn-sm btn-danger hapus-prosedure">Hapus</button></td>' +
                    '</tr>';
                $('#selectedTindakanProsedureTable tbody').append(row);

                $('#hiddenTindakanProsedureData').append(
                    '<input type="hidden" name="tindakan_prosedure[]" value="' +
                    diagnosa + '">');
                $('#hiddenTindakanProsedureData').append(
                    '<input type="hidden" name="kode_tindakan_prosedure[]" value="' + kode + '">');
                // Clear input setelah memilih diagnosa
                $('#tindakan_prosedure').val('');
                $('#kode_tindakan_prosedure').val('');
                // Menutup modal
                $('#modalkodeicd10').modal('hide');
            });

            // Menghapus diagnosa yang dipilih
            $(document).on('click', '.hapus-prosedure', function() {
                $(this).closest('tr').remove();
            });
        });

        $(document).ready(function() {
            // Ketika halaman dimuat, lakukan request AJAX untuk mendapatkan data dokter
            $.ajax({
                url: '{{ route('resume-pemulangan.vbeta.get-dokter') }}', // URL untuk mendapatkan data dokter
                type: 'GET', // Menggunakan GET untuk mengambil data
                dataType: 'json', // Data yang diterima berupa JSON
                success: function(data) {
                    // Mengosongkan dropdown sebelum diisi
                    var select = $('#nama_dpjp');
                    var selectedValue = select.val(); // Menyimpan nilai yang sudah dipilih sebelumnya

                    // Menambahkan opsi default
                    select.empty();
                    select.append('<option value="">Pilih Nama Dokter</option>');

                    // Looping melalui data dan menambahkan opsi untuk setiap dokter
                    $.each(data, function(index, dokter) {
                        var selected = dokter.kode_paramedis == selectedValue ? 'selected' :
                            ''; // Menentukan apakah dokter ini dipilih
                        select.append('<option value="' + dokter.kode_paramedis + '" ' +
                            selected + '>' + dokter.nama_paramedis + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ' + error);
                    alert('Gagal memuat data dokter');
                }
            });
        });

        function updateTotal() {
            // Ambil nilai untuk baris "1 Menit"
            const a1 = parseFloat(document.getElementById('a_1menit').value) || 0;
            const ap1 = parseFloat(document.getElementById('ap_1menit').value) || 0;
            const apg1 = parseFloat(document.getElementById('apg_1menit').value) || 0;
            const apga1 = parseFloat(document.getElementById('apga_1menit').value) || 0;
            const apgar1 = parseFloat(document.getElementById('apgar_1menit').value) || 0;

            // Hitung total untuk "1 Menit"
            let total1 = a1 + ap1 + apg1 + apga1 + apgar1;

            // Pastikan total tidak negatif
            if (total1 < 0) total1 = 0;

            // Update nilai total untuk "1 Menit"
            document.getElementById('total_apgar_1menit').value = total1;

            // Ambil nilai untuk baris "5 Menit"
            const a5 = parseFloat(document.getElementById('a_5menit').value) || 0;
            const ap5 = parseFloat(document.getElementById('ap_5menit').value) || 0;
            const apg5 = parseFloat(document.getElementById('apg_5menit').value) || 0;
            const apga5 = parseFloat(document.getElementById('apga_5menit').value) || 0;
            const apgar5 = parseFloat(document.getElementById('apgar_5menit').value) || 0;

            // Hitung total untuk "5 Menit"
            let total5 = a5 + ap5 + apg5 + apga5 + apgar5;

            // Pastikan total tidak negatif
            if (total5 < 0) total5 = 0;

            // Update nilai total untuk "5 Menit"
            document.getElementById('total_apgar_5menit').value = total5;
        }

        // Fungsi untuk mencegah inputan negatif
        function checkNegative(id) {
            const inputElement = document.getElementById(id);
            if (parseFloat(inputElement.value) < 0) {
                inputElement.value = 0; // Set nilai ke 0 jika input negatif
            }
        }
    </script>
    <script>
        // Fungsi untuk menghapus diagnosa sekunder
        function removeDiagnosa(index) {
            var row = document.getElementById("row-sekunder-" + index);
            row.parentNode.removeChild(row); // Menghapus baris dari tabel

            var sekunderStr = document.getElementById("diagnosa_sekunder_update").value;
            var sekunderArray = sekunderStr.split("|");
            sekunderArray.splice(index, 1); // Menghapus elemen berdasarkan index

            document.getElementById("diagnosa_sekunder_update").value = sekunderArray.join("|");
            adjustRowIds('sekunder'); // Memperbarui ID baris setelah penghapusan
        }

        // Fungsi untuk menyesuaikan ID baris setelah penghapusan
        function adjustRowIds(type) {
            var rows = document.querySelectorAll(`#${type}-table-body tr`);
            rows.forEach((row, index) => {
                row.id = `row-${type}-${index}`; // Menyesuaikan ID baris
                row.querySelector('button').setAttribute('onclick',
                    `remove${capitalizeFirstLetter(type)}(${index})`);
            });
        }

        // Fungsi untuk kapitalisasi huruf pertama pada string
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Fungsi untuk menghapus tindakan operasi
        function removeTindakanOperasi(index) {
            var operasiData = document.getElementById('tindakan_operasi_update').value;
            var operasiArray = operasiData.split('|');
            operasiArray.splice(index, 1); // Menghapus elemen berdasarkan index

            document.getElementById('tindakan_operasi_update').value = operasiArray.join('|');
            document.getElementById('row-tindakan-' + index).remove();
        }

        // Fungsi untuk menghapus tindakan prosedur
        function removeTindakanProsedure(index) {
            var prosedureData = document.getElementById('tindakan_prosedure_update').value;
            var prosedureArray = prosedureData.split('|');
            prosedureArray.splice(index, 1); // Menghapus elemen berdasarkan index

            document.getElementById('tindakan_prosedure_update').value = prosedureArray.join('|');
            document.getElementById('row-prosedure-' + index).remove();
        }
    </script>
    <script>
        function addRowObatPulang() {
            const table = document.getElementById("obat-pulang-table").getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);

            // Membuat kolom untuk Nama Obat
            const cell1 = newRow.insertCell(0);
            cell1.innerHTML = '<input type="text" class="form-control" name="nama_obat[]">';

            // Membuat kolom untuk Jumlah
            const cell2 = newRow.insertCell(1);
            cell2.innerHTML = '<input type="text" class="form-control" name="jumlah[]">';

            // Membuat kolom untuk tombol Hapus
            const cell3 = newRow.insertCell(2);
            cell3.innerHTML =
                '<button type="button" class="btn btn-sm btn-danger" onclick="removeRowObatPulang(this)">Hapus</button>';
        }

        // Fungsi untuk menghapus baris
        function removeRowObatPulang(button) {
            const row = button.closest("tr");
            row.remove();
        }
    </script>
@endsection
