@extends('adminlte::page')
@section('title', 'ERM Ranap ' . $pasien->nama_px)
@section('content_header')
    <h1>ERM Ranap {{ $pasien->nama_px }}</h1>
@stop
@section('content')
    @php
        $total = 0;
    @endphp
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('kunjunganranap') }}?kodeunit={{ $kunjungan->kode_unit }}"
                class="btn btn-xs mb-2 btn-danger withLoad"><i class="fas fa-arrow-left"></i> Kembali</a>
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('simrs.ranap.erm_ranap_profil')
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs mb-1 btnRiwayatKunjungan" theme="warning" label="Riwayat Kunjungan"
                        icon="fas fa-search" />
                    <x-adminlte-button class="btn-xs mb-1" onclick="lihatHasilLaboratorium()" theme="warning"
                        label="Laboratorium" icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1" onclick="lihatHasilRadiologi()" theme="warning" label="Radiologi"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1" onclick="lihatLabPa()" theme="warning" label="Patologi Anatomi"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1 " theme="warning" label="Berkas Upload"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1 btnCariRujukanFKTP" theme="primary" label="Rujukan FKTP"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1 btnCariRujukanRS" theme="primary" label="Rujukan RS"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1 btnCariSEP" theme="primary" label="SEP"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1" onclick="cariSuratKontrol()" theme="primary"
                        label="Surat Kontrol" icon="fas fa-file-medical" />
                </x-slot>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayat --}}
                        {{-- @include('simrs.ranap.erm_ranap_riwayat') --}}
                        {{-- IGD --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cIGD">
                                <h3 class="card-title">
                                    Riwayat & Triase IGD
                                </h3>
                            </a>
                            <div id="cIGD" class="collapse" role="tabpanel">
                                <div class="card-body p-0">
                                    {{-- <iframe
                                        src="http://192.168.2.30/simrs/public/scanner/tmp/22965731-23122108034448266.pdf"
                                        height="780" width="100%" frameborder="0"></iframe> --}}
                                </div>
                            </div>
                        </div>
                        {{-- rincian --}}
                        {{-- @include('simrs.ranap.erm_ranap_biaya') --}}
                        <div id="rincian_biaya"></div>
                        {{-- administrasi --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAdministrasi">
                                <h3 class="card-title">
                                    Administrasi Kunjungan
                                </h3>
                            </a>
                            <div id="cAdministrasi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="" name="formAdm" id="formAdm" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                        @endphp
                                        <x-adminlte-input-date name="tgl_masuk" class="tgl_masuk-id" label="Tgl Masuk"
                                            value="{{ $kunjungan->tgl_masuk }}" igroup-size="sm" :config="$config"
                                            readonly />
                                        <x-adminlte-input-date name="tgl_keluar" class="tgl_keluar-id" label="Tgl Keluar"
                                            value="{{ $kunjungan->tgl_keluar }}" igroup-size="sm" :config="$config"
                                            readonly />
                                        <input type="hidden" name="kodekunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                                        <x-adminlte-input name="no_sep" placeholder="No SEP" igroup-size="sm"
                                            label="No SEP" enable-old-support required value="{{ $kunjungan->no_sep }}" />
                                        <button type="submit" form="formAdm" class="btn btn-success">
                                            <i class="fas fa-edit"></i> Update Administrasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        {{-- groupping --}}
                        @include('simrs.ranap.erm_ranap_groupping')
                        {{-- perkembangan --}}
                        @include('simrs.ranap.erm_ranap_catatan_pekembangan_pasien')
                        {{-- keperawatan --}}
                        @include('simrs.ranap.erm_ranap_keperawatan')
                        {{-- observasi --}}
                        @include('simrs.ranap.erm_ranap_observasi')
                        {{-- KPO --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cKPO">
                                <h3 class="card-title">
                                    KPO Elektronik
                                </h3>
                            </a>
                            <div id="cKPO" class="collapse" role="tabpanel">
                                <div class="card-body p-0">
                                    <iframe id="kpoFrame" src="" height="780" width="100%"
                                        frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                        {{-- tindakan --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cTindakanDokter">
                                <h3 class="card-title">
                                    Pemberian Tindakan Kedokteran
                                </h3>
                            </a>
                            <div id="cTindakanDokter" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- konsultasi --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cKonsultasi">
                                <h3 class="card-title">
                                    Pemeriksaan Konsultasi
                                </h3>
                            </a>
                            <div id="cKonsultasi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- nyeri --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cNyeri">
                                <h3 class="card-title">
                                    Pengkajian Nyeri
                                </h3>
                            </a>
                            <div id="cNyeri" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- jatuh --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cJatuh">
                                <h3 class="card-title">
                                    Pengkajian Resiko Jatuh
                                </h3>
                            </a>
                            <div id="cJatuh" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- mpp form a --}}
                        @include('simrs.ranap.erm_ranap_mppa')
                        {{-- mpp form b --}}
                        @include('simrs.ranap.erm_ranap_mppb')
                        {{-- resume --}}
                        @include('simrs.ranap.erm_ranap_resume')
                        {{-- laboratorium --}}
                        {{-- @include('simrs.ranap.erm_ranap_lab') --}}
                        {{-- radiologi --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRadiologi">
                                <h3 class="card-title">
                                    Radiologi
                                </h3>
                            </a>
                            <div id="cRadiologi" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- tindakan --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cTindakan">
                                <h3 class="card-title">
                                    Tindakan
                                </h3>
                            </a>
                            <div id="cTindakan" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- resep --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cResepObat">
                                <h3 class="card-title">
                                    Resep Obat
                                </h3>
                            </a>
                            <div id="cResepObat" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                        {{-- suratkontrol --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                href="#cSuratKontrol">
                                <h3 class="card-title">
                                    Surat Kontrol
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->surat_kontrol)
                                        Sudah Dibuatkan Surat Kontrol {{ $kunjungan->surat_kontrol->noSuratKontrol }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dibuatkan Surat Kontrol <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cSuratKontrol" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    @if ($kunjungan->surat_kontrol)
                                        <input type="hidden" name="nomorsuratkontrol" class="nomorsuratkontrol-id"
                                            value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}">
                                        <form action="{{ route('suratkontrol_update_v2') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSuratKontrol" igroup-size="sm"
                                                        label="Nomor Surat Kontrol" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSuratKontrol }}" readonly />
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" placeholder="Nomor SEP"
                                                        value="{{ $kunjungan->surat_kontrol->noSepAsalKontrol }}"
                                                        readonly />
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        value="{{ $kunjungan->surat_kontrol->tglRencanaKontrol }}"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select2 igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
                                                        <option value="{{ $kunjungan->surat_kontrol->poliTujuan }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaPoliTujuan }}
                                                        </option>
                                                        <option disabled>Silahkan Klik Cari Poliklinik</option>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariDokter">
                                                                <i class="fas fa-search"></i> Cari Dokter
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-select2>
                                                    <x-adminlte-select2 igroup-size="sm" name="kodeDokter"
                                                        label="Dokter">
                                                        <option value="{{ $kunjungan->surat_kontrol->kodeDokter }}"
                                                            selected>{{ $kunjungan->surat_kontrol->namaDokter }}</option>
                                                        <option disabled>Silahkan Klik Cari Dokter</option>
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning withLoad">
                                                <i class="fas fa-save"></i> Update</button>
                                            <div class="btn  btn-success btnPrintSuratKontrol"> <i
                                                    class="fas fa-print"></i> Print</div>
                                            <a href="{{ route('suratkontrol_delete') }}?nomorsuratkontrol={{ $kunjungan->surat_kontrol->noSuratKontrol }}"
                                                class="btn btn-danger withLoad">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </form>
                                    @else
                                        <form action="{{ route('suratkontrol_simpan') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="counter" id="counter"
                                                value="{{ $kunjungan->counter }}" class="counter-id" value="">
                                            <input type="hidden" name="kodekunjungan" id="kodekunjungan"
                                                class="kodekunjungan-id" value="{{ $kunjungan->kode_kunjungan }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-input name="noSEP" class="nomorsep-id" igroup-size="sm"
                                                        label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                        placeholder="Nomor SEP" readonly>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariSEP">
                                                                <i class="fas fa-search"></i> Cari SEP
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input>
                                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                        value="{{ $pasien->no_Bpjs }}" igroup-size="sm"
                                                        label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                                                    <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                        igroup-size="sm" placeholder="No RM "
                                                        value="{{ $pasien->no_rm }}" readonly />
                                                    <x-adminlte-input name="nama" class="nama-id"
                                                        value="{{ $pasien->nama_px }}" label="Nama Pasien"
                                                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                        igroup-size="sm" placeholder="Nomor HP" />
                                                </div>
                                                <div class="col-md-6">
                                                    @php
                                                        $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                        label="Tanggal Rencana Kontrol"
                                                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariPoli">
                                                                <i class="fas fa-search"></i> Cari Poli
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-input-date>
                                                    <x-adminlte-select igroup-size="sm" name="poliKontrol"
                                                        label="Poliklinik">
                                                        <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                                                        <x-slot name="appendSlot">
                                                            <div class="btn btn-primary btnCariDokter">
                                                                <i class="fas fa-search"></i> Cari Dokter
                                                            </div>
                                                        </x-slot>
                                                    </x-adminlte-select>
                                                    <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                                                        <option selected disabled>Silahkan Klik Cari Dokter</option>
                                                    </x-adminlte-select>
                                                    <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                                        placeholder="Catatan Pasien" />
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-warning withLoad"> <i
                                                    class="fas fa-save"></i>
                                                Buat
                                                Surat Kontrol</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                        {{-- pemulangan --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cPulang">
                                <h3 class="card-title">
                                    Pemulangan Pasien
                                </h3>
                                <div class="card-tools">
                                    @if ($kunjungan->tgl_keluar)
                                        Sudah Dipulangkan {{ $kunjungan->tgl_keluar }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Dipulangkan <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="cPulang" class="collapse" role="tabpanel">
                                <div class="card-body">
                                    <form action="{{ route('pemulangan_sep_pasien') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kodebooking" class="kodebooking-id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                                    value="{{ $pasien->no_Bpjs }}" igroup-size="sm" label="Nomor Kartu"
                                                    placeholder="Nomor Kartu" readonly />
                                                <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                    igroup-size="sm" placeholder="No RM " value="{{ $pasien->no_rm }}"
                                                    readonly />
                                                <x-adminlte-input name="nama" class="nama-id"
                                                    value="{{ $pasien->nama_px }}" label="Nama Pasien" igroup-size="sm"
                                                    placeholder="Nama Pasien" readonly />
                                                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                    igroup-size="sm" placeholder="Nomor HP" />
                                                <input type="hidden" name="gender"
                                                    value="{{ $pasien->jenis_kelamin }}">
                                                <input type="hidden" name="tgllahir" value="{{ $pasien->tgl_lahir }}">
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-input name="noSep" class="nomorsep-id" igroup-size="sm"
                                                    label="Nomor SEP" value="{{ $kunjungan->no_sep }}"
                                                    placeholder="Nomor SEP" readonly>
                                                    <x-slot name="appendSlot">
                                                        <div class="btn btn-primary btnCariSEP">
                                                            <i class="fas fa-search"></i> Cari SEP
                                                        </div>
                                                    </x-slot>
                                                </x-adminlte-input>
                                                <x-adminlte-select igroup-size="sm" name="statusPulang"
                                                    label="Alasan Pulang">
                                                    <option selected disabled>Pilih Alasan Pulang</option>
                                                    <option value="1">Atas Persetujuan Dokter</option>
                                                    <option value="3">Atas Permintaan Sendiri</option>
                                                    <option value="4">Meninggal</option>
                                                    <option value="5">Lain-lain</option>
                                                </x-adminlte-select>
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <x-adminlte-input-date name="tglPulang" igroup-size="sm"
                                                    label="Tanggal Pulang" value="{{ now()->format('Y-m-d') }}"
                                                    placeholder="Pilih Tanggal Pulang" :config="$config" />
                                                <p class="text-danger">Isi Jika Pasien Meninggal</p>
                                                <x-adminlte-input-date name="tglMeninggal" igroup-size="sm"
                                                    label="Tanggal Meninggal" placeholder="Pilih Tanggal Meninggal"
                                                    :config="$config" />
                                                <x-adminlte-input name="noSuratMeninggal" class="suratmeninggal-id"
                                                    igroup-size="sm" label="Nomor Surat Meninggal"
                                                    placeholder="Nomor Surat Meninggal" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning withLoad">
                                            <i class="fas fa-save"></i> Pulangkan Pasien</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- filepenunjang --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collapseFile">
                                <h3 class="card-title">
                                    File Penunjang
                                </h3>
                            </a>
                            <div id="collapseFile" class="collapse" role="tabpanel" aria-labelledby="headFile">
                                <div class="card-body">
                                    test
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn  btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>

@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
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
        $(function() {
            getRincianBiaya();
        });

        function getRincianBiaya() {
            var url =
                "{{ route('get_rincian_biaya') }}?norm={{ $kunjungan->no_rm }}&counter={{ $kunjungan->counter }}";
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
    @include('simrs.ranap.erm_ranap_lab')
    @include('simrs.ranap.erm_ranap_rad')
    @include('simrs.ranap.erm_ranap_patologi')
    {{-- suratkontrol --}}
    <x-adminlte-modal id="modalCariSuratKontrol" name="modalCariSuratKontrol" title="Surat Kontrol Pasien"
        theme="success" icon="fas fa-file-medical" size="xl">
        <form name="formCariSuratKontrol" id="formCariSuratKontrol">
            <div class="row">
                <div class="col-4">
                    @php
                        $config = ['format' => 'YYYY-MM'];
                    @endphp
                    <x-adminlte-input-date igroup-size="sm" name="bulan" label="Tanggal Antrian" :config="$config"
                        value="{{ now()->format('Y-m') }}" placeholder="Pilih Bulan">
                    </x-adminlte-input-date>
                </div>
                <div class="col-4">
                    <x-adminlte-input igroup-size="sm" name="nomorkartu" label="Nomor Kartu"
                        value="{{ $pasien->no_Bpjs }}" placeholder="Pencarian Berdasarkan Nomor Kartu BPJS">
                    </x-adminlte-input>
                </div>
                <div class="col-4">
                    <x-adminlte-select2 igroup-size="sm" name="formatfilter" label="Format Filter">
                        <option value="1">Tanggal Entri</option>
                        <option value="2" selected>Tanggal Kontrol </option>
                    </x-adminlte-select2>
                </div>
            </div>
            <x-adminlte-button theme="primary" class="btn btn-sm mb-2" icon="fas fa-search" label="Submit Pencarian"
                onclick="getSuratKontrol()" />
            <x-adminlte-button theme="success" onclick="buatSuratKontrol()" class="btn btn-sm mb-2" icon="fas fa-plus"
                label="Buat Surat Kontrol" />
        </form>
        @php
            $heads = ['Tgl Kontrol', 'No S.Kontrol', 'Jenis Surat', 'Poliklinik', 'Dokter', 'No SEP Asal', 'Terbit SEP', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
            $config['searching'] = false;
        @endphp
        <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" size="lg" title="Surat Kontrol Pasien"
        theme="success" icon="fas fa-file-medical">
        <form id="formSuratKontrol" name="formSuratKontrol">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="noSep" class="nomorsep-id" igroup-size="sm" label="Nomor SEP"
                        value="{{ $kunjungan->no_sep }}" placeholder="Nomor SEP" readonly>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" onclick="cariSEP()">
                                <i class="fas fa-search"></i> Cari SEP
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id" value="{{ $pasien->no_Bpjs }}"
                        igroup-size="sm" label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                    <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                        placeholder="No RM " value="{{ $pasien->no_rm }}" readonly />
                    <x-adminlte-input name="nama" class="nama-id" value="{{ $pasien->nama_px }}" label="Nama Pasien"
                        igroup-size="sm" placeholder="Nama Pasien" readonly />
                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                        placeholder="Nomor HP" />
                </div>
                <div class="col-md-6">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm" label="Tanggal Rencana Kontrol"
                        placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariPoli">
                                <i class="fas fa-search"></i> Cari Poli
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select igroup-size="sm" name="poliKontrol" label="Poliklinik">
                        <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariDokter">
                                <i class="fas fa-search"></i> Cari Dokter
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                    <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                        <option selected disabled>Silahkan Klik Cari Dokter</option>
                    </x-adminlte-select>
                    <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan" placeholder="Catatan Pasien" />
                    <input type="hidden" name="user" value="{{ Auth::user()->name }}">
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button id="btnStoreSuratKontrol" class="mr-auto" icon="fas fa-file-plus" theme="success"
                    label="Buat Surat Kontrol" onclick="simpanSuratKontrol()" />
                <x-adminlte-button id="btnUpdateSuratKontrol" class="mr-auto" icon="fas fa-edit" theme="warning"
                    label="Update Surat Kontrol" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl">
        @php
            $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
            compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <script>
        $(function() {
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
                                optText = value.namaPoli + " (" + value.persentase +
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
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnPrintSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
            $('.btnEditSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_edit') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
        });

        function cariSEP() {
            var nomorkartu = $('.nomorkartu-id').val();
            $('#modalSEP').modal('show');
            var table = $('#tableSEP').DataTable();
            table.rows().remove().draw();
            $.LoadingOverlay("show");
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
        }

        function cariSuratKontrol() {
            $('#modalCariSuratKontrol').modal('show');
        }

        function getSuratKontrol() {
            $.LoadingOverlay("show");
            var data = $('#formCariSuratKontrol').serialize();
            var url = "{{ route('get_surat_kontrol') }}?" + data;
            var table = $('#tableSuratKontrol').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        btnprint =
                            '<button class="btn btn-xs btn-success" onclick="printSuratKontrol(this)" data-nomorsuratkontrol="' +
                            value.noSuratKontrol + '"><i class="fas fa-print"></i></button> ';
                        btnedit =
                            '<button class="btn btn-xs btn-warning"  onclick="editSuratKontrol(this)"><i class="fas fa-edit"></i></button> ';
                        btndelete =
                            '<button class="btn btn-xs btn-danger"  onclick="deleteSuratKontrol(this)" data-nomorsurat="' +
                            value.noSuratKontrol + '"><i class="fas fa-trash"></i></button> ';
                        if (value.terbitSEP == "Belum") {
                            var btn = btnprint + btnedit + btndelete;
                        } else {
                            var btn = btnprint;
                        }
                        table.row.add([
                            value.tglRencanaKontrol,
                            value.noSuratKontrol,
                            value.namaJnsKontrol,
                            value.namaPoliTujuan,
                            value.namaDokter,
                            value.noSepAsalKontrol,
                            value.terbitSEP,
                            btn,
                        ]).draw(false);
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            });
        }

        function printSuratKontrol(button) {
            var nomorsuratkontrol = $(button).data('nomorsuratkontrol');
            var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
            window.open(url, '_blank');
        }

        function buatSuratKontrol(button) {
            $('#btnStoreSuratKontrol').show();
            $('#btnUpdateSuratKontrol').hide();
            $('#modalSuratKontrol').modal('show');
        }

        function simpanSuratKontrol() {
            $.LoadingOverlay("show");
            var data = $('#formSuratKontrol').serialize();
            var url = "{{ route('api.suratkontrol_insert') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: data,
            }).done(function(data) {
                $('#modalSuratKontrol').modal('hide');
                if (data.metadata.code == 200) {
                    Swal.fire(
                        'Berhasil Buat Surat Kontrol',
                        data.metadata.message,
                        'success'
                    );
                    getSuratKontrol();
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            });

        }

        function editSuratKontrol(button) {
            $('#btnStoreSuratKontrol').hide();
            $('#btnUpdateSuratKontrol').show();
            $('#modalSuratKontrol').modal('show');
        }

        function deleteSuratKontrol(button) {
            $.LoadingOverlay("show");
            var nomorsurat = $(button).data('nomorsurat');
            var url = "{{ route('api.suratkontrol_delete') }}";
            var datax = {
                noSuratKontrol: nomorsurat,
                user: "sistem"
            };
            $.ajax({
                type: "DELETE",
                url: url,
                data: datax,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Swal.fire(
                        'Berhasil Buat Surat Kontrol',
                        data.metadata.message,
                        'success'
                    );
                    getSuratKontrol();
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            });

        }
    </script>
@endsection
