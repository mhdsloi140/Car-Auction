<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Auction;
use App\Models\Bid;
use App\Jobs\PlaceBidJob;

class PlaceBid extends Component
{
    public Auction $auction;

    public $amount = null;
    public $selectedIncrement = null;

    public $increments = [100, 200, 500, 1000];

    public $currentPrice;
    public $bidsCount = 0;
    public $latestBids = [];

    public $lastBidId = null;
    public $newBidAlert = null;

    public function mount(Auction $auction)
    {
        $this->auction = $auction;

        $lastBid = $auction->bids()->latest()->first();

        $this->currentPrice = $lastBid->amount ?? $auction->starting_price;
        $this->lastBidId = $lastBid->id ?? null;

        $this->bidsCount = $auction->bids()->count();
        $this->latestBids = $auction->bids()->latest()->take(10)->get();
    }

    public function setBidAmount($inc)
    {
        $this->selectedIncrement = $inc;
        $this->amount = $this->currentPrice + $inc;
    }

    public function placeBid()
    {
        $this->resetErrorBag();

        if (!$this->selectedIncrement) {
            $this->addError('amount', 'يرجى اختيار قيمة الزيادة أولاً');
            return;
        }
\Log::info('Dispatching PlaceBidJob', [
    'auction_id' => $this->auction->id,
    'user_id' => auth()->id(),
    'increment' => $this->selectedIncrement,
]);

        // تحديث السعر قبل الإرسال
        $this->auction->refresh();
        $lastBid = $this->auction->bids()->latest()->first();
        $currentPrice = $lastBid->amount ?? $this->auction->starting_price;

        // إرسال الزيادة فقط للـ Job
        dispatch(new PlaceBidJob(
            $this->auction->id,
            auth()->id(),
            $this->selectedIncrement
        ));

        session()->flash('success', 'تمت المزايدة بنجاح');

        // تحديث الواجهة بعد الإرسال
        $this->auction->refresh();
    }

    public function checkForNewBids()
    {
        $this->auction->refresh();

        $latestBid = $this->auction->bids()->latest()->first();

        if ($latestBid && $latestBid->id != $this->lastBidId) {

            $this->lastBidId = $latestBid->id;

            // تنبيه مزايدة جديدة
            $this->newBidAlert = [
                'user_id' => $latestBid->user_id,
                'amount'  => $latestBid->amount,
            ];

            // تحديث السعر
            $this->currentPrice = $latestBid->amount;

            // تحديث عدد المزايدات
            $this->bidsCount = $this->auction->bids()->count();

            // تحديث قائمة آخر المزايدات
            $this->latestBids = $this->auction->bids()->latest()->take(10)->get();
        }

        // تحديث الوقت في الواجهة
        if ($this->auction->end_at) {
$this->dispatch('update-end-time', endTime: $this->auction->end_at->setTimezone('UTC')->toIso8601String());
        }
    }

    public function render()
    {
        return view('livewire.user.place-bid', [
            'currentPrice' => $this->currentPrice,
            'latestBids'   => $this->latestBids,
            'bidsCount'    => $this->bidsCount,
        ]);
    }
}
