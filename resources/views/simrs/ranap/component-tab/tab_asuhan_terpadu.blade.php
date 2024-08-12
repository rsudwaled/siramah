<div class="tab-pane fade" id="tab-rencana-asuhan-terpadu" role="tabpanel" aria-labelledby="tab-rencana-asuhan-terpadu-tab">
    <div class="row">
        <div class="col-lg-12">
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
                <div class="row">
                    <div class="col-md-5">
                        @php
                            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                        @endphp
                        <x-adminlte-input-date name="tgl_waktu" id="tglwaktu" fgroup-class="row"
                            label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                            value="{{ now() }}" label="Tgl Waktu" :config="$config" required />
                        <x-adminlte-select name="profesi" label="Profesi" fgroup-class="row"
                            label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" required>
                            <option
                                {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Perawat' ? 'selected' : null) : null }}>
                                Perawat
                            </option>
                            <option
                                {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Dokter' ? 'selected' : null) : null }}>
                                Dokter</option>
                        </x-adminlte-select>
                        <x-adminlte-input name="pic" fgroup-class="row" label-class="text-left col-4"
                            igroup-class="col-8" igroup-size="sm" label="Nama Jelas" placeholder="Nama Jelas"
                            value="{{ Auth::user()->name }}" required />
                        <x-adminlte-textarea name="rencana_asuhan" label="Rencana Asuhan" rows="3"
                            igroup-size="sm" placeholder="Rencana Asuhan" required>
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="capaian_diharapkan" label="Capaian yang diharapkan" rows="3"
                            igroup-size="sm" placeholder="Capaian yang diharapkan" required>
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-7">
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
                                                <pre>{{ $item->rencana_asuhan }}</pre>
                                            </td>
                                            <td>
                                                <pre>{{ $item->capaian_diharapkan }}</pre>
                                            </td>
                                            <td>{{ $item->pic }}</td>
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            <div class="col-lg-12">
                <button class="btn btn-sm btn-success" type="submit" form="formAsuhanTerpadu">Simpan Data</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script></script>
@endpush
