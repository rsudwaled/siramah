@extends('adminlte::page')

@section('title', 'Pasien BPJS')
@section('content_header')
    <h1>Pasien BPJS: {{ $pasien->nama_px }}</h1>
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
                    @if ($pasien->no_Bpjs == null && $resdescrtipt->metadata->code != 200)
                        <div class="card">
                            <div class="card-header">
                                <h4>Status Pasien :</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a class="btn btn-app btn-block bg-maroon"><i class="fas fa-user-tag"></i>
                                                PASIEN UMUM </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a class="btn btn-app btn-block bg-success"><i class="fas fa-users"></i>
                                                {{ $antrian->no_antri }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            class="card {{ $resdescrtipt->response->peserta->statusPeserta->kode == 0 ? 'card-success' : 'card-danger' }} card-outline">
                            <div class="card-body box-profile">
                                <div class="card-header">
                                    <b>
                                        <p>
                                            STATUS BPJS : {{ $resdescrtipt->response->peserta->noKartu }}
                                            ({{ $resdescrtipt->response->peserta->statusPeserta->keterangan }})
                                        </p>
                                    </b>
                                    <button type="button"
                                        class="btn btn-block {{ $resdescrtipt->response->peserta->statusPeserta->kode == 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }} btn-sm mb-2">BPJS
                                        :
                                        {{ $resdescrtipt->response->peserta->statusPeserta->keterangan }}</button>
                                    <button type="button" class="btn btn-block bg-gradient-primary btn-sm mb-2">PENJAMIN
                                        BPJS : <b>{{ $ket_jpBpjs }}</b></button>
                                    @if ($pasien->no_Bpjs == null && $resdescrtipt->response->peserta->statusPeserta->kode == 0)
                                        <button type="button" class="btn btn-block bg-gradient-primary btn-sm mb-2"
                                            onclick="updateNOBPJS({{ $pasien->nik_bpjs }}, '{{ $resdescrtipt->response->peserta->noKartu }}')">update
                                            no bpjs</button>
                                        <a href="" class="btn btn-xl btn-warning btn-flat">Pindah Pendaftaran di
                                            Pasien
                                            BPJS</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-9">
                    <x-adminlte-card theme="success" size="sm" id="div_rajal" icon="fas fa-info-circle" collapsible
                        title="Form Pendaftaran">
                        <form action="{{ route('pasien-igdbpjs-store') }}" id="formPendaftaranIGD" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <input type="hidden" value="{{ $antrian->id }}" name="id_antrian">
                                <input type="hidden" name="unit" value="1002">
                                <input type="hidden" name="noKartu" value="{{ $pasien->no_Bpjs }}">
                                <input type="hidden" name="noMR" value="{{ $pasien->no_rm }}">
                                <input type="hidden" name="jnsPelayanan" value="2">
                                <input type="hidden" name="penjamin" value="{{ $ket_jpBpjs }}">
                                <input type="hidden" name="klsRawatHak" value="{{ $resdescrtipt->response->peserta->hakKelas->kode }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <x-adminlte-input name="nama_pasien" value="{{ $pasien->nama_px }}"
                                            disabled label="Nama Pasien" enable-old-support>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-olive">
                                                    {{ $pasien->no_rm }}</div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-lg-6">
                                        <x-adminlte-select2 name="dpjpLayan" id="dpjpLayan" label="Pilih DPJP">
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($paramedis as $item)
                                                <option value="{{ $item->kode_dokter_jkn }}">
                                                    {{ $item->nama_paramedis }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="col-md-12">
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="nama_pasien" value="{{ $pasien->nama_px }}"
                                                        disabled label="Nama Pasien" enable-old-support>
                                                        <x-slot name="prependSlot">
                                                            <div class="input-group-text text-olive">
                                                                {{ $pasien->no_rm }}</div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglSep"
                                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal"
                                                        :config="$config" />
                                                </div>
                                                <div class="col-md-6" id="selectDiagnosa" style="display: none;">
                                                    <x-adminlte-select2 name="diagAwal" label="Diagnosa BPJS ICD-10"
                                                        data-placeholder="Pilih beberapa diagnosa...">
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-select name="asalRujukan" label="Pilih Rujukan">
                                                        <option value="2">Faskes 2</option>
                                                        <option value="1">Faskes 1</option>
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Pendaftaran">
                                                        <option value="">--Pilih Alasan--</option>
                                                        @foreach ($alasanmasuk as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->alasan_masuk }}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-select name="isBridging" id="isBridging"
                                                        onchange="bridgingCheck(this.value)" label="Pilih Bridging / Tidak">
                                                        <option value="">--Status BPJS--</option>
                                                        <option value="1">Bridging</option>
                                                        <option value="0">Tidak Bridging</option>
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-md-6">
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
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noTelp" label="No Telepon" maxlength="13"
                                                        minlength="11" placeholder="08xxxx" />
                                                    <div class="invalid-feedback">
                                                        @error('noTelp')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="div_stts_kecelakaan" style="display: none;">
                                            <div class="card card-danger card-outline">
                                                @if ($knj_aktif > 0)
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-exclamation-triangle"></i> PERINGATAN
                                                            PENTING!</h5>
                                                        pasien memiliki kunjungan yang masih aktif
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="noLP" label="NO LP"
                                                                placeholder="no laporan polisi" disable-feedback />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="keterangan" label="Keterangan"
                                                                placeholder="keterangan kecelakaan" disable-feedback />
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tglKejadian"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal Kejadian" :config="$config" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="provinsi" label="Provinsi">
                                                                <option selected disabled>Cari Provinsi</option>
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="kabupaten" label="Kota / Kabupaten">
                                                                <option selected disabled>Cari Kota / Kabupaten</option>
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="kecamatan" label="Kecamatan">
                                                                <option selected disabled>Cari Kecamatan</option>
                                                            </x-adminlte-select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($knj_aktif == 0)
                                    @if ($resdescrtipt->response->peserta->statusPeserta->kode == 0)
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right" form="formPendaftaranIGD"
                                            label="Simpan Data" />
                                        <x-adminlte-button class=" btn btn-sm btn-flat m-1 bg-danger float-right"
                                            label="Batalkan Pendaftaran"
                                            onclick="batalDaftar({{ $antrian->id }},'{{ $antrian->no_antri }}')" />
                                    @else
                                        <a href="{{ route('form-pasien', ['no' => $antrian->no_antri, 'rm' => $pasien->no_rm, 'jp' => $status_pendaftaran]) }}"
                                            class="float-right">
                                            <div class="alert alert-danger alert-dismissible">
                                                <h5><i class="icon fas fa-ban"></i> BPJS BERMASALAH!</h5>
                                                Pasien Bermasalah dengan bpjs, daftarkan sebagai pasien umum
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <x-adminlte-button class=" btn btn-sm btn-flat m-1 bg-secondary float-right"
                                        label="Kembali" onclick="backAndDelete({{ $antrian->id }})" />

                                    <x-adminlte-button class=" btn btn-sm btn-flat m-1 bg-danger float-right"
                                        label="tidak bisa lanjut daftar (pasien memilki kunjungan yang masih aktif)" />
                                @endif
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
        const select = document.getElementById('status_kecelakaan');
        const isBridging = document.getElementById('isBridging');
        const pilihUnit = document.getElementById('div_stts_kecelakaan');
        $(select).on('change', function() {
            if (select.value > 0 || select.value == null) {
                document.getElementById('div_stts_kecelakaan').style.display = "block";
            } else {
                document.getElementById('div_stts_kecelakaan').style.display = "none";
            }

        });

        function bridgingCheck(value) {
            if (value == "") {
                Swal.fire('silahkan pilih status pendaftaran bpjs bridging atau tidak', '', 'info');
            }
            const diagx = document.getElementById('selectDiagnosa');
            diagx.style.display = value == 1 ? 'block' : 'none';
        }

        function batalDaftar(id, no) {
            var no = no;
            swal.fire({
                icon: 'question',
                title: 'BATALKAN PENDAFTARAN DENGAN NO ' + no,
                showDenyButton: true,
                confirmButtonText: 'Batalkan',
                denyButtonText: `Tidak`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('batalkan.pendaftaranbpjs') }}/?id=" + id;
                    $.ajax({
                        type: "put",
                        url: url,
                        success: function(data) {
                            console.log(data);
                        }
                    });
                    Swal.fire('pendaftaran untuk no ' + no + ' berhasil dibatalkan', '', 'success');
                    window.location.href = "{{ route('pendaftaran-pasien-igdbpjs') }}"
                }
            })
        }

        function backAndDelete(id) {
            swal.fire({
                icon: 'question',
                title: 'Apakah Anda Yakin akan kembali? ',
                showDenyButton: true,
                confirmButtonText: 'Batalkan',
                denyButtonText: `Tidak`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('batalkan.pendaftaranbpjs') }}/?id=" + id;
                    $.ajax({
                        type: "put",
                        url: url,
                        success: function(data) {
                            console.log(data);
                        }
                    });
                    window.location.href = "{{ route('pendaftaran-pasien-igdbpjs') }}"
                }
            })
        }

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
