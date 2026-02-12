<?php

namespace App\Livewire\Seller;

use App\Models\Auction;
use Livewire\Component;

class AuctionMonitor extends Component
{
    public Auction $auction;

    protected $listeners = ['bidPlaced' => '$refresh'];

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function render()
    {
        $this->auction->load(['bids.user']);
        return view('livewire.seller.auction-monitor');
    }
}

