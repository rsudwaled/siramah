<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Asesmen Fungsional (Barthel Index)</h3>
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
                    <th style="border: 1px solid black; text-align:center;">No</th>
                    <th style="border: 1px solid black; text-align:center;">Fungsi</th>
                    <th style="border: 1px solid black; text-align:center;">Skor</th>
                    <th style="border: 1px solid black; text-align:center;">Keterangan</th>
                    <th style="border: 1px solid black; text-align:center;">Skor Pasien</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">1.</td>
                    <td rowspan="3" style="border: 1px solid black;">Mengendalikan Rangsang Defeksi</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak terkendali/tak teratur (perlu bantuan)
                    </td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_rangsang_defeksi"
                            value="{{ $skriningFungsional?->skor_af_rangsang_defeksi ?? '' }}"
                            class="form-control skor-input-af" max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Kadang-kadang tak terkendali</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">2.</td>
                    <td rowspan="3" style="border: 1px solid black;">Mengendalikan Rangsang Berkemih</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tak terkendali / pakai kateter</td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_rangsang_berkemih"
                            value="{{ $skriningFungsional?->skor_af_rangsang_berkemih ?? '' }}"
                            class="form-control skor-input-af" max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Kadang-kadang tak terkendali (1x24jam)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="2" style="border: 1px solid black; text-align:center;">3.</td>
                    <td rowspan="2" style="border: 1px solid black;">Membersihkan Diri (seka muka, sisir rambut,
                        sikat gigi)</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Butuh pertolongan orang lain</td>
                    <td rowspan="2" style="border: 1px solid black;">
                        <input type="number" name="skor_af_membersihkan_diri"
                            value="{{ $skriningFungsional?->skor_af_membersihkan_diri ?? '' }}"
                            class="form-control skor-input-af" max="1">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">4.</td>
                    <td rowspan="3" style="border: 1px solid black;">Penggunaan Jamban, Masuk dan Keluar</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tergantung pertolongan orang lain</td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_penggunaan_jamban"
                            value="{{ $skriningFungsional?->skor_af_penggunaan_jamban ?? '' }}"
                            class="form-control skor-input-af" max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Perlu pertolongan pada beberapa kegiatan
                        terapi, dapat mengerjakan sendiri kegiatan lain</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">5.</td>
                    <td rowspan="3" style="border: 1px solid black;">Makan</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak Mampu</td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_makan"
                            value="{{ $skriningFungsional?->skor_af_makan ?? '' }}" class="form-control skor-input-af"
                            max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Perlu ditolong memotong makanan</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="4" style="border: 1px solid black; text-align:center;">6.</td>
                    <td rowspan="4" style="border: 1px solid black;">Berubah sikap dari berbaring ke duduk</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak Mampu</td>
                    <td rowspan="4" style="border: 1px solid black;">
                        <input type="number" name="skor_af_berubah_sikap"
                            value="{{ $skriningFungsional?->skor_af_berubah_sikap ?? '' }}"
                            class="form-control skor-input-af" max="3">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Perlu banyak bantuan untuk bisa
                        duduk(2orang)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Bantuan minimal(2orang)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">3</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="4" style="border: 1px solid black; text-align:center;">7.</td>
                    <td rowspan="4" style="border: 1px solid black;">Berpindah/berjalan</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak Mampu</td>
                    <td rowspan="4" style="border: 1px solid black;">
                        <input type="number" name="skor_af_berpindah_berjalan"
                            value="{{ $skriningFungsional?->skor_af_berpindah_berjalan ?? '' }}"
                            class="form-control skor-input-af" max="3">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Bisa (pindah) dengan kursi</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Berjalan dengan bantuan 1 orang</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">3</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">8.</td>
                    <td rowspan="3" style="border: 1px solid black;">Memakai baju</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tergantung oranglain</td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_memakai_baju"
                            value="{{ $skriningFungsional?->skor_af_memakai_baju ?? '' }}"
                            class="form-control skor-input-af" max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Sebagian dibantu(misalnya mengancingkan
                        baju)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="3" style="border: 1px solid black; text-align:center;">9.</td>
                    <td rowspan="3" style="border: 1px solid black;">Naik Turun Tangga</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tidak Mampu</td>
                    <td rowspan="3" style="border: 1px solid black;">
                        <input type="number" name="skor_af_naik_tangga"
                            value="{{ $skriningFungsional?->skor_af_naik_tangga ?? '' }}"
                            class="form-control skor-input-af" max="2">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Butuh pertolongan oranglain</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">2</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td rowspan="2" style="border: 1px solid black; text-align:center;">10.</td>
                    <td rowspan="2" style="border: 1px solid black;">Mandi</td>
                    <td style="border: 1px solid black; text-align:center;">0</td>
                    <td style="border: 1px solid black; text-align:center;">Tergantung</td>
                    <td rowspan="2" style="border: 1px solid black;">
                        <input type="number" name="skor_af_mandi"
                            value="{{ $skriningFungsional?->skor_af_mandi ?? '' }}" class="form-control skor-input-af"
                            max="1">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align:center;">1</td>
                    <td style="border: 1px solid black; text-align:center;">Mandiri</td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 1px solid black; text-align:right;">
                        <strong>Total Skor :</strong>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="number" name="total_skor_af"
                            value="{{ $skriningFungsional?->total_skor_af ?? '' }}" id="total_skor_af"
                            class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid black;">
                        <div class="row mt-1">
                            <div class="col-5 ml-1">
                                <div>
                                    <input type="radio" name="skor_total_af" id="skor_total_af_20" value="20">
                                    <label for="skor_total_af_20">Skor 20: Mandiri</label>
                                </div>
                                <div>
                                    <input type="radio" name="skor_total_af" id="skor_total_af_9_11"
                                        value="9-11">
                                    <label for="skor_total_af_9_11">Skor 9-11: Ketergantungan Sedang</label>
                                </div>
                                <div>
                                    <input type="radio" name="skor_total_af" id="skor_total_af_0_4"
                                        value="0-4">
                                    <label for="skor_total_af_0_4">Skor 0-4: Ketergantungan Total</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div>
                                    <input type="radio" name="skor_total_af" id="skor_total_af_12_19"
                                        value="12-19">
                                    <label for="skor_total_af_12_19">Skor 12-19: Ketergantungan Ringan</label>
                                </div>
                                <div>
                                    <input type="radio" name="skor_total_af" id="skor_total_af_5_8"
                                        value="5-8">
                                    <label for="skor_total_af_5_8">Skor 5-8: Ketergantungan Berat</label>
                                </div>
                            </div>
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
    // Fungsi untuk menghitung total skor
    function hitungTotalSkor() {
        let totalSkorAF = 0;

        // Mendapatkan semua input yang memiliki kelas skor-input-af
        $('.skor-input-af').each(function() {
            let nilai = parseInt($(this).val()) || 0; // Jika kosong, anggap 0
            totalSkorAF += nilai;
        });

        // Menampilkan hasil di input total_skor_af
        $('#total_skor_af').val(totalSkorAF);

        // Reset semua radio button terlebih dahulu
        $('input[name="skor_total_af"]').prop('checked', false);

        // Memilih radio button sesuai dengan rentang skor total
        if (totalSkorAF === 20) {
            $('#skor_total_af_20').prop('checked', true);
        } else if (totalSkorAF >= 12 && totalSkorAF <= 19) {
            $('#skor_total_af_12_19').prop('checked', true);
        } else if (totalSkorAF >= 9 && totalSkorAF <= 11) {
            $('#skor_total_af_9_11').prop('checked', true);
        } else if (totalSkorAF >= 5 && totalSkorAF <= 8) {
            $('#skor_total_af_5_8').prop('checked', true);
        } else if (totalSkorAF >= 0 && totalSkorAF <= 4) {
            $('#skor_total_af_0_4').prop('checked', true);
        }
    }

    // Validasi input saat pengguna memasukkan nilai
    $('.skor-input-af').on('input', function() {
        let nilai = parseInt($(this).val());
        let max = parseInt($(this).attr('max'));

        // Jika nilai lebih dari maksimum, set kembali ke maksimum
        if (nilai > max) {
            $(this).val(max);
        } else if (nilai < 0) {
            // Pastikan nilai tidak negatif
            $(this).val(0);
        }

        // Panggil fungsi untuk menghitung total skor setelah validasi
        hitungTotalSkor();
    });

    // Hitung total skor saat halaman dimuat
    hitungTotalSkor();
});

</script>
