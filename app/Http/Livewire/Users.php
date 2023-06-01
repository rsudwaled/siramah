<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $users;

    public function render()
    {

        $this->users = User::get();
        return view('livewire.users');
    }
    public function store()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        Post::create($validatedDate);
        session()->flash('message', 'Post Created Successfully.');
        $this->resetInputFields();
    }
}
