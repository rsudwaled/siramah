<form action="#" name="formRencanaPulang" id="formRencanaPulang" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" name="no_rm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="nama" value="{{ $kunjungan->pasien->nama_px }}">
        <input type="hidden" name="rm_counter" value="{{ $kunjungan->no_rm }}|{{ $kunjungan->counter }}">
        <input type="hidden" name="kode_unit" value="{{ $kunjungan->unit->kode_unit }}">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <x-adminlte-input-date name="tgl_pengisian_mppb" id="tgl_pengisian_mppb" label="Tgl Pengisian"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        :config="$config" required value="{{ $kunjungan->asesmen_ranap->tgl_asesmen_awal ?? now() }}" />
                    <x-adminlte-input name="nama_unit" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" label="Nama Ruangan" placeholder="Nama Ruangan"
                        value="{{ $kunjungan->unit->nama_unit }}" readonly required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="no_rm" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" label="No RM" placeholder="No RM Pasien"
                        value="{{ $kunjungan->pasien->no_rm ?? null }}" readonly />
                    <x-adminlte-input name="nama_pasien" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" label="Nama Pasien" placeholder="Nama Keluarga"
                        value="{{ $kunjungan->pasien->nama_px ?? null }}" readonly />
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kriteria Pasien</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Diagnosa Keperawatan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Diagnosa Keperawatan</label>
                        <textarea name="diagnosa_keperawatan" class="form-control" id="diagnosa_keperawatan" cols="30"
                            rows="10" placeholder="masukan diagnosa keperawatan ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Rencana Asuhan Keperawatan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Rencana Asuhan</label>
                        <textarea name="rencana_asuhan_keperawatan" class="form-control" id="rencana_asuhan_keperawatan" cols="30"
                            rows="10" placeholder="masukan rencana asuhan ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row float-right">
        <button type="submit" class="btn btn-md btn-success" form="formRencanaPulang">
            <i class="fas fa-save"></i> Simpan Data</button>
    </div>
</form>
