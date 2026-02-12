<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use App\Events\NewBidPlaced;
use App\Jobs\PlaceBidJob;
class PlaceBid extends Component
{
    public Auction $auction;
    public $amount;

    public $lastBidId = null;
    public $newBidAlert = null;

    public function mount(Auction $auction)
    {
        $this->auction = $auction;


        $this->lastBidId = $auction->bids()->latest()->first()->id ?? null;
    }

public function placeBid()
{
    $this->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    // جلب أعلى مزايدة
    $highestBid = $this->auction->bids()->max('amount');
    $currentPrice = $highestBid ?? $this->auction->starting_price;

    //  التحقق قبل إرسال الـ Job
    if ($this->amount <= $currentPrice) {
        $this->addError('amount', 'يجب أن تكون المزايدة أعلى من السعر الحالي (' . number_format($currentPrice) . ')');
        return;
    }


    dispatch(new PlaceBidJob(
        $this->auction->id,
        auth()->id(),
        $this->amount
    ));

    session()->flash('success', 'تم إرسال مزايدتك بنجاح');

    $this->amount = null;
}



    // يتم استدعاؤها كل ثانيتين عبر Livewire Polling
    public function checkForNewBids()
    {
        $latestBid = $this->auction->bids()->latest()->first();

        if ($latestBid && $latestBid->id != $this->lastBidId) {

            $this->lastBidId = $latestBid->id;

            // تجهيز بيانات الإشعار
            $this->newBidAlert = [
                'user_id' => $latestBid->user_id,
                'amount' => $latestBid->amount,
            ];
        }
    }

    public function render()
    {
        return view('livewire.user.place-bid');
    }
}
