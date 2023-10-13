@extends('adminlte::page')

@section('title', 'RANAP BPJS')
@section('content_header')
    <h1>RANAP BPJS : {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ $pasien->nama_px }}</h3>
                            <p class="text-muted text-center">RM : {{ $pasien->no_rm }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Jrnis Kelamin :
                                        {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b></li>
                                <li class="list-group-item"><b>Alamat : {{ $pasien->alamat }}</b></li>
                                <li class="list-group-item"><b>NIK : {{ $pasien->nik_bpjs }}</b></li>
                                <li class="list-group-item"><b>BPJS :
                                        {{ $pasien->no_Bpjs == null ? 'tidak punya bpjs' : $pasien->no_Bpjs }}</b></li>
                            </ul>
                            <a class="btn btn-primary bg-gradient-primary btn-block"><b>--</b></a>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <x-adminlte-card theme="primary" collapsible title="Riwayat Kunjungan :">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Counter</td>
                                    <td>Kode Kunjungan</td>
                                    <td>Unit</td>
                                    <td>Tgl Masuk</td>
                                    <td>Tgl Keluar</td>
                                    <td>Penjamin</td>
                                    <td>Petugas</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kunjungan as $item)
                                    <tr>
                                        <td>{{ $item->counter }}</td>
                                        <td>{{ $item->kode_kunjungan }}</td>
                                        <td>{{ $item->unit->nama_unit }}</td>
                                        <td>{{ $item->tgl_masuk }}</td>
                                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}
                                        </td>
                                        <td>{{ $item->nama_penjamin }}</td>
                                        <td>{{ $item->nama_user }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-adminlte-card>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success card-outline">
                        <div class="card-body">
                            <button type="button" class="btn btn-block bg-gradient-primary btn-sm mb-2"id="editSPRI" data-toggle="modal"
                            data-target="#createSPRI">Edit SPRI</button>
                            <button type="button" class="btn btn-block bg-gradient-maroon btn-sm mb-2" id="hapusSPRI">HAPUS SPRI</button>
                            <x-adminlte-modal id="createSPRI" title="SPRI" theme="primary" size='lg'
                                disable-animations>
                                <form id="createSPRI">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-input name="noKartu" value="{{ $pasien->no_Bpjs }}"
                                                label="No Kartu" disabled />
                                        </div>
                                        <div class="col-md-6">
                                            @php
                                                $config = ['format' => 'YYYY-MM-DD'];
                                            @endphp
                                            <x-adminlte-input-date name="tglRencanaKontrol" id="tanggal"
                                                value="{{ $spri->tglRencanaKontrol==null? Carbon\Carbon::now()->format('Y-m-d') :  $spri->tglRencanaKontrol}}" label="Tanggal Masuk"
                                                :config="$config" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-select2 name="poliKontrol" label="poliKontrol" id="poliklinik">
                                                <option selected disabled>Cari Poliklinik</option>
                                            </x-adminlte-select2>
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-select2 name="kodeDokter" label="Dokter DPJP" id="dokter">
                                                <option value="">--Pilih Dpjp--</option>
                                                @foreach ($paramedis as $item)
                                                    <option value="{{ $item->kode_dokter_jkn }}">
                                                        {{ $item->nama_paramedis }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button type="submit" theme="primary" form="createSPRI"
                                            class="btnUpdateSPRI" label="Update SPRI" />
                                        <x-adminlte-button theme="danger" label="batal" data-dismiss="modal" />
                                    </x-slot>
                                </form>
                            </x-adminlte-modal>
                            <div class="col-md-12">
                                <x-adminlte-select2 name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kode_unit }}">
                                            {{ $item->nama_unit }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-select name="kelas_rawat" id="r_kelas_id" label="Kelas Rawat" disabled>
                                    <option value="1" {{ $kodeKelas == 1 ? 'selected' : '' }}>KELAS 1</option>
                                    <option value="2" {{ $kodeKelas == 2 ? 'selected' : '' }}>KELAS 2</option>
                                    <option value="3" {{ $kodeKelas == 3 ? 'selected' : '' }}>KELAS 3</option>
                                    <option value="4" {{ $kodeKelas == 4 ? 'selected' : '' }}>VIP</option>
                                    <option value="5" {{ $kodeKelas == 5 ? 'selected' : '' }}>VVIP</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12">
                                <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="0" name="naikKelasRawat" id="naikKelasRawat">
                                    <label for="naikKelasRawat"></label>
                                </div>

                                <span class="text text-red"><b id="textDescChange">ceklis apabila pasien naik kelas
                                        rawat</b></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <x-adminlte-button label="Cari Ruangan" data-toggle="modal" data-target="#pilihRuangan"
                                id="cariRuangan" class="bg-purple btn-block" />
                            <a href="#" class="btn bg-teal btn-block" id="showBed" style="display: none">
                                <i class="fas fa-bed"></i>
                            </a>
                            <a href="#" class="btn btn-primary btn-block" id="showRuangan" style="display: none">
                                <i class="fas fa-bed"></i> Tidak ada
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" id="div_ranap" icon="fas fa-info-circle" collapsible
                                title="Form Pendaftaran">
                                <form action="{{ route('pasienranapbpjs.store') }}" method="post" id="submitRanap">
                                    @csrf
                                    <input type="hidden" name="kodeKunjungan" value=" {{ $refKunj }}">
                                    <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                    <input type="hidden" name="idRuangan" id="ruanganSend">
                                    <input type="hidden" name="crad" id="c_rad">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
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
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="nik_pasien"
                                                                value="{{ $pasien->nik_bpjs }}" disabled
                                                                label="NIK Pasien" enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">
                                                                        NIK PASIEN</div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $config = ['format' => 'YYYY-MM-DD'];
                                                            @endphp
                                                            <x-adminlte-input-date name="tanggal_daftar"
                                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                label="Tanggal Masuk" :config="$config" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input label="No SPRI" name="noSuratKontrol"
                                                                id="noSuratKontrol" value="{{$spri->noSPRI}}"
                                                                label-class="text-black" disabled>
                                                            </x-adminlte-input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="noTelp" label="No Telp"
                                                                placeholder="masukan no telp" label-class="text-black">
                                                            </x-adminlte-input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="hak_kelas"
                                                                value="{{ $kodeKelas }}"
                                                                placeholder="{{ $kelas }}" label="Hak Kelas"
                                                                disabled />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="penjamin_id" label="Pilih Penjamin">
                                                                <option value="">--Pilih Penjamin--</option>
                                                                @foreach ($penjamin as $item)
                                                                    <option value="{{ $item->kode_penjamin }}">
                                                                        {{ $item->nama_penjamin }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="alasan_masuk_id"
                                                                label="Alasan Pendaftaran">
                                                                <option value="">--Pilih Alasan--</option>
                                                                @foreach ($alasanmasuk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->alasan_masuk }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="dpjp" label="pilih dpjp">
                                                                <option value="">--Pilih Dpjp--</option>
                                                                @foreach ($paramedis as $item)
                                                                    <option value="{{ $item->kode_paramedis }}">
                                                                        {{ $item->nama_paramedis }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right" form="submitRanap"
                                            label="Simpan Data" />
                                        <a href="{{ route('kunjungan.ranap') }}"
                                            class="btn btn-secondary btn-flat m-1 btn-sm float-right">Kembali</a>
                                    </div>
                                </form>
                            </x-adminlte-card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-adminlte-modal id="pilihRuangan" title="List Ruangan Tersedia" theme="success" icon="fas fa-bed" size='xl'
        disable-animations>
        <div class="row listruangan" id="idRuangan"></div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $('#cariRuangan').on('click', function() {
            // $("#pilihRuangan").show();
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
                                    value.id_ruangan + ', `' + value.nama_kamar + '`, ' +
                                    value.no_bed +
                                    ')" style="height: 100px; width: 150px; margin=5px; border-radius: 2%;"><div class="ribbon-wrapper ribbon-sm"><div class="ribbon bg-warning text-sm">KOSONG</div></div><h6 class="text-left">"' +
                                    value.nama_kamar + '"</h6> <br> NO BED : "' + value
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
                    $("#ruanganSend").val(id);
                    $('#pilihRuangan').modal('toggle');
                    $("#showRuangan").text('RUANGAN : ' + nama);
                    $("#showBed").text('NO : ' + bed);
                    $("#showRuangan").css("display", "block");
                    $("#showBed").css("display", "block");
                    $(".ruanganCheck").remove();
                }
            })
        }

        function batalPilih() {
            $(".ruanganCheck").remove();
        }

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#poliklinik").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_poliklinik_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            poliklinik: params.term // search term
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
            $('#naikKelasRawat').click(function(e) {
                if (this.checked) {
                    $("#r_kelas_id").removeAttr("disabled");
                    $("#textDescChange").text("pasien memilih naik kelas rawat");
                    $("#c_rad").val(1);
                } else {
                    $("#r_kelas_id").attr("disabled", true);
                    $("#textDescChange").text("ceklis apabila pasien naik kelas rawat / edit kelas");
                    $("#c_rad").val(0);
                }
            });
            $('#submitRanap').click(function(e) {
                
            });
            $('#editSPRI').click(function(e) {
                var nomorsuratkontrol = $('#noSuratKontrol').val();
                // $.LoadingOverlay("show");
                // $.get(url, function(data) {
                //     $('#nama_suratkontrol').val(data.nama);
                //     $('#nomor_suratkontrol').val(data.noSuratKontrol);
                //     $('#nomorsep_suratkontrol').val(data.noSepAsalKontrol);
                //     $('#tanggal_suratkontrol').val(data.tglRencanaKontrol);
                //     $('#kodepoli_suratkontrol').val(data.poliTujuan).trigger('change');
                //     $('#kodedokter_suratkontrol').val(data.kodeDokter).trigger('change');
                //     $('#modalSuratKontrol').modal('show');
                //     $.LoadingOverlay("hide", true);
                // });
                // var url = "{{route('spri.update')}}?noSPRI="+noSPRI;

            });
            $("#hapusSPRI").hide();
            $('#hapusSPRI').click(function(e) {
                var noSPRI = $('#noSuratKontrol').val();
                swal.fire({
                    icon: 'question',
                    title: 'ANDA YAKIN HAPUS NO SPRI ' + noSPRI + ' ?',
                    showDenyButton: true,
                    confirmButtonText: 'Hapus',
                    denyButtonText: `Batal`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('spri_delete') }}";
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                noSuratKontrol: noSPRI,
                                user:'coba',
                            },
                            success: function(data) {

                                if (data.metadata.code == 200) {
                                    Swal.fire('SPRI BERHASIL DIHAPUS', '', 'success');
                                    location.reload();
                                } else {
                                    Swal.fire(data.metadata.message + '( ERROR : ' +
                                        data.metadata
                                        .code + ')', '', 'error');
                                }
                            },

                        });
                    }
                })
            });
        });
    </script>
@endsection
