@extends('adminlte::page')
@section('title', 'ERM Ranap ' . $pasien->nama_px)
@section('content_header')
    <h1>ERM RAJAL {{ $pasien->nama_px }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('simrs.rajal.erm_rajal_profil')
            </x-adminlte-card>
        </div>
        <div class="col-md-3">
            <x-adminlte-card id="nav" theme="primary" title="Navigasi" body-class="p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item" onclick="">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Riwayat Kunjungan
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatHasilLaboratorium()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-vials"></i> Laboratorium
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatHasilRadiologi()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-x-ray"></i> Radiologi
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatLabPa()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-microscope"></i> Lab Patologi Anatomi
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatFileUpload()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-file-medical"></i> Berkas File Upload
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#nav" class="nav-link" onclick="cariSEP()">
                            <i class="fas fa-file-medical"></i> SEP (BPJS)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#nav" class="nav-link" onclick="cariSuratKontrol()">
                            <i class="fas fa-file-medical"></i> Surat Kontrol (BPJS)
                        </a>
                    </li>
                </ul>
            </x-adminlte-card>
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @include('simrs.ranap.modal_suratkontrol')
                        @include('simrs.ranap.modal_laboratorium')
                        @include('simrs.ranap.modal_radiologi')
                        @include('simrs.ranap.modal_patologi')
                        @include('simrs.ranap.modal_file_rm')
                    </div>
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
@endsection
