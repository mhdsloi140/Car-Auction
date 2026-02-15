<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use DB;
use Illuminate\Http\Request;


class AuctionUsersController extends Controller
{


public function show(string $id)
{
    $auction = Auction::with([
        'car.brand',
        'car.model',
        'bids.user',
    ])
    ->withCount([
        'bids as bidders_count' => function ($query) {
            $query->select(DB::raw('count(distinct user_id)'));
        }
    ])
    ->findOrFail($id);
    // dd($auction->car);

    return view('users.auction.show', compact('auction'));
}


}
