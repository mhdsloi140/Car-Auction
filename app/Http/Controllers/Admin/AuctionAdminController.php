<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Services\AuctionAdminService;
use Illuminate\Http\Request;

class AuctionAdminController extends Controller
{

    public function __construct(protected AuctionAdminService $auctionAdminService)
    {

    }
    public function index()
    {
        return view('admin.auction.index');
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
        $auction = $this->auctionAdminService->show($id);
        $images = $auction->car->getMedia('cars');

        return view('admin.auction.show', compact('auction','images'));

    }
    public function updatePrice(Request $request, Auction $auction)
{
    $request->validate([
        'new_price' => 'required|numeric|min:1',
    ]);

    
    if ($auction->status !== 'pending') {
        return back()->with('error', 'لا يمكن تعديل السعر بعد بدء المزاد');
    }

    $auction->starting_price = $request->new_price;
    $auction->save();

    return back()->with('success', 'تم تعديل سعر المزاد بنجاح');
}


    public function approve($id)
    {
        $auction = $this->auctionAdminService->approve($id);
        return redirect()
            ->route('auction.admin.show', $auction->id)
            ->with('success', 'تم قبول المزاد');
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

        $auction = $this->auctionAdminService->destroy($id);
        return redirect()
            ->route('admin.auction.index')
            ->with('success', 'تم حذف المزاد بنجاح');

    }
}
