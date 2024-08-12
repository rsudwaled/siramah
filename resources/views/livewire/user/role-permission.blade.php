<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-6">
        @livewire('user.role-index', ['lazy' => true])
    </div>
    <div class="col-md-6">
        @livewire('user.permission-index', ['lazy' => true])
    </div>
</div>
