<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use App\Services\AuctionAdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     public function details($id)
    {
        $car = Car::with('auction.bids.user', 'brand', 'model', 'media')
            ->findOrFail($id);





        return view('admin.auction.details', compact('car'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auction = $this->auctionAdminService->show($id);
        $images = $auction->car->getMedia('cars');

        return view('admin.auction.show', compact('auction', 'images'));

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

    public function adminArchive()
    {

       $auctions = Auction::with([
        'car:id,brand_id,model_id',
        'winner:id,name,phone'
    ])
    ->whereIn('status', ['closed', 'rejected', 'completed'])
    ->orderByDesc('end_at')
    ->paginate(10);



        return view('admin.auction.archive', compact('auctions'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function winner($id)
    {
        $user = User::find($id);
        return view('admin.auction.showwinner', compact('user'));
    }
    public function complete(Auction $auction)
    {
        $auction->update(['status' => 'completed']);
        //    $user_id = auth()->id;

        // log_activity(
        //    'مزاد مكتمل',
        //     "تم إنشاء مزاد للسيارة رقم {$auction->id} بواسطة المستخدم رقم {$user_id}"
        // );
        return back()->with('success', 'تم قبول الفائز وتغيير حالة المزاد إلى مكتمل');
    }
    //     public function reject(Auction $auction)
    // {
    //     $auction->update([
    //         'status' => 'rejected'
    //     ]);

    //     $user_id = auth()->id;

    //     log_activity(
    //         'مرفوض مزاد',
    //         "تم إنشاء مزاد للسيارة رقم {$auction->id} بواسطة المستخدم رقم {$user_id}"
    //     );

    //     return back()->with('success', 'تم رفض المزاد بنجاح');
    // }
    public function destroy(string $id)
    {

        $auction = $this->auctionAdminService->destroy($id);
        return redirect()
            ->route('admin.auction.index')
            ->with('success', 'تم حذف المزاد بنجاح');

    }
}
