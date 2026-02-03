<?php

namespace App\Livewire\Auction;

use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IndexAuction extends Component
{
     public $auctions;



    protected $listeners = ['auctionCreated' => 'loadAuctions'];

    public function mount()
    {
        $this->loadAuctions();
    }


    public function loadAuctions()
    {

       $this->auctions = Auction::with('car.brand')
            ->where('seller_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function render()
    {
        return view('livewire.auction.index-auction');

    }
}
