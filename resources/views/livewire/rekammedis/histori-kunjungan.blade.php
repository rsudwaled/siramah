<div id="historikunjungan">
    <x-adminlte-card title="Histori Kunjungan" theme="primary" icon="fas fa-file-medical">
        @if ($kunjungans)
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
                            Tgl Masuk : <b>{{ \Carbon\Carbon::parse($item->tgl_masuk)->isoFormat('D MMMM Y HH:mm:ss') }}</b><br>
                            @if ($item->tgl_keluar)
                                Tgl Keluar :
                                <b>{{ \Carbon\Carbon::parse($item->tgl_keluar)->isoFormat('D MMMM Y') }}</b><br>
                            @endif

                            Counter : <b>{{ $item->counter }}</b> / <b>{{ $item->kode_kunjungan }}</b>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
            <br>
            {{ $kunjungans->links() }}
        @endif
    </x-adminlte-card>
</div>
