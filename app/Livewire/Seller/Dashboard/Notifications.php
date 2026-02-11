<?php

namespace App\Livewire\Seller\Dashboard;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()
            ->where('is_read', false)
            ->latest()
            ->get()
            ->toArray();

    }


    public static function createNotification($userId, $message, $type = 'info', $icon = 'bi bi-bell')
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'icon' => $icon,
            'message' => $message,
        ]);
    }

    /**
     * حذف إشعار
     */
    public function dismiss($id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.seller.dashboard.notifications');
    }
}
