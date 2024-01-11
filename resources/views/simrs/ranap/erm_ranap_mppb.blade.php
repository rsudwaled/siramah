<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" href="#mppformb">
        <h3 class="card-title">
            Catatan Implementasi MPP (Form B)
        </h3>
    </a>
    <div id="mppformb" class="collapse" role="tabpanel">
        <div class="card-body">
            <form action="{{ route('simpan_mppb') }}" id="formMppb" name="formMppb" method="post">
                @csrf
                <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-textarea name="rencana" label="1. Rencana Pelayanan Pasien" rows="3"
                            igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->rencana ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="monitoring"
                            label="2. Monitoring pelayanan / asuhan pasien seluruh PPA (perkembangan, kolaborasi) verifikasi respon terhadap intervensi yang diberikan, revisi rencana asuhan termasuk preferensi perubahan, transisi pelayanan dan kendala pelayanan."
                            rows="3" igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->monitoring ?? '' }}
                        </x-adminlte-textarea>
                        <b>3. Memfasilitasi pelayanan </b> <br>
                        <x-adminlte-textarea name="konsultasi" label="Konsultasi / kolaborasi" rows="3"
                            igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->konsultasi ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="second_opsi" label="Second Opinion" rows="3" igroup-size="sm"
                            placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->second_opsi ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="rawat_bersama" label="Rawat Bersama / Alih Rawat" rows="3"
                            igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->rawat_bersama ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="komunikasi" label="Komunikasi / Edukasi" rows="3"
                            igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->komunikasi ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="rujukan" label="Rujukan" rows="3" igroup-size="sm"
                            placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->rujukan ?? '' }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-6">
                        <b>4. Advokasi pelayanan pasien</b>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="Diskusi" id="adv1"
                                    name="advokasi[]" {{ $kunjungan->erm_ranap_mppb ? (in_array('Diskusi', json_decode($kunjungan->erm_ranap_mppb->advokasi)) ? 'checked' : null) : null }}>
                                <label for="adv1" class="custom-control-label">Diskusi dengan PPA staff lain
                                    tentang
                                    kebutuhan pasien</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="Memfasilitasi" id="adv2"
                                    name="advokasi[]" {{ $kunjungan->erm_ranap_mppb ? (in_array('Memfasilitasi', json_decode($kunjungan->erm_ranap_mppb->advokasi)) ? 'checked' : null) : null }}>
                                <label for="adv2" class="custom-control-label">Memfasilitasi akses pelayanan
                                    sesuai
                                    kebutuhan pasien berkoodinasi dengan PPA dan pemangku kepentingan </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="Meningkatkan" id="adv3"
                                    name="advokasi[]" {{ $kunjungan->erm_ranap_mppb ? (in_array('Meningkatkan', json_decode($kunjungan->erm_ranap_mppb->advokasi)) ? 'checked' : null) : null }}>
                                <label for="adv3" class="custom-control-label">Meningkatkan kemandirian untuk
                                    menentukan pilihan / pengambilan keputusan</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="Mengenali" id="adv4"
                                    name="advokasi[]" {{ $kunjungan->erm_ranap_mppb ? (in_array('Mengenali', json_decode($kunjungan->erm_ranap_mppb->advokasi)) ? 'checked' : null) : null }}>
                                <label for="adv4" class="custom-control-label">Mengenali, mencegah, menghindari
                                    disparatis untuk mengakses mutu dan hasil pelayanan terkait ras, etnik, agama,
                                    gender,
                                    budaya, status pernikahan, umur, politik, disabilitas fisik-mental-kognitif</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="pemenuhan" id="adv5"
                                    name="advokasi[]" {{ $kunjungan->erm_ranap_mppb ? (in_array('pemenuhan', json_decode($kunjungan->erm_ranap_mppb->advokasi)) ? 'checked' : null) : null }}>
                                <label for="adv5" class="custom-control-label">Untuk pemenuhan kebutuhan pelayanan
                                    yang berkembang / bertambah karena perubahan kondisi</label>
                            </div>
                        </div>
                        <b>5. Informasi pelayanan / hasil pelayanan </b> <br>
                        <x-adminlte-textarea name="sasaran" label="Sasaran" rows="3" igroup-size="sm"
                            placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->sasaran ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="keberhasilan"
                            label="Keberhasilan, kualitas, kendali biaya efektif dari intervensi MPP mencapai sasaran asuhan pasien"
                            rows="3" igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->keberhasilan ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="nilai" label="Nilai / laporan dampak pelaksanaan asuhan pasien"
                            rows="3" igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->nilai ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="utilitas" label="Catatan utilisasi sesuai panduan / norma"
                            rows="3" igroup-size="sm" placeholder="">
                            {{ $kunjungan->erm_ranap_mppb->utilitas ?? '' }}
                        </x-adminlte-textarea>
                        <b>5. Terminasi pelayanan pasien catatan keputusan pasien / keluarga dengan MPP</b> <br>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Puas" id="trmns1"
                                    name="terminasi"
                                    {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->terminasi == 'Puas' ? 'checked' : null) : null }}>
                                <label for="trmns1" class="custom-control-label">Puas</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak Puas" id="trmns2"
                                    name="terminasi"
                                    {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->terminasi == 'Tidak Puas' ? 'checked' : null) : null }}>
                                <label for="trmns2" class="custom-control-label">Tidak Puas</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Abstain" id="trmns3"
                                    name="terminasi"
                                    {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->terminasi == 'Abstain' ? 'checked' : null) : null }}>
                                <label for="trmns3" class="custom-control-label">Abstain</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Bermasalah" id="trmns4"
                                    name="terminasi"
                                    {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->terminasi == 'Bermasalah' ? 'checked' : null) : null }}>
                                <label for="trmns4" class="custom-control-label">Bermasalah</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Konflik / Komplain"
                                    id="trmns5" name="terminasi"
                                    {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->terminasi == 'Konflik / Komplain' ? 'checked' : null) : null }}>
                                <label for="trmns5" class="custom-control-label">Konflik / Komplain</label>
                            </div>
                        </div>
                        <b>Kepulangan</b> <br>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Pasien Pulang Perbaikan"
                                    id="kplg1" name="kepulangan" {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->kepulangan == 'Pasien Pulang Perbaikan' ? 'checked' : null) : null }}>
                                <label for="kplg1" class="custom-control-label">Pasien Pulang Perbaikan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Rujuk" id="kplg2"
                                    name="kepulangan" {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->kepulangan == 'Rujuk' ? 'checked' : null) : null }}>
                                <label for="kplg2" class="custom-control-label">Rujuk</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Meninggal" id="kplg3"
                                    name="kepulangan" {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->kepulangan == 'Meninggal' ? 'checked' : null) : null }}>
                                <label for="kplg3" class="custom-control-label">Meninggal</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Lain-lain" id="kplg4"
                                    name="kepulangan" {{ $kunjungan->erm_ranap_mppb ? ($kunjungan->erm_ranap_mppb->kepulangan == 'Lain-lain' ? 'checked' : null) : null }}>
                                <label for="kplg4" class="custom-control-label">Lain-lain</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" form="formMppb" class="btn btn-success">
                    <i class="fas fa-edit"></i> Simpan
                </button>
                <a class="btn btn-warning" target="_blank"
                    href="{{ route('print_mppb') }}?kode={{ $kunjungan->kode_kunjungan }}">Print</a>
            </form>
        </div>
    </div>
</div>
