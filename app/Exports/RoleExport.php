<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Permission\Models\Role;

class RoleExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Role::with('permissions')->get()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->role,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at,
                'permissions' => $role->permissions->pluck('name')->implode(','),
            ];
        });
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'created_at',
            'updated_at',
            'permissions',
        ];
    }
}
