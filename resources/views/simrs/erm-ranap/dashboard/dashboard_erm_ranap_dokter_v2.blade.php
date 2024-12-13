@extends('layouts_erm.app')
@push('style')
   
@endpush
@section('content')
    <div class="row">
        <div class="col-2">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header" style="background-color: #001f3f;">
                            <h3 class="card-title">Riwayat Pasien</h3>
                        </div>
                        <div class="card-body" style="max-height: 350px; overflow-y: auto; margin-top:-5px;">
                            <small><strong>RIWAYAT KUNJUNGAN</strong></small>
                            @foreach ($riwayatKunjungan as $riwayat)
                                <button class="btn btn-secondary btn-flat btn-sm btn-block mb-1" style="text-align: left;"
                                    data-toggle="modal" data-target="#modal-{{ $riwayat->kode_kunjungan }}"
                                    data-kode-kunjungan-riwayat="{{ $riwayat->kode_kunjungan }}">
                                    {{ Carbon\Carbon::parse($riwayat->tgl_masuk)->format('d-m-Y') }} <span
                                        class="badge bg-lightblue disabled color-palette"><small>{{ $riwayat->status->status_kunjungan }}</small></span>
                                    <br> {{ $riwayat->unit->nama_unit }}
                                </button>

                                <div class="modal fade" id="modal-{{ $riwayat->kode_kunjungan }}" aria-hidden="true"
                                    tabindex="-1" role="dialog" aria-labelledby="modalLabel" data-backdrop="static"
                                    data-keyboard="false">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">RIWAYAT {{ $riwayat->unit->nama_unit }}</h4>
                                            </div>
                                            <div class="modal-body" id="modal-body-{{ $riwayat->kode_kunjungan }}">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Tindakan</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="tindakan-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Obat</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="obat-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card direct-chat direct-chat-primary">
                                                            <div class="card-header ui-sortable-handle"
                                                                style="cursor: move;">
                                                                <h3 class="card-title">Riwayat Asesmen</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="direct-chat-messages">
                                                                    <div class="col-12"
                                                                        id="asesmen-{{ $riwayat->kode_kunjungan }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer float-right">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr style="color:2px solid rgb(94, 94, 94);">
                            <small><strong>RIWAYAT PENUNJANG</strong></small>
                            <button class="btn btn-flat btn-sm btn-block text-white"
                                style="text-align: left; background-color:#5c5a90;" 
                                id="btn-radiologi"
                                data-no_rm="{{$pasien->no_rm}}" 
                                data-toggle="modal"
                                data-target="#modal-radiologi">Radiologi</button>
                            <button class="btn btn-flat btn-sm btn-block text-white" data-toggle="modal" data-target="#modal-labpatologi"
                                style="text-align: left; background-color:#5c5a90;">Patologi</button>
                            <button class="btn btn-flat btn-sm btn-block text-white"
                                style="text-align: left; background-color:#5c5a90;" data-toggle="modal" data-target="#modal-berkas">Berkas</button>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-info btn-block">CPPT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10 row">
            <div class="col-md-12" style="font-size: 12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">RM: {{ $pasien->no_rm }} || {{ $pasien->nama_px }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('pasienRanapAktif') }}" class="btn btn-sm btn-danger">Kembali</a>
                            <button class="btn btn-sm btn-warning">
                                Total Bayar: {{ money($grandTotal, 'IDR') }}
                            </button>
                            <button type="button" onclick="getRincianBiaya()" class="btn btn-tool"
                                data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="row" style="font-size: 12px;">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-4 m-0">Nama</dt>
                                            <dd class="col-sm-8 m-0">{{ $pasien->nama_px }} ({{ $pasien->jenis_kelamin }})
                                            </dd>
                                            <dt class="col-sm-4 m-0">No RM</dt>
                                            <dd class="col-sm-8 m-0">{{ $pasien->no_rm }}</dd>
                                            <dt class="col-sm-4 m-0">NIK</dt>
                                            <dd class="col-sm-8 m-0">{{ $pasien->nik_bpjs }}</dd>
                                            <dt class="col-sm-4 m-0">No BPJS</dt>
                                            <dd class="col-sm-8 m-0">{{ $pasien->no_Bpjs }}</dd>
                                            <dt class="col-sm-4 m-0">Tgl Lahir</dt>
                                            <dd class="col-sm-8 m-0">
                                                {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('Y-m-d') }} (
                                                @if (\Carbon\Carbon::parse($pasien->tgl_lahir)->age)
                                                    {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} tahun
                                                @else
                                                    {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInDays(now()) }} hari
                                                @endif
                                                )
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-4 m-0">Tgl Masuk</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_masuk }}</dd>
                                            <dt class="col-sm-4 m-0">Alasan Masuk</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_masuk->alasan_masuk }}</dd>
                                            <dt class="col-sm-4 m-0">Ruangan / Kls</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->unit->nama_unit }} /
                                                {{ $kunjungan->kelas }}</dd>
                                            <dt class="col-sm-4 m-0">Dokter DPJP</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->dokter->nama_paramedis }}</dd>
                                            <dt class="col-sm-4 m-0">Penjamin</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->penjamin_simrs->nama_penjamin }}
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-4 m-0">No SEP</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->no_sep }}</dd>
                                            <dt class="col-sm-4 m-0">Tarif RS</dt>
                                            <dd class="col-sm-8 m-0"> Rp. <span class="biaya_rs_html">-</span></dd>
                                            <dt class="col-sm-4 m-0">Tarif E-Klaim</dt>
                                            <dd class="col-sm-8 m-0">Rp. <span class="tarif_eklaim_html">-</span></dd>
                                            <dt class="col-sm-4 m-0">Groupping</dt>
                                            <dd class="col-sm-8 m-0"><span class="code_cbg_html">-</span></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="row">
                                            <dt class="col-sm-4 m-0">Status</dt>
                                            <dd class="col-sm-8 m-0">
                                                @if ($kunjungan->status_kunjungan == 1)
                                                    <span
                                                        class="badge badge-success">{{ $kunjungan->status->status_kunjungan }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ $kunjungan->status->status_kunjungan }}</span>
                                                @endif
                                            </dd>
                                            <dt class="col-sm-4 m-0">Tgl Keluar</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_keluar ?? '-' }}</dd>
                                            <dt class="col-sm-4 m-0">Alasan Pulang</dt>
                                            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_pulang->alasan_pulang ?? '-' }}
                                            </dd>
                                            <dt class="col-sm-4 m-0">Surat Kontrol</dt>
                                            <dd class="col-sm-8 m-0">
                                                {{ $kunjungan->surat_kontrol->noSuratKontrol ?? '-' }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="rincian_biaya">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="font-size: 12px;">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills" style="font-size: 14px;">
                            <li class="nav-item">
                                <a class="nav-link active" href="#form-assesmen-keperawatan" data-toggle="tab">Form
                                    Asesmen Keperawatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#table-data-assemen-awal-keperawatan" data-toggle="tab">LIHAT
                                    CETAKAN</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="form-assesmen-keperawatan">
                                <form action="http://127.0.0.1:8000/erm-ranap/perawat/assesmen-awal/store/assesmen-awal"
                                    name="formAsesmenKeperawatan" id="formAsesmenKeperawatan" method="POST">
                                    <input type="hidden" name="_token" value="8HgOFIKD79f2EhljBAVkFPcpGJhYKdkMuprttXIq"
                                        autocomplete="off"> <input type="hidden" name="kode" value="22482136">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Ruang Perawatan</label>
                                                    <input type="text" class="form-control" name="unit_ruangan"
                                                        value="SEROJA" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>No RM</label>
                                                    <input type="text" class="form-control" name="no_rm"
                                                        value="23989280" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Nama Pasien</label>
                                                    <input type="text" class="form-control" name="nama_pasien"
                                                        value="LIYAH APRILIYAH" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <input type="text" class="form-control" name="jk_pasien"
                                                        value="Perempuan" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Tiba di Ruangan">Tiba di Ruangan</label>
                                                            <input type="date" name="tgl_tiba_diruangan"
                                                                class="form-control" value="2024-11-26">

                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Waktu Tiba di Ruangan">Waktu</label>
                                                            <input type="time" name="waktu_tiba_diruangan"
                                                                class="form-control" value="11:53">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Kesadaran</label>
                                                            <select class="custom-select rounded-0" name="kesadaran"
                                                                id="kesadaran">
                                                                <option value="compos_mentis">
                                                                    Compos Mentis
                                                                </option>
                                                                <option value="apatis">
                                                                    Apatis
                                                                </option>
                                                                <option value="somnolent">
                                                                    Somnolent
                                                                </option>
                                                                <option value="sopor">
                                                                    Sopor
                                                                </option>
                                                                <option value="coma">
                                                                    Coma
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Sumber Data</label>
                                                            <select class="custom-select rounded-0" name="sumber_data"
                                                                id="sumber_data">
                                                                <option value="Pasien_Autoanamnese">
                                                                    Pasien / Autoanamnese
                                                                </option>
                                                                <option value="Keluarga_Allonamnese">
                                                                    Keluarga / Allonamnese
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Tgl Pengkajian">Tgl Pengkajian</label>
                                                            <input type="date" name="tgl_pengkajian"
                                                                class="form-control" value="2024-11-26">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Waktu Pengkajian">Waktu Pengkajian</label>
                                                            <input type="time" name="waktu_pengkajian"
                                                                class="form-control" value="11:53">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Nama Keluarga</label>
                                                            <input type="text" class="form-control"
                                                                name="nama_keluarga" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Hubungan Keluarga</label>
                                                            <input type="text" class="form-control"
                                                                name="hubungan_keluarga" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Cara Masuk</label>
                                                            <select class="custom-select rounded-0" name="cara_masuk"
                                                                id="cara_masuk">
                                                                <option value="jalan_kaki">
                                                                    Jalan Kaki
                                                                </option>
                                                                <option value="kursi_roda">
                                                                    Kursi Roda
                                                                </option>
                                                                <option value="brankar">
                                                                    Brankar
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Asal Masuk</label>
                                                            <select class="custom-select rounded-0" name="asal_masuk"
                                                                id="asal_masuk">
                                                                <option value="igd">
                                                                    IGD
                                                                </option>
                                                                <option value="rawat_jalan">
                                                                    Rawat Jalan
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="Tekanan Darah">Tekanan Darah</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="tekanan_darah" value="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">mmHg</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="Respirasi">Respirasi</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="respirasi" value="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">x/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="Respirasi">Nadi</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="denyut_nadi" value="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">x/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="Respirasi">Suhu</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="suhu" value="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">°C</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Skrining &amp; Asesmen Nyeri</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Skrining Nyeri :</strong> Apakah Terdapat Keluhan Nyeri
                                                    <div class="icheck-primary d-inline mr-3">
                                                        <input type="checkbox" id="keluhan_nyeri_tidak"
                                                            name="keluhan_nyeri[]" value="Tidak">
                                                        <label for="keluhan_nyeri_tidak">Tidak</label>
                                                    </div>
                                                    <div class="icheck-primary d-inline mr-3">
                                                        <input type="checkbox" id="keluhan_nyeri_ada"
                                                            name="keluhan_nyeri[]" value="Ada">
                                                        <label for="keluhan_nyeri_ada">Ada, </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="Skala">Skala </label>
                                                        <input type="text" name="skala_nyeri" id="skala_nyeri"
                                                            class="form-control col-4 mr-2 ml-2" value="">
                                                        lanjutkan dengan
                                                        asesmen nyeri.
                                                    </div>
                                                </div>
                                                <div class="col-md-12 row">
                                                    <div class="col-8">
                                                        <img src="http://127.0.0.1:8000/nyeri_nrs.png" alt=""
                                                            width="80%">
                                                    </div>
                                                    <div class="col-4" style="border: 1 px solid black;">
                                                        <ul>
                                                            <li class="mb-1">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="radio" id="klasifikasi_nyeri_0"
                                                                        name="klasifikasi_nyeri" value="0"
                                                                        disabled="">
                                                                    <label for="klasifikasi_nyeri_0">Skor 0 = Tidak
                                                                        Nyeri</label>
                                                                </div>
                                                            </li>
                                                            <li class="mb-1">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="radio" id="klasifikasi_nyeri_1_3"
                                                                        name="klasifikasi_nyeri" disabled=""
                                                                        value="1-3">
                                                                    <label for="klasifikasi_nyeri_1_3">Skor 1-3 = Nyeri
                                                                        Ringan</label>
                                                                </div>
                                                            </li>
                                                            <li class="mb-1">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="radio" id="klasifikasi_nyeri_4_6"
                                                                        name="klasifikasi_nyeri" disabled=""
                                                                        value="4-6">
                                                                    <label for="klasifikasi_nyeri_4_6">Skor 4-6 = Nyeri
                                                                        Sedang</label>
                                                                </div>
                                                            </li>
                                                            <li class="mb-1">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="radio" id="klasifikasi_nyeri_7_10"
                                                                        name="klasifikasi_nyeri" disabled=""
                                                                        value="7-10">
                                                                    <label for="klasifikasi_nyeri_7_10">Skor 7-10 = Nyeri
                                                                        Hebat</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6><strong>Asesmen Nyeri Lanjutan :</strong></h6>
                                                    <div class="col-12 mb-1">
                                                        <div class="row mb-1">
                                                            <div class="col-3"><strong>P</strong>rovocation</div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="provocation_cahaya"
                                                                        name="provocation[]" value="cahaya">
                                                                    <label for="provocation_cahaya">Cahaya</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="provocation_gelap"
                                                                        name="provocation[]" value="gelap">
                                                                    <label for="provocation_gelap">Gelap</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="provocation_gerakan"
                                                                        name="provocation[]" value="gerakan">
                                                                    <label for="provocation_gerakan">Gerakan</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-3"><strong>Q</strong>uality</div>
                                                            <div class="col-9">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_ditusuk"
                                                                                name="quality[]" value="ditusuk">
                                                                            <label for="quality_ditusuk">Ditusuk</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_dibakar"
                                                                                name="quality[]" value="dibakar">
                                                                            <label for="quality_dibakar">Dibakar</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_ditarik"
                                                                                name="quality[]" value="ditarik">
                                                                            <label for="quality_ditarik">Ditarik</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_kram"
                                                                                name="quality[]" value="kram">
                                                                            <label for="quality_kram">Kram</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_berdenyut"
                                                                                name="quality[]" value="berdenyut">
                                                                            <label
                                                                                for="quality_berdenyut">Berdenyut</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="quality_lainnya"
                                                                                name="quality[]" value="lainnya">
                                                                            <label for="quality_lainnya">Lainnya</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <div class="col-3"><strong>R</strong>egion</div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="region_berpindah"
                                                                        name="region[]" value="nyeri_berpindah">
                                                                    <label for="region_berpindah">Nyeri
                                                                        berpindah-pindah</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="region_tetap"
                                                                        name="region[]" value="nyeri_tetap">
                                                                    <label for="region_tetap">Nyeri tetap</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <div class="col-3"><strong>S</strong>everity</div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="severity_ringan"
                                                                        name="severity[]" value="ringan">
                                                                    <label for="severity_ringan">Nyeri Ringan</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="severity_sedang"
                                                                        name="severity[]" value="sedang">
                                                                    <label for="severity_sedang">Nyeri Sedang</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="severity_berat"
                                                                        name="severity[]" value="berat">
                                                                    <label for="severity_berat">Nyeri Berat</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-3"><strong>T</strong>ime</div>
                                                            <div class="col-9">
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="time_terus_menerus"
                                                                                name="time[]" value="terus_menerus">
                                                                            <label for="time_terus_menerus">Terus
                                                                                menerus</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="time_hilang_timbul"
                                                                                name="time[]" value="hilang_timbul">
                                                                            <label for="time_hilang_timbul">Hilang
                                                                                timbul</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="time_kurang_30"
                                                                                name="time[]" value="kurang_30">
                                                                            <label for="time_kurang_30">&lt; 30
                                                                                menit</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="time_lebih_30"
                                                                                name="time[]" value="lebih_30">
                                                                            <label for="time_lebih_30">&gt; 30
                                                                                menit</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="Keluhan Utama">Keluhan Utama</label>
                                                                    <textarea name="riwayat_kesehatan_keluahan_utama" class="form-control" id="" cols="30"
                                                                        rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="Riwayat Penyakit Sekarang">Riwayat Penyakit
                                                                        Sekarang</label>
                                                                    <textarea name="riwayat_kesehatan_riwayat_penyakit_sekarang" class="form-control" id="" cols="30"
                                                                        rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h6><strong>Riwayat Kesehatan :</strong></h6>
                                                    <div class="col-12 mb-1">
                                                        <div class="row">
                                                            <div class="col-3">Pernah dirawat di RS</div>
                                                            <div class="col-4">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox"
                                                                        id="riwayat_kesehatan_pernah_dirawat_tidak"
                                                                        name="riwayat_kesehatan_pernah_dirawat[]"
                                                                        value="Tidak">
                                                                    <label
                                                                        for="riwayat_kesehatan_pernah_dirawat_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_kesehatan_pernah_dirawat_ya"
                                                                                name="riwayat_kesehatan_pernah_dirawat[]"
                                                                                value="Ya">
                                                                            <label
                                                                                for="riwayat_kesehatan_pernah_dirawat_ya">Ya,
                                                                                Penyakit</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <input type="text"
                                                                            name="riwayat_kesehatan_nama_penyakit"
                                                                            value="" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1 mt-1">
                                                            <div class="col-3">Riwayat Pemakaian Obat</div>
                                                            <div class="col-4">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox"
                                                                        id="riwayat_kesehatan_pemakaian_obat_tidak"
                                                                        name="riwayat_kesehatan_pemakaian_obat[]"
                                                                        value="Tidak">
                                                                    <label
                                                                        for="riwayat_kesehatan_pemakaian_obat_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_kesehatan_pemakaian_obat_ya"
                                                                                name="riwayat_kesehatan_pemakaian_obat[]"
                                                                                value="Ya">
                                                                            <label
                                                                                for="riwayat_kesehatan_pemakaian_obat_ya">Ya,
                                                                                Sebutkan</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <input type="text"
                                                                            name="riwayat_kesehatan_nama_obat"
                                                                            class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-3">Riwayat Penyerta</div>
                                                            <div class="col-9">
                                                                <div class="row">
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_dm"
                                                                                name="riwayat_penyerta[]" value="DM">
                                                                            <label for="riwayat_penyerta_dm">DM</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_hipertensi"
                                                                                name="riwayat_penyerta[]"
                                                                                value="hipertensi">
                                                                            <label
                                                                                for="riwayat_penyerta_hipertensi">Hipertensi</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_kholesterol"
                                                                                name="riwayat_penyerta[]"
                                                                                value="kholesterol">
                                                                            <label
                                                                                for="riwayat_penyerta_kholesterol">Kholesterol</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_gagal_ginjal"
                                                                                name="riwayat_penyerta[]"
                                                                                value="gagal_ginjal">
                                                                            <label
                                                                                for="riwayat_penyerta_gagal_ginjal">Gagal
                                                                                Ginjal</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_tbc"
                                                                                name="riwayat_penyerta[]" value="tbc">
                                                                            <label for="riwayat_penyerta_tbc">TBC</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-1">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox"
                                                                                id="riwayat_penyerta_kanker"
                                                                                name="riwayat_penyerta[]" value="kanker">
                                                                            <label
                                                                                for="riwayat_penyerta_kanker">Kanker</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 mb-1">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="icheck-primary d-inline mr-3">
                                                                                    <input type="checkbox"
                                                                                        id="riwayat_penyerta_lainya"
                                                                                        name="riwayat_penyerta[]"
                                                                                        value="lainya">
                                                                                    <label
                                                                                        for="riwayat_penyerta_lainya">Lain-lain</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-8">
                                                                                <input type="text"
                                                                                    name="riwayat_penyerta_keterangan_lainya"
                                                                                    value="" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-3">Riwayat Alergi</div>
                                                            <div class="col-2">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="riwayat_alergi_tidak"
                                                                        name="riwayat_alergi[]" value="Tidak">
                                                                    <label for="riwayat_alergi_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-7">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="icheck-primary d-inline mr-3">
                                                                            <input type="checkbox" id="riwayat_alergi_ya"
                                                                                name="riwayat_alergi[]" value="Ya">
                                                                            <label for="riwayat_alergi_ya">Ya,
                                                                                Sebutkan</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <input type="text"
                                                                            name="riwayat_alergi_keterangan"
                                                                            class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Respirasi &amp; Oksigenasi</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>Obstruksi saluran napas atas:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline  mr-3">
                                                            <input type="checkbox" id="obstruksi_ada" name="obstruksi[]"
                                                                value="Ada">
                                                            <label for="obstruksi_ada">Ada</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="obstruksi_tidak"
                                                                name="obstruksi[]" value="Tidak">
                                                            <label for="obstruksi_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Sesak Napas (dyspnea):
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="dyspnea_ada" name="dyspnea[]"
                                                                value="Ada">
                                                            <label for="dyspnea_ada">Ada</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="dyspnea_tidak" name="dyspnea[]"
                                                                value="Tidak">
                                                            <label for="dyspnea_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Pemakaian alat bantu napas: Binasal Canule/Simple Mask/Rebreathing
                                                    Mask/Non Rebreathing Mask/
                                                    Endotracheal Tube/Trachea Canule/Ventilator
                                                    <input type="text" name="alat_bantu_napas"
                                                        class="form-control col-3" value="">
                                                </li>

                                                <li>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            Batuk:
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline  mr-3">
                                                                    <input type="checkbox" id="batuk_ada" name="batuk[]"
                                                                        value="Ada">
                                                                    <label for="batuk_ada">Ada</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="batuk_tidak"
                                                                        name="batuk[]" value="Tidak">
                                                                    <label for="batuk_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            Sputum:
                                                            <div class="form-group clearfix">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <div class="icheck-primary d-inline  mr-3">
                                                                            <input type="checkbox" id="sputum_tidak"
                                                                                name="sputum[]" value="Tidak">
                                                                            <label for="sputum_tidak">Tidak</label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="checkbox" id="sputum_ada"
                                                                                name="sputum[]" value="Ada">
                                                                            <label for="sputum_ada">Ada</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <input type="text" name="warna_sputum"
                                                                            class="form-control"
                                                                            placeholder="masukan warna jika ada di ceklis"
                                                                            value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Bunyi Napas:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline  mr-3">
                                                            <input type="checkbox" id="bunyi_napas_normal"
                                                                name="bunyi_napas[]" value="Normal">
                                                            <label for="bunyi_napas_normal">Normal</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="bunyi_napas_abnormal"
                                                                name="bunyi_napas[]" value="Abnormal">
                                                            <label for="bunyi_napas_abnormal">Abnormal</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            Thorax:
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline  mr-3">
                                                                    <input type="checkbox" id="thorax_simetris"
                                                                        name="thorax[]" value="Simetris">
                                                                    <label for="thorax_simetris">Simetris</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="thorax_tidak"
                                                                        name="thorax[]" value="Tidak">
                                                                    <label for="thorax_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            Krepitasi:
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline  mr-3">
                                                                    <input type="checkbox" id="krepitasi_tidak"
                                                                        name="krepitasi[]" value="Tidak">
                                                                    <label for="krepitasi_tidak">Tidak</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="krepitasi_ya"
                                                                        name="krepitasi[]" value="Ya">
                                                                    <label for="krepitasi_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>CTT:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ctt_tidak" name="ctt[]"
                                                                value="Tidak">
                                                            <label for="ctt_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline  mr-3">
                                                            <input type="checkbox" id="ctt_ya" name="ctt[]"
                                                                value="Ya">
                                                            <label for="ctt_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Kardiovaskuler</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li> Nadi :
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="nadi"
                                                            value="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">x/menit
                                                                (Requler/Irreguler)</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Konjungtiva:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline  mr-3">
                                                            <input type="checkbox" id="konjungtiva_pucat"
                                                                name="konjungtiva[]" value="Pucat">
                                                            <label for="konjungtiva_pucat">Pucat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="konjungtiva_mm"
                                                                name="konjungtiva[]" value="Merah_Muda">
                                                            <label for="konjungtiva_mm">Merah Muda</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Riwayat Pemasangan Alat:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="pasang_alat_ada"
                                                                name="pasang_alat[]" value="Ada">
                                                            <label for="pasang_alat_ada">Ada</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pasang_alat_tidak"
                                                                name="pasang_alat[]" value="Tidak">
                                                            <label for="pasang_alat_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Kulit:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="kulit_pucat" name="kulit[]"
                                                                value="Pucat">
                                                            <label for="kulit_pucat">Pucat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="kulit_cyanosis" name="kulit[]"
                                                                value="Cyanosis">
                                                            <label for="kulit_cyanosis">Cyanosis</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="kulit_hipermis" name="kulit[]"
                                                                value="Hipermis">
                                                            <label for="kulit_hipermis">Hipermis</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="kulit_ekimosis" name="kulit[]"
                                                                value="Ekimosis">
                                                            <label for="kulit_ekimosis">Ekimosis</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Temperatur:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="temperatur_hangat"
                                                                name="temperatur[]" value="Hangat">
                                                            <label for="temperatur_hangat">Hangat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="temperatur_dingin"
                                                                name="temperatur[]" value="Dingin">
                                                            <label for="temperatur_dingin">Cyanosis</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="temperatur_diaphoresis"
                                                                name="temperatur[]" value="Dhiaporesis">
                                                            <label for="temperatur_diaphoresis">Dhiaporesis</label>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>Bunyi Jantung:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="bunyi_jantung_normal"
                                                                name="bunyi_jantung[]" value="Normal">
                                                            <label for="bunyi_jantung_normal">Normal</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="bunyi_jantung_abnormal"
                                                                name="bunyi_jantung[]" value="Abnormal">
                                                            <label for="bunyi_jantung_abnormal">Abnormal</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Ekstremis :
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">CRT</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="ekstremis"
                                                            value="">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">Detik</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Terpasang Nichiban / TR Band:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="nichiban_tidak" name="nichiban[]"
                                                                value="Tidak">
                                                            <label for="nichiban_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="nichiban_ya" name="nichiban[]"
                                                                value="Ya">
                                                            <label for="nichiban_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Edema:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="edema_tidak" name="edema[]"
                                                                value="Tidak">
                                                            <label for="edema_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="edema_ada" name="nichiban[]"
                                                                value="Ada">
                                                            <label for="edema_ada">Ada</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Gastro Intestinal</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Makan :
                                                    <div class="row">
                                                        <div class="col-6">
                                                            Frekuensi :
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control"
                                                                    name="makan_frekuensi" value="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">X/Hari</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            Jumlah :
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control"
                                                                    name="makan_jumlah" value="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Porsi</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            Mual:
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline  mr-3">
                                                                    <input type="checkbox" id="mual_tidak" name="mual[]"
                                                                        value="Tidak">
                                                                    <label for="mual_tidak">Tidak</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="mual_ya" name="mual[]"
                                                                        value="Ya">
                                                                    <label for="mual_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    Muntah:
                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-primary d-inline  mr-3">
                                                                            <input type="checkbox" id="muntah_tidak"
                                                                                name="muntah[]" value="Tidak">
                                                                            <label for="muntah_tidak">Tidak</label>
                                                                        </div>
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="checkbox" id="muntah_warna"
                                                                                name="muntah[]" value="Warna">
                                                                            <label for="muntah_warna">Warna</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" name="warna_muntah"
                                                                        class="form-control"
                                                                        placeholder="warna muntah ..." value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            BAB :
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control"
                                                                    name="bab" value="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">X/Hari</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            Warna :
                                                            <input type="text" class="form-control"
                                                                name="warna_bab" value="">
                                                        </div>
                                                        <div class="col-4">
                                                            Konsistensi :
                                                            <input type="text" class="form-control"
                                                                name="konsistensi_bab" value="">

                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Sklera:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="sklera_ikterik" name="sklera[]"
                                                                value="Ikterik">
                                                            <label for="sklera_ikterik">Ikterik</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="sklera_tidak" name="sklera[]"
                                                                value="Tidak">
                                                            <label for="sklera_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Mulut &amp; Pharyng: <br>
                                                    <div class="form-group clearfix">
                                                        Mukosa:
                                                        <div class="icheck-primary d-inline mr-3 ml-3">
                                                            <input type="checkbox" id="mukosa_lembab" name="mukosa[]"
                                                                value="Lembab">
                                                            <label for="mukosa_lembab">Lembab</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="mukosa_kering" name="mukosa[]"
                                                                value="Kering">
                                                            <label for="mukosa_kering">Kering</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="mukosa_lesi" name="mukosa[]"
                                                                value="Lesi">
                                                            <label for="mukosa_lesi">Lesi</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="mukosa_nodul" name="mukosa[]"
                                                                value="Nodul">
                                                            <label for="mukosa_nodul">Nodul</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            Lidah Warna :
                                                            <input type="text" class="form-control"
                                                                name="warna_lidah" value="">
                                                        </div>
                                                        <div class="col-8 mt-4">
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="lidah_ulkus"
                                                                        name="lidah_warna[]" value="Ulkus">
                                                                    <label for="lidah_ulkus">Ulkus</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="lidah_ada"
                                                                        name="lidah_warna[]" value="Ada">
                                                                    <label for="lidah_ada">Ada</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="lidah_tidak"
                                                                        name="lidah_warna[]" value="Tidak">
                                                                    <label for="lidah_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Reflek Menelan:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="reflek_menelan_dapat"
                                                                name="reflek_menelan[]" value="Dapat">
                                                            <label for="reflek_menelan_dapat">Dapat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="reflek_menelan_tidak"
                                                                name="reflek_menelan[]" value="Tidak">
                                                            <label for="reflek_menelan_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Reflek Mengunyah:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="reflek_mengunyah_dapat"
                                                                name="reflek_mengunyah[]" value="Dapat">
                                                            <label for="reflek_mengunyah_dapat">Dapat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="reflek_mengunyah_tidak"
                                                                name="reflek_mengunyah[]" value="Tidak">
                                                            <label for="reflek_mengunyah_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Alat Bantu:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="alat_bantu_tidak"
                                                                name="alat_bantu[]" value="Tidak">
                                                            <label for="alat_bantu_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="alat_bantu_ya"
                                                                name="reflek_mengunyah[]" value="Ya">
                                                            <label for="alat_bantu_ya">Ya (NGT/OGT)*</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="input-group">
                                                                Abdomen : bising usu :
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="bising_usu" value="">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">X/Menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mt-4">
                                                            <div class="form-group clearfix">
                                                                Bentuk :
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="bentuk_abdomen_kembung"
                                                                        name="bentuk_abdomen[]" value="Kembung">
                                                                    <label for="bentuk_abdomen_kembung">Kembung</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" id="bentuk_abdomen_datar"
                                                                        name="bentuk_abdomen[]" value="Datar">
                                                                    <label for="bentuk_abdomen_datar">Datar</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Stomata:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="stomata_ya" name="stomata[]"
                                                                value="Ya">
                                                            <label for="stomata_ya">Ya</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="stomata_tidak" name="stomata[]"
                                                                value="Tidak">
                                                            <label for="stomata_tidak">Tidak (lanjutkan ke pengkajian
                                                                stomata)</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>Drain:
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="drain_tidak" name="drain[]"
                                                                value="Tidak">
                                                            <label for="drain_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="drain_ya" name="drain[]"
                                                                value="Ya">
                                                            <label for="drain_ya">Ya (silicon/T-Tube/penrose)*</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Muskulo Skeletal</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Faktur :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="fraktur_tidak" name="fraktur[]"
                                                                value="Tidak">
                                                            <label for="fraktur_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="fraktur_ada" name="fraktur[]"
                                                                value="Ada">
                                                            <label for="fraktur_ada">Ada (lanjut ke char
                                                                muskulosketal)*</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Mobilitas :
                                                    <div class="form-group clearfix">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div class="icheck-primary d-inline mr-3">
                                                                    <input type="checkbox" id="mobilitas_mandiri"
                                                                        name="mobilitas[]" value="Mandiri">
                                                                    <label for="mobilitas_mandiri">Mandiri</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="icheck-primary d-inline">
                                                                            <input type="checkbox"
                                                                                id="mobilitas_dibantu"
                                                                                name="mobilitas[]" value="Dibantu">
                                                                            <label for="mobilitas_dibantu">Dibantu, alat
                                                                                bantu..</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <input type="text"
                                                                            name="mobilitas_alat_bantu"
                                                                            class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Neurologi</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Kesulitan Bicara :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="kesulitan_bicara_tidak"
                                                                name="kesulitan_bicara[]" value="Tidak">
                                                            <label for="kesulitan_bicara_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="kesulitan_bicara_ada"
                                                                name="kesulitan_bicara[]" value="Ada">
                                                            <label for="kesulitan_bicara_ada">Ada</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Kelemahan alat gerak :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="kelemahan_alat_gerak_tidak"
                                                                name="kelemahan_alat_gerak[]" value="Tidak">
                                                            <label for="kelemahan_alat_gerak_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="kelemahan_alat_gerak_ada"
                                                                name="kelemahan_alat_gerak[]" value="Ada">
                                                            <label for="kelemahan_alat_gerak_ada">Ada</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Terpasang EVD :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="evd_tidak" name="evd[]"
                                                                value="Tidak">
                                                            <label for="evd_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="evd_ya" name="evd[]"
                                                                value="Ya">
                                                            <label for="evd_ya">Ya</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Urogenital</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Perubahan pada pola bak :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="pola_bak_tidak"
                                                                name="pola_bak[]" value="Tidak">
                                                            <label for="pola_bak_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pola_bak_ya" name="pola_bak[]"
                                                                value="Ya">
                                                            <label for="pola_bak_ya">Ya (tidak lampias, sensasi terbakar
                                                                saat miksi, penurunan pencaran urine)*</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            Frekuensi BAK :
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control"
                                                                    name="frekuensi_bak" value="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">X/Hari</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            Warna Urina:
                                                            <input type="text" class="form-control"
                                                                name="warna_urina" value="">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Alat Bantu :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="uro_alat_bantu_tidak"
                                                                name="uro_alat_bantu[]" value="Tidak">
                                                            <label for="uro_alat_bantu_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="uro_alat_bantu_ya"
                                                                name="uro_alat_bantu[]" value="Ya">
                                                            <label for="uro_alat_bantu_ya">Ya (dower kateter/kondom
                                                                kateter)</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Stomata :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="uro_stomata_tidak"
                                                                name="uro_stomata[]" value="Tidak">
                                                            <label for="uro_stomata_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="uro_stomata_ya"
                                                                name="uro_stomata[]" value="Ya">
                                                            <label for="uro_stomata_ya">Ya
                                                                (urustomy/nefrostomy/cystotomy)* lanjutkan ke pengkajian
                                                                stomata</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Sistem Integumen</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Luka :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="integumen_luka_tidak"
                                                                name="integumen_luka[]" value="Tidak">
                                                            <label for="integumen_luka_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="integumen_luka_ya"
                                                                name="integumen_luka[]" value="Ya">
                                                            <label for="integumen_luka_ya">Ya (lanjut ke pengkajian &amp;
                                                                perkembangan luka)</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Benjolan :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="integumen_benjolan_tidak"
                                                                name="integumen_benjolan[]" value="Tidak">
                                                            <label for="integumen_benjolan_tidak">Tidak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="integumen_benjolan_ya"
                                                                name="integumen_benjolan[]" value="Ya">
                                                            <label for="integumen_benjolan_ya">Ya (gunakan gambar untuk
                                                                menunjukkan lokasi benjolan)</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Suhu :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="integumen_suhu_hangat"
                                                                name="integumen_suhu[]" value="Hangat">
                                                            <label for="integumen_suhu_hangat">Hangat</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="integumen_suhu_dingin"
                                                                name="integumen_suhu[]" value="Dingin">
                                                            <label for="integumen_suhu_dingin">Dingin</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="integumen_suhu_panas"
                                                                name="integumen_suhu[]" value="Panas">
                                                            <label for="integumen_suhu_panas">Panas</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Hygiene</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Aktivitas sehari-hari :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="aktivitas_hygiene_mandiri"
                                                                name="aktivitas_hygiene[]" value="Mandiri">
                                                            <label for="aktivitas_hygiene_mandiri">Mandiri</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="aktivitas_hygiene_dibantu"
                                                                name="aktivitas_hygiene[]" value="dibantu">
                                                            <label for="aktivitas_hygiene_dibantu">dibantu</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Penampilan :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="penampilan_hygiene_bersih"
                                                                name="penampilan_hygiene[]" value="Bersih">
                                                            <label for="penampilan_hygiene_bersih">Bersih</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="penampilan_hygiene_kotor"
                                                                name="penampilan_hygiene[]" value="Kotor">
                                                            <label for="penampilan_hygiene_kotor">Kotor</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Psikososial dan Budaya</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Ekspresi wajah :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="ekspresi_wajah_cerah"
                                                                name="ekspresi_wajah[]" value="Cerah">
                                                            <label for="ekspresi_wajah_cerah">Cerah</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ekspresi_wajah_tenang"
                                                                name="ekspresi_wajah[]" value="Tenang">
                                                            <label for="ekspresi_wajah_tenang">Tenang</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ekspresi_wajah_murung"
                                                                name="ekspresi_wajah[]" value="Murung">
                                                            <label for="ekspresi_wajah_murung">Murung</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ekspresi_wajah_cemas"
                                                                name="ekspresi_wajah[]" value="Cemas">
                                                            <label for="ekspresi_wajah_cemas">Cemas</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ekspresi_wajah_takut"
                                                                name="ekspresi_wajah[]" value="Takut">
                                                            <label for="ekspresi_wajah_takut">Ketakutan</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="ekspresi_wajah_panik"
                                                                name="ekspresi_wajah[]" value="Panik">
                                                            <label for="ekspresi_wajah_panik">Panik</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Kemampuan Bicara :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox"
                                                                id="kemampuan_bicara_psiko_sosbud_baik"
                                                                name="kemampuan_bicara_psiko_sosbud[]" value="Baik">
                                                            <label for="kemampuan_bicara_psiko_sosbud_baik">Baik</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox"
                                                                id="kemampuan_bicara_psiko_sosbud_tidak_bicara"
                                                                name="kemampuan_bicara_psiko_sosbud[]"
                                                                value="tidak_dapat_bicara">
                                                            <label for="kemampuan_bicara_psiko_sosbud_tidak_bicara">Tidak
                                                                Dapat Bicara</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox"
                                                                id="kemampuan_bicara_psiko_sosbud_tidak_kontak"
                                                                name="kemampuan_bicara_psiko_sosbud[]"
                                                                value="Tidak_kontak_mata">
                                                            <label for="kemampuan_bicara_psiko_sosbud_tidak_kontak">Tidak
                                                                Mau Kontak Mata</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Koping Mekanisme :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="koping_selesaikan_sendiri"
                                                                name="koping_mekanisme[]" value="selesaikan_sendiri">
                                                            <label for="koping_selesaikan_sendiri">Menyelesaikan Masalah
                                                                Sendiri</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="koping_selalu_dibantu"
                                                                name="koping_mekanisme[]" value="selalu_dibantu">
                                                            <label for="koping_selalu_dibantu">Selalu dibantu bila ada
                                                                masalah</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Pekerjaan :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="pekerjaan_wiraswasta"
                                                                name="pekerjaan[]" value="wiraswasta">
                                                            <label for="pekerjaan_wiraswasta">Wiraswasta</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pekerjaan_swasta"
                                                                name="pekerjaan[]" value="pegawai_swasta">
                                                            <label for="pekerjaan_swasta">Pegawai Swasta</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pekerjaan_pensiunan"
                                                                name="pekerjaan[]" value="pensiunan">
                                                            <label for="pekerjaan_pensiunan">Pensiunan</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pekerjaan_pns_polri"
                                                                name="pekerjaan[]" value="pns_polri">
                                                            <label for="pekerjaan_pns_polri">PNS/TNI/POLRI</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="pekerjaan_lain"
                                                                name="pekerjaan[]" value="lain_lain">
                                                            <label for="pekerjaan_lain">lain-lain</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Tinggal Bersama :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="tinggal_bersama_suami_istri"
                                                                name="tinggal_bersama[]" value="suami_istri">
                                                            <label for="tinggal_bersama_suami_istri">Suami/Istri</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tinggal_bersama_orangtua"
                                                                name="tinggal_bersama[]" value="orangtua">
                                                            <label for="tinggal_bersama_orangtua">Orangtua</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tinggal_bersama_anak"
                                                                name="tinggal_bersama[]" value="anak">
                                                            <label for="tinggal_bersama_anak">Anak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tinggal_bersama_teman"
                                                                name="tinggal_bersama[]" value="teman">
                                                            <label for="tinggal_bersama_teman">Teman</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tinggal_bersama_sendiri"
                                                                name="tinggal_bersama[]" value="sendiri">
                                                            <label for="tinggal_bersama_sendiri">Sendiri</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tinggal_bersama_lainya"
                                                                name="tinggal_bersama[]" value="lain_lain">
                                                            <label for="tinggal_bersama_lainya">Lain-lain</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Suku :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="suku_jawa" name="suku[]"
                                                                value="jawa">
                                                            <label for="suku_jawa">Jawa</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="suku_sunda" name="suku[]"
                                                                value="sunda">
                                                            <label for="suku_sunda">Sunda</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="suku_batak" name="suku[]"
                                                                value="batak">
                                                            <label for="suku_batak">Batak</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="suku_tionghoa" name="suku[]"
                                                                value="tionghoa">
                                                            <label for="suku_tionghoa">Tionghoa</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>

                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Spiritual dan nilai-nilai kepercayaan</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ol type="a" style="font-size: 13px;">
                                                <li>
                                                    Agama :
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="spiritual_agama_islam"
                                                                name="spiritual_agama[]" value="islam">
                                                            <label for="spiritual_agama_islam">Islam</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="spiritual_agama_kristen"
                                                                name="spiritual_agama[]" value="kristen">
                                                            <label for="spiritual_agama_kristen">Kristen</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="spiritual_agama_hindu"
                                                                name="spiritual_agama[]" value="hindu">
                                                            <label for="spiritual_agama_hindu">Hindu</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="spiritual_agama_budha"
                                                                name="spiritual_agama[]" value="budha">
                                                            <label for="spiritual_agama_budha">Budha</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline mr-3">
                                                            <input type="checkbox" id="spiritual_agama_katolik"
                                                                name="spiritual_agama[]" value="katolik">
                                                            <label for="spiritual_agama_katolik">Katolik</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Mengungkapkan keprihatinan yang berhubungan dengan rawat inap :
                                                    <div class="form-group clearfix row">
                                                        <div class="col-2">
                                                            <div class="icheck-primary d-inline mr-3">
                                                                <input type="checkbox" id="keprihatinan_tidak"
                                                                    name="keprihatinan_jawaban" value="Tidak">
                                                                <label for="keprihatinan_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" id="keprihatinan_Ya"
                                                                            name="keprihatinan_jawaban" value="Ya">
                                                                        <label for="keprihatinan_Ya">Ya :</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-10">
                                                                    <div class="form-group clearfix">
                                                                        <div class="row">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox"
                                                                                    id="keprihatinan_detail_1"
                                                                                    name="keprihatinan_ya_detail[]"
                                                                                    value="ketidak_mampuan_praktek_spiritual">
                                                                                <label for="keprihatinan_detail_1">Ketidak
                                                                                    mampuan untuk mempertahankan praktek
                                                                                    spiritual.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox"
                                                                                    id="keprihatinan_detail_2"
                                                                                    name="keprihatinan_ya_detail[]"
                                                                                    value="perasaan_negatif_kepercayaan">
                                                                                <label
                                                                                    for="keprihatinan_detail_2">Perasaan
                                                                                    negatif tentang sistem
                                                                                    kepercayaan.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox"
                                                                                    id="keprihatinan_detail_3"
                                                                                    name="keprihatinan_ya_detail[]"
                                                                                    value="konflik_spiritual_dengan_kesehatan">
                                                                                <label for="keprihatinan_detail_3">Konflik
                                                                                    antara kepercayaan spiritual dengan
                                                                                    sistem kesehatan.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox"
                                                                                    id="keprihatinan_detail_4"
                                                                                    name="keprihatinan_ya_detail[]"
                                                                                    value="bimbingan_rohani">
                                                                                <label
                                                                                    for="keprihatinan_detail_4">Bimbingan
                                                                                    rohani.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="checkbox"
                                                                                    id="keprihatinan_detail_5"
                                                                                    name="keprihatinan_ya_detail[]"
                                                                                    value="lain_lain">
                                                                                <label
                                                                                    for="keprihatinan_detail_5">Lain-lain.</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    Nilai-Nilai Kepercayaan :
                                                    <input type="text" name="nilai_kepercayaan"
                                                        class="form-control" value="">
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Asesmen Resiko Jatuh Pasien Dewasa</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black;">Faktor Risiko</th>
                                                        <th style="border: 1px solid black;">Skala</th>
                                                        <th style="border: 1px solid black;">Skor</th>
                                                        <th style="border: 1px solid black;">Skor Pasien</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black;">Riwayat
                                                            Jatuh</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_riwayat_jatuh_tidak"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Ya</td>
                                                        <td style="border: 1px solid black; text-align:center;">25</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_riwayat_jatuh_ya"
                                                                class="form-control skor-input" max="25"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black;">Diagnosa
                                                            Sekunder</td>
                                                        <td style="border: 1px solid black;text-align:center;">Tidak</td>
                                                        <td style="border: 1px solid black;text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_diagnosa_sekunder_tidak"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Ya</td>
                                                        <td style="border: 1px solid black; text-align:center;">15</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_diagnosa_sekunder_ya"
                                                                class="form-control skor-input" max="15"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="3" style="border: 1px solid black;">Menggunakan
                                                            alat-alat bantu</td>
                                                        <td style="border: 1px solid black;text-align:center;">Tidak
                                                            ada/Bedrest/dibantu perawat</td>
                                                        <td style="border: 1px solid black;text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_alat_bantu_tidak"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">
                                                            Kruk/Tongkat</td>
                                                        <td style="border: 1px solid black; text-align:center;">15</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_alat_bantu_kruk"
                                                                class="form-control skor-input" max="15"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">
                                                            Kursi/Perabot</td>
                                                        <td style="border: 1px solid black; text-align:center;">30</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_alat_bantu_kursi"
                                                                class="form-control skor-input" max="30"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black;">Menggunakan
                                                            infus/heparin/pengencer darah/obat
                                                            risiko jatuh</td>
                                                        <td style="border: 1px solid black;text-align:center;">Tidak</td>
                                                        <td style="border: 1px solid black;text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_infus_tidak"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Ya</td>
                                                        <td style="border: 1px solid black; text-align:center;">20</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_infus_ya"
                                                                class="form-control skor-input" max="20"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="3" style="border: 1px solid black;">Gaya
                                                            berjalan</td>
                                                        <td style="border: 1px solid black;text-align:center;">
                                                            Normal/Bedrest/kursi roda</td>
                                                        <td style="border: 1px solid black;text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_gaya_berjalan_normal"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Lemah</td>
                                                        <td style="border: 1px solid black; text-align:center;">10</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_gaya_berjalan_lemah"
                                                                class="form-control skor-input" max="10"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Terganggu
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">20</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_gaya_berjalan_terganggu"
                                                                class="form-control skor-input" max="20"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black;">Status
                                                            mental</td>
                                                        <td style="border: 1px solid black;text-align:center;">Menyadari
                                                            kemampuan</td>
                                                        <td style="border: 1px solid black;text-align:center;">0</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_status_mental_menyadari"
                                                                class="form-control skor-input" max="0"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">Lupa akan
                                                            keterbatasan/pelupa</td>
                                                        <td style="border: 1px solid black; text-align:center;">15</td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_status_mental_lupa"
                                                                class="form-control skor-input" max="15"
                                                                value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="mt-2">
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" id="pasien_tidak_beresiko"
                                                                    name="pasien_tidak_beresiko">
                                                                <label for="pasien_tidak_beresiko">Pasien tidak beresiko
                                                                    (0-24) </label>
                                                            </div> <br><br>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="pasien_risiko_sedang"
                                                                    name="pasien_risiko_sedang">
                                                                <label for="pasien_risiko_sedang">Pasien risiko
                                                                    rendah-sedang (25-44)</label>
                                                            </div> <br><br>
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" id="pasien_risiko_tinggi"
                                                                    name="pasien_risiko_tinggi">
                                                                <label for="pasien_risiko_tinggi">Pasien risiko tinggi
                                                                    (&gt; 45)*</label>
                                                            </div>
                                                        </td>
                                                        <td colspan="2" class="mt-2 text-left">
                                                            <div class="form-group">
                                                                <label for="total_skor">Total Skor</label>
                                                                <input type="text" id="total_skor"
                                                                    name="total_skor_pasien" value="0"
                                                                    class="form-control" readonly="">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Asesmen Resiko Jatuh Pasien Geriatri</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="card-body">
                                            <table style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black;">Parameter</th>
                                                        <th style="border: 1px solid black;">Skrinning</th>
                                                        <th style="border: 1px solid black;">Keterangan Nilai</th>
                                                        <th style="border: 1px solid black; width:100px;">Keterangan</th>
                                                        <th style="border: 1px solid black;">Skor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black;">Riwayat
                                                            Jatuh</td>
                                                        <td style="border: 1px solid black; text-align:left;">Apakah
                                                            pasien datang ke rumah sakit karena
                                                            jatuh?</td>
                                                        <td rowspan="2"
                                                            style="border: 1px solid black; text-align:left;">salah satu
                                                            jawaban <br> Ya =
                                                            6</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_riwayat_jatuh[]"
                                                                class="form-control skrining-select"
                                                                data-input="skor_skrining_riwayat_jatuh_1">
                                                                <option value="0">
                                                                    Tidak</option>
                                                                <option value="6"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_riwayat_jatuh[]"
                                                                id="skor_skrining_riwayat_jatuh_1"
                                                                class="form-control skor-skrining-input" max="6"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">Jika tidak,
                                                            apakah pasien mengalami jatuh
                                                            dalam 2 bulan terakhir?</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_riwayat_jatuh[]"
                                                                class="form-control skrining-select"
                                                                data-input="skor_skrining_riwayat_jatuh_2">
                                                                <option value="0">
                                                                    Tidak</option>
                                                                <option value="6">
                                                                    Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_riwayat_jatuh[]"
                                                                id="skor_skrining_riwayat_jatuh_2"
                                                                class="form-control skor-skrining-input" max="6"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>

                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="3" style="border: 1px solid black;">Status
                                                            Mental</td>
                                                        <td style="border: 1px solid black; text-align:left;">Apakah
                                                            pasien delirium? <br>(tidak dapat
                                                            membuat keputusan, pola pikir tidak terorganisir, gangguan daya
                                                            ingat)?</td>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:left;">salah satu
                                                            jawaban <br> Ya =
                                                            14</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_status_mental[]"
                                                                class="form-control skrining-select"
                                                                data-input="skor_skrining_status_mental_1">
                                                                <option value="0"> Tidak
                                                                </option>
                                                                <option value="14"> Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_status_mental[]"
                                                                id="skor_skrining_status_mental_1"
                                                                class="form-control skor-skrining-input" max="14"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">Apakah
                                                            pasien disorientasi? <br>(salah
                                                            menyebutkan waktu, tempat atau orang)</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_status_mental[]"
                                                                class="form-control skrining-select"
                                                                data-input="skor_skrining_status_mental_2">
                                                                <option value="0"> Tidak
                                                                </option>
                                                                <option value="14"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_status_mental[]"
                                                                id="skor_skrining_status_mental_2"
                                                                class="form-control skor-skrining-input" max="14"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">Apakah
                                                            pasien mengalami agitasi?
                                                            <br>(ketakutan, gelisah dan cemas)
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_status_mental[]"
                                                                class="form-control skrining-select"
                                                                data-input="skor_skrining_status_mental_3">
                                                                <option value="0"> Tidak</option>
                                                                <option value="14"> Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_status_mental[]"
                                                                id="skor_skrining_status_mental_3"
                                                                class="form-control skor-skrining-input" max="14"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="3" style="border: 1px solid black;">Penglihatan
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:left;">apakah
                                                            pasien memakai kacamata?</td>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:left;">salah satu
                                                            jawaban <br> Ya =
                                                            1</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_penglihatan[]"
                                                                data-input="skringing_penglihatan_1"
                                                                class="form-control skrining-select">
                                                                <option value="0"> Tidak
                                                                </option>
                                                                <option value="1"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_penglihatan[]"
                                                                id="skringing_penglihatan_1"
                                                                class="form-control skor-skrining-input" max="0"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">apakah
                                                            pasien mengeluh adanya penglihatan
                                                            buram?</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_penglihatan[]"
                                                                data-input="skringing_penglihatan_2"
                                                                class="form-control skrining-select">
                                                                <option value="0">
                                                                    Tidak</option>
                                                                <option value="1"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_penglihatan[]"
                                                                id="skringing_penglihatan_2"
                                                                class="form-control skor-skrining-input" max="0"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">apakah
                                                            pasien mengeluh glaukoma, katarak,
                                                            atau degenerasi makula?</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_penglihatan[]"
                                                                data-input="skringing_penglihatan_3"
                                                                class="form-control skrining-select">
                                                                <option value="0"> Tidak
                                                                </option>
                                                                <option value="1"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="skor_skrining_penglihatan[]"
                                                                id="skringing_penglihatan_3"
                                                                class="form-control skor-skrining-input" max="0"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black;">Kebiasaan Berkemih</td>
                                                        <td style="border: 1px solid black; text-align:left;">apakah
                                                            terdapat perubahan perilaku berkemih?
                                                            <br>(frekuensi, urgensi, inkontinesia, nokturia)
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:left;">Ya = 2</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="skrining_kebiasaan_berkemih[]"
                                                                data-input="skor_skrining_kebiasaan_berkemih"
                                                                class="form-control skrining-select">
                                                                <option value="0">
                                                                    Tidak</option>
                                                                <option value="2"> Ya
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number"
                                                                name="skor_skrining_kebiasaan_berkemih[]"
                                                                id="skor_skrining_kebiasaan_berkemih"
                                                                class="form-control skor-skrining-input" max="0"
                                                                value="0" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="4" style="border: 1px solid black;">Transfer (
                                                            dari tempat tidur ke kursi dan
                                                            kembali ke tempat tidur)</td>
                                                        <td style="border: 1px solid black; text-align:left;">Mandiri
                                                            (boleh menggunakan alat bantu jalan)
                                                        </td>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black; text-align:left;">jumlahkan
                                                            nilai transfer dan
                                                            mobilitas. <br> jika nilai total 0-3 maka nilai skor = 0 <br>
                                                            jika nilai total 4-6 maka skor = 7
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td rowspan="8">
                                                            <select name="transfer_mobilitas" id="transfer_mobilitas"
                                                                class="form-control skrining-select skor-skrining-input">
                                                                <option value="0">0
                                                                </option>
                                                                <option value="7">7
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">memerlukan
                                                            sedikit bantuan (1 orang)/dalam
                                                            pengawasan</td>
                                                        <td style="border: 1px solid black;text-align:center;">1</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">memerlukan
                                                            bantuan yang nyata (2 orang)</td>
                                                        <td style="border: 1px solid black;text-align:center;">2</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">tidak dapat
                                                            duduk dengan seimbang, perlu
                                                            bantuan total</td>
                                                        <td style="border: 1px solid black;text-align:center;">3</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="4" style="border: 1px solid black;">Mobilitas
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:left;">Mandiri
                                                            (boleh menggunakan alat bantu jalan)
                                                        </td>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black; text-align:left;">mandiri
                                                            (boleh menggunakan
                                                            alat bantu jalan)</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">berjalan
                                                            dengan bantuan 1 orang(verbal/fisik)
                                                        </td>
                                                        <td style="border: 1px solid black;text-align:center;">1</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">menggunakan
                                                            kursi roda</td>
                                                        <td style="border: 1px solid black;text-align:center;">2</td>
                                                    </tr>
                                                    <tr style="border: 1px solid black;">
                                                        <td style="border: 1px solid black; text-align:left;">imobilisasi
                                                        </td>
                                                        <td style="border: 1px solid black;text-align:center;">3</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="mt-2">
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" id="risiko_jatuh_rendah"
                                                                    name="risiko_jatuh_rendah">
                                                                <label for="risiko_jatuh_rendah">Skor 0-5 risiko rendah
                                                                    jatuh </label>
                                                            </div> <br><br>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="risiko_jatuh_sedang"
                                                                    name="risiko_jatuh_sedang">
                                                                <label for="risiko_jatuh_sedang">Skor 6-16 risiko jatuh
                                                                    sedang</label>
                                                            </div> <br><br>
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" id="risiko_jatuh_tinggi"
                                                                    name="risiko_jatuh_tinggi">
                                                                <label for="risiko_jatuh_tinggi">Skor 17-30 risiko jatuh
                                                                    tinggi</label>
                                                            </div>
                                                        </td>
                                                        <td colspan="2" class="mt-2 text-left">
                                                            <div class="form-group">
                                                                <label for="total_skor_skrining">Total Skor</label>
                                                                <input type="text" id="total_skor_skrining"
                                                                    name="total_skor_skrining" value="0"
                                                                    class="form-control" readonly="">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Data Diagnostik dan Kebutuhan Edukasi</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h6><strong>Data Diagnostik</strong></h6>
                                                    <div class="form-group">
                                                        <label for="Laboratiorium">Laboratorium</label>
                                                        <input type="text" name="diagnostik_laboratorium"
                                                            value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Radiologi">Radiologi</label>
                                                        <input type="text" name="diagnostik_radiologi"
                                                            value="" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Lain-lain">Lain-lain</label>
                                                        <input type="text" name="diagnostik_lainya" value=""
                                                            class="form-control">
                                                    </div>

                                                </div>
                                                <div class="col-6">
                                                    <h6><strong>Kebutuhan Edukasi</strong></h6>
                                                    <ol type="1" style="font-size: 13px;">
                                                        <li>
                                                            <div class="form-group">
                                                                <label for="tentang_penyakit">Apa yang saudara ketahui
                                                                    tentang penyakit saudara</label>
                                                                <input type="text" name="tentang_penyakit"
                                                                    class="form-control" value="">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-group">
                                                                <label for="informasi_yg_ingin_diketahui">Informasi apa
                                                                    yang ingin saudara ketahui / yang diperlukan</label>
                                                                <input type="text"
                                                                    name="informasi_yg_ingin_diketahui"
                                                                    class="form-control" value="">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-group">
                                                                <label for="keluarga_terlibat_perawatan">Keluarga yang
                                                                    ikut terlibat dalam perawatan selanjutnya</label>
                                                                <input type="text" name="keluarga_terlibat_perawatan"
                                                                    class="form-control" value="">
                                                            </div>
                                                        </li>
                                                    </ol>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Skrining Nutrisi</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black; padding: 10px;">No</th>
                                                        <th style="border: 1px solid black; padding: 10px;">Parameter</th>
                                                        <th style="border: 1px solid black; padding: 10px;">Nilai</th>
                                                        <th style="border: 1px solid black; padding: 10px;">Skor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="10"
                                                            style="border: 1px solid black; padding: 10px;">1</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">Apakah Pasien
                                                            mengalami penurunan berat badan
                                                            yang tidak direncanakan?</td>
                                                        <td style="border: 1px solid black; padding: 10px;"></td>
                                                        <td style="border: 1px solid black; padding: 10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="checkbox" class="nilai-checkbox"
                                                                data-skor="0" name="tidak_terjadi_penurunan">
                                                            <label>Tidak (tidak terjadi penurunan dalam 6 bulan
                                                                terakhir)</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">0</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="checkbox" class="nilai-checkbox"
                                                                data-skor="2" name="tidak_yakin_penurunan">
                                                            <label>Tidak Yakin (tanyakan apakah baju/celana terasa
                                                                longgar)</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">2</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="checkbox" id="ya_penurunan_bb"
                                                                name="ya_penurunan_bb">
                                                            <label for="ya_penurunan_bb">Ya, berapakah penurunan berat
                                                                badan tersebut?</label>
                                                        </td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="radio" name="penurunan_bb" value="1"
                                                                class="nilai-radio" data-skor="1">
                                                            <label>1 - 5 Kg</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">1</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text" name="skor_penurunan_bb_1_5"
                                                                value="" class="form-control skor-input-skrining"
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="radio" name="penurunan_bb" value="2"
                                                                class="nilai-radio" data-skor="2">
                                                            <label>6 - 10 Kg</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">2</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text" name="skor_penurunan_bb_6_10"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="radio" name="penurunan_bb" value="3"
                                                                class="nilai-radio" data-skor="3">
                                                            <label>11 - 15 Kg</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">3</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text" name="skor_penurunan_bb_11_15"
                                                                value="" class="form-control skor-input-skrining"
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="radio" name="penurunan_bb" value="4"
                                                                class="nilai-radio" data-skor="4">
                                                            <label>Lebih dari 15 Kg</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">4</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text" name="skor_penurunan_bb_lbh_15"
                                                                value="" class="form-control skor-input-skrining"
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="radio" name="penurunan_bb"
                                                                class="nilai-radio" data-skor="2">
                                                            <label>Tidak Yakin</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align: center;">2</td>
                                                        <td style="border: 1px solid black; padding: 10px;">
                                                            <input type="text" name="skor_penurunan_bb_tidak_yakin"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black;padding:10px;">2</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">Apakah asupan
                                                            makan pasien buruk akibat nafsu
                                                            makan yang menurun**? (misalnya asupan makan 3/4 dari
                                                            biasasanya)</td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="radio" id="asupan_makan_buruk_tidak"
                                                                class="nilai-radio" name="asupan_makan_buruk"
                                                                data-skor="0" value="0">
                                                            <label for="asupan_makan_buruk_tidak">Tidak</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="text" name="skor_asupan_makan_buruk_tidak"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="radio" id="asupan_makan_buruk_ya"
                                                                class="nilai-radio" name="asupan_makan_buruk"
                                                                data-skor="1" value="1">
                                                            <label for="asupan_makan_buruk_ya">Ya</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="text" name="skor_asupan_makan_buruk_ya"
                                                                class="form-control skor-input-skrining" value=""
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black;padding:10px;">3</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">Sakit Berat **
                                                        </td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="radio" id="sakit_berat_tidak"
                                                                value="0" name="sakit_berat">
                                                            <label for="sakit_berat_tidak">Tidak</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">-</td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; padding:10px;">
                                                            <input type="radio" id="sakit_berat_ya"
                                                                name="sakit_berat" value="1">
                                                            <label for="sakit_berat_ya">Ya</label>
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">-</td>
                                                        <td style="border: 1px solid black; padding:10px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"
                                                            style="text-align: right; border: 1px solid black; padding: 10px;">
                                                            <strong>Total Skor</strong>
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black; padding: 10px; text-align: center;">
                                                            <input type="text" name="total_skor_skrining_nutrisi"
                                                                id="total_skor_skrining_nutrisi" class="form-control"
                                                                value="" readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"
                                                            style="border: 1px solid black; text-align:left;">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="col-12">Kesimpulan dan tindak lanjut :
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <input type="checkbox" class="kesimpulan-skor"
                                                                            name="kesimpulan_skor_lbh_2"
                                                                            id="kesimpulan_skor_lbh_2">
                                                                        <label>Total Skor &gt; 2, rujuk ke diestisien untuk
                                                                            asesmen</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <input type="checkbox" class="kesimpulan-skor"
                                                                        name="kesimpulan_skor_krg_2"
                                                                        id="kesimpulan_skor_krg_2">
                                                                    <label>Total Skor &lt; 2, skrining ulang 7 hari</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Asesmen Fungsional (Barthel Index)</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black; text-align:center;">No</th>
                                                        <th style="border: 1px solid black; text-align:center;">Fungsi
                                                        </th>
                                                        <th style="border: 1px solid black; text-align:center;">Skor</th>
                                                        <th style="border: 1px solid black; text-align:center;">Keterangan
                                                        </th>
                                                        <th style="border: 1px solid black; text-align:center;">Skor
                                                            Pasien</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">1.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            Mengendalikan Rangsang Defeksi</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak
                                                            terkendali/tak teratur (perlu bantuan)
                                                        </td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_rangsang_defeksi"
                                                                value="" class="form-control skor-input-af"
                                                                max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">
                                                            Kadang-kadang tak terkendali</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">2.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            Mengendalikan Rangsang Berkemih</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tak
                                                            terkendali / pakai kateter</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_rangsang_berkemih"
                                                                value="" class="form-control skor-input-af"
                                                                max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">
                                                            Kadang-kadang tak terkendali (1x24jam)</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"
                                                            style="border: 1px solid black; text-align:center;">3.</td>
                                                        <td rowspan="2" style="border: 1px solid black;">Membersihkan
                                                            Diri (seka muka, sisir rambut,
                                                            sikat gigi)</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Butuh
                                                            pertolongan orang lain</td>
                                                        <td rowspan="2" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_membersihkan_diri"
                                                                value="" class="form-control skor-input-af"
                                                                max="1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">4.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">Penggunaan
                                                            Jamban, Masuk dan Keluar</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tergantung
                                                            pertolongan orang lain</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_penggunaan_jamban"
                                                                value="" class="form-control skor-input-af"
                                                                max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Perlu
                                                            pertolongan pada beberapa kegiatan
                                                            terapi, dapat mengerjakan sendiri kegiatan lain</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">5.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">Makan</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak
                                                            Mampu</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_makan" value=""
                                                                class="form-control skor-input-af" max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Perlu
                                                            ditolong memotong makanan</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black; text-align:center;">6.</td>
                                                        <td rowspan="4" style="border: 1px solid black;">Berubah
                                                            sikap dari berbaring ke duduk</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak
                                                            Mampu</td>
                                                        <td rowspan="4" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_berubah_sikap"
                                                                value="" class="form-control skor-input-af"
                                                                max="3">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Perlu
                                                            banyak bantuan untuk bisa
                                                            duduk(2orang)</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Bantuan
                                                            minimal(2orang)</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">3</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="4"
                                                            style="border: 1px solid black; text-align:center;">7.</td>
                                                        <td rowspan="4" style="border: 1px solid black;">
                                                            Berpindah/berjalan</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak
                                                            Mampu</td>
                                                        <td rowspan="4" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_berpindah_berjalan"
                                                                value="" class="form-control skor-input-af"
                                                                max="3">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Bisa
                                                            (pindah) dengan kursi</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Berjalan
                                                            dengan bantuan 1 orang</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">3</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">8.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">Memakai baju
                                                        </td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tergantung
                                                            oranglain</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_memakai_baju"
                                                                value="" class="form-control skor-input-af"
                                                                max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Sebagian
                                                            dibantu(misalnya mengancingkan
                                                            baju)</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="3"
                                                            style="border: 1px solid black; text-align:center;">9.</td>
                                                        <td rowspan="3" style="border: 1px solid black;">Naik Turun
                                                            Tangga</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tidak
                                                            Mampu</td>
                                                        <td rowspan="3" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_naik_tangga"
                                                                value="" class="form-control skor-input-af"
                                                                max="2">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Butuh
                                                            pertolongan oranglain</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">2</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"
                                                            style="border: 1px solid black; text-align:center;">10.</td>
                                                        <td rowspan="2" style="border: 1px solid black;">Mandi</td>
                                                        <td style="border: 1px solid black; text-align:center;">0</td>
                                                        <td style="border: 1px solid black; text-align:center;">Tergantung
                                                        </td>
                                                        <td rowspan="2" style="border: 1px solid black;">
                                                            <input type="number" name="skor_af_mandi" value=""
                                                                class="form-control skor-input-af" max="1">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; text-align:center;">1</td>
                                                        <td style="border: 1px solid black; text-align:center;">Mandiri
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"
                                                            style="border: 1px solid black; text-align:right;">
                                                            <strong>Total Skor :</strong>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="number" name="total_skor_af" value=""
                                                                id="total_skor_af" class="form-control"
                                                                readonly="">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="border: 1px solid black;">
                                                            <div class="row mt-1">
                                                                <div class="col-5 ml-1">
                                                                    <div>
                                                                        <input type="radio" name="skor_total_af"
                                                                            id="skor_total_af_20" value="20">
                                                                        <label for="skor_total_af_20">Skor 20:
                                                                            Mandiri</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="skor_total_af"
                                                                            id="skor_total_af_9_11" value="9-11">
                                                                        <label for="skor_total_af_9_11">Skor 9-11:
                                                                            Ketergantungan Sedang</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="skor_total_af"
                                                                            id="skor_total_af_0_4" value="0-4">
                                                                        <label for="skor_total_af_0_4">Skor 0-4:
                                                                            Ketergantungan Total</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-5">
                                                                    <div>
                                                                        <input type="radio" name="skor_total_af"
                                                                            id="skor_total_af_12_19" value="12-19">
                                                                        <label for="skor_total_af_12_19">Skor 12-19:
                                                                            Ketergantungan Ringan</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="skor_total_af"
                                                                            id="skor_total_af_5_8" value="5-8">
                                                                        <label for="skor_total_af_5_8">Skor 5-8:
                                                                            Ketergantungan Berat</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Rencana Pulang</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-12 row mb-1">
                                                <div class="col-4">
                                                    <strong>Jenis Tempat tinggal pasien :</strong>
                                                    <input type="radio" name="jenis_tt" value="0"
                                                        class="ml-2" checked="">
                                                    <label>Rumah</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" name="jenis_tt" value="1">
                                                    <label>Kost</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="radio" name="jenis_tt" value="2">
                                                    <label>Apartemen</label>
                                                </div>
                                                <div class="col-4" style="text-align: center">
                                                    <input type="text" name="jenis_tt_lainya"
                                                        class="form-control col-12"
                                                        placeholder="masukan tempat lainnya...">
                                                </div>
                                            </div>
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black; text-align:center;">No</th>
                                                        <th style="border: 1px solid black; text-align:center;">Kriteria
                                                            Pulang</th>
                                                        <th style="border: 1px solid black; text-align:center;">Jawaban
                                                        </th>
                                                        <th style="border: 1px solid black; text-align:center;">Keterangan
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="border: 1px solid black;">1.</td>
                                                        <td style="border: 1px solid black;">Usia diatas 70 tahun</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="usia_lbh_7" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_usia_lbh_70"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">2.</td>
                                                        <td style="border: 1px solid black;">Pasien tinggal sendiri</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="pasien_tinggal_sendiri" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_pasien_tinggal_sendiri"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">3.</td>
                                                        <td style="border: 1px solid black;">Tempat tinggal pasien
                                                            memiliki tetangga</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="memiliki_tetangga" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_memiliki_tetangga"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">4.</td>
                                                        <td style="border: 1px solid black;">Memerlukan perawatan lanjutan
                                                            dirumah</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="perawatan_lanjutan_dirumah"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_perawatan_lanjutan_dirumah"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">5.</td>
                                                        <td style="border: 1px solid black;">Mempunyai keterbatasan
                                                            kemampuan merawat diri</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="keterbatasan_merawat_diri"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_keterbatasan_merawat_diri"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">6.</td>
                                                        <td style="border: 1px solid black;">Pasien pulang dengan jumlah
                                                            obat lebih dari 6 jenis / macam
                                                            obat</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="lebih_6_jenis_obat" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_lebih_6_jenis_obat"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">7.</td>
                                                        <td style="border: 1px solid black;">Kesulitan mobilitas</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="kesulitan_mobilitas" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_kesulitan_mobilitas"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">8.</td>
                                                        <td style="border: 1px solid black;">Memerlukan alat bantu</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="memerlukan_alat_bantu" class="form-control"
                                                                id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_memerlukan_alat_bantu"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">9.</td>
                                                        <td style="border: 1px solid black;">Memerlukan pelayanan medis
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="memerlukan_pelayanan_medis"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text" name="ket_memerlukan_pelayanan_medis"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">10.</td>
                                                        <td style="border: 1px solid black;">Memerlukan pelayanan
                                                            keperawatan</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="memerlukan_pelayanan_keperawatan"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text"
                                                                name="ket_memerlukan_pelayanan_keperawatan"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">11.</td>
                                                        <td style="border: 1px solid black;">Memerlukan bantuan dalam
                                                            kehidupan sehari-hari</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="memerlukan_bantuan_sehari_hari"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text"
                                                                name="ket_memerlukan_bantuan_sehari_hari"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">12.</td>
                                                        <td style="border: 1px solid black;">Riwayat sering menggunakan
                                                            fasilitasi gawat darurat</td>
                                                        <td style="border: 1px solid black;">
                                                            <select name="sering_menggunakan_fasilitas_igd"
                                                                class="form-control" id="">
                                                                <option value="0">TIDAK</option>
                                                                <option value="1">Ya</option>
                                                            </select>
                                                        </td>
                                                        <td style="border: 1px solid black;">
                                                            <input type="text"
                                                                name="ket_sering_menggunakan_fasilitas_igd"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary" style="font-size: 12px;">
                                        <div class="card-header">
                                            <h3 class="card-title">Diagnosa Keperawatan</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="Diagnosa Keperawatan">Diagnosa Keperawatan</label>
                                                <textarea name="diagnosa_keperawatan" class="form-control" id="diagnosa_keperawatan" cols="30"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary" style="font-size: 12px;">
                                        <div class="card-header">
                                            <h3 class="card-title">RENCANA ASUHAN KEPERAWATAN</h3>

                                            <div class="card-tools">
                                                <button type="button" id="addRowRencanaAsuhan"
                                                    class="btn btn-primary btn-xs">
                                                    Tambah Baris Rencana
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-xs"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-12 mb-2">
                                                <div id="dynamicFormRencanaAsuhan">
                                                    <!-- Jika tidak ada data rencanaAsuhan, tampilkan form kosong -->
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label>Tanggal</label>
                                                                <input type="hidden" name="id_asuhan_keperawatan[]"
                                                                    value="">
                                                                <input type="date" class="form-control"
                                                                    name="tanggal_asuhan_keperawatan[]"
                                                                    value="2024-11-26">
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label>Waktu</label>
                                                                <input type="time" class="form-control"
                                                                    name="waktu_asuhan_keperawatan[]" value="11:53">
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="form-group">
                                                                <label>Rencana Asuhan</label>
                                                                <input type="text" class="form-control"
                                                                    name="rencana_asuhan_keperawatan[]" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-sm float-right" type="submit">Simpan</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="table-data-assemen-awal-keperawatan">
                                <div class="card">
                                    <iframe
                                        src="http://127.0.0.1:8000/erm-ranap/perawat/assesmen-awal/cetakan/asesmen-awal-keperawatan?kode=22482136"
                                        width="100%" height="700px" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('simrs.erm-ranap.dashboard.component_modal.modal_radiologi')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_lab_patologi')
    @include('simrs.erm-ranap.dashboard.component_modal.modal_berkas')
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="{{ asset('style-erm/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('style-erm/plugins/daterangepicker/daterangepicker.js') }}"></script>
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var urlRoute = "{{ route('dashboard.erm-ranap.riwayat.details', ':kode_kunjungan') }}";
        $('button[data-target^="#modal-"]').on('click', function() {
            var kode_kunjungan = $(this).data('kode-kunjungan-riwayat');
            var finalUrl = urlRoute.replace(':kode_kunjungan', kode_kunjungan);
            $.ajax({
                url: finalUrl, // URL untuk mengambil data
                method: 'GET', // Metode GET untuk mengambil data
                beforeSend: function() {
                    // Menambahkan elemen loading ke dalam setiap tabel sebelum melakukan request
                    $('#tindakan-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                    $('#obat-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                    $('#asesmen-' + kode_kunjungan).html('<div class="loading">Loading...</div>');
                },
                success: function(data) {
                    console.log(data);

                    // Membuat HTML untuk tabel tindakan
                    var tindakanHtml =
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th><th>KODE KUNJUNGAN</th></tr></thead><tbody>';
                    $.each(data.tindakan, function(index, item) {
                        tindakanHtml += '<tr><td>' + item.NAMA_TARIF + '</td><td>' + item
                            .kode_kunjungan + '</td></tr>';
                    });
                    tindakanHtml += '</tbody></table>';

                    // Membuat HTML untuk tabel obat
                    var obatHtml =
                        '<table class="table table-bordered"><thead><tr><th>NAMA</th><th>KODE KUNJUNGAN</th></tr></thead><tbody>';
                    $.each(data.obat, function(index, item) {
                        obatHtml += '<tr><td>' + item.NAMA_TARIF + '</td><td>' + item
                            .kode_kunjungan + '</td></tr>';
                    });
                    obatHtml += '</tbody></table>';

                    // Membuat HTML untuk tabel asesmen
                    var asesmenHtml =
                        '<table class="table table-bordered"><thead><tr><th>LEMON</th><th>alergi</th><th>anamnesa</th><th>anjuran</th><th>asthma</th><th>beratbadan</th><th>diagnosakerja</th><th>frekuensi_nadi</th><th>frekuensi_nafas</th><th>keadaanumum</th><th>keluhan_pasien</th><th>keterangan_alergi</th><th>keterangan_kesadaran</th><th>riwayat_alergi</th><th>riwayat_kehamilan_pasien_wanita</th><th>riwyat_kelahiran_pasien_anak</th><th>riwyat_penyakit_sekarang</th><th>tekanan_darah</th><th>tindak_lanjut</th></tr></thead><tbody>';
                    $.each(data.asesmenRajal, function(index, item) {
                        asesmenHtml += '<tr><td>LEMON</td><td>' + item.alergi + '</td><td>' +
                            item.anamnesa + '</td><td>' + item.anjuran + '</td><td>' + item
                            .astdma + '</td><td>' + item.beratbadan + '</td><td>' + item
                            .diagnosakerja + '</td><td>' + item.frekuensi_nadi + '</td><td>' +
                            item.frekuensi_nafas + '</td><td>' + item.keadaanumum +
                            '</td><td>' + item.keluhan_pasien + '</td><td>' + item
                            .keterangan_alergi + '</td><td>' + item.keterangan_kesadaran +
                            '</td><td>' + item.riwayat_alergi + '</td><td>' + item
                            .riwayat_kehamilan_pasien_wanita + '</td><td>' + item
                            .riwyat_kelahiran_pasien_anak + '</td><td>' + item
                            .riwyat_penyakit_sekarang + '</td><td>' + item.tekanan_darah +
                            '</td><td>' + item.tindak_lanjut + '</td></tr>';
                    });
                    asesmenHtml += '</tbody></table>';

                    // Masukkan data ke dalam modal
                    $('#tindakan-' + kode_kunjungan).html(tindakanHtml);
                    $('#obat-' + kode_kunjungan).html(obatHtml);
                    $('#asesmen-' + kode_kunjungan).html(asesmenHtml);
                },
                error: function() {
                    // Jika terjadi kesalahan, tampilkan pesan error
                    $('#tindakan-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                    $('#obat-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                    $('#asesmen-' + kode_kunjungan).html(
                        '<div class="error">Terjadi kesalahan dalam mengambil data.</div>');
                }
            });

        });
    
    </script>
    {{-- rincian biaya --}}
    <script>
        function lihatRincianBiaya() {
            $('#modalRincianBiaya').modal('show');
        }

        function getRincianBiaya() {
            var url =
                "{{ route('dashboard.erm-ranap.rincian-biaya') }}?norm={{ $kunjungan->no_rm }}&counter={{ $kunjungan->counter }}";
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
    {{-- Hasil Lab --}}
    <script>
        $(document).ready(function() {
            // Ketika$(document).ready(function() {
            // Ketika tombol Radiologi diklik
            $('#btn-radiologi').on('click', function() {
                var no_rm = $(this).data('no_rm');
                const urlRadiologi = "{{ route('dashboard.erm-ranap.dokters.penunjang-radiologi') }}";

                $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

                $.ajax({
                    url: urlRadiologi,  // Ganti dengan rute yang sesuai di server Anda
                    method: 'GET',
                    data: { no_rm: no_rm },  // Mengirimkan no_rm sebagai parameter
                    success: function(data) {
                        // Kosongkan table sebelum memasukkan data baru
                        $('#radiologi-table-body').empty();

                        // Periksa apakah data radiologi ada
                        if (data.length > 0) {
                            $.each(data, function(index, radiologi) {
                                // Menambahkan baris ke tabel
                                var row = '<tr>' +
                                            '<td>' + radiologi.tgl_masuk + '</td>' +
                                            '<td>' + radiologi.kode_kunjungan + '</td>' +
                                            '<td>' + radiologi.nama_px + '</td>' +
                                            '<td>' + radiologi.nama_unit + '</td>' +
                                            '<td>' + radiologi.pemeriksaan + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-xs btn-primary" data-norm="' + radiologi.no_rm + '">Rontgen</button>' +
                                                '<button class="btn btn-xs btn-success" data-header="' + radiologi.header_id + '" data-detail="' + radiologi.detail_id + '">Expertise</button>' +
                                            '</td>' +
                                        '</tr>';
                                $('#radiologi-table-body').append(row);
                            });
                        } else {
                            // Jika tidak ada data, tampilkan pesan
                            $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>');
                        }
                    },
                    error: function() {
                        // Menangani error jika terjadi kesalahan
                        $('#radiologi-table-body').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan dalam memuat data.</td></tr>');
                    }
                });
            });

            // Event delegation untuk tombol dinamis dengan kelas .btn-primary (Rontgen)
            $('#radiologi-table-body').on('click', '.btn-primary', function() {
                // Log untuk memastikan tombol diklik
                console.log("Rontgen button clicked");

                // Pastikan data norm tersedia
                var norm = $(this).data('norm');
                console.log("Norm:", norm);
                
                // Panggil fungsi lihatHasilRongsen
                lihatHasilRongsen(this);
            });

            // Event delegation untuk tombol dinamis dengan kelas .btn-success (Expertise)
            $('#radiologi-table-body').on('click', '.btn-success', function() {
                console.log("Expertise button clicked");

                var header = $(this).data('header');
                var detail = $(this).data('detail');
                lihatExpertiseRad(this);
            });
        });


        function showHasilLab(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.74/smartlab_waled/his/his_report?hisno=" + kode;
            $('#dataHasilLab').attr('src', url);
            $('#urlHasilLab').attr('href', url);
            $('#modalHasilLab').modal('show');
        }

        function lihatHasilRongsen(button) {
            var norm = $(button).data('norm');
            var url = "http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id=" + norm +
                "&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function lihatExpertiseRad(button) {
            var header = $(button).data('header');
            var detail = $(button).data('detail');
            var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                "&tgl_cetak={{ now()->format('Y-m-d') }}";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }

        function lihatFile(button) {
            var url = $(button).data('fileurl');
            $('#dataUrlFile').attr('src', url);
            $('#midalFileLihat').modal('show');
        }
    </script>
@endpush
