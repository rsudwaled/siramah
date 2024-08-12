<div id="resumerajal">
    <x-adminlte-card title="Resume Rawat Jalan" theme="primary" icon="fas fa-user-md">
        <iframe src="{{ route('resume-rajal-print') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
            height="400px" frameborder="0"></iframe>
    </x-adminlte-card>
</div>
