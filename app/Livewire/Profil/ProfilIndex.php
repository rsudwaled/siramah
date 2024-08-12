<?php

namespace App\Livewire\Profil;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ProfilIndex extends Component
{
    public $user;
    public $id, $name, $email, $phone, $username, $password;
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
        flash('User updated successfully!', 'success');
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
        return view('components.placeholder.placeholder-text')
            ->title('Profil');
    }
    public function render()
    {
        return view('livewire.profil.profil-index')
            ->title('Profil');
    }
}
