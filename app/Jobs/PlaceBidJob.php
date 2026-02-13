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
    ) {
    }

   public function handle()
{
    $lock = Cache::lock("auction:{$this->auctionId}", 5);

    if (!$lock->get()) {
        return;
    }

    try {
        DB::transaction(function () {

            $auction = Auction::lockForUpdate()->findOrFail($this->auctionId);

            if ($auction->status !== 'active') {
                throw new \Exception('Auction not active');
            }

            if ($auction->end_at && now()->greaterThan($auction->end_at)) {
                throw new \Exception('Auction ended');
            }

            // السعر الحالي
            $highestBid = $auction->bids()->max('amount');
            $currentPrice = $highestBid ?? $auction->starting_price;

            // السعر النهائي
            $finalAmount = $currentPrice + $this->amount;

            // التحقق الصحيح
            if ($finalAmount <= $currentPrice) {
                throw new \Exception('Bid must be higher than current price');
            }

            // إنشاء المزايدة بالسعر النهائي
            Bid::create([
                'auction_id' => $auction->id,
                'user_id' => $this->userId,
                'amount' => $finalAmount,
            ]);

            // تحديث المزاد
            $auction->update([
                'current_price' => $finalAmount,
                'end_at' => $auction->end_at
                    ? $auction->end_at->addSeconds(30)
                    : now()->addSeconds(30),
            ]);

        });

    } finally {
        $lock->release();
    }
}

}
