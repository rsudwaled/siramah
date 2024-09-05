<div>
    <x-adminlte-card theme="primary" title="I-Care JKN">
        @if ($icare)
            @if ($message)
                <x-adminlte-alert theme="danger" title="Mohon Maaf !" dismissable>
                    {{ $message }}
                </x-adminlte-alert>
            @endif
            <iframe src="{{ $url }}" width="100%" height="400px" frameborder="0"></iframe>
        @else
            ICare JKN Tidak Aktif / Pasien NON-JKN
        @endif
    </x-adminlte-card>
</div>
