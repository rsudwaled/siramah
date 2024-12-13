@extends('layouts_erm.app')
@push('style')
    <style>
        #loadingSpinner {
            display: none !important;
            /* Ensure it's hidden by default */
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">RM: {{ $pasien->no_rm }} || {{ $pasien->nama_px }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('pasienRanapAktif') }}" class="btn btn-sm btn-danger">Kembali</a>
                        <button class="btn btn-sm btn-warning">
                            Total Bayar: {{ money($grandTotal, 'IDR') }}
                        </button>
                        <button type="button" onclick="getRincianBiaya()" class="btn btn-tool"
                            data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <div class="row" style="font-size: 12px;">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4 m-0">Nama</dt>
                                        <dd class="col-sm-8 m-0">{{ $pasien->nama_px }} ({{ $pasien->jenis_kelamin }})</dd>
                                        <dt class="col-sm-4 m-0">No RM</dt>
                                        <dd class="col-sm-8 m-0">{{ $pasien->no_rm }}</dd>
                                        <dt class="col-sm-4 m-0">NIK</dt>
                                        <dd class="col-sm-8 m-0">{{ $pasien->nik_bpjs }}</dd>
                                        <dt class="col-sm-4 m-0">No BPJS</dt>
                                        <dd class="col-sm-8 m-0">{{ $pasien->no_Bpjs }}</dd>
                                        <dt class="col-sm-4 m-0">Tgl Lahir</dt>
                                        <dd class="col-sm-8 m-0">
                                            {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('Y-m-d') }} (
                                            @if (\Carbon\Carbon::parse($pasien->tgl_lahir)->age)
                                                {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} tahun
                                            @else
                                                {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInDays(now()) }} hari
                                            @endif
                                            )
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4 m-0">Tgl Masuk</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_masuk }}</dd>
                                        <dt class="col-sm-4 m-0">Alasan Masuk</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_masuk->alasan_masuk }}</dd>
                                        <dt class="col-sm-4 m-0">Ruangan / Kls</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->unit->nama_unit }} /
                                            {{ $kunjungan->kelas }}</dd>
                                        <dt class="col-sm-4 m-0">Dokter DPJP</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->dokter->nama_paramedis }}</dd>
                                        <dt class="col-sm-4 m-0">Penjamin</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->penjamin_simrs->nama_penjamin }}
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4 m-0">No SEP</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->no_sep }}</dd>
                                        <dt class="col-sm-4 m-0">Tarif RS</dt>
                                        <dd class="col-sm-8 m-0"> Rp. <span class="biaya_rs_html">-</span></dd>
                                        <dt class="col-sm-4 m-0">Tarif E-Klaim</dt>
                                        <dd class="col-sm-8 m-0">Rp. <span class="tarif_eklaim_html">-</span></dd>
                                        <dt class="col-sm-4 m-0">Groupping</dt>
                                        <dd class="col-sm-8 m-0"><span class="code_cbg_html">-</span></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-4 m-0">Status</dt>
                                        <dd class="col-sm-8 m-0">
                                            @if ($kunjungan->status_kunjungan == 1)
                                                <span
                                                    class="badge badge-success">{{ $kunjungan->status->status_kunjungan }}</span>
                                            @else
                                                <span
                                                    class="badge badge-danger">{{ $kunjungan->status->status_kunjungan }}</span>
                                            @endif
                                        </dd>
                                        <dt class="col-sm-4 m-0">Tgl Keluar</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_keluar ?? '-' }}</dd>
                                        <dt class="col-sm-4 m-0">Alasan Pulang</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_pulang->alasan_pulang ?? '-' }}</dd>
                                        <dt class="col-sm-4 m-0">Surat Kontrol</dt>
                                        <dd class="col-sm-8 m-0">{{ $kunjungan->surat_kontrol->noSuratKontrol ?? '-' }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" id="rincian_biaya">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header" style="background-color: #001f3f;">
                            <h3 class="card-title">Riwayat Pasien</h3>
                        </div>
                        <div class="card-body" style="max-height: 350px; overflow-y: auto; margin-top:-5px;">
                            <small><strong>RIWAYAT KUNJUNGAN</strong></small>
                            @foreach ($riwayatKunjungan as $riwayat)
                                <button
                                    class="btn {{ $riwayat->status_kunjungan == '1' ? 'btn-success' : 'btn-secondary' }} btn-flat btn-sm btn-block mb-1 btn-modal-riwayatpoli"
                                    style="text-align: left;" 
                                    data-toggle="modal"
                                    data-target="#modal-{{ $riwayat->kode_kunjungan }}"
                                    data-kode-kunjungan-riwayat="{{ $riwayat->kode_kunjungan }}">
                                    {{ Carbon\Carbon::parse($riwayat->tgl_masuk)->format('d-m-Y') }}
                                    <span
                                        class="badge {{ $riwayat->status_kunjungan == '1' ? 'bg-light' : 'bg-gray-dark' }} disabled color-palette">
                                        <small>{{ $riwayat->status->status_kunjungan }}</small>
                                    </span>
                                    <br> {{ $riwayat->unit->nama_unit }} | {{ $riwayat->kode_kunjungan }}
                                </button>

                                <div class="modal fade" 
                                    id="modal-{{ $riwayat->kode_kunjungan }}" 
                                    aria-hidden="true"
                                    tabindex="-1" 
                                    role="dialog" 
                                    aria-labelledby="modalLabel" 
                                    data-backdrop="static"
                                    data-keyboard="false">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">RIWAYAT {{ $riwayat->unit->nama_unit }}</h4>
                                            </div>
                                            <div class="modal-body" id="modal-body-{{ $riwayat->kode_kunjungan }}">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Tindakan</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="tindakan-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Obat</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="obat-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Asesmen</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="asesmen-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer float-right">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr style="color:2px solid rgb(94, 94, 94);">
                            <small><strong>RIWAYAT PENUNJANG</strong></small>
                            <button class="btn btn-flat btn-sm btn-block text-white"
                                style="text-align: left; background-color:#5c5a90;" id="btn-radiologi"
                                data-no_rm="{{ $pasien->no_rm }}" data-toggle="modal"
                                data-target="#modal-radiologi">Radiologi</button>
                            <button class="btn btn-flat btn-sm btn-block text-white" id="btn-patologi" data-toggle="modal"
                                data-target="#modal-labpatologi"
                                style="text-align: left; background-color:#5c5a90;">Patologi</button>
                            <button class="btn btn-flat btn-sm btn-block text-white" id="btn-berkas-file"
                                style="text-align: left; background-color:#5c5a90;" data-toggle="modal"
                                data-target="#modal-berkas">Berkas</button>
                        </div>
                        <div class="card-body">
                            <h6>Tombol Aksi</h6>
                            <button type="button" data-targeteksternal="rekonsiliasi-obat"
                                data-norm="{{ $kunjungan->no_rm }}" data-kode="{{ $kunjungan->kode_kunjungan }}"
                                class="btn btn-primary btn-sm btn-eksternal btn-block">Rekonsiliasi Obat</button>
                            <button type="button" data-targeteksternal="kpo"
                                class="btn btn-success btn-sm btn-eksternal btn-block">KPO Elektronik</button>
                            <button type="button" data-targeteksternal="grouping"
                                class="btn btn-success btn-sm btn-block btn-eksternal">Grouping</button>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pemulangan Pasien</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-outline-danger btn-block btn-resume-pemulangan"
                                data-target="resume-pemulangan" data-kode="22488001" data-norm="01002765">Resume
                                Pemulangan</button>
                            <button type="button" class="btn btn-outline-danger btn-block btn-suratkontrol" data-target="surat-kontrol"
                                data-kode="{{ $kunjungan->kode_kunjungan }}">Surat Kontrol</button>
                            <button type="button" class="btn btn-outline-danger btn-block"
                                data-target="assesmen-kebutuhan-edukasi"
                                data-kode="{{ $kunjungan->kode_kunjungan }}">Asesmen
                                Edukasi</button>
                            <button type="button" class="btn btn-outline-danger btn-block"
                                data-target="assesmen-pra-anastesi" data-kode="{{ $kunjungan->kode_kunjungan }}">Asesmen
                                Pra-Anastesi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-md"></i></span>

                        <button class="info-box-content btn-asesmen-awal"
                            style="background: none; border: none; outline: none;" data-target="assesmen-awal-medis"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">
                            <span class="info-box-text">Asesmen</span>
                            <span class="info-box-number">Awal</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-signature"></i></span>
                        <button class="info-box-content btn-cppt-konsultasi"
                            style="background: none; border: none; outline: none;" data-target="cppt"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">
                            <span class="info-box-text">CPPT</span>
                            <span class="info-box-number">& Konsultasi</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-contract"></i></span>
                        <button class="info-box-content btn-catatan-mppa"
                            style="background: none; border: none; outline: none;" data-target="catatan-mpp-a"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">
                            <span class="info-box-text">Catatan</span>
                            <span class="info-box-number">MPPA</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice"></i></span>
                        <button class="info-box-content btn-catatan-mppb"
                            style="background: none; border: none; outline: none;" data-target="catatan-mpp-b"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">
                            <span class="info-box-text">Catatan</span>
                            <span class="info-box-number">MPPB</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-navy disabled color-palette elevation-1"><i
                                class="fas fa-tasks"></i></span>
                        <button class="info-box-content btn-rencana-asuhan-terpadu"
                            style="background: none; border: none; outline: none;" data-target="rencana-asuhan-terpadu"
                            data-norm="{{ $kunjungan->no_rm }}" data-kode="{{ $kunjungan->kode_kunjungan }}">
                            <span class="info-box-text">Rencana</span>
                            <span class="info-box-number">Asuhan Terpadu</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="welcome_view" id="welcome_view">
                @include('simrs.erm-ranap.petunjuk_penggunaan.dokter')
            </div>
            <div id="content_penunjang">
                <!-- Konten default atau yang dimuat melalui AJAX akan tampil di sini -->
            </div>
            <div id="content_erm">
                <!-- Konten default atau yang dimuat melalui AJAX akan tampil di sini -->
            </div>
            <div id="content_eksternal">
                <!-- Konten default atau yang dimuat melalui AJAX akan tampil di sini -->
            </div>
        </div>
    </div>
    @include('simrs.erm-ranap.dashboard.component_modal.modal_radiologi')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_lab_patologi')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_berkas')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_view_rongsen')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_view_expertise')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_view_patologi')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_view_berkas_file')
    
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="{{ asset('style-erm/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Cache selectors
            const $contentErm = $('#content_erm');
            const $contentPenunjang = $('#content_penunjang');
            // Event handler untuk btn-outline-primary dan btn-penunjang
            $(document).on('click',
                '.btn-outline-primary, .btn-penunjang, .btn-kpo, .btn-asesmen-awal, .btn-cppt-konsultasi, .btn-catatan-mppa, .btn-catatan-mppb, .btn-rencana-asuhan-terpadu, .btn-resume-pemulangan, .btn-suratkontrol',
                function() {
                    const $button = $(this);
                    const target = $button.data('target') || $button.data('targetpenujang');
                    const kode = $button.data('kode');
                    const no_rm = $button.data('norm');
                    const type = $button.hasClass('btn-penunjang') ? 'penunjang' : 'erm-ranap';
                    const url = getUrl(target, type, kode, no_rm);

                    // Pilih div yang sesuai berdasarkan tombol
                    const targetDiv = type === 'penunjang' ? $contentPenunjang : $contentErm;

                    loadContent(url, targetDiv);
                    $('#welcome_view').hide();
                });

            // Fungsi untuk mendapatkan URL dinamis berdasarkan target
            function getUrl(target, type, kode = '', no_rm = '') {
                const urlMap = {
                    'erm-ranap': {
                        'surat-kontrol': "{{ route('dashboard.erm-ranap.surat-kontrol.create') }}",
                        'resume-pemulangan': "{{ route('dashboard.erm-ranap.resume-pemulangan.resume') }}",
                        'rencana-asuhan-terpadu': "{{ route('dashboard.erm-ranap.penunjang.rencana-asuhan-terpadu') }}",
                        'assesmen-awal-medis': "{{ route('dashboard.erm-ranap.assesmen-awal-medis') }}",
                        'assesmen-kebutuhan-edukasi': "{{ route('dashboard.erm-ranap.assesmen-kebutuhan-edukasi') }}",
                        'cppt': "{{ route('dashboard.erm-ranap.konsultasi') }}",
                        'assesmen-pra-anastesi': "{{ route('dashboard.erm-ranap.assesmen-pra-anastesi') }}",
                        'informasi-tindakan': "{{ route('dashboard.erm-ranap.informasi-tindakan') }}",
                        'catatan-mpp-a': "{{ route('dashboard.erm-ranap.catatan-mpp-a') }}",
                        'catatan-mpp-b': "{{ route('dashboard.erm-ranap.catatan-mpp-b') }}",
                        'dashboard': "{{ route('dashboard.erm-ranap.dashboard') }}"
                    },
                    'penunjang': {
                        'data-penunjang': "{{ route('dashboard.erm-ranap.penunjang.get-penunjang') }}",
                        'data-riwayat-poliklinik': "{{ route('dashboard.erm-ranap.penunjang.riwayat-poliklinik') }}",
                        'kpo': "{{ route('dashboard.erm-ranap.penunjang.kpo-elektronik') }}",
                    }
                };

                const url = urlMap[type][target] || urlMap[type]['dashboard'];

                // Tambahkan parameter kode atau no_rm jika ada
                const params = [];
                if (kode) params.push("kode=" + encodeURIComponent(kode));
                if (no_rm) params.push("no_rm=" + encodeURIComponent(no_rm));

                return params.length ? url + '?' + params.join('&') : url;
            }

            // Fungsi untuk memuat konten ke dalam div yang ditentukan
            function loadContent(url, targetDiv) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        targetDiv.html(data);
                    },
                    error: function() {
                        targetDiv.html('<p>Error loading content. Please try again later.</p>');
                    }
                });
            }
        });

        $(document).ready(function() {
            // Cache selectors
            const $contentEksternal = $('#content_eksternal');
            // Event listener for buttons with class .btn-eksternal
            $(document).on('click', '.btn-eksternal', function() {
                const $button = $(this);
                const target = $button.data('targeteksternal');
                const kode = $button.data('kode');
                const no_rm = $button.data('norm');
                const url = getUrl(target, kode, no_rm);

                loadContent(url, $contentEksternal);
                $('#welcome_view').hide();
            });

            // Function to get URL based on target
            function getUrl(target, kode = '', no_rm = '') {
                const urlMap = {
                    'rekonsiliasi-obat': "{{ route('dashboard.erm-ranap.penunjang.rekonsiliasi-obat') }}",
                    'kpo': "{{ route('dashboard.erm-ranap.penunjang.kpo-elektronik') }}",
                    'grouping': "{{ route('dashboard.erm-ranap.penunjang.grouping') }}"
                };

                let url = urlMap[target] || '';

                // Append parameters if the URL is valid
                if (url) {
                    const params = new URLSearchParams();
                    if (kode) params.append('kode', kode);
                    if (no_rm) params.append('no_rm', no_rm);
                    url += '?' + params.toString();
                }

                return url;
            }

            // Function to load content into the specified div
            function loadContent(url, targetDiv) {
                if (!url) {
                    targetDiv.html('<p>Invalid URL.</p>');
                    return;
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        targetDiv.html(data);
                    },
                    error: function() {
                        targetDiv.html('<p>Error loading content. Please try again later.</p>');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.tutup-tab-penunjang', function() {
            $('.card-penunjang').hide();
        });
        $(document).on('click', '.tutup-tab-rekonsiliasi-obat', function() {
            $('.rekonsiliasi-obat').hide();
        });
        $(document).on('click', '.tutup-tab-rencana-asuhan', function() {
            $('.card-rencana-asuhan').hide();
        });
        $(document).on('click', '.tutup-tab-riwayat-poliklinik', function() {
            $('.card-riwayat-poliklinik').hide();
        });
    </script>
    <script>
        var urlRoute = "{{ route('dashboard.erm-ranap.riwayat.details', ':kode_kunjungan') }}";
        $('.btn-modal-riwayatpoli').on('click', function() {
            var kode_kunjungan = $(this).data('kode-kunjungan-riwayat');
            var finalUrl = urlRoute.replace(':kode_kunjungan', kode_kunjungan);
            $.ajax({
                url: finalUrl, // URL untuk mengambil data
                method: 'GET', // Metode GET untuk mengambil data
                beforeSend: function() {
                    // Menambahkan elemen loading ke dalam setiap tabel sebelum melakukan request
                    $('#tindakan-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                    $('#obat-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                    $('#asesmen-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                },
                success: function(data) {
                    console.log(data);

                    // Membuat HTML untuk tabel tindakan
                    var tindakanHtml =
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th><th>KODE KUNJUNGAN</th></tr></thead><tbody>';
                    $.each(data.tindakan, function(index, item) {
                        tindakanHtml += '<tr><td>' + item.NAMA_TARIF + '</td><td>' + item
                            .kode_kunjungan + '</td></tr>';
                    });
                    tindakanHtml += '</tbody></table>';

                    // Membuat HTML untuk tabel obat
                    var obatHtml =
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th><th>QTY</th><th>Aturan Pakai</th></tr></thead><tbody>';
                    $.each(data.obat, function(index, item) {
                        obatHtml += '<tr><td>' + item.nama_barang + '</td><td>' + item.qty + '</td><td>' + item.aturan_pakai + '</td></tr>';
                    });
                    obatHtml += '</tbody></table>';

                    // Membuat HTML untuk tabel asesmen
                    var asesmenHtml =
                        '<table class="table table-bordered"><thead><tr><th>LEMON</th><th>alergi</th><th>anamnesa</th><th>anjuran</th><th>asthma</th><th>beratbadan</th><th>diagnosakerja</th><th>frekuensi_nadi</th><th>frekuensi_nafas</th><th>keadaanumum</th><th>keluhan_pasien</th><th>keterangan_alergi</th><th>keterangan_kesadaran</th><th>riwayat_alergi</th><th>riwayat_kehamilan_pasien_wanita</th><th>riwyat_kelahiran_pasien_anak</th><th>riwyat_penyakit_sekarang</th><th>tekanan_darah</th><th>tindak_lanjut</th></tr></thead><tbody>';
                    $.each(data.asesmenRajal, function(index, item) {
                        asesmenHtml += '<tr><td>LEMON</td><td>' + item.alergi + '</td><td>' +
                            item.anamnesa + '</td><td>' + item.anjuran + '</td><td>' + item
                            .astdma + '</td><td>' + item.beratbadan + '</td><td>' + item
                            .diagnosakerja + '</td><td>' + item.frekuensi_nadi + '</td><td>' +
                            item.frekuensi_nafas + '</td><td>' + item.keadaanumum +
                            '</td><td>' + item.keluhan_pasien + '</td><td>' + item
                            .keterangan_alergi + '</td><td>' + item.keterangan_kesadaran +
                            '</td><td>' + item.riwayat_alergi + '</td><td>' + item
                            .riwayat_kehamilan_pasien_wanita + '</td><td>' + item
                            .riwyat_kelahiran_pasien_anak + '</td><td>' + item
                            .riwyat_penyakit_sekarang + '</td><td>' + item.tekanan_darah +
                            '</td><td>' + item.tindak_lanjut + '</td></tr>';
                    });
                    asesmenHtml += '</tbody></table>';

                    // Masukkan data ke dalam modal
                    $('#tindakan-' + kode_kunjungan).html(tindakanHtml);
                    $('#obat-' + kode_kunjungan).html(obatHtml);
                    $('#asesmen-' + kode_kunjungan).html(asesmenHtml);
                },
                error: function() {
                    // Jika terjadi kesalahan, tampilkan pesan error
                    $('#tindakan-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                    $('#obat-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                    $('#asesmen-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                }
            });

        });
    
    </script>
    <script>
        $(document).ready(function() {
            $('#btn-radiologi').on('click', function() {
                var no_rm = $(this).data('no_rm');
                const urlRadiologi = "{{ route('dashboard.erm-ranap.dokters.penunjang-radiologi') }}";

                $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

                $.ajax({
                    url: urlRadiologi,
                    method: 'GET',
                    data: { no_rm: no_rm },
                    success: function(data) {
                        $('#radiologi-table-body').empty();
                        if (data.length > 0) {
                            $.each(data, function(index, radiologi) {
                                var row = '<tr>' +
                                            '<td>' + radiologi.tgl_masuk + '</td>' +
                                            '<td>' + radiologi.kode_kunjungan + '</td>' +
                                            '<td>' + radiologi.nama_px + '</td>' +
                                            '<td>' + radiologi.nama_unit + '</td>' +
                                            '<td>' + radiologi.pemeriksaan + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)" data-norm="' + radiologi.no_rm + '">Rontgen</button>' +
                                                '<button class="btn btn-xs btn-success" onclick="lihatExpertiseRad(this)" data-header="' + radiologi.header_id + '" data-detail="' + radiologi.detail_id + '">Expertise</button>' +
                                            '</td>' +
                                        '</tr>';
                                $('#radiologi-table-body').append(row);
                            });
                        } else {
                            $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>');
                        }
                    },
                    error: function() {
                        $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan dalam memuat data.</td></tr>');
                    }
                });
            });
            $('#btn-patologi').on('click', function() {
                var no_rm = $(this).data('no_rm');
                const urlRadiologi = "{{ route('dashboard.erm-ranap.dokters.penunjang-radiologi') }}";

                $('#patologi-table-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

                $.ajax({
                    url: urlRadiologi,
                    method: 'GET',
                    data: { no_rm: no_rm },
                    success: function(data) {
                        $('#patologi-table-body').empty();
                        if (data.length > 0) {
                            $.each(data, function(index, radiologi) {
                                var row = '<tr>' +
                                            '<td>' + radiologi.tgl_masuk + '</td>' +
                                            '<td>' + radiologi.kode_kunjungan + '</td>' +
                                            '<td>' + radiologi.nama_px + '</td>' +
                                            '<td>' + radiologi.nama_unit + '</td>' +
                                            '<td>' + radiologi.pemeriksaan + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)" data-norm="' + radiologi.no_rm + '">Rontgen</button>' +
                                                '<button class="btn btn-xs btn-success" onclick="lihatExpertiseRad(this)" data-header="' + radiologi.header_id + '" data-detail="' + radiologi.detail_id + '">Expertise</button>' +
                                            '</td>' +
                                        '</tr>';
                                $('#patologi-table-body').append(row);
                            });
                        } else {
                            $('#patologi-table-body').html('<tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>');
                        }
                    },
                    error: function() {
                        $('#patologi-table-body').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan dalam memuat data.</td></tr>');
                    }
                });
            });
            $('#btn-berkas-file').on('click', function() {
                var no_rm = $(this).data('no_rm');
                const urlFileBerkas = "{{ route('dashboard.erm-ranap.get-berkas-file') }}";

                $('#patologi-table-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

                $.ajax({
                    url: urlFileBerkas,
                    method: 'GET',
                    data: { no_rm: no_rm },
                    success: function(data) {
                        $('#patologi-file-table-body').empty();
                        $('#patologi-fileupload-table-body').empty();
                        if (data.length > 0) {
                            $.each(data, function(index, files) {
                                var row = '<tr>' +
                                            '<td>' + files.tanggalscan + '</td>' +
                                            '<td>' + files.norm + '</td>' +
                                            '<td>' + files.nama + '</td>' +
                                            '<td>' + files.namafile + '</td>' +
                                            '<td>' + files.jenisberkas + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-xs btn-primary" onclick="lihatFile(this)" data-fileurl="'+files.fileurl+'"><i class="fas fa-eye"></i></button>'
                                            '</td>' +
                                        '</tr>';
                                $('#patologi-file-table-body').append(row);
                            });
                            $.each(data, function(index, fileUpload) {
                                var row = '<tr>' +
                                            '<td>' + fileUpload.tgl_upload + '</td>' +
                                            '<td>' + fileUpload.no_rm + '</td>' +
                                            '<td>' + fileUpload.pasien.nama_px + '</td>' +
                                            '<td>' + fileUpload.nama_unit + '</td>' +
                                            '<td>' + fileUpload.nama + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-xs btn-primary" onclick="lihatFile(this)" data-fileurl="http://192.168.2.45/files/'+fileUpload.gambar+'"><i class="fas fa-eye"></i></button>'
                                            '</td>' +
                                        '</tr>';
                                $('#patologi-fileupload-table-body').append(row);
                            });
                        } else {
                            $('#patologi-file-table-body').html('<tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>');
                            $('#patologi-fileupload-body').html('<tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>');
                        }
                    },
                    error: function() {
                        $('#patologi-file-table-body').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan dalam memuat data.</td></tr>');
                        $('#patologi-fileupload-table-body').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan dalam memuat data.</td></tr>');
                    }
                });
            });
        });


        function showHasilLab(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.74/smartlab_waled/his/his_report?hisno=" + kode;
            $('#dataHasilLab').attr('src', url);
            $('#urlHasilLab').attr('href', url);
            $('#modalHasilLab').modal('show');
        }

        function lihatHasilRongsen(button) {
            var norm = $(button).data('norm');
            var url = "http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id=" + norm +
                "&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function lihatExpertiseRad(button) {
            var header = $(button).data('header');
            var detail = $(button).data('detail');
            var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                "&tgl_cetak={{ now()->format('Y-m-d') }}";
            $('#dataUrlExpertise').attr('src', url);
            $('#modalExpertise').modal('show');
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }

        function lihatFile(button) {
            var url = $(button).data('fileurl');
            $('#dataUrlFile').attr('src', url);
            $('#midalFileLihat').modal('show');
        }
    </script>
@endsection
@section('scripts')
    {{-- toast --}}
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
    {{-- gorupping --}}
    <script>
        $(function() {
            $('#kpoFrame').attr('src', 'http://192.168.2.125/kpoelektronik/');
        });

        function checkBayi() {
            if ($('#bayi').is(":checked"))
                $(".formbb").show();
            else
                $(".formbb").hide();
        }

        function checkCovid() {
            if ($('#covid').is(":checked"))
                $(".checkCovid").show();
            else
                $(".checkCovid").hide();
        }

        function checkTB() {
            if ($('#tb').is(":checked"))
                $(".checkTB").show();
            else
                $(".checkTB").hide();
        }

        function checkIcu() {
            if ($('#perawatan_icu').is(":checked")) {
                $(".masuk_icu").show();
                $(".checkVentilator").show();
                $(".pake_ventilator").hide();
            } else {
                $(".masuk_icu").hide();
                $(".checkVentilator").hide();
                $(".pake_ventilator").hide();
            }
        }

        function checkVenti() {
            if ($('#ventilator').is(":checked"))
                $(".pake_ventilator").show();
            else
                $(".pake_ventilator").hide();
        }
        // row select diagnosa
        $("#rowAdder").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text">' +
                '<i class="fas fa-diagnoses "></i></span></div>' +
                '<select name="diagnosa[]" class="form-control diagnosaID"></select>' +
                '<div class="input-group-append"><button type="button" class="btn btn-xs btn-danger" id="DeleteRow">' +
                '<i class="fas fa-trash "></i> Hapus</button></div>' +
                '</div></div></div>';
            $('#newinput').append(newRowAdd);
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_diagnosis_eclaim') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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

        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#row").remove();
        })
        // row select tindakan
        $("#rowAddTindakan").click(function() {
            newRowAdd =
                '<div id="row" class="row"><div class="col-md-7"><div class="form-group"><div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text">' +
                '<i class="fas fa-procedures "></i></span></div>' +
                '<select name="procedure[]" class="form-control procedure "></select></div></div></div>' +
                '<div class="col-md-3"><div class="form-group"><div class="input-group input-group-sm"><div class="input-group-prepend">' +
                '<span class="input-group-text"><b>@</b></span></div><input type="number" class="form-control" value="1">' +
                '</div></div></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" id="deleteRowTindakan"> ' +
                '<i class="fas fa-trash "></i> Hapus</button></div></div>';
            $('#newTindakan').append(newRowAdd);
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('get_procedure_eclaim') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            keyword: params.term // search term
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
        $("body").on("click", "#deleteRowTindakan", function() {
            $(this).parents("#row").remove();
        });
    </script>
    {{-- rincian biaya --}}
    <script>
        function lihatRincianBiaya() {
            $('#modalRincianBiaya').modal('show');
        }

        function getRincianBiaya() {
            var url =
                "{{ route('dashboard.erm-ranap.rincian-biaya') }}?norm={{ $kunjungan->no_rm }}&counter={{ $kunjungan->counter }}";
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                $('#rincian_biaya').html(data);
                $('#tableRincianBiaya').DataTable({
                    "paging": false,
                    "info": false,
                    "scrollCollapse": true,
                    "scrollY": '300px'
                });
            });
        }
    </script>
    {{-- Hasil Lab Penunjang --}}
    <script>
        function showHasilLab(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.74/smartlab_waled/his/his_report?hisno=" + kode;
            $('#dataHasilLab').attr('src', url);
            $('#urlHasilLab').attr('href', url);
            $('#modalHasilLab').modal('show');
        }

        function lihatHasilRongsen(button) {
            var norm = $(button).data('norm');
            var url = "http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id=" + norm +
                "&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function lihatExpertiseRad(button) {
            var header = $(button).data('header');
            var detail = $(button).data('detail');
            var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                "&tgl_cetak={{ now()->format('Y-m-d') }}";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }

        function lihatFile(button) {
            var url = $(button).data('fileurl');
            $('#dataUrlFile').attr('src', url);
            $('#midalFileLihat').modal('show');
        }
    </script>
@endsection
