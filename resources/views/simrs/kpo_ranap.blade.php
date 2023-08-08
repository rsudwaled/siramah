@extends('adminlte::page')

@section('title', 'KMKB Rawat Inap')

@section('content_header')
    <h1>KMKB Rawat Inap</h1>

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
                <x-adminlte-input name="nomor_sep" label="Nomor SEP" igroup-size="sm" placeholder="Cari nomor SEP" readonly>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="primary" id="btnCariSEP" label="Cari!" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-search"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

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
                            <a class="nav-link active" data-toggle="pill" href="#inacbgPasien">INACBG</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tarifPasien">TARIF</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="inacbgPasien">
                            {{-- pelyanan pasien --}}
                            <div class="row">
                                <div class="col-md-9">
                                    <h6>Pelayanan Pasien</h6>
                                    <div class="row">
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                        @endphp
                                        <x-adminlte-input-date name="tgl_masuk" label="Tgl Masuk" fgroup-class="col-md-4"
                                            igroup-size="sm" :config="$config" />
                                        <x-adminlte-input-date name="tgl_pulang" label="Tgl Pulang" fgroup-class="col-md-4"
                                            igroup-size="sm" :config="$config" />
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
                                            fgroup-class="col-md-4 naik_kelas" igroup-size="sm">
                                            <option value="3" selected>Kelas 3</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="1">Kelas 1</option>
                                            <option value="4">Diatas Kelas 1</option>
                                        </x-adminlte-select>
                                        <x-adminlte-input name="lama_pelayanan" label="Lama Pelayanan"
                                            fgroup-class="col-md-4 naik_kelas" igroup-size="sm"
                                            placeholder="Lama hari pelayanan" type="number" />
                                        <x-adminlte-input name="lama_icu" label="Lama ICU"
                                            fgroup-class="col-md-4 masuk_icu" igroup-size="sm"
                                            placeholder="Lama hari ICU" type="number" />
                                        <x-adminlte-input name="intubasi" label="Tgl Intubasi"
                                            fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                                        <x-adminlte-input name="ekstubasi" label="Tgl Ekstubasi"
                                            fgroup-class="col-md-4 masuk_icu pake_ventilator" igroup-size="sm" />
                                        <x-adminlte-select name="discharge_status" label="Cara Pulang"
                                            fgroup-class="col-md-4" igroup-size="sm">
                                            <option value="1">Atas persetujuan dokter</option>
                                            <option value="2">Dirujuk</option>
                                            <option value="3">Atas permintaan sendiri</option>
                                            <option value="4">Meninggal</option>
                                            <option value="5">Lain-lain</option>
                                        </x-adminlte-select>
                                        <x-adminlte-input name="dokter_dpjp" label="Dokter DPJP" fgroup-class="col-md-4"
                                            igroup-size="sm" placeholder="Dokter DPJP" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="naik_turun_kelas"
                                                value="1" onchange="naikKelasFunc();">
                                            <label for="naik_turun_kelas" class="custom-control-label">Naik/Turun
                                                Kelas</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="perawatan_icu"
                                                value="1" onchange="perawatanIcuFunc();">
                                            <label for="perawatan_icu" class="custom-control-label">Perawatan ICU</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="ventilator"
                                                value="1" onchange="pakeVentilatorFunc();">
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
                            {{-- tekanan darah --}}
                            <div class="row">
                                <br><br>
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
                            {{-- diagnosa --}}
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
                            {{-- tarif --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <br><br>
                                    <h6>Tekanan Darah</h6>
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="prosedur_non_bedah" label="Prosedur Non Bedah"
                                        igroup-size="sm" />
                                    <x-adminlte-input name="tenaga_ahli" label="Tenaga Ahli" igroup-size="sm" />
                                    <x-adminlte-input name="radiologi" label="Radiologi" igroup-size="sm" />
                                    <x-adminlte-input name="rehabilitasi" label="Rehabilitasi" igroup-size="sm" />
                                    <x-adminlte-input name="obat" label="Obat" igroup-size="sm" />
                                    <x-adminlte-input name="alkes" label="Alkes" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="prosedur_bedah" label="Prosedur Bedah" igroup-size="sm" />
                                    <x-adminlte-input name="keperawatan" label="Keperawatan" igroup-size="sm" />
                                    <x-adminlte-input name="laboratorium" label="Laboratorium" igroup-size="sm" />
                                    <x-adminlte-input name="kamar_akomodasi" label="Kamar / Akomodasi"
                                        igroup-size="sm" />
                                    <x-adminlte-input name="obat_kronis" label="Obat Kronis" igroup-size="sm" />
                                    <x-adminlte-input name="bmhp" label="BMHP" igroup-size="sm" />
                                </div>
                                <div class="col-md-4">
                                    <x-adminlte-input name="konsultasi" label="Konsultasi" igroup-size="sm" />
                                    <x-adminlte-input name="penunjang" label="Penunjang" igroup-size="sm" />
                                    <x-adminlte-input name="pelayanan_darah" label="Pelayanan Darah" igroup-size="sm" />
                                    <x-adminlte-input name="rawat_intensif" label="Rawat Intensif" igroup-size="sm" />
                                    <x-adminlte-input name="obat_kemo" label="Obat Kemoterapi" igroup-size="sm" />
                                    <x-adminlte-input name="sewa_alat" label="Sewa Alat" igroup-size="sm" />
                                </div>
                                <x-adminlte-input name="tarif_rs" label="Tarif Rumah Sakit" fgroup-class="col-md-6" />
                            </div>
                            {{-- tarif inacbg --}}
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-3">MDC</dt>
                                        <dd class="col-sm-9">: <span id="mdc_desc"></span></dd>
                                        <dt class="col-sm-3">DRG</dt>
                                        <dd class="col-sm-9">: <span id="drg_desc"></span></dd>
                                    </dl>
                                </div>
                            </div>
                            {{-- <x-adminlte-button theme="success" id="btnSetClaim" label="Set Claim" /> --}}
                            <x-adminlte-button theme="primary" id="btnGroupperClaim" label="Groupper Claim" />
                        </div>
                        <div class="tab-pane fade" id="tarifPasien">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $heads = ['TGL', 'NAMA_UNIT', 'GROUP_VCLAIM', 'KELOMPOK_TARIF', 'NAMA_TARIF', 'GRANTOTAL_LAYANAN'];
                                        $config['paging'] = false;
                                        $config['info'] = false;
                                    @endphp
                                    <x-adminlte-datatable id="tableRincian" class="nowrap text-xs" :heads="$heads"
                                        :config="$config" bordered hoverable compressed>
                                    </x-adminlte-datatable>
                                </div>
                            </div>
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
                    <th>Penjamin</th>
                    <th>No SEP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl" v-centered>
        <table id="tableSEP" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>tglSep</th>
                    <th>tglPlgSep</th>
                    <th>noSep</th>
                    <th>jnsPelayanan</th>
                    <th>poli</th>
                    <th>diagnosa</th>
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
            $(".masuk_icu").hide();
            $(".naik_kelas").hide();
            $(".pake_ventilator").hide();
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
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                table.row.add([
                                    value.tgl_masuk,
                                    value.no_rm + ' ' + value.pasien.nama_px,
                                    value.unit.nama_unit ?? '-',
                                    value.dokter.nama_paramedis ?? '-',
                                    value.penjamin_simrs.nama_penjamin ?? '-',
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
                                        $('#dokter_dpjp').val(data
                                            .dokter.nama_paramedis);
                                        $('#nomor_kartu').val(data
                                            .nomorkartu);
                                        $('#nomor_sep').val(data.noSEP);
                                        $('#nomor_rm').val(data.no_rm);
                                        $('#nama_pasien').val(data
                                            .namaPasien);
                                        $('#tgl_lahir').val(data.tglLahir);
                                        $('#gender').val(data.sex);
                                        $('#tgl_masuk').val(data.tgl_masuk);
                                        $('#tgl_pulang').val(data
                                            .tgl_keluar);
                                        var urlRincian =
                                            "{{ route('api.eclaim.rincian_biaya_pasien') }}?counter=" +
                                            data.counter + "&norm=" + data
                                            .no_rm;
                                        var table = $('#tableRincian')
                                            .DataTable();
                                        table.rows().remove().draw();
                                        $.ajax({
                                            url: urlRincian,
                                            type: "GET",
                                            success: function(
                                                data) {
                                                if (data
                                                    .metadata
                                                    .code == 200
                                                ) {
                                                    $.each(data
                                                        .response
                                                        .rincian,
                                                        function(
                                                            key,
                                                            value
                                                        ) {
                                                            console
                                                                .log(
                                                                    value
                                                                );
                                                            table
                                                                .row
                                                                .add(
                                                                    [
                                                                        value
                                                                        .TGL,
                                                                        value
                                                                        .NAMA_UNIT,
                                                                        value
                                                                        .nama_group_vclaim,
                                                                        value
                                                                        .KELOMPOK_TARIF,
                                                                        value
                                                                        .NAMA_TARIF,
                                                                        value
                                                                        .GRANTOTAL_LAYANAN,
                                                                    ]
                                                                )
                                                                .draw(
                                                                    false
                                                                );

                                                        });
                                                    $('#prosedur_non_bedah')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .prosedur_non_bedah
                                                        );
                                                    $('#tenaga_ahli')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .tenaga_ahli
                                                        );
                                                    $('#radiologi')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .radiologi
                                                        );
                                                    $('#rehabilitasi')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .rehabilitasi
                                                        );
                                                    $('#obat')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .obat
                                                        );
                                                    $('#alkes')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .alkes
                                                        );
                                                    $('#prosedur_bedah')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .prosedur_bedah
                                                        );
                                                    $('#keperawatan')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .keperawatan
                                                        );
                                                    $('#laboratorium')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .laboratorium
                                                        );
                                                    $('#kamar_akomodasi')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .kamar_akomodasi
                                                        );
                                                    $('#obat_kronis')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .obat_kronis
                                                        );
                                                    $('#bmhp')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .bmhp
                                                        );
                                                    $('#konsultasi')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .konsultasi
                                                        );
                                                    $('#penunjang')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .penunjang
                                                        );
                                                    $('#pelayanan_darah')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .pelayanan_darah
                                                        );
                                                    $('#rawat_intensif')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .rawat_intensif
                                                        );
                                                    $('#obat_kemo')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .obat_kemo
                                                        );
                                                    $('#sewa_alat')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .sewa_alat
                                                        );
                                                    $('#tarif_rs')
                                                        .val(
                                                            data
                                                            .response
                                                            .rangkuman
                                                            .tarif_rs
                                                        );
                                                    swal.fire(
                                                        'Success',
                                                        data
                                                        .metadata
                                                        .message,
                                                        'success'
                                                    );
                                                } else {
                                                    swal.fire(
                                                        'Error',
                                                        data
                                                        .metadata
                                                        .message,
                                                        'error'
                                                    );
                                                }
                                                $.LoadingOverlay(
                                                    "hide");
                                            },
                                            error: function(data) {
                                                swal.fire(
                                                    'Error ' +
                                                    data
                                                    .responseJSON
                                                    .metadata
                                                    .code,
                                                    data
                                                    .responseJSON
                                                    .metadata
                                                    .message,
                                                    'error'
                                                );
                                                $.LoadingOverlay(
                                                    "hide");
                                            }
                                        });
                                        $('#kunjunganPasien').modal('hide');
                                        $('#dataPasien').show();
                                        $('#riwayatPasien').show();
                                    },
                                    error: function(data) {
                                        $.LoadingOverlay("hide");
                                    }
                                });
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
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        swal.fire(
                            'Error ' + data.responseJSON.metadata.code,
                            data.responseJSON.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnGroupperClaim').click(function() {
                $.LoadingOverlay("show");
                // setklaim
                var nomor_sep = $('#nomor_sep').val();
                var nomor_kartu = $('#nomor_kartu').val();
                var tgl_masuk = $('#tgl_masuk').val();
                var tgl_pulang = $('#tgl_pulang').val();
                var cara_masuk = $('#cara_masuk').val();
                var jenis_rawat = $('#jenis_rawat').val();
                var kelas_rawat = $('#kelas_rawat').val();
                var discharge_status = $('#discharge_status').val();

                var prosedur_non_bedah = $('#prosedur_non_bedah').val();
                var tenaga_ahli = $('#tenaga_ahli').val();
                var radiologi = $('#radiologi').val();
                var rehabilitasi = $('#rehabilitasi').val();
                var obat = $('#obat').val();
                var alkes = $('#alkes').val();
                var prosedur_bedah = $('#prosedur_bedah').val();
                var keperawatan = $('#keperawatan').val();
                var laboratorium = $('#laboratorium').val();
                var kamar_akomodasi = $('#kamar_akomodasi').val();
                var obat_kronis = $('#obat_kronis').val();
                var bmhp = $('#bmhp').val();
                var konsultasi = $('#konsultasi').val();
                var penunjang = $('#penunjang').val();
                var pelayanan_darah = $('#pelayanan_darah').val();
                var rawat_intensif = $('#rawat_intensif').val();
                var obat_kemo = $('#obat_kemo').val();
                var sewa_alat = $('#sewa_alat').val();
                var tarif_rs = $('#tarif_rs').val();
                var dokter_dpjp = $('#dokter_dpjp').val();

                var diagnosa = $('select[name^=diagnosa]').find(":selected").map(function(idx, elem) {
                    return $(elem).val();
                }).get();
                var procedure = $('select[name^=procedure]').find(":selected").map(function(idx, elem) {
                    return $(elem).val();
                }).get();
                var dataKPO = {
                    nomor_sep: nomor_sep,
                    nomor_kartu: nomor_kartu,
                    tgl_masuk: tgl_masuk,
                    tgl_pulang: tgl_pulang,
                    cara_masuk: cara_masuk,
                    kelas_rawat: kelas_rawat,
                    discharge_status: discharge_status,
                    diagnosa: diagnosa,
                    procedure: procedure,
                    prosedur_non_bedah: prosedur_non_bedah,
                    tenaga_ahli: tenaga_ahli,
                    radiologi: radiologi,
                    rehabilitasi: rehabilitasi,
                    obat: obat,
                    alkes: alkes,
                    prosedur_bedah: prosedur_bedah,
                    keperawatan: keperawatan,
                    laboratorium: laboratorium,
                    kamar_akomodasi: kamar_akomodasi,
                    obat_kronis: obat_kronis,
                    bmhp: bmhp,
                    konsultasi: konsultasi,
                    penunjang: penunjang,
                    pelayanan_darah: pelayanan_darah,
                    rawat_intensif: rawat_intensif,
                    obat_kemo: obat_kemo,
                    sewa_alat: sewa_alat,
                    tarif_rs: tarif_rs,
                    dokter_dpjp: dokter_dpjp,
                }
                var urlGroupper = "{{ route('api.eclaim.set_claim_ranap') }}";
                $.ajax({
                    data: dataKPO,
                    url: urlGroupper,
                    type: "POST",
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            // grouper
                            var nomor_sep = $('#nomor_sep').val();
                            var dataInput = {
                                nomor_sep: nomor_sep,
                            }
                            var url = "{{ route('api.eclaim.grouper') }}";
                            $.ajax({
                                data: dataInput,
                                url: url,
                                type: "POST",
                                success: function(data) {
                                    if (data.metadata.code == 200) {
                                        const rupiah = (number) => {
                                            return new Intl.NumberFormat(
                                                "id-ID", {
                                                    style: "currency",
                                                    currency: "IDR"
                                                }).format(number);
                                        }
                                        $('#kode_inacbg').html(data.response.cbg
                                            .code);
                                        $('#description_inacbg').html(data.response
                                            .cbg.description);
                                        $('#base_tariff').html(rupiah(data.response
                                            .cbg
                                            .base_tariff));
                                        $('#tariff').html(rupiah(data.response.cbg
                                            .tariff));

                                        $('#kelas').html(data.response.kelas);
                                        var tarif_kelas = data.tarif_alt;
                                        var tarif_kelass = tarif_kelas.filter(x => x
                                            .kelas === data.response.kelas)
                                        $('#tarif_inacbg').html(rupiah(
                                            tarif_kelass[0].tarif_inacbg));
                                        $('#mdc_desc').html(data.response_inagrouper
                                            .mdc_description);
                                        $('#drg_desc').html(data.response_inagrouper
                                            .drg_description);
                                        swal.fire(
                                            'Success',
                                            data.metadata.message,
                                            'success'
                                        );
                                    } else {
                                        swal.fire(
                                            'Error',
                                            data.metadata.message,
                                            'error'
                                        );
                                        $.LoadingOverlay("hide");
                                    }
                                    $.LoadingOverlay("hide");
                                },
                                error: function(data) {
                                    swal.fire(
                                        'Error ' + data.responseJSON.metadata
                                        .code,
                                        data.responseJSON.metadata.message,
                                        'error'
                                    );
                                    $.LoadingOverlay("hide");
                                }
                            });
                        } else {
                            swal.fire(
                                'Error',
                                data.metadata.message,
                                'error'
                            );
                            $.LoadingOverlay("hide");
                        }
                    },
                    error: function(data) {
                        swal.fire(
                            'Error ' + data.responseJSON.metadata.code,
                            data.responseJSON.metadata.message,
                            'error'
                        );
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('#btnCariSEP').click(function(e) {
                var nomorkartu = $('#nomor_kartu').val();
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
                                $('#nomor_sep').val(nomorsep);
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
            // $("#obat").select2({
            //     placeholder: 'Silahkan pilih obat',
            //     theme: "bootstrap4",
            //     ajax: {
            //         url: "{{ route('api.simrs.get_obats') }}",
            //         type: "get",
            //         dataType: 'json',
            //         delay: 100,
            //         data: function(params) {
            //             return {
            //                 search: params.term // search term
            //             };
            //         },
            //         processResults: function(response) {
            //             return {
            //                 results: response
            //             };
            //         },
            //         cache: true
            //     }
            // });
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
    <script>
        function naikKelasFunc() {
            if ($('#naik_turun_kelas').is(":checked"))
                $(".naik_kelas").show();
            else
                $(".naik_kelas").hide();
        }

        function perawatanIcuFunc() {
            if ($('#perawatan_icu').is(":checked"))
                $(".masuk_icu").show();
            else
                $(".masuk_icu").hide();
        }

        function pakeVentilatorFunc() {
            if ($('#ventilator').is(":checked"))
                $(".pake_ventilator").show();
            else
                $(".pake_ventilator").hide();
        }
    </script>
@endsection
