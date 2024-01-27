@extends('adminlte::page')

@section('title', 'Daftar')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Form Daftar / Tanpa Nomor</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('list.antrian') }}"
                            class="btn btn-sm btn-flat btn-secondary">kembali</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="row bg-primary">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-headers">{{ $pasien->nama_px }}</h5>
                                                <small>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</small>
                                                <br>
                                                <span class="description-text">-Pasien-</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-headers">
                                                    {{ date('d F Y', strtotime($pasien->tgl_lahir)) }}</h5>
                                                <span class="description-text">-Tanggal Lahir-</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-headers">{{ $pasien->no_rm }}</h5>
                                                <span class="description-text">-No RM-</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-headers">
                                                    NIK : {{ $pasien->nik_bpjs == null ? 'tidak ada' : $pasien->nik_bpjs }}
                                                    <br>
                                                    BPJS : {{ $pasien->no_Bpjs == null ? 'tidak ada' : $pasien->no_Bpjs }}
                                                </h5>
                                                <span class="description-text">-NIK & BPJS-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    @php
                                        $heads = ['Kunjungan', 'Kode Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Status'];
                                        $config['order'] = ['0', 'asc'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                        $config['scrollY'] = '300px';
                                        $config['scrollCollapse'] = true;
                                        $config['scrollX'] = true;
                                    @endphp
                                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
                                        striped bordered hoverable compressed>
                                        @foreach ($kunjungan as $item)
                                            <tr>
                                                <td>{{ $item->counter }}</td>
                                                <td>{{ $item->kode_kunjungan }}</td>
                                                <td>{{ $item->unit->nama_unit }}</td>
                                                <td>{{ $item->tgl_masuk }}</td>
                                                <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                                </td>
                                                <td>{{ $item->kode_penjamin }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-success disabled' : ($item->status_kunjungan == 1 ? 'btn-danger' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'kunjungan ditutup' : ($item->status_kunjungan == 1 ? 'kunjungan aktif' : 'kunjungan dibatalkan') }}</button>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </x-adminlte-datatable>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <x-adminlte-card theme="success" size="sm" id="div_rajal" icon="fas fa-info-circle" collapsible
                        title="Daftarkan : {{ $pasien->nama_px }} ({{ $pasien->no_rm }})">
                        @if (!empty($resdescrtipt->response))
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body bg-success disabled color-palette">
                                        <div class="row ">
                                            <div class="col-sm-3 col-6">
                                                <div class="description-block border-right">
                                                    <h5 class="description-header ">-
                                                        {{ $resdescrtipt->response->peserta->statusPeserta->keterangan }} -
                                                    </h5>
                                                    <span class="description-text">STATUS BPJS </span>
                                                </div>

                                            </div>

                                            <div class="col-sm-3 col-6">
                                                <div class="description-block border-right">
                                                    <h5 class="description-header ">
                                                        {{ $resdescrtipt->response->peserta->jenisPeserta->keterangan }}
                                                    </h5>
                                                    <span class="description-text">JENIS PESERTA</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-3 col-6">
                                                <div class="description-block border-right">
                                                    <h5 class="description-header ">
                                                        {{ $resdescrtipt->response->peserta->hakKelas->keterangan }}</h5>
                                                    <span class="description-text">HAK KELAS</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-3 col-6">
                                                <div class="description-block">
                                                    <h5 class="description-header ">
                                                        {{ $resdescrtipt->response->peserta->noKartu }}</h5>
                                                    <span class="description-text">NO KARTU</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="" id="formPendaftaranIGD" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <input type="hidden" name="rm" value="{{ $pasien->no_rm }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <x-adminlte-select name="jp" label="Pilih Unit">
                                            <option value="">--Pilih Unit--</option>
                                            <option value="1">IGD</option>
                                            <option value="0">IGK</option>
                                        </x-adminlte-select>

                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tanggal"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                            :config="$config" />
                                        <x-adminlte-input name="noTelp" type="number"
                                            value="{{ $pasien->no_tlp == null ? $pasien->no_hp : $pasien->no_tlp }}"
                                            label="No Telpon" />
                                        <div class="form-group">
                                            <label for="exampleInputBorderWidth2">Perujuk
                                                <code>(jika pasien memiliki referensi instansi yang merujuk)</code></label>
                                            <select name="isPerujuk" id="isPerujuk" class="form-control">
                                                <option value="0">Tanpa Perujuk</option>
                                                <option value="1">Tambah Perujuk</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perujuk">
                                            <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                                            <input type="text" name="nama_perujuk" class="form-control"
                                                id="nama_perujuk">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <x-adminlte-select name="isBpjs" id="isBpjs" label="Jenis Pasien">
                                            <option value="">--Pilih Jenis Pasien--</option>
                                            <option value="0">Pasien UMUM</option>
                                            <option value="1">Pasien BPJS</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($paramedis as $item)
                                                <option value="{{ $item->kode_paramedis }}">
                                                    {{ $item->nama_paramedis }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <div class="form-group" id="show_penjamin_umum">
                                            <x-adminlte-select2 name="penjamin_id_umum" label="Pilih Penjamin">
                                                @foreach ($penjamin as $item)
                                                    <option value="{{ $item->kode_penjamin }}">
                                                        {{ $item->nama_penjamin }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                        <div class="form-group" id="show_penjamin_bpjs">
                                            <x-adminlte-select2 name="penjamin_id_bpjs" label="Pilih Penjamin BPJS" >
                                                @foreach ($penjaminbpjs as $item)
                                                    <option value="{{ $item->kode_penjamin_simrs }}">
                                                        {{ $item->nama_penjamin_bpjs }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                        <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Masuk">
                                            <option value="">--Pilih Alasan--</option>
                                            @foreach ($alasanmasuk as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->alasan_masuk }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <x-adminlte-select name="lakaLantas" id="status_kecelakaan"
                                            label="Status Kecelakaan">
                                            <option value="">--Status Kecelakaan--</option>
                                            <option value="0">BUKAN KECELAKAAN LALU LINTAS (BKLL)
                                            </option>
                                            <option value="1">KLL & BUKAN KECELAKAAN KERJA (BKK)
                                            </option>
                                            <option value="2">KLL & KK</option>
                                            <option value="3">KECELAKAAN KERJA</option>
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-md-12" id="div_stts_kecelakaan" style="display: none;">
                                            <div class="card card-danger card-outline">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="provinsi" id="provinsi"
                                                                label="Provinsi">
                                                                <option selected disabled>Cari Provinsi</option>
                                                            </x-adminlte-select2>
                                                            <x-adminlte-select2 name="kabupaten" label="Kota / Kabupaten">
                                                                <option selected disabled>Cari Kota / Kabupaten
                                                                </option>
                                                            </x-adminlte-select2>
                                                            <x-adminlte-select2 name="kecamatan" label="Kecamatan">
                                                                <option selected disabled>Cari Kecamatan
                                                                </option>
                                                            </x-adminlte-select2>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="noLP" label="NO LP"
                                                                placeholder="no laporan polisi" id="noLP"
                                                                disable-feedback />
                                                            <x-adminlte-input name="keterangan" id="keterangan"
                                                                label="Keterangan" placeholder="keterangan kecelakaan"
                                                                disable-feedback />
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tglKejadian" id="tglKejadian"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal Kejadian" :config="$config" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($knj_aktif == 0)
                                    @if (!empty($resdescrtipt->response))
                                        @if ($resdescrtipt->response->peserta->statusPeserta->keterangan === 'AKTIF')
                                            <x-adminlte-button type="submit"
                                                onclick="javascript: form.action='{{ route('form-tanpanomor.store') }}';"
                                                class="withLoad btn btn-flat btn-sm m-1 bg-green float-right"
                                                from="formPendaftaranIGD" label="Simpan Data" />
                                        @else
                                            <x-adminlte-button type="submit"
                                                onclick="javascript: form.action='{{ route('form-tanpanomor.store') }}';"
                                                class="withLoad btn btn-flat btn-sm m-1 bg-green float-right"
                                                from="formPendaftaranIGD" label="Simpan" />
                                        @endif
                                    @else
                                        <x-adminlte-button type="submit"
                                            onclick="javascript: form.action='{{ route('form-tanpanomor.store') }}';"
                                            class="withLoad btn btn-flat btn-sm m-1 bg-green float-right"
                                            from="formPendaftaranIGD" label="Simpan" />
                                    @endif
                                @else
                                    <x-adminlte-button class=" btn btn-sm m-1 bg-danger float-right"
                                        label="tidak bisa lanjut daftar" />
                                @endif
                                <a href="{{ route('list.antrian') }}"
                                    class="btn btn-sm btn-flat m-1 bg-secondary float-right">kembali</a>
                            </div>
                        </form>
                    </x-adminlte-card>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        const isbpjs = document.getElementById('isBpjs');
        const perujuk = document.getElementById('isPerujuk');
        const select = document.getElementById('status_kecelakaan');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        const nolaporan = document.getElementById('noLP');
        const keterangan = document.getElementById('keterangan');
        const tanggalkejadian = document.getElementById('tglKejadian');
        const provinsi = document.getElementById('provinsi');
        $(select).on('change', function() {
            if (select.value > 0 || select.value == null) {
                document.getElementById('div_stts_kecelakaan').style.display = "block";
            } else {
                nolaporan.value = '';
                keterangan.value = '';
                tanggalkejadian.value = '';
                provinsi.value = '';
                document.getElementById('div_stts_kecelakaan').style.display = "none";
            }
        });
        $('#perujuk').hide();
        $(perujuk).on('change', function() {
            if (perujuk.value > 0 || perujuk.value == null) {
                $('#perujuk').show();
            } else {
                $('#perujuk').hide();
            }
        });
        $('#show_penjamin_bpjs').hide();
        $(isbpjs).on('change', function() {
            if (isbpjs.value > 0 || isbpjs.value == null) {
                $('#show_penjamin_umum').hide();
                $('#show_penjamin_bpjs').show();
            } else {
                $('#show_penjamin_umum').show();
                $('#show_penjamin_bpjs').hide();
            }
        });
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#diagAwal").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
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

            $("#provinsi").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_provinsi_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            nama: params.term // search term
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
            $("#kabupaten").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kabupaten_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodeprovinsi: $("#provinsi option:selected").val(),
                            nama: params.term // search term
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
            $("#kecamatan").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_kecamatan_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            kodekabupaten: $("#kabupaten option:selected").val(),
                            nama: params.term // search term
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

        function updateNOBPJS(nik_pas, noKartu) {
            var nik_pas = nik_pas;
            var no_bpjs = noKartu;
            swal.fire({
                icon: 'question',
                title: 'UPDATE NO BPJS PASIEN DENGAN NIK ' + nik_pas,
                showDenyButton: true,
                confirmButtonText: 'Update',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('update-nobpjs.pasien') }}";
                    $.ajax({
                        type: "put",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            nik_pas: nik_pas,
                            no_bpjs: no_bpjs,
                        },
                        success: function(data) {

                        }
                    });
                    Swal.fire('nobpjs sudah diupdate', '', 'success');
                    location.reload();
                }
            })
        }
    </script>
@endsection
