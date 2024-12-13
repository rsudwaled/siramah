<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Asesmen Resiko Jatuh Pasien Dewasa</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table style="width: 100%;">
            <thead>
                <th style="border: 1px solid black;">Faktor Risiko</th>
                <th style="border: 1px solid black;">Skala</th>
                <th style="border: 1px solid black;">Skor</th>
                <th style="border: 1px solid black;">Skor Pasien</th>
            </thead>
            <tbody>
                <tr style="border: 1px solid black;">
                    <td rowspan="2" style="border: 1px solid black;">Riwayat Jatuh</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_riwayat_jatuh_tidak" class="form-control skor-input"
                            max="0" value="{{ $faktorResiko->skor_riwayat_jatuh_tidak ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Ya</td>
                    <td style="border: 1px solid black; text-align:center;">25</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_riwayat_jatuh_ya" class="form-control skor-input"
                            max="25" value="{{ $faktorResiko->skor_riwayat_jatuh_ya ?? 0 }}">
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="2" style="border: 1px solid black;">Diagnosa Sekunder</td>
                    <td style="border: 1px solid black;text-align:center;">Tidak</td>
                    <td style="border: 1px solid black;text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_diagnosa_sekunder_tidak" class="form-control skor-input"
                            max="0" value="{{ $faktorResiko->skor_diagnosa_sekunder_tidak ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Ya</td>
                    <td style="border: 1px solid black; text-align:center;">15</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_diagnosa_sekunder_ya" class="form-control skor-input"
                            max="15" value="{{ $faktorResiko->skor_diagnosa_sekunder_ya ?? 0 }}">
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="3" style="border: 1px solid black;">Menggunakan alat-alat bantu</td>
                    <td style="border: 1px solid black;text-align:center;">Tidak ada/Bedrest/dibantu perawat</td>
                    <td style="border: 1px solid black;text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_alat_bantu_tidak" class="form-control skor-input"
                            max="0" value="{{ $faktorResiko->skor_alat_bantu_tidak ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Kruk/Tongkat</td>
                    <td style="border: 1px solid black; text-align:center;">15</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_alat_bantu_kruk" class="form-control skor-input" max="15"
                            value="{{ $faktorResiko->skor_alat_bantu_kruk ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Kursi/Perabot</td>
                    <td style="border: 1px solid black; text-align:center;">30</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_alat_bantu_kursi" class="form-control skor-input"
                            max="30" value="{{ $faktorResiko->skor_alat_bantu_kursi ?? 0 }}">
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="2" style="border: 1px solid black;">Menggunakan infus/heparin/pengencer darah/obat
                        risiko jatuh</td>
                    <td style="border: 1px solid black;text-align:center;">Tidak</td>
                    <td style="border: 1px solid black;text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_infus_tidak" class="form-control skor-input" max="0"
                            value="{{ $faktorResiko->skor_infus_tidak ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Ya</td>
                    <td style="border: 1px solid black; text-align:center;">20</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_infus_ya" class="form-control skor-input" max="20"
                            value="{{ $faktorResiko->skor_infus_ya ?? 0 }}">
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="3" style="border: 1px solid black;">Gaya berjalan</td>
                    <td style="border: 1px solid black;text-align:center;">Normal/Bedrest/kursi roda</td>
                    <td style="border: 1px solid black;text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_gaya_berjalan_normal" class="form-control skor-input"
                            max="0" value="{{ $faktorResiko->skor_gaya_berjalan_normal ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Lemah</td>
                    <td style="border: 1px solid black; text-align:center;">10</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_gaya_berjalan_lemah" class="form-control skor-input"
                            max="10" value="{{ $faktorResiko->skor_gaya_berjalan_lemah ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Terganggu</td>
                    <td style="border: 1px solid black; text-align:center;">20</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_gaya_berjalan_terganggu" class="form-control skor-input"
                            max="20" value="{{ $faktorResiko->skor_gaya_berjalan_terganggu ?? 0 }}">
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="2" style="border: 1px solid black;">Status mental</td>
                    <td style="border: 1px solid black;text-align:center;">Menyadari kemampuan</td>
                    <td style="border: 1px solid black;text-align:center;">0</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_status_mental_menyadari" class="form-control skor-input"
                            max="0" value="{{ $faktorResiko->skor_status_mental_menyadari ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">Lupa akan keterbatasan/pelupa</td>
                    <td style="border: 1px solid black; text-align:center;">15</td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_status_mental_lupa" class="form-control skor-input"
                            max="15" value="{{ $faktorResiko->skor_status_mental_lupa ?? 0 }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="mt-2">
                        <div class="icheck-primary d-inline ">
                            <input type="checkbox" id="pasien_tidak_beresiko" name="pasien_tidak_beresiko">
                            <label for="pasien_tidak_beresiko">Pasien tidak beresiko (0-24) </label>
                        </div> <br><br>
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="pasien_risiko_sedang" name="pasien_risiko_sedang">
                            <label for="pasien_risiko_sedang">Pasien risiko rendah-sedang (25-44)</label>
                        </div> <br><br>
                        <div class="icheck-primary d-inline ">
                            <input type="checkbox" id="pasien_risiko_tinggi" name="pasien_risiko_tinggi">
                            <label for="pasien_risiko_tinggi">Pasien risiko tinggi (> 45)*</label>
                        </div>
                    </td>
                    <td colspan="2" class="mt-2 text-left">
                        <div class="form-group">
                            <label for="total_skor">Total Skor</label>
                            <input type="text" id="total_skor" name="total_skor_pasien"
                                value="{{ $faktorResiko->total_skor ?? 0 }}" class="form-control" readonly>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Asesmen Resiko Jatuh Pasien Geriatri</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>


    <div class="card-body">
        <table style="width: 100%;">
            <thead>
                <th style="border: 1px solid black;">Parameter</th>
                <th style="border: 1px solid black;">Skrinning</th>
                <th style="border: 1px solid black;">Keterangan Nilai</th>
                <th style="border: 1px solid black; width:100px;">Keterangan</th>
                <th style="border: 1px solid black;">Skor</th>
            </thead>
            <tbody>
                <tr style="border: 1px solid black;">
                    <td rowspan="2" style="border: 1px solid black;">Riwayat Jatuh</td>
                    <td style="border: 1px solid black; text-align:left;">Apakah pasien datang ke rumah sakit karena
                        jatuh?</td>
                    <td rowspan="2" style="border: 1px solid black; text-align:left;">salah satu jawaban <br> Ya =
                        6</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_riwayat_jatuh[]" class="form-control skrining-select"
                            data-input="skor_skrining_riwayat_jatuh_1">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->jatuh_rumah_sakit == 0 ? 'selected' : '' }}>
                                Tidak</option>
                            <option value="6"
                                {{ isset($skriningResiko) && $skriningResiko->jatuh_rumah_sakit > 0 ? 'selected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_riwayat_jatuh[]" id="skor_skrining_riwayat_jatuh_1"
                            class="form-control skor-skrining-input" max="6"
                            value="{{ $skriningResiko->jatuh_rumah_sakit ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">Jika tidak, apakah pasien mengalami jatuh
                        dalam 2 bulan terakhir?</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_riwayat_jatuh[]" class="form-control skrining-select"
                            data-input="skor_skrining_riwayat_jatuh_2">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->jatuh_2_bulan_terakhir == 0 ? 'selected' : '' }}>
                                Tidak</option>
                            <option value="6"
                                {{ isset($skriningResiko) && $skriningResiko->jatuh_2_bulan_terakhir > 0 ? 'selected' : '' }}>
                                Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_riwayat_jatuh[]" id="skor_skrining_riwayat_jatuh_2"
                            class="form-control skor-skrining-input" max="6"
                            value="{{ $skriningResiko->jatuh_2_bulan_terakhir ?? 0 }}" readonly>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td rowspan="3" style="border: 1px solid black;">Status Mental</td>
                    <td style="border: 1px solid black; text-align:left;">Apakah pasien delirium? <br>(tidak dapat
                        membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)?</td>
                    <td rowspan="3" style="border: 1px solid black; text-align:left;">salah satu jawaban <br> Ya =
                        14</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_status_mental[]" class="form-control skrining-select"
                            data-input="skor_skrining_status_mental_1">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->delirium == 0 ? 'selected' : '' }}> Tidak
                            </option>
                            <option value="14"
                                {{ isset($skriningResiko) && $skriningResiko->delirium > 0 ? 'selected' : '' }}> Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_status_mental[]" id="skor_skrining_status_mental_1"
                            class="form-control skor-skrining-input" max="14"
                            value="{{ $skriningResiko->delirium ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">Apakah pasien disorientasi? <br>(salah
                        menyebutkan waktu, tempat atau orang)</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_status_mental[]" class="form-control skrining-select"
                            data-input="skor_skrining_status_mental_2">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->disorientasi == 0 ? 'selected' : '' }}> Tidak
                            </option>
                            <option value="14"
                                {{ isset($skriningResiko) && $skriningResiko->disorientasi > 0 ? 'selected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_status_mental[]" id="skor_skrining_status_mental_2"
                            class="form-control skor-skrining-input" max="14"
                            value="{{ $skriningResiko->disorientasi ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">Apakah pasien mengalami agitasi?
                        <br>(ketakutan, gelisah dan cemas)
                    </td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_status_mental[]" class="form-control skrining-select"
                            data-input="skor_skrining_status_mental_3">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->agitasi == 0 ? 'selected' : '' }}> Tidak</option>
                            <option value="14"
                                {{ isset($skriningResiko) && $skriningResiko->agitasi > 0 ? 'selected' : '' }}> Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_status_mental[]" id="skor_skrining_status_mental_3"
                            class="form-control skor-skrining-input" max="14"
                            value="{{ $skriningResiko->agitasi ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="3" style="border: 1px solid black;">Penglihatan</td>
                    <td style="border: 1px solid black; text-align:left;">apakah pasien memakai kacamata?</td>
                    <td rowspan="3" style="border: 1px solid black; text-align:left;">salah satu jawaban <br> Ya =
                        1</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_penglihatan[]" data-input="skringing_penglihatan_1"
                            class="form-control skrining-select">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->pakai_kacamata == 0 ? 'selected' : '' }}> Tidak
                            </option>
                            <option value="1"
                                {{ isset($skriningResiko) && $skriningResiko->pakai_kacamata > 0 ? 'selected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_penglihatan[]" id="skringing_penglihatan_1"
                            class="form-control skor-skrining-input" max="0"
                            value="{{ $skriningResiko->pakai_kacamata ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">apakah pasien mengeluh adanya penglihatan
                        buram?</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_penglihatan[]" data-input="skringing_penglihatan_2"
                            class="form-control skrining-select">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->penglihatan_buram == 0 ? 'selected' : '' }}>
                                Tidak</option>
                            <option value="1"
                                {{ isset($skriningResiko) && $skriningResiko->penglihatan_buram > 0 ? 'selected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_penglihatan[]" id="skringing_penglihatan_2"
                            class="form-control skor-skrining-input" max="0"
                            value="{{ $skriningResiko->penglihatan_buram ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">apakah pasien mengeluh glaukoma, katarak,
                        atau degenerasi makula?</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_penglihatan[]" data-input="skringing_penglihatan_3"
                            class="form-control skrining-select">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->keluhan_mata == 0 ? 'selected' : '' }}> Tidak
                            </option>
                            <option value="1"
                                {{ isset($skriningResiko) && $skriningResiko->keluhan_mata > 0 ? 'selected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_penglihatan[]" id="skringing_penglihatan_3"
                            class="form-control skor-skrining-input" max="0"
                            value="{{ $skriningResiko->keluhan_mata ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;">Kebiasaan Berkemih</td>
                    <td style="border: 1px solid black; text-align:left;">apakah terdapat perubahan perilaku berkemih?
                        <br>(frekuensi, urgensi, inkontinesia, nokturia)
                    </td>
                    <td style="border: 1px solid black; text-align:left;">Ya = 2</td>
                    <td style="border: 1px solid black;">
                        <select name="skrining_kebiasaan_berkemih[]" data-input="skor_skrining_kebiasaan_berkemih"
                            class="form-control skrining-select">
                            <option value="0"
                                {{ isset($skriningResiko) && $skriningResiko->perubahan_berkemih == 0 ? 'seelected' : '' }}>
                                Tidak</option>
                            <option value="2"
                                {{ isset($skriningResiko) && $skriningResiko->perubahan_berkemih > 0 ? 'seelected' : '' }}> Ya
                            </option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="skor_skrining_kebiasaan_berkemih[]"
                            id="skor_skrining_kebiasaan_berkemih" class="form-control skor-skrining-input"
                            max="0" value="{{ $skriningResiko->perubahan_berkemih ?? 0 }}" readonly>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="4" style="border: 1px solid black;">Transfer ( dari tempat tidur ke kursi dan
                        kembali ke tempat tidur)</td>
                    <td style="border: 1px solid black; text-align:left;">Mandiri (boleh menggunakan alat bantu jalan)
                    </td>
                    <td rowspan="4" style="border: 1px solid black; text-align:left;">jumlahkan nilai transfer dan
                        mobilitas. <br> jika nilai total 0-3 maka nilai skor = 0 <br> jika nilai total 4-6 maka skor = 7
                    </td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td rowspan="8">
                        <select name="transfer_mobilitas" id="transfer_mobilitas" class="form-control skrining-select skor-skrining-input">
                            <option value="0" {{ $skriningResiko?->transfer_mobilitas === 0 ? 'selected' : '' }}>0
                            </option>
                            <option value="7" {{ $skriningResiko?->transfer_mobilitas === 7 ? 'selected' : '' }}>7
                            </option>
                        </select>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">memerlukan sedikit bantuan (1 orang)/dalam
                        pengawasan</td>
                    <td style="border: 1px solid black;text-align:center;">1</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">memerlukan bantuan yang nyata (2 orang)</td>
                    <td style="border: 1px solid black;text-align:center;">2</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">tidak dapat duduk dengan seimbang, perlu
                        bantuan total</td>
                    <td style="border: 1px solid black;text-align:center;">3</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td rowspan="4" style="border: 1px solid black;">Mobilitas</td>
                    <td style="border: 1px solid black; text-align:left;">Mandiri (boleh menggunakan alat bantu jalan)
                    </td>
                    <td rowspan="4" style="border: 1px solid black; text-align:left;">mandiri (boleh menggunakan
                        alat bantu jalan)</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">berjalan dengan bantuan 1 orang(verbal/fisik)
                    </td>
                    <td style="border: 1px solid black;text-align:center;">1</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">menggunakan kursi roda</td>
                    <td style="border: 1px solid black;text-align:center;">2</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; text-align:left;">imobilisasi</td>
                    <td style="border: 1px solid black;text-align:center;">3</td>
                </tr>
                <tr>
                    <td colspan="3" class="mt-2">
                        <div class="icheck-primary d-inline ">
                            <input type="checkbox" id="risiko_jatuh_rendah" name="risiko_jatuh_rendah">
                            <label for="risiko_jatuh_rendah">Skor 0-5 risiko rendah jatuh </label>
                        </div> <br><br>
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="risiko_jatuh_sedang" name="risiko_jatuh_sedang">
                            <label for="risiko_jatuh_sedang">Skor 6-16 risiko jatuh sedang</label>
                        </div> <br><br>
                        <div class="icheck-primary d-inline ">
                            <input type="checkbox" id="risiko_jatuh_tinggi" name="risiko_jatuh_tinggi">
                            <label for="risiko_jatuh_tinggi">Skor 17-30 risiko jatuh tinggi</label>
                        </div>
                    </td>
                    <td colspan="2" class="mt-2 text-left">
                        <div class="form-group">
                            <label for="total_skor_skrining">Total Skor</label>
                            <input type="text" id="total_skor_skrining" name="total_skor_skrining"
                                value="{{ $skriningResiko->total_skor ?? 0 }}" class="form-control" readonly>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk menghitung total skor dan memperbarui checkbox
        function updateSkorAndCheckboxes() {
            let total = 0;
            const inputs = $('.skor-input');

            // Hitung total dari semua input
            inputs.each(function() {
                total += parseInt($(this).val()) || 0; // Menggunakan 0 jika input tidak valid

                // Membatasi input tidak melebihi nilai maksimum
                if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
                    $(this).val($(this).attr('max')); // Reset ke nilai maksimum jika input melebihi
                }
            });

            // Update total skor di input
            $('#total_skor').val(total);

            // Reset semua checkbox
            $('#pasien_tidak_beresiko').prop('checked', false);
            $('#pasien_risiko_tinggi').prop('checked', false);
            $('#pasien_risiko_sedang').prop('checked', false);

            // Cek nilai total skor dan centang checkbox sesuai kriteria
            if (total >= 0 && total <= 24) {
                $('#pasien_tidak_beresiko').prop('checked', true);
            } else if (total > 45) {
                $('#pasien_risiko_tinggi').prop('checked', true);
            } else if (total >= 25 && total <= 44) {
                $('#pasien_risiko_sedang').prop('checked', true);
            }
        }

        // Menambahkan event listener untuk setiap input
        $('.skor-input').on('input', function() {
            updateSkorAndCheckboxes(); // Hitung total dan update checkbox setiap kali input berubah
        });

        // Jalankan fungsi saat halaman dimuat
        updateSkorAndCheckboxes();
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Event listener untuk semua select
        $('.skrining-select').each(function() {
            $(this).on('change', function() {
                var inputId = $(this).data('input');
                var inputElement = $('#' + inputId);

                if (inputElement.length) {
                    // Set value input sesuai dengan pilihan
                    inputElement.val($(this).val());
                }

                // Panggil fungsi untuk menghitung total skor dan periksa checkbox
                calculateTotalScore();
            });
        });

        // Fungsi untuk menghitung total skor dan update checkbox
        function calculateTotalScore() {
            var totalScore = 0;

            // Loop semua input skor
            $('.skor-skrining-input').each(function() {
                var score = parseInt($(this).val()) || 0;
                totalScore += score;
            });

            // Update nilai total di input total_skor_skrining
            $('#total_skor_skrining').val(totalScore);

            // Reset semua checkbox
            $('#risiko_jatuh_rendah').prop('checked', false);
            $('#risiko_jatuh_sedang').prop('checked', false);
            $('#risiko_jatuh_tinggi').prop('checked', false);

            // Tentukan checkbox mana yang akan dicentang berdasarkan total skor
            if (totalScore >= 0 && totalScore <= 5) {
                $('#risiko_jatuh_rendah').prop('checked', true);
            } else if (totalScore >= 6 && totalScore <= 16) {
                $('#risiko_jatuh_sedang').prop('checked', true);
            } else if (totalScore >=
                17) { // Pastikan kondisi ini memeriksa skor lebih besar atau sama dengan 17
                $('#risiko_jatuh_tinggi').prop('checked', true);
            }
        }

        // Panggil fungsi perhitungan saat halaman pertama kali dimuat
        calculateTotalScore();
    });
</script>
