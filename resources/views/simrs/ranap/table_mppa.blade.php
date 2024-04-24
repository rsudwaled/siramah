@if ($kunjungan->erm_ranap_mppa)
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <tr style="background-color: #ffc107">
            <td width="100%" colspan="2" class="text-center">
                <b>EVALUASI AWAL MPP (FORM A)</b><br>
                <i>Diisi oleh Case Manager</i>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2">
                <b>Tanggal </b> :
                {{ \Carbon\Carbon::parse($kunjungan->erm_ranap_mppa->created_at)->format('d F Y h:m:s') }}
                <br>
                <b>Catatan </b> : {{ $kunjungan->erm_ranap_mppa->catatan }} <br>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <b>1. Identifikasi / skrining pasien terdapat jawaban </b><br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->skiring ?? '.........' }}</span><br>
                <b>2. Assesmen Meliputi</b> <br>
                <b>a. Fisik, fungsional, kekuatan / kemampuan / kemandirian</b><br>
                @if ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Penuh')
                    <span class="unicode">&#x2611;</span> Mandiri Penuh
                @else
                    <span class="unicode">&#x2610;</span> Mandiri Penuh
                @endif
                @if ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Sebagian')
                    <span class="unicode">&#x2611;</span> Mandiri Sebagian
                @else
                    <span class="unicode">&#x2610;</span> Mandiri Sebagian
                @endif <br>
                @if ($kunjungan->erm_ranap_mppa->kemampuan == 'Total Bantuan')
                    <span class="unicode">&#x2611;</span> Total Bantuan
                @else
                    <span class="unicode">&#x2610;</span> Total Bantuan
                @endif
                @if ($kunjungan->erm_ranap_mppa->kemampuan_text)
                    <span class="unicode">&#x2611;</span> {{ $kunjungan->erm_ranap_mppa->kemampuan_text }}
                @else
                    <span class="unicode">&#x2610;</span> .............
                @endif
                <br>
                <b>b. Riwayat Kesehatan</b> <br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->riwayat_kesehatan ?? '.........' }}</span><br>
                <b>c. Perilaku psiko-spiritual-sosio-kultural</b><br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->psikologi ?? '.........' }}</span><br>
                <b>d. Kesehatan mental dan kognitif</b><br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->mental ?? '.........' }}</span><br>
                <b>e. Lingkungan tempat tinggal</b><br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->lingkungan ?? '.........' }}</span><br>
                <b>f. Dukungan keluarga, kemampuan merawat dari pemberi asuhan</b><br>
                @if ($kunjungan->erm_ranap_mppa->dukungan == 'Ya')
                    <span class="unicode">&#x2611;</span> Ya
                @else
                    <span class="unicode">&#x2610;</span> Ya
                @endif
                @if ($kunjungan->erm_ranap_mppa->dukungan == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif <br>
                <b>g. Finansial</b>
                @if ($kunjungan->erm_ranap_mppa->finansial == 'Baik')
                    <span class="unicode">&#x2611;</span> Baik
                @else
                    <span class="unicode">&#x2610;</span> Baik
                @endif
                @if ($kunjungan->erm_ranap_mppa->finansial == 'Sedang')
                    <span class="unicode">&#x2611;</span> Sedang
                @else
                    <span class="unicode">&#x2610;</span> Sedang
                @endif
                @if ($kunjungan->erm_ranap_mppa->finansial == 'Buruk')
                    <span class="unicode">&#x2611;</span> Buruk
                @else
                    <span class="unicode">&#x2610;</span> Buruk
                @endif
                <b> Jaminan</b>
                @if ($kunjungan->erm_ranap_mppa->jaminan == 'Pribadi')
                    <span class="unicode">&#x2611;</span> Pribadi
                @else
                    <span class="unicode">&#x2610;</span> Pribadi
                @endif
                @if ($kunjungan->erm_ranap_mppa->jaminan == 'Asuransi')
                    <span class="unicode">&#x2611;</span> Asuransi
                @else
                    <span class="unicode">&#x2610;</span> Asuransi
                @endif
                @if ($kunjungan->erm_ranap_mppa->jaminan == 'JKN / BPJS')
                    <span class="unicode">&#x2611;</span> JKN / BPJS
                @else
                    <span class="unicode">&#x2610;</span> JKN / BPJS
                @endif <br>
                <b>h. Riwayat Pengobatan Alternatif</b>
                @if ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif
                @if ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Ya')
                    <span class="unicode">&#x2611;</span> Ya
                @else
                    <span class="unicode">&#x2610;</span> Ya
                @endif <br>
                <b>i. Riwayat Trauma / Kekerasan</b>
                @if ($kunjungan->erm_ranap_mppa->trauma == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif
                @if ($kunjungan->erm_ranap_mppa->trauma == 'Ada')
                    <span class="unicode">&#x2611;</span> Ada
                @else
                    <span class="unicode">&#x2610;</span> Ada
                @endif <br>
                <b>j. Pemahaman Tentang Kesehatan</b>
                @if ($kunjungan->erm_ranap_mppa->paham == 'Tidak Tahu')
                    <span class="unicode">&#x2611;</span> Tidak Tahu
                @else
                    <span class="unicode">&#x2610;</span> Tidak Tahu
                @endif
                @if ($kunjungan->erm_ranap_mppa->paham == 'Tahu')
                    <span class="unicode">&#x2611;</span> Tahu
                @else
                    <span class="unicode">&#x2610;</span> Tahu
                @endif <br>
                <b>k. Harapan terhadap hasil asuhan, kemampuan menerima perubahan</b>
                @if ($kunjungan->erm_ranap_mppa->harapan == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif
                @if ($kunjungan->erm_ranap_mppa->harapan == 'Ada')
                    <span class="unicode">&#x2611;</span> Ada
                @else
                    <span class="unicode">&#x2610;</span> Ada
                @endif <br>
                <b>l. Perkiraan Lama Ranap (Hari) ? </b> {{ $kunjungan->erm_ranap_mppa->perkiraan_inap ?? '.........' }}
                hari<br>
                <b>m. Discharge Plan </b>
                @if ($kunjungan->erm_ranap_mppa->discharge_plan == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif
                @if ($kunjungan->erm_ranap_mppa->discharge_plan == 'Ada')
                    <span class="unicode">&#x2611;</span> Ada
                @else
                    <span class="unicode">&#x2610;</span> Ada
                @endif <br>
                <b>n. Perencanaan Lanjutan </b> <br>
                @if ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Home Care')
                    <span class="unicode">&#x2611;</span> Home Care
                @else
                    <span class="unicode">&#x2610;</span> Home Care
                @endif
                @if ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Rujuk')
                    <span class="unicode">&#x2611;</span> Rujuk
                @else
                    <span class="unicode">&#x2610;</span> Rujuk
                @endif
                @if ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Pengobatan/Perawatan')
                    <span class="unicode">&#x2611;</span> Pengobatan/Perawatan
                @else
                    <span class="unicode">&#x2610;</span> Pengobatan/Perawatan
                @endif
                @if ($kunjungan->erm_ranap_mppa->rencana_lanjutan == 'Komunitas')
                    <span class="unicode">&#x2611;</span> Komunitas
                @else
                    <span class="unicode">&#x2610;</span> Komunitas
                @endif <br>
                <b>o. Aspek Legal </b>
                @if ($kunjungan->erm_ranap_mppa->legalitas == 'Tidak')
                    <span class="unicode">&#x2611;</span> Tidak
                @else
                    <span class="unicode">&#x2610;</span> Tidak
                @endif
                @if ($kunjungan->erm_ranap_mppa->legalitas == 'Ada')
                    <span class="unicode">&#x2611;</span> Ada
                @else
                    <span class="unicode">&#x2610;</span> Ada
                @endif <br>
            </td>
            <td width="50%">
                <b>3. Identifikasi Masalah - Resiko - Kesempatan </b> <br>
                {{-- @if (in_array('Tidak sesuai dengan CP / PPK', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Tidak sesuai dengan CP / PPK
            @else
                &#x25A2; Tidak sesuai dengan CP / PPK
            @endif <br>
            @if (in_array('Adanya Komplikasi', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Adanya Komplikasi
            @else
                &#x25A2; Adanya Komplikasi
            @endif <br>
            @if (in_array('Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan
            @else
                &#x25A2; Pemahaman pasien kurang tentang penyakit, kondisi terkini, obat-obatan
            @endif <br>
            @if (in_array('Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat
            @else
                &#x25A2; Ketidakpatuhan pasien kendala keuangan ketika keparahan / komplikasi meningkat
            @endif <br>
            @if (in_array('Terjadi Konflik', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Terjadi Konflik
            @else
                &#x25A2; Terjadi Konflik
            @endif <br>
            @if (in_array('Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda
            @else
                &#x25A2; Pemulangan / rujukan belum memenuhi kriteria / sebaliknya / ditunda
            @endif <br>
            @if (in_array('Tindakan / pengobatan yang tertunda / dibatalkan', json_decode($kunjungan->erm_ranap_mppa->identifisikasimasalah)))
                &#x1F5F9; Tindakan / pengobatan yang tertunda / dibatalkan
            @else
                &#x25A2; Tindakan / pengobatan yang tertunda / dibatalkan
            @endif <br> --}}
                <b>4. Perencanaan MPP </b> <br>
                {{-- @if (in_array('Kebutuhan asuhan', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                &#x1F5F9; Kebutuhan asuhan
            @else
                &#x25A2; Kebutuhan asuhan
            @endif <br>
            @if (in_array('Kebutuhan edukasi', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                &#x1F5F9; Kebutuhan edukasi
            @else
                &#x25A2; Kebutuhan edukasi
            @endif <br>
            @if (in_array('Solusi konflik', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                &#x1F5F9; Solusi konflik
            @else
                &#x25A2; Solusi konflik
            @endif <br>
            @if (in_array('Diagnosis', json_decode($kunjungan->erm_ranap_mppa->rencana_mpp)))
                &#x1F5F9; Diagnosis
            @else
                &#x25A2; Diagnosis
            @endif <br> --}}
                <b>Jangka Pendek</b> <br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->jangka_pendek ?? '.........' }}</span><br>
                <b>Jangka Panjang</b> <br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->jangka_panjang ?? '.........' }}</span><br>
                <b>Kebutuhan Berjalan</b> <br>
                <span
                    style="color: blue">{{ $kunjungan->erm_ranap_mppa->kebutuhan_berjalan ?? '.........' }}</span><br>
                <b>Lain-lain</b> <br>
                <span style="color: blue">{{ $kunjungan->erm_ranap_mppa->lain_lain ?? '.........' }}</span><br>
            </td>
        </tr>
    </table>
    <table class="table table-sm" style="font-size: 11px">
        <tr>
            <td width="70%"></td>
            <td width="30%">
                <center>
                    Waled, {{ \Carbon\Carbon::parse($kunjungan->erm_ranap_mppa->created_at)->format('d F Y') }}
                    <br>
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg=="
                        alt="Red dot" />
                    {{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} "> --}}
                    <br><br><br><br>
                    <b><u>{{ $kunjungan->erm_ranap_mppa->pic }}</u></b>
                </center>
            </td>
        </tr>
    </table>
@else
    <table class="table table-sm table-bordered" style="font-size: 11px">
        <tr style="background-color: #ffc107">
            <td width="100%" colspan="2" class="text-center">
                <b>EVALUASI AWAL MPP (FORM A)</b><br>
                <i>Diisi oleh Case Manager</i>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2" class="text-center">
                <b>Belum Diisi</b><br>
            </td>
        </tr>
    </table>
@endif
