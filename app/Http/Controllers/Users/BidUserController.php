<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class BidUserController extends Controller
{
    public function show($id)
     {
        $auction = Auction::with(['car', 'bids.user'])->findOrFail($id);
        return view('users.auction.bid', compact('auction'));
     }
}
