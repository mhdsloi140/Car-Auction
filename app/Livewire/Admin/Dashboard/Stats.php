<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Car;

class Stats extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard.stats', [
            'users'        => User::count(),
            'cars'         => Car::count(),
            'auctions'     => Auction::count(),
            'active'       => Auction::where('status', 'active')->count(),
            'pending'      => Auction::where('status', 'pending')->count(),
            'rejected'     => Auction::where('status', 'rejected')->count(),
            'closed'       => Auction::where('status', 'closed')->count(),
            'totalBids'    => Bid::sum('amount'),
        ]);
    }
}
