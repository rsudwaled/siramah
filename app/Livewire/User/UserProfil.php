<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfil extends Component
{
    public $user;
    public $id, $name, $email, $phone, $username;
    public function save()
    {
        $user = Auth::user();
        $user->name = $this->name;
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->save();
        flash('User updated successfully!', 'success');
    }
    public function resetForm()
    {
        $this->reset('name', 'email', 'phone', 'username');
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
    public function placeholder()
    {
        return view('components.placeholder.placeholder-text');
    }
    public function render()
    {
        return view('livewire.user.user-profil');
    }
}
