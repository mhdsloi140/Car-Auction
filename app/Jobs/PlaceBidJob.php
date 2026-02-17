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

    public int $auctionId;
    public int $userId;
    public float $increment;

    public function __construct(int $auctionId, int $userId, float $increment)
    {
        $this->auctionId = $auctionId;
        $this->userId = $userId;
        $this->increment = $increment;
    }

    public function handle()
    {
        // منع التداخل بين المزايدات
        $lock = Cache::lock("auction:{$this->auctionId}", 5);

        if (!$lock->get()) {
            return;
        }

        try {

            DB::transaction(function () {

                // جلب المزاد مع قفل للتحديث
                $auction = Auction::lockForUpdate()->findOrFail($this->auctionId);

                // التحقق من حالة المزاد
                if ($auction->status !== 'active') {
                    throw new \Exception('Auction not active');
                }

                // التحقق من انتهاء الوقت
                if ($auction->end_at && now()->greaterThan($auction->end_at)) {
                    throw new \Exception('Auction ended');
                }

                // آخر مزايدة
                $lastBid = $auction->bids()->latest()->first();
                $currentPrice = $lastBid->amount ?? $auction->starting_price;

                //  منع المزايدة المتتالية من نفس المستخدم
                if ($lastBid && $lastBid->user_id == $this->userId) {
                    throw new \Exception('لا يمكنك المزايدة مرتين متتاليتين');
                }

                // السعر الجديد
                $newAmount = $currentPrice + $this->increment;

                if ($newAmount <= $currentPrice) {
                    throw new \Exception('Bid must be higher than current price');
                }

                // إنشاء المزايدة
                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $this->userId,
                    'amount' => $newAmount,
                ]);

                // تحديث المزاد
                $auction->update([
                    'current_price' => $newAmount,
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
