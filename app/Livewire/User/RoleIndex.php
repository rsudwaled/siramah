<?php

namespace App\Livewire\User;

use App\Exports\RoleExport;
use App\Imports\RoleImport;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $roleId, $name;
    public $permissions = [];
    public $selectedPermissions = [];
    public $form = false;
    public $search = '';
    public $formImport = 0;
    public $fileImport;

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $role = Role::updateOrCreate(
            ['id' => $this->roleId],
            ['name' => $this->name],
        );
        $role->syncPermissions($this->selectedPermissions);
        Log::notice(auth()->user()->name . ' menyimpan data role ' . $role->name);
        flash('Role ' . $role->name . ' saved successfully.', 'success');
        $this->closeForm();
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role->users()->count()) {
            Log::notice(auth()->user()->name . ' gagal menghapus data role ' . $role->name);
            flash('Role tidak bisa dihapus karena sedang dipakai', 'danger');
        } else {
            $role->delete();
            Log::notice(auth()->user()->name . ' menghapus data role ' . $role->name);
            flash('Role ' . $role->name . ' deleted successfully.', 'success');
        }
    }
    public function edit($id)
    {
        $this->form = true;
        $role = Role::find($id);
        $this->name = $role->name;
        $this->roleId = $role->id;
        $this->permissions = Permission::pluck('name', 'id');
        $this->selectedPermissions = $role->permissions()->pluck('name');
    }
    public function openForm()
    {
        $this->form = true;
        $this->name = '';
        $this->roleId = '';
        $this->permissions = Permission::pluck('name', 'id');
        $this->selectedPermissions = [];
    }
    public function closeForm()
    {
        $this->form = false;
        $this->name = '';
        $this->roleId = '';
        $this->selectedPermissions = [];
    }
    public function export()
    {
        try {
            $time = now()->format('Y-m-d');
            Log::notice( auth()->user()->name . ' mengekspor data role');
            flash('Export successfully', 'success');
            return Excel::download(new RoleExport, 'role_backup_' . $time . '.xlsx');
        } catch (\Throwable $th) {
            flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }
    public function openFormImport()
    {
        $this->formImport = $this->formImport ?  0 : 1;
    }
    public function import()
    {
        try {
            $this->validate([
                'fileImport' => 'required|mimes:xlsx'
            ]);

            Excel::import(new RoleImport, $this->fileImport->getRealPath());
            Log::notice(auth()->user()->name . ' mengimpor data role');
            Alert::success('Success', 'Imported successfully');
            return redirect()->route('role-permission');
        } catch (\Throwable $th) {
            flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }
    public function mount()
    {
        $this->permissions = Permission::pluck('name', 'id');
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        $roles = Role::with('permissions')
            ->withCount('users')
            ->where('name', 'like', $search)
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.user.role-index', compact('roles'));
    }
}
