<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colAnamnesa">
        <h3 class="card-title">
            Ringkasan Pasien Pulang
        </h3>
    </a>
    <div id="colAnamnesa" class="collapse" role="tabpanel" aria-labelledby="hAnamnesa">
        <div class="card-body">
            <form action="{{ route('simpan_resume_ranap') }}" name="formResume" id="formResume" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-textarea name="ringkasan_perawatan" label="Ringkasan Perawatan" rows="3"
                            igroup-size="sm" placeholder="Ringkasan Perawatan">
                            {{ $kunjungan->erm_ranap->ringkasan_perawatan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="riwayat_penyakit" label="Riwayat Penyakit" rows="2"
                            igroup-size="sm" placeholder="Riwayat Penyakit">
                            {{ $kunjungan->erm_ranap->riwayat_penyakit ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="indikasi_ranap" label="Indikasi Ranap" rows="2"
                            igroup-size="sm" placeholder="Indikasi Ranap">
                            {{ $kunjungan->erm_ranap->indikasi_ranap ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="pemeriksaan_fisik" label="Pemeriksaan Fisik" rows="4"
                            igroup-size="sm" placeholder="Pemeriksaan Fisik">
                            {{ $kunjungan->erm_ranap->pemeriksaan_fisik ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="catatan_laboratorium" label="Pemeriksaan Laboratorium" rows="3"
                            igroup-size="sm" placeholder="Pemeriksaan Laboratorium">
                            {{ $kunjungan->erm_ranap->catatan_laboratorium ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="catatan_radiologi" label="Pemeriksaan Radiologi" rows="3"
                            igroup-size="sm" placeholder="Pemeriksaan Radiologi">
                            {{ $kunjungan->erm_ranap->catatan_radiologi ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="catatan_penunjang" label="Pemeriksaan Penunjang Lainnya"
                            rows="3" igroup-size="sm" placeholder="Pemeriksaan Penunjang Lainnya">
                            {{ $kunjungan->erm_ranap->catatan_penunjang ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="hasil_konsultasi" label="Hasil Konsultasi" rows="3"
                            igroup-size="sm" placeholder="Hasil Konsultasi">
                            {{ $kunjungan->erm_ranap->hasil_konsultasi ?? null }}
                        </x-adminlte-textarea>
                    </div>

                    <div class="col-md-3">
                        <x-adminlte-textarea name="diagnosa_masuk" label="Diagnosa Masuk" rows="3"
                            igroup-size="sm" placeholder="Diagnosa Masuk">
                            {{ $kunjungan->erm_ranap->diagnosa_masuk ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="diagnosa_utama" label="Diagnosa Utama" rows="3"
                            igroup-size="sm" placeholder="Diagnosa Utama">
                            {{ $kunjungan->erm_ranap->diagnosa_utama ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="diagnosa_sekunder" label="Diagnosa Sekunder" rows="3"
                            igroup-size="sm" placeholder="Diagnosa Sekunder">
                            {{ $kunjungan->erm_ranap->diagnosa_sekunder ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="komplikasi" label="Komplikasi" rows="3" igroup-size="sm"
                            placeholder="Komplikasi">
                            {{ $kunjungan->erm_ranap->komplikasi ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="diagnosa_icd10" label="Diagnosa ICD-10" rows="3"
                            igroup-size="sm" placeholder="Diagnosa ICD-10">
                            {{ $kunjungan->erm_ranap->diagnosa_icd10 ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="tindakan" label="Tindakan Operasi" rows="3" igroup-size="sm"
                            placeholder="Tindakan Operasi">
                            {{ $kunjungan->erm_ranap->tindakan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="tindakan" label="Tindakan / Prosedur" rows="3"
                            igroup-size="sm" placeholder="Tindakan / Prosedur">
                            {{ $kunjungan->erm_ranap->tindakan ?? null }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="tindakan_icd9" label="Tindakan ICD-9" rows="3"
                            igroup-size="sm" placeholder="Tindakan ICD-9">
                            {{ $kunjungan->erm_ranap->tindakan_icd9 ?? null }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>
                <button type="submit" form="formResume" class="btn btn-success">
                    <i class="fas fa-edit"></i> Simpan Resume Ranap
                </button>

                <a class="btn btn-warning" target="_blank"
                    href="{{ route('print_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}">Print</a>
            </form>
        </div>
    </div>
</div>
