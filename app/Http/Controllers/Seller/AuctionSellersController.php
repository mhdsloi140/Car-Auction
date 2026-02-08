<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Car;
use App\Services\AuctionSellerService;
use Illuminate\Http\Request;

class AuctionSellersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected AuctionSellerService $auctionSellerService)
    {

    }
    public function index()
    {
        $auctions = $this->auctionSellerService->index();
        return view('seller.auction.index', compact('auctions'));
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
    public function show($id)
    {

        $car = $this->auctionSellerService->show($id);


        return view('seller.auction.show', compact('car'));
    }


public function details($id)
{
   $car = Car::findOrFail($id);

    return view('seller.auction.details',compact('car'));
}
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
