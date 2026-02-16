<?php

namespace App\Livewire\User;

use Livewire\Component;

class Profile extends Component
{
    public function openProfile()
{
    return redirect()->route('profile.edit');
}

    public function render()
    {
        return view('livewire.user.profile');
    }
}
