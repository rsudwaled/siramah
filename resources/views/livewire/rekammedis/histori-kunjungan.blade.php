<div id="historikunjungan">
    <x-adminlte-card title="Histori Kunjungan" theme="primary" icon="fas fa-file-medical">
        <table class="table table-bordered table-xs">
            <thead>
                <tr>
                    <th>Registrasi</th>
                    <th>Perawat</th>
                    <th>Dokter</th>
                    <th>Penunjang</th>
                    <th>Farmasi</th>
                </tr>
            </thead>
            @foreach ($kunjungans as $item)
                <tr>
                    <td>
                        <b>{{ $item->unit->nama_unit }}</b><br>
                        Tgl Masuk : <b>{{ $item->tgl_masuk }}</b><br>
                        Counter : <b>{{ $item->counter }}</b> / <b>{{ $item->kode_kunjungan }}</b>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </table>
        {{-- {{ $kunjungans->links() }} --}}
    </x-adminlte-card>
</div>
