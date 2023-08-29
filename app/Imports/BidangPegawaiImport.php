<?php

namespace App\Imports;

use App\Models\BidangPegawai;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BidangPegawaiImport implements ToCollection, WithHeadingRow
{
    use Importable;
    public function collection(Collection $rows)
    {
    }
}
