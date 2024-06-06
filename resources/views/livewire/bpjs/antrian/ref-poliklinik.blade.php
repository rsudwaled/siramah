<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Referensi Poliklinik" theme="secondary">
            <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Poliklinik</th>
                        <th>Kode Poliklinik</th>
                        <th>Nama Subspesialis</th>
                        <th>Kode Subspesialis</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($polikliniks as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nmpoli }}</td>
                            <td>{{ $item->kdpoli }}</td>
                            <td>{{ $item->nmsubspesialis }}</td>
                            <td>{{ $item->kdsubspesialis }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </x-adminlte-card>
    </div>
</div>
