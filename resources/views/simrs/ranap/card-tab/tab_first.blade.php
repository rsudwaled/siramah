<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-start-panduan-tab" data-toggle="pill"
                    href="#tab-start-panduan" role="tab" aria-controls="tab-start-panduan"
                    aria-selected="false">PANDUAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabs-riwayat-triase-igd" data-toggle="pill" href="#tab-triase"
                    role="tab" aria-controls="tab-triase" aria-selected="true">Triase IGD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " onclick="getHasilRadiologi()" id="tab-radiologi-tab"
                    data-toggle="pill" href="#tab-radiologi" role="tab" aria-controls="tab-radiologi"
                    aria-selected="false">Radiologi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="getHasilLab()" id="tab-laboratorium-tab" data-toggle="pill"
                    href="#tab-laboratorium" role="tab" aria-controls="tab-laboratorium"
                    aria-selected="false">Laboratorium</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill"
                    href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings"
                    aria-selected="false">Berkas File</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-assesmen-awal-tab" data-toggle="pill" href="#tab-assesmen-awal"
                    role="tab" aria-controls="tab-assesmen-awal" aria-selected="false">Assesmen Awal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-assesmen-keperawatan-tab" data-toggle="pill"
                    href="#tab-assesmen-keperawatan" role="tab" aria-controls="tab-assesmen-keperawatan"
                    aria-selected="false">Assesmen Keperawatan</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            @include('simrs.ranap.component-tab.tab_start')
            @include('simrs.ranap.component-tab.tab_triase')
            @include('simrs.ranap.component-tab.tab_radiologi')
            @include('simrs.ranap.component-tab.tab_laboratorium')
            @include('simrs.ranap.component-tab.tab_assesmen_awal')
            @include('simrs.ranap.component-tab.tab_assesmen_keperawatan')
        </div>
    </div>

</div>