<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuctionSellerService
{
    /**
     * جلب قائمة المزادات للبائع الحالي
     */
    public function index()
    {
        $sellerId = auth()->id();

        $auctions = Auction::with(['car.brand', 'car.model', 'car.media'])
            ->where('seller_id', $sellerId)
            ->paginate(5);

        return $auctions;
    }

    /**
     * عرض مزاد معين مع السيارة والبائع
     */
    public function show($auctionId)
    {
        $auction = Auction::with(['car.brand', 'car.model', 'car.media', 'seller'])
            ->findOrFail($auctionId);

        return $auction;
    }

    /**
     * قبول سعر المزاد
     */
    public function accept($auction)
    {
        // التأكد أن المستخدم هو البائع
        if (Auth::id() !== $auction->seller_id) {
            return [
                'success' => false,
                'message' => 'غير مصرح لك'
            ];
        }

        // التأكد أن المزاد في حالة pending_seller
        if ($auction->status !== 'pending_seller') {
            return [
                'success' => false,
                'message' => 'هذا المزاد ليس بانتظار قرارك'
            ];
        }

        try {
            // تحديث حالة المزاد
            $auction->update([
                'status' => 'completed',
                'seller_decision_at' => now(),
            ]);

            // تسجيل النشاط
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'قبول سعر المزاد',
                'description' => "قام البائع بقبول سعر المزاد رقم {$auction->id} بقيمة {$auction->final_price}",
                'auction_id' => $auction->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            Log::info('بائع قبل المزاد', [
                'auction_id' => $auction->id,
                'seller_id' => Auth::id()
            ]);

            return [
                'success' => true,
                'message' => 'تم قبول السعر بنجاح'
            ];

        } catch (\Exception $e) {
            Log::error('خطأ في قبول المزاد', [
                'auction_id' => $auction->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء قبول السعر'
            ];
        }
    }

    /**
     * رفض سعر المزاد
     */
    public function reject($auction)
    {
        // التأكد أن المستخدم هو البائع
        if (Auth::id() !== $auction->seller_id) {
            return [
                'success' => false,
                'message' => 'غير مصرح لك'
            ];
        }

        // التأكد أن المزاد في حالة pending_seller
        if ($auction->status !== 'pending_seller') {
            return [
                'success' => false,
                'message' => 'هذا المزاد ليس بانتظار قرارك'
            ];
        }

        try {
            // تحديث حالة المزاد
            $auction->update([
                'status' => 'rejected',
                'seller_decision_at' => now(),
            ]);

            // تسجيل النشاط
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'رفض سعر المزاد',
                'description' => "قام البائع برفض سعر المزاد رقم {$auction->id}",
                'auction_id' => $auction->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            Log::info('بائع رفض المزاد', [
                'auction_id' => $auction->id,
                'seller_id' => Auth::id(),
            ]);

            return [
                'success' => true,
                'message' => 'تم رفض السعر'
            ];

        } catch (\Exception $e) {
            Log::error('خطأ في رفض المزاد', [
                'auction_id' => $auction->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ أثناء رفض السعر'
            ];
        }
    }
}
