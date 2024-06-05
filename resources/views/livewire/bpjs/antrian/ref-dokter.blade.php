<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Referensi Dokter" theme="secondary">
            <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Dokter</th>
                        <th>Kode Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokters as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>{{ $item->kodedokter }}</td>
                        </tr>
                    @empty
                        <p>No polikliniks found.</p>
                    @endforelse
                </tbody>
            </table>
        </x-adminlte-card>
    </div>
</div>
