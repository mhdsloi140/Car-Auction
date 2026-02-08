<?php
namespace App\Services;

use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use Auth;

class AuctionSellerService
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
        $car = Car::with(['brand', 'model', 'auction.seller', 'media'])->findOrFail($id);

        return $car;
    }

    public function details($id)
    {
        return $id;
    }
}
