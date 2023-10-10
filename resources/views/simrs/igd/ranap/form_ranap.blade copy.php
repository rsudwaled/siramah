@extends('adminlte::page')

@section('title', 'Ranap Umum')
@section('content_header')
    <h1>Ranap Umum : {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- <div class="row">
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
                    <x-adminlte-card theme="primary" collapsible title="Riwayat Kunjungan Hari Ini:">
                        @php
                            $heads = ['Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Petugas'];
                            $config['order'] = ['0', 'asc'];
                            $config['paging'] = false;
                            $config['info'] = false;
                            $config['scrollY'] = '450px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                        @endphp
                        <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config" striped
                            bordered hoverable compressed>
                            @foreach ($kunjungan as $item)
                                <tr>
                                    <td>{{ $item->counter }}</td>
                                    <td>{{ $item->kode_kunjungan }}</td>
                                    <td>{{ $item->unit->nama_unit }}</td>
                                    <td>{{ $item->tgl_masuk }}</td>
                                    <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                                    <td>{{ $item->nama_penjamin }}</td>
                                    <td>{{ $item->nama_user }}</td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
            </div> --}}
            <div class="row">
                @if ($pasien->no_Bpjs == null)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>Status Pasien :</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a class="btn btn-app btn-block bg-maroon"><i class="fas fa-users"></i> PASIEN
                                                UMUM</a>
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
                @else
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-block bg-gradient-success btn-sm mb-2">Pasien Naik
                                    Kelas</button>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <x-adminlte-select name="naikKelasPembiyaan" label="Pembiayaan">
                                        <option value="0">--Pilih Pembiayaan--</option>
                                        <option value="1">Pribadi</option>
                                        <option value="2">Pemberi Kerja</option>
                                        <option value="3">Asuransi Kesehatan Tambahan</option>
                                    </x-adminlte-select>
                                </div>
                                <div class="col-md-12">
                                    <x-adminlte-input name="nama_pj" label="Nama PenanggungJawab"
                                        placeholder="masukan nama pj" label-class="text-black">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text">
                                                <i class="fas fa-user text-black"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                </div>
                                <div class="col-lg-12">
                                    <x-adminlte-button label="Open Modal" data-toggle="modal" data-target="#pilihRuangan"
                                        class="bg-purple" />
                                    <x-adminlte-modal id="pilihRuangan" title="Theme Purple" theme="purple"
                                        icon="fas fa-bolt" size='xl' disable-animations>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="position-relative p-3 bg-green" style="height: 100px; border-radius: 2%;">
                                                    <div class="ribbon-wrapper ribbon-sm">
                                                        <div class="ribbon bg-warning text-sm">
                                                            KOSONG
                                                        </div>
                                                    </div>
                                                    <h6>DAHLIA</h6> <br> NO BED : 08 <br>
                                                    <small>.ribbon-wrapper.ribbon-xl .ribbon.text-xl</small>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="position-relative p-3 bg-danger" style="height: 100px; border-radius: 2%;">
                                                    <div class="ribbon-wrapper ribbon-sm">
                                                        <div class="ribbon bg-primary text-sm">
                                                            TERISI
                                                        </div>
                                                    </div>
                                                    <h6>ANGREK</h6> <br> NO BED : 08 <br>
                                                    <small>.ribbon-wrapper.ribbon-xl .ribbon.text-xl</small>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </x-adminlte-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-adminlte-card theme="success" id="div_ranap" icon="fas fa-info-circle" collapsible
                                title="Form Pendaftaran">
                                <form action="{{ route('pasienranap.store') }}" method="post" id="submitRanap">
                                    @csrf
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-input name="nama_pasien"
                                                                value="{{ $pasien->nama_px }}" disabled label="Nama Pasien"
                                                                enable-old-support>
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text text-olive">
                                                                        {{ $pasien->no_rm }}</div>
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
                                                    </div>
                                                </div>
                                                <input type="hidden" name="kodeKunjungan" value=" {{ $refKunj }}">
                                                <input type="hidden" name="noMR" value=" {{ $pasien->no_rm }}">
                                                {{-- <input type="hidden" name="ruangan" id="ruanganSend">
                                                <input type="hidden" name="bed" id="bedSend"> --}}
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-adminlte-select name="hak_kelas" label="Hak Kelas">
                                                                <option value="1">KELAS 1</option>
                                                                <option value="2">KELAS 2</option>
                                                                <option value="3">KELAS 3</option>
                                                                <option value="4">VIP</option>
                                                                <option value="5">VVIP</option>
                                                            </x-adminlte-select>
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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <x-adminlte-select name="unitTerpilih" id="unitTerpilih"
                                                                label="Ruangan">
                                                                @foreach ($unit as $item)
                                                                    <option value="{{ $item->kode_unit }}">
                                                                        {{ $item->nama_unit }}</option>
                                                                @endforeach
                                                            </x-adminlte-select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <x-adminlte-select name="kelas_rawat" id="r_kelas_id"
                                                                label="Kelas Rawat">
                                                                <option value="1">KELAS 1</option>
                                                                <option value="2">KELAS 2</option>
                                                                <option value="3">KELAS 3</option>
                                                                <option value="4">VIP</option>
                                                                <option value="5">VVIP</option>
                                                            </x-adminlte-select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <x-adminlte-select name="bed_byruangan" id="bed_byruangan"
                                                                label="No BED">
                                                            </x-adminlte-select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
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
                                                            <x-adminlte-input name="noTelp" label="No Telp"
                                                                placeholder="masukan no telp" label-class="text-black">
                                                                <x-slot name="prependSlot">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-phone text-black"></i>
                                                                    </div>
                                                                </x-slot>
                                                            </x-adminlte-input>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-button type="submit"
                                            class="withLoad btn btn-sm m-1 bg-green float-right" form="submitRanap"
                                            label="Simpan Data" />
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
        $('#r_kelas_id').change(function() {
            var unit = $('#unitTerpilih').val();
            var kelas = $(this).val();
            // alert(unit);
            if (kelas) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('bed-ruangan.get') }}?unit=" + unit + '&kelas=' + kelas,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            console.log(res);
                            $("#bed_byruangan").empty();
                            $("#bed_byruangan").append('<option>--Pilih Bed--</option>');
                            $.each(res.bed, function(key, value) {
                                var bed = value.no_bed;
                                var kamar = value.nama_kamar;
                                if (bed == 0) {
                                    var stts = '|| terisi';
                                } else {
                                    var stts = '|| kosong';
                                }
                                console.log(bed);
                                $("#bed_byruangan").append('<option value="' + value
                                    .id_ruangan + '">' + value.nama_kamar +
                                    ' || No: ' + value.no_bed + ' ' + stts + '</option>');
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

        // $('#ruanganSend').change(function() {
        //     var ruangan = $(this).val();
        //     $("#ruanganSend").val(ruangan);
        //     $('#bedSend').change(function() {
        //         var bed_byruangan = $(this).val();
        //         $("#bedSend").val(bed_byruangan);
        //     });
        // });
    </script>
@endsection
