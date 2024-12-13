<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Psikososial dan Budaya</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Ekspresi wajah :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="ekspresi_wajah_cerah" name="ekspresi_wajah[]" value="Cerah"
                            {{ in_array('Cerah', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_cerah">Cerah</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ekspresi_wajah_tenang" name="ekspresi_wajah[]" value="Tenang"
                            {{ in_array('Tenang', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_tenang">Tenang</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ekspresi_wajah_murung" name="ekspresi_wajah[]" value="Murung"
                            {{ in_array('Murung', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_murung">Murung</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ekspresi_wajah_cemas" name="ekspresi_wajah[]" value="Cemas"
                            {{ in_array('Cemas', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_cemas">Cemas</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ekspresi_wajah_takut" name="ekspresi_wajah[]" value="Takut"
                            {{ in_array('Takut', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_takut">Ketakutan</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ekspresi_wajah_panik" name="ekspresi_wajah[]" value="Panik"
                            {{ in_array('Panik', $sistemPsikobudaya['ekspresi_wajah'] ?? []) ? 'checked' : '' }}>
                        <label for="ekspresi_wajah_panik">Panik</label>
                    </div>
                </div>
            </li>
            <li>
                Kemampuan Bicara :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="kemampuan_bicara_psiko_sosbud_baik" name="kemampuan_bicara_psiko_sosbud[]" value="Baik"
                            {{ in_array('Baik', $sistemPsikobudaya['kemampuan_bicara_psiko_sosbud'] ?? []) ? 'checked' : '' }}>
                        <label for="kemampuan_bicara_psiko_sosbud_baik">Baik</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kemampuan_bicara_psiko_sosbud_tidak_bicara" name="kemampuan_bicara_psiko_sosbud[]" value="tidak_dapat_bicara"
                            {{ in_array('tidak_dapat_bicara', $sistemPsikobudaya['kemampuan_bicara_psiko_sosbud'] ?? []) ? 'checked' : '' }}>
                        <label for="kemampuan_bicara_psiko_sosbud_tidak_bicara">Tidak Dapat Bicara</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kemampuan_bicara_psiko_sosbud_tidak_kontak" name="kemampuan_bicara_psiko_sosbud[]" value="Tidak_kontak_mata"
                            {{ in_array('Tidak_kontak_mata', $sistemPsikobudaya['kemampuan_bicara_psiko_sosbud'] ?? []) ? 'checked' : '' }}>
                        <label for="kemampuan_bicara_psiko_sosbud_tidak_kontak">Tidak Mau Kontak Mata</label>
                    </div>
                </div>
            </li>
            <li>
                Koping Mekanisme :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="koping_selesaikan_sendiri" name="koping_mekanisme[]" value="selesaikan_sendiri"
                            {{ in_array('selesaikan_sendiri', $sistemPsikobudaya['koping_mekanisme'] ?? []) ? 'checked' : '' }}>
                        <label for="koping_selesaikan_sendiri">Menyelesaikan Masalah Sendiri</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="koping_selalu_dibantu" name="koping_mekanisme[]" value="selalu_dibantu"
                            {{ in_array('selalu_dibantu', $sistemPsikobudaya['koping_mekanisme'] ?? []) ? 'checked' : '' }}>
                        <label for="koping_selalu_dibantu">Selalu dibantu bila ada masalah</label>
                    </div>
                </div>
            </li>
            <li>
                Pekerjaan :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="pekerjaan_wiraswasta" name="pekerjaan[]" value="wiraswasta"
                            {{ in_array('wiraswasta', $sistemPsikobudaya['pekerjaan'] ?? []) ? 'checked' : '' }}>
                        <label for="pekerjaan_wiraswasta">Wiraswasta</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pekerjaan_swasta" name="pekerjaan[]" value="pegawai_swasta"
                            {{ in_array('pegawai_swasta', $sistemPsikobudaya['pekerjaan'] ?? []) ? 'checked' : '' }}>
                        <label for="pekerjaan_swasta">Pegawai Swasta</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pekerjaan_pensiunan" name="pekerjaan[]" value="pensiunan"
                            {{ in_array('pensiunan', $sistemPsikobudaya['pekerjaan'] ?? []) ? 'checked' : '' }}>
                        <label for="pekerjaan_pensiunan">Pensiunan</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pekerjaan_pns_polri" name="pekerjaan[]" value="pns_polri"
                            {{ in_array('pns_polri', $sistemPsikobudaya['pekerjaan'] ?? []) ? 'checked' : '' }}>
                        <label for="pekerjaan_pns_polri">PNS/TNI/POLRI</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pekerjaan_lain" name="pekerjaan[]" value="lain_lain"
                            {{ in_array('lain_lain', $sistemPsikobudaya['pekerjaan'] ?? []) ? 'checked' : '' }}>
                        <label for="pekerjaan_lain">lain-lain</label>
                    </div>
                </div>
            </li>
            <li>
                Tinggal Bersama :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="tinggal_bersama_suami_istri" name="tinggal_bersama[]" value="suami_istri"
                            {{ in_array('suami_istri', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_suami_istri">Suami/Istri</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="tinggal_bersama_orangtua" name="tinggal_bersama[]" value="orangtua"
                            {{ in_array('orangtua', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_orangtua">Orangtua</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="tinggal_bersama_anak" name="tinggal_bersama[]" value="anak"
                            {{ in_array('anak', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_anak">Anak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="tinggal_bersama_teman" name="tinggal_bersama[]" value="teman"
                            {{ in_array('teman', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_teman">Teman</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="tinggal_bersama_sendiri" name="tinggal_bersama[]" value="sendiri"
                            {{ in_array('sendiri', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_sendiri">Sendiri</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="tinggal_bersama_lainya" name="tinggal_bersama[]" value="lain_lain"
                            {{ in_array('lain_lain', $sistemPsikobudaya['tinggal_bersama'] ?? []) ? 'checked' : '' }}>
                        <label for="tinggal_bersama_lainya">Lain-lain</label>
                    </div>
                </div>
            </li>
            <li>
                Suku :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="suku_jawa" name="suku[]" value="jawa"
                            {{ in_array('jawa', $sistemPsikobudaya['suku'] ?? []) ? 'checked' : '' }}>
                        <label for="suku_jawa">Jawa</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="suku_sunda" name="suku[]" value="sunda"
                            {{ in_array('sunda', $sistemPsikobudaya['suku'] ?? []) ? 'checked' : '' }}>
                        <label for="suku_sunda">Sunda</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="suku_batak" name="suku[]" value="batak"
                            {{ in_array('batak', $sistemPsikobudaya['suku'] ?? []) ? 'checked' : '' }}>
                        <label for="suku_batak">Batak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="suku_tionghoa" name="suku[]" value="tionghoa"
                            {{ in_array('tionghoa', $sistemPsikobudaya['suku'] ?? []) ? 'checked' : '' }}>
                        <label for="suku_tionghoa">Tionghoa</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>