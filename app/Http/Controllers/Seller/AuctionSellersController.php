<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Car;
use App\Models\ActivityLog;
use App\Services\AuctionSellerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuctionSellersController extends Controller
{
    /**
     * قائمة المزادات للبائع
     */
    public function __construct(protected AuctionSellerService $auctionSellerService)
    {

    }
    public function index()
    {
        $auctions = Auction::where('seller_id', Auth::id())
            ->with(['car.brand', 'car.model'])
            ->latest()
            ->paginate(15);

        return view('seller.auction.index', compact('auctions'));
    }

    /**
     * عرض تفاصيل المزاد
     */
    public function show($id)
    {
        $auction = Auction::where('seller_id', Auth::id())
            ->with(['car.brand', 'car.model', 'car.media', 'bids.user'])
            ->findOrFail($id);

        return view('seller.auction.show', compact('auction'));
    }

    /**
     * عرض تفاصيل السيارة
     */
    public function details($id)
    {
        $car = Car::with(['brand', 'model', 'media'])
            ->whereHas('auction', function ($q) {
                $q->where('seller_id', Auth::id());
            })
            ->findOrFail($id);

        return view('seller.auction.details', compact('car'));
    }

    /**
     * عرض صفحة نتيجة المزاد (للمزادات المغلقة)
     */
    public function result(Auction $auction)
    {
        // التأكد أن المستخدم هو البائع
        if (Auth::id() !== $auction->seller_id) {
            abort(403, 'غير مصرح لك');
        }

        // التأكد أن المزاد في حالة مناسبة لعرض النتيجة
        if (!in_array($auction->status, ['closed', 'pending_seller', 'completed', 'rejected'])) {
            return redirect()->route('seller.auction.show', $auction->id)
                ->with('error', 'لا يمكن عرض نتيجة هذا المزاد');
        }

        $auction->load([
            'car.brand',
            'car.model',
            'car.media',
            'winner',
            'bids' => function ($q) {
                $q->latest()->limit(10);
            }
        ]);

        // التحقق مما إذا كان البائع قد قبل المزاد مسبقاً
        $accepted = ActivityLog::where('user_id', Auth::id())
            ->where('action', 'قبول سعر المزاد')
            ->where('auction_id', $auction->id)
            ->exists();

        return view('seller.auction.result', compact('auction', 'accepted'));
    }

    /**
     * قبول نتيجة المزاد
     */
    public function accept(Auction $auction)
    {
        $result = $this->auctionSellerService->accept($auction);

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }



    /**
     * رفض نتيجة المزاد
     */
    public function reject(Auction $auction)
    {
        $data = $this->auctionSellerService->reject($auction);

        if ($data) {
            return redirect()->route('auction.index', $auction->id)
                ->with('success', 'تم رفض السعر بنجاح');
        }


    }

    /**
     * عرض المزادات المعلقة بانتظار قرار البائع
     */
    public function pending()
    {
        $auctions = Auction::where('seller_id', Auth::id())
            ->where('status', 'pending_seller')
            ->with(['car.brand', 'car.model', 'winner'])
            ->latest('closed_at')
            ->paginate(15);

        return view('seller.auction.pending', compact('auctions'));
    }

    /**
     * عرض المزادات المكتملة
     */
    public function completed()
    {
        $auctions = Auction::where('seller_id', Auth::id())
            ->whereIn('status', ['completed', 'rejected'])
            ->with(['car.brand', 'car.model', 'winner'])
            ->latest('seller_decision_at')
            ->paginate(15);

        return view('seller.auction.completed', compact('auctions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // يمكن إضافة منطق إنشاء مزاد جديد هنا
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // يمكن إضافة منطق تحديث المزاد هنا
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // يمكن إضافة منطق حذف المزاد هنا
    }
}
