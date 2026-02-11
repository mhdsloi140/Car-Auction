<?php

namespace App\Observers;

use App\Models\Auction;

class AuctionObserver
{
    public function created(Auction $auction)
    {
        log_activity(
            'تنشاء مزاد',
            "تم إنشاء مزاد للسيارة رقم {$auction->car_id} بواسطة المستخدم رقم {$auction->seller_id}"
        );
    }
}
