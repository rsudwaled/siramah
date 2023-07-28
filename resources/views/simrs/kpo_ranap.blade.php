@extends('adminlte::page')

@section('title', 'E-KPO Rawat Inap')

@section('content_header')
    <h1>E-KPO Rawat Inap</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- pencarian pasien --}}
            <x-adminlte-card title="Pencarian Pasien" theme="warning" collapsible="">
                <form>
                    <div class="row">
                        <div class="col-md-5">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" id="tanggal" label="Tanggal Kunjungan" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-7">
                            <x-adminlte-select name="unit" label="Ruangan">
                                @foreach ($units as $kode => $nama)
                                    <option value="{{ $kode }}" {{ $request->unit == $kode ? 'selected' : null }}>
                                        {{ $nama }}</option>
                                @endforeach
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" id="btnCariPasien" label="Cari!" />
                                </x-slot>
                            </x-adminlte-select>
                        </div>
                    </div>
                </form>

            </x-adminlte-card>
        </div>
        <div class="col-md-3" id="dataPasien">
            {{-- pencarian pasien --}}
            <x-adminlte-card title="Data Pasien" theme="warning" collapsible>
                <x-adminlte-input igroup-size="sm" name="nomor_kartu" label="Nomor Kartu" value="" readonly />
                <x-adminlte-input igroup-size="sm" name="nomor_sep" label="Nomor SEP" value="" readonly />
                <x-adminlte-input igroup-size="sm" name="nomor_rm" label="Nomor RM" value="" readonly />
                <x-adminlte-input igroup-size="sm" name="nama_pasien" label="Nama Pasien" value="" readonly />
                <x-adminlte-input igroup-size="sm" name="tgl_lahir" label="Tgl Lahir" value="" readonly />
                <x-adminlte-input igroup-size="sm" name="gender" label="Gender" value="" readonly />
                <x-adminlte-button theme="success" id="btnNewClaim" label="Create Claim" />
            </x-adminlte-card>
        </div>
        <div class="col-md-9" id="riwayatPasien">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs">
                        <li class="pt-2 px-3">
                            <h3 class="card-title"><b>Riwayat Pasien</b></h3>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#inacbg">INACBG</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tarif">TARIF</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- icd 10 --}}
                        <div class="tab-pane fade show active" id="inacbg">
                            <div class="row">
                                <div class="col-md-9">
                                    <h6>Pelayanan Pasien</h6>
                                    <div class="row">
                                        <x-adminlte-input name="tgl_masuk" label="Tgl Masuk" fgroup-class="col-md-4"
                                            igroup-size="sm" />
                                        <x-adminlte-input name="tgl_pulang" label="Tgl Pulang" fgroup-class="col-md-4"
                                            igroup-size="sm" />
                                        <x-adminlte-select name="cara_masuk" label="Cara Masuk" fgroup-class="col-md-4"
                                            igroup-size="sm">
                                            <option value="gp">Rujukan FKTP</option>
                                            <option value="hosp-trans">Rujukan FKRTL</option>
                                            <option value="mp">Rujukan Spesialis</option>
                                            <option value="outp">Dari Rawat Jalan</option>
                                            <option value="inp">Dari Rawat Inap</option>
                                            <option value="emd">Dari Rawat Darurat</option>
                                            <option value="born">Lahir di RS</option>
                                            <option value="nursing">Rujukan Panti Jompo</option>
                                            <option value="psych">Rujukan dari RS Jiwa</option>
                                            <option value="rehab"> Rujukan Fasilitas Rehab</option>
                                            <option value="other">Lain-lain</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select name="kelas_rawat" label="Kelas Rawat" fgroup-class="col-md-4"
                                            igroup-size="sm">
                                            <option value="3" selected>Kelas 3</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="1">Kelas 1</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select name="kelas_pelayanan" label="Kelas Pelayanan"
                                            fgroup-class="col-md-4" igroup-size="sm">
                                            <option value="3" selected>Kelas 3</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="1">Kelas 1</option>
                                            <option value="4">Diatas Kelas 1</option>
                                        </x-adminlte-select>
                                        <x-adminlte-input name="lama_pelayanan" label="Lama Pelayanan"
                                            fgroup-class="col-md-4" igroup-size="sm" placeholder="Lama hari pelayanan"
                                            type="number" />
                                        <x-adminlte-input name="lama_icu" label="Lama ICU" fgroup-class="col-md-4"
                                            igroup-size="sm" placeholder="Lama hari ICU" type="number" />
                                        <x-adminlte-input name="intubasi" label="Tgl Intubasi" fgroup-class="col-md-4"
                                            igroup-size="sm" />
                                        <x-adminlte-input name="ekstubasi" label="Tgl Ekstubasi" fgroup-class="col-md-4"
                                            igroup-size="sm" />

                                        <x-adminlte-select name="discharge_status" label="Cara Pulang"
                                            fgroup-class="col-md-4" igroup-size="sm">
                                            <option value="1">Atas persetujuan dokter</option>
                                            <option value="2">Dirujuk</option>
                                            <option value="3">Atas permintaan sendiri</option>
                                            <option value="4">Meninggal</option>
                                            <option value="5">Lain-lain</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select name="dokter_dpjp" label="Dokter DPJP" fgroup-class="col-md-4"
                                            igroup-size="sm">
                                            <option value="1">Atas persetujuan dokter</option>
                                            <option value="2">Dirujuk</option>
                                            <option value="3">Atas permintaan sendiri</option>
                                            <option value="4">Meninggal</option>
                                            <option value="5">Lain-lain</option>
                                        </x-adminlte-select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="naik_turun_kelas"
                                                value="naik_turun_kelas">
                                            <label for="naik_turun_kelas" class="custom-control-label">Naik/Turun
                                                Kelas</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="perawatan_icu"
                                                value="perawatan_icu">
                                            <label for="perawatan_icu" class="custom-control-label">Perawatan ICU</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="ventilator"
                                                value="ventilator">
                                            <label for="ventilator" class="custom-control-label">Ventilator ICU</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="bayi"
                                                value="bayi">
                                            <label for="bayi" class="custom-control-label">Bayi</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="tb"
                                                value="tb">
                                            <label for="tb" class="custom-control-label">Pasien TB</label>
                                        </div>
                                        <x-adminlte-input name="no_reg_tb" label="No Register TB"
                                            placeholder="No Register TB" igroup-size="sm" />
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="covid"
                                                value="covid">
                                            <label for="covid" class="custom-control-label">Pasien COVID-19</label>
                                        </div>
                                        <x-adminlte-input name="no_claim_covid" label="No Claim COVID-19"
                                            placeholder="No Claim COVID-19" igroup-size="sm" />
                                    </div>
                                </div>

                            </div>

                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Tekanan Darah</h6>
                                    <div class="row">
                                        <x-adminlte-input name="sistole" label="Sistole" fgroup-class="col-md-4"
                                            igroup-size="sm" placeholder="Sistole" type="number" />
                                        <x-adminlte-input name="distole" label="Diastole" fgroup-class="col-md-4"
                                            igroup-size="sm" placeholder="Diastole" type="number" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- multipe diagnosa --}}
                                    <br><br>
                                    <h6>Diagnosa & Tindakan</h6>
                                    <label class=" mb-2">Diagnosa ICD-10</label>
                                    <button id="rowAdder" type="button" class="btn btn-xs btn-success  mb-2">
                                        <span class="fas fa-plus">
                                        </span> Tambah Diagnosa
                                    </button>
                                    <div id="row">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="diagnosa[]" class="form-control diagnosaID ">
                                                </select>
                                                <div class="input-group-append"><button type="button"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-diagnoses "></i> Diagnosa Utama </button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="newinput"></div>
                                    {{-- multipe tindakan --}}
                                    <label class="mb-2">Tindakan ICD-9</label>
                                    <button id="rowAddTindakan" type="button" class="btn btn-xs btn-success  mb-2">
                                        <span class="fas fa-plus">
                                        </span> Tambah Tindakan
                                    </button>
                                    <div id="rowTindakan" class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-hand-holding-medical "></i>
                                                        </span>
                                                    </div>
                                                    <select name="procedure[]" class="form-control procedure ">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <b>@</b>
                                                        </span>
                                                    </div>
                                                    <input type="number" class="form-control" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-warning">
                                                <i class="fas fa-hand-holding-medical "></i> </button>
                                        </div>
                                    </div>
                                    <div id="newTindakan"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br><br>
                                    <h6>Tekanan Darah</h6>
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="tgl_masuk" label="Prosedur Non Bedah" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Tenaga Ahli" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Radiologi" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Rehabilitasi" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Obat" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Alkes" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="tgl_masuk" label="Prosedur Bedah" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Keperawatan" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Laboratorium" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Kamar / Akomodasi" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Obat Kronis" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="BMHP" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="tgl_masuk" label="Konsultasi" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Penunjang" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Pelayanan Darah" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Rawat Intensif" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Obat Kemoterapi" igroup-size="sm" />
                                    <x-adminlte-input name="tgl_masuk" label="Sewa Alat" igroup-size="sm" />
                                </div>
                                <x-adminlte-input name="tgl_masuk" label="Tarif Rumah Sakit" fgroup-class="col-md-6" />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tarif">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input readonly name="tgl_masuk" label="Prosedur Non Bedah" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Tenaga Ahli" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Radiologi" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Rehabilitasi" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Obat" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Alkes" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input readonly name="tgl_masuk" label="Prosedur Bedah" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Keperawatan" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Laboratorium" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Kamar / Akomodasi" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Obat Kronis" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="BMHP" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input readonly name="tgl_masuk" label="Konsultasi" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Penunjang" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Pelayanan Darah" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Rawat Intensif" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Obat Kemoterapi" igroup-size="sm" />
                                    <x-adminlte-input readonly name="tgl_masuk" label="Sewa Alat" igroup-size="sm" />
                                </div>
                                <x-adminlte-input name="tgl_masuk" label="Tarif Rumah Sakit" fgroup-class="col-md-6" />
                            </div>
                            <dl class="row">
                                <dt class="col-sm-3">Kode</dt>
                                <dd class="col-sm-9">: <span id="kode_inacbg"></span></dd>
                                <dt class="col-sm-3">Keterangan</dt>
                                <dd class="col-sm-9">: <span id="description_inacbg"></span></dd>
                                <dt class="col-sm-3">Base Tarif</dt>
                                <dd class="col-sm-9">: <span id="base_tariff"></span></dd>
                                <dt class="col-sm-3">Tarif</dt>
                                <dd class="col-sm-9">: <span id="tariff"></span></dd>
                                <dt class="col-sm-3">Kelas</dt>
                                <dd class="col-sm-9">: <span id="kelas"></span></dd>
                                <dt class="col-sm-3">Tarif Kelas Inacbg</dt>
                                <dd class="col-sm-9">: <span id="tarif_inacbg"></span></dd>
                            </dl>
                            {{-- <x-adminlte-button theme="success" id="btnSetClaim" label="Set Claim" /> --}}
                            <x-adminlte-button theme="primary" id="btnGroupperClaim" label="Groupper Claim" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="kunjunganPasien" size="xl" title="Daftar Kunjungnan Pasien" theme="success"
        icon="fas fa-user-md">
        <dl class="row">
            <dt class="col-sm-2">Tgl Kunjungan</dt>
            <dd class="col-sm-10">: <span id="tglKunjungan"></span> </dd>
            <dt class="col-sm-2">Unit</dt>
            <dd class="col-sm-10">: <span id="unitKunjungan"></span> </dd>
        </dl>

        <table id="tableKunjunganPasien" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>Tgl Masuk</th>
                    <th>Pasien</th>
                    <th>Unit</th>
                    <th>Dokter</th>
                    <th>No SEP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminlte-modal>
