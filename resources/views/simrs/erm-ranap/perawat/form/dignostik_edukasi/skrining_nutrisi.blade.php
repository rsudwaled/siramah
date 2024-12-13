<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Skrining Nutrisi</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 10px;">No</th>
                    <th style="border: 1px solid black; padding: 10px;">Parameter</th>
                    <th style="border: 1px solid black; padding: 10px;">Nilai</th>
                    <th style="border: 1px solid black; padding: 10px;">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="10" style="border: 1px solid black; padding: 10px;">1</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">Apakah Pasien mengalami penurunan berat badan
                        yang tidak direncanakan?</td>
                    <td style="border: 1px solid black; padding: 10px;"></td>
                    <td style="border: 1px solid black; padding: 10px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="checkbox" class="nilai-checkbox" data-skor="0" name="tidak_terjadi_penurunan"
                            {{ $skriningNutrisi?->tidak_terjadi_penurunan != null ? 'checked' : '' }}>
                        <label>Tidak (tidak terjadi penurunan dalam 6 bulan terakhir)</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">0</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->tidak_terjadi_penurunan != null?$skriningNutrisi->tidak_terjadi_penurunan:'' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="checkbox" class="nilai-checkbox" data-skor="2" name="tidak_yakin_penurunan"
                            {{ $skriningNutrisi?->tidak_yakin_turun != null ? 'checked' : '' }}>
                        <label>Tidak Yakin (tanyakan apakah baju/celana terasa longgar)</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">2</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->tidak_yakin_turun != null?$skriningNutrisi->tidak_yakin_turun:'' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="checkbox" id="ya_penurunan_bb" name="ya_penurunan_bb"
                            {{ $skriningNutrisi?->penurunan_bb > 0 ? 'checked' : '' }}>
                        <label for="ya_penurunan_bb">Ya, berapakah penurunan berat badan tersebut?</label>
                    </td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="radio" name="penurunan_bb" value="1" class="nilai-radio" data-skor="1"
                            {{ $skriningNutrisi?->penurunan_bb == 1 ? 'checked' : '' }}>
                        <label>1 - 5 Kg</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">1</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" name="skor_penurunan_bb_1_5"
                            value="{{ $skriningNutrisi?->skor_penurunan_1_5 ?? '' }}"
                            class="form-control skor-input-skrining" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="radio" name="penurunan_bb" value="2" class="nilai-radio" data-skor="2"
                            {{ $skriningNutrisi?->penurunan_6_10 === 2 ? 'checked' : '' }}>
                        <label>6 - 10 Kg</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">2</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" name="skor_penurunan_bb_6_10" class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->skor_penurunan_6_10 ?? '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="radio" name="penurunan_bb" value="3" class="nilai-radio" data-skor="3"
                            {{ $skriningNutrisi?->penurunan_bb == 3 ? 'checked' : '' }}>
                        <label>11 - 15 Kg</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">3</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" name="skor_penurunan_bb_11_15"
                            value="{{ $skriningNutrisi?->skor_penurunan_11_15 ?? '' }}"
                            class="form-control skor-input-skrining" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="radio" name="penurunan_bb" value="4" class="nilai-radio" data-skor="4"
                            {{ $skriningNutrisi?->penurunan_bb == 4 ? 'checked' : '' }}>
                        <label>Lebih dari 15 Kg</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">4</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" name="skor_penurunan_bb_lbh_15"
                            value="{{ $skriningNutrisi?->skor_penurunan_lbh_15 ?? '' }}"
                            class="form-control skor-input-skrining" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="radio" name="penurunan_bb" class="nilai-radio" data-skor="2"
                            {{ $skriningNutrisi?->penurunan_tidak_yakin == 2 ? 'checked' : '' }}>
                        <label>Tidak Yakin</label>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">2</td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <input type="text" name="skor_penurunan_bb_tidak_yakin"
                            class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->penurunan_tidak_yakin == 2 ? $skriningNutrisi?->penurunan_tidak_yakin : '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td rowspan="4" style="border: 1px solid black;padding:10px;">2</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">Apakah asupan makan pasien buruk akibat nafsu
                        makan yang menurun**? (misalnya asupan makan 3/4 dari biasasanya)</td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="radio" id="asupan_makan_buruk_tidak" class="nilai-radio"
                            {{ isset($skriningNutrisi) && $skriningNutrisi->nafsu_makan_buruk == 0 ? 'checked' : '' }}
                            name="asupan_makan_buruk" data-skor="0" value="0">
                        <label for="asupan_makan_buruk_tidak">Tidak</label>
                    </td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="text" name="skor_asupan_makan_buruk_tidak"
                            class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->nafsu_makan_buruk === 0 ? '0' : '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="radio" id="asupan_makan_buruk_ya" class="nilai-radio"
                            {{ isset($skriningNutrisi) && $skriningNutrisi->nafsu_makan_buruk == 1 ? 'checked' : '' }}
                            name="asupan_makan_buruk" data-skor="1" value="1">
                        <label for="asupan_makan_buruk_ya">Ya</label>
                    </td>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="text" name="skor_asupan_makan_buruk_ya"
                            class="form-control skor-input-skrining"
                            value="{{ $skriningNutrisi?->nafsu_makan_buruk === 1 ? '1' : '' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td rowspan="4" style="border: 1px solid black;padding:10px;">3</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">Sakit Berat **</td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="radio" id="sakit_berat_tidak" value="0" name="sakit_berat"
                            {{ isset($skriningNutrisi) && $skriningNutrisi->sakit_berat == 0 ? 'checked' : '' }}>
                        <label for="sakit_berat_tidak">Tidak</label>
                    </td>
                    <td style="border: 1px solid black; text-align:center;">-</td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">
                        <input type="radio" id="sakit_berat_ya" name="sakit_berat" value="1"
                            {{ isset($skriningNutrisi) && $skriningNutrisi->sakit_berat == 1 ? 'checked' : '' }}>
                        <label for="sakit_berat_ya">Ya</label>
                    </td>
                    <td style="border: 1px solid black; text-align:center;">-</td>
                    <td style="border: 1px solid black; padding:10px;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; border: 1px solid black; padding: 10px;">
                        <strong>Total Skor</strong>
                    </td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center;">
                        <input type="text" name="total_skor_skrining_nutrisi" id="total_skor_skrining_nutrisi"
                            class="form-control" value="{{ $skriningNutrisi?->total_skor_skrining_nutrisi ?? '' }}"
                            readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 1px solid black; text-align:left;">
                        <div class="row">
                            <div class="col-6">
                                <div class="col-12">Kesimpulan dan tindak lanjut :</div>
                                <div class="col-12">
                                    <input type="checkbox" class="kesimpulan-skor" name="kesimpulan_skor_lbh_2"
                                        id="kesimpulan_skor_lbh_2">
                                    <label>Total Skor > 2, rujuk ke diestisien untuk asesmen</label>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <input type="checkbox" class="kesimpulan-skor" name="kesimpulan_skor_krg_2"
                                    id="kesimpulan_skor_krg_2">
                                <label>Total Skor < 2, skrining ulang 7 hari</label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Update skor input when checkbox is checked/unchecked
        $('.nilai-checkbox').change(function() {
            const skor = $(this).data('skor');
            const inputSkor = $(this).closest('tr').find('.skor-input-skrining');

            if ($(this).is(':checked')) {
                inputSkor.val(skor);
            } else {
                inputSkor.val('');
            }
            updateTotalSkor();
        });

        // Update skor input when radio is selected
        $('.nilai-radio').change(function() {
            const skor = $(this).data('skor');
            const inputSkor = $(this).closest('tr').find('.skor-input-skrining');

            // Clear only skor inputs associated with the current group of radio buttons
            $(this).closest('table')
                .find(`input[name="${$(this).attr('name')}"]`).closest('tr').find(
                    '.skor-input-skrining').val(
                    '');

            // Set the selected radio button's skor input
            inputSkor.val(skor);

            updateTotalSkor();
        });

        // Function to update the total skor
        function updateTotalSkor() {
            let total = 0;
            $('.skor-input-skrining').each(function() {
                const nilai = parseInt($(this).val()) || 0;
                total += nilai;
            });
            $('input[name="total_skor_skrining_nutrisi"]').val(total);
            updateKesimpulan(total);
        }

        function updateKesimpulan(skorTotal) {
            var skorTotal = $('#total_skor_skrining_nutrisi').val();
            console.info(parseFloat(skorTotal));
            if (parseFloat(skorTotal) <= 2) {
                $('#kesimpulan_skor_lbh_2').prop('checked', false); // Atur checkbox menjadi checked
                $('#kesimpulan_skor_krg_2').prop('checked', true); // Atur checkbox menjadi checked
            } else {
                $('#kesimpulan_skor_krg_2').prop('checked', false); // Atur checkbox menjadi unchecked
                $('#kesimpulan_skor_lbh_2').prop('checked', true); // Atur checkbox menjadi unchecked
            }
        }

        updateTotalSkor();
    });
</script>
