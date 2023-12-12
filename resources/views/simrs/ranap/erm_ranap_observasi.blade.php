<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colObservasi">
        <h3 class="card-title">
            Observasi 24 Jam
        </h3>
    </a>
    <div id="colObservasi" class="show collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Observasi" icon="fas fa-plus" data-toggle="modal"
                data-target="#modalObservasi" theme="success" class="btn-xs" />
            <x-adminlte-button label="Get Observasi" icon="fas fa-sync" theme="primary"
                class="btn-xs btnGetObservasi" />
            <a href="{{ route('print_obaservasi_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>


            <table class="table table-sm table-bordered table-hover" id="tableObservasi">
                <thead>
                    <tr>
                        <th>Tanggal Jam</th>
                        <th>Tensi</th>
                        <th>Nadi</th>
                        <th>RR</th>
                        <th>Suhu</th>
                        <th>GDS</th>
                        <th>Kesadaran</th>
                        <th>Pupil</th>
                        <th>ECG</th>
                        <th>Ket.</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalObservasi" title="Observasi 24 Jam" theme="warning" icon="fas fa-file-medical"
    size='lg'>
    <form action="{{ route('simpan_observasi_ranap') }}" id="formObservasi" name="formObservasi" method="POST">
        @csrf
        @php
            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
        @endphp
        <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
            value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input-date class="tanggal_input-keperawatan" name="tanggal_input" label="Tanggal & Waktu"
                    :config="$config" value="{{ now() }}" />
                <x-adminlte-input name="tensi" class="tensi" igroup-size="sm" label="Tensi Darah"
                    placeholder="Tensi" />
                <x-adminlte-input name="nadi" class="nadi-id" igroup-size="sm" label="Denyut Nadi"
                    placeholder="Denyut Nadi" />
                <x-adminlte-input name="rr" class="rr-id" igroup-size="sm" label="RR" placeholder="RR" />
                <x-adminlte-input name="suhu" class="suhu-id" igroup-size="sm" label="Suhu" placeholder="Suhu" />
                <x-adminlte-input name="gds" class="gds-id" igroup-size="sm" label="GDS" placeholder="GDS" />
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran1" name="kesadaran"
                            value="Sadar baik">
                        <label for="kesadaran1" class="custom-control-label">Sadar
                            baik</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran2" name="kesadaran"
                            value="Berespon dengan kata-kata">
                        <label for="kesadaran2" class="custom-control-label">Berespon
                            dengan
                            kata-kata</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran3" name="kesadaran"
                            value="Hanya berespons jika dirangsang nyeri/pain">
                        <label for="kesadaran3" class="custom-control-label">Hanya
                            berespons jika
                            dirangsang nyeri/pain</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran4" name="kesadaran"
                            value="Pasien tidak sadar/unresponsive">
                        <label for="kesadaran4" class="custom-control-label">Pasien tidak
                            sadar/unresponsive</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran5" name="kesadaran"
                            value="Gelisah / bingung">
                        <label for="kesadaran5" class="custom-control-label">Gelisah /
                            bingung</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="kesadaran6" name="kesadaran"
                            value="Acute Confusional State">
                        <label for="kesadaran6" class="custom-control-label">Acute
                            Confusional
                            State</label>
                    </div>
                </div>
                <x-adminlte-input name="pupilkanan" class="pupilkanan-id" igroup-size="sm" label="Pupil Kanan"
                    placeholder="Pupil Kanan" />
                <x-adminlte-input name="pupilkiri" class="pupilkiri-id" igroup-size="sm" label="Pupil Kiri"
                    placeholder="Pupil Kiri" />
                <x-adminlte-input name="ecg" class="ecg-id" igroup-size="sm" label="ECG"
                    placeholder="ECG" />
                <x-adminlte-textarea igroup-size="sm" class="keterangan" name="keterangan" label="Keterangan"
                    placeholder="Keterangan" rows=3>
                </x-adminlte-textarea>
            </div>
        </div>


        <x-slot name="footerSlot">
            <button type="submit" form="formObservasi" class="btn btn-success mr-auto"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </form>
</x-adminlte-modal>
