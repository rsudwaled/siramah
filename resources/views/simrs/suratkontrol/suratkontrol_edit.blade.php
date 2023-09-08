@extends('adminlte::page')

@section('title', 'Edit Surat Kontrol')

@section('content_header')
    <h1>Edit Surat Kontrol</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-7">
            <x-adminlte-card title="Surat Kontrol " theme="secondary">
                <section class="invoice p-3 mb-1">
                    <div class="row">
                        <img src="{{ asset('vendor/adminlte/dist/img/rswaledico.png') }}" style="width: 100px">
                        <div class="col">
                            <b>RUMAH SAKIT UMUM DAERAH WALED KABUPATEN CIREBON</b><br>
                            Jalan Raden Walangsungsang Kecamatan Waled Kabupaten Cirebon 45188<br>
                            www.rsudwaled.id - brsud.waled@gmail.com - Whatasapp 0895 4000 60700 - Call Center (0231) 661126
                        </div>
                        <hr width="100%" hight="20px" class="m-1 " color="black" size="50px" />
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col text-center">
                            <b class="text-md">SURAT KONTROL RAWAT JALAN</b> <br>
                            <b class="text-md">No. {{ $suratkontrol->noSuratKontrol }}</b>
                            <br>
                            <br>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">No RM</dt>
                                <dd class="col-sm-8 m-0">{{ $pasien->no_rm }}</b></dd>
                                <dt class="col-sm-4 m-0">Nama Pasien</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->nama }}</b></dd>
                                <dt class="col-sm-4 m-0">Nomor Kartu</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->noKartu }}</b></dd>
                                <dt class="col-sm-4 m-0">No HP / Telp</dt>
                                <dd class="col-sm-8 m-0">{{ $pasien->no_hp }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->kelamin }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Lahir</dt>
                                <dd class="col-sm-8 m-0">{{ $peserta->tglLahir }}</b></dd>

                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4 m-0">Tanggal Kontrol</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->tglRencanaKontrol }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Terbit</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->tglTerbit }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Kontrol</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaJnsKontrol }}</b></dd>
                                <dt class="col-sm-4 m-0">Poliklinik Tujuan</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaPoliTujuan }}</b></dd>
                                <dt class="col-sm-4 m-0">Dokter</dt>
                                <dd class="col-sm-8 m-0">{{ $suratkontrol->namaDokter }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-6 invoice-col">
                            <dl class="row">
                                <dt class="col-sm-4 m-0">No SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->noSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal SEP</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->tglSep }}</b></dd>
                                <dt class="col-sm-4 m-0">Jenis Pelayanan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->jnsPelayanan }}</b></dd>
                                <dt class="col-sm-4 m-0">Poliklinik</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->poli }}</b></dd>
                                <dt class="col-sm-4 m-0">Diagnosa</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->diagnosa }}</b></dd>
                                <dt class="col-sm-4 m-0">Prov. Perujuk</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->nmProviderPerujuk }}</b></dd>
                                <dt class="col-sm-4 m-0">Asal Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->asalRujukan }}</b></dd>
                                <dt class="col-sm-4 m-0">No Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->noRujukan }}</b></dd>
                                <dt class="col-sm-4 m-0">Tanggal Rujukan</dt>
                                <dd class="col-sm-8 m-0">{{ $sep->provPerujuk->tglRujukan }}</b></dd>
                            </dl>
                        </div>
                        <div class="col-sm-12 ">
                            Dengan ini pasien diatas belum dapat dikembalikan ke Fasilitas Kesehatan Perujuk. Rencana tindak
                            lanjut akan dilanjutkan pada kunjungan selanjutnya.
                            Surat Keterangan ini hanya dapat digunakan 1 (satu) kali pada kunjungan dengan diagnosa diatas.
                        </div>
                        <br>
                        <div class="col-sm-8 mt-1">
                        </div>
                        <div class="col-sm-4 mt-1">
                            <b> Waled, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                                DPJP,</b>

                            <br><br><br><br>
                            <b><u>{{ $dokter->nama_paramedis }}</u></b>
                        </div>
                    </div>
                </section>
            </x-adminlte-card>
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-md-5">
            <x-adminlte-card title="Edit Surat Kontrol" theme="secondary">
                <form action="{{ route('suratkontrol_update') }}" method="POST">
                    @csrf
                    <x-adminlte-input name="noSuratKontrol" igroup-size="sm" label="Nomor Surat Kontrol"
                        placeholder="Nomor SEP" value="{{ $suratkontrol->noSuratKontrol }}" readonly />
                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm" label="Nomor SEP"
                        placeholder="Nomor SEP" value="{{ $sep->noSep }}" readonly />
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm" label="Tanggal Rencana Kontrol"
                        value="{{ $suratkontrol->tglRencanaKontrol }}" placeholder="Pilih Tanggal Rencana Kontrol"
                        :config="$config">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariPoli">
                                <i class="fas fa-search"></i> Cari Poli
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 igroup-size="sm" name="poliKontrol" label="Poliklinik">
                        <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariDokter">
                                <i class="fas fa-search"></i> Cari Dokter
                            </div>
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 igroup-size="sm" name="kodeDokter" label="Dokter">
                        <option selected disabled>Silahkan Klik Cari Dokter</option>
                    </x-adminlte-select2>
                    <button type="submit" class="btn btn-warning withLoad">
                        <i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('suratkontrol_delete') }}?nomorsuratkontrol={{ $suratkontrol->noSuratKontrol }}"
                        class="btn btn-danger withLoad">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)


@section('js')
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.nomorsep-id').val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#poliKontrol').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli.toUpperCase() + " (" + value
                                    .persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('#poliKontrol').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('#poliKontrol').find(":selected").val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#kodeDokter').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('#kodeDokter').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>

@endsection
