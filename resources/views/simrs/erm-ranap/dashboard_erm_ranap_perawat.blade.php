@extends('layouts_erm.app')
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

        {{-- <div class="col-12 row mb-3">
            <div class="col-2">
                <button type="button" class="btn btn-block bg-gradient-info btn-sm">Riwayat Asesmen</button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-block bg-gradient-info btn-sm">Riwayat CPPT</button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-block bg-gradient-info btn-sm">Riwayat Tindakan</button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-block bg-gradient-info btn-sm">Riwayat Obat</button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-block bg-gradient-info btn-sm btn-penunjang"
                    data-norm="{{ $kunjungan->no_rm }}" data-kode="{{ $kunjungan->kode_kunjungan }}"
                    data-targetpenujang="data-penunjang">Riwayat Penunjang</button>
            </div>
        </div> --}}
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
                                <button class="btn btn-secondary btn-flat btn-sm btn-block mb-1" style="text-align: left;"
                                    data-toggle="modal" data-target="#modal-{{ $riwayat->kode_kunjungan }}"
                                    data-kode-kunjungan-riwayat="{{ $riwayat->kode_kunjungan }}">
                                    {{ Carbon\Carbon::parse($riwayat->tgl_masuk)->format('d-m-Y') }} <span
                                        class="badge bg-lightblue disabled color-palette"><small>{{ $riwayat->status->status_kunjungan }}</small></span>
                                    <br> {{ $riwayat->unit->nama_unit }}
                                </button>

                                <div class="modal fade" id="modal-{{ $riwayat->kode_kunjungan }}" aria-hidden="true"
                                    tabindex="-1" role="dialog" aria-labelledby="modalLabel" data-backdrop="static"
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
                            <button class="btn btn-flat btn-sm btn-block text-white" data-toggle="modal"
                                data-target="#modal-labpatologi"
                                style="text-align: left; background-color:#5c5a90;">Patologi</button>
                            <button class="btn btn-flat btn-sm btn-block text-white"
                                style="text-align: left; background-color:#5c5a90;" data-toggle="modal"
                                data-target="#modal-berkas">Berkas</button>
                        </div>
                        <div class="card-body">
                            <h6>Tombol Aksi</h6>
                            <button type="button" class="btn btn-info btn-block btn-cppt-perawat"
                                data-target="cppt-perawat" data-kode="{{ $kunjungan->kode_kunjungan }}">CPPT</button>
                            <button type="button" class="btn btn-primary btn-block" id="rencana-pemulangan-pasien"
                                data-target="rencana-pemulangan-pasien"
                                data-kode="{{ $kunjungan->kode_kunjungan }}">Rencana
                                Pulang</button>
                            <button type="button" data-targeteksternal="kpo"
                                class="btn btn-success btn-sm btn-eksternal btn-block">KPO Elektronik</button>
                            <button type="button" data-targeteksternal="grouping"
                                class="btn btn-success btn-sm btn-block btn-eksternal">Grouping</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky-top mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu Perawat</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-outline-primary btn-block" id="assesmen-awal-keperawatan"
                            data-target="assesmen-awal-keperawatan" data-kode="{{ $kunjungan->kode_kunjungan }}">Assesmen
                            Awal</button>
                        <button type="button" class="btn btn-outline-primary btn-block" id="implementasi-evaluasi"
                            data-target="implementasi-evaluasi" data-kode="{{ $kunjungan->kode_kunjungan }}">Implementasi
                            &
                            Evaluasi</button>
                        <button type="button" class="btn btn-outline-primary btn-block" data-target="lembar-edukasi"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">Lembar Edukasi</button>
                        <button type="button" class="btn btn-outline-primary btn-block" data-target="catatan-mpp-a"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">Catatan MPP A</button>
                        <button type="button" class="btn btn-outline-primary btn-block" data-target="catatan-mpp-b"
                            data-kode="{{ $kunjungan->kode_kunjungan }}">Catatan MPP B</button>
                        <hr style="color: #c9c9c9">

                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lainya</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" data-targeteksternal="kpo"
                            class="btn btn-success btn-sm btn-eksternal btn-block">KPO Elektronik</button>
                        <button type="button" data-targeteksternal="grouping"
                            class="btn btn-success btn-sm btn-block btn-eksternal">Grouping</button>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="col-md-10">
            <div id="content_penunjang">
                <!-- Konten default atau yang dimuat melalui AJAX akan tampil di sini -->
            </div>
            <div id="content_erm_perawat">
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
    <x-adminlte-modal id="modalRongsen" name="modalRongsen" title="Hasil Rontgen Pasien" theme="success"
        icon="fas fa-file-medical" size="lg">
        <iframe id="dataUrlRongsen" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="midalFileLihat" name="midalFileLihat" title="Lihat File Upload Rekam Medis" theme="success"
        icon="fas fa-file-medical" size="lg">
        <iframe id="dataUrlFile" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalLabPA" name="modalLabPA" title="Hasil Patologi Anatomi Pasien" theme="success"
        icon="fas fa-file-medical" size="lg">
        <iframe id="dataHasilLabPa" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <a href="" id="urlHasilLabPa" target="_blank" class="btn btn-primary mr-auto">
                <i class="fas fa-download "></i>Download</a>
            <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="
                    https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js
                    "></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            const $contentErm = $('#content_erm_perawat');
            const $contentPenunjang = $('#content_penunjang');
            const $contentEksternal = $('#content_eksternal');

            // Event handling for buttons
            $(document).on('click', '.btn-outline-primary, .btn-cppt-perawat, .btn-penunjang, .btn-kpo',
                function() {
                    const $button = $(this);
                    const target = $button.data('target') || $button.data('targetpenujang');
                    const kode = $button.data('kode');
                    const no_rm = $button.data('norm');
                    const type = $button.hasClass('btn-penunjang') ? 'penunjang' : 'erm-ranap-perawat';
                    const url = getUrl(target, type, kode, no_rm);
                    const targetDiv = type === 'penunjang' ? $contentPenunjang : $contentErm;
                    loadContent(url, targetDiv);
                });

            $(document).on('click', '.btn-eksternal', function() {
                const target = $(this).data('targeteksternal');
                const url = getUrl(target);
                loadContent(url, $contentEksternal);
            });

            // Function to get URL based on target
            function getUrl(target, type = '', kode = '', no_rm = '') {
                const urlMap = {
                    'erm-ranap-perawat': {
                        'assesmen-awal-keperawatan': "{{ route('dashboard.erm-ranap.perawat.assesmen-awal-keperawatan') }}",
                        'implementasi-evaluasi': "{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi') }}",
                        'lembar-edukasi': "{{ route('dashboard.erm-ranap.perawat.lembar-edukasi') }}",
                        'catatan-mpp-a': "{{ route('dashboard.erm-ranap.perawat.catatan-mpp-a') }}",
                        'catatan-mpp-b': "{{ route('dashboard.erm-ranap.perawat.catatan-mpp-b') }}",
                        'rencana-pemulangan-pasien': "{{ route('dashboard.erm-ranap.perawat.rencana-pemulangan-pasien') }}",
                        'cppt-perawat': "{{ route('dashboard.erm-ranap.perawat.cppt-perawat') }}",
                        'dashboard': "{{ route('dashboard.erm-ranap.dashboard') }}"
                    },
                    'penunjang': {
                        'data-penunjang': "{{ route('dashboard.erm-ranap.penunjang.get-penunjang') }}",
                        'kpo': "{{ route('dashboard.erm-ranap.penunjang.kpo-elektronik') }}",
                        'grouping': "{{ route('dashboard.erm-ranap.penunjang.grouping') }}"
                    },
                    'kpo': "{{ route('dashboard.erm-ranap.penunjang.kpo-elektronik') }}",
                    'grouping': "{{ route('dashboard.erm-ranap.penunjang.grouping') }}"
                };

                let url = urlMap[type] ? urlMap[type][target] : urlMap[target];
                if (!url) return '';

                const params = [];
                if (kode) params.push("kode=" + encodeURIComponent(kode));
                if (no_rm) params.push("no_rm=" + encodeURIComponent(no_rm));

                return params.length ? url + '?' + params.join('&') : url;
            }

            // Function to load content into targetDiv
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
                    },
                    complete: function() {
                        $('#loadingSpinner').hide();
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
    </script>
    <script>
        var urlRoute = "{{ route('dashboard.erm-ranap.riwayat.details', ':kode_kunjungan') }}";
        $('button[data-target^="#modal-"]').on('click', function() {
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
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th></tr></thead><tbody>';
                    $.each(data.tindakan, function(index, item) {
                        tindakanHtml += '<tr><td>' + item.NAMA_TARIF + '</td></tr>';
                    });
                    tindakanHtml += '</tbody></table>';

                    // Membuat HTML untuk tabel obat
                    var obatHtml =
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th></tr></thead><tbody>';
                    $.each(data.obat, function(index, item) {
                        obatHtml += '<tr><td>' + item.NAMA_TARIF + '</td></tr>';
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
@endpush
@push('scripts')
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
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
            $(".checkVentilator").hide();
            $(".checkTB").hide();
            $(".checkCovid").hide();
            $(".formbb").hide();
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
            $(".diagSekunderResume").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
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
            $(".icd9operasi").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
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
            $('.btnCariSEP').click(function(e) {
                var nomorkartu = $('.nomorkartu-id').val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                if (value.jnsPelayanan == 1) {
                                    var jenispelayanan = "Rawat Inap";
                                }
                                if (value.jnsPelayanan == 2) {
                                    var jenispelayanan = "Rawat Jalan";
                                }
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    value.diagnosa,
                                    "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('.nomorsep-id').val(nomorsep);
                                $('#modalSEP').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        $.LoadingOverlay("hide");
                    }
                });
            });
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
@endpush
