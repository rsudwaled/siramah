<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class ProfilIndex extends Component
{
    public $user;
    public $id, $name, $email, $phone, $username, $password;
    public function render()
    {
        return view('livewire.user.profil-index')
            ->title('Profil');
    }
    public function save()
    {
        $user = Auth::user();
        $user->name = $this->name;
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = bcrypt($this->password);
        }
        $user->save();
        Log::notice('User ' . auth()->user()->name . ' telah memperbaharui profil');
        return flash('User updated successfully!', 'success');
    }
    public function mount()
    {
        $user = Auth::user();
        $this->user = $user;
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->username = $user->username;
    }
}