@stop
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(function() {
            var table = new DataTable('#tableKunjunganPasien', {
                info: false,
                ordering: false,
                paging: false
            });
            $('#dataPasien').hide();
            $('#riwayatPasien').hide();
            $('#btnCariPasien').click(function(e) {
                $.LoadingOverlay("show");
                var unit = $('#unit option:selected').text();
                var tanggal = $('#tanggal').val();
                $('#unitKunjungan').html(unit);
                $('#tglKunjungan').html(tanggal);
                table.rows().remove().draw();
                e.preventDefault();
                var url = "{{ route('kunjunganRanap') }}?unit=" + $('#unit').val();
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                table.row.add([
                                    value.tgl_masuk,
                                    value.no_rm + ' ' + value.pasien.nama_px,
                                    value.unit.nama_unit ?? '-',
                                    value.dokter.nama_paramedis ?? '-',
                                    value.no_sep,
                                    "<button class='btnPilihKunjungan btn btn-success btn-xs' data-id=" +
                                    value.kode_kunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihKunjungan').click(function() {
                                var kodekunjungan = $(this).data('id');
                                var url = "{{ route('kunjungan.index') }}/" +
                                    kodekunjungan + "/edit";
                                $.LoadingOverlay("show");
                                $.ajax({
                                    url: url,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        console.log(data);
                                        $('#nomor_kartu').val(data
                                            .nomorkartu);
                                        $('#nomor_sep').val(data.noSEP);
                                        $('#nomor_rm').val(data.no_rm);
                                        $('#nama_pasien').val(data
                                            .namaPasien);
                                        $('#tgl_lahir').val(data.tglLahir);
                                        $('#gender').val(data.sex);
                                        $.LoadingOverlay("hide");
                                        $('#kunjunganPasien').modal('hide');
                                        $('#dataPasien').show();
                                    },
                                    error: function(data) {
                                        console.log(data);
                                        $.LoadingOverlay("hide");

                                    }
                                });
                                // $.LoadingOverlay("show");
                                // $('#nomorsep_suratkontrol').val(nomorsep);
                                // $('#modalSEP').modal('hide');
                                // $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $('#kunjunganPasien').modal('show');
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        $.LoadingOverlay("hide");
                    }
                });

            });
            $('#btnNewClaim').click(function() {
                $.LoadingOverlay("show");
                var nomor_sep = $('#nomor_sep').val();
                var nomor_rm = $('#nomor_rm').val();
                var nama_pasien = $('#nama_pasien').val();
                var nomor_kartu = $('#nomor_kartu').val();
                var tgl_lahir = $('#tgl_lahir').val();
                var gender = $('#gender').val();
                var dataInput = {
                    nomor_sep: nomor_sep,
                    nomor_rm: nomor_rm,
                    nama_pasien: nama_pasien,
                    nomor_kartu: nomor_kartu,
                    tgl_lahir: tgl_lahir,
                    gender: gender,
                }
                var url = "{{ route('api.eclaim.new_claim') }}";
                $.ajax({
                    data: dataInput,
                    url: url,
                    type: "POST",
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            swal.fire(
                                'Success',
                                data.metadata.message,
                                'success'
                            );
                        } else {
                            console.log(data);
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                        $('#riwayatPasien').show();
                    },
                    error: function(data) {
                        console.log(data);
                        swal.fire(
                            'Error ' + data.responseJSON.metadata.code,
                            data.responseJSON.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnSetClaim').click(function() {
                $.LoadingOverlay("show");
                var nomor_sep = $('#nomor_sep').val();
                var nomor_kartu = $('#nomor_kartu').val();
                var tgl_masuk = $('#tgl_masuk').val();
                var cara_masuk = $('#cara_masuk').val();
                var jenis_rawat = $('#jenis_rawat').val();
                var kelas_rawat = $('#kelas_rawat').val();
                var discharge_status = $('#discharge_status').val();
                var diagnosa = $('#diagnosa').val();
                var procedure = $('#procedure').val();
                var dataInput = {
                    nomor_sep: nomor_sep,
                    nomor_kartu: nomor_kartu,
                    tgl_masuk: tgl_masuk,
                    cara_masuk: cara_masuk,
                    jenis_rawat: jenis_rawat,
                    kelas_rawat: kelas_rawat,
                    discharge_status: discharge_status,
                    diagnosa: diagnosa,
                    procedure: procedure,
                }
                var url = "{{ route('api.eclaim.set_claim_ranap') }}";
                $.ajax({
                    data: dataInput,
                    url: url,
                    type: "POST",
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            swal.fire(
                                'Success',
                                data.metadata.message,
                                'success'
                            );
                        } else {
                            console.log(data);
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );

                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        swal.fire(
                            'Error ' + data.responseJSON.metadata.code,
                            data.responseJSON.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>
    {{-- search select2 --}}
    <script>
        $(function() {
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
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
                    url: "{{ route('api.eclaim.search_procedures') }}",
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
            $("#obat").select2({
                placeholder: 'Silahkan pilih obat',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.simrs.get_obats') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            search: params.term // search term
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
    </script>
    {{-- dynamic input --}}
    <script>
        // row select diagnosa
        $("#rowAdder").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group">' +
                '<select name="diagnosa[]" class="form-control diagnosaID"></select>' +
                '<div class="input-group-append"><button type="button" class="btn btn-danger" id="DeleteRow">' +
                '<i class="fas fa-trash "></i> Hapus </button></div>' +
                '</div></div></div>';
            $('#newinput').append(newRowAdd);
            $(".diagnosaID").select2({
                placeholder: 'Silahkan pilih Diagnosa ICD-10',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_diagnosis') }}",
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
                '<i class="fas fa-hand-holding-medical "></i></span></div>' +
                '<select name="procedure[]" class="form-control procedure "></select></div></div></div>' +
                '<div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-prepend">' +
                '<span class="input-group-text"><b>@</b></span></div><input type="number" class="form-control" value="1">' +
                '</div></div></div><div class="col-md-2"><button type="button" class="btn btn-danger" id="deleteRowTindakan"> ' +
                '<i class="fas fa-trash "></i> </button></div></div>';
            $('#newTindakan').append(newRowAdd);
            $(".procedure").select2({
                placeholder: 'Silahkan pilih Tindakan ICD-9',
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('api.eclaim.search_procedures') }}",
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
        })
    </script>
@endsection
