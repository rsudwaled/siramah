<x-adminlte-modal id="formDiagnosa" title="Diagnosa Pasien" theme="primary" size='lg' disable-animations>
    <div class="col-lg-12">
        <div class="alert alert-warning alert-dismissible">
            <h5>
                <i class="icon fas fa-users"></i>Diagnosa dan Bridging SEP :
            </h5>
        </div>
        <form id="formUpdateDiagnosa" method="post" action="">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">KODE KUNJUNGAN</label>
                                <input type="text" name="kode_kunjungan" id="kunjungan" readonly
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputBorderWidth2">RM PASIEN</label>
                                <input type="text" name="noMR" id="noMR" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">NO KARTU</label>
                        <input type="text" name="no_Bpjs" id="no_Bpjs" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">NIK</label>
                        <input type="text" name="nik_bpjs" id="nik_bpjs" readonly class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">Nama PASIEN</label>
                        <input type="text" name="nama_pasien" id="nama_pasien" readonly class="form-control">
                    </div>

                    <div class="form-group" style="display: none">
                        <label for="exampleInputBorderWidth2">JENIS PASIEN DAFTAR</label>
                        <input type="text" name="jp_daftar" id="jp_daftar" readonly class="form-control">
                    </div>
                    <div class="form-group">
                        <label>DPJP</label>
                        <select name="dpjp" id="dpjp" class="select2 form-control">
                            @foreach ($paramedis as $dpjp)
                                <option value="{{ $dpjp->kode_dokter_jkn }}">{{ $dpjp->nama_paramedis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">PILIH DIAGNOSA ICD 10</label>
                        <select name="diagAwal" id="diagnosa" class="select2 form-control"></select>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="button" class="btn btn-sm bg-primary btn-synchronize-sep"
                    form="formUpdateDiagnosa" label="Update Diagnosa" />
                <x-adminlte-button theme="danger" label="batal update" class="btn btn-sm" data-dismiss="modal" />
            </x-slot>
        </form>
    </div>
</x-adminlte-modal>
