<?php

namespace App\Imports;

use App\Models\KebutuhanJurusan;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KebutuhanJurusanImport implements ToCollection, WithHeadingRow
{
    use Importable;
    public function collection(Collection $rows)
    {
    }
}
