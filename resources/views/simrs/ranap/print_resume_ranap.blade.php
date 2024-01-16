@extends('adminlte::print')
@section('title', 'Print Resume Rawat Inap')
@section('content_header')
    <h1>Print Resume Rawat Inap</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="printMe">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <div class="col-md-2 border border-dark">
                            <div class="m-2  text-center">
                                <img class="" src="{{ asset('vendor/adminlte/dist/img/rswaled.png') }}"
                                    style="height: 80px">
                            </div>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <b>PEMERINTAHAN KABUPATEN CIREBON</b><br>
                            <b>RUMAH SAKIT UMUM DAERAH WALED</b><br>
                            Jl. Prabu Kian Santang No. 4 Kab. Cirebon Jawa Barat 45151<br>
                            www.rsudwaled.id - 0823 1169 6919 - (0231) 8850943
                        </div>
                        <div class="col-md-4  border border-dark">
                            <div class="row">
                                <div class="p-2">
                                    No RM : <b>{{ $pasien->no_rm }}</b> <br>
                                    Nama : <b>{{ $pasien->nama_px }}</b> <br>
                                    Tgl Lahir : <b>{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d, F Y') }}
                                        ({{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInYears($kunjungan->tgl_masuk) }}
                                        tahun)</b> <br>
                                    Kelamin : <b>{{ $pasien->jenis_kelamin }}</b>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border border-dark text-center bg-warning">
                            <b>Ringkasan Pasien Pulang</b>
                        </div>
                        <div class="col-md-12 border border-dark">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Tanggal Masuk : </b>
                                    {{ $kunjungans->first()->tgl_masuk ? Carbon\Carbon::parse($kunjungans->first()->tgl_masuk)->format('d F Y H:m:s') : '-' }}
                                    <br>
                                    <b>Tanggal Keluar : </b>
                                    {{ $kunjungan->tgl_keluar ? Carbon\Carbon::parse($kunjungans->first()->tgl_keluar)->format('d F Y H:m:s') : '-' }}
                                    <br>
                                    <b>Lama Rawat : </b>
                                    @if ($kunjungan->tgl_keluar)
                                        {{ Carbon\Carbon::parse($kunjungans->first()->tgl_keluar)->diffInDays($kunjungans->first()->tgl_masuk) }}
                                        hari
                                    @else
                                        .... hari
                                    @endif
                                    <br><br>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <b>Ruangan Asal : </b> {{ $kunjungans->first()->unit->nama_unit ?? '-' }} <br>
                                    <b>Ruangan Inap : </b> {{ $kunjungan->unit->nama_unit ?? '-' }} <br>
                                    <b>No SEP : </b> {{ $kunjungan->no_sep ?? '-' }} <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border border-dark">
                            <dl>
                                <dt>Ringkasan Perawatan :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->ringkasan_perawatan ?? '....' }}</pre>
                                </dd>
                                <dt>Riwayat Penyakit :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->riwayat_penyakit ?? '....' }}</pre>
                                </dd>
                                <dt>Indikasi Rawat Inap :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->indikasi_ranap ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-8  border border-dark">
                            <dl>
                                <dt>Pemeriksaan Fisik :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl class="row">
                                <dt class="col-md-5">Berat Badan</dt>
                                <dd class="col-md-7"> : {{ $kunjungan->erm_ranap->berat_badan ?? '....' }} kg</dd>
                                <dt class="col-md-5">Suhu Badan</dt>
                                <dd class="col-md-7">: {{ $kunjungan->erm_ranap->suhu ?? '....' }} Celcius</dd>
                                <dt class="col-md-5">Tensi Darah</dt>
                                <dd class="col-md-7"> : {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }} mmhg</dd>
                                <dt class="col-md-5">Denyut Nadi</dt>
                                <dd class="col-md-7"> : {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }} xs</dd>
                                <dt class="col-md-5">Pernapasan</dt>
                                <dd class="col-md-7">: {{ $kunjungan->erm_ranap->pernapasan ?? '....' }} xs</dd>
                            </dl>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <dl>
                                <dt>Pemeriksaan Laboratorium :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->catatan_laboratorium ?? '....' }}</pre>
                                </dd>
                                <dt>Pemeriksaan Radiologi :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->catatan_radiologi ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <dl>
                                <dt>Pemeriksaan Penunjang Lainnya :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->catatan_penunjang ?? '....' }}</pre>
                                </dd>
                                <dt>Hasil Konsultasi :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->hasil_konsultasi ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Diagnosa Masuk :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_masuk ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Diagnosa Utama :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_utama ?? '....' }}</pre>
                                </dd>
                                <dt>Diagnosa Sekunder :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_sekunder ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Diagnosa ICD-10 :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_icd10 ?? '-' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Tindakan Operasi :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_operasi ?? '....' }}</pre>
                                </dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-md-5">Tgl Operasi</dt>
                                <dd class="col-md-7">: {{ $kunjungan->erm_ranap->tanggal_operasi ?? '....' }}</dd>
                                <dt class="col-md-5">Waktu Mulai</dt>
                                <dd class="col-md-7">: {{ $kunjungan->erm_ranap->awal_operasi ?? '....' }}</dd>
                                <dt class="col-md-5">Waktu Selesai</dt>
                                <dd class="col-md-7">: {{ $kunjungan->erm_ranap->akhir_operasi ?? '....' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Tindakan / Prosedur :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_prosedur ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4  border border-dark">
                            <dl>
                                <dt>Tindakan ICD-10 :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_icd9 ?? '-' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <dl>
                                <dt>Pengobatan Selama Dirawat :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_icd9 ?? '-' }}</pre>
                                </dd>
                                <dt>Pengobatan Untuk Pulang :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_icd9 ?? '-' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-3  border border-dark">
                            <b>Cara Keluar :</b><br>
                            @if ($kunjungan->erm_ranap->cara_pulang == 'Sembuh / Perbaikan')
                                &#x1F5F9; Sembuh / Perbaikan
                            @else
                                &#x25A2; Sembuh / Perbaikan
                            @endif <br>
                            @if ($kunjungan->erm_ranap->cara_pulang == 'Pindah RS')
                                &#x1F5F9; Pindah RS
                            @else
                                &#x25A2; Pindah RS
                            @endif <br>
                            @if ($kunjungan->erm_ranap->cara_pulang == 'Pulang Paksa')
                                &#x1F5F9; Pulang Paksa
                            @else
                                &#x25A2; Pulang Paksa
                            @endif <br>
                            @if ($kunjungan->erm_ranap->cara_pulang == 'Meninggal')
                                &#x1F5F9; Meninggal
                            @else
                                &#x25A2; Meninggal
                            @endif <br>
                            <pre>{{ $kunjungan->erm_ranap->cara_pulang_text ?? '....' }}</pre>
                        </div>

                        <div class="col-md-3  border border-dark">
                            <dl>
                                <dt>Kondisi Pulang :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->kondisi_pulang ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-3  border border-dark">
                            <dl>
                                <dt>Keadaan Umum :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->kondisi_umum ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-3  border border-dark">
                            <b>Cara Keluar :</b><br>
                            @if ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Poliklinik RSUD Waled')
                                &#x1F5F9; Poliklinik RSUD Waled
                            @else
                                &#x25A2; Poliklinik RSUD Waled
                            @endif <br>
                            @if ($kunjungan->erm_ranap->pengobatan_lanjutan == 'RS Lain')
                                &#x1F5F9; RS Lain
                            @else
                                &#x25A2; RS Lain
                            @endif <br>
                            @if ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Puskesmas')
                                &#x1F5F9; Puskesmas
                            @else
                                &#x25A2; Puskesmas
                            @endif <br>
                            @if ($kunjungan->erm_ranap->pengobatan_lanjutan == 'Dokter Praktek')
                                &#x1F5F9; Dokter Praktek
                            @else
                                &#x25A2; Dokter Praktek
                            @endif <br>
                            <pre>{{ $kunjungan->erm_ranap->pengobatan_lanjutan_text ?? '....' }}</pre>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <dl>
                                <dt>Instruksi Pulang :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->instruksi_pulang ?? '....' }}</pre>
                                </dd>
                                <dt>Tgl Kontrol :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->tanggal_kontrol ?? '....' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <dl>

                                <dt>Diet :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->diet ?? '-' }}</pre>
                                </dd>
                                <dt>Latihan :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->erm_ranap->latihan ?? '-' }}</pre>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6 text-center border border-dark">
                            <br>
                            Pasien / Keluarga Pasien <br>
                            Yang Menerima Penjelasan
                            <br>
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $kunjungan->erm_ranap->nama_keluarga ?? 'Keluarga Pasien' }}</u></b><br>
                            NIK. {{ $kunjungan->erm_ranap->nik_keluarga ?? '' }}
                        </div>
                        <div class="col-md-6 text-center border border-dark">
                            Waled, {{ now()->format('d F y h:m:s') }} <br>
                            Dokter Penanggung Jawab Pelayanan <br>
                            (DPJP)
                            <br>
                            <br>
                            <br>
                            <br>
                            <b><u>{{ $kunjungan->dokter->nama_paramedis }}</u></b><br>
                            SIP. {{ $kunjungan->dokter->sip_dr ?? '..................' }}
                        </div>
                    </div>
                </section>
            </div>
            {{-- <button class="btn btn-success btnPrint" onclick="printDiv('printMe')"><i class="fas fa-print"> Print
                    Laporan</i> --}}
        </div>
    </div>
@stop
@section('css')
    <style>
        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 15px;
        }
    </style>
    <style type="text/css" media="print">
        hr {
            color: #333333 !important;
            border: 1px solid #333333 !important;
            line-height: 1.5;
        }

        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            font-size: 15px;
        }

        #resepobat {
            font-size: 22px !important;
            border: none;
            outline: none;
            padding: 0 !important;
        }

        .main-footer {
            display: none !important;
        }

        .btnPrint {
            display: none !important;
        }
    </style>
@endsection
@section('js')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            tampilan_print = document.body.innerHTML = printContents;
            setTimeout('window.addEventListener("load", window.print());', 1000);
        }
    </script>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     window.print();
        // });
        // setTimeout(function() {
        //     window.top.close();
        // }, 2000);
    </script>
@endsection
