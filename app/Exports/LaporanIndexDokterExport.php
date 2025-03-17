<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Pasien;

class LaporanIndexDokterExport implements FromCollection, WithHeadings, WithTitle
{
    protected $findReport;
    protected $dokterFind;
    protected $bulanSelesai;
    protected $tahunSelesai;

    public function __construct($findReport, $dokterFind, $bulanSelesai, $tahunSelesai)
    {
        $this->findReport = $findReport;
        $this->dokterFind = $dokterFind;
        $this->bulanSelesai = $bulanSelesai;
        $this->tahunSelesai = $tahunSelesai;
    }

    public function collection()
    {
        $data = [];
        $counter=0;
        // Ambil data pasien berdasarkan no_rm yang ada dalam report
        $no_rm_list = $this->findReport->pluck('no_rm')->toArray();

        $pasien = Pasien::whereIn('no_rm', $no_rm_list)->get();

        foreach ($this->findReport as $report) {
            // Mencari pasien berdasarkan no_rm
            $patient = $pasien->firstWhere('no_rm', $report->no_rm);

            if ($patient) {
                // Menambahkan informasi pasien dan menghitung grup umur
                $report->nama_px = $patient->nama_px;
                $report->jenis_kelamin = $patient->jenis_kelamin;
                $report->tgl_lahir = $patient->tgl_lahir;
                $report->age_group = $this->getAgeGroup($patient->tgl_lahir, $patient->jenis_kelamin);
            }

            $data[] = [
                'No' => $counter++,
                'No RM' => $report->no_rm,
                'Pasien' => $report->nama_px,
                'Poliklinik' => $report->nama_unit ?? '-',
                '28H (L)' => ($report->age_group == '0_28HL') ? '1' : '-',
                '28H (P)' => ($report->age_group == '0_28HP') ? '1' : '-',
                '< 1TH(L)' => ($report->age_group == 'kurang_1TL') ? '1' : '-',
                '< 1TH(P)' => ($report->age_group == 'kurang_1TP') ? '1' : '-',
                '1-5 (L)' => ($report->age_group == '1_5TL') ? '1' : '-',
                '1-5 (P)' => ($report->age_group == '1_5TP') ? '1' : '-',
                '5-14 (L)' => ($report->age_group == '5_14TL') ? '1' : '-',
                '5-14 (P)' => ($report->age_group == '5_14TP') ? '1' : '-',
                '15-24 (L)' => ($report->age_group == '15_24TL') ? '1' : '-',
                '15-24 (P)' => ($report->age_group == '15_24TP') ? '1' : '-',
                '25-44 (L)' => ($report->age_group == '25_44TL') ? '1' : '-',
                '25-44 (P)' => ($report->age_group == '25_44TP') ? '1' : '-',
                '45-64 (L)' => ($report->age_group == '45_64TL') ? '1' : '-',
                '45-64 (P)' => ($report->age_group == '45_64TP') ? '1' : '-',
                '> 65 (L)' => ($report->age_group == 'lebih_65TL') ? '1' : '-',
                '> 65 (P)' => ($report->age_group == 'lebih_65TP') ? '1' : '-',
                'Kunjungan' => "In: " . \Carbon\Carbon::parse($report->tgl_masuk)->format('d-m-Y') . " Out: " . \Carbon\Carbon::parse($report->tgl_keluar)->format('d-m-Y'),
                'Diagnosa' => 'utama: ' . ($report->diag_utama_desc ?? '-') . ' sekunder: ' . ($report->diag_sekunder1_desc ?? '-'),
                'Ket' => '-',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            ['KARTU INDEX DOKTER'],
            ['Dokter: ' . $this->dokterFind->nama_paramedis],
            ['Bulan: ' . $this->bulanSelesai . ' Tahun: ' . $this->tahunSelesai],
            [
                'No', 'No RM', 'Pasien', 'Poliklinik', '28H (L)', '28H (P)', '< 1TH(L)', '< 1TH(P)',
                '1-5 (L)', '1-5 (P)', '5-14 (L)', '5-14 (P)', '15-24 (L)', '15-24 (P)', '25-44 (L)',
                '25-44 (P)', '45-64 (L)', '45-64 (P)', '> 65 (L)', '> 65 (P)', 'Kunjungan', 'Diagnosa', 'Ket'
            ]
        ];
    }

    public function title(): string
    {
        return 'Laporan Index Dokter';
    }

    private function getAgeGroup($tanggalLahir, $jenisKelamin)
    {
        $dateOfBirth = \Carbon\Carbon::parse($tanggalLahir);
        $today = \Carbon\Carbon::today();
        $umur = $today->diffInYears($dateOfBirth);

        $umurHari = $today->diffInDays($dateOfBirth);

        if ($umurHari <= 28) {
            return $jenisKelamin == 'L' ? '0_28HL' : '0_28HP';
        } elseif ($umur < 1) {
            return $jenisKelamin == 'L' ? 'kurang_1TL' : 'kurang_1TP';
        } elseif ($umur >= 1 && $umur < 5) {
            return $jenisKelamin == 'L' ? '1_5TL' : '1_5TP';
        } elseif ($umur >= 5 && $umur < 15) {
            return $jenisKelamin == 'L' ? '5_14TL' : '5_14TP';
        } elseif ($umur >= 15 && $umur < 25) {
            return $jenisKelamin == 'L' ? '15_24TL' : '15_24TP';
        } elseif ($umur >= 25 && $umur <= 44) {
            return $jenisKelamin == 'L' ? '25_44TL' : '25_44TP';
        } elseif ($umur >= 45 && $umur <= 64) {
            return $jenisKelamin == 'L' ? '45_64TL' : '45_64TP';
        } else {
            return $jenisKelamin == 'L' ? 'lebih_65TL' : 'lebih_65TP';
        }
    }
}

