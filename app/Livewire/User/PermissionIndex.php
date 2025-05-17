<?php

namespace App\Livewire\User;

use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $id, $name;
    public $form = false;
    public $search = '';
    public $formImport = 0;
    public $fileImport;

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $permission = Permission::updateOrCreate(
            ['id' => $this->id],
            ['name' => Str::slug($this->name)],
        );
        Log::notice(auth()->user()->name . ' telah menyimpan data permission ' . $permission->name);
        flash('Permission ' . $permission->name . ' saved successfully.', 'success');
        $this->closeForm();
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);

        if ($permission->roles->count()) {
            Log::notice(auth()->user()->name . ' gagal menghapus data permission ' . $permission->name);
            flash('Permission tidak bisa dihapus karena sedang dipakai', 'danger');
        } else {
            $permission->delete();
            Log::notice(auth()->user()->name . ' telah menghapus data permission ' . $permission->name);
            flash('Permission ' . $permission->name . ' deleted successfully.', 'success');
        }
    }

    public function edit($id)
    {
        $this->form = true;
        $permission = Permission::find($id);
        $this->name = $permission->name;
        $this->id = $permission->id;
    }

    public function openForm()
    {
        $this->form = true;
        $this->name = '';
        $this->id = '';
    }

    public function closeForm()
    {
        $this->form = false;
        $this->name = '';
        $this->id = '';
    }

    public function export()
    {
        try {
            $time = now()->format('Y-m-d');
            Log::notice(auth()->user()->name . ' telah mengekspor data permission');
            flash('Export successfully', 'success');
            return Excel::download(new PermissionExport, 'permission_backup_' . $time . '.xlsx');
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
            Excel::import(new PermissionImport, $this->fileImport->getRealPath());
            Log::notice(auth()->user()->name . ' telah mengimpor data permission');
            Alert::success('Success', 'Permission imported successfully');
            return redirect()->route('role-permission');
        } catch (\Throwable $th) {
            flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }
    public function cari() {}

    public function render()
    {
        $permissions = Permission::with('roles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name', 'asc')
            ->paginate(10);
        return view('livewire.user.permission-index', compact('permissions'));
    }
}
