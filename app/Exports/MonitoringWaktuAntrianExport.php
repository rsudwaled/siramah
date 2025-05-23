<?php

namespace App\Exports;

use App\Models\Antrian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonitoringWaktuAntrianExport implements FromCollection, WithHeadings
{
    protected $tanggalperiksa;
    public function __construct($tanggalperiksa)
    {
        $this->tanggalperiksa = $tanggalperiksa;
    }
    public function collection()
    {
        $antrians = Antrian::where('tanggalperiksa', 'LIKE', "%" . $this->tanggalperiksa . "%")
            ->where('method', '!=', 'Offline')
            ->where('taskid', '!=', 99)
            ->where('taskid',  7)
            ->orderBy('tanggalperiksa', 'asc')
            ->with(['kunjungan', 'kunjungan.assesmen_perawat', 'kunjungan.order_obat_header'])
            ->get();
        $antrians = $antrians->map(function ($antrian) {
            return [
                'tanggalperiksa' => $antrian->tanggalperiksa,
                'kodebooking' => $antrian->kodebooking,
                'nama' => $antrian->nama,
                'nomorkartu' => $antrian->nomorkartu,
                'namapoli' => $antrian->namapoli,
                'namadokter' => $antrian->kunjungan?->dokter?->nama_paramedis,
                'taskid3' => $antrian->taskid3,
                'tanggalassemen' => $antrian->kunjungan?->assesmen_perawat?->tanggalassemen,
                'taskid4' => $antrian->taskid4,
                'taskid5' => $antrian->taskid5,
                'taskid5' => $antrian->taskid5,
                'taskid6' => $antrian->kunjungan?->order_obat_header?->tgl_entry,
                'taskid7' => $antrian->taskid7,
                'waktupelayanan' => Carbon::parse($antrian->taskid3)->diff(Carbon::parse($antrian->taskid7))->format('%H:%I:%S'),
            ];
        });
        return $antrians;
    }
    public function headings(): array
    {
        return [
            'tanggal',
            'kodebooking',
            'Nama Pasien',
            'Nomor BPJS',
            'Poliklinik',
            'Dokter',
            'Checkin',
            'Anamnesis',
            'Periksa Dokter',
            'Selesai Dokter',
            'Penyiapan Resep',
            'Obat Diserahkan',
            'Waktu Pelayanan',
        ];
    }
}
