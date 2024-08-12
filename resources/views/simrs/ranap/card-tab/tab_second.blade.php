<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-soap-perkembangan-tab" data-toggle="pill"
                    href="#tab-soap-perkembangan" role="tab" aria-controls="tab-soap-perkembangan"
                    aria-selected="false">SOAP & PERKEMBANGAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabs-implementasi-evaluasi-tab" data-toggle="pill" href="#tab-implementasi-evaluasi"
                    role="tab" aria-controls="tab-implementasi-evaluasi" aria-selected="true">IMPLEMENTASI & EVALUASI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-observasi-pasien-tab" data-toggle="pill"
                    href="#tab-observasi-pasien" role="tab" aria-controls="tab-observasi-pasien"
                    aria-selected="false">OBSERVASI 24 JAM</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-rencana-asuhan-terpadu-tab" data-toggle="pill"
                    href="#tab-rencana-asuhan-terpadu" role="tab" aria-controls="tab-rencana-asuhan-terpadu"
                    aria-selected="false">RENCANA ASUHAN TERPADU</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            @include('simrs.ranap.component-tab.tab_soap_perkembangan')
            @include('simrs.ranap.component-tab.tab_implementasi_evaluasi_perawat')
            @include('simrs.ranap.component-tab.tab_observasi_pasien')
            @include('simrs.ranap.component-tab.tab_asuhan_terpadu')
        </div>
    </div>
</div>