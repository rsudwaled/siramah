<div class="card card-outline card-warning">
    <div class="col-12 mt-3 row">
        <div class="col-4">
            <div class="form-group">
                <label for="exampleInputBorderWidth2">Unit Penunjang</label>
                <select name="unit_penunjang" id="unit_penunjang" class="form-control">
                    @foreach ($unitPenunjang as $unit)
                        <option value="{{ $unit->kode_unit }}">{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="exampleInputBorderWidth2">Nama Perujuk</label>
                <input type="text" name="nama_perujuk" class="form-control" id="nama_perujuk">
            </div>
        </div>
    </div>
</div>
