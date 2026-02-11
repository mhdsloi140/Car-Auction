<?php

namespace App\Livewire\Seller;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public $userId;
    public $user;
    public $showModal = false;

    protected $listeners = ['showUser'];

    public function showUser($userId)
    {
        $this->userId = $userId;
        $this->user = User::with('roles')->find($userId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.seller.show-user');
    }
}
