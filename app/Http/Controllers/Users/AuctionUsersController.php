<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionUsersController extends Controller
{
    

  public function show(string $id)
{
    $auction = Auction::with([
        'car.brand',
        'car.model',
        'bids.user',
    ])->findOrFail($id);
    return view('users.auction.show', compact('auction'));
}


}
