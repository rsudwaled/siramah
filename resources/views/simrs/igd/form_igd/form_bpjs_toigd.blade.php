@extends('adminlte::page')

@section('title', 'Pasien IGD')
@section('content_header')
    <h1>Pasien IGD : {{ $pasien->nama_px }}</h1>
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
                                <div class="col-lg-10">
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
                                <div class="col-lg-2">
                                    @if ($knj_aktif > 0)
                                        <button type="button" class="btn btn-block bg-gradient-primary btn-sm mb-2"
                                            data-toggle="modal" data-target="#tutupKunjungan">Tutup
                                            kunjungan</button>
                                        <button type="button" class="btn btn-block bg-gradient-danger btn-sm mb-2">Ada
                                            Kunjungan Yang Masih Aktif</button>
                                    @else
                                        <button type="button" class="btn btn-block bg-gradient-warning btn-sm mb-2"
                                            data-toggle="modal" data-target="#bukaKunjungan">Buka
                                            kunjungan</button>
                                    @endif

                                    <x-adminlte-modal id="tutupKunjungan" title="Tutup Kunjungan RM {{ $pasien->no_rm }}"
                                        size="lg" theme="primary" v-centered static-backdrop>
                                        <form action="{{ route('tutup-kunjungan-pigd') }}" id="tutupKunjunganbyCounter"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <x-adminlte-input name="rm_tk" label="No RM"
                                                                value="{{ $pasien->no_rm }}" disable-feedback disabled />
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <x-adminlte-input name="kunjungan_tk" label="Kode Kunjungan"
                                                                placeholder="masukan kode kunjungan" disable-feedback />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button theme="danger" class="mr-auto" label="batal"
                                                    data-dismiss="modal" />
                                                <x-adminlte-button type="submit" form="tutupKunjunganbyCounter"
                                                    class="btn btn-sm m-1 bg-green float-right" label="Tutup Kunjungan" />
                                            </x-slot>
                                        </form>
                                    </x-adminlte-modal>
                                    <x-adminlte-modal id="bukaKunjungan" title="Buka Kunjungan RM {{ $pasien->no_rm }}"
                                        size="lg" theme="warning" v-centered static-backdrop>
                                        <form action="{{ route('buka-kunjungan-pigd') }}" method="post"
                                            id="bukaKunjunganbyCounter">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <x-adminlte-input name="rm_tk" label="No RM"
                                                                value="{{ $pasien->no_rm }}" disable-feedback disabled />
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <x-adminlte-input name="kunjungan_tk" label="Kode Kunjungan"
                                                                placeholder="masukan kode kunjungan" disable-feedback />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button theme="danger" class="mr-auto" label="batal"
                                                    data-dismiss="modal" />
                                                <x-adminlte-button theme="success" type="submit"
                                                    form="bukaKunjunganbyCounter" label="Buka Kunjungan" />
                                            </x-slot>
                                        </form>
                                    </x-adminlte-modal>
                                </div>
                            </div>
                        </div>
                    </x-adminlte-card>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
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
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" size="sm" id="div_rajal" icon="fas fa-info-circle"
                                collapsible title="Form Pendaftaran">
                                <form action="{{ route('pendaftaran-igd.igdstore') }}" id="formPendaftaranIGD"
                                    method="post">
                                    @csrf
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <input type="hidden" value="{{ $antrian->id }}" name="id_antrian">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="nama_pasien"
                                                                value="{{ $pasien->nama_px }}" disabled
                                                                label="Nama Pasien" enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">
                                                                        {{ $pasien->no_rm }}</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                            <input type="hidden" name="nik"
                                                                value="{{ $pasien->nik_bpjs }}">
                                                            <input type="hidden" name="rm"
                                                                value="{{ $pasien->no_rm }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="unit_ugd_id" value="1002" disabled
                                                                label="Daftar UGD" placeholder="UGD" enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">UGD</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                            <input type="hidden" name="unit" value="1002">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                                <option value="">--Pilih Dokter--</option>
                                                                @foreach ($paramedis as $item)
                                                                    <option value="{{ $item->kode_paramedis }}">
                                                                        {{ $item->nama_paramedis }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tanggal"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal" :config="$config" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                                                <option value="">--Pilih Penjamin--</option>
                                                                @foreach ($penjamin as $item)
                                                                    <option value="{{ $item->kode_penjamin }}">
                                                                        {{ $item->nama_penjamin }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select2 name="alasan_masuk_id"
                                                                label="Alasan Pendaftaran">
                                                                <option value="">--Pilih Alasan--</option>
                                                                @foreach ($alasanmasuk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->alasan_masuk }}</option>
                                                                @endforeach
                                                            </x-adminlte-select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($knj_aktif == 0)
                                            <x-adminlte-button type="submit"
                                                class="withLoad btn btn-sm m-1 bg-green float-right" id="submitPasien"
                                                label="Simpan Data" />
                                        @else
                                            <x-adminlte-button class=" btn btn-sm m-1 bg-danger float-right"
                                                label="tidak bisa lanjut daftar" />
                                        @endif
                                    </div>
                                </form>
                            </x-adminlte-card>
                        </div>
                    </div>
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
    
        function getID(rID, pasien_id) {
            var ruangan_terpilih = rID;
            var pasien_id = pasien_id;
            swal.fire({
                title: 'YAKIN PILIH RUANGAN INI?',
                showDenyButton: true,
                confirmButtonText: 'Pilih Sekarang',
                denyButtonText: `Batal`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pilih-ruangan') }}",
                        data: {
                            ruangan_id: ruangan_terpilih,
                            pasien_id: pasien_id
                        },
                        success: function(data) {
                            // alert(data.success);
                        },
                    });
                    Swal.fire('Ruangan Sudah di Pilih!', '', 'success')
                    $('.modalruangan').modal('hide')


                } else if (result.isDenied) {
                    Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
                }
            })
        }

        $("#submitPernyataan").click(function(e) {

            e.preventDefault();

            var nama_keluarga_sp = $("#nama_keluarga_sp").val();
            var rm_sp = $("#rm_sp").val();
            var alamat_keluarga_sp = $("#alamat_keluarga_sp").val();
            var tlp_keluarga_sp = $("#tlp_keluarga_sp").val();
            var tgl_surat_pernyataan_sp = $("#tgl_surat_pernyataan").val();
            var hub_keluarga_sp = $("#hub_keluarga_sp").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: 'POST',
                url: "{{ route('surat-pernyataan.bpjsproses') }}",
                data: {
                    rm_sp: rm_sp,
                    nama_keluarga_sp: nama_keluarga_sp,
                    tlp_keluarga_sp: tlp_keluarga_sp,
                    tgl_surat_pernyataan_sp: tgl_surat_pernyataan_sp,
                    hub_keluarga_sp: hub_keluarga_sp,
                    alamat_keluarga_sp: alamat_keluarga_sp,
                    _token: token,
                },
                success: function(data) {
                    $('#modalBPJSPROSES').modal('hide');
                    $.LoadingOverlay("hide");
                    Swal.fire('pernyataan berhasil dibuat', '', 'success');
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

        function cariRujukan(rm) {
            var rujukan_rm = rm;
            $('#modalRujukan').show();
        }
    </script>
@endsection
