<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlaceBidJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $auctionId,
        public int $userId,
        public float $amount
    ) {}

    public function handle()
    {
       $lock = Cache::lock("auction:{$this->auctionId}", 5);

        if (! $lock->get()) {

            return;
        }

      try {
        DB::transaction(function () {

            $auction = Auction::lockForUpdate()->findOrFail($this->auctionId);

            if ($auction->status !== 'active') {
                throw new \Exception('Auction not active');
            }


            $highestBid = $auction->bids()->max('amount');

            $currentPrice = $highestBid ?? $auction->starting_price;


            if ($this->amount <= $currentPrice) {
                throw new \Exception('يجب أن يكون العرض أعلى من أعلى عرض حالي');
            }

            Bid::create([
                'auction_id' => $auction->id,
                'user_id'    => $this->userId,
                'amount'     => $this->amount,
            ]);

            $auction->update([
                'current_price' => $this->amount,
            ]);
        });

    } finally {
            $lock->release();
        }
    }
}
