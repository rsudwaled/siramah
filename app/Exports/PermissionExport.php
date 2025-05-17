<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Permission\Models\Permission;

class PermissionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Permission::get();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'created_at',
            'updated_at',
        ];
    }
}
