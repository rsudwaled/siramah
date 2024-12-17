@extends('adminlte::page')
@section('title', 'DAFTAR IGD')
@section('content')
    <style>
        .scroll-container {
            width: 100%;
            height: auto;
            overflow-x: auto;
            white-space: nowrap;
            border: 1px solid #bec5d8;
            padding: 10px;
            scroll-behavior: smooth;
        }

        .scroll-item {
            display: inline-block;
            width: 430px;
            height: auto;
            /* background-color: #cd6e6e; */
            padding: 4px;
        }
    </style>
    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Cari Pasien</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="col-lg-12">
                    <form id="form-cari-pasien-lama" method="get">
                        <div class="col-lg-12 row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Cari Nama Pasien">Cari Nama Pasien</label>
                                    <input type="text" class="form-control" name="cari_nama_pasien" id="cari_nama_pasien">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="Cari Alamat Pasien">Cari Alamat Pasien</label>
                                    <input type="text" class="form-control" name="cari_alamat_pasien" id="cari_alamat_pasien">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-md btn-primary mt-4">Cari Pasien</button>
                            </div>
                        </div>
                      </form>
                  </div>
                  <div class="col-12 mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Riwayat</th>
                            </tr>
                        </thead>
                        <tbody id="result-tbody">
                            <!-- Data akan ditampilkan di sini -->
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-adminlte-input name="rm" label="NO RM" value="{{ $request->rm }}"
                                        placeholder="Masukan Nomor RM ....">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <x-adminlte-input name="nama" label="NAMA PASIEN" value="{{ $request->nama }}"
                                        placeholder="Masukan Nama Pasien ....">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-lg-4">
                                    <x-adminlte-input name="cari_desa" label="CARI BERDASARKAN DESA"
                                        value="{{ $request->cari_desa }}" placeholder="Masukan nama desa dengan lengkap...">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <x-adminlte-input name="cari_kecamatan" label="CARI BERDASARKAN KECAMATAN"
                                        value="{{ $request->cari_kecamatan }}"
                                        placeholder="Masukan nama kecamatan dengan lengkap...">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-lg-4">
                                    <x-adminlte-input name="nomorkartu" label="NOMOR KARTU"
                                        value="{{ $request->nomorkartu }}" placeholder="Masukan Nomor Kartu BPJS ....">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <x-adminlte-input name="nik" label="NIK (NOMOR INDUK KEPENDUDUKAN)"
                                        value="{{ $request->nik }}" placeholder="Masukan nomor NIK ....">
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                label="Cari!" />
                                        </x-slot>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-success">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="scroll-container">
                        @if (!empty($pasien))
                            @foreach ($pasien as $data)
                                <div class="scroll-item">
                                    <div class="info-box bg-gradient-success">
                                        <div class="info-box-content">
                                            <span class="info-box-text">
                                                <strong>
                                                    {{ $data->nama_px }}
                                                </strong>
                                                <a href="{{ route('edit-pasien', ['rm' => $data->no_rm]) }}" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="btn btn-light btn-xs col-4 float-right"><i
                                                        class="far fa-user"></i> <strong>Edit Pasien</strong></a>
                                                <br>
                                                ({{ $data->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }} |
                                                {{ Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }})
                                                <br>
                                                RM: {{ $data->no_rm }}<br>
                                                NIK: {{ $data->nik_bpjs ?? '-' }} <br> BPJS: {{ $data->no_Bpjs ?? '-' }}
                                                <br>
                                                <small>
                                                    {{ $data->alamat ?? '-' }} |
                                                    {{ $data->lokasiDesa?->name ?? '-' }} |
                                                    {{ $data->lokasiKecamatan?->name ?? '-' }}|
                                                    {{ $data->lokasiKabupaten?->name ?? '-' }}

                                                </small>
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 90%"></div>
                                            </div>
                                            @if (!empty($data->kunjunganTerakhir) && $data->kunjunganTerakhir->count() > 0)
                                                @foreach ($data->kunjunganTerakhir as $item)
                                                    <small style="font-size: 12px;">
                                                        KODE: {{ $item->kode_kunjungan }}
                                                        ({{ $item->prefix_kunjungan }})
                                                        <br>
                                                        TGL: {{ $item->tgl_masuk }} <br>
                                                        Diag: {{ $item->diagx ?? '-' }}
                                                    </small>
                                                @endforeach
                                            @else
                                                <small style="font-size: 12px;">
                                                    KODE: - <br>
                                                    TGL: - <br>
                                                    Diag: -
                                                </small>
                                            @endif
                                            <button type="button"
                                                class="btn btn-default btn-xs btn-pilihPasien bg-purple btn-block"
                                                data-rm="{{ $data->no_rm }}" data-nama="{{ $data->nama_px }}"
                                                data-nik="{{ $data->nik_bpjs }}" data-nomorkartu="{{ $data->no_Bpjs }}"
                                                data-kontak="{{ $data->no_telp ?? $data->no_hp }}">
                                                DAFTAR </button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="scroll-info">
                                    <h6>Pasien Tidak Ditemukan pada database</h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="purple" collapsible>
                <form action="" id="formPendaftaranIGD" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="RM PASIEN">RM PASIEN</label>
                                <input type="text" class="form-control" name="rm_terpilih" id="rm_terpilih" readonly>
                            </div>
                            <x-adminlte-input name="nama_pasien" id="nama_pasien" label="NAMA" type="text" readonly
                                disable-feedback />
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">NIK
                                    <code id="note_nik">(mohon nik WAJIB DIISI)</code></label>
                                <input type="number" name="nik_bpjs" id="nik_bpjs" class="form-control"
                                    value="0000000000000000">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">NO KARTU
                                    <code id="note_nik">
                                        (NOKARTU WAJIB DIISI JIKA PASIEN BPJS)
                                    </code>
                                </label>
                                <input type="number" name="no_bpjs" id="no_bpjs" value="0000000000000"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <x-adminlte-input name="noTelp" id="noTelp" type="number" value="000000000000"
                                label="No Telpon" />
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                label="Tanggal" :config="$config" />
                        </div>
                        <div class="col-3">
                            <x-adminlte-select name="alasan_masuk_id" label="Alasan Masuk">
                                @foreach ($alasanmasuk as $item)
                                    <option value="{{ $item->id }}">
                                        {{ strtoupper($item->alasan_masuk) }}</option>
                                @endforeach
                            </x-adminlte-select>
                            <x-adminlte-select id="tujuanDaftar" name="tujuan_daftar" label="Tujuan Daftar"
                                onchange="updateButton()">
                                <option value="igd">IGD</option>
                                <option value="igk">KEBIDANAN</option>
                                <option value="rawat_inap">RAWAT INAP</option>
                                <option value="penunjang">PENUNJANG</option>
                            </x-adminlte-select>
                        </div>
                        <div class="col-12">
                            <blockquote class="quote-danger">
                                <p>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">INFORMASI PENTING: ketika select option
                                            Tujuan Daftar dirubah maka data yang sudah di isi kedalam <span
                                                style="color:rgb(186, 0, 93)">form dibawah ini akan otomatis
                                                dihapus</span>. maka dari itu harus di perhatikan dalam proses pengisian
                                            data dibawah ini:</font>
                                    </font>
                                </p>
                            </blockquote>
                        </div>
                        <div id="igd_igk_view" style="display:none;" class="col-12">
                            @include('simrs.igd.daftar.components.igd_igk')
                        </div>
                        <div id="ranap_view" style="display:none;" class="col-12">
                            @include('simrs.igd.daftar.components.ranap')
                        </div>
                        <div id="penunjang_view" style="display:none;" class="col-12">
                            @include('simrs.igd.daftar.components.penunjang')
                        </div>
                        <x-slot name="footerSlot">
                            <x-adminlte-button type="submit" id="btn-post-igd"
                                onclick="javascript: form.action='{{ route('v2.store-tanpa-noantrian') }}';"
                                class="withLoad btn  btn-sm bg-primary float-right" form="formPendaftaranIGD"
                                label="Simpan Data" />
                            <x-adminlte-button type="submit" id="btn-post-ranap" style="display:none;"
                                onclick="javascript: form.action='{{ route('v2.store-tanpa-noantrian-ranap') }}';"
                                class="withLoad btn  btn-sm bg-success float-right" form="formPendaftaranIGD"
                                label="Simpan Data" />
                            <x-adminlte-button type="submit" id="btn-post-penunjang" style="display:none;"
                                onclick="javascript: form.action='{{ route('v2.store-tanpa-noantrian-penunjang') }}';"
                                class="withLoad btn  btn-sm bg-warning float-right" form="formPendaftaranIGD"
                                label="Simpan Data" />
                        </x-slot>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        document.getElementById('tujuanDaftar').addEventListener('change', function() {
            // Ambil nilai yang dipilih
            const selectedValue = this.value;
            // Buat mapping antara value dan ID elemen
            const views = {
                igd: 'igd_igk_view',
                igk: 'igd_igk_view',
                rawat_inap: 'ranap_view',
                penunjang: 'penunjang_view'
            };

            // Sembunyikan semua div view
            document.querySelectorAll('#igd_igk_view, #ranap_view, #penunjang_view').forEach(div => {
                div.style.display = 'none';
                // Reset semua input yang ada di dalam div tersebut
                const inputs = div.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = ''; // Reset input, select, dan textarea
                    }
                    // Jika input adalah elemen select2, reset dengan select2 API
                    if ($(input).hasClass('select2-hidden-accessible')) {
                        $(input).val(null).trigger('change'); // Reset Select2
                    }
                });
            });

            // Tampilkan div yang sesuai berdasarkan pilihan
            if (views[selectedValue]) {
                document.getElementById(views[selectedValue]).style.display = 'block';
            }
        });
        // Trigger event `change` saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tujuanDaftar').dispatchEvent(new Event('change'));
        });
    </script>
    <script>
        // Fungsi untuk memperbarui tampilan tombol berdasarkan pilihan select
        function updateButton() {
            // Mendapatkan nilai pilihan dari select
            var tujuan = document.getElementById('tujuanDaftar').value;

            // Menyembunyikan semua tombol terlebih dahulu
            document.getElementById('btn-post-igd').style.display = 'none';
            document.getElementById('btn-post-ranap').style.display = 'none';
            document.getElementById('btn-post-penunjang').style.display = 'none';

            // Menampilkan tombol berdasarkan nilai yang terpilih
            if (tujuan === 'igd' || tujuan === 'igk') {
                document.getElementById('btn-post-igd').style.display = 'block';
            } else if (tujuan === 'rawat_inap') {
                document.getElementById('btn-post-ranap').style.display = 'block';
            } else if (tujuan === 'penunjang') {
                document.getElementById('btn-post-penunjang').style.display = 'block';
            }
        }
    </script>
    <script>
        const isbpjs = document.getElementById('isBpjs');
        const isbpjsRanap = document.getElementById('isBpjsRanap');
        const perujuk = document.getElementById('isPerujuk');
        const provinsi = document.getElementById('provinsi');

        document.querySelectorAll('input[name="isBpjs"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === '0') {
                    document.getElementById('penjamin_pribadi').style.display = 'block';
                    document.getElementById('show_penjamin_bpjs').style.display = 'none';
                } else {
                    document.getElementById('show_penjamin_bpjs').style.display = 'block';
                    document.getElementById('penjamin_pribadi').style.display = 'none';
                }
            });
        });
        document.querySelectorAll('input[name="isBpjsRanap"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === '0') {
                    document.getElementById('penjamin_pribadi_ranap').style.display = 'block';
                    document.getElementById('show_penjamin_bpjs_ranap').style.display = 'none';
                } else {
                    document.getElementById('show_penjamin_bpjs_ranap').style.display = 'block';
                    document.getElementById('penjamin_pribadi_ranap').style.display = 'none';
                }
            });
        });

        $('.btn-pilihPasien').on('click', function() {
            let rm = $(this).data('rm');
            let nama = $(this).data('nama');
            let nik = $(this).data('nik');
            let nomorkartu = $(this).data('nomorkartu');
            let kontak = $(this).data('kontak');

            $('#rm_terpilih').val(rm);
            $('#nik_bpjs').val(nik);
            $('#nama_pasien').val(nama);
            $('#no_bpjs').val(nomorkartu);
            $('#noTelp').val(kontak);

            getKunjungan(rm);
        });

        function getKunjungan(no_rm) {
            if (no_rm) {
                // Gunakan Laravel route() helper untuk menghasilkan URL
                var url = "{{ route('cek-kunjungan-pasien-terpilih', ':no_rm') }}";
                url = url.replace(':no_rm', no_rm); // Gantilah :no_rm dengan nilai no_rm

                // Lakukan request AJAX ke route yang sudah disiapkan
                $.ajax({
                    url: url, // Gunakan URL yang sudah dibangun dengan route()
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Bersihkan tabel sebelum diisi
                        $('#kunjunganTable tbody').empty();
                        $('#viewTableIGD tbody').empty();

                        if (data.length > 0) {
                            // Loop data dan tampilkan di dalam tabel
                            data.forEach(function(kunjungan) {
                                const editRuanganUrlRoute =
                                    "{{ route('simrs.pendaftaran-ranap-igd.edit-ruangan', ':kunjungan') }}";
                                const editRuanganUrl = editRuanganUrlRoute.replace(':kunjungan',
                                    kunjungan.kode_kunjungan);
                                let buttonAction =
                                    ''; // Variabel untuk menyimpan tombol yang akan ditampilkan
                                if ((kunjungan.status_kunjungan == 14 && (kunjungan.kode_unit != '1002' && kunjungan.kode_unit != '1023' || kunjungan.kode_unit == '0000'))){
                                    buttonAction = `
                                            <blockquote>
                                                <p>Pasien sudah didaftarkan ranap pada tanggal: <br> <strong>${kunjungan.tgl_masuk} WIB</strong>. <br>
                                                Silakan cari data pasien di kunjungan pasien ranap dan jika perlu untuk edit ruangan sesuai dengan informasi yang
                                                didapatkan dari ruangan! Silakan klik tombol berikut:</p>
                                                <small>
                                                    <a href="${editRuanganUrl}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-share"></i> Edit Ruangan</a>
                                                </small>
                                            </blockquote>
                                        `;
                                } else if ((kunjungan.status_kunjungan == 1 && (kunjungan.kode_unit == '1002' || kunjungan.kode_unit == '1023'))|| (kunjungan.status_kunjungan == 1 && (kunjungan.kode_unit != '1002' || kunjungan.kode_unit != '1023'))) {
                                    // If status_kunjungan is 1 and kode_unit is '1002' or '1023'
                                    buttonAction = `
                                            <x-adminlte-button type="button"
                                            data-kode="${kunjungan.kode_kunjungan}"
                                            data-unit="${kunjungan.unit.nama_unit}"
                                            class="btn-sm btn-pilihPilihKodeRef bg-primary btn-block"
                                            label="PILIH REF KUNJUNGAN" />
                                        `;
                                }

                                const row = `
                                            <tr>
                                                <td>${kunjungan.tgl_masuk} WIB</td>
                                                <td>UNIT: ${kunjungan.prefix_kunjungan} <br> KODE: ${kunjungan.kode_kunjungan}</td>
                                                <td>STATUS: ${kunjungan.status ? kunjungan.status.status_kunjungan : '-'} <br> ADMIN: ${kunjungan.pic ? kunjungan.pic.username : '-'}</td>
                                                <td>${kunjungan.penjamin_simrs ? kunjungan.penjamin_simrs.nama_penjamin : '-'}</td>
                                                <td>
                                                   ${buttonAction}
                                                </td>
                                            </tr>
                                        `;
                                const rowViewIgd = `
                                            <tr>
                                                <td>${kunjungan.tgl_masuk} WIB</td>
                                                <td>UNIT: ${kunjungan.prefix_kunjungan} <br> KODE: ${kunjungan.kode_kunjungan}</td>
                                                <td>STATUS: ${kunjungan.status ? kunjungan.status.status_kunjungan : '-'} <br> ADMIN: ${kunjungan.pic ? kunjungan.pic.username : '-'}</td>
                                                <td>${kunjungan.penjamin_simrs ? kunjungan.penjamin_simrs.nama_penjamin : '-'}</td>
                                            </tr>
                                        `;
                                $('#kunjunganTable tbody').append(row);
                                $('#viewTableIGD tbody').append(rowViewIgd);
                            });
                        } else {
                            // Jika tidak ada data kunjungan
                            $('#kunjunganTable tbody').append(
                                '<tr><td colspan="5">No kunjungan found.</td></tr>');
                            $('#viewTableIGD tbody').append(
                                '<tr><td colspan="4">No kunjungan found.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        }

        $(document).on('click', '.btn-pilihPilihKodeRef', function() {
            let kode = $(this).data('kode');
            let unit = $(this).data('unit');
            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin memilih kode kunjungan: ${kode} (${unit}) sebagai referensi kunjungan?`,
                icon: 'question', // Ikon SweetAlert
                showCancelButton: true, // Menampilkan tombol batal
                confirmButtonText: 'Ya, Pilih',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika tombol "Ya, Pilih" diklik
                    Swal.fire(
                        'Dipilih!',
                        `Kode kunjungan ${kode} (${unit}) telah dipilih. silahkan cek pada inputan Referensi Kunjungan apakah kodenya sudah sesuai dan muncul`,
                        'success'
                    );
                    $('#referensi_kunjungan').val(kode);
                } else {
                    // Jika tombol "Batal" diklik
                    Swal.fire(
                        'Batal',
                        'Pemilihan kode kunjungan dibatalkan.',
                        'info'
                    );
                }
            });
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#cariRuangan').on('click', function() {
                var unit = $('#unitTerpilih').val();
                var kelas = $('#r_kelas_id').val();
                $('#hakKelas').val(kelas);
                $('#hakKelas').text('Kelas ' + kelas);
                if (kelas) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('bed-ruangan.get') }}?unit=" + unit + '&kelas=' + kelas,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res) {
                                $.each(res.bed, function(key, value) {
                                    $("#idRuangan").append(
                                        '<div class="position-relative p-3 m-2 bg-green ruanganCheck" onclick="chooseRuangan(' +
                                        value.id_ruangan + ', `' + value
                                    .nama_kamar + '`, `' +
                                    value.no_bed +
                                    '`)" style="height: 100px; width: 150px; margin=5px; border-radius: 2%;"><div class="ribbon-wrapper ribbon-sm"><div class="ribbon bg-warning text-sm">KOSONG</div></div><h6 class="text-left">"' +
                                        value.nama_kamar +
                                        '"</h6> <br> NO BED : "' + value
                                        .no_bed + '"<br></div></div></div>');
                                });
                            } else {
                                $("#bed_byruangan").empty();
                            }
                        }
                    });
                } else {
                    $("#bed_byruangan").empty();
                }
            });

            $('#status_persiapan').on('change', function() {
                const isPreparation = this.value === '1';
                const rows = ['#rowDiv1', '#rowDiv2'];

                rows.forEach(row => {
                    $(row).toggle(!isPreparation);
                });
            });
        });

        function chooseRuangan(id, nama, bed) {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN PILIH RUANGAN ' + nama + ' No ' + bed + ' ?',
                showDenyButton: true,
                confirmButtonText: 'Pilih',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    //
                    $("#id_ruangan").val(id);
                    $("#ruanganTerpilih").val(nama);
                    $("#bedTerpilih").val(bed);
                    $('#pilihRuangan').modal('toggle');
                    $(".ruanganCheck").remove();

                    $("#infoRuangan").css("display", "none");
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }
    </script>
    {{-- ajax cari pasien lama --}}
    <script>
        $(document).ready(function () {
            $('#form-cari-pasien-lama').on('submit', function (e) {
                e.preventDefault(); // Menghentikan form dari reload halaman

                var namaPasien = $('#cari_nama_pasien').val();
                var alamatPasien = $('#cari_alamat_pasien').val();

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '{{route('cari-pasien-lama')}}',
                    type: 'GET',
                    data: {
                        cari_nama_pasien: namaPasien,
                        cari_alamat_pasien: alamatPasien
                    },
                    success: function (response) {
                        var resultHtml = '';
                        if (response.length > 0) {
                            response.forEach(function (pasien) {
                                var riwayatKunjunganHtml = pasien.kunjungans.map(function(kunjungans) {
                                    return '<table><tbody><tr style="margin:0px; padding:2px;"><td>Masuk: '+kunjungans.tgl_masuk+'</td><td>Unit: '+kunjungans.prefix_kunjungan+'</td><td>Keluar: '+kunjungans.tgl_keluar+'</td></tr></tbody></table>'
                                });

                                resultHtml += '<tr><td>RM: '+pasien.no_rm+'<br>NAMA :'+pasien.nama_px+'<br>Alamat: '+pasien.lokasi_desa.name+','+pasien.lokasi_kecamatan.name+'-'+pasien.lokasi_kabupaten.name+'<br></td><td>Tgl Lahir:'+pasien.tgl_lahir+'<br>Jenis Kelamin:'+pasien.jenis_kelamin+'</td><td>'+riwayatKunjunganHtml+'</td></tr>';
                            });
                        } else {
                            resultHtml = '<p>Data tidak ditemukan.</p>';
                        }
                        $('#result-tbody').html(resultHtml); // Menampilkan hasil ke dalam div#result
                    },
                    error: function () {
                        alert('Terjadi kesalahan');
                    }
                });
            });
        });
    </script>
@endsection
