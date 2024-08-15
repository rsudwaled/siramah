<!-- resources/views/partials/rencana_asuhan.blade.php -->
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('simpan_rencana_asuhan_terpadu') }}" name="formAsuhanTerpadu" id="formAsuhanTerpadu"
                    method="POST">
                    @csrf
                    <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                    <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
                    <input type="hidden" name="no_rm" value="{{ $kunjungan->no_rm }}">
                    <input type="hidden" name="nama" value="{{ $kunjungan->pasien->nama_px }}">
                    <input type="hidden" name="rm_counter" value="{{ $kunjungan->no_rm }}|{{ $kunjungan->counter }}">
                    <input type="hidden" name="kode_unit" value="{{ $kunjungan->unit->kode_unit }}">
                    <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="kode" value="{{ uniqid() }}">
                    <input type="hidden" name="id_asuhan">

                    <div class="form-group">
                        <label>Tanggal & Waktu</label>
                        <input type="datetime-local" id="tglwaktuRencanaAsuhan" step="60" name="tgl_waktu"  class="form-control tglwaktuRencanaAsuhan">
                        <div class="invalid-feedback "></div>
                    </div>
                    <div class="form-group">
                        <label>Profesi</label>
                        <select name="profesi" class="form-control profesi" id="profesi">
                            <option
                                {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Perawat' ? 'selected' : null) : null }}>
                                Perawat</option>
                            <option
                                {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Dokter' ? 'selected' : null) : null }}>
                                Dokter</option>
                        </select>
                        <div class="invalid-feedback "></div>
                    </div>
                    <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" id="pic" name="pic"value="{{ Auth::user()->name }}" required
                            class="form-control pic">
                        <div class="invalid-feedback "></div>
                    </div>
                    <x-adminlte-textarea name="rencana_asuhan" class="rencana_asuhan" id="rencana_asuhan" label="Rencana Asuhan" rows="4"
                        igroup-size="sm" placeholder="Rencana Asuhan" required></x-adminlte-textarea>
                    <x-adminlte-textarea name="capaian_diharapkan" class="capaian_diharapkan" label="Capaian yang diharapkan" rows="4"
                        igroup-size="sm" placeholder="Capaian yang diharapkan" required></x-adminlte-textarea>
                    <button class="btn btn-sm btn-success" type="submit" form="formAsuhanTerpadu">Simpan Data</button>
                </form>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Profesi</th>
                            <th>Rencana Asuhan</th>
                            <th>Capaian yang diharapkan</th>
                            <th>Ttd & Nama Jelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kunjungan->asuhan_terpadu)
                            @foreach ($kunjungan->asuhan_terpadu as $item)
                                <tr>
                                    <td>{{ $item->tgl_waktu }}</td>
                                    <td>{{ $item->profesi }}</td>
                                    <td>
                                        {{ $item->rencana_asuhan }}
                                    </td>
                                    <td>
                                        {{ $item->capaian_diharapkan }}
                                    </td>
                                    <td>{{ $item->pic }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-xs" onclick="editRencanaAsuh(this)"
                                            data-id="{{ $item->id }}">Edit</button>

                                        <button class="btn btn-danger btn-xs">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
