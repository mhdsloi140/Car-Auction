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

    public $lastBidId = null;
    public $newBidAlert = null;
    public $currentPrice;

    public $increments = [100, 200, 500, 1000];
    public $selectedIncrement = null;

    public function mount(Auction $auction)
    {
        $this->auction = $auction;

        $latestBid = $auction->bids()->latest()->first();
        $this->lastBidId = $latestBid->id ?? null;

        $this->currentPrice = $latestBid->amount ?? $auction->starting_price;
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
            $this->addError('amount', 'يرجى اختيار قيمة المزايدة أولاً');
            return;
        }

        // تحديث السعر الحالي قبل الإرسال
        $this->auction->refresh();
        $lastBid = $this->auction->bids()->latest()->first();
        $currentPrice = $lastBid->amount ?? $this->auction->starting_price;

        // نرسل فقط الزيادة للـ Job
        $increment = $this->selectedIncrement;

        if ($increment <= 0) {
            $this->addError('amount', 'قيمة الزيادة غير صحيحة');
            return;
        }

        // إرسال المزايدة للـ Job
        dispatch(new PlaceBidJob(
            $this->auction->id,
            auth()->id(),
            $increment
        ));

        session()->flash('success', 'تمت المزايدة بنجاح');

        // تحديث بيانات المزاد بعد تنفيذ الـ Job
        $this->auction->refresh();

        // إرسال الوقت الجديد للواجهة
        if ($this->auction->end_at) {
            $this->dispatch('update-end-time', endTime: $this->auction->end_at->format('Y-m-d\TH:i:s'));
        }
    }

    public function checkForNewBids()
    {
        $this->auction->refresh();

        $latestBid = $this->auction->bids()->latest()->first();

        // تحديث الوقت في الواجهة
        if ($this->auction->end_at) {
            $this->dispatch('update-end-time', endTime: $this->auction->end_at->format('Y-m-d\TH:i:s'));
        }

        if ($latestBid && $latestBid->id != $this->lastBidId) {

            $this->lastBidId = $latestBid->id;

            $this->newBidAlert = [
                'user_id' => $latestBid->user_id,
                'amount' => $latestBid->amount,
            ];

            $this->currentPrice = $latestBid->amount;
        }
    }

    public function render()
    {
        return view('livewire.user.place-bid', [
            'currentPrice' => $this->currentPrice,
        ]);
    }
}
