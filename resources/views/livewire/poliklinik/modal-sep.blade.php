<div>
    <x-adminlte-card theme="primary" title="SEP Pasien">
        @if (flash()->message)
            <div class="text-{{ flash()->class }}" wire:loading.remove>
                Loading Result : {{ flash()->message }}
            </div>
        @endif
        <table class="table text-nowrap table-sm table-hover table-bordered table-responsive mb-3">
            <thead>
                <tr>
                    <th>Tgl Masuk</th>
                    <th>Tgl Keluar</th>
                    <th>noSep</th>
                    <th>namaPeserta</th>
                    <th>jnsPelayanan</th>
                    <th>kelasRawat</th>
                    <th>poli</th>
                    <th>ppkPelayanan</th>
                    <th>noRujukan</th>
                    <th>diagnosa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seps as $item)
                    <tr>
                        <td>{{ $item->tglSep }}</td>
                        <td>{{ $item->tglPlgSep }}</td>
                        <td>{{ $item->noSep }}</td>
                        <td>{{ $item->namaPeserta }}</td>
                        <td>
                            @switch($item->jnsPelayanan)
                                @case(1)
                                    Rawat Inap
                                @break

                                @case(2)
                                    Rawat Jalan
                                @break

                                @default
                                    {{ $item->jnsPelayanan }}
                            @endswitch
                        </td>
                        <td>{{ $item->kelasRawat }}</td>
                        <td>{{ $item->poli }}</td>
                        <td>{{ $item->ppkPelayanan }}</td>
                        <td>{{ $item->noRujukan }}</td>
                        <td>{{ $item->diagnosa }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </x-adminlte-card>
</div>
