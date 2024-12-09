<div class="modal fade" id="modalCreateSepRanap" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bridging SEP Rawat Inap</h4>
            </div>
            <form id="formCreateSepRanap">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user" id="user" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="jenispelayanan" id="jenispelayanan" value="1">
                    <div class="col-12 row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="No SPRI">No SPRI</label>
                                <input type="text" class="form-control no_spri" name="no_spri" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Kode Kunjungan">Kode Kunjungan</label>
                                <input type="text" class="form-control kunjungan" name="kode_kunjungan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="No Kartu">No Kartu</label>
                                <input type="text" class="form-control nomorBpjs" name="noKartu" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Tanggal">Tanggal</label>
                                <input type="date" class="form-control tglSep" name="tglSep"
                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="No RM">No RM</label>
                                <input type="text" class="form-control noMR" name="noMR" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Nama Pasien">Nama Pasien</label>
                                <input type="text" class="form-control namaPasien" name="nama_pasien" readonly>
                            </div>

                            <x-adminlte-select2 name="diagAwal" id="diagnosa" label="Pilih Diagnosa">
                            </x-adminlte-select2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" form="formCreateSepRanap" id="submitDiagnosa"
                        form="formCreateSepRanap">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
