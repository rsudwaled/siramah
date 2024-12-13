<form action="{{ route('dashboard.erm-ranap.assesmen-medis.store-assesmen') }}" name="formAsesmenRanapAwal"
    id="formAsesmenRanapAwal" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">

        <div class="col-lg-12">
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
                                    value="{{ $assesmen->tgl_tiba_diruangan??\Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Waktu Tiba di Ruangan">Waktu</label>
                                <input type="time" name="waktu_tiba_diruangan" class="form-control"
                                    value="{{ $assesmen->waktu_tiba_diruangan??\Carbon\Carbon::now()->format('H:i') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ruang Perawatan</label>
                                <input type="text" class="form-control" name="nama_unit"
                                    value="{{ $assesmen->nama_unit??($header->nama_unit??$kunjungan->unit->nama_unit) }}" readonly required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Sumber Data</label>
                                <select class="custom-select rounded-0" name="sumber_data" id="sumber_data">
                                    <option value="Pasien_Autoanamnese" {{ isset($assesmen) && $assesmen->sumber_data === 'Pasien_Autoanamnese' ? 'selected' : '' }}>
                                        Pasien / Autoanamnese
                                    </option>
                                    <option value="Keluarga_Allonamnese" {{ isset($assesmen) && $assesmen->sumber_data === 'Keluarga_Allonamnese' ? 'selected' : '' }}>
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
                                    value="{{ $assesmen->tgl_pengkajian??\Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Waktu Pengkajian">Waktu Pengkajian</label>
                                <input type="time" name="waktu_pengkajian" class="form-control"
                                    value="{{ $assesmen->waktu_pengkajian??\Carbon\Carbon::now()->format('H:i') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nama Keluarga</label>
                                <input type="text" class="form-control" name="nama_keluarga" value="{{$assesmen->nama_keluarga??($header->nama_keluarga??'')}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Hubungan Keluarga</label>
                                <input type="text" class="form-control" name="hubungan_keluarga" value="{{$assesmen->hubungan_keluarga??($header->hubungan_keluarga??'')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-2">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Anamnesis</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Keluhan Utama">Keluhan Utama</label>
                                <textarea name="keluhan_utama" id="keluhan_utama" class="form-control" cols="30" rows="3"
                                    placeholder="masukan keluhan utama ..." required>{{ isset($assesmen->keluhan_utama) ? $assesmen->keluhan_utama : ($header->keluhan_utama_perawat ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Riwayat Penyakit Utama">Riwayat Penyakit Utama</label>
                                <textarea name="riwayat_penyakit_utama" id="riwayat_penyakit_utama" class="form-control" cols="30" rows="3"
                                    placeholder="masukan riwayat penyakit utama ..." required>{{ isset($assesmen->riwayat_penyakit_utama) ? $assesmen->riwayat_penyakit_utama : ($header->riwayat_penyakit_sekarang ?? '') }}</textarea>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Riwayat Penyakit Dahulu">Riwayat Penyakit Dahulu</label>
                                <textarea name="riwayat_penyakit_dahulu" id="riwayat_penyakit_dahulu" class="form-control" cols="30"
                                    rows="3">{{$assesmen->riwayat_penyakit_dahulu??''}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Riwayat Penyakit Keluarga">Riwayat Penyakit Keluarga</label>
                                <textarea name="riwayat_penyakit_keluarga" id="riwayat_penyakit_keluarga" class="form-control" cols="30"
                                    rows="3">{{$assesmen->riwayat_penyakit_keluarga??''}}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tanda-Tanda Vital & Pemeriksaan Fisik</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Keadaan Umum">Keadaan Umum</label>
                                <input type="text" class="form-control" name="keadaan_umum" value="{{$assesmen->keadaan_umum??''}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Kesadaran">Kesadaran</label>
                                <input type="text" class="form-control" name="kesadaran" value="{{$assesmen->kesadaran??($header->kesadaran??'')}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Tekanan Darah">Tekanan Darah</label>
                                <input type="text" class="form-control" name="sistole" value="{{$assesmen->sistole??($header->tekanan_darah??'')}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Pernapasan">Pernapasan</label>
                                <input type="text" class="form-control" name="pernapasan" value="{{$assesmen->pernapasan??($header->respirasi??'')}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Suhu">Suhu</label>
                                <input type="text" class="form-control" name="suhu" value="{{$assesmen->suhu??($header->suhu??'')}}" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Diastole">Diastole</label>
                                <input type="text" class="form-control" name="diastole" value="{{$assesmen->diastole??''}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row col-lg-12">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Pemeriksaan Fisik">Pemeriksaan Fisik</label>
                                    <textarea class="form-control" rows="3" name="pemeriksaan_fisik" placeholder="masukan pemeriksaan ..."
                                        required>{{$assesmen->pemeriksaan_fisik??''}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Hasil Pemeriksaan Penunjang">Hasil Pemeriksaan Penunjang</label>
                                    <textarea class="form-control" rows="3" name="pemeriksaan_penunjang" placeholder="masukan pemeriksaan ...">{{$assesmen->pemeriksaan_penunjang??''}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Diagnosa Kerja">Diagnosa Kerja</label>
                                    <textarea class="form-control" rows="3" name="diagnosa_kerja" placeholder="masukan pemeriksaan ..." required>{{$assesmen->diagnosa_kerja??''}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Pemeriksaan Fisik">Diagnosa Banding</label>
                                    <textarea class="form-control" rows="3" name="diagnosa_banding" placeholder="masukan pemeriksaan ...">{{$assesmen->diagnosa_banding??''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Rencana Asuhan & Kepulangan Pasien</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Rencana Pemeriksaan Penunjang">Rencana Pemeriksaan Penunjang</label>
                                <textarea class="form-control" rows="3" name="rencana_penunjang" placeholder="masukan rencana ...">{{$assesmen->rencana_penunjang??''}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Rencana Tindakan">Rencana Tindakan</label>
                                <textarea class="form-control" rows="3" name="rencana_tindakan" placeholder="masukan rencana ..." required>{{$assesmen->rencana_tindakan??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-l6 mr-2">
                                    <div class="form-group">
                                        <label for="Lama Rawat">Lama Rawat</label>
                                        <input type="text" class="form-control" name="rencana_lama_ranap" value="{{$assesmen->rencana_lama_ranap??''}}">
                                    </div>
                                </div>
                                <div class="col-l6">
                                    <div class="form-group">
                                        <label for="Rencana Tgl Pulang">Rencana Tgl Pulang</label>
                                        <input type="date" class="form-control" name="rencana_tgl_pulang" value="{{$assesmen->rencana_tgl_pulang??''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Alasan Ranap">Alasan Ranap</label>
                                <input type="text" class="form-control" name="alasan_lama_ranap" value="{{$assesmen->alasan_lama_ranap??''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="Memerlukan Perawat Lanjutan?">Memerlukan Perawat Lanjutan?</label>
                            <select class="custom-select rounded-0" name="memerlukan_perawatan_lanjutan" required
                                id="memerlukan_perawatan_lanjutan">
                                <option value="tidak"{{ isset($assesmen) && $assesmen->lanjutan_perawatan!=null?'':'selected' }}>Tidak</option>
                                <option value="iya" {{ isset($assesmen) && $assesmen->lanjutan_perawatan!=null?'':'selected' }}>IYA</option>
                            </select>
                        </div>
                        <div class="col-6" id="keterangan-lanjutan" style="display: {{ isset($assesmen) &&$assesmen->lanjutan_perawatan!=null?'block':'none'}};">
                            <div class="form-group">
                                <label for="Keterangan Perawatan Lanjutan">Keterangan Perawatan Lanjutan</label>
                                <input type="text" class="form-control" name="lanjutan_perawatan" value="{{ isset($assesmen) && $assesmen->lanjutan_perawatan??''}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row float-right">
        <button type="submit" class="btn btn-md btn-success" form="formAsesmenRanapAwal">
            <i class="fas fa-save"></i> Simpan Assesmen Awal</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#memerlukan_perawatan_lanjutan').change(function() {
            if ($(this).val() === 'iya') {
                $('#keterangan-lanjutan').show();
            } else {
                $('#keterangan-lanjutan').hide();
            }
        });
    });
</script>
