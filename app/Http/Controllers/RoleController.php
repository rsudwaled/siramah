<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->role) {
            $roles = Role::with(['permissions', 'users'])
                ->where('name', "LIKE",  "%" . $request->role . "%")
                ->get();
        } else {
            $roles = Role::with(['permissions', 'users'])->get();
        }
        if ($request->permission) {
            $permissions = Permission::with(['roles'])
                ->where('name', "LIKE",  "%" . $request->permission . "%")
                ->get();
        } else {
            $permissions = Permission::with(['roles'])->get();
        }
        return view('admin.role_index', compact(['roles', 'permissions', 'request']));
    }
    public function edit(Role $role)
    {
        $permissions = Permission::pluck('name', 'id');
        return view('admin.role_edit', compact(['role', 'permissions']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $request->id,
        ]);
        $role = Role::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        $role->syncPermissions();
        $role->syncPermissions($request->permission);
        Alert::success('Success Info', 'Success Message');
        return redirect()->route('role.index');
    }
    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            Alert::error('Gagal Menghapus', 'Role masih memiliki user');
        } else {
            $role->delete();
            Alert::success('Success', 'Role Telah Dihapus');
        }
        return redirect()->route('role.index');
    }
}
