<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Antrian" theme="secondary">
            @if ($antrian)
                <table>
                    <tr>
                        <td>jeniskunjungan</td>
                        <td>:</td>
                        <td>{{ $antrian->jeniskunjungan }}</td>
                    </tr>
                    <tr>
                        <td>nomorreferensi</td>
                        <td>:</td>
                        <td>{{ $antrian->nomorreferensi }}</td>
                    </tr>
                    <tr>
                        <td>createdtime</td>
                        <td>:</td>
                        <td>{{ $antrian->createdtime }}</td>
                    </tr>
                    <tr>
                        <td>kodebooking</td>
                        <td>:</td>
                        <td>{{ $antrian->kodebooking }}</td>
                    </tr>
                    <tr>
                        <td>norekammedis</td>
                        <td>:</td>
                        <td>{{ $antrian->norekammedis }}</td>
                    </tr>
                    <tr>
                        <td>nik</td>
                        <td>:</td>
                        <td>{{ $antrian->nik }}</td>
                    </tr>
                    <tr>
                        <td>nokapst</td>
                        <td>:</td>
                        <td>{{ $antrian->nokapst }}</td>
                    </tr>
                    <tr>
                        <td>noantrean</td>
                        <td>:</td>
                        <td>{{ $antrian->noantrean }}</td>
                    </tr>
                    <tr>
                        <td>kodepoli</td>
                        <td>:</td>
                        <td>{{ $antrian->kodepoli }}</td>
                    </tr>
                    <tr>
                        <td>sumberdata</td>
                        <td>:</td>
                        <td>{{ $antrian->sumberdata }}</td>
                    </tr>
                    <tr>
                        <td>estimasidilayani</td>
                        <td>:</td>
                        <td>{{ $antrian->estimasidilayani }}</td>
                    </tr>
                    <tr>
                        <td>kodedokter</td>
                        <td>:</td>
                        <td>{{ $antrian->kodedokter }}</td>
                    </tr>
                    <tr>
                        <td>jampraktek</td>
                        <td>:</td>
                        <td>{{ $antrian->jampraktek }}</td>
                    </tr>
                    <tr>
                        <td>nohp</td>
                        <td>:</td>
                        <td>{{ $antrian->nohp }}</td>
                    </tr>
                    <tr>
                        <td>tanggal</td>
                        <td>:</td>
                        <td>{{ $antrian->tanggal }}</td>
                    </tr>
                    <tr>
                        <td>ispeserta</td>
                        <td>:</td>
                        <td>{{ $antrian->ispeserta }}</td>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>:</td>
                        <td>{{ $antrian->status }}</td>
                    </tr>
                </table>
            @else
                Antrian tidak ditemukan
            @endif
        </x-adminlte-card>
    </div>
</div>
