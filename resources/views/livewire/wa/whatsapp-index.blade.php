<div class="row">
    <x-flash-message />
    <div class="col-md-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="pt-2 px-3">
                        <h3 class="card-title">Pengaturan</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($activeTab === 'tabs-kirim') active @endif"
                            wire:click.prevent="setActiveTab('tabs-kirim')" href="#">Kirim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($activeTab === 'tabs-pengaturan') active @endif"
                            wire:click.prevent="setActiveTab('tabs-pengaturan')" href="#">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($activeTab === 'tabs-integrasi') active @endif"
                            wire:click.prevent="setActiveTab('tabs-integrasi')" href="#">Integrasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($activeTab === 'tabs-logs') active @endif"
                            wire:click.prevent="setActiveTab('tabs-logs')" href="#">Logs</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade @if ($activeTab === 'tabs-kirim') show active @endif" id="tabs-kirim">
                        <form>
                            <x-adminlte-input wire:model="number" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="number" label="Number" />
                            <x-adminlte-textarea rows=5 wire:model="message" fgroup-class="row"
                                label-class="text-left col-3" igroup-class="col-9" igroup-size="sm" name="message"
                                label="Message" />
                        </form>
                        <x-adminlte-button label="Kirim" wire:click="kirim"
                            wire:confirm="Apakah anda ingin mengirim pesan ?" theme="success" icon="fas fa-save" />
                    </div>
                    <div class="tab-pane fade @if ($activeTab === 'tabs-pengaturan') show active @endif" id="tabs-kirim">
                        <form>
                            <x-adminlte-input wire:model="nama" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="nama" label="Nama" />
                            <x-adminlte-input wire:model="kode" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="kode" label="Kode" />
                            <x-adminlte-input wire:model="baseUrl" fgroup-class="row" label-class="text-left col-3"
                                igroup-class="col-9" igroup-size="sm" name="baseUrl" label="BaseUrl" />
                        </form>
                        <x-adminlte-button label="Simpan" wire:click="save"
                            wire:confirm="Apakah anda ingin simpan data ?" theme="success" icon="fas fa-save" />
                    </div>
                    <div class="tab-pane fade @if ($activeTab === 'tabs-integrasi') show active @endif" id="tabs-integrasi"
                        wire:poll.1000ms>
                        QR CODE <br>
                        @foreach ($qr as $item)
                            {!! QrCode::size(300)->generate($item->qr) !!} <br>
                            {{ $item->created_at }} Tolong scan QR Whastapp Yang Terbaru<br>
                        @endforeach
                    </div>
                    <div class="tab-pane fade @if ($activeTab === 'tabs-logs') show active @endif" id="tabs-logs"
                        wire:poll.1000ms>
                        LOGS WA <br>
                        @foreach ($logs as $log)
                            {{ $log->created_at }} {{ $log->type }} {{ $log->status }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
