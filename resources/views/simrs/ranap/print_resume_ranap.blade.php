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
                    <div class="row" style="font-size: 13px">
                        <div class="col-md-2 border border-dark">
                            <div class="m-2  text-center">
                                <img class="" src="{{ asset('vendor/adminlte/dist/img/rswaled.png') }}"
                                    style="height: 70px">
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
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <b>Ruangan Asal : </b> {{ $kunjungans->first()->unit->nama_unit ?? '-' }} <br>
                                    <b>Ruangan Inap : </b> {{ $kunjungan->unit->nama_unit ?? '-' }} <br>
                                    <b>No SEP : </b> {{ $kunjungan->no_sep ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 border border-dark">
                            <b>Ringkasan Perawatan : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->ringkasan_perawatan ?? '....' }}</pre>
                            <b>Riwayat Penyakit : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->riwayat_penyakit ?? '....' }}</pre>
                            <b>Indikasi Rawat Inap : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->indikasi_ranap ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pemeriksaan Fisik : </b><br>
                            <b>Suhu Badan : </b> {{ $kunjungan->erm_ranap->suhu ?? '....' }} Celcius &emsp;
                            <b>Tekanan Darah : </b> {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }} mmHg &emsp;
                            <b>Denyut Nadi : </b> {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }} xs &emsp;
                            <b>Pernapasan : </b> {{ $kunjungan->erm_ranap->pernapasan ?? '....' }} xs &emsp;
                            <b>Berat Badan Bayi : </b> {{ $kunjungan->erm_ranap->berat_badan ?? '....' }} kg &emsp;
                            <br>
                            <pre>{{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pemeriksaan Laboratorium : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->catatan_laboratorium ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pemeriksaan Radiologi : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->catatan_radiologi ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pemeriksaan Penunjang Lainnya : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->catatan_penunjang ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pemeriksaan SHK : </b> &emsp;
                            Dilakukan :
                            @if ($kunjungan->erm_ranap->pemeriksaan_shk == 'Ya')
                                &#x1F5F9; Ya
                            @else
                                &#x25A2; Ya
                            @endif/
                            @if ($kunjungan->erm_ranap->pemeriksaan_shk == 'Tidak')
                                &#x1F5F9; Tidak
                            @else
                                &#x25A2; Tidak
                            @endif &emsp;
                            Diambil dari :
                            @if ($kunjungan->erm_ranap->pengambilan_shk == 'Tumit')
                                &#x1F5F9; Tumit
                            @else
                                &#x25A2; Tumit
                            @endif/
                            @if ($kunjungan->erm_ranap->pengambilan_shk == 'Vena')
                                &#x1F5F9; Vena
                            @else
                                &#x25A2; Vena
                            @endif&emsp;
                            Tgl Pengambilan :
                            {{ \Carbon\Carbon::parse($kunjungan->erm_ranap->tanggal_shk)->format('d F Y') ?? '....' }}
                            &emsp;
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Hasil Konsultasi : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->hasil_konsultasi ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Diagnosa Masuk : </b><br>
                            <pre>{{ $kunjungan->erm_ranap->diagnosa_masuk ?? '....' }}</pre>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <div class="row">
                                <div class="col-md-8">
                                    <b>Diagnosa Utama : </b><br>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_utama ?? '....' }}</pre>
                                </div>
                                <div class="col-md-4">
                                    <b>ICD 10</b><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <div class="row">
                                <div class="col-md-8">
                                    <b>Diagnosa Sekunder : </b><br>
                                    <pre>{{ $kunjungan->erm_ranap->diagnosa_sekunder ?? '....' }}</pre>
                                </div>
                                <div class="col-md-4">
                                    <b>ICD 10</b><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <div class="row">
                                <div class="col-md-8">
                                    <b>Tindakan Operasi :</b><br>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_operasi ?? '....' }}</pre>
                                </div>
                                <div class="col-md-4">
                                    <b>ICD 9 CM</b><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Tgl Operasi : </b>{{ $kunjungan->erm_ranap->tanggal_operasi ?? '....' }}&emsp;
                            <b>Waktu Mulai : </b>{{ $kunjungan->erm_ranap->awal_operasi ?? '....' }}&emsp;
                            <b>Waktu Selesai : </b>{{ $kunjungan->erm_ranap->akhir_operasi ?? '....' }}&emsp;
                        </div>
                        <div class="col-md-12  border border-dark">
                            <div class="row">
                                <div class="col-md-8">
                                    <b>Tindakan / Prosedur :</b><br>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_prosedur ?? '....' }}</pre>
                                </div>
                                <div class="col-md-4">
                                    <b>ICD 9 CM</b><br>
                                    <pre>{{ $kunjungan->erm_ranap->tindakan_icd9 ?? '-' }}</pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pasang Ventilator</b>&emsp;
                            <b>Waktu Intubasi : </b> .... WIB&emsp;
                            <b>Waktu Extubasi : </b> .... WIB&emsp;
                        </div>
                        <div class="col-md-12  border border-dark">
                            <b>Pengobatan Selama Dirawat :</b> <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <table>
                                        <thead>
                                            <tr class="border-bottom border-dark">
                                                <th>Nama Obat</th>
                                                {{-- <th>Jml</th>
                                                <th>Aturan Pakai</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obat2[0] as $item)
                                                <tr class="border-bottom border-dark">
                                                    <td>{{ $item['nama_barang'] }} </td>
                                                    {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                                                    <td>{{ $item['aturan_pakai'] }} </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table>
                                        <thead>
                                            <tr class="border-bottom border-dark">
                                                <th>Nama Obat</th>
                                                {{-- <th>Jml</th>
                                                <th>Aturan Pakai</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obat2[1] as $item)
                                                <tr class="border-bottom border-dark">
                                                    <td>{{ $item['nama_barang'] }} </td>
                                                    {{-- <td>{{ $item['jumlah_layanan'] }} {{ $item['satuan_barang'] }}</td>
                                                    <td>{{ $item['aturan_pakai'] }} </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4  border border-dark">
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
                        <div class="col-md-4  border border-dark">
                            <b>Kondisi Pulang :</b><br>
                            <pre>{{ $kunjungan->erm_ranap->kondisi_pulang ?? '....' }}</pre>
                            <b>Keadaan Umum :</b><br>
                            <pre>{{ $kunjungan->erm_ranap->kondisi_umum ?? '....' }}</pre>
                            <b>Kesadaran :</b> {{ $kunjungan->erm_ranap->kesadaran ?? '....' }}<br>
                            <b>Tekanan Darah :</b> {{ $kunjungan->erm_ranap->tensi_darah ?? '....' }}<br>
                            <b>Nadi :</b> {{ $kunjungan->erm_ranap->denyut_nadi ?? '....' }}<br>
                        </div>
                        <div class="col-md-4  border border-dark">
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
                            <b>Instruksi Pulang :</b><br>
                            <pre>{{ $kunjungan->erm_ranap->instruksi_pulang ?? '....' }}</pre>
                            <b>Tgl Kontrol : </b> {{ $kunjungan->erm_ranap->tanggal_kontrol ?? '....' }} &emsp;
                            <b>Kontrol Ke : </b>{{ $kunjungan->erm_ranap->kontrol_ke ?? '....' }}<br>
                            <b>Diet : </b> {{ $kunjungan->erm_ranap->diet ?? '....' }}<br>
                            <b>Latihan : </b> {{ $kunjungan->erm_ranap->latihan ?? '....' }}<br>
                        </div>
                        <div class="col-md-6  border border-dark">
                            <b>Segera kembali ke Rumah Sakit, langsung ke IGD jika terjadi :</b><br>
                            {{ $kunjungan->erm_ranap->kembali_jika ?? '....' }}
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

        </div>
    </div>
    <footer>Halaman
        <span class="page-number"></span>
    </footer>
@stop
@section('css')
    <style>
        @media print {
            body {
                counter-reset: page;
                size: A4;
                margin-bottom: 60px;
            }

            .page-number::before {
                counter-increment: page;
                content: "Page " counter(page);
            }

            /* Tambahkan gaya lainnya sesuai kebutuhan */
            footer {
                z-index: 2;
                position: fixed;
                height: 50px;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                padding: 5px;
                border-top: 1px solid #ddd;
            }
        }
    </style>
    <style>
        pre {
            border: none;
            outline: none;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 13px;
        }

        dd {
            margin-bottom: 0 !important;
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
            font-size: 13px;
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
