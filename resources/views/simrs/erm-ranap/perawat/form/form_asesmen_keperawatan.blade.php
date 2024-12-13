<form action="{{ route('dashboard.erm-ranap.perawat.assesmen-awal.store-assesmen') }}" name="formAsesmenKeperawatan"
    id="formAsesmenKeperawatan" method="POST">
    @csrf
    <input type="hidden" name="kode" value="{{ $kunjungan->kode_kunjungan }}">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Ruang Perawatan</label>
                    <input type="text" class="form-control" name="unit_ruangan"
                        value="{{ $kunjungan->unit->nama_unit }}" readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>No RM</label>
                    <input type="text" class="form-control" name="no_rm" value="{{ $kunjungan->no_rm }}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" class="form-control" name="nama_pasien"
                        value="{{ $kunjungan->pasien->nama_px }}" readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <input type="text" class="form-control" name="jk_pasien"
                        value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Tiba di Ruangan">Tiba di Ruangan</label>
                            <input type="date" name="tgl_tiba_diruangan" class="form-control"
                                value="{{ \Carbon\Carbon::parse($asesmenkeperawatan->tgl_tiba_ruangan ?? now())->format('Y-m-d') }}"
                                {{ isset($asesmenkeperawatan->tgl_tiba_ruangan) ? 'readonly' : '' }}>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Waktu Tiba di Ruangan">Waktu</label>
                            <input type="time" name="waktu_tiba_diruangan" class="form-control"
                                value="{{ \Carbon\Carbon::parse($asesmenkeperawatan->waktu_tiba ?? now())->format('H:i') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Kesadaran</label>
                            <select class="custom-select rounded-0" name="kesadaran" id="kesadaran">
                                <option value="compos_mentis"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->kesadaran === 'compos_mentis' ? 'selected' : '' }}>
                                    Compos Mentis
                                </option>
                                <option value="apatis"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->kesadaran === 'apatis' ? 'selected' : '' }}>
                                    Apatis
                                </option>
                                <option value="somnolent"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->kesadaran === 'somnolent' ? 'selected' : '' }}>
                                    Somnolent
                                </option>
                                <option value="sopor"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->kesadaran === 'sopor' ? 'selected' : '' }}>
                                    Sopor
                                </option>
                                <option value="coma"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->kesadaran === 'coma' ? 'selected' : '' }}>
                                    Coma
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Sumber Data</label>
                            <select class="custom-select rounded-0" name="sumber_data" id="sumber_data">
                                <option value="Pasien_Autoanamnese"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->sumber_data === 'Pasien_Autoanamnese' ? 'selected' : '' }}>
                                    Pasien / Autoanamnese
                                </option>
                                <option value="Keluarga_Allonamnese"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->sumber_data === 'Keluarga_Allonamnese' ? 'selected' : '' }}>
                                    Keluarga / Allonamnese
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Tgl Pengkajian">Tgl Pengkajian</label>
                            <input type="date" name="tgl_pengkajian" class="form-control"
                                value="{{ \Carbon\Carbon::parse($asesmenkeperawatan->tgl_pengkajian ?? now())->format('Y-m-d') }}" {{ isset($asesmenkeperawatan->tgl_pengkajian) ? 'readonly' : '' }}>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Waktu Pengkajian">Waktu Pengkajian</label>
                            <input type="time" name="waktu_pengkajian" class="form-control"
                                value="{{ $asesmenkeperawatan->waktu_pengkajian ?? \Carbon\Carbon::now()->format('H:i') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Nama Keluarga</label>
                            <input type="text" class="form-control" name="nama_keluarga"
                                value="{{ $asesmenkeperawatan->nama_keluarga ?? '' }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Hubungan Keluarga</label>
                            <input type="text" class="form-control" name="hubungan_keluarga"
                                value="{{ $asesmenkeperawatan->hubungan_keluarga ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Cara Masuk</label>
                            <select class="custom-select rounded-0" name="cara_masuk" id="cara_masuk">
                                <option value="jalan_kaki"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->cara_masuk === 'jalan_kaki' ? 'selected' : '' }}>
                                    Jalan Kaki
                                </option>
                                <option value="kursi_roda"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->cara_masuk === 'kursi_roda' ? 'selected' : '' }}>
                                    Kursi Roda
                                </option>
                                <option value="brankar"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->cara_masuk === 'brankar' ? 'selected' : '' }}>
                                    Brankar
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Asal Masuk</label>
                            <select class="custom-select rounded-0" name="asal_masuk" id="asal_masuk">
                                <option value="igd"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->asal_masuk === 'igd' ? 'selected' : '' }}>
                                    IGD
                                </option>
                                <option value="rawat_jalan"
                                    {{ isset($asesmenkeperawatan) && $asesmenkeperawatan->asal_masuk === 'rawat_jalan' ? 'selected' : '' }}>
                                    Rawat Jalan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-3">
                                <label for="Tekanan Darah">Tekanan Darah</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="tekanan_darah"
                                        value="{{ $asesmenkeperawatan->tekanan_darah ?? '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="Respirasi">Respirasi</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="respirasi"
                                        value="{{ $asesmenkeperawatan->respirasi ?? '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">x/menit</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="Respirasi">Nadi</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="denyut_nadi"
                                        value="{{ $asesmenkeperawatan->denyut_nadi ?? '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">x/menit</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="Respirasi">Suhu</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="suhu"
                                        value="{{ $asesmenkeperawatan->suhu ?? '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">°C</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('simrs.erm-ranap.perawat.form.asesmen_nyeri.skrining_asesmen_nyeri')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.respirasi_oksigenasi')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.kardio_vaskuler')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.gastro_intestinal')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.muskulo_skeletal')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.neurologi')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.urogenital')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.integumen')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.hygiene')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.psikososial_budaya')
    @include('simrs.erm-ranap.perawat.form.pemeriksaan_fisik.spiritual_kepercayaan')
    @include('simrs.erm-ranap.perawat.form.asesmen_resiko.faktor_resiko')
    @include('simrs.erm-ranap.perawat.form.dignostik_edukasi.diagnostik_kebutuhan_edukasi')
    @include('simrs.erm-ranap.perawat.form.dignostik_edukasi.skrining_nutrisi')
    @include('simrs.erm-ranap.perawat.form.dignostik_edukasi.asesmen_fungsional')
    @include('simrs.erm-ranap.perawat.form.dignostik_edukasi.perencanaan_pulang')
    @include('simrs.erm-ranap.perawat.form.rencana_asuhan_keperawatan.rencana_asuhan_keperawatan')


    <button class="btn btn-success btn-sm float-right" type="submit">Simpan</button>
</form>
