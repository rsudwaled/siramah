<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4"  id="formInputPerkembangan">
                <form id="formPerkembangan" name="formPerkembangan" method="POST">
                    @csrf
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <input type="hidden" class="kode_kunjungan-perkembangan" name="kode_kunjungan"
                        value="{{ $kunjungan->kode_kunjungan }}">
                    <input type="hidden" class="counter-keperawatan" name="counter"
                        value="{{ $kunjungan->counter }}">
                    <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
                    <div class="form-group">
                        <label for="tanggal_input-perkembangan">Tanggal & Waktu</label>
                        <input type="datetime-local" id="tanggal_input-perkembangan" name="tanggal_input" class="form-control">
                        <div class="invalid-feedback "></div>
                    </div>
                    <x-adminlte-textarea igroup-size="sm" class="perkembangan-perkembangan" name="perkembangan"
                        label="SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya "
                        placeholder="SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya " rows=7>
                    </x-adminlte-textarea>
                    <x-adminlte-textarea igroup-size="sm" class="instruksi_medis-perkembangan"
                        name="instruksi_medis" label="Instruksi Medis"
                        placeholder="Instruksi Medis termasuk Procedur / Pasca Bedah" rows=5>
                    </x-adminlte-textarea>
                    <button class="btn btn-sm btn-success" type="button" onclick="btnSavePerkembangan()">Simpan Data</button>
                </form>
            </div>
            <div class="col-lg-8">
                <div class="row mb-1">
                    <div class="col-lg-12 text-right">
                        <x-adminlte-button icon="fas fa-sync" id="btn-get-observasiranap" theme="primary" class="btn-sm"
                            onclick="getPerkembanganPasien()" />
                        <a href="{{ route('print_perkembangan_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}"
                            target="_blank" id="btn-print-perkembangan" class="btn btn-sm btn-warning"><i
                                class="fas fa-print"></i> Print</a>
                    </div>
                </div>
                <table class="table table-sm table-bordered table-hover" id="tablePerkembanganPasien">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Tanggal Jam</th>
                            <th>SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya</th>
                            <th>Instruksi Medis</th>
                            <th>Ttd Pengisi,</th>
                            <th>Verifikasi DPJP</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
