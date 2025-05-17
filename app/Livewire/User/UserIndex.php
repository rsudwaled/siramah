<?php

namespace App\Livewire\User;

use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $searchRole = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $form = 0;
    public $roles = [];
    public $userId, $name, $username, $phone, $email, $role, $password;
    public $formImport = 0;
    public $fileImport;


    public function export()
    {
        try {
            $time = now()->format('Y-m-d');
            flash('Export User successfully', 'success');
            return Excel::download(new UserExport, 'user_backup_' . $time . '.xlsx');
        } catch (\Throwable $th) {
            return flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }
    public function import()
    {
        try {
            $this->validate([
                'fileImport' => 'required|mimes:xlsx'
            ]);
            Excel::import(new UserImport, $this->fileImport->getRealPath());
            Log::notice('Data User diimport oleh ' . auth()->user()->name . ' pada ' . now());
            Alert::success('Success', 'User imported successfully');
            return redirect()->route('user');
        } catch (\Throwable $th) {
            return flash('Mohon maaf ' . $th->getMessage(), 'danger');
        }
    }
    public function openFormImport()
    {
        $this->formImport = $this->formImport ? 0 : 1;
    }
    public function verifikasi($id)
    {
        $user = User::find($id);
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->pic = auth()->user()->name;
        $user->user_verify = auth()->user()->name;
        $user->save();
        $status = $user->email_verified_at ? 'diverifikasi' : 'membatalkan verifikasi';
        Log::notice('Data User ' . $user->name . ' ' . $status . ' oleh ' . auth()->user()->name . ' pada ' . now());
        return flash('Berhasil ' . $status, 'success');
    }
    public function hapus($id)
    {
        $user = User::find($id);
        $user->delete();
        Log::notice('Data User ' . $user->name . ' dihapus oleh ' . auth()->user()->name . ' pada ' . now());
        return flash('Berhasil hapus data user', 'success');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->role = $user->roles->first()->name ?? null;
        $this->form = 1;
    }
    public function simpan()
    {
        try {
            $this->validate([
                'name' => 'required|string|min:3',
                'username' => 'required|string|min:3',
                'phone' => 'required|numeric|min:9',
                'email' => 'required|email',
                'role' => 'required',
            ]);
            $data = [
                'name' => $this->name,
                'username' => $this->username,
                'phone' => $this->phone,
                'email' => $this->email,
                'pic' => auth()->user()->name,
            ];
            if (!empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }
            $user = User::updateOrCreate(
                ['id' => $this->userId],
                $data
            );
            $user->syncRoles($this->role);
            Log::notice('Data User ' . $user->name . ' disimpan oleh ' . auth()->user()->name . ' pada ' . now());
            $this->tambah();
            return flash('Berhasil simpan data', 'success');
        } catch (\Throwable $th) {
            return flash($th->getMessage(), 'danger');
        }
    }
    public function tambah()
    {
        $this->roles = Role::pluck('name', 'id');
        $this->reset(['userId', 'name', 'username', 'phone', 'email', 'role', 'password']);
        $this->form =  $this->form ? false : true;
    }
    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }
    public function mount()
    {
        $this->roles = Role::pluck('name', 'id');
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        $users = User::with('roles')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'like', $search)
                    ->orWhere('users.email', 'like', $search);
            })
            ->when($this->searchRole, function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('roles.name', $this->searchRole);
                });
            })
            ->when($this->sortBy === 'role', function ($query) {
                $query->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->select('users.*', 'roles.name as role_name')
                    ->orderBy('role_name', $this->sortDirection);
            }, function ($query) {
                $query->orderBy('users.' . $this->sortBy, $this->sortDirection);
            })
            ->paginate(20);
        return view('livewire.user.user-index', compact('users'))
            ->title('User');
    }
}
