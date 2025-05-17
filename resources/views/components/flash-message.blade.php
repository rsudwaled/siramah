@if (flash()->message)
    <div class="col-md-12">
        <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
            {{ flash()->message }}
        </x-adminlte-alert>
    </div>
@endif
