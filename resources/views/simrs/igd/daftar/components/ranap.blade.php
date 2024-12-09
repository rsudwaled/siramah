<div class="card card-outline card-success">
    <div class="col-12 mt-3 row">
        <div class="table-responsive col-12">
            <table class="table table-bordered" id="kunjunganTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kunjungan</th>
                        <th>Status Daftar</th>
                        <th>Penjamin</th>
                        <th style="width: 30%">Catatan</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="row">
            <div class="col-12 row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="Status Ranap">Status Ranap <i>(Pasien Sudah atau Belum Memiliki
                                Ruangan??)</i></label>
                        <select name="status_persiapan" id="status_persiapan" class="form-control">
                            <option value="0">Bukan Persiapan (Sudah Memiliki Ruangan)</option>
                            <option value="1">Persiapan (Belum Memiliki Ruangan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="Referensi Kunjungan">Referensi Kunjungan</label>
                        <input type="text" name="referensi_kunjungan" id="referensi_kunjungan" class="form-control"
                            readonly>
                    </div>
                </div>
                <div class="col-3">
                    <x-adminlte-input name="inject_sep" id="inject_sep" label="NO SEP (opsional)" type="text" />
                </div>
                <div class="col-3">
                    <x-adminlte-input name="inject_spri" id="inject_spri" label="NO SPRI/ Rencana Rawat Inap (opsional)"
                        type="text" />
                </div>
                <div class="col-6">
                    <label for="Jenis Pasien">Jenis Pasien</label>
                    <div class="col-12 row">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="isBpjsRanap" value="0"
                                    checked="">
                                <label class="form-check-label">PASIEN UMUM</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="isBpjsRanap" value="1">
                                <label class="form-check-label">PASIEN BPJS</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="isBpjsRanap" value="2">
                                <label class="form-check-label">BPJS PROSES</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group" id="penjamin_pribadi_ranap">
                        <label for="PENJAMIN PRIBADI">PENJAMIN PRIBADI</label>
                        <input type="text" value="P01" placeholder="PRIBADI" name="penjamin_pribadi_ranap"
                            class="form-control" readonly>
                    </div>
                    <div class="form-group" id="show_penjamin_bpjs_ranap" style="display: none;">
                        <x-adminlte-select2 name="penjamin_bpjs_ranap" label="Pilih Penjamin BPJS">
                            @foreach ($penjamin as $item)
                                <option value="{{ $item->kode_penjamin }}">
                                    {{ $item->nama_penjamin }}</option>
                            @endforeach
                            {{-- @foreach ($penjaminbpjs as $item)
                                <option value="{{ $item->kode_penjamin_simrs }}">
                                    {{ $item->nama_penjamin_bpjs }}</option>
                            @endforeach --}}
                        </x-adminlte-select2>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row" id="rowDiv1">
                    <div class="col-md-4">
                        <x-adminlte-select name="unitTerpilih" id="unitTerpilih" label="Ruangan">
                            @foreach ($unitRanap as $item)
                                <option value="{{ $item->kode_unit }}">
                                    {{ $item->nama_unit }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-select name="kelas_rawat" id="r_kelas_id" label="Kelas Rawat">
                                    <option value="1">KELAS 1</option>
                                    <option value="2">KELAS 2</option>
                                    <option value="3" selected>KELAS 3</option>
                                    <option value="4">VIP</option>
                                    <option value="5">VVIP</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-button label="Cari Ruangan" data-toggle="modal" data-target="#pilihRuangan"
                                    id="cariRuangan" class="bg-purple mt-4" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="rowDiv2">
                    <input type="hidden" id="id_ruangan" name="id_ruangan">
                    <div class="col-md-4">
                        <x-adminlte-input name="ruangan" label="Ruangan" id="ruanganTerpilih" readonly />
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-input name="bed" label="No Bed" id="bedTerpilih" readonly />
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-input name="hak_kelas" label="Hak Kelas" id="hakKelas" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-adminlte-modal id="pilihRuangan" title="List Ruangan Tersedia" theme="success" icon="fas fa-bed" size='xl'
    disable-animations>
    <div class="row listruangan" id="idRuangan"></div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="batal pilih" onclick="batalPilih()" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
