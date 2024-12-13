<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Diagnostik dan Kebutuhan Edukasi</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h6><strong>Data Diagnostik</strong></h6>
                <div class="form-group">
                    <label for="Laboratiorium">Laboratorium</label>
                    <input type="text" name="diagnostik_laboratorium" 
                           value="{{ is_array($diagnostikEdukasi['diagnostik_laboratorium'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_laboratorium']) : ($diagnostikEdukasi['diagnostik_laboratorium'] ?? '') }}" 
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="Radiologi">Radiologi</label>
                    <input type="text" name="diagnostik_radiologi" 
                           value="{{ is_array($diagnostikEdukasi['diagnostik_radiologi'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_radiologi']) : ($diagnostikEdukasi['diagnostik_radiologi'] ?? '') }}" 
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="Lain-lain">Lain-lain</label>
                    <input type="text" name="diagnostik_lainya" 
                           value="{{ is_array($diagnostikEdukasi['diagnostik_lainya'] ?? null) ? implode(', ', $diagnostikEdukasi['diagnostik_lainya']) : ($diagnostikEdukasi['diagnostik_lainya'] ?? '') }}" 
                           class="form-control">
                </div>
                
            </div>
            <div class="col-6">
                <h6><strong>Kebutuhan Edukasi</strong></h6>
                <ol type="1" style="font-size: 13px;">
                    <li>
                        <div class="form-group">
                            <label for="tentang_penyakit">Apa yang saudara ketahui tentang penyakit saudara</label>
                            <input type="text" name="tentang_penyakit" class="form-control"  
                                   value="{{ is_array($diagnostikEdukasi['tentang_penyakit'] ?? null) ? implode(', ', $diagnostikEdukasi['tentang_penyakit']) : ($diagnostikEdukasi['tentang_penyakit'] ?? '') }}">
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                            <label for="informasi_yg_ingin_diketahui">Informasi apa yang ingin saudara ketahui / yang diperlukan</label>
                            <input type="text" name="informasi_yg_ingin_diketahui" class="form-control" 
                                   value="{{ is_array($diagnostikEdukasi['informasi_yg_ingin_diketahui'] ?? null) ? implode(', ', $diagnostikEdukasi['informasi_yg_ingin_diketahui']) : ($diagnostikEdukasi['informasi_yg_ingin_diketahui'] ?? '') }}">
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                            <label for="keluarga_terlibat_perawatan">Keluarga yang ikut terlibat dalam perawatan selanjutnya</label>
                            <input type="text" name="keluarga_terlibat_perawatan" class="form-control" 
                                   value="{{ is_array($diagnostikEdukasi['keluarga_terlibat_perawatan'] ?? null) ? implode(', ', $diagnostikEdukasi['keluarga_terlibat_perawatan']) : ($diagnostikEdukasi['keluarga_terlibat_perawatan'] ?? '') }}">
                        </div>
                    </li>
                </ol>
                
            </div>
        </div>
    </div>
</div>
