@extends('adminlte::page')

@section('title', 'Pasien IGD')
@section('content_header')
    <h5>Pasien IGD : {{ $pasien->nama_px }}</h5>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <h3 class="profile-username text-center">RM : {{ $pasien->no_rm }}</h3>
                            <p class="text-muted text-center">Nama : {{ $pasien->nama_px }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Jenis Kelamin :
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b></li>
                                <li class="list-group-item"><b>Alamat : {{ $pasien->alamat }}</b></li>
                                <li class="list-group-item"><b>NIK : {{ $pasien->nik_bpjs }}</b></li>
                                <li class="list-group-item"><b>BPJS :
                                        {{ $pasien->no_Bpjs == null ? 'tidak punya bpjs' : $pasien->no_Bpjs }}</b></li>
                                <li class="list-group-item"><b>Telp :
                                        {{ $pasien->no_telp == null ? $pasien->no_hp : $pasien->no_telp }}</b></li>
                            </ul>
                            <a class="btn btn-primary bg-gradient-primary btn-block"><b>No Antri :
                                    {{ $antrian->no_antri }}</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <x-adminlte-card theme="primary" size="sm" collapsible title="Riwayat Kunjungan :">
                        <div class="col-lg-12">
                            <div class="row">
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
                    </x-adminlte-card>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <x-adminlte-card theme="success" size="sm" id="div_rajal" icon="fas fa-info-circle" collapsible
                        title="Form Pendaftaran">
                        <form action="{{ route('form.daftar-create') }}" id="formPendaftaranIGD" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <input type="hidden" value="{{ $antrian->id }}" name="id_antrian">
                                <input type="hidden" name="rm" value="{{ $pasien->no_rm }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <x-adminlte-input name="nama_pasien" value="{{ $pasien->nama_px }}" disabled
                                            label="Nama Pasien" enable-old-support>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-olive">
                                                    {{ $pasien->no_rm }}</div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tanggal"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                            :config="$config" />
                                        <x-adminlte-input name="noTelp" type="number" label="No Telpon" />
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
                                            <input type="text" name="nama_perujuk" class="form-control" id="nama_perujuk">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <x-adminlte-select2 name="isBpjs" label="Jenis Pasien">
                                            <option value="0">--Pasien UMUM--</option>
                                            <option value="1">--Pasien BPJS--</option>
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($paramedis as $item)
                                                <option value="{{ $item->kode_paramedis }}"
                                                    {{ is_null($antrian->isTriase) ? 'asdas' : ($item->kode_paramedis == $antrian->isTriase->kode_paramedis ? 'selected' : '') }}>
                                                    {{ $item->nama_paramedis }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                            <option value="">--Pilih Penjamin--</option>
                                            @foreach ($penjamin as $item)
                                                <option value="{{ $item->kode_penjamin }}">
                                                    {{ $item->nama_penjamin }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
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
                                                            <x-adminlte-select2 name="kabupaten"
                                                                label="Kota / Kabupaten">
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
                                    <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1 bg-green float-right"
                                        id="submitPasien" label="Simpan Data" />
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
