@extends('adminlte::page')

@section('title', 'Pilih Pendaftaran')
@section('content_header')
    <h1>Pilih Pendaftaran </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-sm-6 col-12 pasien-umum" style="cursor: pointer">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                        <div class="info-box-content  m-4">
                            <span class="info-box-text">PASIEN IGD UMUM</span>
                            <span class="info-box-number">daftarkan Sebagai pasien igd umum</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-12 pasien-umum" style="cursor: pointer">
                    <div class="info-box bg-gradient-warning">
                        <span class="info-box-icon"><i class="fas fa-baby"></i></span>
                        <div class="info-box-content  m-4">
                            <span class="info-box-text">PASIEN IGD KEBIDANAN</span>
                            <span class="info-box-number">daftarkan Sebagai pasien igd kebidanan</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-12 pasien-bpjs" style="cursor: pointer">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-hospital-user"></i></span>
                        <div class="info-box-content  m-4">
                            <span class="info-box-text">PASIEN BPJS</span>
                            <span class="info-box-number">daftarkan Sebagai pasien bpjs</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-12 pasien-bayi" style="cursor: pointer">
                    <div class="info-box bg-gradient-danger">
                        <span class="info-box-icon"><i class="fas fa-baby"></i></span>
                        <div class="info-box-content  m-4">
                            <span class="info-box-text">PASIEN BAYI BARU LAHIR</span>
                            <span class="info-box-number">daftarkan Sebagai pasien bayi baru lahir</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-12 pasien-ranap" style="cursor: pointer">
                    <div class="info-box bg-gradient-maroon">
                        <span class="info-box-icon"><i class="fas fa-procedures"></i></span>
                        <div class="info-box-content  m-4">
                            <span class="info-box-text">PASIEN RAWAT INAP</span>
                            <span class="info-box-number">daftarkan Sebagai pasien rawat inap igd</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
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
    $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.pasien-umum').click(function(e) {
                $.LoadingOverlay("show");
                window.location.href ="{{route('d-antrian-igd')}}";
                
            });
            $('.pasien-bpjs').click(function(e) {
                $.LoadingOverlay("show");
                window.location.href ="{{route('pendaftaran-pasien-igdbpjs')}}";
            });
            $('.pasien-bayi').click(function(e) {
                $.LoadingOverlay("show");
                window.location.href ="{{route('pendaftaranpasien.bayi')}}";
            });
            $('.pasien-ranap').click(function(e) {
                $.LoadingOverlay("show");
                window.location.href ="{{route('kunjungan.ranap')}}";
            });
        });
</script>
@endsection
