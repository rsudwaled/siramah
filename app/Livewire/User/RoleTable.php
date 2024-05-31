<?php

namespace App\Livewire\User;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTable extends Component
{
    public $id, $name, $roles;
    public $permissions = [];
    public $selectedPermissions = [];
    public $form = false;
    public $search = '';
    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $role = Role::updateOrCreate(
            ['id' => $this->id],
            ['name' => $this->name],
        );
        $role->syncPermissions();
        $role->syncPermissions($this->selectedPermissions);
        flash('Role ' . $role->name . ' saved successfully.', 'success');
        $this->closeForm();
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        flash('Role ' . $role->name . ' deleted successfully.', 'success');
    }
    public function edit($id)
    {
        $this->form = true;
        $role = Role::find($id);
        $this->name = $role->name;
        $this->id = $role->id;
        $this->permissions = Permission::pluck('name', 'id');
        $this->selectedPermissions = $role->permissions()->pluck('name');
    }
    public function openForm()
    {
        $this->form = true;
        $this->name = '';
        $this->id = '';
        $this->permissions = Permission::pluck('name', 'id');
    }
    public function closeForm()
    {
        $this->form = false;
        $this->name = '';
        $this->id = '';
        $this->selectedPermissions = [];
    }
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text');
    }
    public function mount()
    {
        $search = '%' . $this->search . '%';
        $this->roles = Role::orderBy('name', 'asc')->with(['permissions'])
            ->where('name', 'like', $search)
            ->get();
        $this->permissions = Permission::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.user.role-table');
    }
}
