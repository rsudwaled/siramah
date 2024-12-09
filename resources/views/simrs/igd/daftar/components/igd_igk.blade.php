<div class="card card-outline card-primary">
    <div class="col-lg-12 mt-3">
        <div class="table-responsive col-12">
            <table class="table table-bordered" id="viewTableIGD">
                <thead>
                    <tr>
                        <th>Daftar Tanggal</th>
                        <th>Kunjungan</th>
                        <th>Status Daftar</th>
                        <th>Penjamin</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12 row mt-2">
        <div class="col-4">
            <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                <option value="">--Pilih Dokter--</option>
                @foreach ($paramedis as $item)
                    <option value="{{ $item->kode_paramedis }}">
                        {{ strtoupper($item->nama_paramedis) }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                <input type="text" name="nama_perujuk" class="form-control" id="nama_perujuk">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="Jenis Pasien">Jenis Pasien</label>
                <div class="col-lg-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isBpjs" value="0" checked="">
                        <label class="form-check-label">PASIEN UMUM</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isBpjs" value="1">
                        <label class="form-check-label">PASIEN BPJS</label>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isBpjs" value="2">
                        <label class="form-check-label">BPJS PROSES</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group" id="penjamin_pribadi">
                <label for="PENJAMIN PRIBADI">PENJAMIN PRIBADI</label>
                <input type="text" value="P01" placeholder="PRIBADI" class="form-control" readonly>
            </div>
            <div class="form-group" id="show_penjamin_bpjs" style="display: none;">
                <x-adminlte-select2 name="penjamin_id_bpjs" label="Pilih Penjamin BPJS">
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
</div>
