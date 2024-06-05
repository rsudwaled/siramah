<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="List Taskid" theme="secondary">
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input wire:model='kodebooking' name="kodebooking" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" label="Kodebooking" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-7">
                    <div wire:loading class="col-md-12">
                        <div class="row">
                            <p class="card-text placeholder-glow col-6"></p>
                            <p class="card-text placeholder-glow col-7"></p>
                            <p class="card-text placeholder-glow col-4"></p>
                            <p class="card-text placeholder-glow col-4"></p>
                            <p class="card-text placeholder-glow col-6"></p>
                            <p class="card-text placeholder-glow col-8"></p>
                            <br>
                        </div>
                        <style>
                            .placeholder {
                                display: inline-block;
                                width: 100%;
                                height: 1em;
                                background-color: #e9ecef;
                                border-radius: 0.2rem;
                            }

                            .placeholder-glow::before {
                                content: "\00a0";
                                display: inline-block;
                                width: 100%;
                                height: 100%;
                                background-color: #e9ecef;
                                border-radius: inherit;
                                animation: glow 1.5s infinite linear;
                            }

                            @keyframes glow {
                                0% {
                                    opacity: 1;
                                }

                                50% {
                                    opacity: 0.4;
                                }

                                100% {
                                    opacity: 1;
                                }
                            }
                        </style>
                    </div>
                    <div wire:loading.remove>
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Taskid</th>
                                    <th>Kodebooking</th>
                                    <th>Taskname</th>
                                    <th>Waktu RS</th>
                                    <th>Waktu Server</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taskid as $item)
                                    <tr>
                                        <td>{{ $item->taskid }}</td>
                                        <td>{{ $item->kodebooking }}</td>
                                        <td>{{ $item->taskname }}</td>
                                        <td>{{ $item->wakturs }}</td>
                                        <td>{{ $item->waktu }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
