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
            // فيه مزايدة ثانية شغالة
            return;
        }

        try {
            DB::transaction(function () {

                $auction = Auction::lockForUpdate()->findOrFail($this->auctionId);

                if ($auction->status !== 'active') {
                    throw new \Exception('Auction not active');
                }

                if ($this->amount <= $auction->current_price) {
                    throw new \Exception('Bid too low');
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
