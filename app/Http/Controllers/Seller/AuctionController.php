<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Services\AuctionSellerService;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
       public function __construct(protected AuctionSellerService $auctionSellerService)
       {

       }
    public function index()
    {

        // $auctions=Auction::where()ions=$this->auctio

        $auctions=$this->auctionSellerService->index();
         return view('seller.auction.index',compact('auctions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $car=$this->auctionSellerService->show($id);
        return view('seller.auction.show',compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
