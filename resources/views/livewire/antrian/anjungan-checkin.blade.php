<div class="row p-1">
    <x-header-anjungan-antrian />
    <div class="col-md-4">
        <x-adminlte-card title="Checkin Antrian Manual" theme="success" icon="fas fa-qrcode">
            <form action="" method="GET">
                <x-adminlte-input wire:model='kodebooking' name="kodebooking" label="Masukan Kodebooking"
                    placeholder="Masukan Kodebooking" igroup-size="lg">
                    <x-slot name="appendSlot">
                        <x-adminlte-button type="submit" theme="success" label="Checkin!" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-success">
                            <i class="fas fa-qrcode"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </form>
            <div class="text-center">
                <i class="fas fa-qrcode fa-3x"></i>
                <br>
                <label>Status = <span id="status">-</span></label>
            </div>
            <x-slot name="footerSlot">
                <a href="{{ route('anjungan.mandiri') }}" class="btn btn-danger withLoad"><i
                        class="fas fa-arrow-left"></i>
                    Mesin
                    Antrian</a>
                <a href="{{ route('anjungan.checkin') }}" class="btn btn-warning withLoad"><i class="fas fa-sync"></i>
                    Reset
                    Antrian</a>
            </x-slot>
        </x-adminlte-card>
    </div>
    <div class="col-md-8">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        @if ($antrian)
            <x-adminlte-card title="Detail Antrian" theme="success" icon="fas fa-qrcode">
                <div class="row mb-1">
                    <div class="col-md-5">
                        <table>
                            <tr>
                                <th>Kodebooking</th>
                                <td>:</td>
                                <td>{{ $antrian->kodebooking }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{ $antrian->nama }}</td>
                            </tr>
                            <tr>
                                <th>RM</th>
                                <td>:</td>
                                <td>{{ $antrian->norm }}</td>
                            </tr>
                            <tr>
                                <th>No BPJS</th>
                                <td>:</td>
                                <td>{{ $antrian->nomorkartu }}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>:</td>
                                <td>{{ $antrian->nohp }}</td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>:</td>
                                <td>{{ $antrian->jenispasien }} / {{ $antrian->jeniskunjungan }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <th>Tanggal Periksa</th>
                                <td>:</td>
                                <td>{{ $antrian->tanggalperiksa }}</td>
                            </tr>
                            <tr>
                                <th>Poliklinik</th>
                                <td>:</td>
                                <td>{{ $antrian->namapoli }}</td>
                            </tr>
                            <tr>
                                <th>Dokter</th>
                                <td>:</td>
                                <td>{{ $antrian->namadokter }}</td>
                            </tr>

                            <tr>
                                <th>Jam Praktek</th>
                                <td>:</td>
                                <td>{{ $antrian->jampraktek }}</td>
                            </tr>
                            <tr>
                                <th>Taskid</th>
                                <td>:</td>
                                <td>{{ $antrian->taskid }}</td>
                            </tr>
                            <tr>
                                <th>Nomor SEP</th>
                                <td>:</td>
                                <td>{{ $antrian->nomorsep ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if ($antrian->nomorsep)
                    <x-adminlte-alert theme="warning" title="Informasi SEP">
                        SEP sudah dicetak dengan Nomor <b>{{ $antrian->nomorsep }}</b>
                    </x-adminlte-alert>
                @endif
                @isset($kunjungan->layanan)
                    <div class="row">
                        <div class="col-md-5">
                            <dl class="row">
                                <dt class="col-sm-4">Kunjungan</dt>
                                <dd class="col-sm-8">: {{ $kunjungan->kode_kunjungan ?? '-' }}</dd>
                                <dt class="col-sm-4">Layanan</dt>
                                <dd class="col-sm-8">: {{ $kunjungan->layanan->kode_layanan_header }}</dd>
                                <dt class="col-sm-4">Penjamin</dt>
                                <dd class="col-sm-8">:
                                    {{ $kunjungan->penjamin_simrs ? $kunjungan->penjamin_simrs->nama_penjamin : '-' }}
                                </dd>

                            </dl>
                        </div>
                        <div class="col-md-7">
                            <dl class="row">
                                <dt class="col-sm-4">No SEP</dt>
                                <dd class="col-sm-8">: {{ $kunjungan->no_sep ?? '-' }}</dd>
                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-8">:
                                    {{ $kunjungan->status ? $kunjungan->status->status_kunjungan : '-' }}</dd>
                                <dt class="col-sm-4">Tracer</dt>
                                <dd class="col-sm-8">:
                                    @if ($kunjungan->tracer)
                                        {{ $kunjungan->tracer->id_tracer_header }} /
                                        {{ $kunjungan->tracer->cek_tracer }}
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <table class="table-bordered col-md-12">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Tarif</th>
                                <th>Jumlah Tarif</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($kunjungan->layanan->layanan_details as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_layanan_detail }}</td>
                                    <td>{{ $item->tarif_detail->tarif->NAMA_TARIF }}</td>
                                    <td class="text-right"> {{ money($item->total_layanan, 'IDR') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th class="text-right" colspan="2">Total</th>
                                <th class="text-right">
                                    {{ money($kunjungan->layanan->layanan_details->sum('total_layanan'), 'IDR') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <x-adminlte-alert theme="danger" title="Belum Cetak Karcis Antrian">
                        Silahkan lakukan cetak karcis
                    </x-adminlte-alert>
                @endisset
                <x-slot name="footerSlot">
                    @if ($antrian->jenispasien == 'JKN')
                        <x-adminlte-button wire:click='checkinCetakSEP' theme="warning" icon="fas fa-print" label="Checkin Antrian" />

                        {{-- @if ($antrian->nomorsep)
                            <a href="{{ route('checkinKarcisAntrian') }}?kodebooking={{ $request->kodebooking }}"
                                class="btn btn-success withLoad"><i class="fas fa-print"></i>
                                Cetak Karcis</a>
                        @endif
                        <a href="{{ route('checkinPendaftaran') }}?kodebooking={{ $request->kodebooking }}"
                            class="btn btn-secondary withLoad"><i class="fas fa-print"></i> Checkin
                            Pendaftaran</a>
                        @if (!$antrian->nomorsep)
                        @else
                            <x-adminlte-button
                                onclick="window.open('{{ route('cetakSEPAntrian') }}?kodebooking={{ $request->kodebooking }}', 'window name', 'window settings');"
                                theme="warning" icon="fas fa-print" label="Cetak SEP Antrian"
                                data-kodebooking="{{ $request->kodebooking }}" />
                            <x-adminlte-button
                                onclick="window.open('{{ route('cetakAntrianOnline') }}?kodebooking={{ $request->kodebooking }}', 'window name', 'window settings');"
                                theme="warning" icon="fas fa-print" data-kodebooking="{{ $request->kodebooking }}" />
                        @endif --}}
                    @else
                        <x-adminlte-button theme="warning" icon="fas fa-print" label="Cetak Antrian" />
                        {{-- <a href="{{ route('checkinKarcisAntrian') }}?kodebooking={{ $request->kodebooking }}"
                            class="btn btn-success withLoad"><i class="fas fa-print"></i>
                            Cetak Karcis</a> --}}
                    @endif
                    {{-- <a target="_blank" href="http://192.168.2.45/simrs/cetaklabel/{{ $antrian->norm }}"
                        class="btn btn-primary"><i class="fas fa-print"></i>
                        Cetak Label</a> --}}
                </x-slot>
            </x-adminlte-card>
        @endif
    </div>
</div>
