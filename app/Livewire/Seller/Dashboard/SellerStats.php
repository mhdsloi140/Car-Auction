<?php

namespace App\Livewire\Seller\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerStats extends Component
{

    public $totalAuctions = 0;
    public $pendingAuctions = 0;
    public $rejectedAuctions = 0;
    public $activeAuctions = 0;
    public $closedAuctions = 0;
    public $totalEarnings = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = Auth::user();

        $this->totalAuctions = $user->auctions()->count();
        $this->pendingAuctions = $user->auctions()->where('status', 'pending')->count();
        $this->rejectedAuctions = $user->auctions()->where('status', 'rejected')->count();
        $this->activeAuctions = $user->auctions()->where('status', 'active')->count();
        $this->closedAuctions = $user->auctions()->where('status', 'closed')->count();
        $this->totalEarnings = $user->auctions()->whereNotNull('final_price')->sum('final_price');
    }
    public function render()
    {
        return view('livewire.seller.dashboard.seller-stats');
    }
}
