<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Rencana Pulang</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12 row mb-1">
                <div class="col-4">
                    <strong>Jenis Tempat tinggal pasien :</strong>
                    <input type="radio" name="jenis_tt" value="0" class="ml-2" {{$perencanaanPulang?->jenis_tt==0?'checked':''}}>
                    <label>Rumah</label>
                </div>
                <div class="col-2">
                    <input type="radio" name="jenis_tt" value="1" {{$perencanaanPulang?->jenis_tt===1?'checked':''}}>
                    <label>Kost</label>
                </div>
                <div class="col-2">
                    <input type="radio" name="jenis_tt" value="2" {{$perencanaanPulang?->jenis_tt===2?'checked':''}}>
                    <label>Apartemen</label>
                </div>
                <div class="col-4" style="text-align: center">
                    <input type="text" name="jenis_tt_lainya" class="form-control col-12" placeholder="masukan tempat lainnya...">
                </div>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; text-align:center;">No</th>
                    <th style="border: 1px solid black; text-align:center;">Kriteria Pulang</th>
                    <th style="border: 1px solid black; text-align:center;">Jawaban</th>
                    <th style="border: 1px solid black; text-align:center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black;">1.</td>
                    <td style="border: 1px solid black;">Usia diatas 70 tahun</td>
                    <td style="border: 1px solid black;">
                        <select name="usia_lbh_7" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->usia_lbh_7===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->usia_lbh_7===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_usia_lbh_70" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">2.</td>
                    <td style="border: 1px solid black;">Pasien tinggal sendiri</td>
                    <td style="border: 1px solid black;">
                        <select name="pasien_tinggal_sendiri" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->pasien_tinggal_sendiri===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->pasien_tinggal_sendiri===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_pasien_tinggal_sendiri" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">3.</td>
                    <td style="border: 1px solid black;">Tempat tinggal pasien memiliki tetangga</td>
                    <td style="border: 1px solid black;">
                        <select name="memiliki_tetangga" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->memiliki_tetangga===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->memiliki_tetangga===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_memiliki_tetangga" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">4.</td>
                    <td style="border: 1px solid black;">Memerlukan perawatan lanjutan dirumah</td>
                    <td style="border: 1px solid black;">
                        <select name="perawatan_lanjutan_dirumah" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->perawatan_lanjutan_dirumah===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->perawatan_lanjutan_dirumah===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_perawatan_lanjutan_dirumah" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">5.</td>
                    <td style="border: 1px solid black;">Mempunyai keterbatasan kemampuan merawat diri</td>
                    <td style="border: 1px solid black;">
                        <select name="keterbatasan_merawat_diri" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->keterbatasan_merawat_diri===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->keterbatasan_merawat_diri===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_keterbatasan_merawat_diri" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">6.</td>
                    <td style="border: 1px solid black;">Pasien pulang dengan jumlah obat lebih dari 6 jenis / macam
                        obat</td>
                    <td style="border: 1px solid black;">
                        <select name="lebih_6_jenis_obat" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->lebih_6_jenis_obat===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->lebih_6_jenis_obat===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_lebih_6_jenis_obat" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">7.</td>
                    <td style="border: 1px solid black;">Kesulitan mobilitas</td>
                    <td style="border: 1px solid black;">
                        <select name="kesulitan_mobilitas" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->kesulitan_mobilitas===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->kesulitan_mobilitas===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_kesulitan_mobilitas" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">8.</td>
                    <td style="border: 1px solid black;">Memerlukan alat bantu</td>
                    <td style="border: 1px solid black;">
                        <select name="memerlukan_alat_bantu" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->memerlukan_alat_bantu===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->memerlukan_alat_bantu===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_memerlukan_alat_bantu" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">9.</td>
                    <td style="border: 1px solid black;">Memerlukan pelayanan medis</td>
                    <td style="border: 1px solid black;">
                        <select name="memerlukan_pelayanan_medis" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->memerlukan_pelayanan_medis===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->memerlukan_pelayanan_medis===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_memerlukan_pelayanan_medis" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">10.</td>
                    <td style="border: 1px solid black;">Memerlukan pelayanan keperawatan</td>
                    <td style="border: 1px solid black;">
                        <select name="memerlukan_pelayanan_keperawatan" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->memerlukan_pelayanan_keperawatan===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->memerlukan_pelayanan_keperawatan===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_memerlukan_pelayanan_keperawatan" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">11.</td>
                    <td style="border: 1px solid black;">Memerlukan bantuan dalam kehidupan sehari-hari</td>
                    <td style="border: 1px solid black;">
                        <select name="memerlukan_bantuan_sehari_hari" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->memerlukan_bantuan_sehari_hari===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->memerlukan_bantuan_sehari_hari===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_memerlukan_bantuan_sehari_hari" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">12.</td>
                    <td style="border: 1px solid black;">Riwayat sering menggunakan fasilitasi gawat darurat</td>
                    <td style="border: 1px solid black;">
                        <select name="sering_menggunakan_fasilitas_igd" class="form-control" id="">
                            <option value="0" {{$perencanaanPulang?->sering_menggunakan_fasilitas_igd===0?'selected':''}}>TIDAK</option>
                            <option value="1" {{$perencanaanPulang?->sering_menggunakan_fasilitas_igd===1?'selected':''}}>Ya</option>
                        </select>
                    </td>
                    <td style="border: 1px solid black;">
                        <input type="text" name="ket_sering_menggunakan_fasilitas_igd" class="form-control">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
