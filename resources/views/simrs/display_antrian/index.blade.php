@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title', 'DISPLAY ANTRIAN')
@section('body')
    <div class="wrapper">
        <p hidden>{{ setlocale(LC_ALL, 'IND') }}</p>
        <div class="row p-3">
            <div class="col-md-6">
                <x-adminlte-card title="ANTRIAN OBAT REGULER {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y') }}"
                    theme="success" icon="fas fa-qrcode">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-tablets"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">ANTRIAN NOMOR</span>
                                            <h1 class="info-box-number"> A - DP2001 </h1>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 100%"></div>
                                            </div>
                                            <span class="progress-description">
                                                Nomor Antrian A - DP2001 SEDANG DIPANGGIL!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>A - DP2002</h3>
                                            <p>Persiapan Dipanggil</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-tablets"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>A - DP2003</h3>
                                            <p>Antrian Berikutnya</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-tablets"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <x-adminlte-card title="Informasi Urutan Antrian" theme="success" icon="fas fa-user-injured">
                                @php
                                    $heads = ['Nomor', 'Pasien', 'Jenis', 'Status'];
                                    $config['order'] = false;
                                    $config['paging'] = false;
                                    $config['info'] = false;
                                    $config['scrollY'] = '600px';
                                    $config['scrollCollapse'] = true;
                                    $config['scrollX'] = true;
                                @endphp
                                <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                                    :config="$config" striped bordered hoverable compressed>
                                    @foreach ($reguler_antrian_depo as $reguler)
                                        <tr>
                                            <td>{{ $reguler->nomor_antrian }}</td>
                                            <td>{{ $reguler->pasien->nama_px }}</td>
                                            <td>{{ $reguler->jenis_antrian }} </td>
                                            <td>
                                                <span
                                                    class="badge {{ $reguler->status_antrian == '0' ? 'badge-warning' : 'badge-success' }}">{{ $reguler->status_antrian == '0' ? 'Menunggu Antrian' : 'Selesai Antrian' }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </x-adminlte-card>
                        </div>
                        {{-- <div class="col-lg-12">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <x-adminlte-card title="Informasi Urutan Antrian" theme="success"
                                            icon="fas fa-user-injured">
                                            @php
                                                $heads = ['MENUNGGU ANTRIAN'];
                                                $config['order'] = false;
                                                $config['paging'] = false;
                                                $config['info'] = false;
                                                $config['scrollY'] = '600px';
                                                $config['scrollCollapse'] = true;
                                                $config['scrollX'] = true;
                                            @endphp
                                            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads"
                                                head-theme="dark" :config="$config" striped bordered hoverable compressed>
                                                @foreach ($reguler_antrian_depo as $reguler)
                                                    <tr>
                                                        <td>{{ $reguler->nomor_antrian }} <br>
                                                        {{ $reguler->pasien->nama_px }} <br>
                                                        <span class="badge {{ $reguler->status_antrian == '0' ? 'badge-warning' : 'badge-success' }}">{{ $reguler->status_antrian == '0' ? 'Menunggu Antrian' : 'Selesai Antrian' }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </x-adminlte-datatable>
                                        </x-adminlte-card>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card-body">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="0"
                                                        class="active"></li>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"
                                                        class=""></li>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"
                                                        class=""></li>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img class="d-block w-100"
                                                            src="https://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap"
                                                            alt="First slide">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img class="d-block w-100"
                                                            src="https://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap"
                                                            alt="Second slide">
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img class="d-block w-100"
                                                            src="https://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap"
                                                            alt="Third slide">
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators"
                                                    role="button" data-slide="prev">
                                                    <span class="carousel-control-custom-icon" aria-hidden="true">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators"
                                                    role="button" data-slide="next">
                                                    <span class="carousel-control-custom-icon" aria-hidden="true">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </x-adminlte-card>
            </div>
            {{-- ANTRIAN RACIKAN --}}
            <div class="col-md-6">
                <x-adminlte-card title="ANTRIAN OBAT RACIKAN {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y') }}"
                    theme="purple" icon="fas fa-qrcode">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-box bg-purple">
                                        <span class="info-box-icon"><i class="fas fa-pills"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">ANTRIAN NOMOR</span>
                                            <h1 class="info-box-number"> B - DP2001 </h1>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 100%"></div>
                                            </div>
                                            <span class="progress-description">
                                                Nomor Antrian B - DP2001 SEDANG DIPANGGIL!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>B - DP2002</h3>
                                            <p>Persiapan Dipanggil</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>B - DP2003</h3>
                                            <p>Antrian Berikutnya</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-adminlte-card title="Informasi Urutan Antrian" theme="purple"
                                        icon="fas fa-user-injured">
                                        @php
                                            $heads = ['MENUNGGU ANTRIAN'];
                                            $config['order'] = false;
                                            $config['paging'] = false;
                                            $config['info'] = false;
                                            $config['scrollY'] = '600px';
                                            $config['scrollCollapse'] = true;
                                            $config['scrollX'] = true;
                                        @endphp
                                        <x-adminlte-datatable id="table" class="text-xs" :heads="$heads"
                                            head-theme="dark" :config="$config" striped bordered hoverable compressed>
                                            @foreach ($racikan_antrian_depo as $racikan)
                                                <tr>
                                                    <td>{{ $racikan->nomor_antrian }} <br>
                                                        {{ $racikan->pasien->nama_px }} <br>
                                                        <span
                                                            class="badge {{ $racikan->status_antrian == '0' ? 'badge-warning' : 'badge-success' }}">{{ $racikan->status_antrian == '0' ? 'Menunggu Antrian' : 'Selesai Antrian' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </x-adminlte-datatable>
                                    </x-adminlte-card>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-body">
                                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-target="#carouselExampleIndicators" data-slide-to="0"
                                                    class="active"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="1"
                                                    class=""></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="2"
                                                    class=""></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100"
                                                        src="https://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap"
                                                        alt="First slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block w-100"
                                                        src="https://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap"
                                                        alt="Second slide">
                                                </div>
                                                <div class="carousel-item">
                                                    <img class="d-block w-100"
                                                        src="https://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap"
                                                        alt="Third slide">
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators"
                                                role="button" data-slide="prev">
                                                <span class="carousel-control-custom-icon" aria-hidden="true">
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators"
                                                role="button" data-slide="next">
                                                <span class="carousel-control-custom-icon" aria-hidden="true">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-adminlte-card>

            </div>
        </div>
    </div>

@stop
@section('plugins.Datatables', true)

@section('adminlte_css')
@endsection
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('vendor/onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- scan --}}
    <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Mencari kodebooking " + sCode + "..."
                    });
                    var url = "{{ route('checkinAntrian') }}?kodebooking=" + sCode;
                    window.location.href = url;
                },
            });
        });
    </script>
    {{-- btn chekin --}}
    <script>
        $(function() {
            $('#btn_checkin').click(function() {
                var kodebooking = $('#kodebooking').val();
                $.LoadingOverlay("show", {
                    text: "Mencari kodebooking " + kodebooking + "..."
                });
                var url = "{{ route('checkinAntrian') }}?kodebooking=" + kodebooking;
                window.location.href = url;
            });
        });
    </script>
    {{-- btn daftar --}}
    <script>
        $(function() {
            $(document).ready(function() {
                $('#daftarDokter').hide();
                setTimeout(function() {
                    $('#kodebooking').focus();
                }, 500);
            });
            $('.btnDaftarBPJS').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#btnDaftarPoliUmum').hide();
                $('#btnDaftarPoliBPJS').show();
                $('#inputKartu').show();
                setTimeout(function() {
                    $('#nomorkartu').focus();
                }, 500);

            });
            $('.btnDaftarUmum').click(function() {
                $('#modalBPJS').modal('show');
                $('#inputNIK').show();
                $('#inputKartu').hide();
                $('#btnDaftarPoliUmum').show();
                $('#btnDaftarPoliBPJS').hide();
                setTimeout(function() {
                    $('#nik').focus();
                }, 500);

            });
            $('.btnPoliBPJS').click(function() {
                $('div#rowDokter').children().remove();
                var id = $(this).data('id');
                var hari = "{{ now()->dayOfWeek }}"
                $.LoadingOverlay("show");
                var url = "{{ route('jadwaldokterPoli') }}/?kodesubspesialis=" + id + "&hari=" +
                    hari;
                $.get(url, function(data) {
                    $('#daftarDokter').show();
                    $.each(data, function(i, item) {
                        console.log(item.kodedokter);
                        var bigString = [
                            '<div class="custom-control custom-radio " >',
                            '<input class="custom-control-input btnPoliBPJS" type="radio"',
                            'data-id="' + item.kodedokter + '" id="' + item.kodedokter +
                            '"',
                            'value="' + item.kodedokter + '" name="kodedokter">',
                            '<label for="' + item.kodedokter +
                            '" class="custom-control-label"',
                            'data-id="' + item.kodedokter + '">' + item.namadokter +
                            ' </label>',
                            ' </div>',
                        ];
                        $('#rowDokter').append(bigString.join(''));
                    });
                    $.LoadingOverlay("hide", true);
                });
            });
            $('#btnDaftarPoliBPJS').click(function() {
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('daftarBpjsOffline') }}" + "?kodesubspesialis=" +
                    kodesubspesialis + "&kodedokter=" + kodedokter;
                window.location.href = url;
            });
            $('#btnDaftarPoliUmum').click(function() {
                var kodesubspesialis = $("input[name=kodesubspesialis]:checked").val();
                var kodedokter = $("input[name=kodedokter]:checked").val();
                var url = "{{ route('daftarUmumOffline') }}" + "?kodesubspesialis=" +
                    kodesubspesialis + "&kodedokter=" + kodedokter;
                window.location.href = url;
            });

        });
    </script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert')
@stop
