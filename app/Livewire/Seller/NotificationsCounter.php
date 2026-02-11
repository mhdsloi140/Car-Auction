<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->loadCount();
    }

    public function loadCount()
    {
        $this->count = Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->count();
    }

    public function render()
    {
        return view('livewire.seller.notifications-counter');
    }
}
