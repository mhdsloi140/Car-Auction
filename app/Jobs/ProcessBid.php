<?php

namespace App\Jobs;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProcessBid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Bid $bid;

    /**
     * Create a new job instance.
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $auctionId = $this->bid->auction_id;

        // استخدام Redis Lock لمنع التداخل
        Cache::lock('auction-lock-'.$auctionId, 5)->block(3, function() use ($auctionId) {

            DB::transaction(function() use ($auctionId) {

                $auction = Auction::lockForUpdate()->find($auctionId);

                // الحصول على أعلى مزايدة حالية
                $highestBid = $auction->bids()->latest('amount')->first();

                // التأكد أن المزاد نشط
                if ($auction->status !== 'active') {
                    throw new \Exception('المزاد غير نشط.');
                }

                // إذا المبلغ أقل أو يساوي الأعلى الحالي
                if ($this->bid->amount <= ($highestBid->amount ?? 0)) {
                    throw new \Exception('المبلغ أقل من أعلى مزايدة حالية.');
                }

                // حفظ المزايدة
                $this->bid->save();

                // تحديث السعر الأعلى في المزاد (اختياري)
                $auction->update([
                    'highest_bid' => $this->bid->amount
                ]);

            });

        });
    }
}
