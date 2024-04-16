<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" href="#mppforma">
        <h3 class="card-title">
            Evaluasi Awal MPP (Form A)
        </h3>
    </a>
    <div id="mppforma" class="collapse" role="tabpanel">
        <div class="card-body">
            @include('simrs.ranap.table_mppa')
            <x-adminlte-button class="btn-sm mb-1" theme="danger" label="Edit Evaluasi Awal MPP A" onclick="modalMppA()"
                icon="fas fa-edit" />
            <a href="{{ route('print_mppa') }}?kode={{ $kunjungan->kode_kunjungan }}"
                class="btn btn-success btn-sm mb-1" target="_blank" rel="noopener noreferrer"> <i
                    class="fas fa-print"></i> Print</a>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalMppA" name="modalMppA" title="Asesmen Awal Medis Rawat Inap" theme="success"
    icon="fas fa-file-medical" size="xl">
    <form action="{{ route('simpan_mppa') }}" id="formMppa" name="formMppa" method="post">
        @csrf
        <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-textarea name="skiring" label="1. Identifikasi / skrining pasien terdapat jawaban"
                    rows="3" igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->skiring ?? '' }}
                </x-adminlte-textarea>
                <b>2. Assesmen Meliputi</b> <br>
                <b>a. Fisik, fungsional, kekuatan / kemampuan / kemandirian</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Mandiri Penuh" id="mandiripenuh"
                            name="kemampuan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Penuh' ? 'checked' : null) : null }}>
                        <label for="mandiripenuh" class="custom-control-label">Mandiri
                            Penuh</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="mandirisebagian" value="Mandiri Sebagian"
                            name="kemampuan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Sebagian' ? 'checked' : null) : null }}>
                        <label for="mandirisebagian" class="custom-control-label">Mandiri
                            Sebagian</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="Total Bantuan" type="radio" id="bantuan"
                            name="kemampuan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Total Bantuan' ? 'checked' : null) : null }}>
                        <label for="bantuan" class="custom-control-label">Total
                            Bantuan</label>
                    </div>
                    <x-adminlte-textarea name="kemampuan_text" rows="2" igroup-size="sm"
                        placeholder="Keterangan Lainnya">
                        {{ $kunjungan->erm_ranap_mppa->kemampuan_text ?? '' }}
                    </x-adminlte-textarea>
                </div>
                <x-adminlte-textarea name="riwayat_kesehatan" label="b. Riwayat Kesehatan" rows="3"
                    igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->riwayat_kesehatan ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="psikologi" label="c. Perilaku psiko-spiritual-sosio-kultural" rows="3"
                    igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->psikologi ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="mental" label="d. Kesehatan mental dan kognitif" rows="3"
                    igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->mental ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="lingkungan" label="e. Lingkungan tempat tinggal" rows="3"
                    igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->lingkungan ?? '' }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
                <b>f. Dukungan keluarga, kemampuan merawat dari pemberi asuhan</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Ya" id="dukunganya"
                            name="dukungan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->dukungan == 'Ya' ? 'checked' : null) : null }}>
                        <label for="dukunganya" class="custom-control-label">Ya</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="dukunganno" value="Tidak"
                            name="dukungan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->dukungan == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="dukunganno" class="custom-control-label">Tidak</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <b>g. Finansial</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Baik" id="fbaik"
                                    name="finansial"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Baik' ? 'checked' : null) : null }}>
                                <label for="fbaik" class="custom-control-label">Baik</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="fsedang" value="Sedang"
                                    name="finansial"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Sedang' ? 'checked' : null) : null }}>
                                <label for="fsedang" class="custom-control-label">Sedang</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="fburuk" value="Buruk"
                                    name="finansial"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Buruk' ? 'checked' : null) : null }}>
                                <label for="fburuk" class="custom-control-label">Buruk</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <b>Jaminan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Pribadi" id="jpribadi"
                                    name="jaminan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'Pribadi' ? 'checked' : null) : null }}>
                                <label for="jpribadi" class="custom-control-label">Pribadi</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="jasuransi" value="Asuransi"
                                    name="jaminan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'Asuransi' ? 'checked' : null) : null }}>
                                <label for="jasuransi" class="custom-control-label">Asuransi</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="jbpjs" value="JKN / BPJS"
                                    name="jaminan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'JKN / BPJS' ? 'checked' : null) : null }}>
                                <label for="jbpjs" class="custom-control-label">JKN / BPJS</label>
                            </div>
                        </div>

                    </div>
                </div>
                <b>h. Riwayat Pengobatan Alternatif</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Ya" id="obatalternatifya"
                            name="pengobatan_alt"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Ya' ? 'checked' : null) : null }}>
                        <label for="obatalternatifya" class="custom-control-label">Ya</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="obatalternatiftidak" value="Tidak"
                            name="pengobatan_alt"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="obatalternatiftidak" class="custom-control-label">Tidak</label>
                    </div>
                </div>
                <b>i. Riwayat Trauma / Kekerasan</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Tidak" id="tidaktrauma"
                            name="trauma"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->trauma == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="tidaktrauma" class="custom-control-label">Tidak</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="adatrauma" value="Ada"
                            name="trauma"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->trauma == 'Ada' ? 'checked' : null) : null }}>
                        <label for="adatrauma" class="custom-control-label">Ada</label>
                    </div>
                </div>
                <b>j. Pemahaman Tentang Kesehatan</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Tidak Tahu" id="tidaktahu"
                            name="paham"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->paham == 'Tidak Tahu' ? 'checked' : null) : null }}>
                        <label for="tidaktahu" class="custom-control-label">Tidak Tahu</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="tahu1" value="Tahu"
                            name="paham"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->paham == 'Tahu' ? 'checked' : null) : null }}>
                        <label for="tahu1" class="custom-control-label">Tahu</label>
                    </div>
                </div>
                <b>k. Harapan terhadap hasil asuhan, kemampuan menerima perubahan</b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                            name="harapan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->harapan == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="tidakberubah" class="custom-control-label">Tidak</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                            name="harapan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->harapan == 'Ada' ? 'checked' : null) : null }}>
                        <label for="adaberubah" class="custom-control-label">Ada</label>
                    </div>
                </div>
                <x-adminlte-input name="perkiraan_inap" igroup-size="sm" label="l. Perkiraan Lama Ranap (Hari)"
                    type="number" placeholder="Perkiraan Lama Ranap"
                    value="{{ $kunjungan->erm_ranap_mppa ? $kunjungan->erm_ranap_mppa->perkiraan_inap : null }}" />
                <b>m. Discharge Plan </b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Tidak" id="tidakdischarge"
                            name="discharge_plan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->discharge_plan == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="tidakdischarge" class="custom-control-label">Tidak</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="adadischarge" value="Ada"
                            name="discharge_plan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->discharge_plan == 'Ada' ? 'checked' : null) : null }}>
                        <label for="adadischarge" class="custom-control-label">Ada</label>
                    </div>
                </div>
                <b>n. Perencanaan Lanjutan </b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Home Care" id="homecare"
                            name="rencana_lanjutan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Home Care' ? 'checked' : null) : null }}>
                        <label for="homecare" class="custom-control-label">Home Care</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="rujuk" value="Rujuk"
                            name="rencana_lanjutan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Rujuk' ? 'checked' : null) : null }}>
                        <label for="rujuk" class="custom-control-label">Rujuk</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="obatrawat"
                            value="Pengobatan/Perawatan" name="rencana_lanjutan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Pengobatan/Perawatan' ? 'checked' : null) : null }}>
                        <label for="obatrawat" class="custom-control-label">Pengobatan/Perawatan</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="komunitas" value="Komunitas"
                            name="rencana_lanjutan"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Komunitas' ? 'checked' : null) : null }}>
                        <label for="komunitas" class="custom-control-label">Komunitas</label>
                    </div>
                </div>
                <b>o. Aspek Legal </b>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="Tidak" id="tidaklegal"
                            name="legalitas"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->legalitas == 'Tidak' ? 'checked' : null) : null }}>
                        <label for="tidaklegal" class="custom-control-label">Tidak</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="adalegal" value="Ada"
                            name="legalitas"
                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->legalitas == 'Ada' ? 'checked' : null) : null }}>
                        <label for="adalegal" class="custom-control-label">Ada</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- <b>3. Identifikasi Masalah - Resiko - Kesempatan </b>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="tidakseusaicp" value="Tidak sesuai dengan CP / PPK"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Tidak sesuai dengan CP / PPK', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}>
                        <label for="tidakseusaicp" class="custom-control-label">Tidak sesuai dengan CP /
                            PPK</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="kompilikasi" value="Adanya Komplikasi"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Adanya Komplikasi', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}>
                        <label for="kompilikasi" class="custom-control-label">Adanya Komplikasi</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="kurangpaham"
                            value="Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}>
                        <label for="kurangpaham" class="custom-control-label">Pemahaman pasien kurang tentang
                            penyakit, kondisi terkini, obat-obatan</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="tidakpatuh"
                            value="Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}>
                        <label for="tidakpatuh" class="custom-control-label">Ketidakpatuhan pasien kendala
                            keuangan ketika keparahan / komplikasi meningkat</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="konflik"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Terjadi Konflik', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}
                            value="Terjadi Konflik">
                        <label for="konflik" class="custom-control-label">Terjadi Konflik</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="pemulangand"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}
                            value="Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda">
                        <label for="pemulangand" class="custom-control-label">Pemulangan / rujukan belum
                            memenuhi kriteria / sebaliknya / ditunda</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="identifisikasimasalah[]" type="checkbox"
                            id="tindakan"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Tindakan / pengobatan yang tertunda / dibatalkan', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)) ? 'checked' : null) : null }}
                            value="Tindakan / pengobatan yang tertunda / dibatalkan">
                        <label for="tindakan" class="custom-control-label">Tindakan / pengobatan yang tertunda
                            / dibatalkan</label>
                    </div>
                </div>
                <b>4. Perencanaan MPP </b>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="rencana_mpp[]" type="checkbox"
                            id="kebutuhanasuhanp"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Kebutuhan asuhan', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)) ? 'checked' : null) : null }}
                            value="Kebutuhan asuhan">
                        <label for="kebutuhanasuhanp" class="custom-control-label">Kebutuhan asuhan</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="rencana_mpp[]" type="checkbox" id="edukasip"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Kebutuhan edukasi', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)) ? 'checked' : null) : null }}
                            value="Kebutuhan edukasi">
                        <label for="edukasip" class="custom-control-label">Kebutuhan edukasi</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="rencana_mpp[]" type="checkbox" id="solusikonflikp"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Solusi konflik', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)) ? 'checked' : null) : null }}
                            value="Solusi konflik">
                        <label for="solusikonflikp" class="custom-control-label">Solusi konflik</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="rencana_mpp[]" type="checkbox" id="diagnosisp"
                            {{ $kunjungan->erm_ranap_mppa ? (in_array('Diagnosis', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)) ? 'checked' : null) : null }}
                            value="Diagnosis">
                        <label for="diagnosisp" class="custom-control-label">Diagnosis</label>
                    </div>
                </div> --}}
                <x-adminlte-textarea name="jangka_pendek" label="Jangka Pendek" rows="3" igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->jangka_pendek ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="jangka_panjang" label="Jangka Panjang" rows="3" igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->jangka_panjang ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="kebutuhan_berjalan" label="Kebutuhan Berjalan" rows="3"
                    igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->kebutuhan_berjalan ?? '' }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="lain_lain" label="Lain-lain" rows="3" igroup-size="sm">
                    {{ $kunjungan->erm_ranap_mppa->lain_lain ?? '' }}
                </x-adminlte-textarea>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <button type="submit" form="formMppa" class="btn btn-success">
            <i class="fas fa-edit"></i> Simpan
        </button>
        <a class="btn btn-warning" target="_blank"
            href="{{ route('print_mppa') }}?kode={{ $kunjungan->kode_kunjungan }}">Print</a>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalMppA() {
            $.LoadingOverlay("show");
            $('#modalMppA').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
