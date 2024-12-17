@extends('layouts_erm.app')
@push('style')
@endpush
@section('content')
    <div class="col-12">
        <div class="card" style="font-size: 12px;">
            <div class="card-header p-2">
                <ul class="nav nav-pills" style="font-size: 14px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="#resume-kepulangan-pasien" data-toggle="tab">CODER RINGKASAN PASIEN
                            PULANG</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content ">
                    <div class="tab-pane active" id="resume-kepulangan-pasien">
                        <form action="{{ route('casemix-resume.coder-diagnosa.store') }}" name="formEvaluasiMPPA"
                            id="formEvaluasiMPPA" method="POST">
                            @csrf
                            <input type="hidden" name="kunjungan_counter"
                                value="{{ $resume->kode_kunjungan . '|' . $resume->counter }}">
                            <input type="hidden" name="kode" value="{{ $resume->kode_kunjungan }}">
                            <input type="hidden" name="rm" value="{{ $resume->rm }}">
                            <input type="hidden" name="id_resume" value="{{ $resume->id }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">FORM CODER RINGKASAN PASIEN PULANG</h3>
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
                                                        <td>
                                                            <strong style="margin: 0.5rem 0;">Diagnosa Masuk</strong>
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" name="diagnosa_masuk" class="form-control"
                                                                value="{{ $resume->diagnosa_masuk ?? '' }}" readonly>
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
                                                                                    <div class="col-12">
                                                                                        Diagnosa Utama Dokter:
                                                                                        <input type="text"
                                                                                            name="diagnosa_utama_dokter"
                                                                                            id="diagnosa_utama_dokter"
                                                                                            class="form-control"
                                                                                            value="{{ $resume->diagnosa_utama_dokter ?? '' }}"
                                                                                            readonly>
                                                                                    </div>
                                                                                </td>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12 row mt-1">
                                                                                        <div class="col-8">
                                                                                            Cari ICD10 Untuk Diagnosa Utama:
                                                                                            <input type="text"
                                                                                                name="cari_icd10utama"
                                                                                                id="cari_icd10utama"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <button type="button"
                                                                                                class="btn btn-md btn-primary col-12 mt-3"
                                                                                                id="btn-cari-icd10">Cari</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 row mt-1">
                                                                                        <div class="col-12">
                                                                                            Diagnosa Terpilih:
                                                                                            <input type="text"
                                                                                                name="diagnosa_utama_casemix"
                                                                                                id="diagnosa_utama_casemix"
                                                                                                class="form-control"
                                                                                                value="{{$resume->diagnosa_utama}}"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12">
                                                                                        @if (!empty($resume) && !empty($resume->diagnosa_sekunder_dokter))
                                                                                            @php
                                                                                                $sekunder = explode(
                                                                                                    '|',
                                                                                                    $resume->diagnosa_sekunder_dokter,
                                                                                                );
                                                                                            @endphp
                                                                                            <table
                                                                                                class="table table-bordered"
                                                                                                id="sekunder-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Diagnosa
                                                                                                            Sekunder Dokter
                                                                                                        </th>
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
                                                                                                        </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        @endif
                                                                                    </div>
                                                                                </td>
                                                                                <td style=" padding: 10px;">
                                                                                    <div class="col-12 row mt-1">
                                                                                        <div class="col-8">
                                                                                            Cari ICD Diagnosa Sekunder :
                                                                                            <input type="text"
                                                                                                name="cari_icd10sekunder"
                                                                                                id="cari_icd10sekunder"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <button type="button"
                                                                                                class="btn btn-md btn-primary mt-3"
                                                                                                id="btn-cari-icd10sekunder">Cari</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 row mt-2">
                                                                                        <div class="col-12">
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
                                                                                                <tbody>
                                                                                                    @forelse ($resume->diagnosaSekunder as $diagSekunder)
                                                                                                        <tr
                                                                                                            data-kode="{{ $diagSekunder->kode }}">
                                                                                                            <td>{{ $diagSekunder->diagnosa }}
                                                                                                            </td>
                                                                                                            <td>{{ $diagSekunder->kode_diagnosa }}
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <button
                                                                                                                    class="btn btn-sm btn-danger hapus-diagnosa"
                                                                                                                    data-id="{{ $diagSekunder->id }}">Hapus</button>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @empty
                                                                                                        
                                                                                                    @endforelse
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="hiddenDiagnosaData">
                                                                                        <!-- Di sini kita akan menambahkan input tersembunyi untuk data diagnosa -->
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
                                                            <div class="col-12">
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
                                                            <div class="col-12 mt-1">
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
                                                                        @forelse ($resume->tindakanOperasiCodes as $operasi)
                                                                            <tr data-kode="{{ $operasi->kode }}">
                                                                                <td>{{$operasi->nama_tindakan}}</td>
                                                                                <td>{{$operasi->kode_tindakan}}</td>
                                                                                <td>
                                                                                    <button class="btn btn-sm btn-danger hapus-tindakan">Hapus</button>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="hiddenTindakanData">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                                                            <div class="col-12 row mt-1">
                                                                @if (!empty($resume) && !empty($resume->tindakan_prosedure))
                                                                    @php
                                                                        $tindakanProsedure = explode(
                                                                            '|',
                                                                            $resume->tindakan_prosedure,
                                                                        );
                                                                        $prosedure_str = implode(
                                                                            '|',
                                                                            $tindakanProsedure,
                                                                        );
                                                                    @endphp

                                                                    <input type="hidden" name="tindakan_prosedure_update"
                                                                        id="tindakan_prosedure_update"
                                                                        value="{{ $prosedure_str }}">

                                                                    <table class="table table-bordered"
                                                                        id="prosedure-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tindakan Prosedure Yang Sudah
                                                                                    Dipilih</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tindakan-prosedure-table-body">
                                                                            @foreach ($tindakanProsedure as $index => $prosedure)
                                                                                <tr
                                                                                    id="row-prosedure-{{ $index }}">
                                                                                    <td
                                                                                        style="margin: 0; padding:2px; padding-left:10px;">
                                                                                        {{ $prosedure }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-12 row mt-1">
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        name="cari_icd9_tindakanprosedure"
                                                                        id="cari_icd9_tindakanprosedure"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-4">
                                                                    <button type="button" class="btn btn-md btn-primary"
                                                                        id="btn-cari-icd9tindakan-prosedure">Cari</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 row mt-2">
                                                                <div class="col-12">
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
                                                                            @forelse ($resume->tindakanProsedureCodes as $prosedure)
                                                                            <tr data-kode="{{ $prosedure->kode }}">
                                                                                <td>{{$prosedure->nama_procedure}}</td>
                                                                                <td>{{$prosedure->kode_procedure}}</td>
                                                                                <td>
                                                                                    <button class="btn btn-sm btn-danger hapus-prosedure">Hapus</button>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            
                                                                        @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div id="hiddenTindakanProsedureData">
                                                                <!-- Di sini kita akan menambahkan input tersembunyi untuk data diagnosa -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions col-12 text-right">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="hasil-resume">

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
                $('#diagnosa_utama_casemix').val(namaDiagnosa);

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
    </script>
    <script>
        // Fungsi untuk menambah baris baru
        function addRowDiagSekunderDokter() {
            // Mendapatkan referensi ke tbody
            const tbody = document.querySelector('#diagsekunder-dokter-table tbody');

            // Membuat baris baru
            const newRow = document.createElement('tr');

            // Menambahkan input dan tombol hapus ke baris baru
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="diag_sekunder_dokter[]"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowDiagSekunderDokter(this)">Hapus</button></td>
            `;

            // Menambahkan baris baru ke tbody
            tbody.appendChild(newRow);
        }

        // Fungsi untuk menghapus baris
        function removeRowDiagSekunderDokter(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
    <script>
        // Fungsi untuk menambah baris baru
        function addRowTindakanOperasiDokter() {
            // Mendapatkan referensi ke tbody
            const tbody = document.querySelector('#tindakanoperasi-dokter-table tbody');

            // Membuat baris baru
            const newRow = document.createElement('tr');

            // Menambahkan input dan tombol hapus ke baris baru
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="tindakan_operasi_dokter[]"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowTindakanOperasiDokter(this)">Hapus</button></td>
            `;

            // Menambahkan baris baru ke tbody
            tbody.appendChild(newRow);
        }

        // Fungsi untuk menghapus baris
        function removeRowTindakanOperasiDokter(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
    <script>
        // Fungsi untuk menambah baris baru
        function addRowTindakanProsedureDokter() {
            // Mendapatkan referensi ke tbody
            const tbody = document.querySelector('#tindakanprosedure-dokter-table tbody');

            // Membuat baris baru
            const newRow = document.createElement('tr');

            // Menambahkan input dan tombol hapus ke baris baru
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="tindakan_prosedure_dokter[]"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRowTindakanProsedureDokter(this)">Hapus</button></td>
            `;

            // Menambahkan baris baru ke tbody
            tbody.appendChild(newRow);
        }

        // Fungsi untuk menghapus baris
        function removeRowTindakanProsedureDokter(button) {
            const row = button.closest('tr');
            row.remove();
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
