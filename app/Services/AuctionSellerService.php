<?php

namespace App\Services;

use App\Models\Auction;

class AuctionSellerService
{
    /**
     * جلب قائمة المزادات للبائع الحالي
     */
    public function index()
    {
        $sellerId = auth()->id();

        $auctions = Auction::with(['car.brand', 'car.model', 'car.media'])
            ->where('seller_id', $sellerId)
            ->paginate(5);

        return $auctions;
    }

    /**
     * عرض مزاد معين مع السيارة والبائع
     */
    public function show($auctionId)
    {
        $auction = Auction::with(['car.brand', 'car.model', 'car.media', 'seller'])
            ->findOrFail($auctionId);

        return $auction;
    }
}
