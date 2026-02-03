<?php
namespace App\Services;

use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use Auth;

class AuctionAdminService
{
    ///
    public function index()
    {
        $seller_id = auth()->user();
        $auctions = Auction::where('seller_id', $seller_id)->paginate(5);
        return $auctions;
    }


    public function show($id)
    {
        $auction = Auction::with([
            'car.brand',
            'car.model',
            'seller',
            'car.media',
        ])->findOrFail($id);

        return $auction;
    }

    public function approve($id)
    {
        $auction = Auction::findOrFail($id);

        $auction->update([
            'status' => 'active',
            'start_at' => now(),
            'end_at' => now()->addDay(),
        ]);

        return $auction;
    }

    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();
        return $auction;
    }


}
