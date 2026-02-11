<?php

namespace App\Observers;

use App\Models\Bid;

class BidObserver
{
    public function created(Bid $bid)
    {
        log_activity(
            'مزايدة',
            "قام المستخدم رقم {$bid->user_id} بالمزايدة على المزاد رقم {$bid->auction_id} بقيمة {$bid->amount}"
        );
    }
}

