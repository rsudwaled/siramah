@extends('vendor.medilab.master')

@section('title', 'Daftar Rawat Jalan - SIRAMAH-RS Waled')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <section id="services" class="services">
        <div class="container">
            <div class="section-title">
                <h2>Services</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat
                    sit
                    in iste officiis commodi quidem hic quas.</p>
            </div>
            @if ($request->jenispasien)
                @if ($request->jeniskunjungan)
                    <div class="row col-lg-12 ">
                        <div class="col-lg-6 ">
                            @if ($errors->any())
                                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </x-adminlte-alert>
                            @endif
                            <form action="" id="daftarTamu" method="get">
                                <input type="hidden" name="jenispasien" value="{{ $request->jenispasien }}">
                                <input type="hidden" name="jeniskunjungan" value="{{ $request->jeniskunjungan }}">
                                <div class="col-md-10 form-group">
                                    <label for="nomorkartu"><b>No BPJS Pasien</b></label>
                                    <input type="text" name="nomorkartu" class="form-control" id="nomorkartu"
                                        placeholder="Masukan Nama Anda" value="{{ $request->nomorkartu }}">
                                    <div class="validate"></div>
                                </div>
                                <div class="col-md-10 form-group mt-3">
                                    <label for="nik"><b>NIK Pasien</b></label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        placeholder="Masukan nik Pasien" value="{{ $request->nik }}">
                                    <div class="validate"></div>
                                </div>
                                <div class="form-group mt-2 mb-5">
                                    <div>
                                        <button id="save" type="submit" form="daftarTamu"
                                            class="btn btn-success mt-1">Check</button>
                                        <span class="btn btn-danger mt-1" id="clear">Clear</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            Data Kunjungan
                        </div>




                    </div>
                @else
                    <div class="row">
                        <div class="col-lg-4 d-flex justify-content-around col-md-6 d-flex align-items-stretch">
                            <a href="?jenispasien={{ $request->jenispasien }}&jeniskunjungan=1">
                                <div class="icon-box">
                                    <div class="icon"><i class="fas fa-heartbeat"></i></div>
                                    <h4>Rujukan FKTP</h4>
                                    <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                                </div>
                            </a>
                        </div>
                        <div
                            class="col-lg-4 d-flex justify-content-around col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <a href="?jenispasien={{ $request->jenispasien }}&jeniskunjungan=3">
                                <div class="icon-box">
                                    <div class="icon"><i class="fas fa-pills"></i></div>
                                    <h4>Surat Kontrol</h4>
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                                </div>
                            </a>
                        </div>
                        <div
                            class="col-lg-4 d-flex justify-content-around col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <a href="?jenispasien={{ $request->jenispasien }}&jeniskunjungan=4">
                                <div class="icon-box">
                                    <div class="icon"><i class="fas fa-pills"></i></div>
                                    <h4>Rujukan Antar RS</h4>
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-around col-md-6 d-flex align-items-stretch">
                        <a href="?jenispasien=JKN">
                            <div class="icon-box">
                                <div class="icon"><i class="fas fa-heartbeat"></i></div>
                                <h4>Pasien BPJS</h4>
                                <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-around col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        <a href="?jenispasien=NON-JKN">
                            <div class="icon-box">
                                <div class="icon"><i class="fas fa-pills"></i></div>
                                <h4>Pasien Umum</h4>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>
    @if ($rujukans)
        <section id="faq" class="faq section-bg">
            <div class="container">

                <div class="section-title">
                    <h2>Frequently Asked Questions</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                        consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                        fugiat
                        sit
                        in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="faq-list">
                    <ul>
                        @foreach ($rujukans as $rujukan)
                            <li data-aos="fade-up">
                                <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                                    data-bs-target="#faq-list-1">{{ $rujukan->noKunjungan }}<i
                                        class="bx bx-chevron-down icon-show"></i><i
                                        class="bx bx-chevron-up icon-close"></i></a>
                                <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                                    <p>
                                        <td>{{ $rujukan->tglKunjungan }}</td>
                                        <td>{{ $rujukan->noKunjungan }}</td>
                                        <td>{{ $rujukan->peserta->nama }}</td>
                                        <td>{{ $rujukan->pelayanan->nama }}</td>
                                        <td>{{ $rujukan->diagnosa->kode }} {{ $rujukan->diagnosa->nama }}</td>
                                        <td>{{ $rujukan->poliRujukan->nama }}</td>
                                        <td>{{ $rujukan->provPerujuk->nama }}</td>

                                </div>
                            </li>
                        @endforeach

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc?
                                <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                                    velit
                                    laoreet id
                                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est
                                    pellentesque elit
                                    ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                </p>
                            </div>
                        </li>
                        <li data-aos="fade-up" data-aos-delay="200">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit?
                                <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus
                                    pulvinar
                                    elementum
                                    integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque
                                    eu
                                    tincidunt.
                                    Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed
                                    odio morbi
                                    quis
                                </p>
                            </div>
                        </li>
                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam
                                sem et
                                tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est
                                    ante in. Nunc
                                    vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum
                                    est.
                                    Purus
                                    gravida quis blandit turpis cursus in.
                                </p>
                            </div>
                        </li>
                        <li data-aos="fade-up" data-aos-delay="400">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius
                                vel
                                pharetra vel turpis nunc eget lorem
                                dolor? <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo
                                    integer
                                    malesuada
                                    nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed.
                                    Ut
                                    venenatis
                                    tellus in metus vulputate eu scelerisque.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </section>
    @endif

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('signature/dist/signature-style.css') }}">
@endsection

@section('js')
    <script src="{{ asset('signature/dist/underscore-min.js') }}"></script>
    <script src="{{ asset('signature/dist/signature-script.js') }}"></script>
@endsection
