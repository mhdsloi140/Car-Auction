<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Auction;

class QuickAlerts extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard.quick-alerts', [
            'activeWithoutBids' => Auction::where('status', 'active')
                ->doesntHave('bids')
                ->count(),
            'endedNoWinner' => Auction::where('status', 'closed')
                ->whereNull('winner_id')
                ->count(),
            'activeWithBids' => Auction::where('status', 'active')
                ->has('bids')
                ->count(),
            'rejectedToday' => Auction::where('status', 'rejected')
                ->whereDate('updated_at', today())
                ->count(),
        ]);
    }
}
