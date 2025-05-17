<div class="row">
    <x-flash-message />
    <div class="col-md-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="pt-2 px-3">
                        <h3 class="card-title">Profil</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#tabs-akun">Akun</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tabs-identitas">Identitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tabs-kepegawaian">Kepegawaian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tabs-dokumen">Dokumen</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-akun">
                        <form>
                            <x-adminlte-input wire:model="name" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="name" label="Nama" />
                            <x-adminlte-input wire:model="username" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="username" label="Username" />
                            <x-adminlte-input wire:model="phone" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="phone" label="Phone" />
                            <x-adminlte-input wire:model="email" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="email" type="email" label="Email" />
                            <x-adminlte-input wire:model="password" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="password" type="password" label="Password"
                                placeholder="Isi apabila ingin merubah passowrd" />
                        </form>
                        <x-adminlte-button label="Simpan" wire:click="save"
                            wire:confirm="Apakah anda ingin menyimpan data profil {{ $user->name }} ?"
                            form="formUpdate" theme="warning" icon="fas fa-save" />
                    </div>
                    <div class="tab-pane fade" id="tabs-kepegawaian">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                        ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                        Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                        ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc
                        euismod pellentesque diam.
                    </div>
                    <div class="tab-pane fade" id="tabs-identitas">
                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis
                        ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate.
                        Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec
                        interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at
                        consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst.
                        Praesent imperdiet accumsan ex sit amet facilisis.
                    </div>
                    <div class="tab-pane fade" id="tabs-dokumen">
                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue
                        id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                        tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit
                        condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus
                        tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet
                        sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum
                        gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend
                        ac ornare magna.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
