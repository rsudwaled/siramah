<x-adminlte-card id="nav" theme="primary" title="Navigasi" body-class="p-0">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item" data-toggle="collapse" data-parent="#accordion" href="#cIGD">
            <a href="#card-Triase" class="nav-link">
                <i class="fas fa-vials"></i> Triase IGD
            </a>
        </li>
        <li class="nav-item" data-toggle="collapse" data-parent="#accordion" href="#cLaboratorium" onclick="getHasilLab()">
            <a href="#card-laboratorium" class="nav-link">
                <i class="fas fa-vials"></i> Laboratorium
            </a>
        </li>
        <li class="nav-item" onclick="lihatHasilRadiologi()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-x-ray"></i> Radiologi
            </a>
        </li>
        <li class="nav-item" onclick="lihatLabPa()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-microscope"></i> Lab Patologi Anatomi
            </a>
        </li>
        <li class="nav-item" onclick="lihatFileUpload()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-file-medical"></i> Berkas File Upload
            </a>
        </li>
        <li class="nav-item" onclick="lihatRincianBiaya()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i> Rincian Biaya
            </a>
        </li>
        <li class="nav-item" onclick="modalAsesmenAwal()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-file-medical-alt"></i> Asesmen Awal Medis
                @if ($kunjungan->asesmen_ranap)
                    <span class="badge bg-success float-right">Sudah</span>
                @else
                    <span class="badge bg-danger float-right">Belum</span>
                @endif
            </a>
        </li>
        <li class="nav-item" onclick="modalAsuhanTerpadu()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-user-md"></i> Rencana Asuhan Terpadu
                <span class="badge bg-primary float-right">{{ $kunjungan->asuhan_terpadu->count() }}</span>
            </a>
        </li>
        <li class="nav-item" onclick="modalAsesmenKeperawatan()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-file-medical-alt"></i> Asesmen Keperawatan
                @if ($kunjungan->asesmen_ranap_keperawatan)
                    <span class="badge bg-success float-right">Sudah</span>
                @else
                    <span class="badge bg-danger float-right">Belum</span>
                @endif
            </a>
        </li>
        <li class="nav-item" onclick="btnModalGroupping()">
            <a href="#nav" class="nav-link">
                <i class="fas fa-diagnoses"></i> Groupping E-Klaim
                @if ($groupping)
                    <span class="badge bg-success float-right">Sudah</span>
                @else
                    <span class="badge bg-danger float-right">Belum</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="#nav" class="nav-link">
                <i class="fas fa-file-medical"></i> Rencana Pemulangan
                <span class="badge bg-danger float-right">Belum</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#nav" class="nav-link" onclick="modalResumeRanap()">
                <i class="fas fa-file-medical-alt"></i> Resume Rawat Inap
                @if ($kunjungan->erm_ranap)
                    <span class="badge bg-success float-right">Sudah</span>
                @else
                    <span class="badge bg-danger float-right">Belum</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="#nav" class="nav-link btnCariSEP">
                <i class="fas fa-file-medical"></i> SEP
            </a>
        </li>
        <li class="nav-item">
            <a href="#nav" class="nav-link" onclick="cariSuratKontrol()">
                <i class="fas fa-file-medical"></i> Surat Kontrol
            </a>
        </li>
    </ul>
</x-adminlte-card>