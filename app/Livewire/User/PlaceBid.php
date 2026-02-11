<?php

namespace App\Livewire\User;

use App\Events\NewBidPlaced;
use App\Jobs\PlaceBidJob;
use Livewire\Component;
use App\Models\Auction;
use App\Models\Bid;
use App\Jobs\ProcessBid;
use Illuminate\Support\Facades\Auth;

class PlaceBid extends Component
{
    public Auction $auction;
    public $amount;

    public function placeBid()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $bid = new Bid([
            'auction_id' => $this->auction->id,
            'user_id' => Auth::id(),
            'amount' => $this->amount,
        ]);

broadcast(new NewBidPlaced($bid))->toOthers();
       dispatch(new PlaceBidJob(
            $this->auction->id,
            auth()->id(),
            $this->amount
        ));

        session()->flash('success', 'تم إرسال مزايدتك!');

        $this->amount = null;
    }

    public function render()
    {
        return view('livewire.user.place-bid');
    }
}
