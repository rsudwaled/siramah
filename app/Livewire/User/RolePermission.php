<?php

namespace App\Livewire\User;

use Livewire\Component;

class RolePermission extends Component
{
    public function render()
    {
        return view('livewire.user.role-permission')
            ->title('Role & Permission');
    }
}
