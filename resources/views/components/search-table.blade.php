{{-- filepath: c:\laragon\www\simrs\resources\views\components\search-table.blade.php --}}
@if ($isSearching)
    <div
        style="position: absolute; z-index: 1000; background: white; border: 1px solid #ddd;  max-height: 200px; overflow-y: auto;">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if (!empty($data))
                    @foreach ($data as $item)
                        <tr wire:click="{{ $clickEvent }}({{ json_encode($item) }})">
                            @foreach ($item as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ count($columns) }}" class="text-center">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endif
